<?php /* Smarty version Smarty-3.1.20, created on 2017-02-14 14:37:06
         compiled from "/app/yii-giant/app/admin/app/views/home/index/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1403755319589f2db2223c19-60623558%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4b394943c9bf1f7d20e592759597ed2661f20bae' => 
    array (
      0 => '/app/yii-giant/app/admin/app/views/home/index/main.tpl',
      1 => 1487083022,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1403755319589f2db2223c19-60623558',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.20',
  'unifunc' => 'content_589f2db2246938_27769193',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_589f2db2246938_27769193')) {function content_589f2db2246938_27769193($_smarty_tpl) {?><h2 class="contentTitle">系统基本设置</h2>
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
        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
            </ul>
        </div>
    </form>
</div>
<?php }} ?>
