<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>员工列表</h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" action="<?php  echo $_W['siteurl'];?>">
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        <input type="hidden" name="submit" value="true" />
                    <div class="row">
                        <div class="col-sm-2 m-b-xs">
                            <select name="roles_id" class="input-sm form-control input-s-sm inline">
                                <option value="0">所有角色</option>
                                <?php  if(is_array($roles_list)) { foreach($roles_list as $roles) { ?>
                                <option value="<?php  echo $roles['id'];?>" <?php  if($roles['id']==$_GPC['roles_id']) { ?>selected<?php  } ?>><?php  echo $roles['name'];?></option>
                                <?php  } } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 m-b-xs">
                            <div class="input-group">

                                <input type="text" placeholder="请输入关键词" name="keywords" class="input-sm form-control">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary"> 搜索</button>
                                </span>

                            </div>
                        </div>
                        <div class="col-sm-4 m-b-xs">
                            <a href="<?php  echo urlGo('user','index', array('do'=>'add'))?>" class="btn btn-sm btn-danger"> 添加员工</a>
                        </div>

                    </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>

                                <th></th>
                                <th>角色</th>
                                <th>类型</th>
                                <th>帐号</th>
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
                                <td>
                                    <?php  echo $row['roles_name'];?>
                                </td>
                                <td>
                                    <?php  if($row['is_front']) { ?>
                                    前台帐号
                                    <?php  } else { ?>
                                    后台帐号
                                    <?php  } ?>
                                </td>
                                <td><?php  echo $row['name'];?></td>
                                <td>
                                    <i class="fa <?php  if($row['status']) { ?>fa-check text-navy<?php  } else { ?>fa-close text-muted<?php  } ?>"></i>
                                </td>
                                <td><?php  echo date('Y-m-d', $row['add_time']);?></td>
                                <td>
                                    <a href="<?php  echo urlGo('user','index', ['do'=>'add', 'id'=>$row['id']]);?>" class="btn btn-primary btn-sm">编辑</a>
                                    <a href="<?php  echo urlGo('user','index', ['do'=>'chg_status', 'id'=>$row['id'], 'status'=>!$row['status']]);?>" class="btn btn-warning btn-sm"><?php  if($row['status']) { ?>禁用<?php  } else { ?>启用<?php  } ?></a>
                                    <?php  if($_W['isfounder']) { ?><a href="<?php  echo urlGo('user','index', ['do'=>'del', 'id'=>$row['id']]);?>" onclick="if(confirm('确定删除?')==false)return false;" class="btn btn-primary btn-sm">删除</a><?php  } ?>                                   
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