<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品品牌 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/css/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/css/main.css" rel="stylesheet" type="text/css" />
<link href="/Public/css/page.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('add');?>">添加品牌</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品品牌 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <form action="<?php echo U();?>" name="searchForm">
    <img src="/Public/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />
    <select name="goods_category_id">
        <option>所有分类</option>
        <?php if(is_array($categories)): foreach($categories as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>"><?php echo str_repeat('&nbsp;',($val['level']-1)*3); echo ($val['name']); ?></option><?php endforeach; endif; ?>
    </select>
    <!-- 品牌 -->
    <select name="brand_id">
        <option value="">所有品牌</option>
        <?php if(is_array($brands)): foreach($brands as $key=>$val): ?><option value="<?php echo ($val['id']); ?>"><?php echo ($val['name']); ?></option><?php endforeach; endif; ?>
    </select>
    <!-- 推荐 -->
    <select name="goods_status">
        <option value="">全部</option>
        <option value="is_best">精品</option>
        <option value="is_new">新品</option>
        <option value="is_hot">热销</option>
    </select>
    <!-- 上架 -->
    <select name="is_on_sale">
        <option value=''>全部</option>
        <option value="1">上架</option>
        <option value="0">下架</option>
    </select>
    关键字<input type="text" name="keyword" size="15" value="<?php echo I('get.keyword');?>"/>
    <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>商品名称</th>
                <th>货号</th>
                <th>本店价格</th>
                <th>上架</th>
                <th>精品</th>
                <th>新品</th>
                <th>热销</th>
                <th>排序</th>
                <th>库存</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($rows)): foreach($rows as $key=>$row): ?><tr>
                <td align="center" class="first-cell">
                    <?php echo ($row["id"]); ?>
                </td>
                <td align="center">
                    <?php echo ($row["name"]); ?>
                </td>
                <td align="center">
                    <?php echo ($row["sn"]); ?>
                </td>
                <td align="center">
                    <?php echo ($row["shop_price"]); ?>
                </td>
                <td align="center">
                    <img src="/Public/Images/<?php echo ($row["is_on_sale"]); ?>.gif" />
                </td>
                <td align="center">
                    <img src="/Public/Images/<?php echo $row['goods_status']&1?1:0;?>.gif" />
                </td>
                <td align="center">
                    <img src="/Public/Images/<?php echo $row['goods_status']&2?1:0;?>.gif" />
                </td>
                <td align="center">
                    <img src="/Public/Images/<?php echo $row['goods_status']&4?1:0;?>.gif" />
                </td>
                <td align="center">
                    <?php echo ($row["sort"]); ?>
                </td>
                <td align="center">
                    <?php echo ($row["stock"]); ?>
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