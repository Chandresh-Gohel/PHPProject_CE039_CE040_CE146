$(document).ready(function(){
    // $("#search_modal").modal("show");
    $("#search_bar").on('keyup',function(){
        var search_key = $("#search_bar").val();
        $.ajax({
            type:'POST',
            url:'searchResult.php',
            data:{"search_key":search_key},
            success:function(result){
                //alert("result");
                $("#search_modal").modal("show");
                $("#search_result").html(result);
                $("#search_bar").val("");
            }
        })
    });

});
