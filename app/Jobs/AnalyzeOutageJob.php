<?php

namespace App\Jobs;

use App\Entities\Outage;
use App\Entities\Subscriber;
use App\Notifications\SubscribedOutagePlanned;
use App\Repositories\SubscriberRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AnalyzeOutageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Outage */
    protected $outage;

    /**
     * AnalyzeOutageJob constructor.
     * @param Outage $outage
     */
    public function __construct($outage)
    {
        $this->outage = $outage;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SubscriberRepository $subscriberRepository)
    {
        $outage = $this->outage;
        Subscriber::chunk(10, function ($subscribers) use ($outage) {
            /** @var Subscriber $subscriber */
            foreach($subscribers as $subscriber)
            {
                if(mb_strpos(strtolower($outage->locality), strtolower($subscriber->locality)) !== false)
                {
                    $subscriber->user->notify(new SubscribedOutagePlanned($outage));
                }
            }
        });
    }
}
