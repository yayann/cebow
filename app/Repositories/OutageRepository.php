<?php

namespace App\Repositories;

use Illuminate\Support\Carbon;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OutageRepository.
 *
 * @package namespace App\Repositories;
 */
interface OutageRepository extends RepositoryInterface
{
    //
    /**
     * @param $locality
     * @return array
     */
    public function getPastYearOutagesByWeekStats($locality);
}
