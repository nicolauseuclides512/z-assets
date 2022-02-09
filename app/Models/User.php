<?php

namespace App\Models;

use App\Exceptions\AppException;
use App\Mail\VerificationUserMail;
use App\Models\Base\BaseModel;
use App\Utils\DateTimeUtil;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Response as CODE;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\HasApiTokens;

class User extends MasterModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    use HasApiTokens, Notifiable;

    protected $fillable = [
        'username', 'email', 'password', 'full_name', 'nickname', 'gender', 'status', 'country_id', 'timezone_id', 'photo', 'verification_code'
    ];

    protected $hidden = [
        'password', 'remember_token', 'token', 'invitation_code', 'reset_code'
    ];

}
