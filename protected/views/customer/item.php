<div id="tabs">
    <ul>
        <li><a href="#tabs-1">商品列表</a></li>
		<li style="width: 780px; text-align: right;">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-default" onclick="location.href='<?=Yii::app()->request->baseUrl; ?>/customer/itemAdd';" >新增商品資料</button>
			</div>
		</li>
    </ul>
    <div id="tabs-1">
		<form id="searchOrderForm" method="get">
			<table class="detail-list searchOrderTable" >
				<tr>
					<td style="text-align: left; padding-left: 20px;">
						<div>
							<input type="text" name="name" value="<?=CHtml::encode($pageVO->params['name']) ?>" placeholder="商品名稱" />
							<input type="text" name="item_serial" value="<?=CHtml::encode($pageVO->params['item_serial']) ?>" placeholder="商品型號" />
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
				<th>商品型號</th>
				<th>商品名稱</th>
				<th>成本價</th>
				<th>已進數量</th>
				<th>已出數量</th>
				<th>剩餘數量</th>
				<th>商品類別</th>
				<th>功能</th>
			</tr>
			<?php foreach ($customers as $key=>$row){ ?>
			<tr <?php if($key%2 == 1){ ?>class="odd-row" <?php } ?>>
				<td>
					<?=$row['item_id'] ?>
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
					<?=number_format($row['item_count_in']) ?>
				</td>
				<td >
					<?=number_format($row['item_count_out']) ?>
				</td>
				<td >
					<?=number_format($row['item_count_in']-$row['item_count_out']) ?>
				</td>
				<td >
					<?=CHtml::encode($item_types[$row['item_type']]) ?>
				</td>
				<td>
					<button type="button" class="btn btn-default" onclick="location.href='<?=Yii::app()->request->baseUrl; ?>/customer/itemEdit/?id=<?=$row['item_id'] ?>';" >編輯</button><br/>
				</td>
			</tr>
			<?php }?>
		</table>
		<?php
		$this->widget('CPageView',array(
			'pageVO' => $pageVO
		));
		?>
	</div>
</div>