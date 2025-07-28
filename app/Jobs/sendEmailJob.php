<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class sendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $password;
    protected $username;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $password, $username)
    {

        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new ResetPasswordMail($this->password, $this->username);
        Mail::to('sundar.r@securenext.in')->send($email);
        // Log::info("email: " . $email);
        // Mail::to($this->email)->send(new ResetPasswordMail($this->password));
    }
}
