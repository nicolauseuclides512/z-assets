<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\AssetLanguage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssetLanguageController extends BaseController
{
    public $name = 'Asset Language';

    public $sortBy = ['id', 'name', 'created_at', 'updated_at'];

    protected $select = ['id', 'name', 'status'];

    public function __construct(Request $request)
    {
        parent::__construct(AssetLanguage::inst(), $request);
    }

    protected function list()
    {
        $list = $this->model->listAll($this->select, true ?: []);
        return $this
            ->json(Response::HTTP_OK,
                "Fetch $this->name",
                $list
            );
    }
}
