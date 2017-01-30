$(document).ready(function(){
    
    
    function customerAddForm(){
		$("#city2 option").css('display', 'none');
		$("#city2 option[city=金門縣]").css('display', 'block');
		$("#city1").change(this.selectAddress);
    }
    
    customerAddForm.prototype.init = function(){
        $('#customerAddForm .loginSubmit').click(this.checkVariable);
        
    }
	
    customerAddForm.prototype.selectAddress = function(){
        var address = $("#city1").val();
		$("#city2 option").css('display', 'none');
		$("#city2 option[city="+address+"]").css('display', 'block');
		$("#city2").val($("#city2 option[city="+address+"]").eq(0).val())
    }
    
    customerAddForm.prototype.checkVariable = function(){
        var msg = [];
        if($('input[name=tel1]').val().trim() == ''){
            msg.push('請填入電話');
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