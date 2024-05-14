<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct($details)
    {
      $this->details=$details;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users=User::all();
        $input['title']=$this->$details['title'];
        $input['body']=$this->$details['body'];

        foreach($users as $user){
          $input['name']=$user['name'];
          $input['email']=$user['email'];

          Mail::send('mail.test_mail', ['input' => $input], function ($message) use ($input) {
            $message->to($input['email'], $input['name'])
                ->subject($input['title']);
        });

        }
    }
}
