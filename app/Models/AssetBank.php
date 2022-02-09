<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Collection;

class AssetBank extends MasterModel
{

    protected $table = 'asset_banks';

    protected $columnStatus = 'status';

    protected $columnDefault = ["*"];

    protected $columnSimple = ["id", "name", "logo"];

    protected $showActiveOnly = true;

    public static function rules($id = null)
    {
        $uniqueQueryHandler = $id ? ',' . $id . ',id' : '';

        return [
            'name' => 'required|string|max:100|unique:asset_banks,name' . $uniqueQueryHandler,
            'logo' => 'string',
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
        $model->name = $req->get('name');
        $model->logo = $req->get('logo');
        $model->status = (int)$req->get('status') ?? true;

        return $model;
    }

    public function scopeFilter($q, $filterBy = "", $key = "")
    {
        $data = $q;

        switch (true) {
            case $filterBy === self::STATUS_ACTIVE :
                $data->where($this->columnStatus, "=", self::STATUS_ACTIVE);
                break;
            case $filterBy === self::STATUS_INACTIVE :
                $data->where($this->columnStatus, "=", self::STATUS_INACTIVE);
                break;
        }

        if (!empty($key)) {
            $data = $data->where(function ($qu) use ($key) {
                return $qu->where("name", "ILIKE", "%" . $key . "%");
            });

        }

        return $data;
    }

    public function scopeGetByName($q, $name)
    {
        return $q->where('name', 'ilike', $name)->first() ?? null;
    }
}