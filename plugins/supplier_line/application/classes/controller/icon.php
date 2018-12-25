<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Icon extends Stourweb_Controller{

        public function before()
        {
            parent::before();
            $this->assign('weblist',Common::getWebList());
        }
	    private $product_arr=array(
            1=>'line',
            2=>'hotel',
            3=>'car',
            4=>'article',
            5=>'spot',
            6=>'photo',
            8=>'visa',
            11=>'jieban',
            13=>'tuan'
        );



	   public function action_ajax_iconlist()
	   {
		   $model=ORM::factory('icon');
		   $list=$model->get_all();
		   echo json_encode($list);
	   }
	   /*
	     设置产品的iconlist
	   */
	   public function action_ajax_seticon()
	   {
		 $typeid=Arr::get($_POST,'typeid');
		 $productid=Arr::get($_POST,'productid');
		 $icons=Arr::get($_POST,'icons');
	   
	    $is_success='ok';
		$productid_arr=explode('_',$productid);
		foreach($productid_arr as $k=>$v)
		{
            $model_info = Model_Model::getModuleInfo($typeid);
            $table = $model_info['maintable']=='model_archive' ? 'model_archive' : self::$product_arr[$typeid];
           // $table = $typeid>13 ? 'model_archive' : $this->product_arr[$typeid];
			$model=ORM::factory($table,$v);
			if($model->id)
			{
				$model->iconlist=$icons;
				$model->save();
				if(!$model->saved())
				   $is_success='no';
			}
		}
		echo $is_success;
	  }
      public function action_dialog_seticon()
      {
          $id=$_GET['id'];
          $typeid=$_GET['typeid'];
          $iconStr=$_GET['iconlist'];
          $selector=$_GET['selector'];
          $iconlist=$this->getProductIcons($id,$typeid);
          if($iconStr)
              $iconlist=explode(',',$iconStr);
          $this->assign('selIcons',$iconlist);
          $icons=ORM::factory('icon')->get_all();
          $this->assign('icons',$icons);
          $this->assign('selector',$selector);
          $this->assign('id',$id);
          $this->display('icon/dialog_seticon');
      }
      public function getProductIcons($id,$typeid)
      {
          if(empty($id)||empty($typeid))
              return null;
          $model=ORM::factory('model',$typeid);
          if(!$model->loaded())
              return null;
          $table=$model->maintable;
          $info=ORM::factory($table,$id);
          if(!$info->loaded())
              return null;
          if(empty($info->iconlist))
              return null;
          return explode(',',$info->iconlist);

      }
}