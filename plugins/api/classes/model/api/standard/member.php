<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Api_Standard_Member
{

    public static function get_grade_list()
    {
        $grade_list = Model_Member::member_grade();
        $result = array();
        foreach ($grade_list as $grade)
        {
            $result[] = array(
                'id' => $grade['id'],
                'name' => $grade['name'],
                'begin_jifen' => $grade['begin'],
                'end_jifen' => $grade['end']
            );
        }
        return $result;

    }

    public static function get_verify_status_list()
    {
        return array(
            array('id' => 0, 'name' => '未认证'),
            array('id' => 1, 'name' => '审核中'),
            array('id' => 2, 'name' => '通过'),
            array('id' => 3, 'name' => '未通过'),
        );

    }

    public static function search($condition)
    {
        $result = array(
            'row_count' => 0,
            'data' => array()
        );

        $where = "
FROM
	sline_member
WHERE
    1=1 ";
        if ($condition['keyword'])
        {
            $where .= " and (
            `nickname` LIKE '%{$condition['keyword']}%'
            or `truename` LIKE '%{$condition['keyword']}%'
            or `email` LIKE '%{$condition['keyword']}%'
            or `mobile` LIKE '%{$condition['keyword']}%'
			  or `cardid` LIKE '%{$condition['keyword']}%'
			  or `address` LIKE '%{$condition['keyword']}%'
			  or `qq` LIKE '%{$condition['keyword']}%'
            )";
        }
        if ($condition['birthday'])
        {
            $where .= " and unix_timestamp(birth_date)=unix_timestamp('{$condition['birthday']}')";
        }
        if ($condition['sex'])
        {
            $where .= " and sex='{$condition['sex']}'";
        }
        if (is_numeric($condition['begin_jifen']))
        {
            $where .= " and jifen>={$condition['begin_jifen']}";
        }
        if (is_numeric($condition['end_jifen']))
        {
            $where .= " and jifen<={$condition['end_jifen']}";
        }
        if ($condition['start_time'])
        {
            $where .= " and jointime>=unix_timestamp('{$condition['start_time']}')";
        }
        if ($condition['end_time'])
        {
            $where .= " and jointime<=unix_timestamp('{$condition['end_time']}')";
        }

        $sql = "select count(*) as row_count {$where}";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        $result['row_count'] = $list[0]['row_count'];

        $sql = "SELECT
        mid as id,
        nickname,
        pwd,
        truename,
        sex,
        email,
        mobile,
        jifen,
        litpic,
        safequestion,
        safeanswer,
        jointime,
        joinip,
        logintime,
        loginip,
        checkmail,
        checkphone,
        cardid,
        address,
        regtype,
        birth_date,
        constellation,
        qq,
        signature
      {$where}";
        if ($condition['sort'])
        {
            $sql .= " order by {$condition['sort']['property']} {$condition['sort']['direction']}";
        } else
        {
            $sql .= ' order by jointime desc';
        }

        $start = $condition['start'] ? $condition['start'] : 0;
        $limit = $condition['limit'] ? $condition['limit'] : 20;
        $sql .= " LIMIT {$start},{$limit}";


        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        if (count($list) <= 0)
            return $result;

        foreach ($list as &$member)
        {
            $member['jointime'] = Model_Api_Standard_System::format_unixtime($member['jointime']);
            $member['logintime'] = Model_Api_Standard_System::format_unixtime($member['logintime']);
            $member['litpic'] = Model_Api_Standard_System::reorganized_resource_url($member['litpic']);
        }

        $result['data'] = $list;
        return $result;

    }

    public static function get_detail($id)
    {
        $sql = "SELECT
            mid as id,
            nickname,
            pwd,
            truename,
            sex,
            email,
            mobile,
            jifen,
            litpic,
            safequestion,
            safeanswer,
            jointime,
            joinip,
            logintime,
            loginip,
            checkmail,
            checkphone,
            cardid,
            address,
            regtype,
            birth_date,
            constellation,
            qq,
            signature
         FROM `sline_member` WHERE mid={$id}";
        $info = DB::query(Database::SELECT, $sql)->execute()->current();
        if (empty($info))
        {
            return null;
        }

        $result = $info;
        $result['jointime'] = Model_Api_Standard_System::format_unixtime($result['jointime']);
        $result['logintime'] = Model_Api_Standard_System::format_unixtime($result['logintime']);
        $result['litpic'] = Model_Api_Standard_System::reorganized_resource_url($result['litpic']);
        $result['litpic'] = empty($result['litpic']) ? Model_Api_Standard_System::reorganized_resource_url(Model_Member::member_nopic()) : $result['litpic'];

        //会员等级信息
        $result['grade_info'] = array();
        $member_grade = DB::select('*')->from('member_grade')->where("{$info['jifen']} between `begin` and `end`")->execute()->current();
        if (!empty($member_grade))
        {
            $result['grade_info'] = array(
                'id' => $member_grade['id'],
                'name' => $member_grade['name'],
                'begin_jifen' => $member_grade['begin'],
                'end_jifen' => $member_grade['end']
            );
        }

        //会员收货地址列表
        $result['address_list'] = array();
        $member_address_list = DB::select('*')->from('member_address')->where("memberid", "=", $info['id'])->execute()->as_array();
        if (count($member_address_list) > 0)
        {
            $result['address_list'] = $member_address_list;
        }

        //会员常用旅客列表
        $result['tourist_list'] = array();
        $tourist_list = DB::select('*')->from('member_linkman')->where("memberid", "=", $info['id'])->execute()->as_array();
        if (count($tourist_list) > 0)
        {
            $result['tourist_list'] = $tourist_list;
        }

        return $result;
    }

    public static function statistics_num($timespan)
    {
        $sql = "SELECT count(*) as num FROM `sline_member` WHERE jointime between {$timespan[0]} and {$timespan[1]}";
        $info = DB::query(Database::SELECT, $sql)->execute()->current();

        return $info['num'];
    }


    public static function save($member)
    {
        $result = array(
            'success' => false,
            'message' => ''
        );

        $id = Arr::get($member, 'mid');

        if ($member['pwd'])
        {
            $member['pwd'] = md5(Arr::get($member, 'pwd'));
        }

        if ($member['email'])
        {
            $flag = Model_Member::checkExist("email", $member['email'], $id);
            if ($flag == 'false')
            {
                $result['message'] = "存在重复的email";
                return $result;
            }
        }

        if ($member['mobile'])
        {
            $flag = Model_Member::checkExist("mobile", $member['mobile'], $id);
            if ($flag == 'false')
            {
                $result['message'] = "存在重复的mobile";
                return $result;
            }
        }

        if ($member['litpic'])
        {
            $litpic = explode(",", $member['litpic']);
            $pic_data = base64_decode($litpic[1]);
            $pic_name = uniqid() . $litpic[0];
            $pic_url = "/uploads/member/{$pic_name}";
            $pic_path = BASEPATH . $pic_url;
            if (!file_exists(dirname($pic_path)))
            {
                if (!mkdir(dirname($pic_path), 0777, true))
                {
                    $result['message'] = "创建头像上传目录失败";
                    return $result;
                }
            }

            if (file_put_contents($pic_path, $pic_data) === false)
            {
                $result['message'] = "头像文件写入失败";
                return $result;
            }

            $member['litpic'] = $pic_url;
        }


        //添加操作
        if (empty($id))
        {
            $member['jointime'] = time();
            $insert_result = DB::insert('member', array_keys($member))->values(array_values($member))->execute();
            $result['success'] = true;
            $result['message'] = $insert_result[0];
        } else
        {
            DB::update('member')->set($member)->where('mid', '=', $id)->execute();
            $result['success'] = true;
            $result['message'] = $id;
        }

        return $result;
    }

}