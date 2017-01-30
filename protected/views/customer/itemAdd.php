<form id="customerAddForm" method="post" >
    <table>
        <tr>
            <th colspan="2" class="subTitle">新增商品資料</th>
        </tr>
        <tr  >
            <td>商品型號</td>
            <td >
                <input type="text" name="item_serial" maxlength="50"  placeholder="必填" />
            </td>
        </tr>
        <tr class="odd-row">
            <td >商品名稱</td>
            <td >
                <input type="text" name="item_name" maxlength="20"/>
            </td>
        </tr>
        <tr  >
            <td>商品類型</td>
            <td >
                <select name="item_type">
					<?php foreach($item_types as $type_key=>$type_name){ ?>
					<option value="<?=$type_key?>"><?=$type_name?></option>
					<?php } ?>
				</select>
            </td>
        </tr>
        <tr class="odd-row">
            <td >商品成本</td>
            <td >
                <input type="text" name="primary_price" maxlength="20"/>
            </td>
        </tr>
        <tr >
            <td >商品販售</td>
            <td >
                <input type="text" name="sell_price"   maxlength="20"/>
            </td>
        </tr>
        <tr class="odd-row">
            <td colspan="2" style="text-align: center;">
                <div class="btn-group btn-group-lg" role="group" >
                    <button class="btn btn-lg btn-primary btn-block loginSubmit" type="submit">提交</button>
                </div>
            </td>
        </tr>
    </table>
</form>