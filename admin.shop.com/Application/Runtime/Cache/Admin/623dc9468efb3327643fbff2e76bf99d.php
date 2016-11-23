<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: category_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加分类 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/css/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/css/main.css" rel="stylesheet" type="text/css" />
<link href="/Public/ext/ztree/zTreeStyle.css" rel="stylesheet" type="text/css" />
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
                    <input type="hidden" name="id"  value='<?php echo ($rs["id"]); ?>' />
                </td>
            </tr>
            <tr>
                <td class="label">父级分类:</td>
                <td>
                    <input type="hidden" name="parent_id" id="parent_id" value="<?php echo ($rs["parent_id"]); ?>"/>
                    <ul id="parent_nodes" class="ztree"></ul>
                </td>
            </tr>
            <tr>
                <td class="label">分类简介:</td>
                <td>
                    <textarea name="intro" rows="6" cols="40" ><?php echo ($rs["intro"]); ?></textarea>
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
<script type="text/javascript" src="/Public/ext/ztree/jquery.ztree.core.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('#parent_id').val([<?php echo ($rs["parent_id"]); ?>]);
    });
    var setting = {
        data: {
            simpleData: {
                enable: true,
                pIdKey:'parent_id',
            }
        },
        callback:{
            onClick:function(event,ele_id,node){
                $('#parent_id').val(node.id);
            },
        },
    };

    var zNodes = <?php echo ($categories); ?>;

    $(document).ready(function() {
        var ztree_obj = $.fn.zTree.init($("#parent_nodes"), setting, zNodes);
        ztree_obj.expandAll(true);
        <?php if(isset($rs)): ?>var parent_node = ztree_obj.getNodeByParam('id',<?php echo ($rs["parent_id"]); ?>);
    ztree_obj.selectNode(parent_node)<?php endif; ?>
    });

</script>
</body>
</html>