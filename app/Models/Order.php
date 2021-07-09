<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * Class Order
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $userUuid
 * @property string|null $gameUuid
 * @property string $roundSerial
 * @property string $orderSerial
 * @property string $transactionDate
 * @property string $code
 * @property string $type
 * @property string $email
 * @property string $currency
 * @property float $stake
 * @property float $stakeCny
 * @property float $winning
 * @property float $winningCny
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @property Game|null $game
 * @property User|null $user
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereGameUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderSerial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRoundSerial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStake($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStakeCny($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTransactionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereWinning($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereWinningCny($value)
 * @mixin \Eloquent
 */
class Order extends Model
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
	protected $table = 'orders';

	protected $casts = [
		'stake' => 'float',
		'stakeCny' => 'float',
		'winning' => 'float',
		'winningCny' => 'float'
	];

	protected $dates = [
		'createdAt',
		'updatedAt'
	];

	protected $fillable = [
		'uuid',
		'userUuid',
		'gameUuid',
		'roundSerial',
		'orderSerial',
		'transactionDate',
		'code',
		'type',
		'email',
		'currency',
		'stake',
		'stakeCny',
		'winning',
		'winningCny',
		'createdAt',
		'updatedAt'
	];

	public function game()
	{
		return $this->belongsTo(Game::class, 'gameUuid', 'uuid');
	}

	public function player()
	{
		return $this->belongsTo(User::class, 'userUuid', 'uuid');
	}
}
