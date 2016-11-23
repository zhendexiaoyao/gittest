<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>京西商城</title>
    <link rel="stylesheet" href="/Public/css/base.css" type="text/css">
    <link rel="stylesheet" href="/Public/css/global.css" type="text/css">
    <link rel="stylesheet" href="/Public/css/header.css" type="text/css">
    <link rel="stylesheet" href="/Public/css/index.css" type="text/css">
    <link rel="stylesheet" href="/Public/css/bottomnav.css" type="text/css">
    <link rel="stylesheet" href="/Public/css/footer.css" type="text/css">
    <link rel="stylesheet" href="/Public/css/common.css" type="text/css">
    
	<link rel="stylesheet" href="/Public/css/home.css" type="text/css">
	<link rel="stylesheet" href="/Public/css/address.css" type="text/css">

</head>
<body>
<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w1210 bc">
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

<!-- 头部 start -->
<div class="header w1210 bc mt15">
    <!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
    <div class="logo w1210">
        <h1 class="fl"><a href="index.html"><img src="/Public/Images/logo.png" alt="京西商城"></a></h1>
        <!-- 头部搜索 start -->
        <div class="search fl">
            <div class="search_form">
                <div class="form_left fl"></div>
                <form action="" name="serarch" method="get" class="fl">
                    <input type="text" class="txt" value="请输入商品关键字" /><input type="submit" class="btn" value="搜索" />
                </form>
                <div class="form_right fl"></div>
            </div>

            <div style="clear:both;"></div>

            <div class="hot_search">
                <strong>热门搜索:</strong>
                <a href="">D-Link无线路由</a>
                <a href="">休闲男鞋</a>
                <a href="">TCL空调</a>
                <a href="">耐克篮球鞋</a>
            </div>
        </div>
        <!-- 头部搜索 end -->

        <!-- 用户中心 start-->
        <div class="user fl">
            <dl>
                <dt>
                    <em></em>
                    <a href="">用户中心</a>
                    <b></b>
                </dt>
                <dd>
                    <div class="prompt">
                        您好，请<a href="">登录</a>
                    </div>
                    <div class="uclist mt10">
                        <ul class="list1 fl">
                            <li><a href="">用户信息></a></li>
                            <li><a href="">我的订单></a></li>
                            <li><a href="">收货地址></a></li>
                            <li><a href="">我的收藏></a></li>
                        </ul>

                        <ul class="fl">
                            <li><a href="">我的留言></a></li>
                            <li><a href="">我的红包></a></li>
                            <li><a href="">我的评论></a></li>
                            <li><a href="">资金管理></a></li>
                        </ul>

                    </div>
                    <div style="clear:both;"></div>
                    <div class="viewlist mt10">
                        <h3>最近浏览的商品：</h3>
                        <ul>
                            <li><a href=""><img src="/Public/Images/view_list1.jpg" alt="" /></a></li>
                            <li><a href=""><img src="/Public/Images/view_list2.jpg" alt="" /></a></li>
                            <li><a href=""><img src="/Public/Images/view_list3.jpg" alt="" /></a></li>
                        </ul>
                    </div>
                </dd>
            </dl>
        </div>
        <!-- 用户中心 end-->

        <!-- 购物车 start -->
        <div class="cart fl">
            <dl>
                <dt>
                    <a href="">去购物车结算</a>
                    <b></b>
                </dt>
                <dd>
                    <div class="prompt">
                        购物车中还没有商品，赶紧选购吧！
                    </div>
                </dd>
            </dl>
        </div>
        <!-- 购物车 end -->
    </div>
    <!-- 头部上半部分 end -->

    <div style="clear:both;"></div>

    <!-- 导航条部分 start -->
    <div class="nav w1210 bc mt10">
        <!--  商品分类部分 start-->
        <div class="category fl <?php if((ACTION_NAME) != "index"): ?>cat1<?php endif; ?>"> <!-- 非首页，需要添加cat1类 -->
            <div class="cat_hd <?php if((ACTION_NAME) != "index"): ?>off<?php endif; ?>">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
                <h2>全部商品分类</h2>
                <em></em>
            </div>
            <div class="cat_bd">
                <?php if(is_array($rows)): foreach($rows as $key=>$top): if(($top["parent_id"]) == "0"): ?><div class="cat item1">
                            <h3><a href=""><?php echo ($top["name"]); ?></a> <b></b></h3>
                            <div class="cat_detail">
                                <?php if(is_array($rows)): foreach($rows as $key=>$second): if(($second["parent_id"]) == $top["id"]): ?><dl class="dl_1st">
                                            <dt><a href=""><?php echo ($second["name"]); ?></a></dt>
                                            <dd>
                                                <?php if(is_array($rows)): foreach($rows as $key=>$third): if(($third['parent_id']) == $second['id']): ?><a href=""><?php echo ($third["name"]); ?></a><?php endif; endforeach; endif; ?>
                                            </dd>
                                        </dl><?php endif; endforeach; endif; ?>
                            </div>
                        </div><?php endif; endforeach; endif; ?>
            </div>
        </div>
        <!--  商品分类部分 end-->

        <div class="navitems fl">
            <ul class="fl">
                <li class="current"><a href="">首页</a></li>
                <li><a href="">电脑频道</a></li>
                <li><a href="">家用电器</a></li>
                <li><a href="">品牌大全</a></li>
                <li><a href="">团购</a></li>
                <li><a href="">积分商城</a></li>
                <li><a href="">夺宝奇兵</a></li>
            </ul>
            <div class="right_corner fl"></div>
        </div>
    </div>
    <!-- 导航条部分 end -->
</div>
<!-- 头部 end-->

	<div style="clear:both;"></div>

	<!-- 页面主体 start -->
	<div class="main w1210 bc mt10">
		<div class="crumb w1210">
			<h2><strong>我的XX </strong><span>> 我的订单</span></h2>
		</div>
		
		<!-- 左侧导航菜单 start -->
		<div class="menu fl">
			<h3>我的XX</h3>
			<div class="menu_wrap">
				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="">我的订单</a></dd>
					<dd><b>.</b><a href="">我的关注</a></dd>
					<dd><b>.</b><a href="">浏览历史</a></dd>
					<dd><b>.</b><a href="">我的团购</a></dd>
				</dl>

				<dl>
					<dt>账户中心 <b></b></dt>
					<dd class="cur"><b>.</b><a href="">账户信息</a></dd>
					<dd><b>.</b><a href="">账户余额</a></dd>
					<dd><b>.</b><a href="">消费记录</a></dd>
					<dd><b>.</b><a href="">我的积分</a></dd>
					<dd><b>.</b><a href="">收货地址</a></dd>
				</dl>

				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="">返修/退换货</a></dd>
					<dd><b>.</b><a href="">取消订单记录</a></dd>
					<dd><b>.</b><a href="">我的投诉</a></dd>
				</dl>
			</div>
		</div>
		<!-- 左侧导航菜单 end -->

		<!-- 右侧内容区域 start -->
		<div class="content fl ml10">
			<div class="address_hd">
				<h3>收货地址薄</h3>
				<?php if(is_array($addresses)): foreach($addresses as $key=>$address): ?><dl>
						<dt><?php echo ($key+1); ?>.<?php echo ($address["name"]); ?> <?php echo ($address["province_name"]); ?> <?php echo ($address["city_name"]); ?> <?php echo ($address["area_name"]); ?> <?php echo ($address["detail_address"]); ?> <?php echo ($address["tel"]); ?> </dt>
						<dd>
							<a href="<?php echo U('addressEdit',['id'=>$address['id']]);?>">修改</a>
							<a href="<?php echo U('removeAddress',['id'=>$address['id']]);?>">删除</a>
							<?php if(($address["is_default"]) != "1"): ?><a href="<?php echo U('is_defaultAddress',['id'=>$address['id']]);?>">设为默认地址</a><?php endif; ?>
						</dd>
					</dl><?php endforeach; endif; ?>
			</div>

			<div class="address_bd mt10">
				<h4>新增/修改收货地址</h4>
				<form action="<?php echo U('Address/addAddress');?>" method="post" name="address_form">
						<ul>
							<li>
								<label for=""><span>*</span>收 货 人：</label>
								<input type="text" name="name" class="txt" />
							</li>
							<li>
								<label for=""><span>*</span>所在地区：</label>
								<input type="hidden" name="province_name" id="province_name"/>
								<select name="province_id" id="province">
									<option value="">请选择</option>
									<?php if(is_array($provinces)): foreach($provinces as $key=>$province): ?><option value="<?php echo ($province["id"]); ?>"><?php echo ($province["name"]); ?></option><?php endforeach; endif; ?>
								</select>

								<input type="hidden" name="city_name" id="city_name" />
								<select name="city_id" id="city">
									<option value="">请选择</option>
								</select>

								<input type="hidden" name="area_name" id="area_name"/>
								<select name="area_id" id="area">
									<option value="">请选择</option>
								</select>
							</li>
							<li>
								<label for=""><span>*</span>详细地址：</label>
								<input type="text" name="detail_address" class="txt address"  />
							</li>
							<li>
								<label for=""><span>*</span>手机号码：</label>
								<input type="text" name="tel" class="txt" />
							</li>
							<li>
								<label for="">&nbsp;</label>
								<input type="checkbox" name="is_default" class="check" value='1' />设为默认地址
							</li>
							<li>
								<label for="">&nbsp;</label>
								<input type="submit" name="" class="btn" value="保存" />
							</li>
						</ul>
				</form>
			</div>	

		</div>
		<!-- 右侧内容区域 end -->
	</div>


<div style="clear:both;"></div>

<!-- 底部导航 start -->
<div class="bottomnav w1210 bc mt10">
    <?php if(is_array($article_categories)): foreach($article_categories as $key=>$article_cateogry): ?><div class="bnav<?php echo ($key); ?>">
            <h3><b></b> <em><?php echo ($article_cateogry); ?></em></h3>
            <ul>
                <?php if(is_array($articles[$key])): foreach($articles[$key] as $key=>$article): ?><li><a href="<?php echo U('Article/show',['id'=>$key]);?>"><?php echo ($article); ?></a></li><?php endforeach; endif; ?>
            </ul>
        </div><?php endforeach; endif; ?>
</div>
<!-- 底部导航 end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt10">
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
<script type="text/javascript" src="/Public/Js/header.js"></script>
<script type="text/javascript" src="/Public/Js/index.js"></script>

	<script type="text/javascript" src="/Public/Js/home.js"></script>
	<script type="text/javascript">
		$(function() {
			$('#province').change(function() {
				var province_id = $(this).val();
//				console.debug(province_id)
				var url = '<?php echo U("Locations/getListByParentId");?>';
				var data = {parent_id: province_id};
				$('#province_name').val($('#province :checked').text());
				$.getJSON(url, data, function(data) {
					//遍历结果集,放入到市级列表中
					//记得将jQuery对象变成DOM节点才能使用length属性
					$('#city').get(0).length = 1;
					$('#area').get(0).length = 1;
					$('#city_name').val('');
					$('#area_name').val('');

					$(data).each(function(i, city) {
						var html = '<option value="' + city.id + '">' + city.name + '</option>';
						$(html).appendTo($('#city'));
					});
				});
			});
			//---------------   切换市级 获取区县   ----------------
			$('#city').change(function() {
				var city_id = $(this).val();
				var url = '<?php echo U("Locations/getListByParentId");?>';
				var data = {parent_id: city_id};
				$('#city_name').val($('#city :checked').text());
				$.getJSON(url, data, function(data) {
					//遍历结果集,放入到市级列表中
					$('#area').get(0).length = 1;
					$('#area_name').val('');
					$(data).each(function(i, area) {
						var html = '<option value="' + area.id + '">' + area.name + '</option>';
						$(html).appendTo($('#area'));
					});
				});
			});

			$('#area').change(function() {
				$('#area_name').val($('#area :checked').text());
			});
		});
	</script>

</body>
</html>