<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<body>
<style type="text/css">
    .abc{width: 100%;
        height: 40px;
        line-height: 40px;
        text-align: center;
        background: -webkit-gradient(linear, 0 0, 0 100%, from(rgb(81, 95, 102)), color-stop(0.6, rgb(59, 68, 75)), to(rgb(39, 44, 48)));
        border-bottom: 1px solid rgb(0, 0, 0);
        border-top: 0px none;
        background:#697077;
    }
</style>
<div class="body">
    <div class="abc">
        <strong style="color:#fff;">员工微店后台</strong>
        <span class="head_btn_left"><a href="javascript:history.go(-1);"><span>返回</span></a><b></b></span>
    </div>
    <div class="qiandaobanner">  <a href="javascript:history.go(-1);"><img src="./resource/css/img/info.jpg"> </a></div>

    <div id="orderlist">
        <?php  if(is_array($order_list)) { foreach($order_list as $order) { ?>
        <div class="cardexplain">
            <a href="javascript:;"><ul class="round">
                <li class="title"><span><?php  echo $order['oid'];?> 订单信息<em class="ok"><?php  echo getOrderStatus($order['status'])?></em></span></li>
                <li>
                    <div class="text">
                        <p>订单编号：<?php  echo $order['oid'];?></p>
                        <p>商品：<?php  echo $order['goods_name'];?></p>
                        <p>订单金额：<?php  echo $order['price'];?></p>
                        <p>收货人 ：<?php  echo mb_substr($order['name'],0,1,'utf-8');?>***</p>
                        <p>联系电话：<?php  echo mb_substr($order['mobile'],0,3,'utf-8');?>*****<?php  echo mb_substr($order['mobile'],8,3,'utf-8');?></p>
                        <p>收货地址：<?php  echo $order['province'];?> - <?php  echo $order['city'];?> - <?php  echo $order['district'];?><br />
                            　　　　　<?php  echo $order['address'];?>
                        </p>
                        <p>下单时间：<?php  echo date('Y-m-d H:i:s',$order['add_time'])?></p>
                        <p>订单状态：<b style="color:#1CC200;"><?php  echo getOrderStatus($order['status'])?></b></p>
                        <?php  if($order['dubious']) { ?>
                        <p>是否异常：<b style='color:#ff0000;'>异常订单：手机号码归属地为：<?php  echo $order['sjprovince'];?>，与下单地址不符;</b></p>
                        <p><a href="<?php  echo urlGo('order','index', ['oid'=>$order['oid'], 'act'=>'cancel']);?>" style="color: #1CC200;">取消订单</a> </p>
                        <?php  } ?>
                        <p>

                        </p>
                    </div>
                </li>
            </ul>
            </a>
            <!--页码-->
        </div>
        <?php  } } ?>


    </div>
    <div class="get_more_info" id="get_more_info">
    </div>

<div style="height:2em;">

</div>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#fa3").attr("class","active");
        });
    </script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>