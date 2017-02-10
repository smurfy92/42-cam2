

(function() {

  var streaming = false,
      video        = document.querySelector('#video'),
      cover        = document.querySelector('#cover'),
      photo        = document.querySelector('#photo'),
      startbutton  = document.querySelector('#startbutton'),
      width = 320,
      height = 0;

 navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
window.URL = window.URL || window.webkitURL || window.mozURL || window.msURL;

  navigator.getUserMedia(
    {
      video: true,
      audio: false
    },
    function(stream) {
      if (navigator.mozGetUserMedia) {
        video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL ;
        video.src = vendorURL ? vendorURL.createObjectURL(stream) : stream;
      }
      video.onloadedmetadata = function(e) {
      video.play();
    };
    },
    function(err) {
    }
  );

  video.addEventListener('canplay', function(ev){
    if (!streaming) {
      height = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      streaming = true;
    }
  }, false);

  function takepicture() {
    var palmier  = document.querySelector('#palmier');
    var pokeball  = document.querySelector('#pokeball');
    var glasses  = document.querySelector('#glasses');
    var photos  = document.querySelector('.photos');
    var div = document.createElement('div');
    var save = document.createElement('button');
    var canvas = document.createElement('canvas');
    save.innerHTML = "save";
    save.className = "save";
    canvas.className = "shot";
    photos.insertBefore(div, photos.firstChild);
    div.appendChild(canvas);
    div.appendChild(save);

    if (palmier.className.indexOf('selected') > -1)
      var selected = "palmier";
    else if (pokeball.className.indexOf('selected') > -1)
      var selected = "pokeball";
    else if (glasses.className.indexOf('selected') > -1)
      var selected = "glasses";
    canvas.width = width;
    canvas.height = height;
    var xhr = getXMLHttpRequest();
    xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
      //console.log(xhr.responseText);
      var image = new Image();
      image.onload = function() {
          canvas.getContext('2d').drawImage(image, 0, 0, width, height);

      };
      save.addEventListener('click', function(ev){
      saveimage(xhr.responseText);
        ev.preventDefault();
      }, false);
      image.src = xhr.responseText;
      //canvas.getContext('2d').drawImage(xhr.responseText, 0, 0, width, height);

    }}
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    var objJSON = JSON.stringify({ Base64: canvas.toDataURL().split(",")[1], selection: selected });
    xhr.open("POST", 'Api', true)
    xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    xhr.send(objJSON)

    // var data = canvas.toDataURL('image/png');
    // data = "toto";
    // console.log(data);
  }

  startbutton.addEventListener('click', function(ev){
      takepicture();
    ev.preventDefault();
  }, false);

function saveimage(str)
{
  var xhr = getXMLHttpRequest();
  xhr.onreadystatechange = function() {
  if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
    console.log("ok");
  }}
  var objJSON = JSON.stringify({ img: str.split(",")[1] });
  xhr.open("POST", 'Api', true)
  xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
  xhr.send(objJSON);
}

function readImage() {
  var photos  = document.querySelector('.photos');
  var palmier  = document.querySelector('#palmier');
  var pokeball  = document.querySelector('#pokeball');
  var glasses  = document.querySelector('#glasses');
  var div = document.createElement('div');
  var save = document.createElement('button');
  var canvas = document.createElement('canvas');
  save.innerHTML = "save";
  save.className = "save";
  canvas.className = "shot";
  photos.insertBefore(div, photos.firstChild);
  div.appendChild(canvas);
  div.appendChild(save);
  if (palmier.className.indexOf('selected') > -1)
    var selected = "palmier";
  else if (pokeball.className.indexOf('selected') > -1)
    var selected = "pokeball";
  else if (glasses.className.indexOf('selected') > -1)
    var selected = "glasses";
    if ( this.files && this.files[0] ) {
        var FR= new FileReader();
        FR.onload = function(e) {
           var xhr = getXMLHttpRequest();
          xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            //console.log(xhr.responseText);
            var image = new Image();

            image.onload = function() {
                canvas.getContext('2d').drawImage(image, 0, 0, width, height);
                photos.insertBefore(div, photos.firstChild);
            };
            save.addEventListener('click', function(ev){
            saveimage(xhr.responseText);
              ev.preventDefault();
            }, false);
            image.src = xhr.responseText;
            //document.getElementById('save').style.visibility = "visible";
            //canvas.getContext('2d').drawImage(xhr.responseText, 0, 0, width, height);
          }}
          var objJSON = JSON.stringify({ Base64: e.target.result.split(",")[1], selection: selected });
          xhr.open("POST", 'Api', true)
          xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
          xhr.send(objJSON)
        };
        FR.readAsDataURL( this.files[0] );
    }
}

document.getElementById("fileUpload").addEventListener("change", readImage, false);

})();