@extends('layouts.app')
@section('content')
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    {{--导航栏下侧内容--}}
    <div class="panel spotlight">
        <div class="container">
            <div class="main-wrapper">
                <ol class="breadcrumb_giz">
                    <li><a href="/gateway">网关详情 </a></li>
                    <li class="active"><a href="/gateway/{{$input}}">{{$input}}</a></li>
                    <li class="active">数据展示</li>
                    <li class="active">数据趋势</li>
                </ol>
                <div class="spotlight-button">
                    <a class="btn btn-primary" href="/gateway"> 返回</a>
                </div>
            </div>
        </div>
    </div>
    {{--左侧导航栏--}}
    <div class="main-wrapper product-base main-height-wrapper">
        <div class="panel panel-border-none sidebar">
            <ul activelink data-parent="li">
                <li class="sidebar-section">
                    <ul>
                        <li class="sidebar-section-header">
                            <div class="gizwits-icon icon-menu_ic_information"></div>
                            <span>OverView</span></li>
                        <li class="sidebar-section-menu">
                            <a href="/gateway/{{$input}}">基本信息</a></li>
                    </ul>
                </li>
                <li class="sidebar-section">
                    <ul>
                        <li class="sidebar-section-header">
                            <div class="gizwits-icon icon-menu_ic_information"></div>
                            <span>Traffic</span></li>
                        <li class="sidebar-section-menu">
                            <a href="/gateway/{{$input}}/traffic/list">数据展示</a></li>
                    </ul>
                </li>
                <li class="sidebar-section">
                    <ul>
                        <li class="sidebar-section-header">
                            <div class="gizwits-icon icon-menu_ic_information"></div>
                            <span>Settings</span></li>
                        <li class="sidebar-section-menu">
                            <a href="/gateway/{{$input}}/setting">网关设置</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    <div class="panel product-main">
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12 column">
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <h2 class="col-md-12 column" align="center">数据趋势图展示</h2>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <ul class="pagination">
                            <li ><a href="/gateway/{{$input}}/traffic/list">数据列表</a></li>
                            <li class="active"><a href="/gateway/{{$input}}/traffic/graph">数据趋势图</a></li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="panel panel-default">
                                <div class="panel-heading">选择时间区间（展示选择时间当天的数据）
                                    <br>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <form name="reg_testdate" action="/gateway/{{$input}}/traffic/graph">
                                        <select class="btn btn-default " name="YYYY" onchange="YYYYDD(this.value)">
                                            <option id="year"></option>
                                        </select>年
                                        <select class="btn btn-default " name="MM" onchange="MMDD(this.value)">
                                            <option id="month"></option>
                                        </select>月
                                        <select class="btn btn-default " name="DD">
                                            <option id="data"></option>
                                        </select>日
                                        <input class="btn btn-success" type="submit" value=" 确定">
                                    </form>
                                </div>
                                <div class="panel-body">
                                    <p align="center">{{$year}}年{{$month}}月{{$data}}日的数据展示</p>
                                    <div id="temps_div"></div>
                                    <?= $lava->render('LineChart', 'chart', 'temps_div') ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="year" value="{{$year}}">
                    <input type="hidden" id="month" value="{{$month}}">
                    <input type="hidden" id="data" value="{{$data}}">

                </div>
            </div>
        </div>
    </div>
    </div>


    <script language="JavaScript">
        function YYYYMMDDstart()
        {
            MonHead = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            //先给年下拉框赋内容
            var y  = new Date().getFullYear();
            for (var i = (y-10); i < (y+10); i++) //以今年为准，前10年
            {
                document.reg_testdate.YYYY.options.add(new Option(i, i));
            }
            document.reg_testdate.YYYY.value =y;
            //赋月份的下拉框
            for (var i = 1; i < 13; i++) {
                document.reg_testdate.MM.options.add(new Option(i, i));
            }
            document.reg_testdate.MM.value = new Date().getMonth()+1;
            //赋日期下拉框
            var n = MonHead[new Date().getMonth()];
            if (new Date().getMonth() ==1 && IsPinYear(YYYYvalue)) {
                n++;
            }
            writeDay(n);
            document.reg_testdate.DD.value = new Date().getDate();
        }
        if(document.attachEvent)
            window.attachEvent("onload", YYYYMMDDstart);
        else
            window.addEventListener('load', YYYYMMDDstart, false);
        function YYYYDD(str) //年发生变化时日期发生变化(主要是判断闰平年)
        {
            var MMvalue = document.reg_testdate.MM.options[document.reg_testdate.MM.selectedIndex].value;
            if (MMvalue == ""){ var e = document.reg_testdate.DD; optionsClear(e); return;}
            var n = MonHead[MMvalue - 1];
            if (MMvalue ==2 && IsPinYear(str)) n++;
            writeDay(n)
        }
        function MMDD(str)   //月发生变化时日期联动
        {
            var YYYYvalue = document.reg_testdate.YYYY.options[document.reg_testdate.YYYY.selectedIndex].value;
            if (YYYYvalue == ""){ var e = document.reg_testdate.DD; optionsClear(e); return;}
            var n = MonHead[str - 1];
            if (str ==2 && IsPinYear(YYYYvalue)) n++;
            writeDay(n)
        }
        function writeDay(n)   //据条件写日期的下拉框
        {
            var e = document.reg_testdate.DD;
            optionsClear(e);
            for (var i=1; i<(n+1); i++)
                e.options.add(new Option( i , i));
        }
        function IsPinYear(year)//判断是否闰平年
        {
            return(0 == year%4 && (year%100 !=0 || year%400 == 0));
        }
        function optionsClear(e)
        {
            e.options.length = 1;
        }
    </script>
@endsection