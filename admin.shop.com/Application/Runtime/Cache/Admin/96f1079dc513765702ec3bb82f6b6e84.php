<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ECSHOP 管理中心 - 商品列表 </title>
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/Public/css/general.css" rel="stylesheet" type="text/css" />
    <link href="/Public/css/main.css" rel="stylesheet" type="text/css" />
    <link href="/Public/css/page.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('add');?>">添加图片</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 图片列表 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <form action="<?php echo U();?>" name="searchForm">
        <img src="/Public/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />
        关键字<input type="text" name="keyword" size="15" value="<?php echo I('get.keyword');?>"/>
        <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>图片</th>
                <th>图片路径</th>
                <th>跳转路径</th>
                <th>文字提示</th>
                <th>开始时间</th>
                <th>结束时间</th>
                <th>是否显示</th>
                <th>排序</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($rows)): foreach($rows as $key=>$row): ?><tr>
                    <td align="center" class="first-cell">
                        <?php echo ($row["id"]); ?>
                    </td>
                    <td align="center">
                        <img alt="<?php echo ($row["notice"]); ?>" src="<?php echo ($row["path"]); ?>" style="width: 100px;height: 60px"/>
                    </td>
                    <td align="center">
                        <?php echo ($row["path"]); ?>
                    </td>
                    <td align="center">
                        <?php echo ($row["url"]); ?>
                    </td>
                    <td align="center">
                        <?php echo ($row["notice"]); ?>
                    </td>
                    <td align="center">
                        <?php echo (date("y-m-d",$row['start_time'])); ?>
                    </td>
                    <td align="center">
                        <?php echo (date("y-m-d",$row['end_time'])); ?>
                    </td>
                    <td align="center">
                        <img src="/Public/Images/<?php echo $row['status']&1?1:0;?>.gif" />
                    </td>
                    <td align="center">
                        <?php echo ($row["sort"]); ?>
                    </td>
                    <td align="center">
                        <a href="<?php echo U('edit',['id'=>$row['id']]);?>" title="编辑">编辑</a> |
                        <a href="<?php echo U('remove',['id'=>$row['id']]);?>" title="移除">移除</a>
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
    共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>