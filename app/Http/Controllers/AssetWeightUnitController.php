<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\AssetWeightUnit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


/**
 * class AssetWeightUnitController
 */
class AssetWeightUnitController extends BaseController
{

    protected $name = 'Asset Weight Unit';

    protected $statusColumn = 'status';

    protected $sortBy = ['id', 'name', 'created_at', 'updated_at'];

    protected $select = ['id', 'code', 'name'];

    public function __construct(Request $request)
    {
        parent::__construct(AssetWeightUnit::inst(), $request);
    }

    public function getByCode($code)
    {
        return $this->json(Response::HTTP_OK,
            "get $this->name by code",
            $this->model->where('code', $code)->where('status', true)->select($this->select)->get()
        );
    }
}
