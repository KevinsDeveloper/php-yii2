<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>YiiGiant</title>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="viewport" content="width=device-width"/>
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
        <link href="/themes/default/style.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="/themes/default/style.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="/themes/css/core.css" rel="stylesheet" type="text/css" media="screen"/>

        <!--[if IE]>
        <link href="/themes/css/ieHack.css" rel="stylesheet" type="text/css" media="screen"/>
        <![endif]-->

        <!--[if lt IE 9]>
        <script src="/js/speedup.js" type="text/javascript"></script>
        <script src="/js/jquery-1.11.3.min.js" type="text/javascript"></script>
        <![endif]-->
        <!--[if gte IE 9]><!--><script src="/js/jquery-2.1.4.min.js" type="text/javascript"></script><!--<![endif]-->

        <script src="/js/jquery.cookie.js" type="text/javascript"></script>
        <script src="/js/jquery.validate.js" type="text/javascript"></script>
        <script src="/js/jquery.bgiframe.js" type="text/javascript"></script>
        <script src="/js/dwz.min.js" type="text/javascript"></script>
        <script src="/js/dwz.regional.zh.js" type="text/javascript"></script>
        {literal}
            <script type="text/javascript">
                $(function () {
                    DWZ.init("/dwz.frag.xml", {
                        //loginUrl:"login_dialog.html",
                        loginUrl: "/site/login",
                        loginTitle: "登录",
                        statusCode: {ok: 200, error: 300, timeout: 301},
                        pageInfo: {pageNum: "pageNum", numPerPage: "numPerPage", orderField: "orderField", orderDirection: "orderDirection"},
                        keys: {statusCode: "statusCode", message: "message"},
                        ui: {hideMode: 'offsets'},
                        debug: false,
                        callback: function () {
                            initEnv();
                            $("#themeList").theme({themeBase: "themes"});
                        }
                    });
                });
            </script>
        {/literal}
    </head>
    <body>
        <div id="layout">
            <div id="header">
                <div class="headerNav">
                    <a class="logo" href="http://j-ui.com">标志</a>
                    <ul class="nav">
                        <li><a href="changepwd.html" target="dialog" width="600">设置</a></li>
                        <li><a href="http://www.weigiant.cn" target="_blank">官网</a></li>
                        <li><a href="/site/login/out">退出</a></li>
                    </ul>
                    <ul class="themeList" id="themeList">
                        <li theme="default"><div class="selected">蓝色</div></li>
                        <li theme="green"><div>绿色</div></li>
                        <li theme="purple"><div>紫色</div></li>
                        <li theme="silver"><div>银色</div></li>
                        <li theme="azure"><div>天蓝</div></li>
                    </ul>
                </div>
            </div>

            <div id="leftside">
                <div id="sidebar_s">
                    <div class="collapse">
                        <div class="toggleCollapse"><div></div></div>
                    </div>
                </div>
                <div id="sidebar">
                    <div class="toggleCollapse"><h2>主菜单</h2><div>收缩</div></div>
                    <div class="accordion" fillSpace="sidebar">
                        <div class="accordionContent">
                            <ul class="tree treeFolder">
                                <li>
                                    <a>系统管理</a>
                                    <ul>
                                        <li><a href="{$Url->to('/site/index/main')}" target="navTab" rel="setting">基本设置</a></li>
                                        <li><a href="demo_page1.html" target="navTab" rel="page1" fresh="false">替换页面一</a></li>
                                        <li><a href="demo_page2.html" target="navTab" rel="page2">页面二</a></li>
                                        <li><a href="demo/common/ajaxTimeout.html" target="navTab">navTab会话超时</a></li>
                                        <li><a href="demo/common/ajaxTimeout.html" target="dialog">dialog会话超时</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a>常用组件</a>
                                    <ul>
                                        <li><a href="w_panel.html" target="navTab" rel="w_panel">面板</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a>表单组件</a>
                                    <ul>
                                        <li><a href="w_validation.html" target="navTab" rel="w_validation">表单验证</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a>组合应用</a>
                                    <ul>
                                        <li><a href="demo/pagination/layout1.html" target="navTab" rel="pagination1">局部刷新分页1</a></li>
                                        <li><a href="demo/pagination/layout2.html" target="navTab" rel="pagination2">局部刷新分页2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="accordionHeader">
                            <h2><span>Folder</span>流程演示</h2>
                        </div>
                        <div class="accordionContent">
                            <ul class="tree">
                                <li><a href="newPage1.html" target="dialog" rel="dlg_page">列表</a></li>
                                <li><a href="newPage1.html" target="dialog" rel="dlg_page2">列表</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="container">
                <div id="navTab" class="tabsPage">
                    <div class="tabsPageHeader">
                        <!-- 显示左右控制时添加 class="tabsPageHeaderMargin" -->
                        <div class="tabsPageHeaderContent">
                            <ul class="navTab-tab">
                                <li tabid="main" class="main"><a href="javascript:;"><span><span class="home_icon">我的主页</span></span></a></li>
                            </ul>
                        </div>
                        <!-- 禁用只需要添加一个样式 class="tabsLeft tabsLeftDisabled" -->
                        <div class="tabsLeft">left</div>
                        <!-- 禁用只需要添加一个样式 class="tabsRight tabsRightDisabled" -->
                        <div class="tabsRight">right</div>
                        <div class="tabsMore">more</div>
                    </div>
                    <ul class="tabsMoreList">
                        <li><a href="javascript:;">我的主页</a></li>
                    </ul>
                    <div class="navTab-panel tabsPageContent layoutBox">

                    </div>
                </div>
            </div>

        </div>

        <div id="footer">Copyright &copy; 2017 微巨人网络工作室版权所有</div>
    </body>
</html>