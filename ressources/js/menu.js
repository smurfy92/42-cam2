(function() {
  var home  = document.querySelector('#Home');
  var gallery  = document.querySelector('#Gallery');
  var disco  = document.querySelector('#Disconnect');

  url = window.location.href.split("/");
  home.addEventListener('click', function(ev){
    //console.log(url[2]+"/"+url[3]+"/Home");
     window.location.href = "/"+url[3]+"/Home";
  }, false);
  gallery.addEventListener('click', function(ev){
     window.location.href = "/"+url[3]+"/Gallery";
  }, false);
  disco.addEventListener('click', function(ev){
     window.location.href = "/"+url[3]+"/Disconnect";
  }, false);

})();
