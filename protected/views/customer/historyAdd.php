<form id="customerAddForm" method="post" >
    <table>
        <tr>
            <th colspan="2" class="subTitle"><?=CHtml::encode($tp_lang['title']) ?></th>
        </tr>
        <tr  >
            <td><?=CHtml::encode($tp_lang['kind_serial']) ?></td>
            <td style="text-align: left;">
                <input type="text" name="history_serial" maxlength="50"  placeholder="<?=CHtml::encode($tp_lang['kind_serial_def1']) ?>" /><?=CHtml::encode($tp_lang['kind_serial_def2']) ?>
            </td>
        </tr>
        <tr class="odd-row">
            <td ><?=CHtml::encode($tp_lang['kind_date']) ?></td>
            <td style="text-align: left;">
                <input type="text" name="process_date" readonly="readonly" maxlength="20" placeholder="必填" />*必填
            </td>
        </tr>
        <tr  >
            <td>客戶</td>
            <td  style="text-align: left;">
                <input type="hidden" name="customer_id" readonly="readonly"  />
				<button type="button" id="searchCustomer" >查詢</button><br/>
				<div class="customer_detail" ></div>
            </td>
        </tr>
        <tr  >
            <td >統一編號</td>
            <td style="text-align: left;" >
                <input type="text" name="serial_numbers"  maxlength="20"  />
            </td>
        </tr>
        <tr class="odd-row">
            <td >備註</td>
            <td style="text-align: left;">
				<textarea name="remark" style="width: 300px; height: 100px;" ></textarea>
            </td>
        </tr>
        <tr class="odd-row">
            <td >內容</td>
            <td style="text-align: left;" >
			<?php for($i=0; $i<30; $i++){ ?>
				<div data-sn="<?=$i ?>" class="itemAddShowAll <?php if($i>9){ echo "hide itemAddShow".(floor($i/10)); } ?>" >
					<?=sprintf('%02d.', $i+1); ?>
					<input type="hidden" name="itemId[]" style="width: 50px;"  readonly="readonly" placeholder="ID"/> 
					<input type="text" name="itemSerial[]" style="width: 120px;" readonly="readonly" placeholder="商品型號" />
					<input type="text" name="itemName[]" style="width: 120px;" readonly="readonly" placeholder="商品名稱"/>
					<input type="text" name="item_sn[]" style="width: 180px;" placeholder="商品序號" />
					<input type="text" name="itemPrice[]" style="width: 100px;"  placeholder="價格" />
					<input type="text" name="itemCount[]" style="width: 50px;"  placeholder="數量" />
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
<?php include dirname(__FILE__).'/block/requestSearchAdd.php'; ?>