<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Workgroup;
use App\Job;

class WorkgroupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function percentage(Request $request)
    {
        $userid = $request['worker'];
        $jobid = $request['id'];
     
        $jobs = Workgroup::all()->where('workid', $jobid);
        $counter = 0;
        foreach ($jobs as $job){
            $counter += $job->percentage;
        }
        $percentage = $request['percentage'];
        if($counter+$percentage > 50){
            return  abort(403, 'Nesedia percenta');
        }else{
            $job = Job::find($jobid);
            $job->percentage -= $percentage;
            $job->save();
        $workgroup = Workgroup::create([
           'userid' => $userid,
           'workid' => $jobid,
           'userpercentage' => $percentage,
        ]);
        $workgroup->save();
        return redirect()->to('/jobs/'.$jobid);

        }
    }

    public function repair(Request $request, $id){
        $jobid = $id;
        $userid = $request['userrepairid'];
        $percentage = $request['reppercent'];
        $oldpercent = $request['oldpercent'];
        $oldpercent -= $percentage;

        $job = Job::find($id);
        $job->percentage += $oldpercent;
        $job->save();

        DB::table('workgroups')
            ->where('userid', $userid)
            ->where('workid', $jobid)
            ->update(['userpercentage' => $percentage]);
        return redirect()->to('/jobs/'.$jobid);
    }

    public function removepercentage(Request $request){
        $jobid = $request['jobid'];
        $userid = (int)$request['useridd'];
        $percentage = $request['reppercent'];
        $user = DB::select('SELECT userpercentage FROM `workgroups` WHERE userid = ? and workid = ?', [$userid, $jobid]);
        $oldpercent = (int) $user[0]->userpercentage;

        $job = Job::find($jobid);
        $job->percentage += $oldpercent;
        $job->save();
        DB::table('workgroups')->where('workid', '=', $jobid)->where('userid', '=', $userid)->delete();

        return redirect()->to('/jobs/'.$jobid);
    }
}
