
  var btnPost = document.getElementById("btnPost");
  var btnEdit = document.getElementById("btnEdit");
  var adding = document.getElementById("adding");
  var editing = document.getElementById("editing");
  var background = document.getElementById("background");
  
  btnEdit.onclick = function(){
    editing.style.display = "block";
    background.style.display = "block";
  }

  btnPost.onclick = function() {
    adding.style.display = "block";
    background.style.display = "block";
  }
  
  background.onclick = function() {
    editing.style.display = "none";
    adding.style.display = "none";
    background.style.display = "none";
  }