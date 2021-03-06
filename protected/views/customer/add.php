<form id="customerAddForm" method="post" >
    <table>
        <tr>
            <th colspan="2" class="subTitle">新增客戶資料</th>
        </tr>
        <tr  >
            <td>姓名</td>
            <td >
                <input type="text" name="name" maxlength="50"   />
            </td>
        </tr>
        <tr class="odd-row">
            <td >電話1</td>
            <td >
                <input type="text" name="tel1" maxlength="20" placeholder="必填" />
            </td>
        </tr>
        <tr  >
            <td>電話2</td>
            <td >
                <input type="text" name="tel2" maxlength="20"/>
            </td>
        </tr>
        <tr class="odd-row" >
            <td>手機</td>
            <td >
                <input type="text" name="phone" maxlength="20"/>
            </td>
        </tr>
        <tr  >
            <td>傳真</td>
            <td >
                <input type="text" name="fax" maxlength="20"/>
            </td>
        </tr>
        <tr class="odd-row" >
            <td>地址</td>
            <td >
				<select id="city1" name="city1" >
				<?php foreach($address as $address_row){ ?>
					<option><?=$address_row[0] ?></option>
				<?php }?>
				</select>
				<select id="city2" name="city2" >
					<?php foreach($address as $address_row){ ?>
						<?php 
						$city = 0;
						foreach($address_row as $key=>$row2){
							if($key == 0){ $city = $row2; continue; }
						?>
					<option city="<?=$city ?>" style="display:none;" ><?=$row2 ?></option>
						<?php 
						}
						?>
					<?php }?>
				</select>
                <input type="text" name="address" maxlength="200"/>
            </td>
        </tr>
        <tr  >
            <td>統一編號</td>
            <td >
                <input type="text" name="serial_numbers" maxlength="20"/>
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