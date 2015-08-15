$(function(){
    $("#btnSearch").click(function(){
        var url = "/words/";
        if($("#q").val() != ""){
            url += "search/" + encodeURI($("#q").val()) + "/";
        }
        location.href = url;
    });

    $("#q").keyup(function(event){
        if(event.keyCode == 13){
            $("#btnSearch").trigger("click");
        }
    });
});
