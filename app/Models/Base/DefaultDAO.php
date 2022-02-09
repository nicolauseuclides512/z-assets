<?php
/**
 * @author Jehan Afwazi Ahmad <jee.archer@gmail.com>.
 */

namespace App\Models\Base;


use App\Exceptions\AppException;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait DefaultDAO
{
    public function listAll($select = [], $status = null)
    {
        Log::info("list {$this->table}");
        $q = DB::table($this->table);

        if (!is_null($status))
            $q = $q->where("status", $status);

        return $q->select($select ?: "*")->get();
    }

    /**
     * @param $request
     * @return mixed
     * @throws Exception
     */
    public function storeExec($request)
    {
        DB::beginTransaction();
        try {
            $data = $this->populate($request);
            if (!$data->save()) {
                DB::rollback();
            }
            DB::commit();
            return $data;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * @param $request
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function updateExec($request, $id)
    {
        DB::beginTransaction();
        try {
            $dataInId = $this->getByIdRef($id)->firstOrFail();
            $data = $this->populate($request, $dataInId);
            if (!$data->save()) {
                DB::rollback();
            }
            DB::commit();
            return $data;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function destroyExec($id)
    {
        DB::beginTransaction();
        try {
            $dataInId = $this
                ->getByIdRef($id)
                ->firstOrFail();

            if (!$dataInId->delete()) {
                DB::rollback();
                return false;
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * @param $ids string (1,2,3)
     * @return bool
     * @throws Exception
     */
    public function destroySomeExec(string $ids): bool
    {
        try {
            array_map(function ($id) {
                $dataInId = $this->getByIdRef($id)->firstOrFail();

                if (!$dataInId->delete()) {
                    throw AppException::inst(
                        "The data of id $dataInId->id can not be deleted ",
                        Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                return true;
            }, explode(',',
                preg_replace('/\s+/', '', $ids)
            ));

            return true;

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function markAsExec($ids, $status)
    {
        // TODO: Implement markAsExec() method.
    }
}