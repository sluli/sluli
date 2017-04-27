<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<body class="gray-bg">
<div class="row" style="padding: 5%;">
    <div class="col-sm-3">
        </div>
    <div class="col-sm-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>提示</h5>
            </div>
            <div class="ibox-content">
                <div class="alert alert-<?php  echo $type;?>">
                    <?php  echo $msg;?>
                </div>
                <div class="">
                    <a href="<?php  if($redirect) { ?><?php  echo $redirect;?><?php  } else { ?>javascript:history.go(-1);<?php  } ?>">点击这里返回</a>
                    <?php  if($redirect) { ?>
                    <script type="text/javascript">
                        setTimeout(function () {
                            location.href="<?php  echo $redirect;?>";
                        },1500)
                    </script>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>