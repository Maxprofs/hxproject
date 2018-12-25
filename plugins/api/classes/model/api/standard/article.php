<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2017/7/24 10:23
 *Desc: 攻略模型
 */
class Model_Api_Standard_Article
{
    private static $_typeid = 4;

    /**
     * @desc 栏目信息
     * @return mixed
     */
    public static function channel()
    {
        $row = DB::select()
                 ->from('nav')
                 ->where('typeid', '=', self::$_typeid)
                 ->and_where('issystem', '=', 1)
                 ->execute()
                 ->current();

        return $row;
    }

    /**
     * @desc 攻略查询
     * @param $params
     * @return array
     */
    public static function search($params)
    {
        $status = true;
        $dest_pinyin = $params['destpy'];
        $attr_id = $params['attrid'];
        $page = intval($params['page']);
        $page = $page ? $page : 1;
        $pagesize = intval($params['pagesize']);
        $pagesize = $pagesize ? $pagesize : 5;
        $keyword = Common::remove_xss($params['keyword']);


        $value_arr = array();
        $where = " WHERE a.ishidden=0 ";
        //按目的地搜索
        if ($dest_pinyin && $dest_pinyin != 'all')
        {
            $destId = DB::select('id')
                        ->from('destinations')
                        ->where('pinyin', '=', $dest_pinyin)
                        ->execute()
                        ->get('id');
            //如果找不到则跳转404页面
            if (! empty($destId))
            {
                $where .= " AND FIND_IN_SET('$destId',a.kindlist) ";
            }

        }

        //按属性
        if (! empty($attr_id))
        {

            $where .= self::get_attr_where($attr_id);
        }
        //按关键词
        if (! empty($keyword))
        {
            $value_arr[':keyword'] = '%' . $keyword . '%';
            $where .= " AND a.title like :keyword ";
        }

        $offset = (intval($page) - 1) * $pagesize;

        $orderBy = " IFNULL(b.displayorder,9999) ASC, ";

        //如果选择了目的地
        if (! empty($destId))
        {
            $sql = "SELECT a.* FROM `sline_article` a ";
            $sql .= "LEFT JOIN `sline_kindorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=" . self::$_typeid . " AND a.webid=b.webid AND b.classid='$destId')";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy} IFNULL(b.displayorder,9999) ASC, a.modtime DESC,a.addtime DESC ";
            //$sql.= "LIMIT {$offset},{$pagesize}";

        }
        else
        {
            $sql = "SELECT a.* FROM `sline_article` a ";
            $sql .= "LEFT JOIN `sline_allorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=" . self::$_typeid . " AND a.webid=b.webid)";
            $sql .= $where;
            //$sql.= "ORDER BY IFNULL(b.displayorder,9999) ASC,{$orderBy}a.modtime DESC,a.addtime DESC ";
            $sql .= "ORDER BY {$orderBy} IFNULL(b.displayorder,9999) ASC, a.modtime DESC,a.addtime DESC ";
            //$sql.= "LIMIT {$offset},{$pagesize}";


        }

        //计算总数
        $totalSql = "SELECT count(*) as dd " . strchr($sql, " FROM");
        $totalSql = str_replace(strchr($totalSql, "ORDER BY"), '', $totalSql);//去掉order by


        $totalN = DB::query(1, $totalSql)
                    ->parameters($value_arr)
                    ->execute()
                    ->as_array();
        $totalNum = $totalN[0]['dd'] ? $totalN[0]['dd'] : 0;

        //数据量大时的优化方法,数据量小时不推荐使用此方法
        //$idWhere = "SELECT id FROM `sline_line` ORDER BY id limit $offset, 1";
        //$sql = str_replace("WHERE","WHERE a.id>($idWhere) AND",$sql);
        //$sql.= "LIMIT {$pagesize}";

        //检测页面数量是否超限
        $total_page = (int) ceil($totalNum / $pagesize);
        if (($total_page > 0 AND intval($page) > $total_page) OR ($total_page == 0 AND $page > 1))
        {
            $status = false;
        }


        $sql .= "LIMIT {$offset},{$pagesize}";

        $arr = DB::query(1, $sql)
                 ->parameters($value_arr)
                 ->execute()
                 ->as_array();
        foreach ($arr as &$v)
        {
            $v['attrlist'] = Model_Article_Attr::get_attr_list($v['attrid']);
            $v['commentnum'] = Model_Comment::get_comment_num($v['id'], self::$_typeid); //评论次数
            $v['litpic'] = Common::img($v['litpic']);
            $v['litpic'] = Model_Api_Standard_System::reorganized_resource_url($v['litpic']);
            $v['iconlist'] = Product::get_ico_list($v['iconlist']);
        }
        $out = array(
            'total'  => $totalNum,
            'list'   => $arr,
            'status' => $status,
        );

        return $out;

    }

    /**
     * @desc 属性生成where条件,用于多条件属性搜索
     * @param $attrid
     * @return string
     */
    public static function get_attr_where($attrid)
    {
        $arr = Common::remove_arr_empty(explode('_', $attrid));
        $str = '';
        foreach ($arr as $value)
        {
            $value = intval($value);
            if ($value != 0)
            {
                $str .= " and FIND_IN_SET($value,a.attrid) ";
            }
        }

        return $str;
    }

    /**
     * @desc 获取攻略详情
     * @param $id
     * @return array
     */
    public static function detail($id)
    {
        if ($id)
        {
            $info = DB::select()
                      ->from('article')
                      ->where('id', '=', $id)
                      ->execute()
                      ->current();
            //seo
            $seo_info = Product::seo($info);

            $info['seo_info'] = $seo_info;
            //产品图片
            $piclist = Product::pic_list($info['piclist']);
            $p = array();
            foreach ($piclist as &$pic)
            {
                $pi = Model_Api_Standard_System::reorganized_resource_url($pic[0]);
                array_push($p, $pi);
            }
            $info['piclist'] = $p;
            //属性列表
            $info['attrlist'] = Model_Article_Attr::get_attr_list($info['attrid']);
            //点评数
            $info['commentnum'] = Model_Comment::get_comment_num($info['id'], self::$_typeid);
            //产品编号
            $info['series'] = St_Product::product_series($info['id'], self::$_typeid);
            //产品图标
            $info['iconlist'] = Product::get_ico_list($info['iconlist']);
            $info['litpic'] = Model_Api_Standard_System::reorganized_resource_url($info['litpic']);
            $info['basehost'] = $GLOBALS['cfg_basehost'];

            //扩展字段信息
            $extend_info = ORM::factory('article_extend_field')
                              ->where("productid=" . $info['id'])
                              ->find()
                              ->as_array();
            $info['extend_info'] = $extend_info;

            return $info;
        }
        else
        {
            return array();
        }

    }
}