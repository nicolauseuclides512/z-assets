<?php
/**
 * @author Jehan Afwazi Ahmad <jee.archer@gmail.com>.
 */

namespace App\Models;


use App\Models\Base\BaseModel;
use Illuminate\Support\Collection;

class AssetCurrency extends MasterModel
{
    protected $table = 'asset_currencies';

    protected $filterNameCfg = 'asset_currency';

    public static function rules($id = null)
    {
        $uniqueQueryHandler = $id ? ',' . $id . ',id' : '';

        return [
            'code' => 'required|string|max:3|unique:asset_currencies,code' . $uniqueQueryHandler,
            'symbol' => 'required|string|max:10',
            'name' => 'required|string|max:100',
            'iso_2' => 'string|max:2',
            'iso_3' => 'string|max:3',
            'status' => 'boolean'
        ];
    }

    public static function inst()
    {
        return new self();
    }

    public function populate($request, BaseModel $model = null)
    {
        $req = new Collection($request);

        if (is_null($model)) {
            $model = self::inst();
        }

        $model->code = $req->get('code');
        $model->symbol = $req->get('symbol');
        $model->name = $req->get('name');
        $model->iso_2 = $req->get('iso_2');
        $model->iso_3 = $req->get('iso_3');
        $model->status = $req->get('status') ?? true;

        return $model;
    }

    public function scopeFilter($q, $filterBy = "", $key = "")
    {
        $data = $q;

        switch (true) {
            case $filterBy === self::STATUS_INACTIVE:
                $data = $data->where("status", false);
                break;
            case $filterBy === self::STATUS_ACTIVE:
                $data = $data->where("status", true);
                break;
        }

        if (!empty($key)) {
            $data = $data
                ->where(function ($qu) use ($key) {
                    return $qu
                        ->where("name", "ILIKE", "%" . $key . "%")
                        ->orWhereRaw("CAST(id AS TEXT) ILIKE '%$key%'")
                        ->orWhere("code", "ILIKE", "%" . $key . "%")
                        ->orWhere("symbol", "ILIKE", "%" . $key . "%");
                });
        }

        return $data;
    }
}