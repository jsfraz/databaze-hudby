//https://www.w3schools.com/js/js_cookies.asp
const cookieExDays = 365;
const booleanExp = /^(true|false)$/;

function setCookie(cname, cvalue, exdays) {
  if (booleanExp.test(cvalue) == false) {
    cvalue = "false";
  }
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/;SameSite=None; Secure";
  //https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie/SameSite
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

//změna true/false cookie
function filterClick(cname) {
  value = getCookie(cname);
  if (booleanExp.test(value)) {
    if (value == "true") {
      setCookie(cname, "false", cookieExDays);
    } else {
      setCookie(cname, "true", cookieExDays);
    }
  } else {
    setCookie(cname, "false", cookieExDays);
  }
}