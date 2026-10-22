<?php

namespace App\Models\Self;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaction extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table      = 'transaction';
    protected $primaryKey = 'id';

    const CREATED_AT      = 'created_at';
    const UPDATED_AT      = 'updated_at';
    const DELETED_AT      = 'deleted_at';

    public function customer()
    {
        return $this->hasOne(Customer::class, "code", "customer_code");
    }
    public function store()
    {
        return $this->hasOne(AllStore::class, "id", "store_id");
    }
    public function pointsAddiction()
    {
        return $this->hasOne(PointsAddiction::class, "id", "transaction_id");
    }
}
