<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<body class="gray-bg">
<link href="./resource/css/plugins/summernote/summernote.css" rel="stylesheet">
<link href="./resource/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>订单详情 <small></small></h5>

                </div>
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" enctype="multipart/form-data">
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        <input type="hidden" name="submit" value="true" />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">说明：</label>
                            <div class="col-sm-6">
                                <span class="help-block m-b-none">
                                    你可以通过Excel文件批量导入的方式进行发货操作，但需要符合模板格式要求，否则操作会失败
                                </span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">上传文件</label>
                            <div class="col-sm-6">
                                <input type="file"  class="form-control" name="file" />
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