<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demo;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Mail;
use App\Exports\FileExport;
use Maatwebsite\Excel\Facades\Excel;
class IndexController extends Controller
{
    public function index()
    {  
        return view('welcome');
    }

    public function list(){
        $demo_list = Demo::all();
        return view('form.list')->with('demo_list',$demo_list);
    }
   
    //
    public function store(Request $request)
    {
        //   dd($request);
        $validated = $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
        ]);
        
        $demo = new Demo();
        $demo->firstName = $request->firstName;
        $demo->lastName = $request->lastName;
        if($demo->save()){

            return redirect('list')->with('Success', 'Data Added Successfully.');
        }else{
            return redirect('/')->with('Error', 'Something went wrong.');

        }
    }

    public function getIpWithCityState(Request $request)
    {
        // dd($_SERVER['REMOTE_ADDR']);
        // $ipAddr= request()->getClientIp();
        // $ip = $this->getUserIpAddr();

    //    $full_ip_address = trim(shell_exec("nslookup myip.opendns.com resolver1.opendns.com"));
    //    $trim_ip = explode("\n",$full_ip_address);
    //    $ip = trim($trim_ip[4], 'Address: ');
       $ip = $_SERVER['REMOTE_ADDR'];
    //    dd($ip);
       $data = \Location::get($ip);
        // dd($data);
       if(!empty($data)){

        return redirect('/')->withCookie('ip_address',$data->ip)->withCookie('state',$data->regionName)->withCookie('city',$data->cityName);

       }else{
        return redirect('/')->with('Error', 'Something went wrong.');
       }

    }

    public function getUserIpAddr(){
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';    
        return $ipaddress;
     }
   
     public function add(){
         return view('form.add');
     }

     public function sendMail(Request $request)
     {
        try{
            $validated = $request->validate([
                'email' => 'required',
                'msg' => 'required'
            ]);
    
            $mailData = $request->msg;
            
            $mail = Mail::to($request->email)->send(new UserMail($mailData));
            
            return redirect('/')->with('Success','Mail Sent Successfully!');
        } catch (\Throwable $th) {
            \Session::put("Error",$th->getMessage());
            return redirect('/')->with('Error',$th->getMessage());
        }
     }

     public function getExcelFile()
     {
    
        return Excel::download(new FileExport, 'test.xlsx');

     }
}
