<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Entities\Subscriber
 *
 * @property int $id
 * @property int $user_id
 * @property string $locality
 * @property string|null $street
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Subscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Subscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Subscriber whereLocality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Subscriber whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Subscriber whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Subscriber whereUserId($value)
 * @mixin \Eloquent
 * @property-read mixed $planned_outages
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|static[] $current_outages
 */
class Subscriber extends Model implements Transformable
{
    use TransformableTrait;

    protected $_planned_outages;
    protected $_current_outages;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'locality', 'street'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getPlannedOutagesAttribute()
    {
        if(! $this->_planned_outages) {
            $this->_planned_outages = Outage::future()->search($this->locality, $this->street)->get();
        }

        return $this->_planned_outages;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getCurrentOutagesAttribute()
    {
        if(! $this->_current_outages) {
            $this->_current_outages = Outage::current()->search($this->locality, $this->street)->get();
        }

        return $this->_current_outages;
    }


    public function hasPlannedOutages()
    {
        return count($this->planned_outages);
    }

    public function hasCurrentOutages()
    {
        return count($this->current_outages);
    }

}
