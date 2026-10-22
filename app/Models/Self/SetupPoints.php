<?php

namespace App\Models\Self;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class SetupPoints extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table      = 'setup_points';
    protected $primaryKey = 'id';

    const CREATED_AT      = 'created_at';
    const UPDATED_AT      = 'updated_at';
    const DELETED_AT      = 'deleted_at';
}
