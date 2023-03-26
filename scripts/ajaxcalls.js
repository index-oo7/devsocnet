$(document).ready(function(){
    
});
function Postcomm(postid,userid){
    let divname="commented"+postid;
    console.log(divname);
    let nametxt="commtxt"+postid;
    let txt = $('[id="' + nametxt + '"]').val();
    if(txt!=""){
        $.post("../../ajax/ajax.php?fun=comment",{commtxt:txt,iduser:userid,postid:postid},function(response){
            $('[id="' + divname + '"]').html(response);

        })
    }
}

function ChangeInfo(userid){
    let name=$("#name").val();
    let surname=$("#surname").val();
    let nickname=$("#nickname").val();
    let info=$("#info").val();
    $.post("../../ajax/ajax.php?fun=change",{iduser:userid,name:name,surname:surname,nickname:nickname,info:info},function(response){
        $("#response").html(response);
    })
}