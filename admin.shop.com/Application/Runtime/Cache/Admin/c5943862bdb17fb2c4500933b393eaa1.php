<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: category_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加分类 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/css/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>">分类列表</a></span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加分类 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form action="<?php echo U();?>" method="post" name="theForm" enctype="multipart/form-data">
        <table width="100%" id="general-table">
            <tr>
                <td class="label">分类名称:</td>
                <td>
                    <input type='text' name='name' maxlength="20" value='<?php echo ($rs["name"]); ?>' size='27' /> <font color="red">*</font>
                </td>
            </tr>
            <tr>
                <td class="label">分类简介:</td>
                <td>
                    <input type="text" name='intro'  value="<?php echo ($rs["intro"]); ?>" size="15" />
                    <input type="hidden" name="id"  value="<?php echo ($rs["id"]); ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">排序:</td>
                <td>
                    <input type="text" name='sort'  value="<?php echo ($rs["sort"]); ?>" size="15" />
                </td>
            </tr>
            <tr>
                <td class="label">是否显示:</td>
                <td>
                    <input type="radio" name="status" class="status" value="1"  /> 是
                    <input type="radio" name="status" class="status" value="0"  /> 否
                </td>
            </tr>
            <tr>
                <td class="label">帮助相关:</td>
                <td>
                    <input type="radio" name="is_help" class="is_help" value="1"  /> 是
                    <input type="radio" name="is_help" class="is_help" value="0"  /> 否
                </td>
            </tr>
        </table>
        <div class="button-div">
            <input type="submit" value=" 确定 " />
            <input type="reset" value=" 重置 " />
        </div>
    </form>
</div>

<div id="footer">
共执行 3 个查询，用时 0.162348 秒，Gzip 已禁用，内存占用 2.266 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>
<script type="text/javascript" src="/Public/Js/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('.status').val([<?php echo ((isset($rs["status"]) && ($rs["status"] !== ""))?($rs["status"]):1); ?>]);
        $('.is_help').val([<?php echo ((isset($rs["is_help"]) && ($rs["is_help"] !== ""))?($rs["is_help"]):1); ?>]);
    })
</script>
</body>
</html>