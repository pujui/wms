$(document).ready(function(){
    
    
    function customerAddForm(){
    }
    
    customerAddForm.prototype.init = function(){
        
        $('#customerAddForm .loginSubmit').click(this.checkVariable);
        
    }
    
    customerAddForm.prototype.checkVariable = function(){
        var msg = [];
        if($('input[name=name]').val().trim() == ''){
            msg.push('請填入姓名');
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