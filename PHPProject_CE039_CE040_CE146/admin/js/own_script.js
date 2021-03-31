$(document).ready(function(){

    /* -------------------------------------------root elements*/
    $("#delete_category").on('click',function(){
        var category=$("#delete_category").val();
    /*------------------------------------------- validate for username*/
        $.ajax({
            type:'POST',
            url:'deleteCategory.php',
            data:{"delete_category":category},
            success:function(result){
                if(result.status=='fail'){
                    alert("Error Accoured");
                }
                else if(result.status=='success'){
                    alert("Category deleted Successfully");
                    location.reload()
                }
            } 
        });
    
    });

    $("#delete_album").on('click',function(){
        var album=$("#delete_album").val();
    /*------------------------------------------- validate for username*/
        $.ajax({
            type:'POST',
            url:'deleteAlbum.php',
            data:{"delete_album":album},
             success:function(result){
                if(result.status=='fail'){
                    alert("Error Accoured");
                }
                else if(result.status=='success'){
                    alert("Album deleted Successfully");
                    location.reload()
                }
            } 
        });
    
    });

    $("#search_bar").on('keyup',function(){
        var search_key = $("#search_bar").val();
        $.ajax({
            type:'POST',
            url:'searchResultAdmin.php',
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
    