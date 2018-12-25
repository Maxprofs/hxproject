<?php

/**
 * Created by Phpstorm.
 * User: netman
 * Date: 15-9-23
 * Time: 上午10:43
 * Desc: 攻略获取标签
 */
class Taglib_Article
{

    private static $_typeid = 4;
    private static $basefield = 'a.id,
                                a.webid,
                                a.aid,
                                a.title,
                                a.seotitle,
                                a.comefrom,
                                a.fromsite,
                                a.author,
                                a.litpic,
                                a.addtime,
                                a.modtime,
                                a.shownum,
                                a.tagword,
                                a.keyword,
                                a.description,
                                a.kindlist,
                                a.finaldestid,
                                a.themelist,
                                a.attrid,
                                a.ad_productid,
                                a.ad_kindid,
                                a.redirecturl,
                                a.ishidden,
                                a.iconlist,
                                a.templet,
                                a.summary,
                                a.isoffical,
                                a.piclist,
                                a.attachment,
                                a.downnum';

    /**
     * 检测该产品模块是否安装
     * @return bool
     */
    public function right()
    {
        $bool = true;
        if (!St_Functions::is_system_app_install(self::$_typeid))
        {
            $bool = false;
        }
        return $bool;
    }


    /**
     * @param $params
     * @return mixed
     * @description 标签接口
     */
    public static function query($params)
    {
        $default = array(
            'flag' => '',
            'destid' => 0,
            'offset' => 0,
            'row' => '10',
            'havepic' => false,
            'tagword'=>''
        );
        $params = array_merge($default, $params);
        extract($params);
        switch ($flag)
        {
            case 'new':
                $list = self::get_article_new($offset, $row, $havepic);
                break;
            case 'order':
                $list = self::get_article_order($offset, $row, $havepic);
                break;
            case 'mdd':

            case 'relative':
                if (empty($destid)) return '';
                $list = self::get_article_bymdd($offset, $row, $destid, $havepic);
                break;

            case 'byattrid':
                $list = self::get_article_by_attrid($offset, $row, $attrid);
                break;
            case 'theme':
                $list = self::get_article_by_themeid($offset, $row, $themeid);
                break;
            case 'mdd_order':
                $list = self::get_article_by_mdd_order($offset, $row, $destid, $havepic);
                break;
            case 'mdd_new':
                $list = self::get_article_by_mdd_new($offset, $row, $destid, $havepic);
                break;
            case 'tagrelative':
                $list = self::get_tagrelative($offset,$row,$tagword);
                break;

        }
        foreach($list as &$a)
        {
            $a['articleid'] = $a['id'];

        }
        return Model_Article::get_article_attachinfo($list);

    }

    /*
   * 获取最新
   * */
    public static function get_article_new($offset,$row,$havepic)
    {
        $sql = "SELECT ".self::$basefield." FROM sline_article a ";
        $sql.= "WHERE a.ishidden=0 ";
        if($havepic)
            $sql.= "and a.litpic<>'' ";
        $sql.= "ORDER BY a.addtime desc,a.modtime DESC ";
        $sql.= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;
    }

    /*
  * 获取最新
  * */
    public static function get_tagrelative($offset,$row,$tagword)
    {
        if(empty($tagword))
        {
            return null;
        }

        $w = " WHERE a.ishidden=0 ";
        $tagword_arr = explode(',',$tagword);
        $tagword_w_arr = array();
        foreach($tagword_arr as $tag)
        {
            $tagword_w_arr[] = " FIND_IN_SET('{$tag}',a.tagword) ";
        }
        if(count($tagword_w_arr)>0)
        {
            $w.=" and (".implode(' or ',$tagword_w_arr).")";
        }
        else
        {
            return null;
        }

        $sql = "SELECT ".self::$basefield." FROM sline_article a ";
        $sql.= $w;
        $sql.= "ORDER BY a.modtime desc,a.addtime DESC ";
        $sql.= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;
    }

    /*
     * 按顺序获取
     * */
    public static function get_article_order($offset,$row,$havepic)
    {
        $sql = "SELECT ".self::$basefield." FROM sline_article a ";
        $sql.= "LEFT JOIN `sline_allorderlist` b ";
        $sql.= "ON (a.id=b.aid and b.typeid=4) ";
        $sql.= "WHERE a.ishidden=0 ";
        if($havepic)
            $sql.= "and a.litpic<>'' ";
        $sql.= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql.= "limit {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;


    }
    /*
     * 按目的地获取
     * */
    public static function get_article_bymdd($offset,$row,$destid,$havepic)
    {
        $sql = "SELECT ".self::$basefield." FROM `sline_article` a ";
        $sql.= "LEFT JOIN `sline_kindorderlist` b ";
        $sql.= "ON (a.id=b.aid and b.typeid=4 and b.classid=$destid) ";
        $sql.= "WHERE a.ishidden=0 AND FIND_IN_SET($destid,a.kindlist) ";
        if($havepic)
            $sql.= "and a.litpic<>'' ";
        $sql.= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql.= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;
    }


    /*
  * 执行sql语句
  * */
    private static function execute($sql)
    {
        $arr = DB::query(1,$sql)->execute()->as_array();
        return $arr;
    }


    /**
     * @param $offset
     * @param $row
     * @param $attrid
     * @return mixed
     * @desc 按属性读取文章
     */
    private static function get_article_by_attrid($offset, $row, $attrid)
    {
        $sql = "SELECT a.* FROM sline_article a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=4) ";
        $sql .= "WHERE a.ishidden=0  AND FIND_IN_SET($attrid,a.attrid)";

        $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "limit {$offset},{$row}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;

    }

    /**
     * @param $offset
     * @param $row
     * @param $themeid
     * @return mixed
     * 按专题读取数据
     */
    private static function get_article_by_themeid($offset, $row, $themeid)
    {
        $sql = "SELECT a.* FROM sline_article a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=4) ";
        $sql .= "WHERE a.ishidden=0  AND FIND_IN_SET($themeid,a.themelist)";

        $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "limit {$offset},{$row}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }

    /*
     * 按目的地获取推荐
     * */
    public static function get_article_by_mdd_order($offset, $row, $destid, $havepic)
    {
        $sql = "SELECT " . self::$basefield . " FROM `sline_article` a ";
        $sql .= "LEFT JOIN `sline_kindorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=4 and b.classid=$destid) ";
        $sql .= "WHERE a.ishidden=0 AND FIND_IN_SET('$destid',a.kindlist) ";
        if ($havepic)
            $sql .= "and a.litpic<>'' ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }

    /*
     * 按目的地获取最新
     * */
    public static function get_article_by_mdd_new($offset, $row, $destid, $havepic)
    {
        $sql = "SELECT " . self::$basefield . " FROM `sline_article` a ";
        $sql .= "LEFT JOIN `sline_kindorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=4 and b.classid=$destid) ";
        $sql .= "WHERE a.ishidden=0 AND FIND_IN_SET($destid,a.kindlist) ";
        if ($havepic)
            $sql .= "and a.litpic<>'' ";
        $sql .= "ORDER BY a.modtime desc,a.addtime DESC,IFNULL(b.displayorder,9999) asc ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }

    public static function comment($params)
    {
        $default = array(
            'row' => '30',
            'offset' => 0,
            'flag' => '',
            'page' => 1,
            'controller' => 'article'
        );
        $params = array_merge($default, $params);
        $data = Product::content_comment($params);
        return $data;
    }

} 