<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Collection;

class AssetWeightUnit extends MasterModel
{

    protected $table = 'asset_weight_units';

    protected $columnStatus = 'status';

    protected $columnSimple = ["id", "code", "name"];

    protected $showActiveOnly = true;

    public static function rules($id = null)
    {

        $uniqueQueryHandler = $id ? ',' . $id . ',id' : '';

        return [
            'code' => 'required|string|max:5|unique:asset_weight_units,code' . $uniqueQueryHandler,
            'name' => 'required|string|max:50',
            'status' => 'required|boolean'
        ];
    }

    public static function inst()
    {
        return new self();
    }

    public function populate($request = [], BaseModel $model = null)
    {

        if (is_null($model))
            $model = self::inst();

        $req = new Collection($request);
        $model->name = $req->name;
        $model->code = $req->code;
        $model->status = $req->status ?? true;

        return $model;
    }

    public function scopeFilter($q, $filterBy = "", $key = "")
    {
        $data = $q;

        switch (true) {
            case $filterBy === self::STATUS_ACTIVE :
                $data = $data->where($this->columnStatus, "=", self::STATUS_ACTIVE);
                break;
            case $filterBy === self::STATUS_INACTIVE :
                $data = $data->where($this->columnStatus, "=", self::STATUS_INACTIVE);
                break;
        }

        if (!empty($key)) {
            $data = $data->where(function ($qu) use ($key) {
                return $qu
                    ->where("name", "ILIKE", "%" . $key . "%")
                    ->orWhere("code", "ILIKE", "%" . $key . "%");
            });

        }

        return $data;
    }

}