<?php

namespace App\Helper;

class ExportHelper
{
    /**
     * 直接輸出檔案
     * (檔案產生位置 在vm執行位置，用網頁執行則出現在 /backend/web)
     * @param $fileName string 檔名
     * @param $hLines array 標題 [0=>title1,2=>title2]
     * @param $lines array 每列的資料 [0=>[title1 => value1 , title2 =>value2],]
     */
    public static function exportCsvToLocalStorage($fileName, $hLines, $lines)
    {
        //檔名若非csv結尾則自動補上
        if (!strpos($fileName, '.csv') !== false) {
            $fileName .= '.csv';
        }
        $output = fopen($fileName, 'w') or die("Can't open php://output");//開檔
        fwrite($output, "\xEF\xBB\xBF");//顯示中文

        foreach ($hLines as $hLine) {
            fputcsv($output, $hLine);
        }

        foreach ($lines as $line) {
            fputcsv($output, $line);
        }
        fclose($output) or die("Can't close php://output");//關檔
    }

    /**
     * 輸出csv的字串
     * @param $hLines array 標題  [0=>[title1 => value1 , title2 =>value2],]
     * @param $lines array 每列的資料 [0=>[title1 => value1 , title2 =>value2],]
     * @param string $newlineString
     * @return string
     */
    public static function exportCsvToString($hLines, $lines, $newlineString = "\n")
    {
        $result = '';
        foreach ($hLines as $hLine) {
            $result .= implode(',', $hLine) . $newlineString;
        }
        foreach ($lines as $line) {
            $result .= implode(',', $line) . $newlineString;
        }
        return $result;
    }


    /**
     * 用瀏覽器下載文字內容
     * @param $textContent
     * @param $fileType
     * @param string $fileName
     */
    public static function downloadTxtByApache($textContent, $fileName = 'log', $fileType = 'txt')
    {
        //檔名若非txt結尾則自動補上
        if (!!strpos($fileName, '.txt') !== false) {
            $fileName .= '.' . $fileType;
        }
        $output = fopen($fileName, "w") or die("Unable to open file!");
        fwrite($output, "\xEF\xBB\xBF");//顯示中文
        fwrite($output, print_r($textContent, 1));
        fclose($output);

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=' . basename($fileName));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileName));
        header("Content-Type: text/plain");

        readfile($fileName);
        unlink($fileName);
    }
}
