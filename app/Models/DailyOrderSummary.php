<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DailyOrderSummary
 *
 * @property int $id
 * @property int $type
 * @property int $currency
 * @property string $transactionDate
 * @property int $orderCount
 * @property float $totalWin
 * @property float $bet
 * @property float $totalPayout
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|DailyOrderSummary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyOrderSummary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyOrderSummary query()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyOrderSummary whereBet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyOrderSummary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyOrderSummary whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyOrderSummary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyOrderSummary whereOrderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyOrderSummary whereTotalPayout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyOrderSummary whereTotalWin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyOrderSummary whereTransactionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyOrderSummary whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyOrderSummary whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DailyOrderSummary extends Model
{
	protected $table = 'dailyOrderSummary';
	public $timestamps = false;

	protected $casts = [
		'type' => 'int',
		'currency' => 'int',
		'orderCount' => 'int',
		'totalWin' => 'float',
		'bet' => 'float',
		'totalPayout' => 'float'
	];

	protected $dates = [
		'createdAt',
		'updatedAt'
	];

	protected $fillable = [
		'type',
		'currency',
		'transactionDate',
		'orderCount',
		'totalWin',
		'bet',
		'totalPayout',
		'createdAt',
		'updatedAt'
	];
}
