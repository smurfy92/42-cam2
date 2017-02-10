(function() {

  var reset  = document.querySelector('#reset');

    reset.addEventListener('click', function(ev){
    email  = document.querySelector('#reset-email').value;
    var xhr = getXMLHttpRequest();
    xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
      if (xhr.responseText == "ok")
        console.log(xhr.responseText);
      else
      {
        var error = document.getElementById('error');
        error.innerHTML = xhr.responseText;
      }
    }}
    xhr.open("POST", 'Api/Reset/'+email, true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    xhr.send();
    ev.preventDefault();
  }, false);
})();
