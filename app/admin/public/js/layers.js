// layer组件扩展文件
var layers = {
    // 异步frame
    frame: function (url, t, w, h) {
        var ii = layer.load();
        //此处用setTimeout演示ajax的回调
        setTimeout(function () {
            layer.close(ii);
        }, 1000);
        //
        layer.open({
            type: 2,
            title: t,
            area: [w + 'px', h + 'px'],
            fix: false,
            maxmin: true,
            shadeClose: true,
            content: [url]
        });
    }
    ,
    // 全屏frame
    full: function (url, t, w, h) {
        var ii = layer.load();
        //此处用setTimeout演示ajax的回调
        setTimeout(function () {
            layer.close(ii);
        }, 1000);
        //
        var index = layer.open({
            type: 2,
            title: t,
            area: [w + 'px', h + 'px'],
            fix: false,
            maxmin: true,
            shadeClose: true,
            content: [url]
        });
        layer.full(index);
    }
    ,
    // 异步frame
    open: function (url, t, w, h) {
        var ii = layer.load();
        //此处用setTimeout演示ajax的回调
        setTimeout(function () {
            layer.close(ii);
        }, 1000);
        //
        layer.open({
            type: 2,
            title: t,
            area: [w + 'px', h + 'px'],
            fix: false,
            maxmin: true,
            shadeClose: true,
            content: [url, 'no']
        });
    }
    ,
    // 异步删除
    del: function (url, data) {
        layer.confirm('您确定要删除这条记录？', {
            btn: ['确定', '取消'] //按钮
        }, function () {
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: data,
                success: function (data) {
                    if (data.status != 1) {
                        return layer.alert(data.msg);
                    }
                    if (data.url) {
                        location.href = data.url;
                    } else {
                        location.reload();
                    }
                },
                error: function (error) {
                    layer.alert('抱歉，请求异常');
                }
            });
        }, function () {
            layer.msg('已取消', {icon: 2});
        });
    }
    ,

    // 异步恢复
    back: function (url, data) {
        layer.confirm('您确定要恢复这条记录？', {
            btn: ['确定', '取消'] //按钮
        }, function () {
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: data,
                success: function (data) {
                    if (data.status != 1) {
                        return layer.alert(data.msg);
                    }
                    if (data.url) {
                        location.href = data.url;
                    } else {
                        location.reload();
                    }
                },
                error: function (error) {
                    layer.alert('抱歉，请求异常');
                }
            });
        }, function () {
            layer.msg('已取消', {icon: 2});
        });
    }
    ,
    post: function (url, data) {
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: data,
            success: function (data) {
                if (data.status != 1) {
                    return swal(data.msg, '', "error");
                }
                if (data.url) {
                    location.href = data.url;
                } else {
                    return swal({type: "success", title: data.msg, text: ''}, function () {
                        location.reload();
                    });
                }
            },
            error: function (error) {
                return swal("请求或返回数据异常", '', "error");
            }
        });
    }
};

var swals = {
    cancel: function (url, id) {
        swal({
            title: "您确定要删除这条记录吗",
            text: "删除后将无法恢复，请谨慎操作！",
            type: "warning",
            cancelButtonColor: "#1ab394",
            cancelButtonText: '取消',
            showCancelButton: true,
            confirmButtonColor: "#ec4758",
            confirmButtonText: "删除",
            closeOnConfirm: false
        }, function () {
            layers.post(url, {id: id});
        });
    },
    // 异步删除
    actions: function (url, id) {
        swal({
            title: "您确定要执行此操作吗?",
            text: "操作后将无法恢复，请谨慎操作！",
            type: "warning",
            cancelButtonColor: "#1ab394",
            cancelButtonText: '取消',
            showCancelButton: true,
            confirmButtonColor: "#ec4758",
            confirmButtonText: "确定",
            closeOnConfirm: false
        }, function () {
            layers.post(url, {id: id});
        });
    }
};