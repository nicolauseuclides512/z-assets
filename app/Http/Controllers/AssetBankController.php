<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\AssetBank;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


/**
 * class AssetBankController
 */
class AssetBankController extends BaseController
{

    public $name = 'Asset Bank';

    public $statusColumn = 'status';

    public $sortBy = ['id', 'name', 'created_at', 'updated_at'];

    protected $select = ['id', 'name', 'full_name', 'status', 'logo'];

    public function __construct(Request $request)
    {
        parent::__construct(AssetBank::inst(), $request);
    }

    protected function list()
    {
        $request = $this->request;

        switch ($request->get('filter')) {
            case 'all':
                $list = $this->model->listAll($this->select);
                break;
            case 'false':
                $list = $this->model->listAll($this->select, false);
                break;
            default:
                $list = $this->model->listAll($this->select, true);
                break;
        }

//        $list = $this->model->listAll($this->select, true ?: []);
        return $this
            ->json(Response::HTTP_OK,
                "Fetch $this->name",
                $list
            );
    }

    public function getByName($bankName)
    {
        return $this
            ->json(Response::HTTP_OK,
                "Fetch $this->name",
                $this->model->getByName($bankName)
            );
    }
}
