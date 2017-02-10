(function() {

  var palmier  = document.querySelector('#palmier');
  var pokeball  = document.querySelector('#pokeball');
  var glasses  = document.querySelector('#glasses');
  var palmierphoto  = document.querySelector('#filter-palmier');
  var pokeballphoto  = document.querySelector('#filter-pokeball');
  var glassesphoto  = document.querySelector('#filter-glasses');
  var startbutton  = document.querySelector('#startbutton');
  var file  = document.querySelector('#fileUpload');

  palmier.addEventListener('click', function(ev){
    if (palmier.className.indexOf('selected') > -1)
    {
      palmier.className = "filter";
      palmierphoto.className = "hide";
      startbutton.className = "hide";
      file.className = "hide";
    }
    else
    {
      startbutton.className = "";
      file.className = "";
      pokeball.className = "filter";
      glasses.className = "filter";
      palmierphoto.className = "";
      pokeballphoto.className = "hide";
      glassesphoto.className = "hide";
      palmier.className += palmier.className ? ' selected' : 'selected';
    }
    ev.preventDefault();
  }, false);


  pokeball.addEventListener('click', function(ev){
    if (pokeball.className.indexOf('selected') > -1)
    {
      pokeball.className = "filter";
      pokeballphoto.className = "hide";
      startbutton.className = "hide";
      file.className = "hide";
    }
    else
    {
      startbutton.className = "";
      file.className = "";
      palmier.className = "filter";
      glasses.className = "filter";
      palmierphoto.className = "hide";
      pokeballphoto.className = "";
      glassesphoto.className = "hide";
      pokeball.className += pokeball.className ? ' selected' : 'selected';
    }
    ev.preventDefault();
  }, false);

  glasses.addEventListener('click', function(ev){
    if (glasses.className.indexOf('selected') > -1)
    {
      glasses.className = "filter";
      glassesphoto.className = "hide";
      startbutton.className = "hide";
      file.className = "hide";
    }
    else
    {
      startbutton.className = "";
      file.className = "";
      palmier.className = "filter";
      pokeball.className = "filter";
      palmierphoto.className = "hide";
      pokeballphoto.className = "hide";
      glassesphoto.className = "";
      glasses.className += glasses.className ? ' selected' : 'selected';
    }
    ev.preventDefault();
  }, false);


})();