<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Task;
use App\Client;
use App\Process;
use App\User;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }


    public function index()
    {
        $userid = Auth::id();

        $tasks = DB::select('SELECT a.id,a.title,a.content, a.newtask, a.inprogress, a.completed,b.client, a.deadline, a.taskfrom FROM `tasks` AS a LEFT JOIN clients AS b ON a.worktaskid = b.id WHERE a.userid = ?', [$userid]);
        foreach($tasks as $task){
            $usernameid = User::find($task->taskfrom);
            $username = $usernameid->name;
            $task->taskfrom = $username;
            $task->content = substr($task->content, 0,50);
        }
       // dd($tasks);
        return view('tasks.index')->with('tasks', $tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $userid = Auth::id();
        $clientsjob = DB::select('SELECT b.id, c.client,b.title FROM workgroups as a 
        LEFT JOIN jobs as b on b.id = a.workid 
        LEFT JOIN clients as c on b.clientid = c.id 
        LEFT JOIN users AS d on a.userid = d.id where b.complete = 0 AND a.userid = ?', [$userid]);
        $clients = Client::all(); 
       return view('tasks.create')->with('clients', $clients)->with('users', $users)->with('clientsjob', $clientsjob);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userid = $request['userid'];
        $worktaskid = $request['worktaskid'];
        $taskfrom = Auth::id();

        $deadline = $request['deadline'];

//        $arrDeadline = explode('.', $deadline);
//
//        //dd($arrDeadline);
//        $deadline = '';
//        $deadline .= $arrDeadline[2] . '-';
//        $deadline .= $arrDeadline[1] . '-' ;
//        $deadline .= $arrDeadline[0];

      // dd($deadline);

        $task = Task::create([
            'userid' => $userid,
            'title' => $request['title'],
            'content' => $request['content'],
            'worktaskid' => $worktaskid,
            'taskfrom' => $taskfrom,
            'deadline' => $deadline,

        ]);

        $task->save();

        if($userid == $taskfrom){
            return redirect('tasks');
        }else {
            return redirect('all-tasks');
        }

       // return redirect('tasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
        $userid = Auth::id();
        
        $task = Task::find($id);
       // $client = DB::select("Select * from clients as b left join tasks as a on a.worktaskid = b.id where a.id = ?",[$id]);
        $client = Client::find($task->worktaskid);
      //  dd($client);
            return view('tasks.show')->with('task', $task)->with('client', $client);
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $userid = Auth::id();
        $idcko = $request['idckoje'];
        $task = Task::find($idcko);
        //$clients = DB::select('SELECT c.id, c.client,b.title FROM workgroups as a LEFT JOIN jobs as b on b.id = a.workid LEFT JOIN clients as c on b.clientid = c.id LEFT JOIN users AS d on a.userid = d.id where b.complete = 0 AND a.userid = ?', [$userid]);
        $clients = Client::all();
        
       //dd($idcko);
      //  dd('userid: '. $userid. ' taskfromid: '. $task->taskfrom );
        if($userid == $task['userid'] || $userid == $task->taskfrom){
            return view('tasks.edit')->with('task', $task)
                                          ->with('clients', $clients);
        }else{
            {
                return response()->json([
                    'error' => 'Nope'
                ],402);
            }
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $userid = Auth::id();
        //
        $task = Task::find($id);


        $deadline = $request['deadline'];

        $arrDeadline = explode('.', $deadline);

        //dd($arrDeadline[0]);
//        $deadline = '';
//        $deadline .= $arrDeadline[2] . '-';
//        $deadline.= $arrDeadline[1] . '-' ;
//        $deadline .= $arrDeadline[0];

        // dd($deadline);

        $task->title = $request['title'];
        $task->content = $request['content'];
        $task->worktaskid = $request['worktaskid'];
        $task->deadline = $deadline;

        $task->save();

        if($userid == $task->taskfrom){
            return redirect('tasks');
        }else {
            return redirect('all-tasks');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $userid = Auth::id();
       

        if($userid == $task['userid'] || $userid == $task->taskfrom){
            if($task->delete()){;

                return response()->json([
                    'success' => 'Record deleted successfully!'
                ],200);
            }else{
                return response()->json([
                    'error' => 'Nope'
                ],402);
            }
        }else{
            return response()->json([
                'error' => 'Nope'
            ],402);
        }

       

  
    }

    public function alltasks(){

        $tasks = DB::select('SELECT a.id,a.title,a.content,b.client, a.taskfrom, a.newtask, a.inprogress, a.completed,a.deadline,c.name FROM `tasks` AS a LEFT JOIN clients AS b ON a.worktaskid = b.id LEFT JOIN users as c on a.userid = c.id');
        foreach($tasks as $task){
            $usernameid = User::find($task->taskfrom);
            $username = $usernameid->name;
            $task->taskfrom = $username;
            $task->content = substr($task->content, 0,50);

        }
       // dd($tasks);
        return view('tasks.alltasks')->with('tasks', $tasks);
    }
}
