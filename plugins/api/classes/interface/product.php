<?php defined('SYSPATH') or die('No direct script access.');
/*
 命名规则：
     1.尽量用英文单词而不是拼音,且以下划线分开, eg.kind_name
     2.参数类型为'id'的，以'_id'结尾，eg.line_id
     3.字段的中文名用'字段名称'(去掉id)+'_name',  eg. rankid => rank_name
     4.关联数组字段以'_info'结尾, eg. member_info
     5.索引数组字段以'_list'结尾，eg. tourer_list
     6.表示数字的以'_num'或'_count'结尾，eg. comment_num
     7.私有变量请使用protected限定符
 */


interface Interface_Product
{

    public function action_channel();

    /**
     * 产品列表
     *******
      *传入通用参数规则：
            dest_py：目的地拼音;
            day_id:日期id;
            price_id:价格id;
            sort_type: 排序方式;
            startcity_id:出发城市id;
            attr_id:属性id;
            kind_id:目的地id;
            page:页数;
            keyword:搜索关键词;
            page_size：每页数量;
     ********
     *返回规则:
      array(
          data=>$list,//数据列表
          row_count=>100,//总数
       )
     */
    public function action_list();

    /**
     * 产品详情
     *******
     * 返回数据通用字段名称规则:
          seo_info: seo信息;
          pic_list:图片列表;
          litpic:产品封面图片
          attr_list:属性列表;
          startcity_name:出发城市名称;
          comment_num:评论数;
          sell_num:销售数量;
          series:产品编号;
          icon_list:图标列表;
          satisfy_score:满意度;
          extend_info:扩展字段列表;
          suit_list:套餐列表;
          introduce_list:内容介绍列表;
     ********
     * 返回规则:
         一个关联数组
     */
    public function action_detail();
   /*
     * 获取报价
     */
    public function action_price();
    /**
     * 创建订单
     ***********
     * 通用字段名称规则:
        web_id:网站id;
        ding_num：预订数量或成人数量;
        child_num:儿童数量;
        old_num: 老人数量;
        suit_id:套餐ID;
        product_id：产品ID;
        remark:预订说明,
        use_date:使用日期,eg.2015-05-08 12:00:00
        end_date:结束日期,eg.2015-06-01 12:00:00
        tourer_list=>[
              {
                  name:游客姓名
                  birthday:出生日期
                  card_type:证件类型
                  card_number:证件号码
                  sex:性别
                  phone:手机
                  email:邮件
               }
               ......
           ]:游客列表;
        member_id:会员id;
        link_info=>{
               name:联系人姓名
               phone:联系人电话
               email:联系人邮件
           }:联系人信息;
        privilege_info=>{
               price_jifen:抵现使用的积分
               coupon_id:优惠券ID
           }:优惠信息;
        bill_info=>{
              title:发票抬头,
              receiver:收件人,
              phone:电话,
              province:省份,
              city:城市,
              address:详细地址
            };发票信息;
     */
    public function action_create_order();
}