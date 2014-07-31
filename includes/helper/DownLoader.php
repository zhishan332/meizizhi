<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yfwangqing
 * Date: 14-7-31
 * Time: 下午3:27
 * To change this template use File | Settings | File Templates.
 */

class DownLoader {

    public static function download($url,$targetFilePath){
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        $imageData = curl_exec($curl);
        curl_close($curl);
        $tp = @fopen($targetFilePath,'a');
        fwrite($tp, $imageData);
        fclose($tp);
    }
}