<?php

namespace App\Http\Transformers\Self;

use League\Fractal\TransformerAbstract;

class SetupPointsTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        $transform = [
            "id" => $data->id,
            "min_transaction" => $data->min_transaction,
            "start_date" => $data->start_date,
            "expiration_day" => $data->expiration_day,
        ];

        return $transform;
    }
}
