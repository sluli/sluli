<?php defined('IN_IA') or exit('Access Denied');?>﻿<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<body id="card"  class="mode_webapp">
<div class="menu_header">
    <div class="menu_topbar">
        <strong class="head-title">员工后台</strong>
        <a class="head_btn_right" href="?ac=cardunion&tid=30166&c=oSEUut21z7RDtrk5ZfrQzhRr60xw">
            <span><i class="menu_header_home"></i></span><b></b>
        </a>
    </div>
</div>

<div id="overlay"></div>
<div class="cardcenter">
    <div class="card"><img class="cardbg" src="./resource/css/img/card_bg02.png"><img id="cardlogo" class="logo" src="./resource/css/img/logo.png"><h1 style="color:#000000">&nbsp;</h1>
        <strong class="pdo verify" style="color:#080106"><span id="cdnb" ><em >ID:</em><?php  echo $_W['user']['name'];?></span></strong> </div>
    <p class="explain"><span>关乎个人利益 密码妥善保管</span></p>
    <div class="window" id="windowcenter">
        <div id="title" class="wtitle">领卡信息<span class="close" id="alertclose"></span></div>
        <div class="content">
            <div id="txt"></div>
            <p>
                <input name="truename" value=""  class="px" id="truename"  type="text" placeholder="请输入您的姓名">
            </p>
            <p>
                <input name="tel"  class="px" id="tel"  value=""   type="number"  placeholder="请输入您的电话">
            </p>
            <input type="button" value="确 定" name="确 定" class="txtbtn" id="windowclosebutton">
        </div>
    </div>
</div>

<div class="cardexplain" >

    <!--会员积分信息-->
    <div class="jifen-box">
        <ul class="zongjifen">
            <li><div class="fengexian"><p>今日订单</p><span><?php  echo $toDayOrderNum;?></span></div></li>
            <li><a href="javascript:;"><div class="fengexian"><p>昨日订单</p><span><?php  echo $yesterDayOrderNum;?></span></div></a></li>
            <li><a href="javascript:;"><p>本月订单</p><span><?php  echo $monthOrderNum;?></span></a></li>
        </ul>
        <div class="clr"></div>
    </div>

    <div class="jifen-box">
        <ul class="zongjifen">
            您今日正常订单 <b style='color:#0000ff;'><?php  echo $toDayOKOrderNum;?></b> 个，可疑订单 <b style='color:#ff0000;'><?php  echo $toDayNoOrderNum;?></b> 个，请核实订单信息之后，确定是否发货！收藏专属链接的时候，请先<font style="color:#CD00CD;"><b>等待缓冲完毕</b></font>之后再收藏！</a>
        </ul>
        <div class="clr"></div>
    </div>

    <ul class="round"  id="powerandgift"  >
        <li><a href="<?php  echo urlGo('order','index')?>"><span>查看我的 <font style="color:#0000EE;">正常订单</font></span></a></li>
    </ul>

<ul class="round">
<li><a href="<?php  echo urlGo('order','index',['dubious'=>1])?>"><span>查看我的 <font style="color:#FF0000;">异常订单</font></span></a></li>
    </ul>


    <ul class="round">
        <!--<li class="gift" style="border-radius: 0px;  line-height: 40px;"><a href="http://agent.hthzu.com/3cuc_admin/a/s1606139624807900/cm0001/wx_group/index.php/cx/Cx_index/ewm/?openid=ohT_1sq-fhlgOxWrlU0G50j1fv-I&cxid=A2016030"><span>我的推广名片</span></a></li> -->
        <li class="gift" style="border-radius: 0px;  line-height: 40px;" onclick="hit()"><span id="change_span" style="color: #333;">我的专属链接</span>
            <ul style="display:none;" id="hit">
                <?php  if(is_array($market_list)) { foreach($market_list as $row) { ?>
                <li class="hit">
                    <a href="http://<?php  echo $domain;?>/app/<?php  echo urlGo('main', 'show', ['id'=>$row['id'].'_'.$_W['uid']])?>">
                        <span style="font-size:13px;"><?php  echo $row['title'];?></span>
                    </a>
                </li>
                <?php  } } ?>

            </ul>
        </li>
    </ul>
    <ul class="round">
        <li class="tel"><a href="QQ:2055204423"><span>技术支持QQ：2055204423</span></a></li>
    </ul>
    <ul class="round"  id=""  >
        <li><a href="<?php  echo urlGo('main','login', ['act'=>'out'])?>"><span>退出登录</span></a></li>
    </ul>

</div>

<script>
    $(document).ready(function(){
        $("#fa1").attr("class","active");
    });

    function hit(){
        $("#hit").css("display","block");
        $("#change_span").addClass("spanover");
    }

    $('.hit').bind('click', function() {
        $("#hit").css("display","none");
        $("#change_span").removeClass("spanover");
        event.stopPropagation();
    });
</script>
<div style="height:2em;">

</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>