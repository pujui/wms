<form id="customerAddForm" method="post" >
    <table>
        <tr>
            <th colspan="2" class="subTitle">編輯客戶資料</th>
        </tr>
        <tr  >
            <td>姓名</td>
            <td >
                <input type="text" name="name" value="<?=CHtml::encode($customer['customer_name']) ?>" maxlength="50"  />
            </td>
        </tr>
        <tr class="odd-row">
            <td >電話1</td>
            <td >
                <input type="text" name="tel1" value="<?=CHtml::encode($customer['customer_tel1']) ?>" maxlength="20" placeholder="必填"  />
            </td>
        </tr>
        <tr  >
            <td>電話2</td>
            <td >
                <input type="text" name="tel2" value="<?=CHtml::encode($customer['customer_tel1']) ?>" maxlength="20"/>
            </td>
        </tr>
        <tr class="odd-row" >
            <td>手機</td>
            <td >
                <input type="text" name="phone" value="<?=CHtml::encode($customer['customer_phone']) ?>" maxlength="20"/>
            </td>
        </tr>
        <tr  >
            <td>傳真</td>
            <td >
                <input type="text" name="fax" value="<?=CHtml::encode($customer['customer_fax']) ?>" maxlength="20"/>
            </td>
        </tr>
        <tr class="odd-row" >
            <td>地址</td>
            <td >
                <input type="text" name="address" value="<?=CHtml::encode($customer['customer_address']) ?>" maxlength="200"/>
            </td>
        </tr>
        <tr  >
            <td>統一編號</td>
            <td >
                <input type="text" name="serial_numbers" value="<?=CHtml::encode($customer['serial_numbers']) ?>" maxlength="20"/>
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