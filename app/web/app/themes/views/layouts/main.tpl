<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        {include '_head.tpl'}
        <link rel="stylesheet" href="{$smarty.const.WEB_CSS}/comm.icon.css" />
        <link rel="stylesheet" type="text/css" href="{$smarty.const.WEB_CSS}/web.min.css" />
        <script src="/dest/libs/jquery.js"></script>
        <script src="/dest/common.js"></script>
    </head>
    <body>
        {include 'header.tpl'}
        {$content}
        {include 'footer.tpl'}
    </body>
</html>