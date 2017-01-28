<div id="tabs">
    <ul>
        <li><a href="#tabs-1">客戶列表</a></li>
		<li style="width: 780px; text-align: right;">
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-default" onclick="location.href='<?=Yii::app()->request->baseUrl; ?>/customer/add';" >新增客戶資料</button>
			</div>
		</li>
    </ul>
    <div id="tabs-1">
        <?php include dirname(__FILE__).'/block/tabList.php'; ?>
    </div>
</div>