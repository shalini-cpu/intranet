<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Techlabel extends Model
{
    protected $table = 'tech_labels';
    protected $fillable = ['name', 'status'];

}