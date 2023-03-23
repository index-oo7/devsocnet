document.getElementById('close').onclick=function(){
    const overlay = document.getElementById('myOverlay');
    overlay.style.display="none";
  }
  document.getElementById('btnEdit').onclick=function(){
    const overlay = document.getElementById('myOverlay').classList.add('show');
  }