<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\AssetCarrier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * class AssetCarrierController
 */
class AssetCarrierController extends BaseController
{

    public $name = 'Asset Carrier';

    public $statusColumn = 'status';

    public $sortBy = ['id', 'name', 'created_at', 'updated_at'];

    protected $select = [
        'id',
        'name',
        'code',
        'logo',
        'is_shipping_cost_on',
        'is_track_shipment_on',
        'priority',
        'is_default',
        'status'
    ];

    public function __construct(Request $request)
    {
        parent::__construct(AssetCarrier::inst(), $request);
    }

    public function ongkirList()
    {
        $result = $this
            ->model
            ->ongkirList($this->select)
            ->toArray();

        foreach ($result as &$data) {
            $data->is_shipping_cost_on = (int)$data->is_shipping_cost_on;
            $data->is_track_shipment_on = (int)$data->is_track_shipment_on;
            $data->is_default = (int)$data->is_default;

            $strUrlNoExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $data->logo);
            $ext = pathinfo($data->logo, PATHINFO_EXTENSION);
            $data->image = [
                'small' => "{$strUrlNoExt}_small.{$ext}",
                'medium' => "{$strUrlNoExt}_medium.{$ext}",
                'thumb' => "{$strUrlNoExt}_thumb.{$ext}",
                'big' => "{$strUrlNoExt}_big.{$ext}"];
        }

        return $this
            ->json(
                Response::HTTP_OK,
                "Fetch $this->name",
                $result
            );
    }

    public function ongkirLogoByCode($code)
    {
        return $this
            ->json(
                Response::HTTP_OK,
                "Fetch $this->name",
                $this->model->getByCode($code, ['select' => 'logo'])
            );
    }

    public function getByCode($code)
    {
        return $this
            ->json(
                Response::HTTP_OK,
                "Fetch $this->name",
                $this->model->getByCode($code)
            );
    }

}
