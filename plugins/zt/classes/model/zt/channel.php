<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Zt_Channel extends ORM
{

    //删除数据
    public function delete_clear()
    {
        //清除产品
        $all_product = ORM::factory('zt_channel_product')->where("channelid={$this->id}")->find_all()->as_array();
        foreach ($all_product as $p)
        {
            $p->delete_clear();
        }
        //清除优惠券
        $all_coupon = ORM::factory('zt_channel_coupon')->where("channelid={$this->id}")->find_all()->as_array();
        foreach ($all_coupon as $c)
        {
            $c->delete_clear();
        }
        $this->delete();
    }

    /**
     * @function 栏目信息
     * @param $channelid
     * @return mixed
     */
    public function detail($channelid)
    {
        $row = DB::select()->from('zt_channel')->where('id','=',$channelid)->execute()->current();
        return $row;
    }

    /**
     *
     * @param string $ztid
     * @return int|ORM
     */
    public function add($ztid)
    {
        $data = array(
            'ztid'=>$ztid,
            'title'=>'自定义',
            'introduce'=>''
        );
        $result = DB::insert('zt_channel',array_keys($data))->values(array_values($data))->execute();
        return $result[0] ? $result[0] : 0;
    }


    /**
     * @function 更新专题栏目信息表
     * @param Validation $post
     * @return ORM|void
     */
    public function update($post)
    {
        $channelname_arr = $post['channelname'];
        $displayorder_arr = $post['displayorder'];
        $isopen_arr = $post['isopen'];
        $channel_introduce_arr = $post['channel_introduce'];
        $kindtype_arr = $post['kindtype'];
        $moreurl_arr = $post['moreurl'];
        foreach($channelname_arr as $key=>$v)
        {
            $data = array(
                'title' => $v,
                'displayorder' => $displayorder_arr[$key],
                'isopen' => $isopen_arr[$key],
                'introduce' => $channel_introduce_arr[$key],
                'kindtype'  => $kindtype_arr[$key],
                'moreurl'   => $moreurl_arr[$key]
            );
            DB::update('zt_channel')->set($data)->where('id','=',$key)->execute();
        }


    }

    /***********************************前端调用***************************************************/

    public static function get_channel_list($ztid)
    {
        $arr = DB::select()->from('zt_channel')
            ->where('ztid','=',$ztid)
            ->and_where('isopen','=',1)
            ->order_by('displayorder','ASC')->execute()->as_array();
        foreach($arr as &$row)
        {
            //优惠券
            if($row['kindtype'] == 1)
            {
                $row['productlist'] = Model_Zt_Channel_Coupon::get_coupon($row['id'],1,16);
            }
            //产品陈列 or 文章列表
            else
            {
                $row['productlist'] = Model_Zt_Channel_Product::get_product($row['id'],1,16);
            }
        }
        return $arr;
    }

    /**
     * @function 是否存在优惠券栏目
     * @param $ztid
     * @return int
     */
    public static function is_exist_coupon_channel($ztid)
    {
        $id = DB::select()->from('zt_channel')
            ->where('ztid','=',$ztid)
            ->and_where('kindtype','=',1)
            ->and_where('isopen','=',1)
            ->execute()->get('id');
        return $id ? 1 : 0;
    }




    



}