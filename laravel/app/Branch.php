<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        "location", "city", "mobile", "address"
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'branch_id', 'id')
            ->select(['users.branch_id', 'users.id', 'users.name', 'users.email', 'users.role_id', 'users.reporting_to']);
    }

}
