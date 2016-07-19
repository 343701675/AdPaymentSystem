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
    var vm = avalon.define({
        $id: "list",
        datalist: [],
        customname: '',
        month: '<?php echo ($month); ?>'
    });

    var loadData = function () {
        $.ajax({
            url: '/index.php/Home/Custom/monthajax',
            type: 'get',
            dataType: "json",
            async: true,
            data: { r: Math.random(),customname:vm.customname, month: vm.month },
            success: function (data) {
                //console.log(data.RowCount);
                vm.datalist = data;
            }
        });
    };

    $(function () {
        //初始化
        loadData();
        //搜索
        $('#search').click(loadData);
    });
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
                        
    <div class="col-md-12 text-title ft-em15 padding10">月汇总</div>
    <form class="well form-inline" id="fromlist" ms-controller="list" onkeypress="if (event.keyCode == 13) { loadData();}" onsubmit="return false;">
        <div class="form-group" style="margin-top: 15px;">
            <label for="customname">客户名称:</label>
            <input type="text" name="customname" id="customname" class="form-control" ms-duplex="customname" />
            <label for="month">月份:</label>
            <input type="text" name="month" id="month" class="form-control" ms-duplex="month" onfocus="WdatePicker({ isShowClear: true, readOnly: false, skin: 'ext', dateFmt: 'yyyy-MM' })" />
        </div>

        <button type="button" id="search" class="btn btn btn-primary" style="margin-top: 15px;" data-loading-text="加载中...">查询</button>
    </form>
    <table class="table table-hover table-bordered" ms-controller="list">
        <tr>
            <th>年月</th>
            <th>客户名称</th>
            <th>期初金额</th>
            <th>本期借方</th>
            <th>本期贷方</th>
            <th>期末金额</th>
        </tr>
        <tr ms-repeat="datalist">
            <td>{{el.month}}</td>
            <td>{{el.customname}}</td>
            <td>{{el.defaultmoney}}</td>
            <td>{{el.debitmoney}}</td>
            <td>{{el.creditmoney}}</td>
            <td>{{el.finalmoney}}</td>
        </tr>
    </table>

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