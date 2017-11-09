function facebookReady() {
  FB.init({
    appId: '1859992774262472',
    xfbml: true,
    status: true,
    cookie: true,
    version: 'v2.9'
  });
}

$(function(){
	if (window.FB) { facebookReady(); } else { window.fbAsyncInit = facebookReady; }
	$(".logFacebook").on("click", function() {
		FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				FB.api('/me', {"fields":"email,name"}, function(response) {
					if (response&&!response.error) {
						$.ajax({
							url: 'fbConnect.php',
							method: 'POST',
							data: 'fbusertoken='+FB.getAuthResponse()['accessToken']+'&fbuserid='+response.id+'&fbusername='+response.name+'&fbuseremail='+response.email,
							async: false,
							error: function(){ 
								console.log('Erro no login, tente novamente'); 
							},
							success: function(data){ 
								console.log(data);
								window.location.replace(data);
							}
						});
					}
				});
			} else { 
				FB.login(function(response){ $(".logFacebook").click(); }, { scope: 'email,user_photos' }); 
			}
		});
	});
});