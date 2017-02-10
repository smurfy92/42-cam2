(function() {

  var reset  = document.querySelector('#Reset-Confirm');

  reset.addEventListener('click', function(ev){
    url = window.location.href.split("/");

    email  = document.querySelector('#reset-confirm-email').value;
    var xhr = getXMLHttpRequest();
    xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
      if (xhr.responseText == "ok")
        window.location.href = '/'+url[3]+'/Home';
      else
      {
        var error = document.getElementById('error');
        error.innerHTML = xhr.responseText;
      }
    }}
    xhr.open("POST", '/'+url[3]+'/Api/Reset-Confirm/'+url[5]+'/'+email, true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    xhr.send();
    ev.preventDefault();
  }, false);


})();