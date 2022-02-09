<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public $name = 'User';

    public function __construct(Request $request)
    {
        parent::__construct(User::inst(), $request);
    }
}
