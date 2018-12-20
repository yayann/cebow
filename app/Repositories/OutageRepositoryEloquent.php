<?php

namespace App\Repositories;

use App\Events\OutagePlanned;
use Illuminate\Support\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OutageRepository;
use App\Entities\Outage;
use App\Validators\OutageValidator;

/**
 * Class OutageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OutageRepositoryEloquent extends BaseRepository implements OutageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Outage::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        $model = parent::create($attributes);
        event(new OutagePlanned($model));

        return $model;
    }

    /**
     * @param $locality
     * @return array
     */
    public function getPastYearOutagesByWeekStats($locality)
    {
        $data = \DB::table('outages')
            ->selectRaw('WEEK(outage_from) Week, count(id) Outages')
            ->where('outage_from', '>=', Carbon::now()->subYear())
            ->where('locality', 'LIKE', '%' . $locality . '%')
            ->orderByRaw('WEEK(outage_from)')
            ->groupBy('Week')
            ->pluck('Outages', 'Week')->all();

        if (count($data)) {
            $w_start = array_first(array_keys($data));
            $w_end = (int)Carbon::now()->format('W');

            $cursor = $w_start;
            while ($cursor  <= $w_end) {
                if (!isset($data[$cursor])) {
                    $data[$cursor] = 0;
                }

                $cursor++;
            }
        }

        ksort($data);

        return $data;

    }

}
