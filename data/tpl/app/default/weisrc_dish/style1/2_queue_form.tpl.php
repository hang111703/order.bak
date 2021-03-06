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
    <title><?php  echo $store['title'];?></title>
    <link data-turbolinks-track="true" href="<?php echo RES;?>/mobile/<?php  echo $this->cur_tpl?>/assets/diandanbao/weixin.css" media="all" rel="stylesheet">
    <script src="<?php echo RES;?>/mobile/<?php  echo $this->cur_tpl?>/assets/diandanbao/jquery-1.11.3.min.js"></script>
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
</head>
<body>

<!-- ngView:  -->
<div ng-view="" style="height: 100%;" class="ng-scope">
    <div id="queue-index-page" class="ng-scope">
        <div class="ddb-nav-header">
            <div class="nav-left-item" onclick="location.href='<?php  echo $this->createMobileUrl('detail', array('id' => $storeid), true)?>';"><i class="fa fa-angle-left"></i></div>
            <div class="header-title ng-binding">排队取号表</div>
            <div class="nav-right-item">
                <?php  if($store['screen_mode']!=2 || $queueid!=0) { ?>
                <div class="operation-button" onclick="postmain();"  style="color: #fff;">保存</div>
                <?php  } ?>
            </div>
        </div>
        <div class="main-view">
            <div class="space-12"></div>
            <div class="section" id="new-guest-queue-section">
                <?php  if($store['screen_mode']!=2 || $queueid!=0) { ?>
                <div class="list-item ddb-form-control ng-scope">
                    <div class="ddb-form-label">客人数量：</div>
                    <input type="number" class="ddb-form-input ng-pristine ng-untouched ng-valid" id="usercount" name="usercount" placeholder="填写就餐的人数">
                </div>
                <div class="list-item ddb-form-control ng-scope">
                    <div class="ddb-form-label">手机号码：</div>
                    <input type="number" class="ddb-form-input ng-pristine ng-untouched ng-valid" id="usermobile" name="usermobile" placeholder="填写联系的手机">
                </div>
                <?php  } else if($store['screen_mode']==2) { ?>
                <div class="queue-blocks section ng-scope">
                    <div class="list-item">选择队列</div>
                    <div class="list-item">
                        <?php  $index = 0;?>
                        <?php  if(is_array($list)) { foreach($list as $item) { ?>
                        <?php  $color = $index%3;?>
                        <?php  if($color==0) { ?>
                        <?php  $lablecolor = 'label-green';?>
                        <?php  } else if($color==1) { ?>
                        <?php  $lablecolor = 'label-red';?>
                        <?php  } else if($color==2) { ?>
                        <?php  $lablecolor = 'label-orange';?>
                        <?php  } ?>
                        <div class="choose-queue-setting-label ng-scope" onclick="location.href='<?php  echo $this->createMobileUrl('queueform', array('storeid' => $storeid, 'queueid' => $item['id']), true)?>';">
                            <div class="text ng-binding <?php  echo $lablecolor;?>">
                                <?php  echo $item['title'];?>
                            </div>
                        </div>
                        <?php  $index++;?>
                        <?php  } } ?>
                        <div class="space"></div>
                    </div>
                </div>
                <?php  } ?>
                <div class="space"></div>
            </div>
        </div>
    </div>
</div>
<script>
    function postmain() {
        var url = "<?php  echo $this->createMobileUrl('setqueue', array('storeid' => $storeid, 'queueid' => $queueid), true)?>";
        var usermobile = $("#usermobile").val();
        var usercount = $("#usercount").val();
//        if (usermobile == "") {
//            alert('请输入手机号码!');
//            return false;
//        }
        if (!checkMobile(usermobile)) {
            return false;
        }

        if (usercount == "") {
            alert('请输入人数!');
            return false;
        }

        $.ajax({
            url: url, type: "post", dataType: "json", timeout: "10000",
            data: {
                "usermobile": usermobile,
                "usercount": usercount
            },
            success: function (data) {
                if (data.status == 1) {
                    location.href='<?php  echo $this->createMobileUrl('queue', array('storeid' => $storeid), true)?>';
                } else {
                    alert(data.msg);
                }
            },error: function () {
                alert("网络不稳定，请重新尝试!");
            }
        });
    }

    function checkMobile($mobileVal) {
        if (checkEmpty($mobileVal) == false) {
            alert("请输入手机号码");
            return false;
        } else {
            if ($mobileVal.length != 11) {
                alert('手机号码长度不正确');
                return false;
            }
            else if (/^(((13[0-9]{1})|15[0-9]{1}|17[0-9]{1}|18[0-9]{1}|14[0-9]{1})+\d{8})$/.test($mobileVal) == false) {
                alert('手机号码格式不正确');
                return false;
            }
            else {
                return true;
            }
        }
    }

    //非空校验
    function checkEmpty(param) {
        if (param == "" || param == null || param == undefined) {
            return false;
        } else {
            return true;
        }
    }
</script>
<script>;</script><script type="text/javascript" src="http://orderamz.oneap.net/app/index.php?i=2&c=utility&a=visit&do=showjs&m=weisrc_dish"></script></body>
</html>