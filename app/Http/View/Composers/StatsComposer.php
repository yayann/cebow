<?php
/**
 * cebparser
 *
 * @author    Yann Labour <yann@sugarsplashes.com>
 * @copyright 2018 - Sugarsplashes
 */

namespace App\Http\View\Composers;

use App\Charts\OutageChart;
use Carbon\Carbon;
use Illuminate\View\View;

class StatsComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {

        $view->with('outages_by_day', $this->getOutagesByDayStats());
        $view->with('outages_by_week', $this->getOutagesByWeekStats());
    }


    protected function getOutagesByDayStats()
    {
        $outages_by_day = \DB::table('outages')
            ->selectRaw('dayname(outage_from) Day, count(id) Outages')
            ->orderByRaw('WEEKDAY(outage_from)')
            ->groupBy('Day')
            ->pluck('Outages', 'Day')->all();

        $chart = new OutageChart();

        $chart->labels(array_keys($outages_by_day));

        $chart->dataset('Outages', 'bar', array_values($outages_by_day));

        return $chart;
    }

    protected function getOutagesByWeekStats()
    {
        $outages_by_week = \DB::table('outages')
            ->selectRaw('WEEK(outage_from) Week, count(id) Outages')
            ->where('outage_from', '>=', Carbon::now()->subYear())
            ->orderByRaw('WEEK(outage_from)')
            ->groupBy('Week')
            ->pluck('Outages', 'Week')->all();

        $chart = new OutageChart();

        $chart->labels(array_keys($outages_by_week));

        $chart->dataset('Outages', 'line', array_values($outages_by_week));

        return $chart;
    }


}