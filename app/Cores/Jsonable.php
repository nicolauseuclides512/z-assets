<?php
/**
 * @author Jehan Afwazi Ahmad <jee.archer@gmail.com>.
 */


namespace App\Cores;


use App\Exceptions\AppException;
use Illuminate\Http\Response;

trait Jsonable
{
    protected function json($code = 400, $message = '', $data = null)
    {

        if (!is_null($data)) {
            if (method_exists($data, 'items')) {

                $previousPageUrl = (!empty($data->previousPageUrl())) ?
                    $data->previousPageUrl() . $this->requestMod()['query'] :
                    $data->previousPageUrl();

                $nextPageUrl = (!empty($data->nextPageUrl())) ?
                    $data->nextPageUrl() . $this->requestMod()['query'] :
                    $data->nextPageUrl();


                $currentPageUrl = (!empty($data->url($data->currentPage()))) ?
                    $data->url($data->currentPage()) . $this->requestMod()['query'] :
                    $data->url($data->currentPage());


                $paginate = array(
                    'has_more_pages' => $data->hasMorePages(),
                    'count' => (int)$data->count(),
                    'total' => (int)$data->total(),
                    'per_page' => (int)$data->perPage(),
                    'current_page' => (int)$data->currentPage(),
                    'last_page' => (int)$data->lastPage(),
                    'prev_page_url' => $previousPageUrl,
                    'current_page_url' => $currentPageUrl,
                    'next_page_url' => $nextPageUrl
                );

                return response()->json(
                    array(
                        "code" => $code,
                        "message" => $message,
                        "data" => $data->items(),
                        "paginate" => $paginate
                    ), 200, [], JSON_NUMERIC_CHECK
                );
            }

            return response()->json(
                array(
                    "code" => $code,
                    "message" => $message,
                    "data" => $data
                ), 200, [], JSON_NUMERIC_CHECK
            );
        }
        return response()->json(
            array(
                "code" => $code,
                "message" => $message
            ), 200, [], JSON_NUMERIC_CHECK
        );
    }

    /**@deprecated
     * @param $data
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonErrors($data, $code = Response::HTTP_BAD_REQUEST, $message = '')
    {
        switch (true) {
            case ($data instanceof AppException) :
                return $this->json($data->getCode(), $data->getMessage(), $data->getCause());
                break;
            case ($data instanceof \Exception) :
                return $this->json($data->getCode(), $data->getMessage());
                break;
        }

        return $this->json($code, $message, $data);
    }

    public function jsonExceptions($exception,
                                   $code = Response::HTTP_BAD_REQUEST,
                                   $message = ''
    ){
        switch (true) {
            case ($exception instanceof AppException) :
                return $this->json($exception->getCode(),
                    $exception->getMessage(),
                    $exception->getCause());
                break;
            case ($exception instanceof \Exception) :
                return $this->json(Response::HTTP_INTERNAL_SERVER_ERROR,
                    $exception->getMessage());
                break;
        }

        return $this->json($code, $message, $exception);
    }
}
