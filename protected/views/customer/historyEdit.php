<form id="customerAddForm" method="post" >
    <table>
        <tr>
            <th colspan="2" class="subTitle"><?=CHtml::encode($tp_lang['title']) ?></th>
        </tr>
        <tr  >
            <td><?=CHtml::encode($tp_lang['kind_serial']) ?></td>
            <td style="text-align: left;">
                <input type="text" name="history_serial" value="<?=CHtml::encode($history['history_serial']) ?>" maxlength="50"  placeholder="<?=CHtml::encode($tp_lang['kind_serial_def1']) ?>" /><?=CHtml::encode($tp_lang['kind_serial_def2']) ?>
            </td>
        </tr>
        <tr class="odd-row">
            <td ><?=CHtml::encode($tp_lang['kind_date']) ?></td>
            <td style="text-align: left;">
                <input type="text" name="process_date" value="<?=CHtml::encode($history['process_date']) ?>" readonly="readonly" maxlength="20" placeholder="必填" />*必填
            </td>
        </tr>
        <tr  >
            <td>客戶ID</td>
            <td  style="text-align: left;">
                <input type="text" name="customer_id" value="<?=CHtml::encode($history['customer_id']) ?>" readonly="readonly"  />
				<button type="button" id="searchCustomer" >查詢</button><br/>
				<div class="customer_detail"  ><?=CHtml::encode($history['customer_name']) ?></div>
            </td>
        </tr>
        <tr  >
            <td >統一編號</td>
            <td style="text-align: left;" >
                <input type="text" name="serial_numbers" value="<?=CHtml::encode($history['serial_numbers']) ?>" maxlength="20"  />
            </td>
        </tr>
        <tr class="odd-row">
            <td >備註</td>
            <td style="text-align: left;">
				<textarea name="remark" style="width: 300px; height: 100px;" ><?=CHtml::encode($history['remark']) ?></textarea>
            </td>
        </tr>
        <tr class="odd-row">
            <td >內容</td>
            <td style="text-align: left;" >
			<?php for($i=0; $i<30; $i++){ ?>
				<?php $detail_row = (!empty($history['details'][$i]))? $history['details'][$i]: []; ?>
				<div class="itemAddShowAll <?php if($i>9 && empty($detail_row)){ echo "hide itemAddShow".(floor($i/10)); } ?>" >
					<?=sprintf('%02d.', $i+1); ?>
					<input type="text" name="itemId[]" style="width: 50px;"  value="<?=CHtml::encode($detail_row['item_id']) ?>" readonly="readonly" placeholder="ID"/> 
					<input type="text" name="itemName[]" style="width: 150px;" value="<?=CHtml::encode($detail_row['item_name']) ?>"  readonly="readonly" placeholder="商品名稱"/>
					<input type="text" name="itemSerial[]" style="width: 200px;" value="<?=CHtml::encode($detail_row['item_serial']) ?>"  readonly="readonly" placeholder="商品型號" />
					<input type="text" name="itemPrice[]" style="width: 80px;" value="<?=CHtml::encode($detail_row['price']) ?>" placeholder="價格" />
					<input type="text" name="itemCount[]" style="width: 50px;" value="<?=CHtml::encode($detail_row['item_count']) ?>"  placeholder="數量" />
					<button type="button" class="btn btn-default searchItem" >查詢</button>
					<button type="button" class="btn btn-default clearItem"  >清除</button>
					<span></span>
				</div>
			<?php } ?>
				<a href="#" onclick="$('.itemAddShow'+itemAddShow).removeClass('hide');itemAddShow++;" >再新增</a>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
				<div id="totalPrice" ></div>
                <div class="btn-group btn-group-lg" role="group" >
                    <button class="btn btn-lg btn-primary btn-block calculate" type="button" >預覽價格計算</button>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <div class="btn-group btn-group-lg" role="group" >
                    <button class="btn btn-lg btn-primary btn-block loginSubmit" type="submit">提交</button>
                </div>
            </td>
        </tr>
    </table>
</form>
<form id="customerAddForm"  method="post" >
	<input type="hidden" name="is_del" value="deleted" />
	<button onClick="return (confirm('確認是否刪除資料'));" type="submit">刪除資料</button>
</form>
<div id="searchCustomerBlockHide" class="hide" >
	<div id="searchCustomerBlock" >
		查詢客戶
		<table class="detail-list searchOrderTable" >
			<tr>
				<td style="text-align: left; padding-left: 20px;">
					<div>
						<input type="text" id="searchOrderFormName" placeholder="姓名" />
						<input type="text" id="searchOrderFormPhone"  placeholder="連絡電話" />
						<button type="button" id="requestCustomer" class="btn btn-default"  >搜尋</button>
					</div>
				</td>
			</tr>
		</table>
		<div class="searchCustomerBlockShow" style="height: 368px;overflow-y: scroll;overflow-x: hidden;" >查無資料</div>
	</div>
</div>
<div id="searchItemBlockHide" class="hide" >
	<div id="searchItemBlock" >
		查詢商品
		<table class="detail-list searchOrderTable" >
			<tr>
				<td style="text-align: left; padding-left: 20px;">
					<div>
						<input type="text" id="searchItemFormName" placeholder="商品名" />
						<input type="text" id="searchItemFormSerial"  placeholder="商品型號" />
						<button type="button" id="requestItem" class="btn btn-default"  >搜尋</button>
					</div>
				</td>
			</tr>
		</table>
		<div class="searchItemBlockShow" style="height: 368px;overflow-y: scroll;overflow-x: hidden;" >查無資料</div>
	</div>
</div>