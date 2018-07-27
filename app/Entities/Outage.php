<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Outage.
 *
 * @package namespace App\Entities;
 */
class Outage extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['hash', 'outage_from', 'outage_to', 'locality', 'roads'];

    /**
     * @param $query
     */
    public function scopeFuture($query)
    {
        return $query->where('outage_to', '>=', Carbon::now());
    }


    /**
     * @param $query
     */
    public function scopeCurrent($query)
    {
        return $query
            ->where('outage_from', '<=', Carbon::now())
            ->where('outage_to', '>=', Carbon::now());
    }

}
