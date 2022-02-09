<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Collection;
use Validator;

class AssetTimezone extends MasterModel
{
    protected $table = 'asset_timezones';

    protected $filterNameCfg = 'asset_timezone';

    public static function rules($id = null)
    {
        $uniqueQueryHandler = $id ? ',' . $id . ',id' : '';

        return [
            'name' => 'required|string|max:100|unique:asset_timezones,name' . $uniqueQueryHandler,
            'zone' => 'required|numeric',
            'status' => 'boolean'
        ];
    }

    public function populate($request = array(), BaseModel $model = null)
    {

        if (is_null($model))
            $model = self::inst();

        $req = new Collection($request);

        $model->name = $req->get('name');
        $model->zone = $req->get('zone');
        $model->status = true;
        return $model;
    }

    public static function inst()
    {
        return new self();
    }

    public function scopeFilter($q, $filterBy = "", $query = "")
    {
        $data = $q;

        switch ($filterBy) {
            case self::STATUS_INACTIVE:
                $data = $data->where("status", false);
                break;
            case self::STATUS_ACTIVE:
                $data = $data->where("status", true);
                break;
        }

        if (!empty($query)) {
            $data = $data
                ->where("name", "ILIKE", "%" . $query . "%")
                ->orWhereRaw("CAST(id AS TEXT) ILIKE '%$query%'");
        }

        return $data;
    }
}