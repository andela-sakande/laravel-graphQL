<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relations
     */
    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'follow_id', 'user_id')
            ->withTimestamps();
    }
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follow_id')
            ->withTimestamps();
    }
}
