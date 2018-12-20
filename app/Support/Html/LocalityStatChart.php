<?php
/**
 * cebparser
 *
 * @author    Yann Labour <yann@sugarsplashes.com>
 * @copyright 2018 - Sugarsplashes
 */

namespace App\Support\Html;

use App\Charts\OutageChart;
use App\Repositories\OutageRepository;

class LocalityStatChart
{

    /** @var  OutageRepository */
    protected $outage_repository;

    /**
     * LocalityStatChart constructor.
     * @param OutageRepository $outage_repository
     */
    public function __construct()
    {
        $this->outage_repository = app(OutageRepository::class);
    }


    public function make($locality, $label = 'Outages', $type = 'line')
    {
        $data = $this->outage_repository->getPastYearOutagesByWeekStats($locality);

        if(empty($data)) {
            return false;
        }

        $chart = new OutageChart();

        $chart->labels(array_keys($data));

        $chart->dataset($label, $type, array_values($data));

        return $chart;
    }
}