<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Article extends ORM {

    protected  $_table_name = 'article';

	 private static $typeid = 4;
    private static $basefield ='a.id as articleid,
                                a.webid,
                                a.aid,
                                a.title,
                                a.seotitle,
                                a.comefrom,
                                a.fromsite,
                                a.author,
                                a.content,
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
    
	public function delete_clear()
	{
		 $this->delete();
	}
	
   

    /**
     * @param $aid
     * @return mixed
     * 文章详情 by aid
     */
    public static function detail_aid($aid)
    {
        $sql = "SELECT * FROM sline_article ";
        $sql .= "WHERE webid={$GLOBALS['sys_webid']} AND ishidden=0 AND aid={$aid} ";
        $sql .= "limit 1";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr[0];
    }
    /**
     * 扩展字段
     * @param $id
     * @return mixed
     */
    public static function extend($id)
    {
        $sql = "SELECT * FROM sline_article_extend_field ";
        $sql .= "WHERE productid={$id}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }

    /**
     * @param $type
     * @param $id
     * @return array
     * 获取上一条,下一条
     */
    public static function get_prev_next($type,$id)
    {

        if($type == 'prev')
        {
            $sql = "SELECT aid,title,webid FROM `sline_article` WHERE id<$id and ishidden=0 ORDER BY id DESC LIMIT 1";

        }
        else if($type == 'next')
        {
            $sql = "SELECT aid,title FROM `sline_article` WHERE id>$id and ishidden=0 ORDER BY id ASC LIMIT 1";
        }
        $row = DB::query(1,$sql)->execute()->current();
        if(!empty($row['aid']))
        {
            $row['url'] = Common::get_web_url($row['webid']).'/raiders/show_'.$row['aid'].'.html';
        }
        else
        {
            $row = array();
        }

        return $row;

    }
    /**
     * 属性
     * @param $attrid
     * @return array
     */
    public static function attr($attrid)
    {
        if (empty($attrid))
        {
            return;
        }
        $attrid = trim($attrid,',');
        $arr = DB::select('attrname')->from('article_attr')->where("id in({$attrid}) and pid!=0")->execute()->as_array();
        return $arr;
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
    * 搜索
    * */
    public static function search_article($destid, $attrid, $keyword, $offset, $row, $havepic, $sorttype)
    {
        $ordertable = empty($destid) ? 'sline_allorderlist' : 'sline_kindorderlist';

        $sql = "SELECT ".self::$basefield." FROM `sline_article` a ";
        $sql.= "LEFT JOIN `{$ordertable}` b ";
        $sql.= "ON (a.id=b.aid and b.typeid=4) ";
        $sql.= "WHERE a.ishidden=0 ";
        if(!empty($destid))
            $sql.= "AND FIND_IN_SET($destid,a.kindlist) ";
        if(!empty($attrid)){
            $attrid=explode('_',$attrid);
            foreach($attrid as $value){
                if($value)
                {
                    $sql.= "AND FIND_IN_SET($value,a.attrid) ";
                }
            }
        }
        if(!empty($keyword))
            $sql.= "AND a.title like '%{$keyword}%' ";
        if($havepic)
            $sql.= "AND a.litpic<>'' ";
        if(empty($sorttype))
            $sql.= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        else if($sorttype == "1")
            $sql.= "ORDER BY IFNULL(a.shownum,0) DESC ";
        else if($sorttype == "2")
            $sql.= "ORDER BY a.modtime desc,a.addtime DESC ";
        $sql.= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;
    }

    /*
 * 获得附加信息
 * */
    public static function get_article_attachinfo($list)
    {
        //对获取的数据进行初始化处理
        foreach($list as &$v)
        {
            $v['commentnum'] = Model_Comment::get_comment_num($v['articleid'],4); //评论次数
            //$v['sellnum'] = Model_Member_Order::get_sell_num($v['id'],2)+intval($v['bookcount']); //销售数量
            //$v['sellprice'] = Model_Hotel::get_sellprice($v['id']);//挂牌价
            //$v['price'] = Model_Hotel::get_minprice($v['id']);//最低价
            $v['lastdest']= Model_Destinations::get_last_dest($v['kindlist']);//最低层目的地
            $v['finaldest'] = DB::select()->from('destinations')->where('id','=',$v['finaldestid'])->execute()->current();
            $v['attrlist'] = Model_Article_Attr::get_attr_list($v['attrid']);//属性列表.
            $v['url'] = Common::get_web_url($v['webid']) . "/raiders/show_{$v['aid']}.html";
        }
        return $list;
    }

    /*
* 获得详细信息
* */
    public static function get_article_details($webid, $aid)
    {
        $sql = "SELECT ".self::$basefield.",b.* FROM `sline_article` a ";
        $sql.= "LEFT JOIN `sline_article_extend_field` b ";
        $sql.= "ON (a.id=b.productid) ";
        $sql.= "WHERE a.ishidden=0 AND a.aid={$aid} AND webid={$webid}";

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

    //------------------------以下是搜索页新增加使用函数-----------------

    /**
     * 参数解析
     * @param $params
     */
    public static function search_result($params,$keyword,$currentpage,$pagesize='10')
    {
        $destPy = $params['destpy'];
        $attrId = $params['attrid'];
        $page = $currentpage;
        $page = $page ? $page : 1;

        $value_arr = array();
        $where = ' WHERE a.ishidden=0 ';
        $where = " WHERE a.ishidden=0 ";
        //按目的地搜索
        if($destPy && $destPy!='all')
        {
            $destId = DB::select('id')->from('destinations')->where('pinyin','=',$destPy)->execute()->get('id');
            $where.= " AND FIND_IN_SET('$destId',a.kindlist) ";
        }
        //关键词
        if(!empty($keyword))
        {
            $where.= " AND a.title like :keyword ";
            $value_arr[':keyword'] = '%'.$keyword.'%';
        }
        //按属性
        if(!empty($attrId))
        {
            $where.= Product::get_attr_where($attrId);
        }

        $offset = (intval($page)-1)*$pagesize;

        //如果选择了目的地
        if(!empty($destId))
        {
            $sql = "SELECT a.* FROM `sline_article` a ";
            $sql.= "LEFT JOIN `sline_kindorderlist` b ";
            $sql.= "ON (a.id=b.aid AND b.typeid=".self::$typeid." AND a.webid=b.webid AND b.classid=$destId)";
            $sql.= $where;
            $sql.= "ORDER BY IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
            //$sql.= "LIMIT {$offset},{$pagesize}";

        }
        else
        {
            $sql = "SELECT a.* FROM `sline_article` a ";
            $sql.= "LEFT JOIN `sline_allorderlist` b ";
            $sql.= "ON (a.id=b.aid AND b.typeid=4 AND a.webid=b.webid)";
            $sql.= $where;
            $sql.= "ORDER BY IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
            //$sql.= "LIMIT {$offset},{$pagesize}";


        }
        //计算总数
        $totalSql = "SELECT count(*) as dd ".strchr($sql," FROM");
        $totalSql = str_replace(strchr($totalSql,"ORDER BY"),'', $totalSql);//去掉order by


        $totalN = DB::query(1,$totalSql)->parameters($value_arr)->execute()->get('dd');
        $totalNum = $totalN ? $totalN : 0;

        $sql.= "LIMIT {$offset},{$pagesize}";
        $arr = DB::query(1,$sql)->parameters($value_arr)->execute()->as_array();
        foreach($arr as &$v)
        {
            $v['commentnum'] = Model_Comment::get_comment_num($v['id'],self::$typeid); //评论次数
            $v['attrlist'] = Model_Article_Attr::get_attr_list($v['attrid']);//属性列表.
            $v['url'] = Common::get_web_url($v['webid']) . "/raiders/show_{$v['aid']}.html";
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
    public static function get_search_url($v,$paramname,$p,$currentpage=1)
    {

        $url = $GLOBALS['cfg_basehost'].'/raiders/';
        switch($paramname)
        {
            case "destpy":
                $url.=$v.'-'.$p['sorttype'].'-'.$p['attrid'].'-'.$currentpage;
                break;
            case "sorttype":
                $url.=$p['destpy'].'-'.$v.'-'.$p['attrid'].'-'.$currentpage;
                break;
            case "attrid":
                $orignalArr = Product::get_attr_parent($p['attrid'],self::$typeid);
                $nowArr = Product::get_attr_parent($v,self::$typeid);
                if(!empty($nowArr))
                {
                    $attrArr = $nowArr + $orignalArr;
                    sort($attrArr);
                    $attr_list = join('_',$attrArr);
                }
                else
                {
                    $attr_list = 0;
                }
                $url.=$p['destpy'].'-'.$p['sorttype'].'-'.$attr_list.'-'.$currentpage;
                break;

        }
        return $url;


    }

    /**
     * @param $p
     * @return array
     * @desc 已选择项处理
     */
    public static function get_selected_item($p)
    {
        $p['displaytype'] = 0;
        $out = array();
        //目的地
        if($p['destpy']!='all')
        {
            $temp = array();
            $url = self::get_search_url('all','destpy',$p);
            $temp['url'] = $url;
            $dest= DB::select()->from('destinations')->where('pinyin','=',$p['destpy'])->execute()->current();
            if(empty($dest['iswebsite'])){
                $temp['itemname']=$dest['kindname'];
                $out[]=$temp;
            }
        }


        //属性
        if($p['attrid']!=0)
        {
            $attArr = $orgArr = explode('_',$p['attrid']);
            foreach($attArr as $ar)
            {

                $orgArr = $attArr;
                $temp = array();
                $temp['itemname'] = DB::select('attrname')->from('article_attr')->where('id','=',$ar)->execute()->get('attrname');
                unset($orgArr[array_search($ar,$orgArr)]);
                if (!empty($orgArr))
                {
                    $attrid = implode('_', $orgArr);
                }
                else
                {
                    $attrid = 0;
                }

                $url = $GLOBALS['cfg_basehost'].'/raiders/';
                $url.=$p['destpy'].'-'.$p['sorttype'].'-'.$attrid.'-1';
                $temp['url'] = $url;
                $out[] = $temp;
            }

        }
        return $out;

    }



    /**
     * @param $param
     * @return string
     * @desc 生成优化标题
     */
    public static function gen_seotitle($param)
    {
        $main_items=array();
        $normal_items = array();
        if(!empty($param['p']))
        {
            $p = intval($param['p']);
            if($p>1)
            {
                $arr[] = '第'.$p.'页';
            }
        }

        if(!empty($param['destpy']) && $param['destpy']!='all')
        {
            $destInfo = Model_Destinations::search_seo($param['destpy'],self::$typeid);
            $normal_items[] = $destInfo['seotitle'];
        }
        if(!empty($param['keyword']))
        {
            $normal_items[] ='关于'.$param['keyword'].'的搜索结果';
        }
        if(!empty($param['attrid']))
        {
            $normal_items[] = Model_Article_Attr::get_attrname_list($param['attrid'],'|');

        }
        $normal_items_str = implode('|',$normal_items);
        if(!empty($normal_items_str))
        {
            $main_items[]=$normal_items_str;
        }
       /* if(!empty($param['channel_name']) && empty($destInfo['seotitle']))
        {
            $main_items[]=$param['channel_name'];
        }*/
        $main_items[] = $GLOBALS['cfg_webname'];

        $main_items_str = implode('-',$main_items);
        return $main_items_str;



    }

    //获取当前选择的线路目的地优化信息
    public static function get_dest_info($destid)
    {
        $file=SLINEDATA."/autotitle.cache.inc.php"; //载入智能title配置
        if(file_exists($file))
        {
            require_once($file);
        }
        $arr=array();
        if($destid)
        {

            $sql="SELECT a.kindname,b.seotitle,b.jieshao,b.keyword,b.tagword,b.description,a.pinyin FROM `sline_destinations` as a left join `sline_article_kindlist` AS b ON a.id=b.kindid WHERE a.id = $destid ";
        }
        $row = DB::query(1,$sql)->execute()->current();

        $cfg_article_title=str_replace('XXX',$row['kindname'],$cfg_article_title);
        $cfg_article_desc=str_replace('XXX',$row['kindname'],$cfg_article_desc);
        if(empty($row['seotitle']))
        {

            $arr['seotitle']=empty($cfg_article_title) ? $row['kindname'] : $cfg_article_title;
        }
        else
        {
            $arr['seotitle']=$row['seotitle'];

        }
        if(empty($row['description']))
        {
            $arr['description']=empty($cfg_article_desc) ? $row['description'] : $cfg_article_desc;
        }
        else
        {
            $arr['description']=$row['description'];
        }


        $arr['typename']=$row['kindname'];
        $arr['dest_jieshao']=$row['jieshao'];
        $arr['dest_name'] = $row['kindname'];
        $arr['kindid'] = $destid;
        $arr['dest_id'] = $destid;
        $arr['dest_pinyin'] = $row['pinyin'];
        $arr['tagword']=$row['tagword'];
        $arr['keyword']=!empty($row['keyword'])?"<meta name=\"keywords\" content=\"".$row['keyword']."\"/>":"";
        $arr['description']=!empty($arr['description'])?"<meta name=\"description\" content=\"".$arr['description']."\"/>":"";
        $arr['pinyin'] = $row['pinyin'];
        return $arr;
    }
}