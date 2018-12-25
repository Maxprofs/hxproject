<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Line extends ORM {

    protected  $_table_name = 'line';

	public function deleteClear()
	{
		 //DB::delete('line_suit_price')->where("suitid={$this->id}")->execute();
		 $suits=ORM::factory('line_suit')->where("lineid={$this->id}")->find_all()->as_array();
		 foreach($suits as $suit)
		 {
			 $suit->deleteClear();
		 }
		/* Common::deleteRelativeImage($this->litpic);
		 $piclist=explode(',',$this->piclist);
		 foreach($piclist as $k=>$v)
		 {
			  $img_arr=explode('||',$v);
			  Common::deleteRelativeImage($img_arr[0]);
		 }*/
		 $this->delete();
	}

    /*
     * 提取景点
     * */
    public function autoGetSpot($content,$lineid,$day)
    {
        $sql="select a.id,a.aid,a.title,a.litpic,a.webid from #@__spot as a where a.litpic !='' or a.piclist !='' group by a.title";


        $arr = ORM::factory('spot')->where("litpic !='' or piclist !=''")->group_by('title')->get_all();

        $keysarrs = $picsarr = $idsarr = $orderarr = array();
        foreach($arr as $row)
        {

            array_push($keysarrs,$row['shortname']);
            array_push($picsarr,$row['litpic']);
            array_push($idsarr,$row['id']);
            array_push($orderarr,$row['displayorder']);

        }


        $k=0;

        $num = count($keysarrs);
        $out = array();

        for($i=0;$i < $num;$i++)
        {


            if(Common::checkStr($content,trim($keysarrs[$i])))//如果找到
            {

                $litpic=empty($picsarr[$i]) ? Common::getDefaultImage() : $picsarr[$i];
                $spotid=$idsarr[$i];
                $spotname=$keysarrs[$i];

                $autoid = $this->insertDaySpot($lineid,$spotname,$litpic,$day,$spotid);
                if($autoid)
                $out[]=array('title'=>$spotname,'spotid'=>$spotid,'autoid'=>$autoid);

            }
            $k++;
        }

        return $out;
    }
    //插入到景点库
    private function insertDaySpot($lineid,$spotname,$litpic,$day,$spotid)
    {

        $sql="select count(*) as num from sline_line_dayspot where lineid='$lineid' and title='$spotname' and day=$day";

        $row = $this->query($sql,1);
        $flag = 0;
        if($row[0]['num']==0)
        {
            $sql="insert into sline_line_dayspot(lineid,title,spotid,litpic,day) values('$lineid','$spotname','$spotid','$litpic','$day')";
            $ar = $this->query($sql,Database::INSERT);
            if($ar[0]>0)$flag = $ar[0];
        }
        return $flag;
    }

    //删除提取景点
    public function delDaySpot($autoid)
    {
        $sql = "delete from sline_line_dayspot where id= '$autoid'";
        $flag = $this->query($sql,3);
        return $flag;
    }

    //获取行程景点
    public static function getDaySpotHtml($day,$lineid)
    {
        $sql = "select * from sline_line_dayspot where lineid='$lineid' and day='$day'";
        $arr = DB::query(1,$sql)->execute();
        $out = '';
        foreach($arr as $row)
        {
            $out.='<span><s onclick="delDaySpot(this,\''.$row['id'].'\')"></s>'.$row['title'].'</span>';
        }
        return $out;
    }

    /**
     * @function 克隆线路
     * @param $id
     * @param $num
     * @return mixed
     */
    public function clone_line($id, $num)
    {
        $arr = $this->where("id=$id")->find()->as_array();
        unset($arr['id']);//去除id项.
        unset($arr['starttime']);
        unset($arr['endtime']);
        unset($arr['linephone']);
        unset($arr['istejia']);
        unset($arr['ssmalprovince']);
        unset($arr['ssmalcity']);
        unset($arr['ssmalarea']);
        unset($arr['price_date']);
        for ($i = 1; $i <= $num; $i++)
        {
            $newaid = Common::getLastAid('sline_line', 0);//新线路aid
            $arr['aid'] = $newaid;
            $arr['addtime'] = $arr['modtime'] = time();
            $arr['webid'] = 0;
            $arr['lineicon'] = '0';
            $arr['ishidden'] = 1;
            $arr['status'] = 0;
            $sql = "INSERT INTO sline_line (";
            $sql2 = "VALUES ( ";
            $sql_key = '';
            $sql_value = '';
            foreach ($arr as $key => $value)
            {
                if (!empty($value) || $key == 'webid' || $key == 'status')
                {
                    $sql_key .= "`" . $key . "`,";
                    $sql_value .= "'" . addslashes($value) . "',";
                }
            }
            $sql_key = substr($sql_key, 0, -1) . ")";
            $sql_value = substr($sql_value, 0, -1) . ")";
            $sql = $sql . $sql_key . $sql2 . $sql_value . ";";
            $ar = $this->query($sql, 2);
            $new_line_id = $ar[0];//新插入id
            $this->clone_jieshao($id, $new_line_id);
            $this->clone_extend_info($id, $new_line_id);
        }
        return $new_line_id;
    }
    /*
     * 克隆新版行程内容
     * */
    private function clone_jieshao($oldlineid, $newlineid)
    {
        $sql = "select * from sline_line_jieshao where lineid='$oldlineid'";
        $arr = $this->query($sql, 1);
        $intArr = array('breakfirsthas', 'supperhas', 'lunchhas');
        foreach ($arr as $row)
        {
            unset($row['id']);
            $row['lineid'] = $newlineid;
            $sql = "INSERT INTO sline_line_jieshao (";
            $sql2 = "VALUES ( ";
            $sql_key = '';
            $sql_value = '';
            foreach ($row as $key => $value)
            {
                if (in_array($key, $intArr))
                {
                    $value = empty($value) ? 0 : $value;
                }
                $sql_key .= "`" . $key . "`,";
                $sql_value .= "'" . addslashes($value) . "',";
            }
            $sql_key = substr($sql_key, 0, -1) . ")";
            $sql_value = substr($sql_value, 0, -1) . ")";
            $sql = $sql . $sql_key . $sql2 . $sql_value . ";";
            $this->query($sql, 2);
        }

    }

    public function clone_extend_info($id, $new_line_id)
    {
        $extend_info = DB::select()->from('line_extend_field')->where('productid', '=', $id)->execute()->current();
        if (empty($extend_info))
            return true;
        unset($extend_info['id']);
        $extend_info['productid'] = $new_line_id;
        $model = ORM::factory('line_extend_field');
        foreach ($extend_info as $k => $v)
        {
            $model->$k = $v;
        }
        $model->save();
        return $model->saved();
    }





    /*
    * 更新最低报价
    * */
    public static function updateMinPrice($lineid)
    {
	    $newtime = time();
        $sql = "SELECT MIN(adultprice) as price FROM sline_line_suit_price WHERE lineid='$lineid' and adultprice>0 and day>=$newtime";
        $ar = DB::query(1,$sql)->execute()->as_array();
        $price = $ar[0]['price'] ? $ar[0]['price'] : 0;
        $model = ORM::factory('line',$lineid);
        $model->price = $price;
        $model->update();


    }



    /**
     * @function 更新线路最低报价
     * @param $lineid
     */
    public static function update_min_price($lineid)
    {
        $day = strtotime(date('Y-m-d'));
        //最低价规则
        $cfg_line_minprice_rule = Model_Sysconfig::get_configs(0, 'cfg_line_minprice_rule', true);
        //提前预定
        $info = DB::select('islinebefore', 'linebefore')->from('line')->where('id', '=', $lineid)->execute()->current();
        if ($info['islinebefore'] > 0 && $info['linebefore'] > 0)
        {
            $day = strtotime("+{$info['linebefore']} days", $day);
        }

        $sql = "SELECT MIN(`adultprice`) as price FROM sline_line_suit_price WHERE `lineid`={$lineid} and `adultprice`>=0 and day>={$day} and `number`!=0 and find_in_set(2,propgroup)";
        $condition = array('childprice', 'oldprice');
        switch ($cfg_line_minprice_rule)
        {
            //儿童
            case 1:
                $sql = "SELECT MIN(`childprice`) as price FROM sline_line_suit_price WHERE `lineid`={$lineid} and `childprice`>=0 and `day`>={$day} and `number`!=0 and find_in_set(1,propgroup)";
                $condition = array('adultprice', 'oldprice');
                break;
            //成人
            case 2:
                $sql = "SELECT MIN(`adultprice`) as price FROM sline_line_suit_price WHERE `lineid`={$lineid} and `adultprice`>=0 and day>={$day} and `number`!=0 and find_in_set(2,propgroup)";
                $condition = array('childprice', 'oldprice');
                break;
            //老人
            case 3:
                $sql = "SELECT MIN(`oldprice`) as price FROM sline_line_suit_price WHERE `lineid`={$lineid} and `oldprice`>=0 and day>={$day} and `number`!=0 and find_in_set(3,propgroup)";
                $condition = array('adultprice', 'childprice');
                break;
        }

        $rs = DB::query(1, $sql)->execute()->current();
        if (!$rs['price'])
        {
            $sql = "select * from ((SELECT MIN({$condition[0]}) as price1 FROM sline_line_suit_price WHERE `lineid`={$lineid} and {$condition[0]}>0 and `day`>={$day} and `number`!=0) as temp1,(SELECT MIN({$condition[1]}) as price2 FROM sline_line_suit_price WHERE `lineid`={$lineid} and {$condition[1]}>0 and `day`>={$day} and `number`!=0) as temp2)";
            $result = DB::query(1, $sql)->execute()->current();
            $rs['price'] = ($result['price1'] > $result['price2'] && $result['price2'] ? $result['price2'] : $result['price1']);
        }
        //更新最低价



        DB::update('line')->set(array('price' => $rs['price'], 'price_date' => strtotime(date('Y-m-d'))))->where('id', '=', $lineid)->execute();
        self::update_sellprice($lineid);
    }


    /**
     * @function 更新线路显示原价
     */
    public static function update_sellprice($lineid)
    {
        $sellprice = DB::select( DB::expr('max(sellprice) as sellprice'))->from('line_suit')
            ->where('lineid','=',$lineid)->execute()->get('sellprice');
        DB::update('line')->set(array('storeprice'=>$sellprice))->where('id','=',$lineid)->execute();

    }

    /**
     * @function 当线路内容有变化的时候，重新提交审核
     * @param $lineid
     */
    public static function update_line_to_check($lineid)
    {
       if(self::is_need_check())
       {
           $data = array(
               'status'=>1,
               'ishidden'=>1
           );
           DB::update('line')->set($data)->where('id','=',$lineid)->execute();
       }

    }

    /**
     * @function 是否需要审核
     * @return bool
     */
    public static function is_need_check()
    {
        $cfg_line_supplier_check_auto = DB::select('value')
            ->from('sysconfig')
            ->where('varname','=','cfg_line_supplier_check_auto')
            ->execute()
            ->get('value');
        if($cfg_line_supplier_check_auto == 1)
        {
            return false;
        }
        else
        {
            return true;
        }
    }


}