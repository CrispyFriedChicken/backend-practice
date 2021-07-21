<?php

namespace App\Helper;

use App\Enum\GamesEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ChartHelper
{

    const TYPE_BAR_CHART = 'Bar';
    const TYPE_LINE_CHART = 'Line';
    const TYPE_PIE_CHART = 'Pie';

    const COLOR_ORANGE = '#f87979';
    const COLOR_BLUE = '#0069d9';
    const COLOR_GREEN = '#28a745';
    const COLOR_RED = '#dc3545';

    const FORMAT_NUMBER = 'number';
    const FORMAT_MONEY = 'money';

    public static function getSetting($type, $title, $labels, $datasets, $options = [], $isShowPercentage = false)
    {
        return [
            'type' => $type,
            'title' => $title,
            'chartdata' => [
                'labels' => $labels,
                'datasets' => $datasets,
                'isShowPercentage' => $isShowPercentage,
            ],
            'options' => count($options) ? $options : [
                'responsive' => true,
                'maintainAspectRatio' => false,
            ],
        ];
    }


    public static function getDatasets($label, $backgroundColor = self::COLOR_ORANGE, $data = [], $otherOptions = [], $format = false)
    {
        return array_merge($otherOptions, [
            'label' => $label,
            'backgroundColor' => $backgroundColor,
            'data' => $data,
            'format' => $format,
        ]);
    }

    public static function getLabels($rows, $col, $map = false)
    {
        $labels = [];
        foreach ($rows as $row) {
            $labels[] = $map ? @(string)$map[$row->$col] : $row->$col;
        }
        return $labels;
    }


    public static function getDatas($rows, $cols)
    {
        $datas = [];
        foreach ($cols as $col) {
            $datas[$col] = [];
        }
        foreach ($rows as $row) {
            foreach ($cols as $col) {
                $datas[$col][] = (int)$row->$col;
            }
        }
        return $datas;
    }


    public static function getColors($rows)
    {
        $colorSet = [
            '#FF9900',
            '#3366CC',
            '#109618',
            '#990099',
            '#3B3EAC',
            '#0099C6',
            '#DD4477',
            '#66AA00',
            '#B82E2E',
            '#316395',
            '#994499',
            '#22AA99',
            '#AAAA11',
            '#6633CC',
            '#E67300',
            '#8B0707',
            '#329262',
            '#5574A6',
            '#3B3EAC',
        ];
        return array_splice($colorSet, 0, count($rows));
    }
}
