document.getElementById('close').onclick=function(){
  const overlay = document.getElementById('myOverlay');
  overlay.style.display="none";
  }
document.getElementById('btnEdit').onclick=function(){
  const overlay = document.getElementById('myOverlay').classList.add('show');
  }

  var btnPost = document.getElementById("btnPost");
  var adding = document.getElementById("adding");
  var background = document.getElementById("background");
  
  btnPost.onclick = function() {
    adding.style.display = "block";
    background.style.display = "block";
  }
  
  background.onclick = function() {
    adding.style.display = "none";
    background.style.display = "none";
  }