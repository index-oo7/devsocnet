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




function Search(){
    let input=$("#search").val();
    $("#search-form").submit(function(event){
        event.preventDefault();
        $.get("../../ajax/ajax.php?fun=search",{input:input},function(response){
            $("#searchresults").html(response);
        })
    })


}
function Like(postid,userid){
    $.get("../../ajax/ajax.php?fun=like",{postid:postid,userid:userid},function(response){
        $("#likecounter").html(response);
        console.log(response);
    });
}   
