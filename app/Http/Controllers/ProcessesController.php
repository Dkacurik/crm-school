<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ProcessesController extends Controller
{
    public function showTasks(){
        $userid = Auth::id();

        $tasks = DB::select('SELECT a.title, a.content, a.id, a.newtask, a.inprogress , a.completed, c.client, b.clientid, a.worktaskid FROM `tasks` as a left join jobs as b on a.worktaskid = b.id left join clients as c on b.clientid = c.id where a.userid = ? ', [$userid]);
        //dd($tasks);
        return view('tasks.process')->with('tasks', $tasks);
    }

    public function inProgress(Request $request, $id){
            $task = Task::find($id);

            $task->newtask = 0;
            $task->inprogress = 1;
            $task->completed = 0;

            $task->save();

            return redirect('/process');
    }

    public function completed(Request $request, $id){
        $task = Task::find($id);

        $task->newtask = 0;
        $task->inprogress = 0;
        $task->completed = 1;

        $task->save();

        return redirect('/process');
    }

    public function newTask(Request $request, $id)
    {
        $task = Task::find($id);

        $task->newtask = 1;
        $task->inprogress = 0;
        $task->completed = 0;

        $task->save();

        return redirect('/process');
    }

    public function ajax(Request $request){

        $task = Task::find($request['id']);
        $send_to = $request['send_to'];

      //  dd(gettype($send_to));

        if($send_to ==  "send-to-inProgress"){
            $task->newtask = 0;
            $task->inprogress = 1;
            $task->completed = 0;
            $task->save();
            return response()->json([
                'success' => 'Task status has been changed to in progress!',
                'title' => $task->title,
                'client' => $task->client,
                'content' => $task->content,
            ],200);
        }else if($send_to ==  "send-to-newTask"){
            $task->newtask = 1;
            $task->inprogress = 0;
            $task->completed = 0;
            $task->save();
            return response()->json([
                'success' => 'Task status has been changed to new task!',
                   'title' => $task->title,
                'client' => $task->client,
                'content' => $task->content,
            ],200);
        } else if($send_to == "send-to-completed"){
            $task->newtask = 0;
            $task->inprogress = 0;
            $task->completed = 1;
            $task->save();
            return response()->json([
                'success' => 'Task status has been changed to completed!',
                   'title' => $task->title,
                'client' => $task->client,
                'content' => $task->content,
            ],200);
        }else{
            return response()->json([
                'error' => 'Nope'
            ],402);
        }

    }
}
