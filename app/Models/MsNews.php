<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsNews extends Model
{

    use SoftDeletes;

    protected $guarded = [];
}
