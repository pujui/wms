<link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl; ?>/css/justified-nav.css" />
<link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl; ?>/js/jquery/jquery-ui-1.10.3.custom/ui-lightness/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl; ?>/css/frame.css" />
<?php
$tp_lang = [
	0 => '進貨',
	1 => '出貨',
	2 => '估價'
];
?>
<?php foreach ($data as $key=>$row){ ?>
<table class="detail-list" style="width: 800px;">
	<tr>
		<th colspan="2"><?=CHtml::encode($tp_lang[$row['history_type']].'單號：'.$row['history_serial']) ?></th>
	</tr>
	<tr>
		<th>姓名</th>
		<td><?=CHtml::encode($row['customer_name']) ?></td>
	</tr>
	<tr>
		<th>電話1</th>
		<td><?=CHtml::encode($row['customer_tel1']) ?></td>
	</tr>
	<tr>
		<th>電話2</th>
		<td><?=CHtml::encode($row['customer_tel2']) ?></td>
	</tr>
	<tr>
		<th>手機</th>
		<td><?=CHtml::encode($row['customer_phone']) ?></td>
	</tr>
	<tr>
		<th>傳真</th>
		<td><?=CHtml::encode($row['customer_tel1']) ?></td>
	</tr>
	<tr>
		<th>地址</th>
		<td><?=CHtml::encode($row['customer_address']) ?></td>
	</tr>
	<tr>
		<th>發票號碼</th>
		<td><?=CHtml::encode($row['serial_numbers']) ?></td>
	</tr>
	<tr>
		<th>總價格</th>
		<td>$<?=number_format($row['total_price']) ?></td>
	</tr>
	<tr>
		<th colspan="2">商品詳細</th>
	</tr>
	<tr>
		<td style="text-align: left;" colspan="2" >
			<table width="100%">
			<?php foreach ($row['details'] as $key=>$detail){ ?>
			<tr >
				<td><?=CHtml::encode($detail['item_name']) ?></td>
				<td><?=CHtml::encode($detail['item_serial']) ?></td>
				<td>$<?=number_format($detail['price']) ?></td>
				<td>x<?=CHtml::encode($detail['item_count']) ?></td>
				<td>$<?=number_format($detail['item_total_price']) ?></td>
			</tr>
			<?php }?>
			</table>
		</td>
	</tr>
</table>
<hr/>
<?php }?>