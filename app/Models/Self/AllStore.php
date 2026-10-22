<?php

namespace App\Models\Self;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class AllStore extends Model
{
    use LogsActivity;

    protected $table      = 'store';
    protected $primaryKey = 'id';

    const CREATED_AT      = 'created_at';
    const UPDATED_AT      = 'updated_at';

    public function kodepos()
    {
        return $this->hasOne(Kodepos::class, "id", "kodepos_id");
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, "id", "store_id");
    }
}
