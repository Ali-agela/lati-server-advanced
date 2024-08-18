<?php

namespace App\Http\Controllers;
use App\models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ServerController extends Controller
{
    public function store(Request $request){
        
        $input=request()->validate([
            "name"=> ["required","string"],
        ]);
        if(auth()->user()->server()->exists()){
            return response()->json(["error"=>"this user can not create a server "]);
        }
        $code=$this->generateCode();
        
        $server=Server::create([
            "name"=> $input["name"],
            "code"=> $code,
            "user_id"=>auth()->id(),
        ]);  
        return response()->json([
            "the following server is added "=>$server
        ])  ;
    }
    private function generateCode(): string
    {
        $code = Str::random(6);
        if (Server::where('code', '=', $code)->exists()) {
            $this->generateCode();
        }
        return $code;
    }
    public function show(Request $request){
        $server=auth()->user()->server()->firstOrFail();
        return response()->json(["your server"=>$server]);
    }
    public function update(){
    $input=request()->validate([
        "name"=>["required","string"]
    ]);
    $server=auth()->user()->server()->firstOrFail();
    $server->update($input);
    return response()->json(["server name updated "=> $server->name]);
    }
    public function destroy(Request $request){
        $server=auth()->user()->server()->firstOrFail();
        $server->delete();
        return response()->json([
            "server deleted"
        ]);
    }
}
