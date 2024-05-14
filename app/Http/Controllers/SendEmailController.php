<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\SendEmailController;

class SendEmailController extends Controller
{



    

    public function emails_form(){
            return view('send_email_form');
    }

    public function send_emails(Request $request){

        $validator=Validator::make($request->all(),[
            'title'=>'required',
            'body'=>'required',

        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $details=[
            'title'=>$request->get('title'),
            'body'=>$request->get('body'),
        ];

        $job=new SendMailJob($details);

        dispatch($job);

        return redirect()->back()->with('status','Email sent successfully');
    }
}
