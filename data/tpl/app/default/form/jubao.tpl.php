<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>举报</title>
    <link rel="stylesheet" href="./resource/w_complain251980.css">
    <script async="" type="text/javascript" src="./resource/js/index251980.js"></script>
</head>

<body class="zh_CN " ontouchstart="">
<div class="page_bd">
    <div id="tips" style="display:none;" class="top_tips warning"></div>
    <div id="step1" class="category_item">
        <h3 class="category_title">请选择举报原因</h3>
        <form id="form1">
            <ul class="checkbox_list">
                <li data-type="1" class="checkbox">
                    <input id="radio_1" name="complaintype" value="2" class="frm_checkbox" type="radio">
                    <label for="radio_1" class="frm_checkbox_label checkbox_title">
                        <div class="checkbox_label_inner">欺诈</div></label>
                </li>
                <li data-type="2" class="checkbox">
                    <input id="radio_2" name="complaintype" value="1" class="frm_checkbox" type="radio">
                    <label for="radio_2" class="frm_checkbox_label checkbox_title">
                        <div class="checkbox_label_inner">色情</div></label>
                </li>
                <li data-type="3" class="checkbox">
                    <input checked="checked" id="radio_3" name="complaintype" value="16" class="frm_checkbox" type="radio">
                    <label for="radio_3" class="frm_checkbox_label checkbox_title">
                        <div class="checkbox_label_inner">政治谣言</div></label>
                </li>
                <li data-type="4" class="checkbox">
                    <input id="radio_4" name="complaintype" value="128" class="frm_checkbox" type="radio">
                    <label for="radio_4" class="frm_checkbox_label checkbox_title">
                        <div class="checkbox_label_inner">常识性谣言</div></label>
                </li>
                <li data-type="5" class="checkbox">
                    <input id="radio_5" name="complaintype" value="1024" class="frm_checkbox" type="radio">
                    <label for="radio_5" class="frm_checkbox_label checkbox_title">
                        <div class="checkbox_label_inner">诱导分享</div></label>
                </li>
                <li data-type="6" class="checkbox">
                    <input id="radio_6" name="complaintype" value="512" class="frm_checkbox" type="radio">
                    <label for="radio_6" class="frm_checkbox_label checkbox_title">
                        <div class="checkbox_label_inner">恶意营销</div></label>
                </li>
                <li data-type="7" class="checkbox">
                    <input id="radio_7" name="complaintype" value="64" class="frm_checkbox" type="radio">
                    <label for="radio_7" class="frm_checkbox_label checkbox_title">
                        <div class="checkbox_label_inner">隐私信息收集</div></label>
                </li>
                <li data-type="8" class="checkbox">
                    <input id="radio_8" name="complaintype" value="reportpage" class="frm_checkbox" type="radio">
                    <label for="radio_8" class="frm_checkbox_label checkbox_title">
                        <div class="checkbox_label_inner">抄袭公众号文章</div></label>
                </li>
                <li data-type="9" class="checkbox">
                    <input id="radio_9" name="complaintype" value="other" class="frm_checkbox" type="radio">
                    <label for="radio_9" class="frm_checkbox_label checkbox_title">
                        <div class="checkbox_label_inner">其他侵权类（冒名、诽谤、抄袭）</div></label>
                </li>
                <li data-type="10" class="checkbox">
                    <input id="radio_10" name="complaintype" value="original_complain" class="frm_checkbox" type="radio">
                    <label for="radio_10" class="frm_checkbox_label checkbox_title">
                        <div class="checkbox_label_inner">违规声明原创</div></label>
                </li>
            </ul>
        </form>
        <div class="opr_area">
            <a id="nextBtn" href="?c=form&act=commit&a=jubao" class="btn btn_primary btn_disabled js_btn_submit">
                <span style="color:#fff;">下一步</span></a>
        </div>
    </div>

    <div id="step3" style="display:none;"></div>
</div>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
</script></body></html>