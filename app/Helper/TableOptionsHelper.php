<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class TableOptionsHelper
{

    const tableTemplate = [
        'table' => [
            'class' => '',
            'style' => '',
        ],
        'columns' => [],
    ];
    const columnsTemplate = [
        'type' => 'text',
        'title' => '',
        'name' => '',
        'list' => false,
        'buttons' => false,
        'headerStyle' => '',
        'headerClass' => '',
        'rowStyle' => '',
        'rowClass' => '',
    ];

    public static function getTableOptions($columnsOptions = [], $tableOptions = [])
    {
        $result = self::tableTemplate;
        foreach ($columnsOptions as $columnsOption) {
            $result['columns'][] = array_merge(self::columnsTemplate, $columnsOption);
        }
        return $result;
    }
}
