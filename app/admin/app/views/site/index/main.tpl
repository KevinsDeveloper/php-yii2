<h2 class="contentTitle">系统基本设置</h2>
<div class="pageFormContent" layoutH="60">
    <form method="post" action="demo/common/ajaxDone.html" class="pageForm required-validate" onsubmit="return validateCallback(this)">

        <fieldset>
            <legend>单行文本框</legend>
            <dl>
                <dt>普通输入框：</dt>
                <dd><input name="field1" type="text" /></dd>
            </dl>
            <dl>
                <dt>提示信息：</dt>
                <dd><input name="field2" type="text" alt="提示信息"/></dd>
            </dl>
            <dl>
                <dt>错误：</dt>
                <dd><input class="error" name="field4" type="text" /></dd>
            </dl>
            <dl>
                <dt>只读：</dt>
                <dd><input readonly="true" name="field5" type="text" /></dd>
            </dl>
            <dl>
                <dt>禁用：</dt>
                <dd><input disabled="true" name="field6" type="text" /></dd>
            </dl>
            <dl>
                <dt>密码：</dt>
                <dd><input name="password" type="text" /></dd>
            </dl>
        </fieldset>

        <fieldset>
            <legend>多行文本框(文本域)</legend>
            <dl class="nowrap">
                <dt>普通文本框：</dt>
                <dd><textarea name="textarea1" cols="80" rows="2"></textarea></dd>
            </dl>
            <dl class="nowrap">
                <dt>必填：</dt>
                <dd><textarea name="textarea2" class="required" cols="80" rows="2"></textarea></dd>
            </dl>
            <dl class="nowrap">
                <dt>错误：</dt>
                <dd><textarea name="textarea3" class="error" cols="80" rows="2"></textarea></dd>
            </dl>
            <dl class="nowrap">
                <dt>只读：</dt>
                <dd><textarea name="textarea4" readonly="true" cols="80" rows="2"></textarea></dd>
            </dl>
            <dl class="nowrap">
                <dt>禁用：</dt>
                <dd><textarea name="textarea5" disabled="true" cols="80" rows="2"></textarea></dd>
            </dl>
        </fieldset>
        <div class="formButton">
            <div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div>
            <div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
        </div>
    </form>
</div>
