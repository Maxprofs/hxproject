<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Hotel
 * @desc 酒店总控制器
 */
class Controller_Hotel extends Stourweb_Controller
{
  

    public function before()
    {
        parent::before();
        $this->assign('currency_symbol',Currency_Tool::symbol());
    }
    public function action_map()
    {
        $id=$_GET['id'];
        $model=ORM::factory('hotel',$id);
      //  if(!$model->loaded())
       //     exit('酒店不存在');
        $info=$model->as_array();
        $seoinfo=array('seotitle'=>$info['title']);
        $this->assign('info',$info);
        $this->assign('seoinfo',$seoinfo);
        $this->display('hotel/map');
    }
    public function action_mapnear()
    {
        $seoinfo=array('seotitle'=>'附近酒店');
        $this->assign('seoinfo',$seoinfo);
        $this->display('hotel/mapnear');
    }
    public function action_ajax_near_hotels()
    {
        $lat=floatval($_POST['lat']);
        $lng=floatval($_POST['lng']);
        $maxDistance=3000;
        $nearDistance=15;
        $sql="select id,aid,webid,title,price,address,lng,lat,ROUND(6378.138*2*ASIN(SQRT(POW(SIN((".$lat."*PI()/180-lat*PI()/180)/2),2)+COS(".$lat."*PI()/180)*COS(lat*PI()/180)*POW(SIN((".$lng."*PI()/180-lng*PI()/180)/2),2))))  AS distance from sline_hotel where ROUND(6378.138*2*ASIN(SQRT(POW(SIN((".$lat."*PI()/180-lat*PI()/180)/2),2)+COS(".$lat."*PI()/180)*COS(lat*PI()/180)*POW(SIN((".$lng."*PI()/180-lng*PI()/180)/2),2))))<".$maxDistance." and  lat is not null and lng is not null and ishidden=0 order by distance asc";
        $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
        $nearhas=false;
        foreach($list as &$row)
        {
            if(floatval($row['distance'])<=$nearDistance)
                $nearhas=true;
            $row['price'] = Model_Hotel::get_minprice($row['id']);
            $row['url']=Common::get_web_url($row['webid']) . "/hotels/show_{$row['aid']}.html";
        }
        echo json_encode(array('status'=>true,'data'=>$list,'nearhas'=>$nearhas));
    }

}