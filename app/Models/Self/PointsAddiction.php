<?php

namespace App\Models\Self;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PointsAddiction extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table      = 'points_addiction';
    protected $primaryKey = 'id';

    const CREATED_AT      = 'created_at';
    const UPDATED_AT      = 'updated_at';
    const DELETED_AT      = 'deleted_at';

    public function transaction()
    {
        return $this->hasOne(Transaction::class, "transaction_id", "id");
    }
    public function customer()
    {
        return $this->hasOne(Customer::class, "customer_code", "code");
    }
}
