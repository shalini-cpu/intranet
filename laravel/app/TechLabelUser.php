<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechLabelUser extends Model
{
    protected $fillable = [
        "tech_label_id", "user_id", "level", "status",
    ];

    public function tech_label()
    {
        return $this->belongsTo(Techlabel::class,'tech_label_id','id')->select(['id','name']);
    }

    public function scopeTech_label_name($query)
    {
        return
            $this->
            join('tech_labels', 'tech_labels.id', '=', 'tech_label_users.tech_label_id')->
            addSelect(['tech_labels.id', 'tech_labels.name']);
    }

}
