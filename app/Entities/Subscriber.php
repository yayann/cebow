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
 */
class Subscriber extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'locality', 'street'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function user()
    {
        return $this->belongsTo(User::class);
    }

}
