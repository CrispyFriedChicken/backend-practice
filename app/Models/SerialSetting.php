<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SerialSetting
 *
 * @property int $id
 * @property string $identifier
 * @property string $prefix
 * @property string $dateRule
 * @property int $length
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|SerialSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SerialSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SerialSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|SerialSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SerialSetting whereDateRule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SerialSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SerialSetting whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SerialSetting whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SerialSetting wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SerialSetting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SerialSetting extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
	protected $table = 'serialSetting';

	protected $casts = [
		'length' => 'int'
	];

	protected $dates = [
		'createdAt',
		'updatedAt'
	];

	protected $fillable = [
		'identifier',
		'prefix',
		'dateRule',
		'length',
		'createdAt',
		'updatedAt'
	];
}
