{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Admin</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="viewport" content="width=device-width"/>
    <link rel="shortcut icon" type="image/x-icon" href="/style/favicon.ico" />
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
    $(function(){
        DWZ.init("/dwz.frag.xml", {
            //loginUrl:"login_dialog.html",
            loginUrl:"/site/login",
            loginTitle:"登录",
            statusCode:{ok:200, error:300, timeout:301},
            pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"orderField", orderDirection:"orderDirection"},
            keys: {statusCode:"statusCode", message:"message"},
            ui:{hideMode:'offsets'},
            debug:false,
            callback:function(){
                initEnv();
                $("#themeList").theme({themeBase:"themes"});
            }
        });
    });
    </script>
    {/literal}
</head>
<body>
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i></div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element" style="text-align:center">
                        <div class="adminlogo"><img alt="image" class="img-circle" src="/img/profile_small.jpg" width="60"/></div>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">
                        <span class="clear">
                            <span class="block m-t-xs"><strong class="font-bold"></strong></span>
                            <span class="text-muted text-xs block">{$logindata['account']}「{$groupdata.role_name}」<b class="caret"></b></span>
                        </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class="J_menuItem" href="">个人资料</a></li>
                            <li class="divider"></li>
                            <li><a href="{Url::to("/site/login/out")}">安全退出</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">Giant</div>
                </li>
                {foreach from=$menudata item=v key=k}
                    {if $v.status == 1}
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fa {$v.icon}"></i>
                                <span class="nav-label">{$v.title}</span>
                                <span class="fa arrow"></span>
                            </a>
                            {if !empty($v.parentid)}
                                <ul class="nav nav-second-level">
                                    {foreach from=$v.parentid item=p}
                                        <li>
                                            <a class="J_menuItem" href="{Url::toRoute([$p.url])}" data-index="{$p.id}">{$p.title}</a>
                                        </li>
                                    {/foreach}
                                </ul>
                            {/if}
                        </li>
                    {/if}
                {/foreach}

            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row content-tabs">
            <div class="roll-nav roll-left J_tabLeft" style="background:#1ab394"><a class="navbar-minimalize btn-primary" href="#"><i class="fa fa-bars"></i></a></div>
            <button class="roll-nav roll-left J_tabLeft" style="left:40px;"><i class="fa fa-backward"></i></button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="/index/main">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i></button>
            <button class="roll-nav roll-right dropdown J_tabClose"><span class="dropdown-toggle" data-toggle="dropdown">关闭操作<span class="caret"></span></span>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a>定位当前选项卡</a></li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a>关闭全部选项卡</a></li>
                    <li class="J_tabCloseOther"><a>关闭其他选项卡</a></li>
                </ul>
            </button>
            <a href="{Url::to("/site/login/out")}" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="" frameborder="0" data-id="/index/main" seamless></iframe>
        </div>
    </div>
    <!--右侧部分结束-->
</div>

<!-- 全局js -->
<script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/js/plugins/layer/layer.min.js"></script>

<!-- 自定义js -->
<script src="/js/hplus.min.js?v=3.0.0"></script>
<script src="/js/contabs.min.js"></script>
</body>
</html>