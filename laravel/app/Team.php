<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        "user_id", "project_id", "tech_label_id", "status",
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id');
    }

    public function user_details()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
