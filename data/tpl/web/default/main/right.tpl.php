<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">今天</span>
                    <h5>今日订单</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php  echo $toDayOrderNum;?></h1>
                    <!--<div class="stat-percent font-bold text-success">&nbsp;<i class="fa fa-bolt"></i>-->
                    <!--</div>-->
                    <small>新订单</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">昨日</span>
                    <h5>昨日订单</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php  echo $yesterDayOrderNum;?></h1>
                    <!--<div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i>-->
                    <!--</div>-->
                    <small>新订单</small>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">当月</span>
                    <h5>当月订单</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php  echo $monthOrderNum;?></h1>
                    <!--<div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i>-->
                    <!--</div>-->
                    <small>新订单</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">上月</span>
                    <h5>上月订单</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php  echo $prevMonthOrderNum;?></h1>
                    <!--<div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i>-->
                    <!--</div>-->
                    <small>新订单</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">今年</span>
                    <h5>今年订单</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php  echo $yearOrderNum;?></h1>
                    <!--<div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i>-->
                    <!--</div>-->
                    <small>新订单</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">所有</span>
                    <h5>所有订单</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php  echo $orderNum;?></h1>
                    <!--<div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i>-->
                    <!--</div>-->
                    <small>新订单</small>
                </div>
            </div>
        </div>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>