<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SerialControl
 *
 * @property int $id
 * @property string $identifier
 * @property string $date
 * @property int $latest
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|SerialControl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SerialControl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SerialControl query()
 * @method static \Illuminate\Database\Eloquent\Builder|SerialControl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SerialControl whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SerialControl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SerialControl whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SerialControl whereLatest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SerialControl whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SerialControl extends Model
{
	protected $table = 'serialControl';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
	protected $casts = [
		'latest' => 'int'
	];

	protected $dates = [
		'createdAt',
		'updatedAt'
	];

	protected $fillable = [
		'identifier',
		'date',
		'latest',
		'createdAt',
		'updatedAt'
	];
}
