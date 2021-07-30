<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'user_id',
        'title',
        'first_name',
        'last_name',
        'gender',
        'street',
        'city',
        'state',
        'country',
        'postcode',
        'birth_date',
        'phone',
        'photo',
        'thumbnail',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'birth_date',
    ];

    protected $hidden = [
        'id',
        'user_id',
        'title',
        'first_name',
        'last_name',
        'gender',
        'street',
        'city',
        'state',
        'country',
        'postcode',
        'birth_date',
        'phone',
        'photo',
        'thumbnail',
        'created_at',
        'updated_at',
        'user',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getUsernameAttribute()
    {
        return $this->user->username ?? null;
    }

    public function getEmailAttribute()
    {
        return $this->user->email ?? null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
