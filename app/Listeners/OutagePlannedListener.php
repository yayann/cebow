<?php

namespace App\Listeners;

use App\Events\OutagePlanned;
use App\Jobs\AnalyzeOutageJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OutagePlannedListener implements ShouldQueue
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
    public function handle(OutagePlanned $event)
    {
        dispatch(new AnalyzeOutageJob($event->outage));
    }
}
