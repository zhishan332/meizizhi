<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yfwangqing
 * Date: 14-7-16
 * Time: 下午4:49
 * 图片操作
 */

require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'Config.php';
require_once dirname(dirname(__FILE__)) . PATH . 'dao' . PATH . 'MySQL.php';
class PageService
{

    public static function find($keyword, $start = 0, $limit = DEFAULT_LIMIT)
    {
        $sql = "select a.id,a.pageid,a.title,a.viewnum,a.cover,a.imgnum,a.disnum,a.praisenum,a.status,a.cuserid,a.cusername,
                a.cdate,a.udate ,b.tagid,b.tag,b.num
                from page a left join  page_tag b
                on a.pageid=b.pageid  where a.status=10";
        if (!empty($keyword)) {
            $sql .= " and a.title like '%" . $keyword . "%'";
        }
        $sql .= " order by a.udate desc  limit   " . $start . "," . $limit;
        $mysql = new MySQL();
        $res = $mysql->executeReturnObj($sql);
        $pages = array();
        if (empty($res)) return $pages;
        foreach ($res as $page) {
            $pageid = $page['pageid'];
            if (!empty($page['tagid'])) {
                $tag['tagid'] = $page['tagid'];
                $tag['tag'] = $page['tag'];
                $tag['num'] = $page['num'];
                $flag = true;
                foreach ($pages as $key => $temPage) {
                    if ($pageid == $temPage['pageid']) {
                        $flag = false;
                        array_push($temPage['tags'], $tag);
                    }
                    $pages[$key] = $temPage;
                }
                if ($flag) {
                    $tags = array();
                    array_push($tags, $tag);
                    $page['tags'] = $tags;
                    array_push($pages, $page);
                }
            } else {
                array_push($pages, $page);
            }
        }
        $mysql->closeCon();
        return $pages;
    }

    public static function findShowIndex($start = 0, $limit = DEFAULT_LIMIT)
    {
        $sql = "select a.id,a.pageid,a.title,a.viewnum,a.cover,a.imgnum,a.disnum,a.praisenum,a.status,a.cuserid,a.cusername,
                a.cdate,a.udate
                from page  a where a.status=10 and a.showindex=1 ";
        $sql .= " order by a.udate desc  limit   " . $start . "," . $limit;
        $mysql = new MySQL();
        $res = $mysql->executeReturnObj($sql);
        if (empty($res)) return null;
        $mysql->closeCon();
        return $res;
    }


    public static function getTotal($keyword)
    {
        $where = " status=10 ";
        if (!empty($keyword)) {
            $where .= " and title like '%" . $keyword . "%'";
        }
        $mysql = new MySQL();
        $total = $mysql->countRows("page", $where);
        $mysql->closeCon();
        return $total;
    }

    public static function getImg($pageid)
    {
        $sql = "select id,pageid,img from page_img where pageid=" . $pageid;
        $mysql = new MySQL();
        $res = $mysql->executeReturnObj($sql);
        $mysql->closeCon();
        return $res;
    }

    public static function updateDisNum($pageid)
    {
        $mysql = new MySQL();
        $res = $mysql->execute("update page set disnum=disnum+1 where pageid=" . $pageid);
        $mysql->closeCon();
        return $res;
    }

    public static function updatePraiseNum($pageid)
    {
        $mysql = new MySQL();
        $res = $mysql->execute("update page set praisenum=praisenum+1 where pageid=" . $pageid);
        $mysql->closeCon();
        return $res;
    }

    public static function getPage($pageid)
    {
        $sql = "select a.id,a.pageid,a.title,a.viewnum,a.cover,a.imgnum,a.disnum,a.praisenum,a.status,a.cuserid,a.cusername,
                a.cdate,a.udate ,b.img
                from page a left join  page_img b
                on a.pageid=b.pageid  where a.pageid=" . $pageid;
        $mysql = new MySQL();
        $res = $mysql->executeReturnObj($sql);
        $mysql->closeCon();
        return $res;
    }
}