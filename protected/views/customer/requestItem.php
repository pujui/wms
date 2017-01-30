<table class="detail-list">
	<tr>
		<th>序號</th>
		<th>商品型號</th>
		<th>商品名稱</th>
		<th>成本價</th>
		<th>商品類別</th>
	</tr>
	<?php foreach ($items as $key=>$row){ ?>
	<tr <?php if($key%2 == 1){ ?>class="odd-row" <?php } ?>>
		<td>
			<?=$row['item_id'] ?>
			<button type="button" class="btn btn-default selectItem" 
			data-sn="<?=$row['item_id'] ?>"
			data-serial="<?=CHtml::encode($row['item_serial']) ?>"
			data-name="<?=CHtml::encode($row['item_name']) ?>"
			data-price="<?=CHtml::encode($row['primary_price']) ?>"
			>確認</button>
		</td>
		<td style="text-align: left;">
			<?=CHtml::encode($row['item_serial']) ?>
		</td>
		<td>
			<?=CHtml::encode($row['item_name']) ?>
		</td>
		<td >
			<?=CHtml::encode($row['primary_price']) ?>
		</td>
		<td >
			<?=CHtml::encode($item_types[$row['item_type']]) ?>
		</td>
	</tr>
	<?php }?>
</table>