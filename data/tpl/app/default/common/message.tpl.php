<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>登录系统</title>

    <meta name="keywords" content="">
    <meta name="description" content="">

    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->

    <link rel="shortcut icon" href="../web/resource/favicon.ico">
    <link href="../web/resource/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="../web/resource/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="../web/resource/css/animate.min.css" rel="stylesheet">
    <link href="../web/resource/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <style type="text/css">
        .remarks{color: #3B9544;}
        .ml20{margin-left: 20px;}
    </style>
</head>
<body class="gray-bg">

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
<script src="../web/resource/js/jquery.min.js?v=2.1.4"></script>
<script src="../web/resource/js/bootstrap.min.js?v=3.3.6"></script>
<script src="../web/resource/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="../web/resource/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="../web/resource/js/plugins/layer/layer.min.js"></script>
<script src="../web/resource/js/hplus.min.js?v=4.1.0"></script>
<script type="text/javascript" src="../web/resource/js/contabs.min.js"></script>
<script src="../web/resource/js/plugins/pace/pace.min.js"></script>
</body>
</html>