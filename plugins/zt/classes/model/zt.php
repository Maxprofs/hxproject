<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Zt extends ORM
{

    //删除数据
    public function delete_clear()
    {
        $all_channel = ORM::factory('zt_channel')->where("ztid={$this->id}")->find_all()->as_array();
        foreach ($all_channel as $channel)
        {
            $channel->delete_clear();
        }
        $this->delete();
    }

    /**
     * @function 获取支持的产品组
     * @param $kindtype
     * @return mixed
     */
    public function get_need_product($kindtype)
    {
        //过滤id,排除积分商城,结伴,问答,目的地,私人定制,游记
        $filter = array(107,10,11,12,14,101);
        $article = array(4,6);
        if($kindtype == 2)
        {
            $filter_arr = array_merge($filter,$article);
            $arr = DB::select()->from('model')->where('id','not in',$filter_arr)->and_where('isopen','=',1)->execute()->as_array();
        }
        else
        {
            $arr = DB::select()->from('model')->where('id','in',$article)->execute()->as_array();
        }
        return $arr;
    }

    /**
     * @function 获取用户模板
     * @param int $ismobile
     * @return mixed
     */
    public static function get_usertpl($ismobile=0)
    {
        $templet_dir = 'usertpl/';
        $right_table = $ismobile ? 'sline_m_page_config' : 'sline_page_config';
        $sql = "select b.path from sline_page a left join ".$right_table." b on a.id=b.pageid where a.pagename='zhuanti_show'";
        $arr = DB::query(1, $sql)->execute()->as_array();
        foreach ($arr as $key => $v)
        {

            if (!empty($v['path']) && $v['path']!=null)
            {
                $v['templetname'] = $v['path'];
                $v['path'] = $templet_dir . $v['path'];
                $arr[$key] = $v;
            }
            else
            {
                array_pop($arr);
            }

        }
        return $arr;
    }

    /**
     * @function 搜索专题列表
     * @param $params
     * @param $keyword
     * @param $page
     * @param int $pagesize
     * @return array
     */
    public static function search_result($params,$keyword,$page,$pagesize=12)
    {
        $page = intval($page);
        $pagesize = intval($pagesize);
        $page = $page<1?1:$page;
        $offset = ($page-1)*$pagesize;

        $sorttype = intval($params['sorttype']);

        $value_arr = array();

        $w = " where id!=0 ";
        //关键词
        if(!empty($keyword))
        {
            $w.= " AND a.title like :keyword ";
            $value_arr[':keyword'] = '%'.$keyword.'%';
        }

        // $order = " order by ifnull(displayorder,9999) asc ";
        //sorttype 排序方式，0表示默认排序，1表示按添加时间倒序，2表示按添加时间顺序
        switch($sorttype)
        {
            case 1:
                $order = ' order by addtime desc,ifnull(displayorder,9999) asc ';
                break;
            case 2:
                $order = ' order by addtime asc,ifnull(displayorder,9999) asc ';
                break;
            default:
                $order = ' order by ifnull(displayorder,9999) asc, addtime desc ';
        }
        $sql = "select * from sline_zt {$w} {$order} limit {$offset},{$pagesize}";
        $sql_num = "select count(*) as num from sline_zt {$w} ";
        $list = DB::query(Database::SELECT,$sql)->parameters($value_arr)->execute()->as_array();
        $num = DB::query(Database::SELECT,$sql_num)->parameters($value_arr)->execute()->get('num');

        foreach($list as &$row)
        {
            $path = !empty($row['pinyin'])?$row['pinyin']:$row['id'];
            $row['url'] = Common::get_web_url(0) .'/zt/'.$path;
        }
        $out = array(
            'total' => $num,
            'list' => $list
        );
        return $out;
    }

    /**
     * @function 获取导航信息
     * @param int $platform  0表示PC，1表示手机端
     */
    public static function get_channel_seo($platform=0)
    {
        if($platform==0)
        {
            $info = DB::select()->from('nav')->where('url','=','/zt/')->and_where('issystem','=',1)->execute()->current();
            $info['seotitle'] = empty($info['seotitle'])?$info['shortname']:$info['seotitle'];
            return $info;
        }
        else
        {
            return DB::select()->from('m_nav')->where('m_url','=','/zt/')->and_where('m_issystem','=',1)->execute()->current();
        }
    }


}