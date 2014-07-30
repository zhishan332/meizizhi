<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangq
 * Date: 12-12-20
 * Time: 下午2:06
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'DbConfig.php';
class MySQL
{
    private $link;
    private $isCon = false;

    /** 析构函数 */
    function __destruct()
    {
        if ($this->isCon)
            $this->closeCon();
    }

    /** 创建连接，没有返回值 */
    function __construct()
    {
        if (!$this->isCon) {
            $this->newCon();
        }
    }

    /**创建连接*/
    private function  newCon()
    {
        $this->link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT)
        or
        die("fail connect to db<br /><br />" . mysql_error());
        mysql_query("SET NAMES " . DB_SET);
        $this->isCon = true;
    }

    /** 关闭连接，没有返回值 */
    function closeCon()
    {
        if ($this->isCon) {
            mysql_close($this->link);
            $this->isCon = false;
        }
    }

    /**执行SQL命令，输入参数:SQL语句，返回值：执行结果
     * @param $sql
     * @return resource
     */
    function execute($sql)
    {
//        echo $sql;exit;
        if (!$this->isCon)
            $this->newCon();

        $db_selected = mysql_select_db(DB_NAME, $this->link)
        or die("fail excute operation<br /><br />" . mysql_error($this->link));
        $result = mysql_query($sql, $this->link);
        return $result;
    }

    /**查询并返回数据对象
     * @param $sql
     * @return array
     */
    function executeReturnObj($sql)
    {
//        echo $sql;exit;
        if (!$this->isCon)
            $this->newCon();
        $db_selected = mysql_select_db(DB_NAME, $this->link)
        or die("fail excute operation<br /><br />" . mysql_error($this->link));
        $result = mysql_query($sql, $this->link);
        $resuleRow = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            foreach ($row as $k => $v) {
                $resuleRow[$i][$k] = $v;
            }
            $i++;
        }
        return $resuleRow;
    }

    /**查询第一条数据
     * @param $sql
     * @return array
     */
    function executeReturnFirstObj($sql)
    {
//        echo $sql;exit;
        if (!$this->isCon)
            $this->newCon();
        $db_selected = mysql_select_db(DB_NAME, $this->link)
        or die("fail excute operation<br /><br />" . mysql_error($this->link));
        $result = mysql_query($sql, $this->link);
        $resuleRow = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            foreach ($row as $k => $v) {
                $resuleRow[$i][$k] = $v;
            }
            break;
        }
        return count($resuleRow)==0?null:$resuleRow[0];
    }

    /**简单的执行sql,无返回，直接关闭连接
     * @param $sql
     * @return resource
     */
    function execute_once($sql)
    {
        if (!$this->isCon)
            $this->newCon();

        $db_selected = mysql_select_db(DB_NAME, $this->link)
        or die("fail excute operation<br /><br />" . mysql_error($this->link));
        mysql_query($sql, $this->link);
        $this->closeCon();
    }

    /**数据库插入并返回自增主键
     * @param $sql
     * @return int
     */
    function insertAndGetId($sql)
    {
        if (!$this->isCon)
            $this->newCon();

        $db_selected = mysql_select_db(DB_NAME, $this->link)
        or die("fail excute operation<br /><br />" . mysql_error($this->link));
        mysql_query($sql, $this->link);
        return mysql_insert_id();
    }

    /**
     * 查询数据库
     */
    public function select($table, $condition = array(), $field = array(), $orderby = "")
    {
        if (!$this->isCon)
            $this->newCon();

        $db_selected = mysql_select_db(DB_NAME, $this->link)
        or die("fail excute operation<br /><br />" . mysql_error($this->link));
        $where = '';
        if (!empty($condition)) {
            foreach ($condition as $k => $v) {
                $where .= $k . "='" . $v . "' and ";
            }
            $where = 'where ' . $where . '1=1';
        }
        $fieldstr = '';
        if (!empty($field)) {
            foreach ($field as $k => $v) {
                $fieldstr .= $v . ',';
            }
            $fieldstr = rtrim($fieldstr, ',');
        } else {
            $fieldstr = '*';
        }
        $sql = "select {$fieldstr} from {$table} {$where} {$orderby}";
//        echo $sql;exit;
        $result = mysql_query($sql, $this->link);
        $resuleRow = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            foreach ($row as $k => $v) {
                $resuleRow[$i][$k] = $v;
            }
            $i++;
        }
        return $resuleRow;
    }

    /**
     * 查询数据库
     */
    public function selectPage($table, $start, $end, $condition = array(), $field = array(), $orderby = "")
    {
        if (!$this->isCon)
            $this->newCon();

        $db_selected = mysql_select_db(DB_NAME, $this->link)
        or die("fail excute operation<br /><br />" . mysql_error($this->link));
        $where = '';
        if (!empty($condition)) {
            foreach ($condition as $k => $v) {
                $where .= $k . "='" . $v . "' and ";
            }
            $where = 'where ' . $where . '1=1';
        }
        $fieldstr = '';
        if (!empty($field)) {
            foreach ($field as $k => $v) {
                $fieldstr .= $v . ',';
            }
            $fieldstr = rtrim($fieldstr, ',');
        } else {
            $fieldstr = '*';
        }
        $sql = "select {$fieldstr} from {$table} {$where} {$orderby} limit " . $start . "," . $end;
//        echo $sql ;exit;
        $result = mysql_query($sql, $this->link);
        $resuleRow = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            foreach ($row as $k => $v) {
                $resuleRow[$i][$k] = $v;
            }
            $i++;
        }
        return $resuleRow;
    }

    /**
     * 查询数据库
     */
    public function selectSeniorPage($table, $start, $end, $conditionstr, $field = array(), $orderbystr = "")
    {
        if (!$this->isCon)
            $this->newCon();

        $db_selected = mysql_select_db(DB_NAME, $this->link)
        or die("fail excute operation<br /><br />" . mysql_error($this->link));
        $where = "";
        if (!empty($conditionstr)) {
            $where = 'where 1=1 ' . $conditionstr;
        }
        $fieldstr = '';
        if (!empty($field)) {
            foreach ($field as $k => $v) {
                $fieldstr .= $v . ',';
            }
            $fieldstr = rtrim($fieldstr, ',');
        } else {
            $fieldstr = '*';
        }
        $sql = "select {$fieldstr} from {$table} {$where} {$orderbystr} limit " . $start . "," . $end;
//        echo $sql ;exit;
        $result = mysql_query($sql, $this->link);
        $resuleRow = array();
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            foreach ($row as $k => $v) {
                $resuleRow[$i][$k] = $v;
            }
            $i++;
        }
        return $resuleRow;
    }

    /**
     * 查询1条
     */
    public function selectOne($table, $condition, $field = array())
    {
        if (!$this->isCon)
            $this->newCon();

        $db_selected = mysql_select_db(DB_NAME, $this->link)
        or die("fail excute operation<br /><br />" . mysql_error($this->link));
        $where = '';
        if (!empty($condition)) {
            $where = 'where ' . $condition . ' and 1=1';
        }
        $fieldstr = '';
        if (!empty($field)) {
            foreach ($field as $k => $v) {
                $fieldstr .= $v . ',';
            }
            $fieldstr = rtrim($fieldstr, ',');
        } else {
            $fieldstr = '*';
        }
        $sql = "select {$fieldstr} from {$table} {$where} limit 1";
//        echo $sql;exit;
        $result = mysql_query($sql, $this->link);
        $resuleRow = array();
        while ($row = mysql_fetch_assoc($result)) {
            foreach ($row as $k => $v) {
                $resuleRow[$k] = $v;
            }
            break;
        }
        return $resuleRow;
    }

    /**
     * 添加一条记录
     */
    public function insert($table, $data)
    {
        if (!$this->isCon)
            $this->newCon();

        $db_selected = mysql_select_db(DB_NAME, $this->link)
        or die("fail excute operation<br /><br />" . mysql_error($this->link));
        $values = '';
        $datas = '';
        foreach ($data as $k => $v) {
            $values .= $k . ',';
            $datas .= "'$v'" . ',';
        }
        $values = rtrim($values, ',');
        $datas = rtrim($datas, ',');
        $sql = "INSERT INTO  {$table} ({$values}) VALUES ({$datas})";
//        echo $sql;exit;
//        echo $sql;
        if (mysql_query($sql, $this->link)) {
            return mysql_insert_id();
        } else {
            return false;
        }

    }

    /**
     * 修改一条记录
     */
    public function update($table, $data, $condition = array())
    {
        if (!$this->isCon)
            $this->newCon();

        $db_selected = mysql_select_db(DB_NAME, $this->link)
        or die("fail excute operation<br /><br />" . mysql_error($this->link));
        $where = '';
        if (!empty($condition)) {

            foreach ($condition as $k => $v) {
                $where .= $k . "='" . $v . "' and ";
            }
            $where = 'where ' . $where . '1=1';
        }
        $updatastr = '';
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $updatastr .= $k . "='" . $v . "',";
            }
            $updatastr = 'set ' . rtrim($updatastr, ',');
        }
        $sql = "update {$table} {$updatastr} {$where}";
//        echo $sql;exit;
        $res = mysql_query($sql, $this->link);
        return $res;
    }

    /**
     * 删除记录
     */
    public function delete($table, $condition)
    {
        if (!$this->isCon)
            $this->newCon();

        $db_selected = mysql_select_db(DB_NAME, $this->link)
        or die("fail excute operation<br /><br />" . mysql_error($this->link));
        $where = '';
        if (!empty($condition)) {
            foreach ($condition as $k => $v) {
                $where .= $k . "='" . $v . "' and ";
            }
            $where = 'where ' . $where . '1=1';
        }
        $sql = "delete from {$table} {$where}";
        return mysql_query($sql);
    }

    public function countRows($from, $where = '')
    {
        $filed[0] = " count(1) total";
        $result = $this->selectOne($from, $where, $filed);
        return intval($result["total"]);
    }

}
