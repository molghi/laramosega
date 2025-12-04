<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visited extends Model
{
    protected $table = "visited";

    protected $fillable = [
        "title_id",
        "type",
        "user_id"
    ];
}
