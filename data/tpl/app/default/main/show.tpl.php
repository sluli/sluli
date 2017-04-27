<?php defined('IN_IA') or exit('Access Denied');?>﻿<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <style type="text/css">
        body{padding: 0px; margin: 0px;}
        footer{background: #ffffff; border-top: #f798a0 2px solid; height: 55px; line-height: 50px; font-size: 16px; color: #f798a0; }
        .avatar{width: 70px; float: left;}
        .avatar img{margin: 20px 10px;}
        .nickname{float: left; line-height: 25px; width: 150px; padding-top: 15px; overflow: hidden;}
        .buyBtn{float: right; width: 130px; padding-top: 15px;}
        .buyBtn a{display: inline-block; background: #fe0000; border-radius: 5px; padding: 0px 20px; color: #ffffff;}

        .buyTable{font-size: 14px;}
        .buyTable a{display: block; background: #fe0000; border-radius: 5px;
            padding: 0px 20px; color: #ffffff; text-align: center; height: 40px;
            line-height: 40px; font-size: 18px;
        }
    </style>
<body>
    <iframe src="<?php  echo $market['show_link'];?>" width="100%" frameborder="0"></iframe>
    <?php  if($isMain == 1) { ?>
        <?php  if($flag == 0) { ?>
        <footer>
            <center>专属链接已生成，请收藏并分享给朋友<?php  echo $flag;?></center>
        </footer>
        <?php  } else { ?>
            <footer>
                <center>专属链接已生成，请分享给朋友<?php  echo $flag;?></center>
            </footer>
        <?php  } ?>
    <?php  } else { ?>
    <footer>
        <table width="100%" cellspacing="5" class="buyTable">
            <tr>
                <td width="40">
                    <img src="/uploads/<?php  echo $users['avatar'];?>" width="40" height="40" />
                </td>
                <td width="100">
                    <?php  echo $users['nickname'];?>的推荐<br />每人限领一套
                </td>
                <td>
                    <a href="<?php  echo urlGo('form', 'add', ['id'=>$_GPC['id'], 'openid'=>$openid])?>" class="dBuyBtn">点此领取</a>
                </td>
            </tr>
        </table>
        <!--<div class="avatar">-->
            <!--<img src="/uploads/<?php  echo $users['avatar'];?>" width="40" height="40" />-->
        <!--</div>-->
        <!--<div class="nickname">-->

        <!--</div>-->
        <!--<div class="buyBtn">-->

        <!--</div>-->

    </footer>
    <?php  } ?>
<script type="text/javascript">
    $(function () {
        $("iframe").css('height', $(window).height()-55);
    })
    <?php  if($target_url) { ?>
    wx.config({
        debug: false,
        appId: '<?php  echo $signPackage["appId"];?>',
        timestamp: <?php  echo $signPackage["timestamp"];?>,
        nonceStr: '<?php  echo $signPackage["nonceStr"];?>',
        signature: '<?php  echo $signPackage["signature"];?>',
        jsApiList: [
            'onMenuShareTimeline',
            'onMenuShareAppMessage'
        ]
    });
//    ,
    //            'onMenuShareQQ',
    //            'onMenuShareWeibo',
    //            'onMenuShareQZone'
    wx.ready(function(){

        wx.onMenuShareTimeline({
            title: "<?php  echo $market['title'];?>", // 分享标题因为微信授权的话，微信公众平台那边是要配置回调域名的。。。
            link: "<?php  echo $target_url;?>", // 分享链接
            desc: "<?php  echo $market['intro'];?>", // 分享图标
            imgUrl: "http://<?php  echo $_SERVER['HTTP_HOST'];?>/uploads/<?php  echo $market['thumb'];?>",
            success: function () {
                // 用户确认分享后执行的回调函数
                //alert('OK')
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        wx.onMenuShareAppMessage({
            title: "<?php  echo $market['title'];?>", // 分享标题
            link: "<?php  echo $target_url;?>", // 分享链接
            desc: "<?php  echo $market['intro'];?>", // 分享图标
            imgUrl: "http://<?php  echo $_SERVER['HTTP_HOST'];?>/uploads/<?php  echo $market['thumb'];?>",
            success: function () {
                // 用户确认分享后执行的回调函数
                //alert('OK')
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
                //alert('cancel')
            }
        });
    });
    <?php  } ?>
</script>
</body>
</html>