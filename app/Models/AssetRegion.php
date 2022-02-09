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
use Models\Contracts\AssetRegionContract;
use Models\Contracts\AssetRegionContracts;

class AssetRegion extends MasterModel
{
    protected $table = 'asset_regions';

    protected $appends = ['full_name'];

    protected $filterNameCfg = 'asset_region';

    public function district()
    {
        return $this->belongsTo(AssetDistrict::class, 'district_id');
    }

    public function getFullNameAttribute()
    {
        $district = $this->district()->first();
        return ($district) ? $this->name . ', ' . $district->name : '';
    }

    public static function rules($id = null)
    {
        return [
            'district_id' => 'required|integer|exists:asset_districts,id',
            'name' => 'required|string|max:100',
            'status' => 'boolean',
            'zip' => 'nullable|string',
            'type' => 'nullable|string|in:subdistrict',
            'is_priority' => 'boolean',
            'lion_parcel_id' => 'nullable|integer|exists:asset_lion_parcels,id'
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

        $model->name = $req->get('name');
        $model->district_id = $req->get('district_id');
        $model->type = $req->get('type') ?? 'subdistrict';
        $model->zip = strtolower($req->get('zip'));
        $model->status = $req->get('status') ?? true;
        $model->is_priority = $req->get('is_priority');
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
            $data = $data
                ->where(function ($qu) use ($key) {
                    return $qu
                        ->where("name", "ILIKE", "%" . strtolower($key) . "%")
                        ->orWhereRaw("CAST(id AS TEXT) ILIKE '%$key%'");
                });
        }

        return $data;
    }

    public function getByDistrict($id)
    {
        return (!is_null($id)) ? $this->where('district_id', $id)->get() : null;
    }

    public function ongkirList($select = [], $status = true)
    {
        Log::info("ongkir list {$this->table}");

        return DB::table($this->table)
            ->join(
                "asset_districts",
                "district_id",
                "=",
                "asset_districts.id")
            ->select(
                "asset_regions.id",
                "asset_regions.name",
                "asset_regions.district_id",
                DB::raw("CONCAT(asset_regions.name,', ',asset_districts.name) AS full_name")
            )
            ->where('asset_regions.status', $status)
            ->get();
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

            $result = DB::table("asset_regions AS ar")
                ->select("ar.id as subdistrict_id",
                    "ar.name AS subdistrict_name",
                    "ar.type AS type",
                    "ad.id AS city_id",
                    "ad.name AS city_name",
                    "ap.id AS province_id",
                    "ap.name AS province")
                ->leftJoin(
                    "asset_districts AS ad",
                    "ad.id",
                    "=",
                    "ar.district_id")
                ->join(
                    "asset_provinces AS ap",
                    "ap.id",
                    "=",
                    "ad.province_id")
                ->where("ar.id", "=", $id)
                ->first();

            return $result;

        } catch (\Exception $e) {
            throw $e;
        }
    }
}