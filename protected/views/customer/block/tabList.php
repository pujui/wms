<form id="searchOrderForm" method="get">
	<table class="detail-list searchOrderTable" >
		<tr>
			<td style="text-align: left; padding-left: 20px;">
				<div>
					<input type="text" name="name" value="<?=CHtml::encode($pageVO->params['name']) ?>" placeholder="姓名" />
					<input type="text" name="phone" value="<?=CHtml::encode($pageVO->params['phone']) ?>" placeholder="連絡電話" />
					<input type="text" name="address" value="<?=CHtml::encode($pageVO->params['address']) ?>" placeholder="地址" />
					<input type="text" name="serial_numbers" value="<?=CHtml::encode($pageVO->params['serial_numbers']) ?>" placeholder="統一編號" />
					<button type="submit" class="btn btn-default"  >搜尋</button>
					<button type="button" class="btn btn-default" onclick="location.href='?';" >預設搜尋</button>&nbsp;&nbsp;&nbsp;共<?=$pageVO->total?>筆資料
				</div>
			</td>
		</tr>
	</table>
</form>
<table class="detail-list">
	<tr>
		<th>序號</th>
		<th>客戶姓名</th>
		<th>客戶電話</th>
		<th>客戶地址</th>
		<th>時間</th>
		<th>功能</th>
	</tr>
	<?php foreach ($customers as $key=>$row){ ?>
	<tr <?php if($key%2 == 1){ ?>class="odd-row" <?php } ?>>
		<td>
			<?=$row['customer_id'] ?>
		</td>
		<td>
			<?=CHtml::encode($row['customer_name']) ?>
			<?php if($row['serial_numbers']!=''){ echo '<br/>統編:'.CHtml::encode($row['serial_numbers']); }?>
		</td>
		<td style="text-align: left;">
			電話1:<?=CHtml::encode($row['customer_tel1']) ?><br/>
			電話2:<?=CHtml::encode($row['customer_tel2']) ?><br/>
			手機:<?=CHtml::encode($row['customer_phone']) ?><br/>
			傳真:<?=CHtml::encode($row['customer_fax']) ?>
		</td>
		<td><?=CHtml::encode($row['customer_address']) ?></td>
		<td>
			建立:<?=date('Y-m-d H:i', strtotime($row['createtime'])) ?><br/>
			編輯:<?=date('Y-m-d H:i', strtotime($row['updatetime'])) ?>
		</td>
		<td>
			<button type="button" class="btn btn-default" onclick="location.href='<?=Yii::app()->request->baseUrl; ?>/customer/edit/?id=<?=$row['customer_id'] ?>';" >編輯</button><br/>
		</td>
	</tr>
	<?php }?>
</table>
<?php
$this->widget('CPageView',array(
	'pageVO' => $pageVO
));
?>