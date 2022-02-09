<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\AssetProvince;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class AssetProvinceController extends BaseController
{
    public $name = 'Asset Province';

    public $sortBy = array('id', 'name', 'created_at', 'updated_at');

    protected $select = ['id', 'name', 'country_id'];

    public function __construct(Request $request)
    {
        parent::__construct(AssetProvince::inst(), $request);
    }

    public function getByCountry($id)
    {
        return $this->json(
            Response::HTTP_ACCEPTED,
            'provinces.sql fetched.',
            $this->model->getByCountry($id));
    }

    //ONGKIR -->
    protected function ongkirList()
    {
        try {
            if ($this->request->get('type') == 'file') {
                $countryJson = Storage::disk('local')
                    ->get('json/provinces.sql.json');

                return $this->json(
                    Response::HTTP_OK,
                    "Fetch $this->name",
                    json_decode($countryJson, true)
                );
            }

            return $this
                ->json(
                    Response::HTTP_OK,
                    "Fetch $this->name",
                    $this->model->listAll(
                        $this->select,
                        $this->request->get('status') ?? true
                    )
                );

        } catch (\Exception $e) {
            return $this->jsonExceptions($e);
        }
    }

}
