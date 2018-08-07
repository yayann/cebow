<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\Outage
 *
 * @property int $id
 * @property string $hash
 * @property \Carbon\Carbon $outage_from
 * @property \Carbon\Carbon $outage_to
 * @property string $locality
 * @property string $roads
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $pretty_print
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Outage current()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Outage future()
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Outage onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Outage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Outage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Outage whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Outage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Outage whereLocality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Outage whereOutageFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Outage whereOutageTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Outage whereRoads($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Outage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Outage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\Outage withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Outage search($locality, $street = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Outage currentOrFuture()
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
     * @var array
     */
    protected $dates = ['outage_from', 'outage_to'];

    /**
     * @param $query
     */
    public function scopeFuture($query)
    {
        return $query->where('outage_from', '>=', Carbon::now());
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

    /**
     * @param $query
     */
    public function scopeCurrentOrFuture($query)
    {
        return $query->where('outage_to', '>=', Carbon::now());
    }

    public function scopeSearch($query, $locality, $street = null)
    {
        return $query->where('locality', 'LIKE', '%'.$locality.'%')
            ->when($street, function($query, $street) {
                return $query->where('roads', 'LIKE', '%'.$street.'%');
            });

    }

    public function getPrettyPrintAttribute()
    {
        return sprintf(
            'in %s on %s from %s to %s',
            $this->locality,
            $this->outage_from->format('l d/m/Y'),
            $this->outage_from->format('H:i'),
            $this->outage_to->format('H:i')
        );
    }

}
