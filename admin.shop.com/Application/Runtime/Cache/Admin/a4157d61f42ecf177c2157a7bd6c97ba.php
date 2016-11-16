<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: category_list.htm 17019 2010-01-29 10:10:34Z liuhui $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品分类 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/css/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/css/main.css" rel="stylesheet" type="text/css" />
<link href="/Public/css/page.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('add');?>">添加分类</a></span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品分类 </span>
    <div style="clear:both"></div>
</h1>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table width="100%" cellspacing="1" cellpadding="2" id="list-table">
            <tr>
                <th>分类名称</th>
                <th>分类简介</th>
                <th>是否显示</th>
                <th>排序</th>
                <th>帮助相关</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($rows)): foreach($rows as $key=>$val): ?><tr align="center" class="0">
                <td align="center" class="first-cell" >
                <span><?php echo ($val["name"]); ?></span>
                </td>
                <td width="15%"><?php echo ($val["intro"]); ?></td>
                <td width="15%"><img src="/Public/Images/<?php echo ($val["status"]); ?>.gif" /></td>
                <td width="15%"><img src="/Public/Images/<?php echo ($val["is_help"]); ?>.gif" /></td>
                <td width="15%" align="center"><span><?php echo ($val["sort"]); ?></span></td>
                <td width="30%" align="center">
                <a href="<?php echo U('edit',['id'=>$val['id']]);?>">编辑</a> |
                <a href="<?php echo U('remove',['id'=>$val['id']]);?>" title="移除" onclick="">移除</a>
                </td>
            </tr><?php endforeach; endif; ?>
                <tr>
                    <td align="right" nowrap="true" colspan="6">
                        <div id="turn-page" class="page">
                            <?php echo ($pageBar); ?>
                        </div>
                    </td>
                </tr>
        </table>
    </div>
</form>
<div id="footer">
共执行 1 个查询，用时 0.055904 秒，Gzip 已禁用，内存占用 2.202 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>