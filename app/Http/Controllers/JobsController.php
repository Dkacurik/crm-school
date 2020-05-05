<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Client;
use App\Job;
use App\User;
use App\Workgroup;
use App\Task;
class newUser
{
    public $id;
    public $name;
}

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {

        $jobs = DB::select('SELECT a.id,a.title,a.description,b.client,a.fullprice, a.complete FROM `jobs` AS a LEFT JOIN clients AS b ON a.clientid = b.id where a.complete = 0 and a.archive = 0');

        return view('jobs.index')->with('jobs', $jobs);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();

        return view('jobs.create')->with('clients', $clients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userid = Auth::id();
        $client = $request['client'];
        $title = $request['title'];
        $description = $request['description'];
        $fullprice = $request['price'];
        $teamprice = $fullprice * 0.5;
        $companypart = $fullprice * 0.5;

        $job = Job::create([
           'userid' => $userid,
           'clientid' => $client,
           'title' => $title,
           'description' => $description,
            'fullprice' => $fullprice,
            'teamprice' => $teamprice,
            'companypart' => $companypart,
            'percentage' => 50,
        ]);

        $job->save();

        return redirect('/jobs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $job = Job::find($id);
        $allusers = DB::select('SELECT a.id, a.name from users as a');

      //  $workers = Workgroup::all()->where('workid', $id);
        $workers = DB::select('SELECT a.userpercentage, c.name, a.userid FROM workgroups as a left join jobs as b on a.workid = b.id left join users as c on a.userid = c.id where a.workid = ? ', [$id]);
        $activeworkers = DB::select('SELECT b.* FROM `workgroups` as a left join users as b on a.userid = b.id WHERE workid = ?', [$id]);

        $users = array();
        $names = array();
        $names[0] = 'empty';

        foreach ($activeworkers as $activeworker){
            $names[] = $activeworker->name;
        }
        $x = 0;
        foreach ($allusers as $user){
            $name = $user->name;
            $key = array_search($name, $names);
            if(!$key){
                $users[$x] = new newUser;
                $users[$x]->id = $user->id;
                $users[$x]->name = $user->name;
                $x++;
            }

        }



        return view('jobs.show')->with('job', $job)
                                    ->with('users', $users)->with('workers', $workers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = Job::find($id);
        $client = Client::all();

        return view('jobs.edit')->with('job', $job)
                ->with('clients', $client);
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
        $job = Job::find($id);

        $job->title = $request['title'];
        $job->description = $request['description'];
        $job->fullprice = $request['price'];
        $job->clientid = $request['client'];
        $job->teamprice = $request['price'] * 0.5;
        $job->companypart = $request['price'] * 0.5;

        $job->save();

        return redirect('jobs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $job = Job::find($id);

       $job->delete();

       return redirect('jobs');
    }

    public function complete($id){

        //kontrola ci ma job este nejaky nedokonceny task

        $tasks = DB::select('select * from tasks where worktaskid = ? and (newtask = 1 or inprogress = 1)', [$id]);
        $tasky =  DB::select('select * from tasks where worktaskid = ? ', [$id]);
        $x = 0;
        foreach($tasks as $task){
            $x++;
        }

        $y = 0;
        foreach($tasky as $task){
            $y++;
        }
        if($y == 0){
            return response()->json([
                'error' => 'Nope'
            ],402);
        }
        if($x == 0){

        $alltasks = DB::select('select * from tasks as a left join jobs as b on a.worktaskid = b.id where b.id = ?', [$id]);

        $disabled = DB::select('select * from tasks as a left join jobs as b on a.worktaskid = b.id where a.inprogress = 0 and b.id = ? or a.newtask = 0 and b.id = ?', [$id, $id]);

    //    echo sizeof($alltasks) . ': all tasks';
    //    echo sizeof($disabled) . ': disabled';
    //    die();
        if($alltasks == $disabled){
        $job = Job::find($id);
        $job->complete = 1;
        $job->archive = 1;
        $job->done_at = date('Y-m-d H:i:s');
        $job->save();
        $workers = Workgroup::all()->where('workid', $id);
        foreach ($workers as $worker){
            $userid = $worker->userid;
           $percentage = $worker->userpercentage;
           $salary = $job->fullprice * ($percentage / 100);
           $user = User::all()->where('id', $userid)->first();
           $user->salary += $salary;
           $user->save();
        }

        //$tasky = DB::select('select * from tasks where worktaskid = ? and (newtask = 1 or inprogress = 1)', [$id]);
        // foreach($tasks as $task){
        //     $y = Task::find($task->id);
        //     $y->delete();
        // }
        if($job->save()){;

            return response()->json([
                'success' => 'Record deleted successfully!'
            ],200);
        }else{
            return response()->json([
                'error' => 'Nope'
            ],402);
        }
        }

        else{
           
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

    public function archive($id){
        $job = Job::find($id);
        $job->archive = 1;
        $job->save();

        if($job->save()){
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }else{
            return 'err';
        }
    }

    public function history(){

        $jobs = DB::select('SELECT a.id,a.title,a.description,b.client,a.fullprice, a.complete, a.created_at, a.done_at FROM `jobs` AS a LEFT JOIN clients AS b ON a.clientid = b.id where a.complete = 1');
 // job->fullprice * ($percentage / 100);
        return view('jobs.history')->with('jobs', $jobs);
    }

    public function myjobs(){
        $userid = Auth::id();

        $jobs = DB::select('SELECT a.id,a.title,a.description,b.client,a.fullprice, a.complete, a.created_at, a.done_at, c.userpercentage FROM `jobs` AS a LEFT JOIN clients AS b ON a.clientid = b.id LEFT JOIN workgroups as c ON a.id = c.workid WHERE c.userid = ?', [$userid]);
        
        if($jobs){
            foreach($jobs as $job){
                $job->fullprice = $job->fullprice * ($job->userpercentage / 100);
        }}
        return view('jobs.myjobs')->with('jobs', $jobs);
        
    
}
}