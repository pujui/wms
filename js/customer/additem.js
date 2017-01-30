$(document).ready(function(){
    
    
    function customerAddForm(){
    }
    
    customerAddForm.prototype.init = function(){
        
        $('#customerAddForm .loginSubmit').click(this.checkVariable);
        
    }
    
    customerAddForm.prototype.checkVariable = function(){
        var msg = [];
        if($('input[name=item_serial]').val().trim() == ''){
            msg.push('請填入商品型號');
        }
		var price = $('input[name=primary_price]').val().trim();
		if(price != '' && !$.isNumeric(price)){
            msg.push('商品成本錯誤');
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