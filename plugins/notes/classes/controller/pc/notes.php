<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Notes extends Stourweb_Controller
{

    private $_typeid = 101;
    private $_cache_key = '';

    public function before()
    {
        parent::before();
        //检查缓存
        $this->_cache_key = Common::get_current_url();
        $html = Common::cache('get', $this->_cache_key);
        $genpage = Common::remove_xss(Arr::get($_GET, 'genpage'));
        if (!empty($html) && empty($genpage))
        {
            echo $html;
            exit;
        }
        $this->assign('typeid', $this->_typeid);

    }

    //首页
    public function action_index()
    {

        $seoinfo = Model_Nav::get_channel_seo($this->_typeid);
        $this->assign('seoinfo', $seoinfo);

        //游记数量
        $total = Model_Notes::get_total_notes();
        $this->assign('total_notes', $total);
        //首页模板
        $templet = Product::get_use_templet('notes_index');
        $templet = $templet ? $templet : 'notes/index';
        $this->display($templet);
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);

    }

    //显示游记
    public function action_show()
    {
        $noteid = intval(Common::remove_xss($this->request->param('id')));
        $noteModel = ORM::factory('notes', $noteid);
        if (!empty($noteid))
        {
            $noteModel->shownum = intval($noteModel->shownum) + 1;
            $noteModel->save();
            $noteModel->reload();
            $info = $noteModel->as_array();
            //未通过审核的游记
            if ($info['status'] != 1)
            {
                $msg = array(
                    'status' => 0,
                    'msg' => '游记未通过审核,暂时不能浏览',
                    'jumpUrl' => $this->request->referrer()
                );
                Common::message($msg);
                exit;
            }
            $author = ORM::factory('member', $info['memberid'])->as_array();
            $author['litpic'] = empty($author['litpic']) ? Common::member_nopic() : $author['litpic'];
            $destination=$info['place']?$info['place']:$info['kindlist'];
            if($destination)
            {
                $sql = "SELECT a.id,a.kindname,a.pinyin from sline_destinations a left join sline_notes_kindlist b on a.id=b.kindid where a.isopen=1 AND find_in_set($this->_typeid,a.opentypeids)";
                $sql .= "AND a.id IN ($destination) ORDER BY b.displayorder ASC";
                $info['destinations']= DB::query(1, $sql)->execute()->as_array();
            }
//            $info['destinations'] = DB::select('kindname', 'pinyin')->from('destinations')
//                ->where('id', 'in', explode(',',$destination))
//                ->and_where('isopen', '=', 1)->execute()->as_array();
            //检测用户是否存在
            $login_user=Model_Member_Login::check_login_info();
            $mid = $login_user['mid'];
            $member=array();
            if ($mid)
            {
                $member = Model_Member::get_member_byid($mid);
            }
            // 前台显示虚拟阅读量+真实阅读量
            $info['shownum'] += $info['read_num'];
            $this->assign('member', $member);
            $this->assign('destid', $info['finaldestid']);
            $this->assign('author', $author);
            $this->assign('info', $info);
            $templet = Product::get_use_templet('notes_show');
            $templet = $templet ? $templet : 'notes/show';
            $this->display($templet);

        }

    }

    //写游记
    public function action_write()
    {

        $noteid = intval(Common::remove_xss(Arr::get($_GET, 'noteid')));
        $memberid = intval(Common::remove_xss(Arr::get($_GET, 'memberid')));
        //会员信息
        $userInfo = Product::get_login_user_info();
        //要求写游记必须登陆
        if (empty($userInfo['mid']))
        {
            $this->request->redirect(Common::get_main_host() . '/member/login/?redirecturl=' . urlencode(Common::get_current_url()));
        }
        //用于会员信息修改
        if (!empty($noteid) && !empty($memberid))
        {
            $info = ORM::factory('notes')
                ->where("id=$noteid and memberid=$memberid")
                ->find()
                ->as_array();
            if (!empty($info))
            {
                $info['destinations'] = DB::select('kindname', 'id')->from('destinations')->where('id', 'in', explode(',', $info['place']))->and_where('isopen', '=', 1)->execute()->as_array();
                $this->assign('info', $info);
            }
        }
        //frmcode
        $code = time();
        Common::session('code', $code);
        $this->assign('frmcode', $code);
        $this->display('notes/write');
    }

    /**
     * 游记保存
     */
    public function action_ajax_save()
    {
        //会员信息
        $userInfo = Product::get_login_user_info();
        //要求写游记必须登陆
        if (empty($userInfo['mid']))
        {
            $this->request->redirect(Common::get_main_host() . '/member/login/?redirecturl=' . urlencode(Common::get_current_url()));
        }
        $frmCode = Common::remove_xss(Arr::get($_POST, 'frmcode'));
        $title = Common::remove_xss(Arr::get($_POST, 'title'));
        $description = Common::remove_xss(Arr::get($_POST, 'description'));
        $content = Arr::get($_POST, 'content');
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
        $m->title = $title;
        $m->memberid = $userInfo['mid'];
        if(!$banner)
        {
            $m->bannerpic = '/res/images/notes_default_banner.png';
        }
        else
        {
            $m->bannerpic = $banner;
        }
        if($cover)
        {
            $m->litpic = $cover;
        }
        if ($description)
        {
            $m->description = $description;
        }
        $m->content = $content;
        $m->modtime = time();
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
        /*if($kidlist){
            $kidlist=array_unique($kidlist);
            sort($kidlist);
            $m->finaldestid = $kidlist[count($kidlist)-1];
            $m->kindlist = implode(',',$kidlist);
        }*/

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



    public function action_ajax_get_new_notes()
    {
        $currentpage = intval(Arr::get($_GET, 'curr'));//当前页
        $pagesize = 6;//每次显示条数需要与js端设置一至
        $offset = ($currentpage - 1) * $pagesize;
        $list = Model_Notes::get_new_notes($offset, $pagesize);
        foreach ($list as &$row)
        {
            $row['pubdate'] = Common::mydate('Y-m-d H:i', $row['modtime']);
            $row['litpic'] = Common::img($row['litpic'], 170, 116);
        }
        echo json_encode(array('list' => $list));
        exit;

    }

    /**
     * 上传图片
     * 作废 暂未删除 等功能上线后可删除
     * 
     */
    public function action_ajax_upload_pictures()
    {
        //if(!$this->request->is_ajax())exit('not ajax');

        $filedata = Arr::get($_FILES, 'filedata');
        //检测图片有效性.
        if(!St_Functions::is_valid_image($filedata))
        {
            return false;
        }
        $storepath = UPLOADPATH . '/notes/';
        if (!file_exists($storepath))
        {
            mkdir($storepath);
        }
        $filename = uniqid();
        $out = array();
        $ext = end(explode('.', $filedata['name']));

        if (move_uploaded_file($filedata['tmp_name'], $storepath . $filename . '.' . $ext))
        {
            $out['status'] = 1;
            $out['litpic'] = '/uploads/notes/' . $filename . '.' . $ext;
            if(isset($_GET['type'])){
                switch ($_GET['type']){
                    case 'cover':
                        $out['thumb']=Common::img($out['litpic'],358,258);
                        break;
                    case 'banner':
                        $out['thumb']=Common::img($out['litpic'],1920,420);
                        break;

                }
            }
        }
        echo json_encode($out);
    }
    
    /***
     * 客户有七牛云就上传到七牛云,
     * 没有则上传到本地服务器
     * 
     */
    public function action_ajax_upload_picture()
    {
        // 获取图片信息
        $filedata = Arr::get($_FILES, 'filedata');
        //检测图片有效性.
        if (!St_Functions::is_valid_image($filedata)) 
        {
            return false;
        }
        $config = false;

        // 检查是否安装七牛云模块
        if (St_Functions::is_normal_app_install('image_qiniu')) 
        {
             // 获取(检测)七牛云配置信息
            $config = Model_Qiniu::get_qiniu_config();
        }
        // 查看用户是否有七牛云的配置
        if ($config == false)
        {
            // 本地上传
            $pictureurl  = St_Functions::local_upload_picture($filedata);
        }
        else
        {
            // 上传至七牛云服务器
            $pictureurl = Model_Qiniu::qiniu_upload_picture($config,$filedata);
        }
        echo json_encode($pictureurl);
    }


    //添加评论
    public function action_ajax_add_comment()
    {
        if (!$this->request->is_ajax()) exit();
        $checkcode = Arr::get($_POST, 'checkcode');
        $articleid = intval(Arr::get($_POST, 'articleid'));
        $content = Common::remove_xss(Arr::get($_POST, 'content'));
        $typeid = $this->_typeid;
        $dockid = intval(Arr::get($_POST, 'dockid'));
        $checkcode = strtolower($checkcode);
        if (!Captcha::valid($checkcode))
        {
            echo 1; //验证码错误
            exit;
        }
        $login_user=Model_Member_Login::check_login_info();
        $memberId = $login_user ? $login_user['mid'] : '0';
        $m = ORM::factory('comment');
        //游记是否开启审核
        $status=3;
        if ($GLOBALS['cfg_notes_pinlun_audit_open']==='0')
        {
            $m->isshow = 1;
            $status=2;
        }
        $m->articleid = $articleid;
        $m->content = $content;
        $m->typeid = $typeid;
        $m->memberid = $memberId;
        $m->dockid = $dockid;
        $m->addtime = time();
        $m->save();
        if ($m->saved())
        {
            $note=$m->as_array();
            if($note['isshow']==1)
            {
                Model_Comment::on_verified($note['id'],$typeid,$memberId);
            }
            echo $status;
            exit;
        }
    }

    //目的列表页调取
    public function action_ajax_destionation_notes()
    {
        $params = array();
        $params['page'] = intval($this->request->param('params'));
        $params['destid'] = intval($_GET['destid']);
        $result = Model_Notes::destionation_notes($params);
        foreach($result['data'] as &$v)
        {
            $v['litpic']=Common::img($v['litpic'],220,150);
            $v['modtime']=date('Y-m-d H:i:s',$v['modtime']);
            $v['member']['litpic']=Common::img($v['member']['litpic'],29,29);
        }
        echo json_encode($result);
    }
    //目的列表页调取
    public function action_ajax_comment()
    {
        $params = array();
        $params['page'] = intval($this->request->param('params'));
        $params['row'] = 5;
        $params['typeid'] = $this->_typeid;
        $params['articleid']=intval($_GET['articleid']);
        $params['controller'] = 'notes';
        $result = Product::content_comment($params);
        foreach($result['data'] as &$v)
        {
            $v['member']['litpic']=Common::img($v['member']['litpic'],29,29);
        }
        echo json_encode($result);
    }

}