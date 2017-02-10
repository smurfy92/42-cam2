function loginpost(params)
{
  var xhr = getXMLHttpRequest();
    xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
      if (xhr.responseText == "ok")
        window.location.href = 'Home';
      else
      {
        var error = document.getElementById('error');
        error.innerHTML = xhr.responseText;
      }
    }}
    var objJSON = JSON.stringify(params);
    xhr.open("POST", 'Api', true)
    xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    xhr.send(objJSON)
}

(function() {

  var login  = document.querySelector('#login');
  var register  = document.querySelector('#register');
  var reset  = document.querySelector('#reset');

  login.addEventListener('click', function(ev){

    var params = {};
    params["Login"] = {};
    params["Login"]["email"]  = document.querySelector('#login-email').value;
    params["Login"]["password"]  = document.querySelector('#login-password').value;
    loginpost(params);
    ev.preventDefault();
  }, false);

  register.addEventListener('click', function(ev){
    var params = {};
    params["Register"] = {};
    params["Register"]["login"]  = document.querySelector('#register-login').value;
    params["Register"]["email"]  = document.querySelector('#register-email').value;
    params["Register"]["password"]  = document.querySelector('#register-password').value;
    if (params["Register"]["password"].length < 5)
    {
      var error = document.getElementById('error');
      error.innerHTML = "Password to small";
    }
    else
      loginpost(params);
    ev.preventDefault();
  }, false);

  reset.addEventListener('click', function(ev){
    window.location.href = "Reset";
    ev.preventDefault();
  }, false);

})();