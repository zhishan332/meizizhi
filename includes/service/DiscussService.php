<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yfwangqing
 * Date: 14-7-24
 * Time: 下午3:05
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'Config.php';
require_once dirname(dirname(__FILE__)) . PATH . 'dao' . PATH . 'MySQL.php';
require_once dirname(dirname(__FILE__)) . PATH . 'service' . PATH . 'EmotionService.php';
require_once dirname(dirname(__FILE__)) . PATH . 'service' . PATH . 'PageService.php';
class DiscussService
{

    public static function queryDiscuss($pageid)
    {
        $sql = "select id,pageid,userid,username,discuss,cdate from page_discs where pageid=" . $pageid . " limit 50";
        $mysql = new MySQL();
        $res = $mysql->executeReturnObj($sql);
        $mysql->closeCon();
        $lastResult = array();
        foreach ($res as $data) {
            $data['discuss'] = self::replaceEmotion($data['discuss']);
            $lastResult[] = $data;
        }
        return $lastResult;
    }

    private function replaceEmotion($discuss)
    {
        if (preg_match_all("/\[(.*?)\]/is", $discuss, $out)) {
            if (count($out) <= 0) return $discuss;
            foreach ($out[0] as $emo) {
                $res = EmotionService::getIconByName($emo);
                $icon = $res['icon'];
                if (!empty($icon)) {
                    $emoHtml = "<img src='$icon' >";
                    $discuss = str_replace($emo, $emoHtml, $discuss);
                }
            }
        }
        return $discuss;
    }

    public static function insertDiscuss($disObj)
    {
        $mysql = new MySQL();
        $res = $mysql->insert("page_discs", $disObj);
        $mysql->closeCon();
        PageService::updateDisNum($disObj['pageid']);
        return $res;
    }


}