<?php

namespace App\Models\Self;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Store extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table      = 'store';
    protected $primaryKey = 'id';

    const CREATED_AT      = 'created_at';
    const UPDATED_AT      = 'updated_at';
    const DELETED_AT      = 'deleted_at';

    public function kodepos()
    {
        return $this->hasOne(Kodepos::class, "id", "kodepos_id");
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, "id", "store_id");
    }
}
