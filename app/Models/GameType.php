<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GameType
 *
 * @property int $id
 * @property int $code
 * @property string $name
 * @property string $title
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|GameType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameType query()
 * @method static \Illuminate\Database\Eloquent\Builder|GameType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameType whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GameType extends Model
{
    const ALL_TYPE = 0;
    protected $table = 'game_types';
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

    public static function getCodeTitleMap($isShowAllSelection = false)
    {
        $codeTitleMap = [];
        $rows = self::get();
        foreach ($rows as $row) {
            $codeTitleMap[$row->code] = $row->title;
        }
        if ($isShowAllSelection) {
            $codeTitleMap += [self::ALL_TYPE => '全遊戲類型'];
        }
        return $codeTitleMap;
    }

    public static function getCodeNameMap()
    {
        $codeNameMap = [];
        $rows = self::get();
        foreach ($rows as $row) {
            $codeNameMap[$row->code] = $row->name;
        }
        return $codeNameMap;
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
