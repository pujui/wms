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
<table style="width: 700px;">
	<tr>
		<th colspan="4">先鋒電器行 - <?=CHtml::encode($tp_lang[$row['history_type']].'單號：'.$row['history_serial']) ?></th>
	</tr>
	<tr >
		<td colspan="1">姓名</td>
		<td colspan="3" ><?=CHtml::encode($row['customer_name']) ?></td>
	</tr>
	<tr>
		<td>電話1</td>
		<td><?=CHtml::encode($row['customer_tel1']) ?></td>
		<td>電話2</td>
		<td><?=CHtml::encode($row['customer_tel2']) ?></td>
	</tr>
	<tr>
		<td>手機</td>
		<td><?=CHtml::encode($row['customer_phone']) ?></td>
		<td>傳真</td>
		<td><?=CHtml::encode($row['customer_tel1']) ?></td>
	</tr>
	<tr >
		<td colspan="1">地址</td>
		<td colspan="3" ><?=CHtml::encode($row['customer_address']) ?></td>
	</tr>
	<tr >
		<td colspan="1">發票號碼</td>
		<td colspan="3" ><?=CHtml::encode($row['serial_numbers']) ?></td>
	</tr>
	<tr>
		<th colspan="4">商品明細</th>
	</tr>
	<tr>
		<td style="text-align: left;" colspan="4" >
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
			<tr >
				<td colspan="4">合計：</td>
				<td >$<?=number_format($row['total_price']) ?></td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="text-align: left;" >稅額：</td>
		<td style="text-align: left;" >折讓金額：</td>
		<td style="text-align: left;" >未收：$<?=number_format($row['total_price']) ?></td>
		<td style="text-align: left;" >總計：$<?=number_format($row['total_price']) ?></td>
	</tr>
	<tr>
		<th >備註：</th>
		<td ></td>
		<th >簽收：</th>
		<td></td>
	</tr>
</table>
<div style="page-break-before: always; "></div>
<?php }?>