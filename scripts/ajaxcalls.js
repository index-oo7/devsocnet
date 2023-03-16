$(document).ready(function(){

});
function Postcomm(postid,userid){
    
    
    let txt = $("#commtxt").val();
if(txt!=""){

    $.post("../../ajax/ajax.php",{commtxt:txt,iduser:userid,postid:postid},function(response){
        $("#commented").html(response);
    })

}
}



