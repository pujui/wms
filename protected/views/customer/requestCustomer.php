
<table class="detail-list">
	<tr>
		<th>序號</th>
		<th>姓名</th>
		<th>電話</th>
		<th>地址</th>
	</tr>
	<?php foreach ($customers as $key=>$row){ ?>
	<tr <?php if($key%2 == 1){ ?>class="odd-row" <?php } ?>>
		<td>
			<?=$row['customer_id'] ?>
			<button type="button" class="btn btn-default" 
				onclick="
					$('input[name=customer_id]').val(<?=$row['customer_id'] ?>);
					$('.customer_detail').text($('#bame<?=$row['customer_id'] ?>').text());
					$.unblockUI();
				"
			>確認</button>
		</td>
		<td id="bame<?=$row['customer_id'] ?>">
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
	</tr>
	<?php }?>
</table>