<div id="tabs">
    <ul>
        <li><a href="#tabs-1"><?=CHtml::encode($tp_lang['title']) ?></a></li>
		<li style="width: 780px; text-align: right;">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-default" onclick="location.href='<?=Yii::app()->request->baseUrl; ?>/customer/<?=$tp_lang['add_path'] ?>';" ><?=CHtml::encode($tp_lang['add']) ?></button>
			</div>
		</li>
    </ul>
    <div id="tabs-1">
	<form id="searchOrderForm" method="get">
		<table class="detail-list searchOrderTable" >
			<tr>
				<td style="text-align: left; padding-left: 20px;">
					<div>
						建立日期：
						<input type="text" name="create_start" value="<?=CHtml::encode($pageVO->params['create_start']) ?>" readonly="readonly" placeholder="開始 <?=date('Y-m-d') ?>" />
						&nbsp;&nbsp;~&nbsp;&nbsp;<input type="text" name="create_end" value="<?=CHtml::encode($pageVO->params['create_end']) ?>" readonly="readonly" placeholder="結束 <?=date('Y-m-d') ?>" />
					</div>
				</td>
			</tr>
			<tr>
				<td style="text-align: left; padding-left: 20px;">
					<div>
						<?=CHtml::encode($tp_lang['kind_date']) ?>：
						<input type="text" name="start" value="<?=CHtml::encode($pageVO->params['start']) ?>" readonly="readonly" placeholder="開始 <?=date('Y-m-d') ?>" />
						&nbsp;&nbsp;~&nbsp;&nbsp;<input type="text" name="end" value="<?=CHtml::encode($pageVO->params['end']) ?>" readonly="readonly" placeholder="結束 <?=date('Y-m-d') ?>" />
					</div>
				</td>
			</tr>
			<tr>
				<td style="text-align: left; padding-left: 20px;">
					<div>
						<?=CHtml::encode($tp_lang['kind_serial']) ?>：
						<input type="text" name="history_serial" value="<?=CHtml::encode($pageVO->params['history_serial']) ?>" placeholder="<?=CHtml::encode($tp_lang['kind_serial']) ?>" />
						型號：
						<input type="text" name="item_serial" value="<?=CHtml::encode($pageVO->params['item_serial']) ?>" placeholder="商品型號" />
						序號：
						<input type="text" name="item_sn" value="<?=CHtml::encode($pageVO->params['item_sn']) ?>" placeholder="商品序號" />
					</div>
				</td>
			</tr>
			<tr>
				<td style="text-align: left; padding-left: 20px;">
					<div>
						電話：
						<input type="text" name="phone" value="<?=CHtml::encode($pageVO->params['phone']) ?>" placeholder="電話" />
						姓名：
						<input type="text" name="name" value="<?=CHtml::encode($pageVO->params['name']) ?>" placeholder="姓名" />
						地址：
						<input type="text" name="address" value="<?=CHtml::encode($pageVO->params['address']) ?>" placeholder="地址" />
					</div>
				</td>
			</tr>
			<tr>
				<td style="text-align: left; padding-left: 20px;">
					<div>
						排序方式：
						<select name="s">
							<option value="0" ><?=CHtml::encode($tp_lang['kind_date']) ?> - DESC</option>
							<option value="1" <?php if($pageVO->params['s']=='1'){ echo 'selected="selected"'; }?> ><?=CHtml::encode($tp_lang['kind_date']) ?> - ASC</option>
							<option value="2" <?php if($pageVO->params['s']=='2'){ echo 'selected="selected"'; }?> >建立日期 - DESC</option>
							<option value="3" <?php if($pageVO->params['s']=='3'){ echo 'selected="selected"'; }?> >建立日期 - ASC</option>
						</select>
						<button type="submit" class="btn btn-default"  >搜尋</button>
						<button type="button" class="btn btn-default" onclick="location.href='?';" >預設搜尋</button>&nbsp;&nbsp;&nbsp;共<?=$pageVO->total?>筆資料
						<a style="color: red;" target="_blank" href="<?=Yii::app()->request->baseUrl; ?>/customer/printHistory?<?=implode('&', $ids) ?>" >前往列印此頁(分頁不列印)</a>
					</div>
				</td>
			</tr>
			<tr>
				<td style="text-align: left; padding-left: 20px;">
					<div>
						查詢總金額：<?=number_format($total_money) ?>
					</div>
				</td>
			</tr>
		</table>
	</form>
	<table class="detail-list">
		<tr>
			<th>序號</th>
			<th><?=CHtml::encode($tp_lang['kind_serial']) ?></th>
			<th><?=CHtml::encode($tp_lang['kind_date']) ?></th>
			<th>客戶</th>
			<th>總價格</th>
			<th>時間</th>
			<th>功能</th>
		</tr>
		<?php foreach ($histories as $key=>$row){ ?>
		<tr <?php if($key%2 == 1){ ?>class="odd-row" <?php } ?>>
			<td>
				<?=$row['history_id'] ?>
			</td>
			<td>
				<?php if($row['remark'] != ''){ ?>
				<a href="#"  style="color: blue; " onclick="$(this).parent().find('div').toggle();" ><?=CHtml::encode($row['history_serial']) ?></a>
				<div style="text-align: left; display:none; position: absolute; width:400px; height: 200px; padding-top: 15px; overflow-y: scroll; background-color: #ccc;" >
					<?=CHtml::encode($row['remark']) ?>
				</div>
				<?php }else{ ?>
					<?=CHtml::encode($row['history_serial']) ?>
				<?php } ?>
			</td>
			<td>
				<?=CHtml::encode($row['process_date']) ?>
			</td>
			<td>
				<a href="#"  style="color: blue; " onclick="$(this).parent().find('div').toggle();" ><?=CHtml::encode($row['customer_name']) ?>(<?=CHtml::encode($row['customer_id']) ?>)</a><br/>
				<div style="text-align: left; display:none; position: absolute; width:400px; height: 200px; padding-top: 15px; overflow-y: scroll; background-color: #ccc;" >
					<?=CHtml::encode($row['customer_address']) ?><br/>
					電話1：<?=CHtml::encode($row['customer_tel1']) ?><br/>
					電話2：<?=CHtml::encode($row['customer_tel2']) ?><br/>
					手機：<?=CHtml::encode($row['customer_phone']) ?><br/>
					傳真：<?=CHtml::encode($row['customer_fax']) ?><br/>
					統編：<?=CHtml::encode($row['customer_serial_numbers']) ?>
				</div>
			</td>
			<td >
				<a target="_blank" href="<?=Yii::app()->request->baseUrl; ?>/customer/printHistory?ids[]=<?=$row['history_id']?>"  style="color: blue; " ><?=number_format($row['total_price']) ?></a>
			</td>
			<td style="text-align: left;" >
				建立時間：<br/>
				<?=CHtml::encode($row['createtime']) ?><br/>
				最後更新時間：<br/>
				<?=CHtml::encode($row['updatetime']) ?>
			</td>
			<td>
				<button type="button" class="btn btn-default" onclick="location.href='<?=Yii::app()->request->baseUrl; ?>/customer/<?=$tp_lang['edit_path'] ?>?id=<?=$row['history_id'] ?>';" >編輯</button><br/>
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