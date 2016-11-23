<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>ECSHOP 管理中心 - 添加角色 </title>
        <meta name="robots" content="noindex, nofollow"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="/Public/css/general.css" rel="stylesheet" type="text/css"/>
        <link href="/Public/css/main.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <h1>
            <span class="action-span"><a href="<?php echo U('index');?>">角色列表</a></span>
            <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
            <span id="search_id" class="action-span1"> - 添加角色 </span>
        </h1>
        <div style="clear:both"></div>
        <div class="main-div">
            <form method="post" action="<?php echo U();?>" enctype="multipart/form-data">
                <table cellspacing="1" cellpadding="3" width="100%">
                    <tr>
                        <td class="label">用户名称</td>
                        <td>
                                <input type="text" name="username" maxlength="60" value="<?php echo ($row["username"]); ?>" disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">用户状态</td>
                        <td>
                            <input type="radio" name="status" value=1 checked="checked"/>启用
                            <input type="radio" name="status" value=0/>禁用
                        </td>
                    </tr>
                    <tr>
                        <td class="label">用户邮箱</td>
                        <td>
                            <input type="text" name="email" maxlength="60" value="<?php echo ($row["email"]); ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">用户电话</td>
                        <td>
                            <input type="hidden" name="id" value="<?php echo ($row["id"]); ?>"/>
                            <input type="text" name="tel" maxlength="60" value="<?php echo ($row["tel"]); ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">重置密码：</td>
                        <td>
                            <input type="text" name="password" maxlength="60" id="psd"/><input type="button" id="btn_psd" value="点击重置密码"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br/>
                            <input type="hidden" name="id" value="<?php echo ($row["id"]); ?>"/>
                            <input type="submit" class="button" value=" 确定 "/>
                            <input type="reset" class="button" value=" 重置 "/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <div id="footer">
            共执行 1 个查询，用时 0.018952 秒，Gzip 已禁用，内存占用 2.197 MB<br/>
            版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
        </div>
        <script type="text/javascript" src="/Public/Js/jquery-1.11.2.min.js"></script>
        <script type="text/javascript">
            $('#btn_psd').click(function(){
                var password = randomString(8);
                $('#psd').val(password);
            })
            function randomString(len) {
                len = len || 32;
                var $chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';    /****默认去掉了容易混淆的字符oOLl,9gq,Vv,Uu,I1****/
                var maxPos = $chars.length;
                var pwd = '';
                for (var i = 0; i < len; i++) {
                    pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
                }
                return pwd;
            }
        </script>
    </body>
</html>