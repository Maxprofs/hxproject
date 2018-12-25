<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Class Model_Visa 签证模块
 */
class Model_Visa extends ORM
{
    public function delete_clear()
    {
        Common::deleteRelativeImage($this->litpic);
        $this->delete();
    }

    /**
     * @function 获取签证的最低价
     * @param $lineid
     * @param array $params
     * @return number
     */
    public static function get_minprice($visaid, $params = array())
    {
        $price = DB::select('price')->from('visa')->where('id','=',$visaid)->execute()->get('price');
        return Currency_Tool::price($price);
    }
    /**
     * 签证
     * @param $kind 目的地
     * @param $city 签发城市
     * @param $p 分页
     * @return mixed
     */
    public static function parse_url($kind, $city, $p,$visatype='')
    {
        $field = 'a.id,a.aid,a.title,a.handleday,a.price,a.litpic,a.cityid,a.bookcount,a.satisfyscore,a.recommendnum';
        $where = "a.webid=0 AND a.ishidden=0 ";
        if ($kind != 'all')
        {
            $where .= 'And  b.pinyin=:pinyin ';
        }
        $value_arr[':pinyin'] = $kind;
        if (!empty($city))
        {
            $where .= " And a.cityid=:cityid";
            $value_arr[':cityid'] = $city;
        }
        if(!empty($visatype))
        {
            $where .= " and a.visatype=:visatype";
            $value_arr[':visatype'] = $visatype;
        }

        $offset = ($p - 1) * 10;
        $sql = "SELECT {$field} FROM sline_visa AS a LEFT JOIN sline_visa_area AS b ON a.nationid=b.id LEFT JOIN `sline_allorderlist` c ON (a.id=c.aid AND c.typeid=8 AND a.webid=c.webid)  ";
        $sql .= "WHERE {$where} ";
        $sql .= "ORDER BY IFNULL(c.displayorder,9999) ASC,a.id DESC ";
        $sql .= "LIMIT {$offset},10";
        $arr = DB::query(1, $sql)->parameters($value_arr)->execute()->as_array();

        foreach ($arr as &$v)
        {
            $v['price'] = Currency_Tool::price($v['price']);
        }
        return $arr;
    }

    /**
     * 手机端解析url
     */
    public static function parse_url_mobile($data)
    {
        $filed = 'a.id,a.aid,a.title,a.handleday,a.price,a.litpic,a.cityid';
        if ($data['area'] != 'all' && $data['area'])
        {
            $area = is_int($data['area']) ? "And b.id={$data['area']}" : "And b.pinyin='{$data['area']}'";
        }
        $where = " a.ishidden=0 {$area}";
        if (!empty($data['cityid']))
        {
            $where .= " And a.cityid={$data['cityid']}";
        }
        $offset = ($data['page'] - 1) * 10;
        $sql = "SELECT {$filed} FROM sline_visa AS a LEFT JOIN sline_visa_area AS b ON a.nationid=b.id ";
        $sql .= "WHERE {$where} ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
        $sql .= "LIMIT {$offset},10";
        $arr = DB::query(1, $sql)->execute()->as_array();
        foreach($arr as &$v)
        {
            $v['price'] = Currency_Tool::price($v['price']);
            $v['dingjin'] = Currency_Tool::price($v['dingjin']);
        }
        return $arr;
    }

    /**
     * 签发目的地
     * @param $pinyin
     * @param string $filed
     * @return mixed
     */
    public static function vias_area($pinyin, $field = 'pinyin')
    {
        $sql = "SELECT * FROM sline_visa_area WHERE webid=0 AND isopen=1 AND {$field}='{$pinyin}' LIMIT 1";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr[0];
    }

    public static function vias_area_by_id($pid, $pagesize = 60)
    {
        $pid = intval($pid);
        $pagesize = intval($pagesize);
        $sql = "SELECT * FROM sline_visa_area WHERE isopen=1 AND pid='{$pid}' LIMIT 0,$pagesize";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }

    /**
     * 签发城市
     * @return mixed
     */
    public static function visa_city()
    {
        $sql = "SELECT * FROM sline_visa_city where isopen=1";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }

    /**
     * 根据id获取签发城市
     * @param $cityid
     */
    public static function visa_city_by_id($cityid)
    {
        if (empty($cityid))
        {
            return;
        }
        $cityid = intval($cityid);
        $sql = "SELECT kindname FROM sline_visa_city WHERE isopen=1 AND id={$cityid}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr[0];
    }

    /**
     * 签证详情 BY aid
     * @param $aid
     * @return mixed
     */
    public static function visa_detail($aid)
    {
        $aid = intval($aid);
        $sql = "SELECT * FROM sline_visa WHERE webid={$GLOBALS['sys_webid']}  AND aid={$aid}";
        $arr = DB::query(1, $sql)->execute()->as_array();

        $arr[0]['price'] = Currency_Tool::price($arr[0]['price']);
        $arr[0]['marketprice'] = Currency_Tool::price($arr[0]['marketprice']);
        $arr[0]['dingjin'] = Currency_Tool::price($arr[0]['dingjin']);

        return $arr[0];
    }

    /**
     * 签证详情 BY id
     * @param $id
     * @return mixed
     */
    public static function visa_detail_id($id)
    {
        $id = intval($id);
        $sql = "SELECT * FROM sline_visa WHERE  ishidden=0 AND id={$id}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        $arr[0]['price'] = Currency_Tool::price($arr[0]['price']);
        $arr[0]['marketprice'] = Currency_Tool::price($arr[0]['marketprice']);
        $arr[0]['dingjin'] = Currency_Tool::price($arr[0]['dingjin']);
        return $arr[0];
    }

    /**
     * 签证扩展字段
     * @param $id
     * @return mixed
     */
    public static function visa_extend($id)
    {
        $sql = "SELECT * FROM sline_visa_extend_field WHERE productid='".$id."'";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }

    /**
     * 团购属性
     * @param $attrid
     * @return array
     */
    public static function attr($attrid)
    {
        if (empty($attrid))
        {
            return;
        }
        $attrid = trim($attrid, ',');
        $arr = DB::select('attrname')->from('visa_attr')->where("id in({$attrid}) and pid!=0")->execute()->as_array();
        return $arr;
    }


    /**
     * 参数解析
     * @param $params
     */
    public static function search_result($params, $keyword, $currentpage, $pagesize = '10')
    {
        $countryPy = $params['countrypy'];
        $cityId = intval($params['cityid']);
        $sortType = intval($params['sorttype']);
        $visaTypeid = intval($params['visatypeid']);
        $page = $currentpage;
        $page = $page ? $page : 1;
        $where = ' WHERE a.ishidden=0 ';
        $value_arr = array();
        //签证城市条件
        if (!empty($cityId))
        {
            $where .= " AND cityid='$cityId'";
        }
        //签证类型
        if (!empty($visaTypeid))
        {
            $where .= " AND visatype='$visaTypeid'";
        }
        //按国家
        if (!empty($countryPy))
        {
            $nationid = DB::select('id')->from('visa_area')->where('pinyin', '=', $countryPy)->execute()->get('id');
            $where .= " AND nationid='$nationid'";
        }
        //排序
        $orderBy = "";
        if (!empty($sortType))
        {
            if ($sortType == 1)//价格升序
            {
                $orderBy = "  a.price DESC,";
            }
            else if ($sortType == 2) //价格降序
            {
                $orderBy = "  a.price ASC,";
            }
            else if ($sortType == 3) //销量降序
            {
                $orderBy = " a.bookcount DESC,";
            }
            else if ($sortType == 4)//推荐
            {
                $orderBy = " a.shownum DESC,";
            }
        }
        //关键词
        if (!empty($keyword))
        {
            $where .= " AND a.title like :keyword ";
            $value_arr[':keyword'] = '%' . $keyword . '%';
        }
        $offset = (intval($page) - 1) * $pagesize;

        $sql = "SELECT a.* FROM `sline_visa` a LEFT JOIN `sline_allorderlist` b ON (a.id=b.aid AND b.typeid=8 AND a.webid=b.webid) ";
        $sql .= "{$where} ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) ASC,{$orderBy} a.modtime DESC,a.addtime DESC ";

        //计算总数
        $totalSql = "SELECT count(*) as dd " . strchr($sql, " FROM");
        $totalSql = str_replace(strchr($totalSql, "ORDER BY"), '', $totalSql);//去掉order by


        $totalN = DB::query(1, $totalSql)->parameters($value_arr)->execute()->as_array();
        $totalNum = $totalN[0]['dd'] ? $totalN[0]['dd'] : 0;

        $sql .= "LIMIT {$offset},{$pagesize}";
        $arr = DB::query(1, $sql)->parameters($value_arr)->execute()->as_array();
        foreach ($arr as &$v)
        {
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], 8) + intval($v['bookcount']); //销售数量
            $v['url'] = Common::get_web_url($v['webid']) . "/visa/show_{$v['aid']}.html";
            $v['iconlist'] = Product::get_ico_list($v['iconlist']);
            $v['visatype'] = DB::select('kindname')->from('visa_kind')->where('id', '=', $v['visatype'])->execute()->get('kindname');
            $v['price'] = Currency_Tool::price($v['price']);
            $v['marketprice'] = Currency_Tool::price($v['marketprice']);
        }
        $out = array(
            'total' => $totalNum,
            'list' => $arr

        );
        return $out;

    }

    /*
    * 生成searh页地址
    * */
    public static function get_search_url($v, $paramname, $p, $currentpage = 1)
    {

        $url = $GLOBALS['cfg_basehost'] . '/visa/';
        switch ($paramname)
        {

            case "cityid":
                $url .= $p['countrypy'] . '-' . $v . '-' . $p['sorttype'] . '-';
                $url .= $p['visatypeid'] . '-' . $currentpage;
                break;
            case "sorttype":
                $url .= $p['countrypy'] . '-' . $p['cityid'] . '-' . $v . '-';
                $url .= $p['visatypeid'] . '-' . $currentpage;
                break;
            case "visatypeid":
                $url .= $p['countrypy'] . '-' . $p['cityid'] . '-' . $p['sorttype'] . '-';
                $url .= $v . '-' . $currentpage;
                break;
        }
        return $url;


    }

    /**
     * @param $param
     * @return string
     * @desc 生成优化标题
     */
    public static function gen_seotitle($param)
    {
        $arr = array();
        if (!empty($param['p']))
        {
            $p = intval($param['p']);
            if ($p > 1)
            {
                $arr[] = '第' . $p . '页';
            }
        }
        if (!empty($param['keyword']))
        {
            $arr[] = '关于' . $param['keyword'] . '的搜索结果';
        }
        if (!empty($param['countrypy']))
        {
            $countryInfo = self::vias_area($param['countrypy']);
            $arr[] = $countryInfo['seotitle'] ? $countryInfo['seotitle'] : $countryInfo['kindname'];
        }
        if (!empty($param['cityid']))
        {
            $arr[] = ORM::factory('visa_city', $param['cityid'])->get('kindname') . "办理";

        }
        if (!empty($param['visatypeid']))
        {
            $arr[] = ORM::factory('visa_kind', $param['visatypeid'])->get('kindname');

        }
        return implode('_', $arr);


    }


    //库存操作
    public static function storage($suitid, $number, $day)
    {

        return true;

    }

    /**
     * 搜索页标题
     * @param $destpy
     * @return array
     */
    public static function search_seo($destpy)
    {
        $data = array();
        if (!empty($destpy) && $destpy != 'all')
        {
            $info = DB::select()->from('visa_area')->where("pinyin='{$destpy}' AND isopen=1")->execute()->current();
            $seotitle = $info['seotitle'] ? $info['seotitle'] : $info['kindname'];
        }
        if (isset($seotitle) && !empty($seotitle))
        {
            $data[] = $seotitle;
        }
        $info = Model_Nav::get_channel_info_mobile(8);
        $data[] = $info['seotitle'] ? $info['seotitle'] : $info['m_title'];
        return array('seotitle' => implode('_', $data));
    }

    /**
     * 搜索页标题
     * @param $destpy
     * @return array
     */
    public static function search_seo_mobile($destpy)
    {
        $data=array();
        if (!empty($destpy) && $destpy != 'all')
        {
            $info = DB::select()->from('visa_area')->where("pinyin='{$destpy}' AND isopen=1")->execute()->current();
            $seotitle = $info['seotitle'] ? $info['seotitle'] : $info['kindname'];
        }
        if (isset($seotitle) && !empty($seotitle))
        {
            $data[]=$seotitle;
        }
        $info = Model_Nav::get_channel_info_mobile(8);
        $data[] = $info['seotitle'] ? $info['seotitle'] : $info['m_title'];
        return array('seotitle' => implode('_',$data));
    }


    /**
     * @function 获取区域拼音.
     * @param $country
     * @return string
     */
    public static function get_visa_area_pinyin($country)
    {
        $row = DB::select('pinyin')->from('visa_area')->where('kindname','=',$country)->execute()->current();
        if($row)
        {
            return $row['pinyin'];
        }
        else
        {
            return Common::get_pinyin($country);
        }
    }

    /**
     * @function 克隆签证
     * @param $id
     * @param $num
     * @return mixed
     */
    public function clone_visa($id, $num)
    {
        $arr = $this->where("id=$id")->find()->as_array();
        unset($arr['id']);//去除id项.
        unset($arr['starttime']);
        unset($arr['endtime']);
        for ($i = 1; $i <= $num; $i++)
        {
            $newaid = Common::getLastAid('sline_visa', 0);//新签证aid
            $arr['aid'] = $newaid;
            $arr['addtime'] = $arr['modtime'] = time();
            $arr['webid'] = 0;
            $arr['ishidden'] = 1;
            $sql = "INSERT INTO sline_visa (";
            $sql2 = "VALUES ( ";
            $sql_key = '';
            $sql_value = '';
            foreach ($arr as $key => $value)
            {
                if (!empty($value) || $key == 'webid')
                {
                    $sql_key .= "`" . $key . "`,";
                    $sql_value .= "'" . addslashes($value) . "',";
                }
            }
            $sql_key = substr($sql_key, 0, -1) . ")";
            $sql_value = substr($sql_value, 0, -1) . ")";
            $sql = $sql . $sql_key . $sql2 . $sql_value . ";";
            $ar = $this->query($sql, 2);
            $new_visa_id = $ar[0];//新插入id
        }
        return $new_visa_id;
    }

}