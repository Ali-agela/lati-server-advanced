<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Server extends Model
{
    use HasFactory;
    protected  $fillable = ['name','code','user_id'];
    public function user(){
        return $this->BelongsTo(User::class);
    }
    public function subscribers (){
        return $this->belongsToMany(User::class,"user_servers");
    }
    public function tasks (){
        return $this->hasMany(Task::class);
    }
}
