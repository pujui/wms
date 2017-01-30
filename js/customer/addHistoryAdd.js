var itemAddShow = 1;
var searchItemKey = 0;
$(document).ready(function(){
    
    
    function customerAddForm(){
		
		$('input[name=process_date]').datepicker({
			dateFormat: "yy-mm-dd"
		});
    }
    
    customerAddForm.prototype.init = function(){
        $('#customerAddForm .loginSubmit').click(this.checkVariable);
		// 客戶搜尋框click
        $('#searchCustomer').click($.proxy(this.add, this));
		// 客戶搜尋資料click
        $('#requestCustomer').click($.proxy(this.requestCustomer, this));
		// 商品搜尋框click
        $('.searchItem').click(this.addItem);
		// 商品清除
        $('.clearItem').click(this.clearItem);
		// 商品搜尋資料click
        $('#requestItem').click($.proxy(this.requestItem, this));
		// 商品選擇確認
		$('#searchItemBlock').on('click', '.selectItem', this.selectItem);
		// 計算價格
		$('.calculate').click(this.calculate);
    }

    customerAddForm.prototype.add = function(e){
        $.blockUI({ 
            message: $('#searchCustomerBlock'),
            onOverlayClick: $.unblockUI,
            css: {
                top: '10%',
                width: 750,
                left: ($( window ).width()/2)-(750/2)
            }
        });
    }

    customerAddForm.prototype.addItem = function(){
		searchItemKey = $(this).parent();
        $.blockUI({ 
            message: $('#searchItemBlock'),
            onOverlayClick: $.unblockUI,
            css: {
                top: '10%',
                width: 750,
                left: ($( window ).width()/2)-(750/2)
            }
        });
    }

    customerAddForm.prototype.clearItem = function(){
		searchItemKey = $(this).parent();
		searchItemKey.find('input[name="itemId[]"]').val('');
		searchItemKey.find('input[name="itemName[]"]').val('');
		searchItemKey.find('input[name="itemSerial[]"]').val('');
		searchItemKey.find('input[name="itemPrice[]"]').val('');
		searchItemKey.find('input[name="itemCount[]"]').val('');
    }
	
    customerAddForm.prototype.requestCustomer = function(){
		$.ajax({
			method: "GET",
			url: "requestCustomer",
			data: { name: $('#searchOrderFormName').val(), phone: $('#searchOrderFormPhone').val() }
		})
		.done(function( msg ) {
			$('.searchCustomerBlockShow').html(msg);
		});
	}
	
    customerAddForm.prototype.requestItem = function(){
		$.ajax({
			method: "GET",
			url: "requestItem",
			data: { item_name: $('#searchItemFormName').val(), item_serial: $('#searchItemFormSerial').val(), is_price : $('#is_price').val()  }
		})
		.done(function( msg ) {
			$('.searchItemBlockShow').html(msg);
		});
	}
	
	customerAddForm.prototype.selectItem = function(){
		searchItemKey.find('input[name="itemId[]"]').val($(this).data('sn'));
		searchItemKey.find('input[name="itemName[]"]').val($(this).data('name'));
		searchItemKey.find('input[name="itemSerial[]"]').val($(this).data('serial'));
		searchItemKey.find('input[name="itemPrice[]"]').val($(this).data('price'));
		searchItemKey.find('input[name="itemCount[]"]').val(1);
		$.unblockUI();
	}
	
	customerAddForm.prototype.calculate = function(){
		var totalPrice = 0;
		var sn, name, serial, price, count;
		$('.itemAddShowAll').each(function(){
			sn = $(this).find('input[name="itemId[]"]').val();
			name = $(this).find('input[name="itemName[]"]').val();
			serial = $(this).find('input[name="itemSerial[]"]').val();
			price = parseInt($(this).find('input[name="itemPrice[]"]').val());
			count = parseInt($(this).find('input[name="itemCount[]"]').val());
			if(sn != '' ){
				if(!$.isNumeric(price) 
					|| !$.isNumeric(count)){
					$(this).find('span').text('請輸入數字');
				}else if(price < 0 || count < 0){
					$(this).find('span').text('不可為負數');
				}else{
					$(this).find('span').text(price*count);
					totalPrice += price*count;
				}
			}else{
				$(this).find('span').text(0);
			}
		});
		$('#totalPrice').text('總價格為:'+totalPrice);
	}
    
    customerAddForm.prototype.checkVariable = function(){
        var msg = [];
		var sn, name, serial, price, count;
		$('.itemAddShowAll').each(function(){
			sn = $(this).find('input[name="itemId[]"]').val();
			name = $(this).find('input[name="itemName[]"]').val();
			serial = $(this).find('input[name="itemSerial[]"]').val();
			price = parseInt($(this).find('input[name="itemPrice[]"]').val());
			count = parseInt($(this).find('input[name="itemCount[]"]').val());
			if(sn != ''){
				if(!$.isNumeric(price) 
					|| !$.isNumeric(count)){
					msg.push('請輸入數字');
				}else if(price < 0 || count < 0){
					msg.push('不可為負數');
				}
			}
		});
        if($('input[name=process_date]').val().trim() == ''){
            msg.push('請填入日期');
        }
        if(msg.length == 0){
            return true;
        }else{
            alert(msg.join('\n\n'));
            return false;
        }
    }
    new customerAddForm().init();
});