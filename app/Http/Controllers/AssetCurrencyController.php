<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\AssetCurrency;
use Illuminate\Http\Request;

class AssetCurrencyController extends BaseController
{
    public $name = 'Asset Currency';

    public $statusColumn = 'status';

    public $sortBy = ['id', 'name', 'created_at', 'updated_at'];

    protected $select = ['id', 'name', 'code'];

    public function __construct(Request $request)
    {
        parent::__construct(AssetCurrency::inst(), $request);
    }

}
