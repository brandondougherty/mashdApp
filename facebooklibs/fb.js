
window.fbAsyncInit = function() {
  FB.init({
    appId      : '464235817026185',
    channelUrl : 'http://mashdapp.mashd.it/channel.php',
    status     : true,
    cookie     : true,
    xfbml      : true
  });
};

(function(d){
   var js, id = 'facebook-jssdk';
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   d.getElementsByTagName('head')[0].appendChild(js);
 }(document));
  