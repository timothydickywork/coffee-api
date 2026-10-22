<?php

namespace App\Http\Transformers\Self;

use League\Fractal\TransformerAbstract;

class CustomerTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        $transform = [
            "code" => $data->code,
            "name" => $data->name,
            "email" => $data->email,
            "uid" => $data->uid,
        ];

        return $transform;
    }
}
