<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\LpCostRouteRequest;
use App\Models\AssetLionParcel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssetLionParcelController extends BaseController
{
    public $name = 'Asset Lion Parcel';

    public $statusColumn = 'status';

    public $sortBy = ['id', 'name', 'created_at', 'updated_at'];

    protected $select = ['id', 'name'];

    public function __construct(Request $request)
    {
        parent::__construct(AssetLionParcel::inst(), $request);
    }

    public function ongkirCostRoute(LpCostRouteRequest $request)
    {
        return $this->json(
            Response::HTTP_OK,
            "get lion parcel cost routes",
            $this->model->ongkirCostRoute(
                $request->get('area_id'),
                $request->get('type')
            )
        );
    }
}
