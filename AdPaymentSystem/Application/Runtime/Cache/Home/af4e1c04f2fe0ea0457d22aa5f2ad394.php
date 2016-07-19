<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=Content-Type content="text/html;charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=7;IE=9;IE=10" />
    <title>首页</title>
    <link rel="stylesheet" type="text/css" href="/Public/Style/base.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Style/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Style/pagination.css" />
    <script type="text/javascript" src="/Public/Scripts/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/Public/Scripts/time/WdatePicker.js"></script>
    <script type="text/javascript" src="/Public/Scripts/base.js"></script>
    <script type="text/javascript" src="/Public/Scripts/floatingLayer.min.js"></script>
    <script type="text/javascript" src="/Public/Scripts/jquery.cookie.js"></script>
    <script type="text/javascript" src="/Public/Scripts/jquery.validate.js"></script>
    <script type="text/javascript" src="/Public/Scripts/jqPaginator.js"></script>
    <script type="text/javascript" src="/Public/Scripts/bootstrap.js"></script>
    <script type="text/javascript" src="/Public/Scripts/avalon.js"></script>
    
<script type="text/javascript">
    var error = '<?php echo ($error); ?>'.length > 0 ? (JSON.parse('<?php echo ($error); ?>')) : [];
    var vm = avalon.define({
        $id: "import",
        error: error
    });
    console.log(error);
</script>

    <script type="text/javascript">
        function checkdel() {
            return confirm("你确定要删除吗?");
        }
    </script>
</head>
<body>
    <!-- 顶部 -->
    <div id="header">
        <nav class="nav bg-basicbg">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo U('/Home/Index/index');?>"><img src="/Public/Images/sxlogo.png" /></a>
                    <div class="navbar-brand header-title">四喜财务预收款系统<small>beta1</small></div>
                </div>
            </div>
        </nav>
    </div>
    <div style="height:10px;"></div>
    <div id="main">
        <div class="main">
            <div class="container">
                <div style="border: 1px solid #AAAAAA;overflow: hidden">
                    <div class="col-md-2 left leftnav">
                        <div class="content-left-nav">
                            
    <ul>
        <li class="title"><a class="plus" href="javascript:;">-</a><a class="text-muted" href="javascript:void(0);"><strong>财务预收款</strong></a></li>
        <li class="items">
            <div class="i"><a class="text-muted" href="<?php echo U('Home/Index/defaultmoney');?>">期初数据导入</a></div>
            <div class="i"><a class="text-muted" href="<?php echo U('Home/Index/customdebit');?>">客户借方导入</a></div>
            <div class="i"><a class="text-muted" href="<?php echo U('Home/Index/customcredit');?>">客户贷方导入</a></div>
            <div class="i"><a class="text-muted" href="<?php echo U('Home/Custom/detail');?>">月查询客户预收明细表</a></div>
            <div class="i"><a class="text-muted" href="<?php echo U('Home/Custom/month');?>">月汇总表</a></div>
            <div class="i"><a class="text-muted" href="<?php echo U('Home/Custom/year');?>">年汇总表</a></div>
        </li>
        <li><hr /></li>
    </ul>

<script type="text/javascript">
    (function () {
        /* 装载左侧导航开启(闭合)状态 */
        var _leftnavstate = $.cookie('_left_nav_state');
        //console.log(_leftnavstate);
        if (_leftnavstate != null) {
            var list1 = $('.content-left-nav ul');
            for (var i = 0; i < list1.length; i++) {
                var s = '' + _leftnavstate.charAt(i);
                if (s == '0') {
                    list1[i].className = 'close';
                    $(list1[i]).find('a[class=plus]').html('+');
                }
            }
        }

        /* 判断当前页面，并且选中左侧链接 */
        var __curPage = '@Request.Path.ToLower()';
        if (__curPage == '') __curPage = '/';
        $('.content-left-nav ul .items .i a').each(function () {
            var href = $(this).attr('href') == null ? "" : $(this).attr('href').toLowerCase();
            if (href == __curPage) {
                $(this).parent().addClass('current');
                if ($(this).parent().parent().parent().hasClass('close'))
                    $(this).parent().parent().parent().removeClass('close');
                return;
            }
        });
    })();

    /* 保存左侧导航状态 */
    var SaveLeftNav = function () {
        var s1 = '';
        var list = $('.content-left-nav ul');
        for (var i = 0; i < list.length; i++) {
            var classTitle = list[i].className;
            if (typeof (classTitle) != 'undefined' && classTitle == 'close')
                s1 += '0';
            else
                s1 += '1';
        }
        //alert(s1);
        $.cookie('_left_nav_state', s1, { expires: 360, path: '/' });
    }

    /* 展开/收缩左侧导航 */
    $('.content-left-nav ul .title').click(function () {
        var o = $(this).parent();

        if ($(o).hasClass('close')) {
            $(o).find('.items').slideDown('fast', function () {
                $(o).removeClass('close');
                $(o).find('a[class=plus]').html('-');
                SaveLeftNav();
            });
        }
        else {
            $(o).find('.items').slideUp('fast', function () {
                $(o).addClass('close');
                $(o).find('a[class=plus]').html('+');
                SaveLeftNav();
            });
        }
    });
</script>
                        </div>
                    </div>
                    <div class="col-md-10">
                        
    <div class="col-md-12 text-title ft-em15 padding10">期初金额</div>
    <form class="well form-horizontal" id="fromlist" ms-controller="import" enctype="multipart/form-data" action="<?php echo U('Index/defaultmoney');?>" method="POST">
        <input type="hidden" name="import" value="导入" />
        <div class="form-group">
            <label class="col-sm-12"><span>导入说明:</span></label>
            <ol class="col-sm-12">
                <li>1.导入的数据必须是标准化数据，如：日期必须为标准日期格式</li>
                <li>2.导入的数据必须有列标题，如：年月，客户名称，期初金额；</li>
                <li>3.导入的数据必须是Excel（*.xls或*.xlsx）类型的文件；</li>
            </ol>
        </div>


        <div class="form-group">
            <label class="col-sm-1" for="excel">文件地址:</label>
            <input type="file" name="excel" id="excel" class="col-sm-4" value=" " />

        </div>

        <input type="submit" name="bOK" id="bOK" class="btn btn-primary" value="导入" />
    </form>

    <div ms-controller="import" ms-if="error!=null && error.length>0">
        <table class="table table-hover table-bordered" id="show">
            <tr>
                <th>客户名称</th>
                <th>问题字段数据</th>
                <th>问题说明</th>
            </tr>
            <tr ms-repeat="error">
                <td>{{el.data.customname}}</td>
                <td>{{el.data.error}}</td>
                <td>{{el.msg}}</td>
            </tr>
        </table>
    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <div class="container">
            <div class="col-md-12 text-center ft-em12 padding10">
                杭州四喜信息技术有限公司
            </div>
        </div>
    </div>
    <span id="__floatDiv"></span>
</body>
</html>