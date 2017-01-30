
$(document).ready(function(){
    $( "#tabs" ).tabs();
    
    $('input[name=create_start], input[name=create_end], input[name=start], input[name=end]').datepicker({
        dateFormat: "yy-mm-dd"
    });
});