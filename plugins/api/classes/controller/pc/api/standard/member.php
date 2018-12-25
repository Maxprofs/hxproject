<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Api_Standard_Member extends Controller_Pc_Api_Base
{
    public function before()
    {
        parent::before();
    }

    public function action_get_grade_list()
    {
        $result = Model_Api_Standard_Member::get_grade_list();
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);

    }

    public function action_get_verify_status_list()
    {
        $result = Model_Api_Standard_Member::get_verify_status_list();
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);

    }

    public function action_search()
    {
        $condition = array();

        $condition['keyword'] = Common::remove_xss($this->request_body->content->keyword);
        $condition['birthday'] = Common::remove_xss($this->request_body->content->birthday);
        $condition['start_time'] = Common::remove_xss($this->request_body->content->start_time);
        $condition['end_time'] = Common::remove_xss($this->request_body->content->end_time);
        $condition['begin_jifen'] = Common::remove_xss($this->request_body->content->begin_jifen);
        $condition['end_jifen'] = Common::remove_xss($this->request_body->content->end_jifen);
        $condition['sex'] = Common::remove_xss($this->request_body->content->sex);

        $condition['start'] = Common::remove_xss($this->request_body->content->page->start);
        $condition['limit'] = Common::remove_xss($this->request_body->content->page->limit);
        $condition['sort'] = array();
        if ($this->request_body->content->sort->property)
        {
            $condition['sort']['property'] = Common::remove_xss($this->request_body->content->sort->property);
            if ($this->request_body->content->sort->direction)
            {
                $condition['sort']['direction'] = Common::remove_xss($this->request_body->content->sort->direction);
            } else
            {
                $condition['sort']['direction'] = "asc";
            }
        }

        $result = Model_Api_Standard_Member::search($condition);
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    public function action_get_detail()
    {
        $id = Common::remove_xss($this->request_body->content->id);

        $result = Model_Api_Standard_Member::get_detail($id);
        if (empty($result))
        {
            $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key'], false, "查找会员信息失败", "查找会员信息失败");
        } else
        {
            $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
        }
    }





    public function action_statistics_annual_report()
    {
        $current_year = date('Y');
        $year = empty($this->request_body->content->year) ? $current_year : $this->request_body->content->year;
        if ($year > $current_year)
        {
            $this->send_datagrams($this->client_info['id'], null, $this->client_info['secret_key'], false, "统计年份不能超过今年", "统计年份不能超过今年");
        }

        for ($i = 1; $i <= 12; $i++)
        {
            $starttime = date('Y-m-d', mktime(0, 0, 0, $i, 1, $year)); //开始时间

            $endtime = strtotime("$starttime +1 month -1 day"); //结束时间
            $timearr = array(strtotime($starttime), $endtime);

            $out[$i] = array('num' => Model_Api_Standard_Member::statistics_num($timearr));
        }

        $this->send_datagrams($this->client_info['id'], $out, $this->client_info['secret_key']);
    }

    public function action_statistics_monthly_report()
    {
        $out = array();

        //今日销售
        $time_arr = St_Functions::back_get_time_range(1);
        $out['today'] = array('num' => Model_Api_Standard_Member::statistics_num($time_arr));

        //昨日销售
        $time_arr = St_Functions::back_get_time_range(2);
        $out['yesterday'] = array('num' => Model_Api_Standard_Member::statistics_num($time_arr));

        //本周销售
        $time_arr = St_Functions::back_get_time_range(3);
        $out['thisweek'] = array('num' => Model_Api_Standard_Member::statistics_num($time_arr));

        //本月销售
        $time_arr = St_Functions::back_get_time_range(5);
        $out['thismonth'] = array('num' => Model_Api_Standard_Member::statistics_num($time_arr));

        $this->send_datagrams($this->client_info['id'], $out, $this->client_info['secret_key']);
    }

    public function action_check_email_exists()
    {
        $email = Common::remove_xss($this->request_body->content->email);
        $exclude_member_id = Common::remove_xss($this->request_body->content->exclude_member_id);
        if (empty($email))
        {
            $this->send_datagrams($this->client_info['id'], null, $this->client_info['secret_key'], false, "email不能为空", "email不能为空");
        }

        $flag = Model_Member::checkExist("email", $email, $exclude_member_id);
        if ($flag == 'false')
        {
            $this->send_datagrams($this->client_info['id'], true, $this->client_info['secret_key']);

        } else
        {
            $this->send_datagrams($this->client_info['id'], false, $this->client_info['secret_key']);
        }
    }

    public function action_check_mobile_exists()
    {
        $mobile = Common::remove_xss($this->request_body->content->mobile);
        $exclude_member_id = Common::remove_xss($this->request_body->content->exclude_member_id);
        if (empty($mobile))
        {
            $this->send_datagrams($this->client_info['id'], null, $this->client_info['secret_key'], false, "mobile不能为空", "mobile不能为空");
        }

        $flag = Model_Member::checkExist("mobile", $mobile, $exclude_member_id);
        if ($flag == 'false')
        {
            $this->send_datagrams($this->client_info['id'], true, $this->client_info['secret_key']);

        } else
        {
            $this->send_datagrams($this->client_info['id'], false, $this->client_info['secret_key']);
        }
    }

    public function action_save()
    {
        $member = array();

        if ($this->request_body->content->id)
        {
            $member['mid'] = Common::remove_xss($this->request_body->content->id);
        }
        if ($this->request_body->content->email)
        {
            $member['email'] = Common::remove_xss($this->request_body->content->email);
        }
        if ($this->request_body->content->mobile)
        {
            $member['mobile'] = Common::remove_xss($this->request_body->content->mobile);
        }
        if ($this->request_body->content->password)
        {
            $member['pwd'] = Common::remove_xss($this->request_body->content->password);
        }
        if ($this->request_body->content->nickname)
        {
            $member['nickname'] = Common::remove_xss($this->request_body->content->nickname);
        }
        if ($this->request_body->content->sex)
        {
            $member['sex'] = Common::remove_xss($this->request_body->content->sex);
        }
        if ($this->request_body->content->birthday)
        {
            $member['birth_date'] = Common::remove_xss($this->request_body->content->birthday);
        }
        if ($this->request_body->content->constellation)
        {
            $member['constellation'] = Common::remove_xss($this->request_body->content->constellation);
        }
        if ($this->request_body->content->qq)
        {
            $member['qq'] = Common::remove_xss($this->request_body->content->qq);
        }
        if ($this->request_body->content->signature)
        {
            $member['signature'] = Common::remove_xss($this->request_body->content->signature);
        }

        if ($this->request_body->content->headpic)
        {
            $member['litpic'] = $this->request_body->content->headpic;
        }

        if ($this->request_body->content->identity_card)
        {
            $member['cardid'] = Common::remove_xss($this->request_body->content->identity_card);
        }
        if ($this->request_body->content->truename)
        {
            $member['truename'] = Common::remove_xss($this->request_body->content->truename);
        }
        if ($this->request_body->content->safequestion)
        {
            $member['safequestion'] = Common::remove_xss($this->request_body->content->safequestion);
        }
        if ($this->request_body->content->safeanswer)
        {
            $member['safeanswer'] = Common::remove_xss($this->request_body->content->safeanswer);
        }
        if (is_numeric($this->request_body->content->checkemail))
        {
            $member['checkmail'] = Common::remove_xss($this->request_body->content->checkemail);
        }
        if (is_numeric($this->request_body->content->checkphone))
        {
            $member['checkphone'] = Common::remove_xss($this->request_body->content->checkphone);
        }
        if (is_numeric($this->request_body->content->jifen))
        {
            $member['jifen'] = Common::remove_xss($this->request_body->content->jifen);
        }
        if ($this->request_body->content->address)
        {
            $member['address'] = Common::remove_xss($this->request_body->content->address);
        }

        $result = Model_Api_Standard_Member::save($member);
        if($result['success'] === true)
        {
            $this->send_datagrams($this->client_info['id'], $result['message'], $this->client_info['secret_key']);
        }
        else
        {
            $this->send_datagrams($this->client_info['id'], null, $this->client_info['secret_key'], false, $result['message'], $result['message']);
        }

    }

}