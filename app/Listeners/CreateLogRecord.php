<?php

namespace App\Listeners;

use App\Events\ExecutedAction;
use App\Http\Controllers\LogController;
use App\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateLogRecord
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
     * @param  ExecutedAction  $event
     * @return void
     */
    public function handle(ExecutedAction $event)
    {
        //

        LogController::storeEvent($event);

    }
}
