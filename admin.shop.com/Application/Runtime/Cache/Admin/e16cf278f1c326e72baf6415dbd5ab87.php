<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加文章 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/css/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/css/main.css" rel="stylesheet" type="text/css" />
<link href="/Public/ext/uploadify/common.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>">文章列表</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加文章 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U();?>"enctype="multipart/form-data" >
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">文章名称</td>
                <td>
                    <input type="text" name="name" maxlength="60" value="<?php echo ($row["name"]); ?>" />
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">文章分类ID</td>
                <td>
                    <select name="article_category_id" class="article_category">
                        <option>-请选择-</option>
                        <?php if(is_array($cate)): foreach($cate as $key=>$val): ?><option value="<?php echo ($val['id']); ?>"><?php echo ($val['name']); ?></option><?php endforeach; endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">文章简介</td>
                <td>
                    <input type="text" name="intro" maxlength="60" value="<?php echo ($row["intro"]); ?>" />
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">排序</td>
                <td>
                    <input type="text" name="sort" maxlength="40" size="15" value="<?php echo ($row["sort"]); ?>" />
                    <input type="hidden" name="id"  value="<?php echo ($row["id"]); ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">是否显示</td>
                <td>
                    <input type="radio" class="status" name="status" value="1"  /> 是
                    <input type="radio" class="status" name="status" value="0"  /> 否(当品牌下还没有商品的时候，首页及分类页的品牌区将不会显示该品牌。)
                </td>
            </tr>
            <!--<tr>
                <td class="label">录入时间：</td>
                <td>
                    <input type="date" name="inputtime" maxlength="60" value="" />
                    <span class="require-field">*</span>
                </td>
            </tr>-->
            <tr>
                <td class="label">文章内容：</td>
                <td style="width: 700px;">
            <!--百度编辑器导入-->
            <textarea id="container" name="content" >
                <?php echo ($row["content"]); ?>
            </textarea>
            <!-- 配置文件 -->
            <script type="text/javascript" src="/Public/ext/ueditor/ueditor.config.js"></script>
            <!-- 编辑器源码文件 -->
            <script type="text/javascript" src="/Public/ext/ueditor/ueditor.all.js"></script>
            <!-- 实例化编辑器 -->
            <script type="text/javascript">
                var ue = UE.getEditor('container');
            </script>
            <!--百度编辑器导入结束-->
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br />
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>

<div id="footer">
共执行 1 个查询，用时 0.018952 秒，Gzip 已禁用，内存占用 2.197 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>
<script type="text/javascript" src="/Public/Js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="/Public/ext/layer/layer.js"></script>
<script type="text/javascript" >
    $(function() {
        $('.status').val([<?php echo ((isset($row["status"]) && ($row["status"] !== ""))?($row["status"]):1); ?>]);
        $('.article_category').val([<?php echo ($row["article_category_id"]); ?>]);
    });
</script>
</body>
</html>