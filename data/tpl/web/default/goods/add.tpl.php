<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
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
                    <form method="post" class="form-horizontal" enctype="multipart/form-data">
                        <input type="hidden" name="gid" value="<?php  echo $edit['gid'];?>">
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        <input type="hidden" name="submit" value="true" />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品名称</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" class="form-control" value="<?php  echo $edit['name'];?>">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">所属</label>
                            <div class="col-sm-3">
                                <!--<select class="" name="roles_id">-->
                                    <?php  if(is_array($roles_list)) { foreach($roles_list as $row) { ?>
                                <label><input type="checkbox" name="roles_id[]" value="<?php  echo $row['id'];?>" <?php  if(in_array($row['id'],explode(',',$edit['roles_id']))) { ?> checked<?php  } ?> /> <?php  echo $row['name'];?></label>
                                    <!--<option value="<?php  echo $row['id'];?>" <?php  if($edit['roles_id']==$row['id']) { ?> selected<?php  } ?>><?php  echo $row['name'];?></option>-->
                                    <?php  } } ?>
                                <!--</select>-->
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">产品图片</label>
                            <div class="col-sm-10">
                                <?php  if($edit['gid']) { ?>
                                <img src="/uploads/<?php  echo $edit['thumb'];?>" style="width: 100px; height: 100px;" /><br />
                                <?php  } ?>
                                <input type="file" name="thumb" class="form-control" value="">
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">售价</label>
                            <div class="col-sm-3">
                                <input type="text" name="price" class="form-control" value="<?php  echo $edit['price'];?>">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">款式</label>
                            <div class="col-sm-10">
                                <input type="text" name="formats" class="form-control" value="<?php  echo $edit['formats'];?>">
                                <span class="help-block m-b-none">多个款式请用","分隔</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">尺码</label>
                            <div class="col-sm-10">
                                <input type="text" name="size" class="form-control" value="<?php  echo $edit['size'];?>">
                                <span class="help-block m-b-none">多个尺码请用","分隔</span>
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
                                <span class="help-block m-b-none">下架商品将无法访问</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">简介</label>
                            <div class="col-sm-10">
                                <textarea id="editor" style="width: 640px;" name="content">
                                   <?php  echo $edit['content'];?>
                                </textarea>
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
<script src="./resource/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    /*tinymce.init({
        selector: 'textarea',
        language:'zh_CN',
        height: 500,
        width:400,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code'
        ],
        toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        content_css: '//www.tinymce.com/css/codepen.min.css'
    });*/
    tinymce.init({
        selector: 'textarea',
        language:'zh_CN',
        height: 500,
        width:600,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
        ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons | codesample',
        image_advtab: true,
        templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    });
</script>
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