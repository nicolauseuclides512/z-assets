<?php
/**
 * @author Jehan Afwazi Ahmad <jee.archer@gmail.com>.
 */

namespace App\Models;


use App\Models\Base\BaseModel;
use Illuminate\Support\Collection;

class AssetLanguage extends MasterModel
{
    protected $table = 'asset_languages';

    protected $filterNameCfg = 'asset_language';

    public static function rules($id = null)
    {
        $uniqueQueryHandler = $id ? ',' . $id . ',id' : '';

        return array(
            'code' => 'required|string|max:50|unique:asset_languages,code' . $uniqueQueryHandler,
            'name' => 'required|string|max:100',
            'status' => 'boolean'
        );
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
        $model->name = $req->get('name');
        $model->status = $req->get('status');

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
            $data = $data->where(function ($qu) use ($key) {
                return $qu
                    ->where("name", "ILIKE", "%" . $key . "%")
                    ->orWhereRaw("CAST(id AS TEXT) ILIKE '%$key%'")
                    ->orWhere("code", "ILIKE", "%" . $key . "%");
            });

        }

        return $data;
    }
}