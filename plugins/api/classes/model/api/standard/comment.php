<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * 评论模型
 * Class Model_Api_Standard_Comment
 */
class Model_Api_Standard_Comment
{

    /**
     * @function 获取评论列表
     * @param $typeid
     * @param $articleid
     * @param $flag
     * @param $pageno
     * @param string $pagesize
     * @return array
     */
    public static function search($typeid, $articleid, $flag, $pageno, $pagesize = '5')
    {
        $where = " WHERE isshow=1 AND typeid='{$typeid}' AND articleid='{$articleid}'";
        if ($flag == 'pic')
        {
            $where .= " AND LENGTH(TRIM(piclist))>0 ";
        }
        elseif ($flag == 'well')
        {
            $where .= " AND level in (4,5) ";
        }
        elseif ($flag == 'mid')
        {
            $where .= " AND level in (2,3) ";
        }
        elseif ($flag == 'bad')
        {
            $where .= " AND level in (1) ";
        }
        $order_by = " ORDER BY addtime DESC ";
        $sql = " SELECT * FROM sline_comment " . $where . $order_by;
        //计算总数
        $totalSql = "SELECT count(*) as dd " . strchr($sql, " FROM");
        $totalSql = str_replace(strchr($totalSql, "ORDER BY"), '', $totalSql);
        $totalN = DB::query(1, $totalSql)->execute()->as_array();
        $totalNum = $totalN[0]['dd'] ? $totalN[0]['dd'] : 0;
        $offset = ($pageno - 1) * $pagesize;
        $sql .= "LIMIT {$offset},{$pagesize}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        foreach ($arr as &$r)
        {
            if(!empty($r['memberid']))
            {
                $awardinfo = Model_Member_Order::get_award_info($r['orderid']);
                $memberinfo = Model_Member::get_member_info($r['memberid']);
                $r['jifentprice'] = $awardinfo['jifentprice'];
                $r['jifencomment'] = $awardinfo['jifencomment'];
                $r['jifenbook'] = $awardinfo['jifenbook'];
                $r['nickname'] = empty($memberinfo['nickname']) ? '匿名' : St_Functions::cutstr_html($memberinfo['nickname'], 9);
                $r['litpic'] = !empty($memberinfo['litpic']) ? $memberinfo['litpic'] : Model_Member::member_nopic();
                $r['litpic'] = Model_Api_Standard_System::reorganized_resource_url($r['litpic']);

            }
            else
            {
                $r['jifencomment'] = $r['vr_jifencomment'];
                $r['nickname'] = $r['vr_nickname'] ? $r['vr_nickname'] : '匿名';
                $r['litpic'] = $r['vr_headpic'] ? $r['vr_headpic'] : Model_Member::member_nopic();
            }
            $r['litpic'] = empty($r['litpic']) ? Model_Member::member_nopic() : $r['litpic'];
            $r['litpic'] = Model_Api_Standard_System::reorganized_resource_url($r['litpic']);
            $r['pltime'] = self::_set_addtime();
            $r['percent'] = 20 * $r['level'] . '%';

            $r['level'] = Model_Member::member_rank($r['memberid'], array('return' => 'current','vr_grade'=>$r['vr_grade']));

            $r['addtime'] = date("Y-m-d", $r['addtime']);
            //图片列表
            if (!empty($r["piclist"]))
            {
                $r['piclist'] = explode(',', $r['piclist']);
                $picthumb = array();
                foreach ($r['piclist'] as $pic)
                {
                    $picthumb[] =  Model_Api_Standard_System::reorganized_resource_url(St_Functions::img($pic, 86, 86));
                }
                $r["picthumb"] = $picthumb;
            }

            if(!empty($r['dockid']))
            {
                $p_info = DB::select('content','memberid')->from('comment')->where('id','=',$r['dockid'])->execute()->current();
                $reply = array();
                if($p_info['memberid'])
                {
                    $memberinfo = Model_Member::get_member_info($p_info['memberid']);
                    $reply['litpic'] = !empty($memberinfo['litpic']) ? $memberinfo['litpic'] : Model_Member::member_nopic();
                    $reply['litpic'] = Model_Api_Standard_System::reorganized_resource_url($reply['litpic']);
                    $reply['nickname'] = empty($memberinfo['nickname']) ? '匿名' : St_Functions::cutstr_html($memberinfo['nickname'], 10);
                }
                else
                {
                    $reply['nickname'] = '匿名';
                    $reply['litpic'] = Model_Member::member_nopic();
                    $reply['litpic'] = Model_Api_Standard_System::reorganized_resource_url($r['litpic']);
                }
                $reply['content'] = $p_info['content'];
                $r['reply'] = $reply;


            }
        }



        $out = array(
            'total' => $totalNum,
            'list' => $arr
        );
        return $out;
    }


    /**
     * 获取评论的统计信息
     * @param $typeid
     * @param $articleid
     * @return array
     */
    public static function get_count($typeid,$articleid)
    {

        //获取全部评论
        //$model = ORM::factory("model")->where("id='{$typeid}' OR pinyin='{$flag}'")->find()->as_array();
        $model = DB::select()->from('model')
            ->or_where_open()
            ->or_where('id', '=', $typeid)
            ->or_where_close()
            ->execute()
            ->current();

        if (empty($model))
        {
            return;
        }
        $table = $model['maintable'];
        $sql_product = "SELECT * FROM sline_{$table} WHERE id='{$articleid}'";
        $product = DB::query(1,$sql_product)->execute()->as_array();
        $satisfyscore = empty($product[0]['satisfyscore']) ? 0 : $product[0]['satisfyscore'];
        $count = self::_get_comment_count($typeid, $articleid, $satisfyscore);
        return $count;
    }

    /**
     * @function 随机设置评论时间
     * @return string
     */
    private static function _set_addtime()
    {
        $hour = mt_rand(0, 3);
        $minute = mt_rand(0, 60);
        $second = mt_rand(0, 60);
        $elapse = '';
        $unitArr = array(
            '年' => 'year',
            '个月' => 'month',
            '周' => 'week',
            '天' => 'day',
            '小时' => 'hour',
            '分钟' => 'minute',
            '秒' => 'second'
        );
        foreach ($unitArr as $cn => $u)
        {
            if ($$u > 0)
            {
                $elapse = $$u . $cn;
                break;
            }
        }
        return $elapse . '前';
    }


    //获取评论的汇总信息
    private static function _get_comment_count($typeid, $articleid, $satisfyscore)
    {
        $where = " WHERE typeid='{$typeid}' AND articleid='{$articleid}' AND isshow=1 AND level BETWEEN 1 AND 5 ";
        //计算图片数量
        $sql_pic = "SELECT count(1) as num FROM sline_comment {$where} and LENGTH(TRIM(piclist))>0 ";
        $arr = DB::query(1,$sql_pic)->execute()->as_array();
        $rtn['picnum'] = intval($arr[0]['num']);
        //计算等级
        $rtn = array_merge($rtn, St_Functions::get_satisfy($typeid, $articleid, $satisfyscore, array('isAll' => 1)));
        return $rtn;
    }

}