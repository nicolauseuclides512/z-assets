<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Collection;

class AssetPaymentMethod extends MasterModel
{

    protected $table = 'asset_payment_methods';

    protected $columnStatus = 'status';

    protected $columnDefault = ["*"];

    protected $columnSimple = ["*"];

    protected $showActiveOnly = true;

    public static function rules($id = null)
    {
        $uniqueQueryHandler = $id ? ',' . $id . ',id' : '';

        return [
            'name' => 'required|string|max:100|unique:asset_payment_methods,name' . $uniqueQueryHandler,
            'description' => 'nullable|string',
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
        $model->description = $req->get('description');
        $model->status = (int)$req->get('status') ?? true;
        return $model;
    }


    public function scopeFilter($q, $filterBy = "", $query = "")
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

        if (!empty($query)) {
            $data = $data->where("name", "ILIKE", "%" . $query . "%");
        }

        return $data;
    }
}