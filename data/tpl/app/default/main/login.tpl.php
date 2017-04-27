<?php defined('IN_IA') or exit('Access Denied');?>﻿<!DOCTYPE html>
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

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">H+</h1>

        </div>
        <h4>技术支持QQ：2055204423</h3>

        <form class="m-t" role="form" action="" method="post">
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
            <input type="hidden" name="submit" value="true" />
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="用户名" required="">
            </div>
            <div class="form-group">
                <input type="password" name="passwd" class="form-control" placeholder="密码" required="">
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>


            <!--<p class="text-muted text-center"> <a href="login.html#"><small>忘记密码了？</small></a> | <a href="register.html">注册一个新账号</a>-->
            <!--</p>-->

        </form>
    </div>
</div>
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