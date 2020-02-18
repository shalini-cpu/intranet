<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'designation', 'reporting_to', 'role_id', 'user_type',
        'phone', 'mobile', 'emer_contact_no', 'emer_contact_name',
        'designation',
        'dob', 'doj', 'hire_date',
        'emp_id', 'resignation_date',
        'city', 'address', 'reporting_to', 'branch_id',
        'profile_pic', 'resume_url', 'current_salary',
        'bg',
    ];

    protected $hidden = [
        'password', 'remember_token', 'emer_contact_no', 'emer_contact_name'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tech_label_users()
    {
        return $this->hasMany(TechLabelUser::class, 'user_id', 'id')
            ->select([
                'tech_label_users.id'
                , 'tech_label_users.tech_label_id'
                , 'tech_label_users.user_id'
                , 'tech_label_users.level'
            ]);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id')
            ->select(['branches.id', 'branches.location', 'branches.city', 'branches.address', 'branches.mobile']);
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

