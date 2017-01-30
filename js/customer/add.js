$(document).ready(function(){
    
    
    function customerAddForm(){
    }
    
    customerAddForm.prototype.init = function(){
        
        $('#customerAddForm .loginSubmit').click(this.checkVariable);
        
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