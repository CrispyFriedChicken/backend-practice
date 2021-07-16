<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency
 *
 * @property int $id
 * @property int $code
 * @property string $name
 * @property string $title
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Currency extends Model
{
    protected $table = 'currency';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $casts = [
        'code' => 'int'
    ];

    protected $dates = [
        'createdAt',
        'updatedAt'
    ];

    protected $fillable = [
        'code',
        'name',
        'title',
        'createdAt',
        'updatedAt'
    ];


    public static function getCodeTitleMap()
    {
        $keyValueMap = [];
        $rows = self::get();
        foreach ($rows as $row) {
            $keyValueMap[$row->code] = $row->title;
        }
        return $keyValueMap;
    }


    public static function getNameCodeMap()
    {
        $rows = self::get();
        $codeNameMap = [];
        foreach ($rows as $row) {
            $codeNameMap[$row->name] = $row->code;
        }
        return $codeNameMap;
    }
}
