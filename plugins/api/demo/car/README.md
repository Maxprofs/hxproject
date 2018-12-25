# 租车api使用文档

## 1. 广告图调用

### 请求说明

---        |  ---
接口地址   | `http://api.stcms.com/api/standard/car/get_rolling_ad`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
name   | string   |  是      | 调用标示 或 广告ID | s_car_index_1

## 2. 栏目信息

### 请求说明

---        |  ---
接口地址   | `http://api.stcms.com/api/standard/car/channel`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---

## 3. 租车列表

### 请求说明

---        |  ---
接口地址   | `http://api.stcms.com/api/standard/car/list`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
pagesize   | string   |  是      | 每页条数 | 8
page   | string   |  是      | 当前页码 | 1
keyword   | string   |  否      | 关键词 | 成都

## 4. 租车详情

### 请求说明

---        |  ---
接口地址   | `http://api.stcms.com/api/standard/car/detail`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
productid   | string   |  是      | 租车id | 1

## 5. 日历报价

### 请求说明

---        |  ---
接口地址   | `http://api.stcms.com/api/standard/car/price`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
suitid   | string   |  是      | 套餐id | 1
row   | string   |  是      | 返回记录数 | 30
year   | string   |  是      | 请求年份 | 2017
month   | string   |  是      | 请求月份 | 05

## 6. 创建订单

### 请求说明

---        |  ---
接口地址   | `http://api.stcms.com/api/standard/car/create_order`
请求方式   | `POST`

### 参数说明

参数名 | 参数类型 | 是否必填 | 参数说明 | 示例
---    |  ---     |  ---     | ---      | ---
typeid   | string   |  是      | 租车模块id | 5
productautoid   | string   |  是      | 租车自增id | 2
productautoaid   | string   |  是      | 租车aid | 2
productname   | string   |  是      | 租车名称 | 雪佛兰
price   | int   |  是      | 价格 | 150
linkman   | string   |  是      | 联系人 | 隔壁老王
linktel   | string   |  是      | 联系电话 | 18612345678
remark   | string   |  是      | 备注信息 | 我写的备注信息
memberid   | string   |  否      | 会员id | 2
suitid   | string   |  是      | 套餐id | 2
dingnum   | int   |  是      | 预定数 | 3
paytype   | int   |  是      | 支付类型 | 1
dingjin   | int   |  是      | 定金 | 0
usedate   | string   |  是      | 使用日期 | 2017-05-15

#### 注意:
   1. 域名需要换成自己的
   2. 当支付类型为定金支付的时候,定金不能为0
