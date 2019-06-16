$(function(){
    $("#get_customers").click(function(e) {
        $.ajax({
            type: "GET",
            url: "api/get_customers.php",
            success: function(response) {
                if(response){
                    location.reload();
                }
            }
        });
    });

    $(".sms-btn").click(function() {
        var customer_id = $(this).siblings(".customer").text();
        var Data = {'id':customer_id};
        $.ajax({
            type: "POST",
            url: "api/send_sms.php",
            data: Data,

            success: function(response)
            {
                alert(response); 
                location.reload();
            }
        });
    });
});