<?php defined('SYSPATH') or die('No direct script access.');


/**
 * Class Controller_Spot 门票景点
 */
class Controller_Spot extends Stourweb_Controller
{


    public function before()
    {
        parent::before();
        $this->assign('currency_symbol',Currency_Tool::symbol());
    }

    public function action_map()
    {
        $id=$_GET['id'];
        $model=ORM::factory('spot',$id);
        //  if(!$model->loaded())
        //     exit('酒店不存在');
        $info=$model->as_array();
        $seoinfo=array('seotitle'=>$info['title']);
        $this->assign('info',$info);
        $this->assign('seoinfo',$seoinfo);
        $this->display('spot/map');
    }
    public function action_mapnear()
    {
        $seoinfo=array('seotitle'=>'附近景点');
        $this->assign('seoinfo',$seoinfo);
        $this->display('spot/mapnear');
    }
    public function action_ajax_near_spots()
    {
       /* $lat=floatval($_POST['lat']);
        $lng=floatval($_POST['lng']);
       */
        $maxDistance=3000;
       // $nearDistance=15;
       // $sql="select id,aid,webid,title,price,address,lng,lat,ROUND(6378.138*2*ASIN(SQRT(POW(SIN((".$lat."*PI()/180-lat*PI()/180)/2),2)+COS(".$lat."*PI()/180)*COS(lat*PI()/180)*POW(SIN((".$lng."*PI()/180-lng*PI()/180)/2),2))))  AS distance from sline_spot where ROUND(6378.138*2*ASIN(SQRT(POW(SIN((".$lat."*PI()/180-lat*PI()/180)/2),2)+COS(".$lat."*PI()/180)*COS(lat*PI()/180)*POW(SIN((".$lng."*PI()/180-lng*PI()/180)/2),2))))<".$maxDistance." and  lat is not null and lng is not null and ishidden=0 order by distance asc";

        $nearDistance=15;
        $west_lng = $_POST['west_lng'];
        $east_lng = $_POST['east_lng'];
        $north_lat = $_POST['north_lat'];
        $south_lat = $_POST['south_lat'];
        if(empty($west_lng) || empty($east_lng) || empty($north_lat) || empty($south_lat))
        {
            echo json_encode(array('status'=>false));
            return;
        }
        $sql="select id,aid,webid,title,price,address,lng,lat from sline_spot where  lat is not null and lng is not null and ishidden=0 and lat>={$south_lat} and lat<={$north_lat} and lng>={$west_lng} and lng<={$east_lng} ";
        $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
        foreach($list as &$row)
        {
            $priceArr = Model_Spot::get_minprice($row['id']);
            $row['price'] = $priceArr['price'];
            $row['url']=Common::get_web_url($row['webid']) . "/spots/show_{$row['aid']}.html";
        }
        echo json_encode(array('status'=>true,'data'=>$list));
    }

}