<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\AssetPaymentMethod;
use Illuminate\Http\Request;


/**
 * class UomController
 */
class AssetPaymentMethodController extends BaseController
{

    public $name = 'Asset Payment Method';

    public $statusColumn = 'status';

    public $sortBy = ['id', 'name', 'created_at', 'updated_at'];

    protected $select = ['id', 'name'];

    public function __construct(Request $request)
    {
        parent::__construct(AssetPaymentMethod::inst(), $request);
    }

}
