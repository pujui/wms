<div id="searchCustomerBlockHide" class="hide" >
	<div id="searchCustomerBlock" >
		查詢客戶
		<table class="detail-list searchOrderTable" >
			<tr>
				<td style="text-align: left; padding-left: 20px;">
					<div>
						<input type="text" id="searchOrderFormPhone"  placeholder="連絡電話" />
						<input type="text" id="searchOrderFormName" placeholder="姓名" />
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
		查詢客戶
		<table class="detail-list searchOrderTable" >
			<tr>
				<td style="text-align: left; padding-left: 20px;">
					<div>
						<input type="text" id="searchItemFormSerial"  placeholder="商品型號" />
						<input type="text" id="searchItemFormName" placeholder="商品名" />
						<input type="hidden" id="is_price" value="<?=($history_type!=0)?'1':'0' ?>"/>
						<button type="button" id="requestItem" class="btn btn-default"  >搜尋</button>
					</div>
				</td>
			</tr>
		</table>
		<div class="searchItemBlockShow" style="height: 368px;overflow-y: scroll;overflow-x: hidden;" >查無資料</div>
	</div>
</div>