<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>添加域名</h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content">
                    <form method="post" class="form-horizontal">
                    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                    <input type="hidden" name="submit" value="true" />
                    <div class="row">
                        <div class="col-sm-4">
                            <input type="text" name="domain" class="form-control" value="" placeholder="域名地址，不包含http://">
                        </div>
                        <div class="col-sm-2">
                            <label>
                                <input type="radio" name="type" value="1" checked /> 主域
                            </label>
                            <label>
                                <input type="radio" name="type" value="0" /> 副域
                            </label>
                        </div>
                        <div class="col-sm-4 m-b-xs">
                            <button class="btn btn-primary" type="submit">添加域名</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>域名列表</h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>

                                <th></th>
                                <th>域名</th>
                                <th>状态</th>
                                <th>添加日期</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php  if(is_array($list)) { foreach($list as $row) { ?>
                            <tr>
                                <td>
                                    <?php  echo $row['id'];?>
                                </td>
                                <td>[<?php  if($row['type']) { ?>主域<?php  } else { ?>副域<?php  } ?>]<?php  echo $row['domain'];?></td>
                                <td>
                                    <i class="fa <?php  if($row['status']) { ?>fa-check text-navy<?php  } else { ?>fa-close text-muted<?php  } ?>"></i>
                                </td>
                                <td><?php  echo date('Y-m-d', $row['add_time']);?></td>
                                <td>
                                    <a href="<?php  echo urlGo('domain','index', ['do'=>'delete', 'id'=>$row['id']]);?>" class="btn btn-primary btn-sm">删除</a>
                                    <a href="<?php  echo urlGo('domain','index', ['do'=>'chg_status', 'id'=>$row['id'], 'status'=>!$row['status']]);?>" class="btn btn-warning btn-sm"><?php  if($row['status']) { ?>无效<?php  } else { ?>有效<?php  } ?></a>
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
</body>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>