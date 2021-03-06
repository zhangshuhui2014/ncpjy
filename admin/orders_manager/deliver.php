<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2014
* Web: http://www.yc60.com
* ================================================
* Author:zhangshuhui
* Date: 2014-10-2
*/

session_start();
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT', 'deliver');
//引入公共文件
require dirname(__FILE__).'/../../includes/common.inc.php'; //转换成硬路径，速度更快
$_percent = 0.2;
if(isset($_GET['id']))
{
	$_id = $_GET['id'];
	$_result = _query("SELECT * FROM tb_orders WHERE deal='0' AND id = $_id LIMIT 1");
	$_rows = _fetch_array_list($_result);
	$_html = array();
	$_html['order_id'] = $_rows['order_id'];
	$_html['re_name'] = $_rows['re_name'];
	$_html['phone'] = $_rows['phone'];
	$_html['address'] = $_rows['address'];
	$_html['remarks'] = $_rows['remarks'];
	$_html['order_time'] = $_rows['order_time'];
	$_html = _html($_html);
}else{
	_alert_back("非法操作");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>发货</title>
<?php
	require ROOT_PATH.'includes/db_title.inc.php';
?>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/db_header.inc.php';
?>

<div id="member">
		<?php 
			require ROOT_PATH.'includes/orders_manager.inc.php';
		?>
	<div id="product_list">
	
		<h2>订单发货</h2>
		<form method="post" name="deliver" action ="deliver_sub.php?action=sub&order_id=<?php echo $_html['order_id']?>">
		<table cellspacing="1">
			<tr><th>商品信息</th><th>商品名称</th><th>单价</th><th>数量</th><th>备货状态</th></tr>
			<tr class="orders">
				<td colspan="5">
					<span>订单号:<?php echo $_html['order_id']?></span>
					<span>用户：<?php echo $_html['re_name']?></span>
					<span>购买时间：<?php echo $_html['order_time']?></span>
				</td>			
			</tr>
			<?php 
				$_result2 = _query("SELECT 
											of.id,
											of.name,
											of.pic,
											of.price,
											ord.quantity
										FROM 
											tb_product AS of,tb_order_items AS ord
										WHERE 
											ord.order_id='{$_rows['order_id']}' AND of.id=ord.product_id
										");
				while(!!$_rows2 = _fetch_array_list($_result2)){
					$_html['product_id'] = $_rows2['id'];
					$_html['name'] = $_rows2['name'];
					$_html['pic']=$_rows2['pic'];
					$_html['price'] = $_rows2['price'];
					$_html['quantity'] = $_rows2['quantity'];
					$_html = _html($_html);
			?>
			
			<tr class="product">			
				<td><img src="../../thumb.php?filename=<?php echo 'uploads/'.$_html['pic']?>&percent=<?php echo $_percent?>" /></td>
				<td><?php echo $_html['name']?></td>
				<td><?php echo $_html['price']?></td>
				<td><?php echo  $_html['quantity']?></td>
				<td>
					<input type="checkbox" name="Bike">已备货
				</td>
			</tr>
		
			<?php 
				}
			?>
		</table>
			<?php if($_GET['action'] == 'deliver'){ ?>
				<dl class="submit"><input type="submit" name="submit" style="width:80px;height:40px" value="确认发货"></input></dl>
			<?php } ?>
		</form>
			<dl class="order_info">
				<dt>收货人信息:</dt>
				<dd>收货人:<?php echo $_html['re_name']?></dd>
				<p class="line"></p>
				<dd>联系方式:<?php echo $_html['phone']?></dd>
				<p class="line"></p>
				<dd>收货地址:<?php echo $_html['address']?></dd>
				<p class="line"></p>
			</dl>
	</div>

</div>
<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>