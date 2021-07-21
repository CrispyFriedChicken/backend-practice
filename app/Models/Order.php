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
 * @property int $type
 * @property string $email
 * @property int $currency
 * @property float $totalWin
 * @property float $totalWinCny
 * @property float $bet
 * @property float $betCny
 * @property float $totalPayout
 * @property float $totalPayoutCny
 * @property float $exchangeRate
 * @property float $exchangeRateCny
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 *
 * @property Game|null $game
 * @property User|null $user
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'orders';
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
	protected $casts = [
		'type' => 'int',
		'currency' => 'int',
		'totalWin' => 'float',
		'totalWinCny' => 'float',
		'bet' => 'float',
		'betCny' => 'float',
		'totalPayout' => 'float',
		'totalPayoutCny' => 'float',
		'exchangeRate' => 'float',
		'exchangeRateCny' => 'float'
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
		'totalWin',
		'totalWinCny',
		'bet',
		'betCny',
		'totalPayout',
		'totalPayoutCny',
		'exchangeRate',
		'exchangeRateCny',
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
