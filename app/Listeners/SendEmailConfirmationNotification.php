<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\EmailConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailConfirmationNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\EmailConfirmation  $event
     * @return void
     */
    public function handle(EmailConfirmation $event)
    {
        $employed = $event->user->name;
        $users = User::with('roles')->role('administrator')->get();

        $admintration = array();

        foreach ($users as $user) {
            array_push($admintration, $user);
        }

        foreach ($admintration as $admin) {
            $data = [
                'user_name' => $admin->name,
                'user_email' => $admin->email,
                'employed_name' => $employed,
            ];
            Mail::to($admin->email)->send(new \App\Mail\LinkConfirmation($data));
        }
    }
}
