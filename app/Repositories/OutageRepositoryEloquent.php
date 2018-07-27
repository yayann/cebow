<?php

namespace App\Repositories;

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
    
}
