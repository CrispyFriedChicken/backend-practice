<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * Class Game
 *
 * @property int $id
 * @property string $uuid
 * @property string $chineseName
 * @property string $englishName
 * @property string $code
 * @property string $type
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property Collection|Order[] $orders
 * @property Collection|UserGame[] $user_games
 * @package App\Models
 * @property-read int|null $orders_count
 * @property-read int|null $user_games_count
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereChineseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereEnglishName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereUuid($value)
 * @mixin \Eloquent
 */
class Game extends Model
{

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
	protected $table = 'games';

	protected $dates = [
		'createdAt',
		'updatedAt'
	];

	protected $fillable = [
		'uuid',
		'chineseName',
		'englishName',
		'code',
		'type',
		'createdAt',
		'updatedAt'
	];

	public function orders()
	{
		return $this->hasMany(Order::class, 'gameUuid', 'uuid');
	}

	public function user_games()
	{
		return $this->hasMany(UserGame::class, 'gameUuid', 'uuid');
	}
}
