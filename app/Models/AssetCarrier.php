<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssetCarrier extends MasterModel
{
    protected $table = 'asset_carriers';

    protected $columnStatus = 'status';

    protected $columnDefault = ["*"];

    protected $columnSimple = ["*"];

    protected $showActiveOnly = false;

    protected $appends = ['image'];

    public function getImageAttribute()
    {
        $strUrlNoExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->logo);
        $ext = pathinfo($this->logo, PATHINFO_EXTENSION);
        return [
            'big' => "{$strUrlNoExt}_big.{$ext}",
            'medium' => "{$strUrlNoExt}_medium.{$ext}",
            'small' => "{$strUrlNoExt}_small.{$ext}",
            'thumb' => "{$strUrlNoExt}_thumb.{$ext}"
        ];
    }

    public static function rules($id = null)
    {
        $uniqueQueryHandler = $id ? ',' . $id . ',id' : '';

        return [
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|unique:asset_carriers,code' . $uniqueQueryHandler,
            'logo' => 'nullable|string',
            'priority' => 'integer',
            'is_track_shipment_on' => 'boolean',
            'is_shipping_cost_on' => 'boolean',
            'is_default' => 'boolean',
            'status' => 'boolean'
        ];
    }

    public function populate($request = [], BaseModel $model = null)
    {

        if (is_null($model))
            $model = self::inst();

        $req = new Collection($request);
        $model->name = $req->get("name");
        $model->logo = $req->get("logo");
        $model->code = $req->get("code");
        $model->priority = $req->get('priority');
        $model->is_track_shipment_on = $req->get('is_track_shipment_on');
        $model->is_shipping_cost_on = $req->get('is_shipping_cost_on');
        $model->is_default = $req->get('is_default');
        $model->status = $req->get("status") ?? true;

        return $model;
    }

    public function scopeGetByCode($q, $code, $options = [])
    {
        return $q
            ->select($options['select'] ?: "*")
            ->where('code', 'ILIKE', $code)
            ->firstOrFail();
    }

    public static function inst()
    {
        return new self();
    }

    public function scopeFilter($q, $filterBy = "", $key = "")
    {
        $data = $q;

        switch (true) {
            case $filterBy === self::STATUS_ACTIVE :
                $data->where('status', "=", self::STATUS_ACTIVE);
                break;
            case $filterBy === self::STATUS_INACTIVE :
                $data->where('status', "=", self::STATUS_INACTIVE);
                break;
        }

        if (!empty($key)) {
            $data = $data->where(function ($qu) use ($key) {
                return $qu
                    ->where("code", "ILIKE", "%$key%")
                    ->orWhere("name", "ILIKE", "%$key%");
            });
        }

        return $data;
    }

    //list for ongkir
    public function ongkirList($select = [], $status = true)
    {
        Log::info("Carrier Ongkir Request List");

        return DB::table($this->table)
            ->where('status', $status)
            ->orderBy("priority")
            ->get($select ?? "");
    }

}