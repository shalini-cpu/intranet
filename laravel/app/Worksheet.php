<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worksheet extends Model
{
    protected $table = 'worksheets';

    protected $fillable = [
        'title', 'desc', 'hours_spend', 'date', 'task_type', 'stack', 'user_id', 'project_id', 'priority', 'status'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->select(['users.id', 'users.name', 'users.email', 'users.role_id', 'users.reporting_to']);
    }

}
