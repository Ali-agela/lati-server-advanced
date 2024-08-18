<?php

namespace App\Http\Controllers;
use App\Models\UserTask;

use Illuminate\Http\Request;

class UsersTasksController extends Controller
{
    public function store(Request $request){
        $inputs= $request->validate([
            "user_id"=>["required","string",],
            "Task_id"=>["required","string",],
        ]);
        $server=auth()->user()->server()->firstOrFail();
        if(UserTask::where("user_id",$inputs["user_id"])->where("Task_id",$inputs["Task_id"])->exists()){
            return response()->json(["already done this"]);
        }
        $server->subscribers()->findOrFail($inputs["user_id"]);
        $server->tasks()->findOrfail($inputs["Task_id"])->users()->attach($inputs["user_id"]);
        return response()->json(["data"=>"task assigned "]);
    }
    public function destroy(Request $request){
        $inputs= $request->validate([
            "user_id"=>["required","string",],
            "Task_id"=>["required","string",],
        ]);
        $server=auth()->user()->server()->firstOrFail();

        $server->tasks()->findOrFail($inputs["Task_id"])->users()->findOrFail($inputs["user_id"])->tasks()->detach($inputs["Task_id"]);
        return response()->json(["data"=> "task un assigned "]);
    }
    public function index(Request $request){
        $tasks=auth()->user()->tasks();
        if ($request->has("name")){
        $name=$request->input('name');
        $tasks=$tasks->where("name","like","%".$name."%");
        }
        if(request()->has("description")){
            $description=$request->input('description');
            $tasks=$tasks->Where("description","like","%".$description."%");
        }
        $tasks=$tasks->get();
        return response()->json(["data"=> $tasks]);
    }
    public function update(Request $request, $id){
        $inputs= $request->validate([
            'status' => ['string', 'in:Not-Started,In-Progress,Completed,Cancelled','required']
        ]);
    auth()->user()->tasks()->where("tasks.id","=",$id)->firstOrFail()->update(['status'=>$inputs['status']]);
    return response()->json(["data"=> "updated "]);
    }
}
