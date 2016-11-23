<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>成功提交订单</title>
    <link rel="stylesheet" href="/Public/css/base.css" type="text/css">
    <link rel="stylesheet" href="/Public/css/global.css" type="text/css">
    <link rel="stylesheet" href="/Public/css/header.css" type="text/css">
    <link rel="stylesheet" href="/Public/css/success.css" type="text/css">
    <link rel="stylesheet" href="/Public/css/footer.css" type="text/css">
    
	<link rel="stylesheet" href="/Public/css/fillin.css" type="text/css">

</head>
<body>
<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w990 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li>您好，欢迎来到京西！[<a href="login.html">登录</a>] [<a href="register.html">免费注册</a>] </li>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="/Public/Images/logo.png" alt="京西商城"></a></h2>
        <div class="flow fr flow3">
            <ul>
                <li>1.我的购物车</li>
                <li>2.填写核对订单信息</li>
                <li class="cur">3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>

<!-- 主体部分 start -->

	<div class="fillin w990 bc mt15">
		<div class="fillin_hd">
			<h2>填写并核对订单信息</h2>
		</div>

		<div class="fillin_bd">
			<!-- 收货人信息  start-->
			<div class="address">
				<h3>收货人信息</h3>
				<div class="address_info">
					<?php if(is_array($addresses)): foreach($addresses as $key=>$address): ?><p>
							<input type="radio" value="<?php echo ($address["id"]); ?>" name="address_id" <?php if(($address["is_default"]) == "1"): ?>checked="checked"<?php endif; ?>/><?php echo ($address["name"]); ?>  <?php echo ($address["tel"]); ?>  <?php echo ($address["province_name"]); ?> <?php echo ($address["city_name"]); ?> <?php echo ($address["area_name"]); ?> <?php echo ($address["detail_address"]); ?> </p><?php endforeach; endif; ?>
				</div>

			</div>
			<!-- 收货人信息  end-->

			<!-- 配送方式 start -->
			<div class="delivery">
				<h3>送货方式</h3>
				<div class="delivery_info">
					<p>
						<input type="radio" value="1" name="delivery_id" checked="checked"/> 顺丰 运费25,速度快,价格高
					</p>
					<p>
						<input type="radio" value="2" name="delivery_id" /> 天天 运费10,速度一般,价格便宜
					</p>
					<p>
						<input type="radio" value="3" name="delivery_id" /> 自提 你来,我一直在
					</p>
				</div>
			</div>
			<!-- 配送方式 end --> 

			<!-- 支付方式  start-->
			<div class="pay">
				<h3>支付方式</h3>
				<div class="pay_info">
					<p>
						<input type="radio" value="1" name="payment" checked="checked"/> 微信支付
					</p>
					<p>
						<input type="radio" value="2" name="payment"/> 银联在线
					</p>
					<p>
						<input type="radio" value="3" name="payment"/> 邮局汇款
					</p>
					<p>
						<input type="radio" value="4" name="payment"/> 货到付款
					</p>
				</div>
			</div>
			<!-- 支付方式  end-->
			<!-- 商品清单 start -->
			<div class="goods">
				<h3>商品清单</h3>
				<table>
					<thead>
						<tr>
							<th class="col1">商品</th>
							<th class="col3">价格</th>
							<th class="col4">数量</th>
							<th class="col5">小计</th>
						</tr>	
					</thead>
					<tbody>
					<?php if(is_array($goods_detail)): foreach($goods_detail as $key=>$goods): ?><tr>
							<td class="col1"><a href="<?php echo U('Index/goods',['id'=>$goods['id']]);?>"><img src="<?php echo ($goods["logo"]); ?>" alt="" /></a>  <strong><a href="<?php echo U('Index/goods',['id'=>$goods['id']]);?>"><?php echo ($goods["name"]); ?></a></strong></td>
							<td class="col3">￥<?php echo ($goods["shop_price"]); ?></td>
							<td class="col4"> <?php echo ($goods["amount"]); ?></td>
							<td class="col5"><span>￥<?php echo ($goods["sub_total"]); ?></span></td>
						</tr><?php endforeach; endif; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">
								<ul>
									<li>
										<span>4 件商品，总商品金额：</span>
										<em>￥5316.00</em>
									</li>
									<li>
										<span>返现：</span>
										<em>-￥240.00</em>
									</li>
									<li>
										<span>运费：</span>
										<em>￥10.00</em>
									</li>
									<li>
										<span>应付总额：</span>
										<em>￥5076.00</em>
									</li>
								</ul>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<!-- 商品清单 end -->
		
		</div>

		<div class="fillin_ft">
			<a href=""><span>提交订单</span></a>
			<p>应付总额：<strong>￥<?php echo ($total_price); ?>元</strong></p>
			
		</div>
	</div>


<!-- 主体部分 end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="/Public/Images/xin.png" alt="" /></a>
        <a href=""><img src="/Public/Images/kexin.jpg" alt="" /></a>
        <a href=""><img src="/Public/Images/police.jpg" alt="" /></a>
        <a href=""><img src="/Public/Images/beian.gif" alt="" /></a>
    </p>
</div>
<!-- 底部版权 end -->
<script type="text/javascript" src="/Public/Js/jquery-1.8.3.min.js"></script>

	<script type="text/javascript" src="/Public/Js/cart2.js"></script>

</body>
</html>