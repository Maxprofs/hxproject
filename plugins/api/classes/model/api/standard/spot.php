<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Api_Standard_Spot
{
    private static $_typeid = 5;

    /**
     * @desc 景点列表
     * @param $params
     * @return array
     */
    public static function search($params)
    {
        $status = true;
        $dest_pinyin = $params['destpy'];
        $price_id = intval($params['priceid']);
        $sort_type = intval($params['sorttype']);
        $attr_id = $params['attrid'];
        $page = intval($params['page']);
        $page = $page ? $page : 1;
        $pagesize = intval($params['pagesize']);
        $pagesize = $pagesize ? $pagesize : 5;
        $keyword = St_String::filter_mark(Common::remove_xss($params['keyword']));


        $value_arr = array();
        $where = " WHERE a.ishidden=0 ";
        //按目的地搜索
        if ($dest_pinyin && $dest_pinyin != 'all')
        {
            $destId = DB::select('id')->from('destinations')->where('pinyin', '=', $dest_pinyin)->execute()->get('id');
            //如果找不到则跳转404页面
            if (!empty($destId))
            {
                $where .= " AND FIND_IN_SET('$destId',a.kindlist) ";
            }

        }

        //价格区间
        if ($price_id)
        {
            $priceArr = DB::select()->from('spot_pricelist')->where('id', '=', $price_id)->execute()->current();
            if (!empty($priceArr))
            {
                $where .= " AND a.price BETWEEN {$priceArr['min']} AND {$priceArr['max']} ";
            }

        }
        //排序
        $orderBy = "";
        if (!empty($sort_type))
        {
            if ($sort_type == 1)//价格升序
            {
                $orderBy = "  a.price ASC,";
            }
            else if ($sort_type == 2) //价格降序
            {
                $orderBy = "  a.price DESC,";
            }
            else if ($sort_type == 3) //销量降序
            {
                $orderBy = " a.bookcount DESC,";
            }
            else if ($sort_type == 4)//推荐
            {
                $orderBy = " a.recommendnum DESC,";
            }
            /*  else if($sortType==5) //满意度
              {
                  $orderBy = " a.shownum desc,";
              }*/
        }

        //按属性
        if (!empty($attr_id))
        {

            $where .= self::get_attr_where($attr_id);
        }
        //按关键词
        if (!empty($keyword))
        {
            $value_arr[':keyword'] = '%' . $keyword . '%';
            $where .= " AND a.title like :keyword ";
        }

        $offset = (intval($page) - 1) * $pagesize;

        $orderBy = empty($orderBy) ? " IFNULL(b.displayorder,9999) ASC, " : $orderBy;

        //如果选择了目的地
        if (!empty($destId))
        {
            $sql = "SELECT a.* FROM `sline_spot` a ";
            $sql .= "LEFT JOIN `sline_kindorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=" . self::$_typeid . " AND a.webid=b.webid AND b.classid='$destId')";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy} IFNULL(b.displayorder,9999) ASC, a.modtime DESC,a.addtime DESC ";
            //$sql.= "LIMIT {$offset},{$pagesize}";

        }
        else
        {
            $sql = "SELECT a.* FROM `sline_spot` a ";
            $sql .= "LEFT JOIN `sline_allorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=" . self::$_typeid . " AND a.webid=b.webid)";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy} IFNULL(b.displayorder,9999) ASC, a.modtime DESC,a.addtime DESC ";


        }

        //计算总数
        $totalSql = "SELECT count(*) as dd " . strchr($sql, " FROM");
        $totalSql = str_replace(strchr($totalSql, "ORDER BY"), '', $totalSql);//去掉order by


        $totalN = DB::query(1, $totalSql)->parameters($value_arr)->execute()->as_array();
        $totalNum = $totalN[0]['dd'] ? $totalN[0]['dd'] : 0;

        //数据量大时的优化方法,数据量小时不推荐使用此方法
        //$idWhere = "SELECT id FROM `sline_line` ORDER BY id limit $offset, 1";
        //$sql = str_replace("WHERE","WHERE a.id>($idWhere) AND",$sql);
        //$sql.= "LIMIT {$pagesize}";

        //检测页面数量是否超限
        $total_page = (int)ceil($totalNum / $pagesize);
        if (($total_page > 0 AND intval($page) > $total_page) OR ($total_page == 0 AND $page > 1))
        {
            $status = false;
        }


        $sql .= "LIMIT {$offset},{$pagesize}";

        $arr = DB::query(1, $sql)->parameters($value_arr)->execute()->as_array();
        foreach ($arr as &$v)
        {
            $v['price'] = Model_Spot::get_minprice($v['id'], $v);
            $v['price'] = $v['price']['price'];
            $v['attrlist'] = Model_Spot::spot_attr($v['attrid']);
            $v['commentnum'] = Model_Comment::get_comment_num($v['id'], self::$_typeid); //评论次数
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], self::$_typeid) + intval($v['bookcount']); //销售数量
            $v['litpic'] = Common::img($v['litpic']);
            $v['litpic'] = Model_Api_Standard_System::reorganized_resource_url($v['litpic']);
            $v['iconlist'] = Product::get_ico_list($v['iconlist']);
            $v['score'] = St_Functions::get_satisfy(self::$_typeid, $v['id'], $v['satisfyscore']);
        }
        $out = array(
            'row_count' => $totalNum,
            'list' => $arr,
            'status' => $status
        );
        return $out;

    }

    /**
     * @desc 景点详情
     * @param $id
     * @return array
     */
    public static function detail($id)
    {
        if($id)
        {
            $info = DB::select()->from('spot')->where('id','=',$id)->execute()->current();
            //seo
            $seo_info = Product::seo($info);

            $info['seo_info'] = $seo_info;
            //产品图片
            $piclist = Product::pic_list($info['piclist']);
            $p = array();
            foreach($piclist as &$pic)
            {
                $pi = Model_Api_Standard_System::reorganized_resource_url($pic[0]);
                array_push($p,$pi);
            }
            $info['pic_list'] = $p;
            //属性列表
            $info['attr_list'] = Model_Spot::spot_attr($info['attrid']);

            $info['price'] = Model_Spot::get_minprice($info['id'], array('info' => $info));

            //点评数
            $info['comment_num'] = Model_Comment::get_comment_num($info['id'], self::$_typeid);
            //销售数量
            $info['sell_num'] = Model_Member_Order::get_sell_num($info['id'], self::$_typeid) + intval($info['bookcount']);
            //产品编号
            $info['series'] = St_Product::product_series($info['id'], self::$_typeid);
            //产品图标
            $info['icon_list'] = Product::get_ico_list($info['iconlist']);

            //满意度
            $info['score'] = St_Functions::get_satisfy(self::$_typeid, $info['id'], $info['satisfyscore']);

            $info['litpic'] = Model_Api_Standard_System::reorganized_resource_url($info['litpic']);

            $info['basehost'] = $GLOBALS['cfg_basehost'];

            //扩展字段信息
            $extend_info = ORM::factory('spot_extend_field')
                ->where("productid=" . $info['id'])
                ->find()
                ->as_array();
            $info['extend_info'] = $extend_info;

            //套餐信息
            $info['suit_list'] = self::suit($info['id']);

            //景点详情内容
            $params = array(
                'typeid' => self::$_typeid,
                'productinfo' => $info,
                'onlyrealfield' => 1,
                'pc' => 0

            );
            $info['introduce_list'] = self::get_detail_content($params);
            return $info;
        }
        else
        {
            return array();
        }

    }

    /**
     * @desc 栏目信息
     * @return mixed
     */
    public static function channel()
    {
        $row = DB::select()->from('nav')->where('typeid','=',self::$_typeid)->and_where('issystem','=',1)->execute()->current();
        return $row;
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
     * @desc 获取景点套餐列表
     * @param $productid
     * @return mixed
     */
    private static function suit($productid)
    {
        $pay_name = array(
            '1' => '全款支付',
            '2' => '定金支付',
            '3' => '二次确认'
        );

        $suit = DB::select()->from('spot_ticket')
            ->where('spotid','=',$productid)
            ->order_by('displayorder','ASC')
            ->execute()
            ->as_array();
        foreach ($suit as &$r)
        {
            $beforBook = array(
                'ticketid' => $r['id'],
                'info' => $r
            );
            $r['price'] = Model_Spot::get_minprice($r['spotid'], $beforBook);
            $r['paytype_name'] = $pay_name[$r['paytype']];
        }
        return $suit;
    }

    /**
     * @desc 获取景点详细内容
     * @param $params
     * @return array
     */
    private static function get_detail_content($params)
    {

        $default = array(
            'typeid' => self::$_typeid,
            'productinfo' => 0,
            'onlyrealfield' => 1,
            'pc' => 0

        );
        $params = array_merge($default, $params);
        extract($params);
        $arr = DB::select()->from('spot_content')
            ->where('webid','=',0)
            ->and_where('isopen','=',1)
            ->order_by('displayorder','ASC')
            ->execute()
            ->as_array();

        //扩展表数据
        $productid = $productinfo['id'];//产品id
        $ar = DB::select()->from('spot_extend_field')->where('productid','=',$productid)->execute()->as_array();

        $list = array();
        foreach ($arr as $v)
        {
            if ($v['columnname'] == 'tupian')
            {
                continue;
            }
            if ($v['isrealfield'] == 1)
            {
                $content = !empty($productinfo[$v['columnname']]) ? $productinfo[$v['columnname']] : $ar[0][$v['columnname']];
                $content = $content ? $content : '';
            }
            if (empty($content))
            {
                continue;
            }

            $a = array();
            $a['columnname'] = $v['columnname'];
            $a['chinesename'] = $v['chinesename'];

            $a['content'] = Model_Api_Standard_Xcx::filter_content($content);
            $list[] = $a;

        }
        return $list;
    }

    /**
     * @function 热门目的地
     * @param int $offset
     * @param int $row
     * @return mixed
     */
    public static function hot_dest($offset=0,$row=20)
    {
        $table = 'sline_spot_kindlist';
        $sql = "SELECT a.id,a.kindname,a.pinyin FROM `sline_destinations` a LEFT JOIN ";
        $sql .= "`$table` b ON (a.id=b.kindid AND IFNULL(b.ishot,0)=1) ";
        $sql .= "WHERE FIND_IN_SET(5,a.opentypeids) AND IFNULL(b.ishot,0)=1 AND a.isopen=1 ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) ASC ";
        $sql .= "LIMIT $offset,$row";
        $arr = DB::query(1,$sql)->execute()->as_array();
        return $arr;
    }

    /**
     * @function 按词搜索目的地
     * @param $keyword
     * @return mixed
     */
    public static function search_dest($keyword)
    {
        $arr = DB::select()->from('destinations')->where('isopen','=',1)->and_where('kindname','like',"%$keyword%")
            ->and_where(DB::expr('FIND_IN_SET(5,opentypeids)'),'>',0)
            ->execute()
            ->as_array();
        return $arr;
    }




}