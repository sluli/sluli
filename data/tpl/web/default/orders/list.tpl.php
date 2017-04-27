<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>推广列表</h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content">
                    <form method="get" action="" id="order_form">
                        <input type="hidden" name="c" value="<?php  echo $_W['controller'];?>">
                        <input type="hidden" name="a" value="<?php  echo $_W['action'];?>">
                        <input type="hidden" name="export" id="export" value="0" />
                    <div class="row">
                        <?php  if($_W['isfounder']) { ?>
                        <div class="col-sm-1 m-b-xs">
                            <select name="roles_id" class="input-sm form-control input-s-sm inline">
                                <option value="0">所有角色</option>
                                <?php  if(is_array($roles_list)) { foreach($roles_list as $roles) { ?>
                                <option value="<?php  echo $roles['id'];?>" <?php  if($roles['id']==$_GPC['roles_id']) { ?>selected<?php  } ?>><?php  echo $roles['name'];?></option>
                                <?php  } } ?>
                            </select>
                        </div>
                        <?php  } ?>
                        <div class="col-sm-1 m-b-xs">
                            <input type="text" name="oid" placeholder="订单号" class="input-sm form-control">
                        </div>
                        <div class="col-sm-1 m-b-xs">
                            <input type="text" name="gid" placeholder="商品编号" class="input-sm form-control">
                        </div>
                        <div class="col-sm-1 m-b-xs">
                            <input type="text" name="name" placeholder="收件人" class="input-sm form-control">
                        </div>
                        <div class="col-sm-1 m-b-xs">
                            <input type="text" name="mobile" placeholder="电话" class="input-sm form-control">
                        </div>
                        <div class="col-sm-1 m-b-xs">
                            <input type="text"  name="delivery_code" placeholder="物流单号" class="input-sm form-control">
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-sm-2 m-b-xs">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control" name="start_time" value="" />
                                    <span class="input-group-addon">到</span>
                                    <input type="text" class="input-sm form-control" name="end_time" value="" />
                                </div>
                            </div>
                            <div class="col-sm-2 m-b-xs">
                                <div class="input-group">
                                    <select name="status" class="input-sm form-control">
                                        <option value="0">所有状态</option>
                                        <option value="1">异常订单</option>
                                        <option value="2">取消</option>
                                        <option value="3">未发货</option>
                                        <option value="4">已发货</option>
                                        <option value="5">已收货</option>
                                    </select>
                                    <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary" id="search_btn"> 搜索</button>
                                    <button type="button" class="btn btn-sm btn-defult" id="export_btn">导出</button>
                                </span>
                                </div>
                            </div>
                            <div class="col-sm-4 m-b-xs">
                                <a href="<?php  echo urlGo('orders','send')?>" class="btn btn-sm btn-danger"> 批量发货</a>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>

                                <th>订单号</th>
                                <th>商品信息</th>
                                <th>商品款式</th>
                                <th>商品规格</th>
                                <th>收件人信息</th>
                                <th>状态</th>
                                <th>物流</th>
                                <th>下单时间</th>
                                <th>推广人</th>
                                <th>下单情况</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php  if(is_array($list)) { foreach($list as $row) { ?>
                            <tr>
                                <td>
                                    <?php  echo $row['oid'];?>
                                </td>
                                <td>
                                    <?php  echo $row['goods_name'];?><br />
                                    ￥<?php  echo $row['price'];?>
                                </td>
                                <td><?php  echo $row['formats'];?></td>
                                <td><?php  echo $row['size'];?></td>
                                <td>
                                    <?php  echo $row['name'];?> ( <?php  echo $row['mobile'];?> )<br />
                                    <?php  echo $row['province'];?> - <?php  echo $row['city'];?> - <?php  echo $row['district'];?><br />
                                    <?php  echo $row['address'];?>
                                </td>

                                <td><?php  echo getOrderStatus($row['status'])?></td>
                                <td>
                                    <?php  echo $row['delivery'];?> - <?php  echo $row['delivery_code'];?>
                                </td>
                                <td><?php  echo date('Y-m-d H:i:s', $row['add_time']);?></td>
                                <td><?php  echo $row['roles_name'];?><br /><?php  echo $row['sale_name'];?></td>
                                <td>
                                	<?php  if($row['is_assist']==1) { ?>
                                		协助下单
                                	<?php  } else { ?>
                                		客户下单
                                	<?php  } ?>
                                </td>
                                <td>
                                    <a href="<?php  echo urlGo('orders','info', ['oid'=>$row['oid']]);?>" class="btn btn-primary btn-sm">详情</a>
                                    <?php  if($row['status']) { ?>
                                    <a href="<?php  echo urlGo('orders','index', ['do'=>'chg_status', 'oid'=>$row['oid'], 'status'=>0]);?>" class="btn btn-warning btn-sm">取消</a>
                                    <?php  if($row['status']==2) { ?>
                                    <a href="<?php  echo urlGo('orders','index', ['do'=>'chg_status', 'oid'=>$row['oid'], 'status'=>3]);?>" class="btn btn-warning btn-sm">已收货</a>
                                    <?php  } ?>
                                    <?php  } ?>
                                </td>
                            </tr>
                            <?php  } } ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
    $(function () {
        $("#export_btn").click(function () {
            $("#export").val(1);
            $("#order_form").submit();
        });
        $("#search_btn").click(function () {
            $("#export").val(0);
            $("#order_form").submit();
        });
        $('#datepicker input').datepicker({
        });
    })
</script>