<?php

namespace App\Models\Self;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Customer extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table      = 'customer';
    protected $primaryKey = 'code';

    const CREATED_AT      = 'created_at';
    const UPDATED_AT      = 'updated_at';
    const DELETED_AT      = 'deleted_at';

    protected $fillable = [
        'name', 'email',
    ];

    protected $hidden = [
        'password',
    ];

    public function tokens()
    {
        return $this->hasMany(CustomerFirebaseToken::class, "code", "customer_code");
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, "code", "customer_code");
    }
}
