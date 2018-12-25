# 景点api使用文档

## 1. 广告图调用

### 请求说明

---        |  ---
接口地址   | `http://api.stcms.com/api/standard/spot/get_rolling_ad`
请求方式   | `POST`
##### 返回结果
*** JSON示例 ***

```
{
    status: 1, 
    data: {id: "7", webid: "0", flag: "2", custom_label: "", kindlist: "",…}
}

```



### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
name   | string   |  是      | 调用标示 或 广告ID | SpotRollingAd

## 2. 栏目信息

### 请求说明

---        |  ---
接口地址   | `http://api.stcms.com/api/standard/spot/channel`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
##### 返回结果
*** JSON示例 ***

```
{
 "status":1,
 "data":{"id":"2","webid":"0",...}
}
```



## 3. 景点列表

### 请求说明

---        |  ---
接口地址   | `http://api.stcms.com/api/standard/spot/list`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
pagesize   | string   |  是      | 每页条数 | 8
page   | string   |  是      | 当前页码 | 1
keyword   | string   |  否      | 关键词 | 成都
dest_name | string |否 |目的地 | 成都
price_id  | int	|否 |价格范围ID | 1
sort_type | int |否 |排序类型 |值1:价格升序,2:价格降序,3:销量降序,4:推荐
attr_id	|int |否 |属性id |多个属性由"_"分隔,如'1_3'

##### 返回结果
*** JSON示例 ***

```
{
 status: 1, 
 data: {
	data: [
	 {id: "6", webid: "0", aid: "6", title: "九寨沟红宝石大酒店", seotitle: "", lineclass: null, hotelrankid: "3"}
	 {id: "7", webid: "0", aid: "6", title: "九寨沟红宝石大酒店2", seotitle: "", lineclass: null, hotelrankid: "3"}
	  …
	 ],
	row_count: 10
	}
}

```





## 4. 景点详情

### 请求说明

---        |  ---
接口地址   | `http://api.stcms.com/api/standard/spot/detail`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
product_id   | string   |  是      | 景点id | 1
##### 返回结果
*** JSON示例 ***

```
{
 status:true
 data:
	{id: "4", webid: "0", aid: "4", title: "上海迪士尼", shortname: "上海迪士尼", seotitle: "", isspotarea: "0",…}
}

```



## 5. 日历报价

### 请求说明

---        |  ---
接口地址   | `http://api.stcms.com/api/standard/spot/price`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
suitid   | string   |  是      | 套餐id | 1
row   | string   |  是      | 返回记录数 | 30
year   | string   |  是      | 请求年份 | 2017
month   | string   |  是      | 请求月份 | 05

##### 返回结果
*** JSON示例 ***

```
{
	status:true,
	data:{
	  list:[{spotid: "4", ticketid: "4", day: "1496937600", childprofit: null, childbasicprice: null,…},…]
	}
}

```




## 6. 创建订单

### 请求说明

---        |  ---
接口地址   | `http://api.stcms.com/api/standard/spot/create_order`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
typeid   | string   |  是      | 景点模块id | 5
product_id   | string   |  是      | 景点自增id | 2
product_aid   | string   |  是      | 景点aid | 2
product_name   | string   |  是      | 景点名称 | 青城山
price   | int   |  是      | 价格 | 146
link_info|array |是 |联系人信息|link_info=array('name'=>'张三','phone'=>'1380000000','email'=>'')
remark   | string   |  是      | 备注信息 | 需要带雨伞吗
member_id   | string   |  否      | 会员id | 2
suit_id   | string   |  是      | 套餐id | 2
ding_num   | int   |  是      | 预定数 | 3
paytype   | int   |  是      | 支付类型 | 1
dingjin   | int   |  是      | 定金 | 0
use_date   | string   |  是      | 使用日期 | 2017-05-15

#### 注意:
   1. 域名需要换成自己的
   2. 当支付类型为定金支付的时候,定金不能为0

##### 返回结果
---

```
{
  status:true,
  data:{
    status:true,
    orderinfo:{id:1,ordersn:050525262...}
  }
}

```


