<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechLabelUser extends Model
{
    protected $fillable = [
        "techlable_id", "user_id", "level", "status",
    ];

}

//$table->integare('techlable_id');
//$table->integare('user_id');
//$table->integare('level')->default(6);
//$table->boolean('status')->default(1);
