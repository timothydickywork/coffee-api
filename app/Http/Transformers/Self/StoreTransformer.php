<?php

namespace App\Http\Transformers\Self;

use League\Fractal\TransformerAbstract;

class StoreTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        $address = "";
        if ($data->kodepos) {
            $address = $data->address .
                " " . $data->kodepos->kelurahan .
                " " . $data->kodepos->kecamatan .
                " " . $data->kodepos->kabupaten .
                " " . $data->kodepos->provinsi;
        } else {
            $address = $data->address;
        }

        $transform = [
            "id" => $data->id,
            "name" => $data->name,
            "address" => $address,
            "latitude" => $data->latitude,
            "longitude" => $data->longitude,
            "phone" => $data->phone
        ];

        return $transform;
    }
}
