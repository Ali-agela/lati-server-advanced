<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $fillable = ['name','phone','email','DOB','password','gender','avatar_url'];
    protected $hidden=['password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function server(){
        return $this->hasOne(Server::class);
    }
    public function subscription (){
        return $this->belongsToMany(Server::class,"user_servers");
    }
    public function tasks (){
        return $this->belongsToMany(Task::class,"user_tasks")->distinct();
    }
}
