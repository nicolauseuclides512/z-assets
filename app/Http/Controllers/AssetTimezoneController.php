<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\AssetTimezone;
use Illuminate\Http\Request;

class AssetTimezoneController extends BaseController
{

    public $name = 'Asset Timezone';

    public $sortBy = ['id', 'created_at', 'updated_at'];

    protected $select = ['id', 'name', 'zone'];

    public function __construct(Request $request)
    {
        parent::__construct(AssetTimezone::inst(), $request);
    }
}
