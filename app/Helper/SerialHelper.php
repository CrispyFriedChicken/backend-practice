<?php

namespace App\Helper;

use App\Models\SerialControl;
use App\Models\SerialSetting;
use \Datetime;

class SerialHelper
{
    /**
     * 產生流水號
     * @param string $identifier
     * @param string $date
     * @return string
     * @throws \Exception
     */
    public static function produce(string $identifier, string $date = 'now'): string
    {
        $result = '';
        $serialSetting = SerialSetting::where(['identifier' => $identifier])->first();
        if ($serialSetting) {
            $dateString = '';
            if ($serialSetting->dateRule) {
                $dateTime = new DateTime($date);
                $dateString = $dateTime->format($serialSetting->dateRule);
            }
            $serialControl = SerialControl::where(['identifier' => $identifier, 'date' => $dateString])->first();
            if ($serialControl) {
                $serialControl->latest++;
                $serialControl->save();
            } else {
                $serialControl = new SerialControl();
                $serialControl->latest = 1;
                $serialControl->identifier = $identifier;
                $serialControl->date = $dateString;
                $serialControl->save();
            }
            //流水號格式
            if ($serialControl->latest < pow(10, $serialSetting->length - 1)) {
                $latestString = str_pad($serialControl->latest, $serialSetting->length, 0, STR_PAD_LEFT);//格式:00X
            } else {
                //超過格式則直接取該數字
                $latestString = $serialControl->latest;
            }
            $result = $serialSetting->prefix . $dateString . $latestString;
        }
        return $result;
    }

}
