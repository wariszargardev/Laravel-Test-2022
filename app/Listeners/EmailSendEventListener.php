<?php

namespace App\Listeners;

use App\Events\EmailSendEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmailSendEventListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(EmailSendEvent $event)
    {
        dispatch(new \App\Jobs\SendEmailJob($event->id, $event->users));
    }
}
