function update_favicon() {
  var ts = Math.round((new Date()).getTime());
  var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
  link.type = 'image/x-icon';
  link.rel = 'shortcut icon';
  link.href = '/wp-content/themes/understrap-child/favicon.php?t=' + ts;
  //alert('dd');
  document.getElementsByTagName('head')[0].appendChild(link);
}

setInterval(update_favicon, 3000);

