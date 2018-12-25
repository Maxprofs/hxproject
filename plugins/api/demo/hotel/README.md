# 酒店api使用文档

## 1. 广告图调用

### 请求说明

---        |  ---
接口地址   | `/api/standard/hotel/get_rolling_ad`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
name   | string   |  是      | 调用标示 | IndexRollingAd

##### 返回结果
*** JSON示例 ***

```
{
    status: 1, 
    data: {id: "7", webid: "0", flag: "2", custom_label: "", kindlist: "",…}
}

```

## 2. 栏目信息

### 请求说明

---        |  ---
接口地址   | `/api/standard/hotel/channel`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
##### 返回结果
*** JSON示例 ***

```
{
   status:true, 
   data:{id: "2", webid: "0", aid: "3", typeid: "2", pid: "0", typename: "", shortname: "酒店",…}
}

```

## 3. 酒店列表

### 请求说明

---        |  ---
接口地址   | `/api/standard/hotel/list`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
pagesize   | string   |  是      | 每页条数 | 8
page   | string   |  是      | 当前页码 | 1
keyword   | string   |  否      | 关键词 | 四川
dest_name | string   |  否	|目的地	 | 四川
price_id  | int	     |  否	|价格范围ID| 1
sort_type | int      |  否      |排序类型| 1,价格升序 2,价格降序,3 销量降序,4,推荐
attr_id   | string   |  否	|属性id |多个属性由"_"分隔,如'1_3'
start_time| string   |  否	|入住时间|2017-06-08
end_time  | string   |  否	|离店时间|2017-06-09
rank_id   | int   |  否	|星级id |1
geo       | array    |否	|定位标识 |geo=array('lat'=>'','lng'=>'','distance'=>'')		
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


## 4. 酒店详情

### 请求说明

---        |  ---
接口地址   | `/api/standard/hotel/detail`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
product_id   | string   |  是      | 酒店id | 1
##### 返回结果
*** JSON示例 ***
```
{
 status: true, 
 data: {id: "6", webid: "0", aid: "6", title: "九寨沟红宝石大酒店", seotitle: "", lineclass: null, hotelrankid: "3",…}
}
```

data
:


## 5. 日历报价

### 请求说明

---        |  ---
接口地址   | `/api/standard/hotel/price`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
suit_id   | string   |  是      | 套餐id | 1
row   | string   |  是      | 返回记录数 | 30
year   | string   |  是      | 请求年份 | 2017
month   | string   |  是      | 请求月份 | 05
##### 返回结果
*** JSON示例 ***

```
{
	status:true,
	data:{
	  list:[{hotelid: "4", ticketid: "4", day: "1496937600", childprofit: null, childbasicprice: null,…},…]
	}
}

```

## 6. 根据入住日期和离店日期计算报价

### 请求说明

---        |  ---
接口地址   | `/api/standard/hotel/range_price`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
suit_id   | string   |  是      | 套餐id | 1
start_date   | string   |  是      | 入住时间 | 2017-06-08
end_date   | string   |  是      | 离店时间 | 2017-06-09
ding_num   | string   |  是      | 预订数量 | 1

##### 返回结果
*** JSON示例 ***

```
{
 status: 1, 
 data: {
    price: 1180
 }
}

```



## 7. 创建订单

### 请求说明

---        |  ---
接口地址   | `/api/standard/hotel/create`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
typeid   | string   |  是      | 酒店 | 2
product_id   | string   |  是      | 酒店 | 2
product_aid   | string   |  是      | 酒店aid | 2
product_name   | string   |  是      | 产品名称 | 青城山
price   | int   |  是      | 价格 | 146
link_info|array |是 |联系人信息|link_info=array('name'=>'张三','phone'=>'1380000000','email'=>'')
remark   | string   |  是      | 备注信息 | 需要带雨伞吗
member_id   | string   |  否      | 会员id | 2
suit_id   | string   |  是      | 套餐id | 2
ding_num   | int   |  是      | 预定数 | 3
paytype   | int   |  是      | 支付类型 | 1
dingjin   | int   |  是      | 定金 | 0
paytype   | int   |  是      | 支付类型 | 1
dingjin   | int   |  是      | 定金 | 0
use_date   | string   |  是      | 使用日期 | 2017-05-15

#### 注意:
   1. 域名需要换成自己的
   2. 当支付类型为定金支付的时候,定金不能为0

##### 返回结果
*** JSON示例 ***

```
{
  status:true,
  data:{
    status:true,
    orderinfo:{id:1,ordersn:020525262...}
  }
}

