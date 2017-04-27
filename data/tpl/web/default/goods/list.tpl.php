<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>商品列表</h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <!--<div class="col-sm-5 m-b-xs">-->
                            <!--<div class="input-group">-->
                                <!--<input type="text" placeholder="请输入关键词" class="input-sm form-control">-->
                                <!--<span class="input-group-btn">-->
                                    <!--<button type="button" class="btn btn-sm btn-primary"> 搜索</button>-->
                                <!--</span>-->

                            <!--</div>-->
                        <!--</div>-->
                        <!--<div class="col-sm-4 m-b-xs">-->
                            <!--<a href="<?php  echo urlGo('user','roles', array('do'=>'add'))?>" class="btn btn-sm btn-danger"> 添加角色</a>-->
                        <!--</div>-->

                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>

                                <th></th>
                                <th>名称</th>
                                <th>价格</th>
                                <th>款式</th>
                                <th>尺码</th>
                                <th>状态</th>
                                <th>添加日期</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php  if(is_array($list)) { foreach($list as $row) { ?>
                            <tr>
                                <td>
                                    <?php  echo $row['gid'];?>
                                </td>
                                <td><?php  echo $row['name'];?></td>
                                <td><?php  echo $row['price'];?></td>
                                <td><?php  echo $row['formats'];?></td>
                                <td><?php  echo $row['size'];?></td>
                                <td>
                                    <i class="fa <?php  if($row['status']) { ?>fa-check text-navy<?php  } else { ?>fa-close text-muted<?php  } ?>"></i>
                                </td>
                                <td><?php  echo date('Y-m-d', $row['add_time']);?></td>
                                <td>
                                    <a href="<?php  echo urlGo('goods','index', ['do'=>'add', 'gid'=>$row['gid']]);?>" class="btn btn-primary btn-sm">编辑</a>
                                    <a href="<?php  echo urlGo('goods','index', ['do'=>'chg_status', 'gid'=>$row['gid'], 'status'=>!$row['status']]);?>" class="btn btn-warning btn-sm"><?php  if($row['status']) { ?>下架<?php  } else { ?>上架<?php  } ?></a>
                                    <a href="<?php  echo urlGo('goods','index', ['do'=>'del', 'gid'=>$row['gid']]);?>" onclick="if(confirm('确定删除?')==false)return false;" class="btn btn-primary btn-sm">删除</a>
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