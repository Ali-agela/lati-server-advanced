<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function store(Request $request){
        
        $inputs = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['max:1024'],
            'due_Date' => ['date'],
            'priority' => ['required', 'integer', 'min:1', 'max:5'],
            'status' => ['string', 'in:Not-Started,In-Progress,Completed,Cancelled']
        ]);
        $server=auth()->user()->server()->firstOrFail();
        $task=Task::create([
            "name"=>$inputs["name"],
            "description"=>$inputs["description"],
            "due_Date"=>$inputs["due_Date"],
            "priority"=> $inputs["priority"],
            "status"=> $inputs["status"],
            "server_id"=> $server->id,
        ]);
        return response()->json(["task created "=> $task]);
    }
    public function destroy( $id){
        $server=auth()->user()->server()->firstOrFail();
        $server->tasks()->findOrFail($id)->delete();
        return response()->json(["deleted"]);
        }
    }
