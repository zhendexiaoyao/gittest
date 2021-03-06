<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加商品 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/css/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/css/main.css" rel="stylesheet" type="text/css" />
<link href="/Public/ext/uploadify/common.css" rel="stylesheet" type="text/css" />
<link href="/Public/ext/ztree/zTreeStyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>">商品列表</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加商品 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U();?>"enctype="multipart/form-data" >
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">商品名称</td>
                <td>
                    <input type="text" name="name" maxlength="60" value="<?php echo ($row["name"]); ?>" />
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">商品分类:</td>
                <td>
                    <input type="hidden" name="goods_category_id" id="parent_id" value="<?php echo ($rs["parent_id"]); ?>"/>
                    <ul id="parent_nodes" class="ztree"></ul>
                </td>
            </tr>
            <tr>
                <td class="label">商品品牌</td>
                <td>
                    <select name="brand_id" class="goods_brand">
                        <option>-请选择-</option>
                        <?php if(is_array($brands)): foreach($brands as $key=>$val): ?><option value="<?php echo ($val['id']); ?>"><?php echo ($val['name']); ?></option><?php endforeach; endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">市场价格</td>
                <td>
                    <input type="text" name="market_price" maxlength="60" value="<?php echo ($row["market_price"]); ?>" placeholder=""/>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">本店价格</td>
                <td>
                    <input type="text" name="shop_price" maxlength="60" value="<?php echo ($row["shop_price"]); ?>" placeholder=""/>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">库存</td>
                <td>
                    <input type="text" name="stock" maxlength="60" value="<?php echo ($row["stock"]); ?>" />
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">商品LOGO</td>
                <td>
                    <input type="file" id="logo" size="45" >
                    <input type="hidden" name="logo" id="logo-h" size="45" />
                </td>
            </tr>
            <tr>
                <td class="label">预览图片</td>
                <td>
                    <img src="<?php echo ($row["logo"]); ?>" style="width: 80px;height: 100px" id="logo-pre"/>
                </td>
            </tr>
            <tr>
                <td class="label">商品图片</td>
                <td>
                    <input type="file" id="goods_img" size="45" />
                </td>
            </tr>
            <tr>
                <td class="label">预览图片</td>
                <td id="pre_view">

                </td>
            </tr>
            <tr>
                <td class="label">商品状态</td>
                <td>
                    <input type="checkbox" class="goods_status" name="goods_status[]" value="1"/>精品
                    <input type="checkbox" class="goods_status" name="goods_status[]" value="2"/>新品
                    <input type="checkbox" class="goods_status" name="goods_status[]" value="4"/>热销
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
                <td class="label">是否上架</td>
                <td>
                    <input type="radio" class="is_on_sale" name="is_on_sale" value="1"  /> 是
                    <input type="radio" class="is_on_sale" name="is_on_sale" value="0"  /> 否
                </td>
            </tr>
            <tr>
                <td class="label">是否显示</td>
                <td>
                    <input type="radio" class="status" name="status" value="1"  /> 是
                    <input type="radio" class="status" name="status" value="0"  /> 否
                </td>
            </tr>
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
                <td colspan="2" align="center" ><br />
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
<script type="text/javascript" src="/Public/ext/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="/Public/ext/layer/layer.js"></script>
<script type="text/javascript" src="/Public/ext/ztree/jquery.ztree.core.min.js"></script>
<script type="text/javascript" >
    $(function() {
        $('.is_on_sale').val([<?php echo ((isset($row["is_on_sale"]) && ($row["is_on_sale"] !== ""))?($row["is_on_sale"]):1); ?>]);
        $('.status').val([<?php echo ((isset($row["status"]) && ($row["status"] !== ""))?($row["status"]):1); ?>]);
        $('.goods_brand').val([<?php echo ($row["brand_id"]); ?>])
        $('.goods_status').val(<?php echo ($row["goods_status"]); ?>);
        <?php if(isset($row)): ?>$.each(<?php echo ($row["path"]); ?>,function(i,n){
                var pre_view = $('#pre_view');
                var html = '';
            html +='<div style="float: left" class="box">'
            html +='<input type="hidden" name="path[]" value="'+n.path+'"/>';
            html += '<img src="'+n.path+'" style="width: 80px;height: 100px"/>';
            html +='<a href="javascript:void(0);">X</a>';
            html +='</div>';
                $(html).appendTo(pre_view);
        });<?php endif; ?>
        $('#logo').uploadify({
            swf: '/Public/ext/uploadify/uploadify.swf',
            uploader: "<?php echo U('Upload/upload');?>",
            buttonText:'选择文件',
            //fileTypeDesc:'选择文件吧',
            //fileTypeExts:'*.jpg;*.png',
            onUploadSuccess:function(file,data){
                data = $.parseJSON(data);
                if(!data.status){
                    layer.msg(data.msg,{icon: 5});
                }else{
                    layer.msg(data.msg,{icon: 6});
                    $('#logo-h').val(data.url);
                    $('#logo-pre').attr('src',data.url);
                }
            },
        });
        $('#goods_img').uploadify({
            swf: '/Public/ext/uploadify/uploadify.swf',
            uploader: "<?php echo U('Upload/upload');?>",
            buttonText:'选择文件',
            //fileTypeDesc:'选择文件吧',
            //fileTypeExts:'*.jpg;*.png',
            onUploadSuccess:function(file,data){
                data = $.parseJSON(data);
                if(!data.status){
                    layer.msg(data.msg,{icon: 5});
                }else{
                    layer.msg(data.msg,{icon: 6});
                    var pre_view = $('#pre_view');
                    var html = '';
                    html +='<div style="float: left" class="box">'
                    html +='<input type="hidden" name="path[]" value="'+data.url+'"/>';
                    html += '<img src="'+data.url+'" style="width: 80px;height: 100px"/>';
                    html +='<a href="javascript:void(0);">X</a>';
                    html +='</div>';
                    $(html).appendTo(pre_view);
                }
            },
        });
        $('#pre_view').on('click','.box a',function(){
            $(this).parent().remove();
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
                beforeClick:function(tree_id,tree_node){
                    if(tree_node.isParent){
                        layer.msg('请选择子节点',{icon: 5});
                        return false;
                    }
                }
            },
        };

        var zNodes = <?php echo ($categories); ?>;

        $(document).ready(function() {
            var ztree_obj = $.fn.zTree.init($("#parent_nodes"), setting, zNodes);
            ztree_obj.expandAll(true);
            <?php if(isset($row)): ?>var parent_node = ztree_obj.getNodeByParam('id',<?php echo ($row["goods_category_id"]); ?>);
            ztree_obj.selectNode(parent_node)<?php endif; ?>
        });
    });
</script>
</body>
</html>