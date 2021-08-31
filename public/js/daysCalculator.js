$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });        
    $("#datepicker").on("changeDate", function(e) {
        var date = $("#datepicker").val();
        
        $.ajax({
            url: ajaxUrl,
            method: 'POST',
            data: {file: date},
            success: function(data){
                    
                $(".result").html('Remaining days until birthday: ' + data.result);
             
            } 
        })
    });


})
