<?php

namespace App\Models\Self;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class CustomerFirebaseToken extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table      = 'customer_firebase_token';
    protected $primaryKey = 'id';

    const CREATED_AT      = 'created_at';
    const UPDATED_AT      = 'updated_at';
    const DELETED_AT      = 'deleted_at';

    public function Customer()
    {
        return $this->hasOne(Customer::class, "customer_code", "code");
    }
}
