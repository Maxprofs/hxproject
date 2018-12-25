<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 手机端游记控制器
 * Class Controller_Mobile_Notes_Member
 *
 */
class Controller_Mobile_Notes_Member extends Stourweb_Controller
{

    private $_member = NULL;
    /**
     * 前置操作
     */
    public function before()
    {
        parent::before();
        $this->_member = Model_Member_Login::check_login_info();
        if (empty($this->_member))
        {
            Common::message(array('message' => __('unlogin'), 'jumpUrl' => $this->cmsurl . 'member/login'));
        }
    }

    /**
     * 我的游记
     */
    public function action_mynotes()
    {
        $pagesize=10;
        $sorttype=1;
        $list=Model_Notes::search(0,'',$sorttype,false,0,$pagesize,$this->_member['mid']);
        $this->assign('list',$list);
        $this->assign('sorttype',$sorttype);
        $this->assign('pagesize',$pagesize);
        $this->display('../mobile/member/mynotes');
    }

    public function action_notes_del()
    {
        if($this->params['id'])
        {
            $id = intval($this->params['id']);
            $noteModel=ORM::factory('notes',$id);
            if(!$noteModel->loaded())
            {
                exit(json_encode(array('status' => false, 'msg' => '删除的内容不存在')));
            }
            $member = Model_Member_Login::check_login_info();
            $info=$noteModel->as_array();
            if($info['memberid']!=$member['mid'])
            {
                exit(json_encode(array('status' => false, 'msg' => '请勿操作不属于您的内容')));
            }
            $status=$noteModel->delete();
            exit(json_encode(array('status' => $status, 'msg' => $status?'删除成功':'删除失败')));
        }
        exit(json_encode(array('status' => false, 'msg' => '操作异常')));
    }

    /**
     * @function
     */
    public function action_notes_edit(){
        if($this->params['id'])
        {
            $id = intval($this->params['id']);
            $noteModel=ORM::factory('notes',$id);
            if(!$noteModel->loaded())
            {
                Common::head_404();
            }
            $member = Model_Member_Login::check_login_info();
            $info=$noteModel->as_array();
            if($info['memberid']!=$member['mid'])
            {
                Common::head_404();
            }
            $memberInfo = Model_Member::get_member_byid($info['memberid']);
            $info['memberinfo'] = $memberInfo;
            $info['articleid'] = $info['id'];
            $info['commentnum'] = Model_Comment::get_comment_num($info['id'],$this->_typeid);
            $seoinfo = Product::seo($info);
            $this->assign('seoinfo',$seoinfo);
            $this->assign('info',$info);
        }
        //frmcode
        $code = time();
        Common::session('code', $code);
        $this->assign('frmcode', $code);
        $this->display('../mobile/member/mynotes_edit');
    }

    public function action_ajax_upload_base64Img()
    {
        $base64_image_content = $_POST['image'];
        //匹配出图片的格式
        $result=array('url'=>$_POST['imgBase64'],'msg'=>'base64ToImg','status'=>false);
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $image_data))
        {
            $type = $image_data[2];
            $pinyin = 'notes';
            $storepath = UPLOADPATH.DIRECTORY_SEPARATOR.$pinyin.DIRECTORY_SEPARATOR;
            if (!file_exists($storepath))
            {
                mkdir($storepath);
            }
            $filename = uniqid();
            $out = array();
            $out['status'] = 0;
            $ext = $type;
            $fullName=$storepath . $filename.'.'.$ext;
            if (file_put_contents($fullName, base64_decode(str_replace($image_data[1], '', $base64_image_content))))
            {
                $result['status'] = true;
                $result['msg'] = '保存图片成功';
                $result['url'] = '/uploads/notes/' . $filename . '.' . $ext;
            }
            else
            {
                $result=array('url'=>'','msg'=>'保存图片失败','status'=>false);
            }
        }
        echo json_encode($result);
    }

    /**
     * 游记封面上传
     */
    public function action_ajax_upload_img()
    {
        $filedata = $_FILES['filedata'];
        if(!$filedata)
        {
            $filedata=$_FILES['file'];
        }
        if(!$filedata)
        {
            $filedata=$_FILES['image'];
        }
        //检测图片有效性.
        if(!St_Functions::is_valid_image($filedata))
        {
            exit(json_encode(array('status' => false, 'msg' => '图片无效')));
        }
        $pinyin = 'notes';
        $storepath = UPLOADPATH.DIRECTORY_SEPARATOR.$pinyin.DIRECTORY_SEPARATOR;
        if (!file_exists($storepath))
        {
            mkdir($storepath);
        }
        $filename = uniqid();
        $out = array();
        $out['status'] = 0;
        $ext = end(explode('.', $filedata['name']));

        if (move_uploaded_file($filedata['tmp_name'], $storepath . $filename . '.' . $ext))
        {
            $w=540;$h=270;
            $out['status'] = 1;
            $out['litpic'] = '/uploads/notes/' . $filename . '.' . $ext;
            $out['cover']=Common::img($out['litpic'],$w,$h);
            $out['banner']=Common::img($out['litpic'],$w,$h);
            $out['url'] = $out['litpic'];
        }
        exit(json_encode($out));
    }

    public function action_ajax_get_more()
    {
        $pagesize = intval($_POST['pagesize']);
        $page = intval($_POST['page']);
        $page = empty($page)?1:$page;
        $sortype = $_POST['sorttype'];
        $offset = $pagesize*($page-1);
        $list=Model_Notes::search(null,null,$sortype,false,$offset,$pagesize,$this->_member['mid']);
        foreach($list as &$row)
        {
            $memberInfo = Model_Member::get_member_byid($row['memberid']);
            $row['modtime'] = date('Y-m-d',$row['modtime']);
            $row['memberinfo'] = $memberInfo;
        }
        echo Product::list_search_format($list,$page-1,$pagesize);
    }

    /**
     * 游记保存
     */
    public function action_ajax_save()
    {
        //会员信息
        $userInfo = Model_Member_Login::check_login_info();
        //要求写游记必须登陆
        if (empty($userInfo['mid']))
        {
            $this->request->redirect(Common::get_main_host() . '/member/login/?redirecturl=' . urlencode(Common::get_current_url()));
        }
        $frmCode = Common::remove_xss(Arr::get($_POST, 'frmcode'));
        $title = Common::remove_xss(Arr::get($_POST, 'title'));
        $description = Common::remove_xss(Arr::get($_POST, 'description'));
        $content = Arr::get($_POST, 'content');
        $content=preg_replace("/<p.*?>|<\/p>/is","", $content);
        $banner = Common::remove_xss(Arr::get($_POST, 'banner'));
        $cover = Common::remove_xss(Arr::get($_POST, 'cover'));
        $noteid = intval(Arr::get($_POST, 'noteid'));
        $place = Common::remove_xss(Arr::get($_POST, 'place'));
        //安全校验码验证
        $orgCode = Common::session('code');
        if ($orgCode != $frmCode)
        {
            exit('frmcode error');
        }
        Common::session('code',null);
        if (!empty($noteid))
        {
            $m = ORM::factory('notes', $noteid);
        }
        else
        {
            $m = ORM::factory('notes');
        }
        if(!$banner)
        {
            $m->bannerpic = '/res/images/notes_default_banner.png';
        }
        else
        {
            $m->bannerpic =$banner;
        }
        $m->title = $title;
        $m->memberid = $userInfo['mid'];
        if($cover)
        {
            $m->litpic = $cover;
        }
        
        if ($description)
        {
            $m->description = $description;
        }
        $m->content = $content;
        //更新不刷新时间
        if (empty($noteid))
        {
            $m->modtime = time();
        }
        $m->place = $place;
        $placeArr=explode(',',$place);
        $kidlist=array();
        foreach($placeArr as $v){
            array_push($kidlist,$v);
            $dest=Model_Destinations::get_parents($v);
            foreach($dest as $d){
                array_push($kidlist,$d['id']);
            }
        }

        $status = 0;
        $m->save();
        if ($m->saved())
        {
            $status = 1;
            if (empty($noteid))
            {
                $m->reload();
                Model_Message::add_note_msg(100,$m->id,$m->as_array());
                $noteid = $m->id;
            }
        }
        echo json_encode(array('status' => $status, 'noteid' => $noteid));
        exit();
    }

}