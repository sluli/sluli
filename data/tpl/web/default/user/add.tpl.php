<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>添加员工 <small><!--包括自定义样式的复选和单选按钮--></small></h5>

                </div>
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php  echo $edit['id'];?>">
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        <input type="hidden" name="submit" value="true" />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">所属角色</label>
                            <div class="col-sm-10">
                                <select name="roles_id">
                                    <?php  if(is_array($roles_list)) { foreach($roles_list as $roles) { ?>
                                    <option value="<?php  echo $roles['id'];?>" <?php  if($roles['id']==$edit['roles_id']) { ?>selected<?php  } ?>><?php  echo $roles['name'];?></option>
                                    <?php  } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">员工帐号</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" value="<?php  echo $edit['name'];?>">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">登录密码</label>
                            <div class="col-sm-10">
                                <input type="text" name="passwd" class="form-control" value="">
                                <span class="help-block m-b-none">不修改密码请保持为空！</span>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">微信昵称</label>
                            <div class="col-sm-10">
                                <input type="text" name="nickname" class="form-control" value="<?php  echo $edit['nickname'];?>">
                                <span class="help-block m-b-none">将在推广页面展示</span>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">头像</label>
                            <div class="col-sm-10">
                                <?php  if($edit['avatar']) { ?>
                                    <img src="/uploads/<?php  echo $edit['avatar'];?>" style="width: 100px; height: 100px;" /><br />
                                <?php  } ?>
                                <input type="file" name="file" class="form-control" value="">
                                <span class="help-block m-b-none">将在推广页面展示！</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态</label>

                            <div class="col-sm-10">
                                <label>
                                    <input type="radio" checked="" value="1" name="status">启用
                                </label>
                                <label>
                                    <input type="radio" <?php  if($edit['status']==='0') { ?> checked=""<?php  } ?> value="0" name="status">禁用
                                </label>
                                <span class="help-block m-b-none">如果禁用，此角色下的所有帐号将禁止登录</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">帐号类型</label>

                            <div class="col-sm-10">
                                <label>
                                    <input type="radio" checked="" value="1" name="is_front">前台
                                </label>
                                <label>
                                    <input type="radio" <?php  if($edit['is_front']==='0') { ?> checked=""<?php  } ?> value="0" name="is_front">后台
                                </label>
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">保存</button>
                                <a class="btn btn-white" href="javascript:history.go(-1);">返回</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>ddd
        </div>
    </div>
</div>
</body>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>