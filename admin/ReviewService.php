<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once dirname(dirname(__FILE__)) . PATH . 'includes' . PATH . 'dao' . PATH . 'MySQL.php';

class ReviewService
{
    public static function find($keyword, $status = 10, $start = 0, $limit = DEFAULT_LIMIT)
    {
        $sql = "select a.id,a.pageid,a.title,a.viewnum,a.cover,a.imgnum,a.disnum,a.praisenum,a.showindex,a.status,a.cuserid,a.cusername,
                a.cdate,a.udate
                from page a  where 1=1 ";
        if ($status != -1) {
            $sql .= " and status=" . $status;
        }
        if (!empty($keyword)) {
            $sql .= " and a.title like '%" . $keyword . "%'";
        }
        $sql .= " order by a.udate desc  limit   " . $start . "," . $limit;
        $mysql = new MySQL();
        $res = $mysql->executeReturnObj($sql);
        $pages = array();
        if (empty($res)) return $pages;
        foreach ($res as $data) {
            $pageid = $data['pageid'];
            $sqlImg = "select id imgid,img from page_img where pageid=" . $pageid;
            $imgs = $mysql->executeReturnObj($sqlImg);
            $data['imgs'] = $imgs;
            $pages[] = $data;
        }
        $mysql->closeCon();
        return $pages;
    }

    public static function getTotal($keyword, $status)
    {
        $where = " 1=1 ";
        if ($status != -1) {
            $where .= " and status=" . $status;
        }
        if (!empty($keyword)) {
            $where .= " and title like '%" . $keyword . "%'";
        }
        $mysql = new MySQL();
        $total = $mysql->countRows("page", $where);
        $mysql->closeCon();
        return $total;
    }

    public static function delImg($imgid, $deltype = 1)
    {
        $mysql = new MySQL();
        $sqlImg = "select * from page_img where id=" . $imgid;
        $imgObj = $mysql->executeReturnFirstObj($sqlImg);
        if (empty($imgObj)) {
            $mysql->closeCon();
            return false;
        }
        $img = $imgObj['img'];
        $pageid = $imgObj['pageid'];
        $sqlPage = "select * from page where pageid=" . $pageid;
        $page = $mysql->executeReturnFirstObj($sqlPage);
        if (empty($page)) {
            $mysql->closeCon();
            return false;
        }
        $cover = $page['cover'];
        $sqlDel = "delete from page_img where id=" . $imgid;
        $mysql->execute($sqlDel);
        //删除文件
        $fullPath = MIMGPATH . $img;
        if (file_exists($fullPath) && $deltype == 1) {
            unlink($fullPath);
        }
        //更新图片数
        $upNumSql = "update page set imgnum=imgnum-1 where pageid=" . $pageid;
        $mysql->execute($upNumSql);

        if ($cover == $img) {
            $sqlImg2 = "select * from page_img where pageid=" . $pageid;
            $imgNw = $mysql->executeReturnFirstObj($sqlImg2);
            if (empty($imgNw)) {
                $mysql->closeCon();
                return false;
            }
            $img2 = $imgNw['img'];
            $sqlUp = "update page set cover='" . $img2 . "' where pageid=" . $pageid;
            $mysql->execute($sqlUp);
        }
        $mysql->closeCon();
        return true;
    }

    public static function setCover($imgid)
    {
        $mysql = new MySQL();
        $sqlImg = "select * from page_img where id=" . $imgid;
        $imgObj = $mysql->executeReturnFirstObj($sqlImg);
        if (empty($imgObj)) {
            $mysql->closeCon();
            return false;
        }
        $img = $imgObj['img'];
        $pageid = $imgObj['pageid'];
        $sqlUp = "update page set cover='" . $img . "' where pageid=" . $pageid;
        $mysql->execute($sqlUp);
        $mysql->closeCon();
        return true;
    }

    public static function delPage($pageid, $deltype = 1)
    {
        $mysql = new MySQL();
        //删除图片和图片数据
        $sqlImg = "select * from page_img where pageid=" . $pageid;
        $imgs = $mysql->executeReturnObj($sqlImg);
        if (!empty($imgs) && 1 == $deltype) {
            foreach ($imgs as $img) {
                $imgName = $img['img'];
                //删除文件
                $fullPath = MIMGPATH . $imgName;
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
        }

        $sqlDelImg = "delete from page_img where pageid=" . $pageid;
        $mysql->execute($sqlDelImg);

        $sqlDelExt = "delete from page_ext where pageid=" . $pageid;
        $mysql->execute($sqlDelExt);

        $sqlDelDis = "delete from page_discs where pageid=" . $pageid;
        $mysql->execute($sqlDelDis);

        $sqlDelPage = "delete from page where pageid=" . $pageid;
        $mysql->execute($sqlDelPage);

        $mysql->closeCon();
        return true;
    }

    public static function update($pageid, $title, $showIndex)
    {
        $nt = time() * 1000;
        $sql = "update page set title='" . $title . "' , status=20, showindex=" . $showIndex . ",udate=" . $nt . " where pageid=" . $pageid;
        $mysql = new MySQL();
        $mysql->execute($sql);
        $mysql->closeCon();
        return true;
    }

    public static function  addPage($page,$imgs){
        $mysql = new MySQL();
        $data['pageid']=
        $mysql->insert('page',$page);
        $pageid=$page['pageid'];
        foreach($imgs as $img){
            $imgObj['pageid']=$pageid;
            $imgObj['img']=$img;
            $mysql->insert('page_img',$imgObj);
        }
        $mysql->closeCon();
    }
}