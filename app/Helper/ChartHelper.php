<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ChartHelper
{

    const TYPE_BAR_CHART = 'Bar';
    const TYPE_LINE_CHART = 'Line';
    const COLOR_ORANGE = '#f87979';
    const COLOR_BLUE = '#0069d9';
    const COLOR_GREEN = '#28a745';
    const COLOR_RED = '#dc3545';

    public static function getSetting($type, $title, $labels, $datasets, $options = [])
    {
        return [
            'type' => $type,
            'title' => $title,
            'chartdata' => [
                'labels' => $labels,
                'datasets' => $datasets,
            ],
            'options' => count($options) ? $options : [
                'responsive' => true,
                'maintainAspectRatio' => false,
            ],
        ];
    }


    public static function getDatasets($label, $backgroundColor = self::COLOR_ORANGE, $data = [], $otherOptions = [])
    {
        return array_merge($otherOptions, [
            'label' => $label,
            'backgroundColor' => $backgroundColor,
            'data' => $data,
        ]);
    }

}
