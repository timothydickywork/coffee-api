<?php

namespace App\Models\Self;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Kodepos extends Model
{
    use LogsActivity;

    protected $table      = 'kodepos';
    protected $primaryKey = 'id';
}
