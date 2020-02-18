<?php

namespace App;

use App\Scopes\StatusScope;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'desc', 'url', 'dev_url', 'repo_url', 'delivered_on',
        'lead_by', 'product_manager_id', 'created_by',
        'wip',
    ];

//    protected static function boot()
//    {
//        parent::boot();
//        if (! auth()->user()->isAdmin()) {
//            static::addGlobalScope('school', function (Builder $builder) {
//                $builder->where('school_id', auth()->user()->school_id);
//            });
//        }
//    }

//    public function scopeManager($query)
//    {
//        if (auth()->user()->role_id == 1) return $query;
//        return $query->where('school_id', 2);
//    }

//    protected static function boot()
//    {
//        parent::boot();
//        static::addGlobalScope(new StatusScope());
//    }

    public function scopeStatus($query, $status = 1)
    {
        return $query->whereStatus($status);
    }

    public function team()
    {
        return $this->hasMany(Team::class);
    }

    public function lead()
    {
        return $this->
        hasOne(User::class, 'id', 'lead_by')
            ->select(['users.id', 'users.name', 'users.email', 'users.role_id', 'users.reporting_to']);
    }

    public function product_manager()
    {
        return $this->hasOne(User::class, 'id', 'product_manager_id')
            ->select(['users.id', 'users.name', 'users.email', 'users.role_id', 'users.reporting_to']);
    }

    public function created_by()
    {
        return $this->hasOne(User::class, 'id', 'created_by')
            ->select(['users.id', 'users.name', 'users.email', 'users.role_id', 'users.reporting_to']);
    }

    public function worksheets()
    {
        return $this->hasMany(Worksheet::class)
            ->select([
                'worksheets.id', 'worksheets.project_id', 'worksheets.user_id',
                'worksheets.title', 'worksheets.desc', 'worksheets.hours_spend', 'worksheets.date',
                'worksheets.task_type',
            ]);
    }

}
