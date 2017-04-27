<?php defined('IN_IA') or exit('Access Denied');?>﻿<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<body class="gray-bg">
<link href="./resource/css/plugins/summernote/summernote.css" rel="stylesheet">
<link href="./resource/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>添加商品 <small><!--包括自定义样式的复选和单选按钮--></small></h5>

                </div>
                <div class="ibox-content">
                    <form method="post" class="form-horizontal">
                        <input type="hidden" name="id" value="<?php  echo $edit['id'];?>">
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        <input type="hidden" name="submit" value="true" />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-6">
                                <input type="text" name="title" class="form-control" value="<?php  echo $edit['title'];?>">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">描述</label>
                            <div class="col-sm-6">
                                <textarea cols="50" rows="5" class="form-control" name="intro"><?php  echo $edit['intro'];?></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">易企秀地址</label>
                            <div class="col-sm-6">
                                <input type="text" name="show_link" class="form-control" value="<?php  echo $edit['show_link'];?>">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品名称</label>
                            <div class="col-sm-3">
                                <select class="" name="gid">
                                    <?php  if(is_array($goods_list)) { foreach($goods_list as $row) { ?>
                                    <option value="<?php  echo $row['gid'];?>" <?php  if($edit['gid']==$row['gid']) { ?> selected<?php  } ?>><?php  echo $row['name'];?></option>
                                    <?php  } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">微信关键词</label>
                            <div class="col-sm-6">
                                <input type="text" name="keyword" class="form-control" value="<?php  echo $edit['keyword'];?>">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态</label>

                            <div class="col-sm-10">
                                <label>
                                    <input type="radio" checked="" value="1" name="status">上架
                                </label>
                                <label>
                                    <input type="radio" <?php  if($edit['status']==='0') { ?> checked=""<?php  } ?> value="0" name="status">下架
                                </label>
                                <span class="help-block m-b-none">下架将无法访问</span>
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
            </div>
        </div>
    </div>
</div>


<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
<script src="./resource/js/plugins/summernote/summernote.min.js"></script>
<script src="./resource/js/plugins/summernote/summernote-zh-CN.js"></script>
<script>
    $(document).ready(function(){
        $(".summernote").summernote({lang:"zh-CN"})
    });
    var edit=function(){
        $("#eg").addClass("no-padding");
        $(".click2edit").summernote({lang:"zh-CN",focus:true})
    };
    var save=function(){
        $("#eg").removeClass("no-padding");
        var aHTML=$(".click2edit").code();
        $(".click2edit").destroy();
        alert(aHTML);
    };

</script>