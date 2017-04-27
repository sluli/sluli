<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>评论列表</h5>
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
                        <div class="col-sm-4 m-b-xs">
                            <a href="<?php  echo urlGo('market','comment', array('do'=>'add','market_id'=>$market_id))?>" class="btn btn-sm btn-danger"> 添加评论</a>
                            <a href="<?php  echo urlGo('market','index')?>" class="btn btn-sm btn-danger"> 推广列表</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>

                                <th></th>
                                <th>地址</th>
                                <th>姓名</th>
                                <th>电话</th>
                                <th>内容</th>
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
                                <td><?php  echo $row['address'];?></td>
                                <td><?php  echo $row['username'];?></td>
                                <td><?php  echo $row['phone'];?></td>
                                <td><?php  echo $row['content'];?></td>
                                <td><?php  echo date('Y-m-d', $row['addtime']);?></td>
                                <td>
                                    <a href="<?php  echo urlGo('market','comment', ['do'=>'add', 'id'=>$row['id'],'market_id'=>$row['market_id']]);?>" class="btn btn-primary btn-sm">编辑</a>
                                    <a href="<?php  echo urlGo('market','comment', ['do'=>'del', 'id'=>$row['id'],'market_id'=>$row['market_id']]);?>" class="btn btn-warning btn-sm">删除</a>
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