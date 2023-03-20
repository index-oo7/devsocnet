$(document).ready(function(){
    
});
function Postcomm(postid,userid){
    let divname="commented"+postid;
    console.log(divname);
    let nametxt="commtxt"+postid;
    let txt = $('[id="' + nametxt + '"]').val();
    if(txt!=""){
        $.post("../../ajax/ajax.php",{commtxt:txt,iduser:userid,postid:postid},function(response){
            $('[id="' + divname + '"]').html(response);

        })
    }
}
