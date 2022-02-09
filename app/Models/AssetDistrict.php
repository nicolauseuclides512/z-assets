<?php
/**
 * @author Jehan Afwazi Ahmad <jee.archer@gmail.com>.
 */

namespace App\Models;


use App\Models\Base\BaseModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Models\Contracts\AssetDistrictContract;

class AssetDistrict extends MasterModel
{
    protected $table = 'asset_districts';

    protected $filterNameCfg = 'asset_district';

    protected $appends = [
        'full_name',
        'priority_region'
    ];

    public function regions()
    {
        return $this->hasMany(AssetRegion::class, 'district_id');
    }

    public function province()
    {
        return $this->belongsTo(AssetProvince::class, 'province_id');
    }

    public function getFullNameAttribute()
    {
        $province = $this->province()->first();
        return ($province) ? $this->name . ', ' . $province->name : '';
    }

    public function getPriorityRegionAttribute()
    {
        return $this->regions()
            ->where('is_priority', true)
            ->select('id', 'name', 'district_id')
            ->first();
    }

    public static function rules($id = null)
    {
        return [
            'province_id' => 'required|integer|exists:asset_provinces,id',
            'name' => 'required|string|max:100',
            'zip' => 'string',
            'type' => 'string|in:city',
            'status' => 'boolean',
            'lion_parcel_id' => 'nullable|integer'
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

        $model->province_id = $req->get('province_id');
        $model->name = $req->get('name');
        $model->type = strtolower($req->get('type')) ?: 'city';
        $model->zip = $req->get('zip');
        $model->status = $req->get('status') ?? true;
        $model->lion_parcel_id = $req->get('lion_parcel_id');

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
                    ->orWhereRaw("CAST(id AS TEXT) ILIKE '%$key%'");
            });

        }

        return $data;
    }

    public function getByProvince($id)
    {
        return (!is_null($id)) ? $this->where('province_id', $id)->get() : null;
    }

    public function ongkirList($select = [], $status = true)
    {
        Log::info("ongkir list {$this->table}");

        $districtResult = DB::table($this->table . ' AS ad')
            ->join(
                "asset_provinces as ap",
                "province_id",
                "=",
                "ap.id")
            ->leftJoin(
                DB::raw("(SELECT ar.id, ar.name, ar.district_id FROM asset_regions ar WHERE is_priority=true) priority_region"),
                function ($join) {
                    $join->on('ad.id', '=', 'priority_region.district_id');
                }
            )
            ->select(
                "ad.id as id",
                "ad.name as name",
                "ap.id as province_id",
                "ap.name as province_name",
                DB::raw("CONCAT(ad.name,', ',ap.name) AS full_name"),
                "priority_region.id as priority_region_id",
                "priority_region.name as priority_region_name"
            )
            ->where('ad.status', $status)
            ->get();

        return $districtResult->map(function ($obj) {
            $obj->priority_region = is_null($obj->priority_region_id)
                ? null
                : (object)[
                    "id" => $obj->priority_region_id,
                    "name" => $obj->priority_region_name,
                    "full_name" => $obj->name . ", " . $obj->priority_region_name
                ];

            unset($obj->priority_region_id);
            unset($obj->priority_region_name);

            return $obj;
        });

    }

    /**
     * @param $id
     * @return mixed|string
     * @throws \Exception
     */
    public function ongkirDetail($id)
    {
        try {
            Log::info("ongkir detail {$this->table}");

            $result = DB::table($this->table . " AS ad")
                ->leftJoin(
                    "asset_provinces AS ap",
                    "ap.id",
                    "=",
                    "ad.province_id")
                ->select(
                    "ad.id AS city_id",
                    "ad.name AS city_name",
                    "ad.type AS type",
                    "ad.zip AS postal_code",
                    "ap.id AS province_id",
                    "ap.name AS province")
                ->where("ad.id", "=", $id)
                ->first();

            return $result;

        } catch (\Exception $e) {
            throw $e;
        }
    }
}