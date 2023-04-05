$(document).ready(function(){});

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
function allcomments(postid){
    $.post("../../ajax/ajax.php?fun=commentsbypost",{postid:postid},function(response){
        $("#commsecc").html(response);
    })

    
}
function ChangeInfo(userid){
    let name=$("#name").val();
    let surname=$("#surname").val();
    let nickname=$("#nickname").val();
    let info=$("#info").val();
    $.post("../../ajax/ajax.php?fun=change",{userid:userid,name:name,surname:surname,nickname:nickname,info:info},function(response){
        $("#response").html(response);
        //ovde negde treba da stoji timeout da bi se warning zadrzao na ekranu
    });
}

function Follow(following_user_id,email, nickname){
    $.post("../../ajax/ajax.php?fun=follow",{following_user_id:following_user_id,email:email,nickname:nickname},function(response){
        $("#btnFollow").html(response);
    });
}

function Unfollow(following_user_id,email,nickname){
    $.post("../../ajax/ajax.php?fun=unfollow",{following_user_id:following_user_id,email:email,nickname:nickname},function(response){
        $("#btnUnfollow").html(response);
    });
}



