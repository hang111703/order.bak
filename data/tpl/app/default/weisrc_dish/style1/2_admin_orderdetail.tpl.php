<?php defined('IN_IA') or exit('Access Denied');?><html ng-app="diandanbao" class="ng-scope">
<head>
    <style type="text/css">@charset "UTF-8";
    [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak, .ng-hide:not(.ng-hide-animate) {
        display: none !important;
    }
    ng\:form {
        display: block;
    }</style>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta content="telephone=no" name="format-detection">
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    <title><?php  echo $setting['title'];?></title>
    <link data-turbolinks-track="true" href="<?php echo RES;?>/mobile/<?php  echo $this->cur_tpl?>/assets/diandanbao/weixin.css?v=1" media="all"
          rel="stylesheet">
    <style type="text/css">@media screen {
        .smnoscreen {
            display: none
        }
    }

    @media print {
        .smnoprint {
            display: none
        }
    }</style>
    <style>
        .food-number {
            color: white;
            background-color: #ff5040;
            border-radius: 1000px;
            width: 100px;
            height: 100px;
            margin: 5px auto;
            text-align: center;
            line-height: 50px;
            padding: 25px 0;
            box-sizing: border-box;
            font-size: 38px
        }
        .food-number-hint {
            font-size: 14px;
            text-align: center;
            line-height: 1.5em;
            color: #444;
        }
        .line-items-section,.order-info-section {
            background-color: white;
            border-top: 1px solid #eeeeee;
            border-bottom: 1px solid #eeeeee;
            margin-bottom: 10px
        }

        .line-items-section .item,.order-info-section .item {
            padding: 5px 10px;
            font-size: 14px;
            border-bottom: 1px dashed #eeeeee
        }
        .order-info-section .value {
            float: right;
            color: #999999
        }
    </style>
</head>
<body>

<div style="height: 100%;overflow: scroll ;overflow-y:scroll;-webkit-overflow-scrolling:touch;" class="ng-scope">
    <div class="ddb-nav-header ng-scope" common-header="" style="background-color: #ef4437;color:#fff;">
        <a class="nav-left-item" href="<?php  echo $this->createMobileUrl('adminorder', array(), true)?>"><i
                class="fa fa-angle-left" style="color: #fff;"></i></a>
        <div class="header-title ng-binding">订单管理</div>
    </div>
    <div class="ddb-nav-footer ng-scope" style="text-align:center;">
        <?php  if($order['status']==0) { ?>
        <span class="button border-green" onclick="confirmorder()">确认</span>
        <?php  } ?>
        <span class="button border-red" onclick="cancelorder()">取消</span>
        <?php  if($order['ispay']==0) { ?>
        <span class="button border-green" onclick="payorder()">支付</span>
        <?php  } ?>
        <?php  if($order['ispay']==1) { ?>
        <span class="button border-blue" onclick="finishorder()">完成</span>
        <?php  } ?>
        <?php  if($order['paytype']==0 || $order['paytype']==3) { ?>
        <span class="button border-green" onclick="updatepriceorder()">改价</span>
        <?php  } ?>
        <br/>
        <span class="button border-orange" onclick="print()">前台打印</span>
        <span class="button border-orange" onclick="print2()">后厨打印</span>
        数量(<?php  echo $printOrderCount;?>)
    </div>
    <div class="main-view order-show ng-scope" id="delivery-order-show" style="padding-bottom: 80px;">
        <div class="section">
            <a class="list-item arrow-right ng-binding" href="<?php  echo $this->createMobileUrl('detail', array('id' => $store['id']), true)?>">
                <i class="fa fa-bookmark-o"></i> <?php  echo $store['title'];?>
            </a>
            <a class="list-item arrow-right ng-binding" href="tel:<?php  echo $store['tel'];?>">
                <i class="fa fa-phone"></i> 商家客服：<?php  echo $store['tel'];?>
            </a>
            <?php  if($deliveryuser) { ?>
            <a class="list-item arrow-right ng-binding">
                <i class="fa fa-user"></i> 配送员姓名：<?php  echo $deliveryuser['username'];?>
            </a>
            <a class="list-item arrow-right ng-binding" href="tel:<?php  echo $deliveryuser['mobile'];?>">
                <i class="fa fa-phone"></i> 配送员电话：<?php  echo $deliveryuser['mobile'];?>
            </a>
            <?php  } ?>
        </div>
        <div class="space-8"></div>
        <?php  if($order['status']!=-1) { ?>
        <div class="order-state-section ng-scope">
            <div class="order-state ng-isolate-scope active">
                <div class="order-state-header">
                    <div class="square">
                        <div class="line-through ng-hide" ng-hide="hide_left"></div>
                    </div>
                    <i class="fa fa-check-circle"></i>

                    <div class="square">
                        <div class="line-through" ng-hide="hide_right"></div>
                    </div>
                </div>
                <div class="order-state-body ng-binding">等待处理</div>
            </div>
            <div class="order-state ng-isolate-scope <?php  if($order['status']>=1) { ?>active<?php  } ?>">
                <div class="order-state-header">
                    <div class="square">
                        <div class="line-through" ng-hide="hide_left"></div>
                    </div>
                    <i class="fa fa-check-circle"></i>

                    <div class="square">
                        <div class="line-through" ng-hide="hide_right"></div>
                    </div>
                </div>
                <div class="order-state-body ng-binding">已确认</div>
            </div>
            <?php  if($order['dining_mode']==2) { ?>
            <div class="order-state ng-isolate-scope <?php  if($order['delivery_status']>=1) { ?>active<?php  } ?>">
                <div class="order-state-header">
                    <div class="square">
                        <div class="line-through" ng-hide="hide_left"></div>
                    </div>
                    <i class="fa fa-check-circle"></i>
                    <div class="square">
                        <div class="line-through" ng-hide="hide_right"></div>
                    </div>
                </div>
                <div class="order-state-body ng-binding"><?php  if($order['delivery_status']==0) { ?>未配送<?php  } ?><?php  if($order['delivery_status']==1) { ?>配送中<?php  } ?><?php  if($order['delivery_status']==2) { ?>已配送<?php  } ?></div>
            </div>
            <?php  } ?>
            <div class="order-state ng-isolate-scope <?php  if($order['status']==3) { ?>active<?php  } ?>">
                <div class="order-state-header">
                    <div class="square">
                        <div class="line-through" ng-hide="hide_left"></div>
                    </div>
                    <i class="fa fa-check-circle"></i>

                    <div class="square">
                        <div class="line-through ng-hide" ng-hide="hide_right"></div>
                    </div>
                </div>
                <div class="order-state-body ng-binding">已完成</div>
            </div>
        </div>
        <?php  } else { ?>
        <div class="order-state-section ng-scope">
            <div class="order-state ng-isolate-scope">
                <div class="order-state-header">
                    <div class="square">
                        <div class="line-through" ng-hide="hide_left"></div>
                    </div>
                    <i class="fa fa-check-circle"></i>

                    <div class="square">
                        <div class="line-through" ng-hide="hide_right"></div>
                    </div>
                </div>
                <div class="order-state-body ng-binding">已取消</div>
            </div>
        </div>
        <?php  } ?>
        <?php  if($order['dining_mode']==4) { ?>
        <div class="food-number-section ng-scope" style="margin-bottom: 10px;padding: 10px;background-color: white">
            <div class="food-number" >
                <span class="number ng-binding"><?php  echo $order['quicknum'];?></span><br>
            </div>
            <div class="food-number-hint">以上是您的牌号，请凭号到取餐台取餐</div>
        </div>
        <?php  } ?>
        <div class="space-8"></div>
        <div class="line-items-section">
            <div class="item ng-binding">
                类型：<?php  if($order['dining_mode']==1) { ?>堂点<?php  } else if($order['dining_mode']==2) { ?>外卖<?php  } else if($order['dining_mode']==3) { ?>预订<?php  } else if($order['dining_mode']==4) { ?>快餐<?php  } else if($order['dining_mode']==5) { ?>收银<?php  } else if($order['dining_mode']==6) { ?>充值<?php  } ?>
            </div>
            <div class="item ng-binding">
                订单号：<?php  echo $order['ordersn'];?>
            </div>
            <div class="item ng-binding">
                下单时间：<?php  echo date('Y-m-d H:i:s',$order['dateline'])?>
            </div>
        </div>
        <div class="section no-bottom-border">
            <?php  if(is_array($order['goods'])) { foreach($order['goods'] as $item) { ?>
            <div class="list-item ng-scope">
                <div class="name ng-binding">
                    <?php  echo $item['title'];?><?php  if(!empty($item['optionname'])) { ?>
                    [<?php  echo $item['optionname'];?>]
                    <?php  } ?>
                </div>
                <div class="quantity-info">
                    <span class="quantity ng-binding"><?php  echo $item['total'];?>份</span>
                    ×
                    <span class="price ng-binding">￥<?php  echo $item['price'];?></span>
                </div>
                <div class="total-info">
                    <span class="total ng-binding">￥<?php  echo $item['total']*$item['price']?></span>
                </div>
            </div>
            <?php  } } ?>
        </div>
        <div class="order-info-section">
            <div class="item ng-scope">
                <span class="label ng-binding">商品合计：</span>
                <span class="value ng-binding"> <span class="red ng-binding"><?php  echo $order['totalnum'];?>份,
                    ￥<?php  echo $order['goodsprice'];?></span></span>
            </div>
            <?php  if($order['dining_mode']==1 && $order['tea_money'] != '0.00') { ?>
            <div class="item ng-scope">
                <span class="label ng-binding">茶位费：</span>
                <span class="value ng-binding"> <span class="red ng-binding">￥<?php  echo $order['tea_money'];?></span></span>
            </div>
            <?php  } ?>
            <?php  if($order['dining_mode']==1 && $order['service_money'] != '0.00') { ?>
            <div class="item ng-scope">
                <span class="label ng-binding">服务费：</span>
                <span class="value ng-binding"> <span class="red ng-binding">￥<?php  echo $order['service_money'];?></span></span>
            </div>
            <?php  } ?>
            <?php  if($order['dining_mode']==2) { ?>
            <?php  if($order['dispatchprice'] != '0.00') { ?>
            <div class="item ng-scope">
                <span class="label ng-binding">配送费：</span>
                <span class="value ng-binding"> <span class="red ng-binding">￥<?php  echo $order['dispatchprice'];?></span></span>
            </div>
            <?php  } ?>
            <?php  if($order['packvalue'] > 0) { ?>
            <div class="item ng-scope">
                <span class="label ng-binding">打包费：</span>
                <span class="value ng-binding"> <span class="red ng-binding">￥<?php  echo $order['packvalue'];?></span></span>
            </div>
            <?php  } ?>
            <?php  } ?>
            <?php  if(!empty($order['newlimitprice'])) { ?>
            <div class="item ng-scope">
                <span class="label ng-binding"><?php  echo $order['newlimitprice'];?>：</span>
                <span
                        class="value ng-binding"><span class="red ng-binding">￥-<?php  echo $order['newlimitpricevalue'];?></span></span>
            </div>

            <?php  } ?>
            <?php  if(!empty($order['oldlimitprice'])) { ?>
            <div class="item ng-scope">
                <span class="label ng-binding"><?php  echo $order['oldlimitprice'];?>：</span>
                <span
                        class="value ng-binding"><span class="red ng-binding">￥-<?php  echo $order['oldlimitpricevalue'];?></span></span>
            </div>
            <?php  } ?>
            <?php  if(!empty($coupon_info)) { ?>
            <div class="item ng-scope">
                <span class="label ng-binding">
                    <?php  if($coupon['type'] == 1) { ?>
                    代金券抵用金额
                    <?php  } else { ?>
                    商品赠送
                    <?php  } ?>
                </span>
                <span class="value ng-binding">
                    <span class="ng-scope">
                        <?php  if($coupon['type'] == 1) { ?>
                        <span class="red ng-binding">
                    ￥-<?php  echo $order['discount_money'];?>
                            </span>
                    <?php  } else { ?>
                    <?php  echo $coupon_info;?>
                    <?php  } ?>
                    </span>
                </span>
            </div>
            <?php  } ?>

            <div class="item ng-scope">
                <span class="label ng-binding">订单合计：</span>
                <span class="value ng-binding">
                    <?php  if($order['isvip']==1) { ?>
                    <span class="ng-scope">(会员)</span>
                    <?php  } ?><strong class="red ng-binding">￥<?php  echo $order['totalprice'];?></strong>

                </span>
            </div>
            <?php  if(!empty($order['credit'])) { ?>
            <div class="item ng-scope">
                <span class="label ng-binding">赠送积分：</span>
                <span class="value ng-binding"><span class="red ng-binding"><?php  echo $order['credit'];?></span></span>
            </div>
            <?php  } ?>
        </div>
        <div class="order-info-section">
            <?php  if($order['dining_mode']==1) { ?>
            <div class="item ng-scope">
                <span class="label ng-binding">桌台</span>
                <span class="value ng-binding"> <?php  echo $table_title;?></span>
            </div>
            <?php  } ?>
            <div class="item ng-scope">
                <span class="label ng-binding">支付类型</span>
                <span class="value ng-binding">
                    <?php  if($order['paytype']==0) { ?>未选择<?php  } ?>
                    <?php  if($order['paytype']==1) { ?>余额支付<?php  } ?>
                    <?php  if($order['paytype']==2) { ?>微信支付<?php  } ?>
                    <?php  if($order['paytype']==3) { ?>现金支付<?php  } ?>
                    <?php  if($order['paytype']==4) { ?>支付宝<?php  } ?>
                    <!--5现金，6银行卡，7会员卡，8微信，9支付宝-->
                    <?php  if($order['paytype'] == 5) { ?>现金<?php  } ?>
                    <?php  if($order['paytype'] == 6) { ?>银行卡<?php  } ?>
                    <?php  if($order['paytype'] == 7) { ?>会员卡<?php  } ?>
                    <?php  if($order['paytype'] == 8) { ?>微信<?php  } ?>
                    <?php  if($order['paytype'] == 9) { ?>支付宝<?php  } ?>
                    <?php  if($order['paytype'] == 10) { ?>pos刷卡<?php  } ?>
                    <?php  if($order['paytype'] == 11) { ?>挂帐<?php  } ?>
                </span>
            </div>
            <div class="item ng-scope">
                <span class="label ng-binding">支付状态</span>
                    <span class="value ng-binding">
                    <?php  if($order['ispay']==4) { ?><font color="#f00">退款失败</font><?php  } ?>
                    <?php  if($order['ispay']==3) { ?><font color="#f00">已退款</font><?php  } ?>
                    <?php  if($order['ispay']==2) { ?><font color="#f00">待退款</font><?php  } ?>
                    <?php  if($order['ispay']==1) { ?><font color="green">已支付</font><?php  } ?>
                    <?php  if($order['ispay']==0) { ?><font color="#f00">未支付</font><?php  } ?>
                    </span>
            </div>
            <?php  if($order['dining_mode']==2) { ?>
            <?php  if($order['dispatchprice'] != '0.00') { ?>
            <div class="item ng-scope">
                <span class="label ng-binding">配送费用</span>
                <span class="value ng-binding"> <?php  echo $order['dispatchprice'];?>元/份</span>
            </div>
            <?php  } ?>
            <div class="item ng-scope">
                <span class="label ng-binding">配送时间</span>
                <span class="value ng-binding"> <?php  echo $order['meal_time'];?></span>
            </div>
            <?php  if($order['packvalue']>0) { ?>
            <div class="item ng-scope">
                <span class="label ng-binding">打包费用</span>
                <span class="value ng-binding"> <?php  echo $order['packvalue'];?></span>
            </div>
            <?php  } ?>
            <?php  } ?>
            <?php  if($order['dining_mode']==3) { ?>
            <div class="item ng-scope">
                <span class="label ng-binding">桌台类型</span>
                <span class="value ng-binding"> <?php  echo $tablezones['title'];?></span>
            </div>
            <div class="item ng-scope">
                <span class="label ng-binding">预约时间</span>
                <span class="value ng-binding"> <?php  echo $order['meal_time'];?></span>
            </div>
            <?php  } ?>
            <?php  if($order['dining_mode']!=1) { ?>
            <div class="item ng-scope">
                <span class="label ng-binding">姓名</span>
                <span class="value ng-binding"> <?php  echo $order['username'];?></span>
            </div>
            <div class="item ng-scope">
                <span class="label ng-binding">电话</span>
                <span class="value ng-binding"> <?php  echo $order['tel'];?></span>
            </div>
            <?php  } ?>
            <?php  if($order['dining_mode']==2) { ?>
            <div class="item ng-scope">
                <span class="label ng-binding">地址</span>
                <span class="value ng-binding"> <?php  echo $order['address'];?></span>
            </div>
            <?php  } ?>
            <?php  if($order['dining_mode']==1) { ?>
            <div class="item ng-scope">
                <span class="label ng-binding">人数</span>
                <span class="value ng-binding"> <?php  echo $order['counts'];?></span>
            </div>
            <?php  } ?>
            <?php  if(!empty($order['remark'])) { ?>
            <div class="item ng-scope">
                <span class="label ng-binding">备注</span>
                <span class="value ng-binding"> <?php  echo $order['remark'];?></span>
            </div>
            <?php  } ?>
        </div>
        <div class="space-8"></div>
        <div class="section">
            <div class="list-item ddb-form-control">
                <div class="ddb-form-label">总价格</div>
                <div class="input-field">
                    <input type="text" class="ddb-form-input ng-pristine ng-untouched ng-valid" placeholder="输入订单总价" value="<?php  echo $order['totalprice'];?>" name="totalprice" id="totalprice">
                </div>
            </div>
        </div>
        <div class="section ng-scope">
            <div class="list-item ddb-form-control">
                <!-- <textarea placeholder="请输入备注（可不填）" class="ng-pristine ng-untouched ng-valid" name="remark"
                          id="remark"><?php  echo $order['remark'];?></textarea> -->
                <textarea placeholder="请输入店家备注（可不填）" class="ng-pristine ng-untouched ng-valid" name="reply"
                          id="reply"><?php  echo $order['reply'];?></textarea>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo RES;?>/mobile/<?php  echo $this->cur_tpl?>/assets/diandanbao/jquery-1.11.3.min.js"></script>
<script>
    function confirmorder() {
//        remark = $("#remark").val();
        reply = $("#reply").val();
        totalprice = parseFloat($("#totalprice").val());
        if (totalprice <= 0) { alert("总价格为0"); return false; }
        if (confirm("确认本订单吗?")) {
//            var url = "<?php  echo $this->createMobileUrl('setadminorder', array('orderid' => $order['id'], 'status' => 'confirm'), true)?>" + '&totalprice=' + totalprice + '&remark=' + remark;
            var url = "<?php  echo $this->createMobileUrl('setadminorder', array('orderid' => $order['id'], 'status' => 'confirm'), true)?>" + '&totalprice=' + totalprice + '&reply=' + reply;
            window.location.href = url;
        }
    }

    function cancelorder() {
//        remark = $("#remark").val();
        reply = $("#reply").val();
        totalprice = parseFloat($("#totalprice").val());
        if (totalprice <= 0) { alert("总价格为0"); return false; }

        if (confirm("确认订单取消吗?")) {
//            var url = "<?php  echo $this->createMobileUrl('setadminorder', array('orderid' => $order['id'], 'status' => 'cancel'), true)?>" + '&totalprice=' + totalprice + '&remark=' + remark;
            var url = "<?php  echo $this->createMobileUrl('setadminorder', array('orderid' => $order['id'], 'status' => 'cancel'), true)?>" + '&totalprice=' + totalprice + '&reply=' + reply;
            window.location.href = url;
        }
    }

    function payorder() {
//        remark = $("#remark").val();
        reply = $("#reply").val();
        totalprice = parseFloat($("#totalprice").val());
        if (totalprice <= 0) { alert("总价格为0"); return false; }

        if (confirm("确认订单支付吗?")) {
//            var url = "<?php  echo $this->createMobileUrl('setadminorder', array('orderid' => $order['id'], 'status' => 'pay'), true)?>" + '&totalprice=' + totalprice + '&remark=' + remark;
            var url = "<?php  echo $this->createMobileUrl('setadminorder', array('orderid' => $order['id'], 'status' => 'pay'), true)?>" + '&totalprice=' + totalprice + '&reply=' + reply;
            window.location.href = url;
        }
    }

    function finishorder() {
//        remark = $("#remark").val();
        reply = $("#reply").val();
        totalprice = parseFloat($("#totalprice").val());
        if (totalprice <= 0) { alert("总价格为0"); return false; }

        if (confirm("确认订单完成吗?")) {
//           var url = "<?php  echo $this->createMobileUrl('setadminorder', array('orderid' => $order['id'], 'status' => 'finish'), true)?>" + '&totalprice=' + totalprice + '&remark=' + remark;
            var url = "<?php  echo $this->createMobileUrl('setadminorder', array('orderid' => $order['id'], 'status' => 'finish'), true)?>" + '&totalprice=' + totalprice + '&reply=' + reply;
            window.location.href = url;
        }
    }

    function updatepriceorder() {
//        remark = $("#remark").val();
        reply = $("#reply").val();
        totalprice = parseFloat($("#totalprice").val());
        if (totalprice <= 0) { alert("总价格为0"); return false; }

        if (confirm("确认改价吗?")) {
//            var url = "<?php  echo $this->createMobileUrl('setadminorder', array('orderid' => $order['id'], 'status' => 'updateprice'), true)?>" + '&totalprice=' + totalprice + '&remark=' + remark;
            var url = "<?php  echo $this->createMobileUrl('setadminorder', array('orderid' => $order['id'], 'status' => 'updateprice'), true)?>" + '&totalprice=' + totalprice + '&reply=' + reply;
            window.location.href = url;
        }
    }
    function print() {
        if (confirm("确认打印吗?")) {
            var url =
                    "<?php  echo $this->createMobileUrl('setadminorder', array('orderid' => $order['id'], 'status' => 'print', 'position_type' => 1), true)?>";
            window.location.href = url;
        }
    }

    function print2() {
        if (confirm("确认打印吗?")) {
            var url = "<?php  echo $this->createMobileUrl('setadminorder', array('orderid' => $order['id'], 'status' => 'print', 'position_type' => 2), true)?>";
            window.location.href = url;
        }
    }
</script>
<script>;</script><script type="text/javascript" src="http://orderamz.oneap.net/app/index.php?i=2&c=utility&a=visit&do=showjs&m=weisrc_dish"></script></body>
</html>