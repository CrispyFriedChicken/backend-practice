<?php

namespace App\Helper;

use Illuminate\Support\Str;

class QueryHelper
{
    const DateSearch = 'DateSearch';
    const EqualSearch = 'EqualSearch';
    const FuzzySearch = 'FuzzySearch';

    public static function addConditions(&$query, $request, $conditions)
    {
        foreach ($conditions as $actionType => $columns) {
            self::doAction($actionType, $query, $request, $columns);
        }
    }

    protected static function doAction($actionType, &$query, $request, $columns)
    {
        switch ($actionType) {
            case self::DateSearch://日期查詢
                self::addDateConditions($query, $request, $columns);
                break;
            case self::EqualSearch://值查詢
                self::addEqualConditions($query, $request, $columns);
                break;
            case self::FuzzySearch://模糊查詢
                self::addFuzzySearchConditions($query, $request, $columns);
                break;
        }
    }


    /**
     * 新增查詢條件(值一致)
     * @param $query
     * @param $request
     * @param $equalColumns array 新增條件的欄位 [['requestName' => '', 'dbColumn' => ''],[]...] || ['requestName(dbColumn)',...]
     */
    public static function addEqualConditions(&$query, $request, $equalColumns)
    {
        foreach ($equalColumns as $equalColumn) {
            $requestName = self::getRequestName($equalColumn);
            $dbColumn = self::getDbColumn($equalColumn);
            if ($requestName && $request->$requestName) {
                $query = $query->where([$dbColumn => $request->$requestName]);
            }
        }
    }


    /**
     * 新增查詢條件(值一致)
     * @param $query
     * @param $request
     * @param $dateColumns array 查詢時間欄位
     */
    public static function addDateConditions(&$query, $request, $dateColumns)
    {
        foreach ($dateColumns as $dateColumn) {
            $requestName = self::getRequestName($dateColumn);
            $dbColumn = self::getDbColumn($dateColumn);
            $dateValue = $request->$requestName;
            if ($requestName && $dateValue) {
                if (is_string($dateValue)) {
                    self::addFuzzySearchConditions($query, $request, [$dateColumn]);
                } elseif (is_array($dateValue)) {
                    $query = $query->where(function ($q) use ($request, $dbColumn, $dateValue) {
                        $q->where($dbColumn, '>=', "$dateValue[0]");
                        $q->where($dbColumn, '<=', "$dateValue[1]%");
                    });
                }
            }
        }
    }

    /**
     * 新增查詢條件(模糊查詢)
     * @param $query
     * @param $request
     * @param $fuzzySearchColumns array 新增條件的欄位[['requestName' => '', 'dbColumn' => ''],[]...] || ['requestName(dbColumn)',...]
     */
    public static function addFuzzySearchConditions(&$query, $request, $fuzzySearchColumns)
    {
        foreach ($fuzzySearchColumns as $fuzzySearchColumn) {
            $requestName = self::getRequestName($fuzzySearchColumn);
            $dbColumn = self::getDbColumn($fuzzySearchColumn);
            $searchString = trim($request->$requestName);

            if ($searchString) {
                if (is_string($dbColumn)) {
                    $query = $query->where($dbColumn, 'LIKE', '%' . $searchString . '%');
                } elseif (is_array($dbColumn)) {
                    $query = $query->where(function ($q) use ($request, $dbColumn, $searchString) {
                        foreach ($dbColumn as $col) {
                            $q->orWhere($col, 'LIKE', "%$searchString%");
                        }
                    });
                }
            }
        }
    }

    /**
     * 取查詢程式碼
     * @param $query
     * @return string
     */
    public static function getRawSQL($query)
    {
        return Str::replaceArray('?', $query->getBindings(), $query->toSql());
    }


    protected static function getRequestName($column)
    {
        if (is_string($column)) {
            return $column;
        } elseif (is_array($column)) {
            return $column['requestName'];
        } else {
            return '';
        }
    }

    protected static function getDbColumn($column)
    {
        if (is_string($column)) {
            return $column;
        } elseif (is_array($column)) {
            return $column['dbColumn'];
        } else {
            return '';
        }
    }
}
