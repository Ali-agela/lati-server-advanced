<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\ServerUser;
use Illuminate\Http\Request;
class UserServerController extends Controller
{
    
    public function store($code){
        
        $server=Server::where("code", $code)->firstOrFail();
        if (auth()->user()->subscription()->where("code", $code)->exists()) {
            return response()->json("already joined in the server",);
        }
        $server->subscribers()->attach(auth()->id());
        return response(
            ["message"=> "joined the server  <<{$code}>>"],
        );
    }
    public function destroy($code){
        $server=Server::where("code", $code)->firstOrFail();
        $server->subscribers()->where("user_id",auth()->id())->firstOrFail()->subscription()->detach($server->id);
        return response()->json("leaved",200);
    }
    public function index(){
        $servers=auth()->user()->subscription()->get();
        return response()->json(["servers"=>$servers]);
    }
}
