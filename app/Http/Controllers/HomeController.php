<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Task;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

            

        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://joke3.p.rapidapi.com/v1/joke",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => array(
        //         "x-rapidapi-host: joke3.p.rapidapi.com",
        //         "x-rapidapi-key: 55c2aed9b1mshac1958df245574dp1fe3cfjsnd1f2bb1d9508"
        //     ),
        // ));
        
        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        
        // curl_close($curl);
        
        // if ($err) {
        //     $quote = "cURL Error #:" . $err;
        // } else {
        //     $response = json_decode($response);
        //     $quote = $response;
        // }



        $userid = Auth::id();
        $salary = User::find($userid);
        $inprogress = DB::select('SELECT  a.title, a.content, a.id, a.newtask, a.inprogress , a.completed, c.client, b.clientid, a.worktaskid FROM `tasks` as a left join jobs as b on a.worktaskid = b.id left join clients as c on b.clientid = c.id WHERE a.userid = ? and a.newtask = 0 and a.inprogress = 1 and  a.completed = 0 order by a.id desc LIMIT 1', [$userid]);
        $lastclient = DB::select('SELECT * FROM `clients` where archive = 0 ORDER BY id DESC LIMIT 1');
    
        $lastjob =  DB::table('jobs')->latest('created_at')->first();
       // dd($lastjob);
        $lastnote =  DB::table('notes')->latest('created_at')->where('userid', $userid)->first();
        $lastcost =  DB::table('costs')->latest('created_at')->first();


        return view('home')->with('salary', $salary)
                                ->with('inprogress', $inprogress)
                                ->with('lastclient', $lastclient[0])
                                ->with('lastjob', $lastjob)
                                ->with('lastnote', $lastnote)
                                ->with('lastcost', $lastcost);
                              //  ->with('quote', $quote);
    }
}
