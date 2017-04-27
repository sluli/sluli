<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>举报</title>
    <link rel="stylesheet" href="./resource/w_complain251980.css">
    <script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js "></script>
</head>

<body class="zh_CN " ontouchstart="">
<div class="page_bd">
    <div id="tips" style="display:none;" class="top_tips warning"></div>
    <div id="step2" class="category_item" style="">
        <h3 class="category_title">举报描述</h3>
        <form action="?c=form&act=result&a=jubao" method="post">
            <div id="textareaDiv" class="textarea_panel">
                <textarea id="aaa" onpropertychange="title_len();"></textarea>
                <i id="reasonTextTips" class="ic ic_warning ic_small"></i>
                <span id="textareaLenSpan" class="frm_hint">
              <span id="textLen">0</span>/50</span></div>
            <button id="submitBtn" type="submit" class="btn btn_primary btn_disabled js_btn_submit">
                <span style="color:#fff;">提交</span></button>
        </form>
        <div class="opr_area"></div>
    </div>
    <div id="step3" style="display:none;"></div>
</div>
<script>
    $("body").on("propertychange input", "#aaa", function () {
        var value = $('#aaa').val().length;
        if(value > 50){
            $('#aaa').val($('#aaa').val().substring(0,50));
            value = $('#aaa').val().length;
        }
        $("span#textLen").html(value);
    });
</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
</script></body></html>