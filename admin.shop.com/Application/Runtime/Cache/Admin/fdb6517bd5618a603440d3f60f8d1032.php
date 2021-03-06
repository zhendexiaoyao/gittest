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
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>">图片列表</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加图片 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U();?>"enctype="multipart/form-data" >
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">跳转地址</td>
                <td>
                    <input type="text" name="url" maxlength="60" value="<?php echo ($row["url"]); ?>" />
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">文字提示:</td>
                <td>
                    <input type="text" name="notice"  value="<?php echo ($row["notice"]); ?>"/>

                </td>
            </tr>
            <tr>
                <td class="label">开始时间:</td>
                <td>
                    <input type="date" name="start_time"  value="<?php echo (date("Y-m-d",$row['start_time'])); ?>"/>
                </td>
            </tr>
            <tr>
                <td class="label">结束时间:</td>
                <td>
                    <input type="date" name="end_time"  value="<?php echo (date("Y-m-d",$row['end_time'])); ?>"/>
                </td>
            </tr>
            <tr>
                <td class="label">banner图片</td>
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
                <td class="label">排序</td>
                <td>
                    <input type="text" name="sort" maxlength="40" size="15" value="<?php echo ($row["sort"]); ?>" />
                    <?php if(isset($row)): ?><input type="hidden" name="id"  value="<?php echo ($row["id"]); ?>" /><?php endif; ?>
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
<script type="text/javascript" >
    $(function() {
        $('.status').val([<?php echo ((isset($row["status"]) && ($row["status"] !== ""))?($row["status"]):1); ?>]);
    <?php if(isset($row)): ?>var pre_view = $('#pre_view');
        var html = '';
        html +='<div style="float: left" class="box">'
        html +='<input type="hidden" name="path" value="<?php echo ($row["path"]); ?>"/>';
        html += '<img src="<?php echo ($row["path"]); ?>" style="width: 80px;height: 100px"/>';
        html +='<a href="javascript:void(0);">X</a>';
        html +='</div>';
        $(html).appendTo(pre_view);<?php endif; ?>



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
                    html +='<input type="hidden" name="path" value="'+data.url+'"/>';
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
    });
</script>
</body>
</html>