function addcomment(id, user_id)
{
  var value = document.querySelector("#comment_"+id).value;
  if (value)
  {
    var xhr = getXMLHttpRequest();
    var params = {};
    params["id"] = id
    params["value"] = value;
    params["user_id"] = user_id;

    xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
        if (xhr.responseText == "ok")
          location.reload();
        else
        {
          var error = document.querySelector('#error');
          error.innerHTML = xhr.responseText;
        }
    }}
    var objJSON = JSON.stringify(params);
    xhr.open("POST", 'Api/addcomment/', true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    xhr.send(objJSON);
  }

}

function delphoto(id, user_id)
{
    var xhr = getXMLHttpRequest();
    var params = {};
    params["id"] = id;
    params["user_id"] = user_id;

    xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
         if (xhr.responseText == "ok")
          location.reload();
        else
        {
          var error = document.querySelector('#error');
          error.innerHTML = xhr.responseText;
        }
    }}
    var objJSON = JSON.stringify(params);
    xhr.open("POST", 'Api/delphoto/', true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    xhr.send(objJSON);
}

function addlike(id, user_id)
{
    var xhr = getXMLHttpRequest();
    var params = {};
    params["id"] = id;
    params["user_id"] = user_id;

    xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
        location.reload();
    }}
    var objJSON = JSON.stringify(params);
    xhr.open("POST", 'Api/addlike/', true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    xhr.send(objJSON);
}

function dellike(id, user_id)
{
    var xhr = getXMLHttpRequest();
    var params = {};
    params["id"] = id;
    params["user_id"] = user_id;

    xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
        location.reload();
    }}
    var objJSON = JSON.stringify(params);
    xhr.open("POST", 'Api/dellike/', true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    xhr.send(objJSON);
}

(function() {

  var prev  = document.querySelector('#prev');
  var next  = document.querySelector('#next');

  prev.addEventListener('click', function(ev){
    url = window.location.href.split("/");
    if (url[5] && url[5] >=1)
      window.location.href ="/camagru/Gallery/"+(url[5] - 1);
    ev.preventDefault();
  }, false);

  next.addEventListener('click', function(ev){
    url = window.location.href.split("/");
    if (url[5] && url[5] > 0)
    {

      window.location.href = "/camagru/Gallery/"+(parseInt(url[5]) + 1);
    }
    else
      window.location.href = '/camagru/Gallery/1';
    console.log("next clicked");
    ev.preventDefault();
  }, false);

})();