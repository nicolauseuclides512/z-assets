<?php
/**
 * @author Jehan Afwazi Ahmad <jee.archer@gmail.com>.
 */


use  Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class CustomBlueprint extends Blueprint
{
    private static $myObj;

    public function __construct($table, $callback)
    {
        parent::__construct($table, $callback);
    }

    public static function inst()
    {
        $schema = DB::getSchemaBuilder();

        $schema->blueprintResolver(function ($table, $callback) {
            return self::$myObj = new CustomBlueprint($table, $callback);
        });

        return $schema;
    }

    public function defaultColumn()
    {
        self::$myObj->timestamp('created_at')->nullable();
        self::$myObj->string('created_by')->nullable();
        self::$myObj->timestamp('updated_at')->nullable();
        self::$myObj->string('updated_by')->nullable();
        self::$myObj->timestamp('deleted_at')->nullable();
        self::$myObj->string('deleted_by')->nullable();
    }

    public function defaultColumnForeign()
    {
        self::$myObj->foreign('created_by')->references('user_id')->on('users');
        self::$myObj->foreign('updated_by')->references('user_id')->on('users');
        self::$myObj->foreign('deleted_by')->references('user_id')->on('users');
    }
}