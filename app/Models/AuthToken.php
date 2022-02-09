<?php
/**
 * @author Jehan Afwazi Ahmad <jee.archer@gmail.com>.
 */


namespace App\Models;


use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Passport;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;

class AuthToken
{
    protected $id;

    protected $username;

    protected $fullName;

    protected $email;

    protected $organizationId;

    protected $organizationName;

    protected $organizationPortal;

    protected $organizationLogo;

    protected $expired;

    protected static $scopes;

    public static $info;

    public function __construct()
    {
        $this->publicKey = file_get_contents(Passport::keyPath('oauth-public.key'));
        $this->secretKey = file_get_contents(Passport::keyPath('oauth-private.key'));
    }

    public static function inst()
    {
        return new self();
    }

    public function verify($token)
    {
        try {
            $tokenData = (new Parser())->parse($token);

            if ($tokenData->verify(new Sha256(), $this->secretKey) && $tokenData->validate(new ValidationData())) {

                $response = JWT::decode($token, $this->secretKey, [$tokenData->getHeader('alg')]);
                Log::info('verify ' . json_encode($response));
                $this->id = $response->data->userId;
                $this->username = $response->data->username;
                $this->email = $response->data->email;
                $this->fullName = $response->data->fullName;

                if (isset($response->data->organizationId)) {
                    $this->organizationId = $response->data->organizationId;
                    $this->organizationName = $response->data->organizationName;
                    $this->organizationPortal = $response->data->organizationPortal;
                    $this->organizationLogo = $response->data->organizationLogo;
                }

                self::$scopes = $response->scopes;

                self::$info = $response->data;

                return true;
            }

            return false;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getOrganizationId()
    {
        return $this->organizationId;
    }

    /**
     * @param mixed $organizationId
     */
    public function setOrganizationId($organizationId)
    {
        $this->organizationId = $organizationId;
    }

    /**
     * @return mixed
     */
    public function getOrganizationName()
    {
        return $this->organizationName;
    }

    /**
     * @param mixed $organizationName
     */
    public function setOrganizationName($organizationName)
    {
        $this->organizationName = $organizationName;
    }

    /**
     * @return mixed
     */
    public function getOrganizationPortal()
    {
        return $this->organizationPortal;
    }

    /**
     * @param mixed $organizationPortal
     */
    public function setOrganizationPortal($organizationPortal)
    {
        $this->organizationPortal = $organizationPortal;
    }

    /**
     * @return mixed
     */
    public function getOrganizationLogo()
    {
        return $this->organizationLogo;
    }

    /**
     * @param mixed $organizationLogo
     */
    public function setOrganizationLogo($organizationLogo)
    {
        $this->organizationLogo = $organizationLogo;
    }

    /**
     * @return mixed
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * @param mixed $expired
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;
    }

    /**
     * @return mixed
     */
    public static function getScopes()
    {
        return self::$scopes;
    }

    /**
     * @return mixed
     */
    public static function info()
    {
        return self::$info;
    }

}