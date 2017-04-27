<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <span><img alt="image" class="img-circle" src="img/profile_small.jpg" /></span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block m-t-xs">
                                    <strong class="font-bold">Flyfish</strong>
                                </span>
                                <span class="text-muted text-xs block">超级管理员<b class="caret"></b></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">

                            <li class="divider"></li>
                            <li><a href="<?php  echo urlGo('main', 'login', ['act'=>'out'])?>">安全退出</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">H+
                    </div>
                </li>
                <li>
                    <a class="J_menuItem" href="<?php  echo $homePage;?>">
                        <i class="fa fa-home"></i>
                        <span class="nav-label">控制面板</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-user-md"></i>
                        <span class="nav-label">帐号管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="<?php  echo urlGo('user', 'roles')?>">角色管理</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="<?php  echo urlGo('user')?>">员工管理</a>
                        </li>
                    </ul>
                </li>
                <?php  if($_W['isfounder']) { ?>
                <li>
                    <a href="#">
                        <i class="fa fa-envelope"></i>
                        <span class="nav-label">商品管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="<?php  echo urlGo('goods', 'index', ['do'=>'add'])?>">添加商品</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="<?php  echo urlGo('goods', 'index')?>">商品列表</a>
                        </li>
                    </ul>
                </li>
<?php  } ?>
                <li>
                    <a href="#">
                        <i class="fa fa-edit"></i>
                        <span class="nav-label">推广管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="<?php  echo urlGo('market', 'index', ['do'=>'add'])?>">添加推广</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="<?php  echo urlGo('market', 'index')?>">推广列表</a>
                        </li>

                    </ul>
                </li>
                
                <li>
                    <a class="J_menuItem" href="<?php  echo urlGo('orders', 'index')?>">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="nav-label">订单管理</span>
                        <span class="label label-warning pull-right"></span>
                    </a>
                </li>
                <?php  if($_W['isfounder']) { ?>
                <li>
                    <a class="J_menuItem" href="<?php  echo urlGo('domain', 'index')?>"><i class="fa fa-desktop"></i> <span class="nav-label">域名管理</span></a>
                </li>
                <?php  } ?>
            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <h3>&nbsp;</h3>
                </div>
            </nav>
        </div>
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="<?php  echo $homePage;?>">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

                </button>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a>定位当前选项卡</a>
                    </li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                    </li>
                    <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                    </li>
                </ul>
            </div>
            <a href="<?php  echo urlGo('main', 'login', ['act'=>'out'])?>" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="<?php  echo $homePage;?>" frameborder="0" data-id="<?php  echo $homePage;?>" seamless></iframe>
        </div>
        <div class="footer">
            <div class="pull-right">&copy; 2015-2017 <a href="http://www.fwei.net/" target="_blank">MeiCheng Tech</a>
            </div>
        </div>
    </div>
    <!--右侧部分结束-->

</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>