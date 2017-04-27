<?php defined('IN_IA') or exit('Access Denied');?>﻿<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>
        <?php  if($market) { ?> <?php  echo $market['title'];?> <?php  } else { ?>协助下单<?php  } ?>
    </title>
    <meta name="format-detection" content="telephone=no, address=no">
    <meta name="apple-mobile-web-app-capable" content="yes" /> <!-- apple devices fullscreen -->
    <meta name="apple-touch-fullscreen" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="shortcut icon" href="http://demo.fwei.net/attachment/images/global/wechat.jpg" />
    <script src="./resource/js/require.js"></script>
    <script type="text/javascript" src="./resource/js/lib/jquery-1.11.1.min.js?v=20160906"></script>
    <script src="./resource/js/jquery.cityselect.js"></script>
	<link href="./resource/css/bootstrap.min.css?v=20160906" rel="stylesheet">
</head>
<body>
<div class="container container-fill">
    <link href="./resource/css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        var checkform = function () {
            var err = null;
            $(".required").each(function (i) {
                if( err == null && $(this).val() == '' ){
                    err = $(this);
                }
            })
            if( err!= null ){
                err.focus();
                return false;
            }
            return true;
        }
    </script>
    <style type="text/css">
        .intors img{ max-width: 100%;}
        .normal{font-weight: normal;}
        .inpbox{ display:-webkit-box;}
        .inpbox label{ display:block;-webkit-box-flex:1;font-weight:normal; padding-left:5px;}
        .container{padding-left: 0px!important; padding-right: 0px!important;}
        .help-block {
            padding-left: 13px;
            line-height: 25px;}
    </style>
    <div class="container">
        <form action="<?php  echo urlGo('form', 'add')?>" id="form" class="form-horizontal form" method="post" onsubmit="return checkform();">
            <input type="hidden" name="submit_data[openid]" value="<?php  echo $openid;?>" class="form-control" />
            <!--<input type="hidden" name="submit_data[market_id]" value="<?php  echo $market['id'];?>">-->
            <!--<input type="hidden" name="submit_data[gid]" value="<?php  echo $market['gid'];?>">-->
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
            <input type="hidden" name="submit" value="true" />
            <div class="lead_box" id="step_1">
                <h6><?php  echo $market['title'];?></h6>
                <div style=" text-align:right;">
                    <a href="<?php  echo urlGo('form', 'jubao')?>" style="margin-right:10px; line-height:40px;color:green;">举报</a>
                </div>
                <div class="lead_content intors">
                    <?php  echo $market['content'];?>
                </div>
                <div class="lead_content">
                    <?php  if($market) { ?>
                    <input type="hidden" name="id" value="<?php  echo $id;?>_<?php  echo $uid;?>">

                    <?php  } else { ?>
                    <div class="form-group">
                        <label class="col-xs-12 item-label">下单商品:</label>
                        <div class="col-xs-12">
                            <select name="id" data-value="" class="form-control tpl-province required">
                                <?php  if(is_array($market_list)) { foreach($market_list as $row) { ?>
                                    <option value="<?php  echo $row['id'];?>"><?php  echo $row['title'];?></option>
                                <?php  } } ?>
                            </select>
                        </div>
                    </div>
                    <?php  } ?>
					<?php  if($market['formats']) { ?>
                    <div class="form-group">
                        <label class="col-xs-12 item-label">款式:</label>
                        <select name="submit_data[formats]" class="form-control style="display:block;width:100%;">
                        	<?php  if(is_array($market['formats'])) { foreach($market['formats'] as $key => $format) { ?>
                        		<option value="<?php  echo $format;?>" <?php  if(!$key) { ?>checked<?php  } ?>><?php  echo $format;?></option>
                        	<?php  } } ?>
                        </select>
                       <!--  <?php  if(is_array($market['formats'])) { foreach($market['formats'] as $key => $format) { ?>
                        <div class="col-xs-12">
                            <p class="inpbox" style="background: #eeeeee;">
                                <input type="radio" value="<?php  echo $format;?>" <?php  if(!$key) { ?>checked<?php  } ?> name="submit_data[formats]" id="inp_<?php  echo $key;?>" ><label for="inp_<?php  echo $key;?>"> <?php  echo $format;?></label>
                            </p>
                        </div>
                        <?php  } } ?> -->

                        <span class="help-block">选择你要的商品款式</span>
                    </div>
                    <?php  } ?>
                    <?php  if($market['size']) { ?>
                    <div class="form-group">
                        <label class="col-xs-12 item-label">尺寸:</label>
                        <select name="submit_data[size]" class="form-control style="display:block;width:100%;">
                        	<?php  if(is_array($market['size'])) { foreach($market['size'] as $key => $format) { ?>
                        		<option value="<?php  echo $format;?>" <?php  if(!$key) { ?>checked<?php  } ?>><?php  echo $format;?></option>
                        	<?php  } } ?>
                        </select>
                        <!-- <?php  if(is_array($market['size'])) { foreach($market['size'] as $key => $format) { ?>
                        <div class="col-xs-12">
                            <p class="inpbox" style="background: #eeeeee;">
                                <input type="radio" value="<?php  echo $format;?>" <?php  if(!$key) { ?>checked<?php  } ?> name="submit_data[size]" id="inp_<?php  echo $key;?>" ><label for="inp_<?php  echo $key;?>"> <?php  echo $format;?></label>
                            </p>
                        </div>
                        <?php  } } ?> -->

                        <span class="help-block">选择你要的商品尺寸</span>
                    </div>
                    <?php  } ?>
                    <?php  if($id=='') { ?>
                    <div class="form-group">
                        <label class="col-xs-12 item-label">推广内容:</label>
                        <div class="col-xs-12" style="overflow:hidden;padding-right:20px;">
                            <select name="m_id" id="m_id" class="form-control style="display:block;width:100%;" onchange="selectType(this.value)">
                            	<?php  if(is_array($m_list)) { foreach($m_list as $row) { ?>
                            	<option value="<?php  echo $row['id'];?>" <?php  echo $row['check'];?>><?php  echo $row['title'];?></option>
                            	<?php  } } ?>
                            </select>
                        </div>
                    </div>
                    <?php  } ?>                  
                    <?php  if($id!='') { ?>
                    <!-- <div class="lead_content" style="color:#FF0000; padding: 10px 0 10px 0;"><strong>活动结束时间：</strong>
                    <span id="t_d">0天</span>
                    <span id="t_h">0时</span>
                    <span id="t_m">0分</span>
                    <span id="t_s">0秒</span>
					</div> -->					
					<?php  } ?>
                    <div class="form-group">

                        <label class="col-xs-12 item-label">收货人姓名<font color="#FF0000"><strong>*</strong></font></label>

                        <div class="col-xs-12">
                            <input type="text" name="submit_data[name]" value="" class="form-control required" />
                        </div>
                            <span class="help-block">请填写收货人全名（资料不全，不予发货）</span>
                    </div>

                    <div class="form-group">

                        <label class="col-xs-12 item-label">手机号<font color="#FF0000"><strong>*</strong></font></label>

                        <div class="col-xs-12">
                            <input type="text" name="submit_data[mobile]" value="" class="form-control required mobile" />
                        </div>
<span class="help-block">请填写收货人手机（号码不详，不予发货）</span>
                    </div>
                    <?php  if($_W['config']['setting']['smscode']) { ?>
                    <div class="form-group">
                        <label class="col-xs-12 item-label">短信验证码:</label>
                        <div class="col-xs-6">
                            <input type="text" name="code" value="" class="form-control required" />
                        </div>
                        <div class="col-xs-4">
                            <button type="button" id="sendCode" class="btn btn-default" style="margin: 0 auto;">免费获取验证码</button>
                        </div>
                    </div>
                    <?php  } ?>
                    <div class="form-group">

                        <label class="col-xs-12 item-label">收货地址<font color="#FF0000"><strong>*</strong></font></label>

                        <div class="col-xs-12">

                            <script type="text/javascript">
                                require(["jquery", "district"], function($, dis){
                                    $(".tpl-district-container").each(function(){
                                        var elms = {};
                                        elms.province = $(this).find(".tpl-province")[0];
                                        elms.city = $(this).find(".tpl-city")[0];
                                        elms.district = $(this).find(".tpl-district")[0];
                                        var vals = {};
                                        vals.province = $(elms.province).attr("data-value");
                                        vals.city = $(elms.city).attr("data-value");
                                        vals.district = $(elms.district).attr("data-value");
                                        dis.render(elms, vals, {withTitle: true});
                                    });
                                });
                            </script>
                            <div class="row row-fix tpl-district-container" id="city">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <select name="submit_data[province]" data-value="" class="form-control tpl-province required prov">
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <select name="submit_data[city]" data-value="" class="form-control tpl-city required city">
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <select name="submit_data[district]" data-value="" class="form-control tpl-district required dist">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <span class="help-block">详细省市区！</span>
                    </div>
                    <script type="text/javascript">
                        $("#city").citySelect();
                    </script>
                    <div class="form-group">

                        <label class="col-xs-12 item-label">详细地址<font color="#FF0000"><strong>*</strong></font></label>

                        <div class="col-xs-12">
                            <input type="text" name="submit_data[address]" value="" class="form-control required" />
                                                    </div>
<span class="help-block">请填写收货人详细地址（地址不详，不予发货）</span>
                    </div>

                    

                    <div class="form-group">

                        <label class="col-xs-12 item-label">确认是否发货<font color="#FF0000"><strong>*</strong></font></label>

                        <div class="col-xs-12">
                            <p class="inpbox" style="background: #eeeeee;">
                                <input type="radio" value="1" checked name="submit_data[is_send]" id="inp_18_0" ><label for="inp_18_0"> 同意支付<i class="priceType"><?php  echo $market['price'];?></i>元（发货）</label>
                            </p>
                        </div>
                        <div class="col-xs-12">
                            <p class="inpbox" style="background: #eeeeee;">
                                <input type="radio" value="0" name="submit_data[is_send]" id="inp_18_1" ><label for="inp_18_1"> 不同意支付<i class="priceType"><?php  echo $market['price'];?></i>元（不发货）</label>
                            </p>
                        </div>
                    </div>
                </div>

					<div class="form-group" style="padding:0px 10xp;color:#3399FF;">

                        <div style="padding:0 15px;"><span><font color="#FF0000"><strong>温馨提示：</strong></font>因我们推广成本巨大，产品涉及运费、包装费、贵重物品保价费<font color="#FF0000"><strong>合计<i class="priceType"><?php  echo $market['price'];?></i>元</strong></font>，此费用需要领取人承担，货到时支付给快递！</span></div>

                        <!--<img src="./resource/images/qrcode.png" width="200" />-->

                    </div><center><button class="btn btn-primary" type="button" id="dosave">　 填写好了  确认提交 　</button></center></div>                   
                    <?php  if($commentlist) { ?>
                    <div class="lead_box">
                    <div class="form-group" style="padding:0px 20px;">
	                    <div class="wffhtitle" style="border-bottom: 1px solid #cccccc;height: 40px;line-height: 40px;font-size: 20px;">客户评价</div>
	                    <div id="TextDiv1" style="height: 200px; overflow-y: hidden;line-height:25px;">
	                    	<ul class="wffhlist" id="TextContent1" style="margin-top: 0px;margin:0px;padding:0px;font-size:13px;">
	                    		<?php  if(is_array($commentlist)) { foreach($commentlist as $row) { ?>
	                    			<li style="list-style:outside none none;padding:10px 0 0 0;">
	                    				<span style="color:red;"><?php  echo date('Y-m-d', time());?>&nbsp;</span>
                        				<span style="color:#000;"><?php  echo $row['address'];?>的<?php  echo mb_substr($row['username'],0,1,'utf-8');?>*</span>
                        				<span style="color:#000;">［<?php  echo mb_substr($row['phone'],0,3,'utf-8');?>*****<?php  echo mb_substr($row['phone'],8,3,'utf-8');?>］</span>
                        				<br><span style="color:#5D5B5B;"><?php  echo $row['content'];?></span>
	                    			</li>
	                    		<?php  } } ?>
	                    	</ul>
	                    </div>
                    </div>  
                    </div>                  
                    <?php  } ?>
        </form>
    </div>
</div>
<div class="text-center footer" style="margin:10px 0; width:100%; text-align:center; word-break:break-all;">
    技术QQ：2055204423								&nbsp;&nbsp;
</div>
</div>
<style>
    h5{color:#555;}
</style>
<script type="text/javascript">
function scrollTxt() {
    var firstLi = $("#TextContent1 li:first-child");
    firstLi.before( $("#TextContent1 li:last-child"));
    setTimeout(function () {
        scrollTxt();
    },3500);
}
$(function(){
    scrollTxt();
});
	function selectType(id){
		$.get('?c=form&a=ajax',{id:id,act:'getmarket'},function(res){
			var json = eval('('+res+')');
			$('.priceType').html(json.price);
		});
	}
    $(function () {

        $("#dosave").click(function () {
            if( !checkform() ){
                return false;
            }
            $.post($("#form").attr('action'), $("#form").serialize(), function (resp) {
                resp = eval('('+resp+')');
                if( resp.code == 1){
                    location.href = "<?php  echo urlGo('form', 'result');?>&hash="+resp.hash;
                } else {
                    alert( resp.message );
                }

            })
        })
        $("#sendCode").click(function () {
            var mobile = $(".mobile").val();
            if( !mobile ){
                alert('请输入手机号码');
                return false;
            }
            $.getJSON("?c=form&a=add&act=sendcode", {mobile:mobile}, function (resp) {
                alert( resp.message );
            })
        })
    })
</script>
<!-- <script>			
var ts = "<?php  echo $endtime;?>";
var market_id = '<?php  echo $market['id'];?>';
                    function GetRTime(){                    	                        
                        var NowTime = new Date();
                        var t =ts - NowTime.getTime();	
                        var d=0;
                        var h=0;
                        var m=0;
                        var s=0;
                        if(t>0){
                            d=Math.floor(t/1000/60/60/24);
                            h=Math.floor(t/1000/60/60%24);
                            m=Math.floor(t/1000/60%60);
                            s=Math.floor(t/1000%60);
                        }else{                        	
                        	clearInterval(tt);
							$.get('?c=form&a=ajax',{id:market_id,act:'setTime'},function(res){
								var json = eval('('+res+')');
								if(json.status){
									ts = json.data;
									tt = setInterval(GetRTime,1000);
								}											
							});
                        }
                        document.getElementById("t_d").innerHTML = d + "天";
                        document.getElementById("t_h").innerHTML = h + "时";
                        document.getElementById("t_m").innerHTML = m + "分";
                        document.getElementById("t_s").innerHTML = s + "秒";

                    }
                   var tt = setInterval(GetRTime,1000);                  
</script> -->
</body>
</html>
