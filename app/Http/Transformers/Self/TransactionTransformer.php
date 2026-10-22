<?php

namespace App\Http\Transformers\Self;

use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        $transform = [];
        if ($data->pointsAddiction) {
            $transform = [
                "id" => $data->id,
                "store_id" => $data->store_id,
                "store_name" => $data->store->name,
                "transaction_number" => $data->transaction_number,
                "customer_code" => $data->customer_code,
                "customer_name" => $data->customer->name,
                "amount" => $data->amount,
                "date" => $data->date,
                "points_addiction" => $data->pointsAddiction->points_addiction
            ];
        } else {
            $transform = [
                "id" => $data->id,
                "store_id" => $data->store_id,
                "store_name" => $data->store->name,
                "transaction_number" => $data->transaction_number,
                "customer_code" => $data->customer_code,
                "customer_name" => $data->customer->name,
                "amount" => $data->amount,
                "date" => $data->date,
                "points_addiction" => 0
            ];
        }

        return $transform;
    }
}
