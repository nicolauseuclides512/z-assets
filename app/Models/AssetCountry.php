<?php
/**
 * @author Jehan Afwazi Ahmad <jee.archer@gmail.com>.
 */

namespace App\Models;


use App\Models\Base\BaseModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AssetCountry extends MasterModel
{
    protected $table = 'asset_countries';

    protected $filterNameCfg = 'asset_country';

//    protected $with = ['provinces.sql'];

    public function provinces()
    {
        return $this->hasMany(AssetProvince::class, 'country_id');
    }

    public static function rules($id = null)
    {
        $uniqueQueryHandler = $id ? ',' . $id . ',id' : '';

        return array(
            'code' => 'nullable|string|max:5|unique:asset_countries,code' . $uniqueQueryHandler,
            'name' => 'required|string|max:100',
            'status' => 'required|boolean'
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
            $data = $data->where(function ($qu) use ($key) {
                return $qu
                    ->whereRaw("CAST(id AS TEXT) ILIKE '%$key%'")
                    ->orWhere("code", "ILIKE", "%" . $key . "%")
                    ->orWhere("name", "ILIKE", "%" . $key . "%");
            });

        }

        return $data;
    }

    public function getNestedList($q)
    {
        return $q->where('status', true)->with(
            ['provinces.sql' => function ($q) {
                return $q->with([
                    'districts' => function ($r) {
                        return $r->with('regions');
                    }]);
            }])->get();
    }

    public function getAreaById($countryId, $provinceId, $districtId, $regionId)
    {
        return [
            'country' => !$countryId ? null
                : DB::table('asset_countries')
                    ->where('id', $countryId)
                    ->select(['name'])
                    ->first(),

            'province' => !$provinceId ? null
                : DB::table('asset_provinces')
                    ->where('id', $provinceId)
                    ->select(['name'])
                    ->first(),

            'district' => !$districtId ? null
                : DB::table('asset_districts')
                    ->where('id', $districtId)
                    ->select(['name'])
                    ->first(),

            'region' => !$regionId ? null
                : DB::table('asset_regions')
                    ->where('id', $regionId)
                    ->select(['name'])
                    ->first()

        ];
    }
}