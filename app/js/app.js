var app = angular.module("app", ['ui.router','infinite-scroll']).config(function( $stateProvider, $urlRouterProvider){
  $stateProvider
    .state("myaccount", {
      url: "/myaccount",
      templateUrl: "myaccount.html",
      controller: "MyAccountController",
      authenticate: false
    })
    .state("login", {
      url: "/login",
      templateUrl: "login.html",
      controller: "LoginController",
      authenticate: false
    })
    .state("social", {
      url: "/social",
      templateUrl: "social.html",
      controller: "SocialController",
      authenticate: false
    }).state("info", {
      url: "/info",
      templateUrl: "info.html"
    })
    .state("vineLogin", {
      url: "/vineLogin",
      templateUrl: "vinelibs/vine_redirect.html"
    })
 	.state("register", {
      url: "/register",
      templateUrl: "register.html",
      controller: "RegisterController",
    })
    .state("twitter", {
      url: "/twitter",
      templateUrl: "twitter.html",
      controller: "TwitterController",
    })
    .state("instagram", {
      url: "/instagram",
      templateUrl: "instagram.html",
      controller: "InstagramController",
    })
    .state("facebookComments", {
      url: "/facebookComments",
      templateUrl: "facebookComments.html",
      controller: "FacebookCommentsController",
    })
    .state("facebookLikes", {
      url: "/facebookLikes",
      templateUrl: "facebookLikes.html",
      controller: "FacebookLikesController",
    })
    .state("facebookShare", {
      url: "/facebookShare",
      templateUrl: "facebookShare.html",
      controller: "FacebookShareController",
    })
    .state("facebookAlbum", {
      url: "/facebookAlbum",
      templateUrl: "facebookAlbum.html",
      controller: "FacebookAlbumController",
    })
    .state("vineComment", {
      url: "/vineComment",
      templateUrl: "vineComment.html",
      controller: "VineController",
    });
    $urlRouterProvider
        .otherwise('/login');
  
});

app.controller('LoginController', function($scope, $location, MashdLogin) {
	$scope.credentials = { username: "", password: ""};

	$scope.login = function(){
		MashdLogin.login($scope.credentials).success(function(response){
			if(response == '1'){
				$location.path('/myaccount');
			}else{
				$location.path('/login');
			}
		});
	}
});
app.controller('TwitterController', function(Comments, $rootScope, $scope,$http) {
	 var posterScreenName = $rootScope.posterScreenName;
	 var postId = $rootScope.postId;
	 var extra = $rootScope.extra;
	 $scope.postId = postId;
	  $scope.twitterMessage = "@" + posterScreenName + extra;
	Comments.twitter(posterScreenName,postId).success(function(response){
		$('.comment').append(response);
		$('.loadcomments').hide();
		$('.comment').show();
	});
	//twitter comment on post
	$scope.sendMessage= function(){
		var message = $scope.twitterMessage;
		console.log(postId);
		console.log(message);
		$http.post('http://mashdapp.mashd.it/twitterlibs/comment.php', 
					{id: postId,
		         status: message}).success(function(response){
		         	console.log('comment sent');
		         	//response = $.parseJSON(response);
			       	var profileImg = response.user.profile_image_url;
			      	var realName = response.user.name;
			      	var twitterName = response.user.screen_name;
			      	var message = response.text;
			      	var names = '';
		      		response.entities.user_mentions.forEach(function(obj) {
		      											 names = names + " @" + obj.screen_name; 
		      											});  //"@" + .screen_name
		      	//add comment in to list.
		      	$('.comment').append("<div class='listComment'><img src='" 
		      		+ profileImg + "' style='border-radius: 10%'/><span class='twitterusername'>" 
		      		+ realName + "</span><span class='twitterRealName'> @" 
		      		+ twitterName + "</span><br>" + message + "</div>");
		      //clear textarea
		      	$('.textarea').val(names);	
		       });
		  }
});

app.controller('InstagramController', function(Comments, $rootScope, $scope,$http) {
	console.log('hi');
	 var postId = $rootScope.postId;
	 $rootScope.scrollId = postId;
	Comments.instagram(postId).success(function(response){
		$('.comment').append(response);
		$('.loadcomments').hide();
		$('.comment').show();
	});

	$scope.sendMessage= function(){
		var message = $scope.instagramMessage;
		
		console.log(message);
		$http.post('http://mashdapp.mashd.it/instagramlibs/comments.php', 
					{id: postId,
		         status: message}).success(function(response){
		         	console.log('comment sent');
		         	var iGuser = response.username;
		      	$('.comment').append("<div class='listComment'><span class='userName'>" + iGuser +
		      	"</span>" + message + "</div>");
		      //clear textarea
		      	$('.textarea').val('');	
		       });
	}
});

app.controller('FacebookCommentsController', function(Comments, $rootScope, $scope,$http,$compile) {
	 var postId = $rootScope.postId;
	 $scope.postId = postId;
	Comments.facebookComments(postId).success(function(response){
		$('.comment').append($compile(response)($scope));
		$('.loadcomments').hide();
		$('.comment').show();
	});

	$scope.sendMessage= function(){
		var message = $scope.facebookMessage;
		console.log(message);
		$http.post('http://mashdapp.mashd.it/facebooklibs/postComment.php', 
					{id: postId,
		         status: message}).success(function(response){
		         	console.log('comment sent');
		         	var responseId = response.id;
		         	var name  = response.name;
		         	var nameId = response.userId;
		      	$('.comment').append($compile("<div class=\"listComment\"><a class=\"user\" ng-click=\"goToUser('" + nameId + "')\">" + name + "</a> " + message + "<br/><a class=\"fbremove\" ng-click=\"removeComment('" + responseId + "')\">remove</a></div>")($scope));
		      //clear textarea
		      	$('.textarea').val('');	
		       });
	}

	$scope.goToUser = function(postId){
		console.log(postId);
	}
	$scope.removeComment = function(postId){
		console.log(postId)
		$http.post('http://mashdapp.mashd.it/facebooklibs/removeComment.php', 
					{id: postId}
					).success(function(response){
						console.log(response);
						$("a[ng-click=\"removeComment('" + postId + "')\"]").parent().remove();
		         });
	}
});

app.controller('FacebookLikesController', function(Comments, $rootScope, $scope,$http,$compile) {
	 var postId = $rootScope.postId;
	 //$scope.postId = postId;
	Comments.facebookLikes(postId).success(function(response){
		$('.comment').append($compile(response)($scope));
		$('.loadcomments').hide();
		$('.comment').show();
	});

	$scope.goToUser = function(postId){
		console.log(postId);
	}
});

app.controller('FacebookShareController', function(Comments, $rootScope, $scope,$http,$compile) {
	
});
app.controller('FacebookAlbumController', function(Comments, $rootScope, $scope,$http,$compile) {
	 var postId = $rootScope.postId;
	Comments.facebookAlbum(postId).success(function(response){
		$('.comment').append($compile(response)($scope));
		$('.loadcomments').hide();
		$('.comment').show();
	});
	$scope.goToPhoto = function(){
		console.log('like photo');
	}
});

app.controller('VineController', function(Comments, $rootScope, $scope,$http,$compile) {
	 var postId = $rootScope.postId;
	Comments.vineComments(postId).success(function(response){
		$('.comment').append($compile(response)($scope));
		$('.loadcomments').hide();
		$('.comment').show();
	});

	$scope.sendMessage= function(){
		var message = $scope.vineMessage;
		console.log(message);
		$http.post('http://mashdapp.mashd.it/vinelibs/postComment.php', 
					{id: postId,
		         status: message}).success(function(response){
		         	console.log('comment sent');
		         	console.log(response);
		         var nameId = response.id;
		         var name = response.name;
		         var avatar = response.avatar;
		      	$('.comment').append($compile("<div class=\"listComment\"><img src=\"http://" + avatar + "\"height = 15px width = 15px/><a class=\"user\" ng-click=\"goToUser('" + nameId + "')\">" + name + "</a> " + message + "</div>")($scope));
		      //clear textarea
		      	$('.textarea').val('');	
		       });
	}

});


app.controller('MyAccountController', function($http, $rootScope, $scope,$window,$location,$compile,$cacheFactory) {
	
	$scope.reload =function(){
        $window.location.reload(); 
    }
    //Caching feed so it doesnt have to laod every time.BALLLLIN
     if($rootScope.cache == undefined){
      console.log('caching');
      $rootScope.cache = $cacheFactory('feedCacheID');
      $http.get('http://mashdapp.mashd.it/social_accounts_include.php').success(function(result){
			$('.brandon').html($compile(result)($scope));
			$rootScope.cache.put('feed', result);
			$scope.morefeed = new MoreFeed();
	  	});

	  //console.log($rootScope.cache);
  	 }else{
  	 	console.log('already cached');
  	 	//console.log($rootScope.cache.get('feed'));
  	 	result = $rootScope.cache.get('feed');

  	 	
  	 	$('.brandon').html($compile(result)($scope))
			var MoreFeed = function() {
	    this.busy = false;
	   };

	MoreFeed.prototype.nextPage = function() {
	    if (this.busy) return;
	    this.busy = true;
	console.log('inside');
	    var url = "http://mashdapp.mashd.it/multiCall_for_more_feed.php";
	    $http.get(url).success(function(result) {
	      	$('.brandon').append($compile(result)($scope));
		       var old = $rootScope.cache.get('feed');
		       $rootScope.cache.put('feed', old + result);
		       console.log('new cache');
	      	   this.busy = false;
	    }.bind(this));
	  };
	  $scope.morefeed = new MoreFeed();
  	 		console.log('done');
  	 }
	$scope.getTwComments = function(posterScreenName, postId, extraId){
		console.log(posterScreenName);
		console.log(postId);
		$rootScope.posterScreenName = posterScreenName;
		$rootScope.postId = postId;
		$rootScope.extra = '';
		if(extraId){
			$rootScope.extra = ' @' + extraId;	
		}
		$location.path('/twitter');
	}
	$scope.getIgComments = function(postId){
		$rootScope.postId = postId;
		$location.path('/instagram');
	}
	$scope.getFbComments = function(postId){
		$rootScope.postId = postId;
		$location.path('/facebookComments');
	}
	$scope.goToFBAlbum = function(postId){
		$rootScope.postId = postId;
		$location.path('/facebookAlbum');
	}

	$scope.getFbLikes = function(postId){
		$rootScope.postId = postId;
		$location.path('/facebookLikes');
	}

	$scope.fbShare = function(){
		$location.path('/facebookShare');
	}

	$scope.getViComments = function(postId){
		$rootScope.postId = postId;
		$location.path('/vineComment');
	}
	//if the user just logged in, or refreshed the page
	//find out there log in statuses
       if($rootScope.facebook === undefined){
	var responsePromise = $http.get('http://mashdapp.mashd.it/social_accounts.php');
	responsePromise.success(function(data, status, headers, config) {
         $rootScope.facebook = data.facebook;
         $rootScope.facebookIO = data.facebookIO;
         $rootScope.twitter = data.twitter;
         $rootScope.twitterIO = data.twitterIO;
         $rootScope.instagram = data.instagram;
         $rootScope.instagramIO = data.instagramIO;
         $rootScope.vine = data.vine;
         $rootScope.vineIO = data.vineIO;

         console.log($rootScope.facebook);
         console.log($rootScope.facebookIO);
         
         //if logged in,else leave it cause they are not signed in
         if($rootScope.facebookIO==0){
        	$('.faceBookNav').css( "fill", "#3b5998" );//hidden use rgba(59, 89, 152, 0.46);
         }
         if($rootScope.twitterIO==0){
        	$('.twitterNav').css( "fill", "#55acee" );//hidden use rgba(85, 172, 238, 0.46);
         }
         if($rootScope.instagramIO==0){
        	$('.instaNav').css( "fill", "black" );//hidden use rgba(0, 0, 0, 0.46);
         }
         if($rootScope.vineIO==0){
        	$('.vineNav').css( "fill", "#00d9a3" );//hidden use rgba(0, 217, 163, 0.46)
         }
		});
		//set nav buttons 
	}else{//if rootscope.social is defined dont worry about it we know the state..
		//set nav buttons
		console.log($rootScope.facebook);
        console.log($rootScope.facebookIO);
         //if logged in,else leave it cause they are not signed in
         if($rootScope.facebookIO==0){
        	$('.faceBookNav').css( "fill", "#3b5998" );
         }else if($rootScope.facebookIO==2){
         	$('.fbPost').parent().hide();
        	$('.faceBookNav').css( "fill", "rgba(59, 89, 152, 0.46)" );
         }
         if($rootScope.twitterIO==0){
        	$('.twitterNav').css( "fill", "#55acee" );
         }else if($rootScope.twitterIO==2){
         	$('.twitterPost').parent().hide();
         	$('.twitterNav').css( "fill", "rgba(85, 172, 238, 0.46)" );
         }
         if($rootScope.instagramIO==0){
        	$('.instaNav').css( "fill", "black" );
         }else if($rootScope.instagramIO==2){
         	$('.instagramPost').parent().hide();
        	$('.instaNav').css( "fill", "rgba(0, 0, 0, 0.46)" );
         }
         if($rootScope.vineIO==0){
        	$('.vineNav').css( "fill", "#00d9a3" );
         }else if($rootScope.vineIO==2){
         	$('.vinepost').parent().hide();
	    	$('.vineNav').css( "fill", "rgba(0, 217, 163, 0.46)" );
         }
	}
	//0 = logged in
	//1 = logged out 
	//2 = toggled off
    $scope.vineNav = function(){
    	//hide things
    	if($rootScope.vineIO == 0){
			$('.vinepost').parent().hide();
	    	//change nav appearance
	    	$rootScope.vineIO = 2;
	    	$('.vineNav').css( "fill", "rgba(0, 217, 163, 0.46)" );
    	}else if($rootScope.vineIO == 2){
    		$rootScope.vineIO = 0;
    		$('.vinepost').parent().show();
    		$('.vineNav').css( "fill", "#00d9a3" );
    	}
    }

    $scope.facebookNav = function(){
		//hide things
    	if($rootScope.facebookIO == 0){
			$('.fbPost').parent().hide();
	    	//change nav appearance
	    	$rootScope.facebookIO = 2;
	    	$('.faceBookNav').css( "fill", "rgba(59, 89, 152, 0.46)" );
    	}else if($rootScope.facebookIO == 2){
    		$rootScope.facebookIO = 0;
    		$('.fbPost').parent().show();
    		$('.faceBookNav').css( "fill", "#3b5998" );
    	}
    }

    $scope.twitterNav = function(){
		//hide things
    	if($rootScope.twitterIO == 0){
			$('.twitterPost').parent().hide();
	    	//change nav appearance
	    	$rootScope.twitterIO = 2;
	    	$('.twitterNav').css( "fill", "rgba(85, 172, 238, 0.46)" );
    	}else if($rootScope.twitterIO == 2){
    		$rootScope.twitterIO = 0;
    		$('.twitterPost').parent().show();
    		$('.twitterNav').css( "fill", "#55acee" );
    	}
    }

    $scope.instaNav = function(){
		//hide things
    	if($rootScope.instagramIO == 0){
			$('.instagramPost').parent().hide();
	    	//change nav appearance
	    	$rootScope.instagramIO = 2;
	    	$('.instaNav').css( "fill", "rgba(0, 0, 0, 0.46)" );
    	}else if($rootScope.instagramIO == 2){
    		$rootScope.instagramIO = 0;
    		$('.instagramPost').parent().show();
    		$('.instaNav').css( "fill", "black" );
    	}
    }
    	
    var MoreFeed = function() {
	    this.busy = false;
	   };

	MoreFeed.prototype.nextPage = function() {
	    if (this.busy) return;
	    this.busy = true;
	console.log('inside');
	    var url = "http://mashdapp.mashd.it/multiCall_for_more_feed.php";
	    $http.get(url).success(function(result) {
	      	$('.brandon').append($compile(result)($scope));
	      	if($rootScope.vineIO == 2){
	      		$('.vinepost').parent().hide();
	      	}
	      	if($rootScope.twitterIO == 2){
	      		$('.twitterPost').parent().hide();
	      	}	
	      	if($rootScope.instagramIO == 2){
	      		$('.instagramPost').parent().hide();
	      	}	
	      	if($rootScope.facebookIO == 2){
	      		$('.fbPost').parent().hide();
	      	}		    	
		       var old = $rootScope.cache.get('feed');
		       $rootScope.cache.put('feed', old + result);
		       console.log('new cache');
	      	   this.busy = false;
	    }.bind(this));
	  };
	  
		
	});

app.controller('SocialController', function($scope, $http, $rootScope,$window,$location,$timeout,MashdLogin) {
	console.log($rootScope.facebook);
	if($rootScope.facebook === undefined){
		var responsePromise = $http.get('http://mashdapp.mashd.it/social_accounts.php');
	responsePromise.success(function(data, status, headers, config) {
		var logout = new RegExp('logout');
         $rootScope.facebook = data.facebook;
         $rootScope.facebookIO = data.facebookIO;
         $rootScope.twitter = data.twitter;
         $rootScope.twitterIO = data.twitterIO;
         $rootScope.instagram = data.instagram;
         $rootScope.instagramIO = data.instagramIO;
         $rootScope.vine = data.vine;
         $rootScope.vineIO = data.vineIO;

         $scope.facebookURL = $rootScope.facebook;
         
         $scope.twitterURL = $rootScope.twitter;
        
         $scope.instagramURL = $rootScope.instagram;
         
         $scope.vineURL = $rootScope.vine;
         
       var fbIO = $rootScope.facebookIO;
       var twIO = $rootScope.twitterIO;
       var igIO = $rootScope.instagramIO;
       var viIO = $rootScope.vineIO;

      if(logout.test($rootScope.facebook)){
      	$('.fbCheckedout').attr('checked','checked');
      }else{
      	$('.fbCheckedin').attr('checked','checked');
      }
      if(logout.test($rootScope.vine)){
      	$('#y1').attr('checked','checked');
      }else{
      	$('#y').attr('checked','checked');
      }
      if(logout.test($rootScope.instagram)){
      	$('.checkedoutig').attr('checked','checked');
      }else{
      	$('.checkedinig').attr('checked','checked');
      }
      if(logout.test($rootScope.twitter)){
      	$('.checkedouttw').attr('checked','checked');
      }else{
      	$('.checkedintw').attr('checked','checked');
      }
	       console.log($scope.facebookURL);
          console.log(fbIO);
          console.log(twIO);
          console.log(igIO);
          console.log(viIO);
		});
	}else{
		var logout = new RegExp('logout');
       $scope.facebookURL = $rootScope.facebook;
       $scope.twitterURL = $rootScope.twitter;
       $scope.instagramURL = $rootScope.instagram;
       $scope.vineURL = $rootScope.vine;
       var fbIO = $rootScope.facebookIO;
       var twIO = $rootScope.twitterIO;
       var igIO = $rootScope.instagramIO;
       var viIO = $rootScope.vineIO;
	  if(logout.test($rootScope.facebook)){
      	$('.fbCheckedout').attr('checked','checked');
      }else{
      	$('.fbCheckedin').attr('checked','checked');
      }
      if(logout.test($rootScope.vine)){
      	$('#y1').attr('checked','checked');
      }else{
      	$('#y').attr('checked','checked');
      }
      if(logout.test($rootScope.instagram)){
      	$('.checkedoutig').attr('checked','checked');
      }else{
      	$('.checkedinig').attr('checked','checked');
      }
      if(logout.test($rootScope.twitter)){
      	$('.checkedouttw').attr('checked','checked');
      }else{
      	$('.checkedintw').attr('checked','checked');
      }
	       console.log($scope.facebookURL);
          console.log(twIO);
          console.log(igIO);
          console.log('else');
      }
          $scope.aLogin = function(url){
          	console.log('login');
          	console.log(url);
          	$window.location.href = url;
          }
          $scope.aLogout = function(url){
          	console.log('logout');
          	console.log(url);
          	$http.get(url);
          }
           $scope.newCredentials={email: "", password: "", retype: ""};
          $scope.changeSettings=function(){
          	 console.log($scope.newCredentials.password);
          	 console.log($scope.newCredentials.email);
          	 console.log($scope.newCredentials.retype);
          	 if($scope.newCredentials.password != $scope.newCredentials.retype){
				$scope.failPrompt = "Passwords do not match."
			 }else if(!$scope.newCredentials.password && !$scope.newCredentials.email){
			 	console.log('nothing has been entered');
			 }else{
			 	MashdLogin.changeSettings($scope.newCredentials).success(function(response){
			 		console.log(response);
			 		$('.changesSaved').attr('disabled','true');
			 		$('.changesSaved').addClass('success');
			 		$('.changesSaved').removeAttr('ng-click');
			 		$('.changesSaved').text('Changes Saved!')
			 	});
			 }
          }
          $scope.save=function(){
          	$('.saveCheck').show();
          		$timeout(($window.location.reload()),1000);
          }
    
});

app.controller('RegisterController', function($scope, $http,$location, $rootScope, MashdLogin) {
	$scope.regCredentials = {email : "", password: "", retype: ""};
	var email = new RegExp('@');
	$scope.register = function(){
		if($scope.regCredentials.password != $scope.regCredentials.retype){
			$scope.failPrompt = "Passwords do not match.";
		}else if(email.test($scope.regCredentials.email)){
			MashdLogin.register($scope.regCredentials).success(function(response){
				if(response.user_registered === 'true'){
					//redirect to social page to start signing into accounts
					$location.path('/social');
				}else if(response.user_registered === 'false'){
					$scope.failPrompt = response.error;
				}
			});
		}else{
			$scope.failPrompt = "Please enter a valid email.";
		}
	}
});

app.factory('MashdLogin', function($http, $location){
	return{
		login: function(credentials){
			return $http({
					    method: 'POST',
					    url: 'http://mashdapp.mashd.it/login.php',
					    data: credentials,
					    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					    });
		},
		logout: function(){
			return $http.get('http://mashdapp.mashd.it/logout.php');
		},
		register: function(credentials){
			return $http({
				method: 'POST',
			    url: 'http://mashdapp.mashd.it/register.php',
			    data: credentials,
			    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
		},
		changeSettings: function(credentials){
			return $http({
				method: 'POST',
			    url: 'http://mashdapp.mashd.it/changeSettings.php',
			    data: credentials,
			    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
		}
	};
});

app.factory('Comments', function($http, $location){
	return{
		twitter: function(posterScreenName, postId){
			return $http({
					    method: 'POST',
					    url: 'http://mashdapp.mashd.it/twitterlibs/twittercommentsajax.php',
					    data: {poster: posterScreenName,
			                  post: postId},
					    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					    });
		},
		instagram: function(postId){
			return $http({
					    method: 'POST',
					    url: 'http://mashdapp.mashd.it/instagramlibs/commentsajax.php',
					    data: {postId: postId},
					    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					    });
		},
		facebookComments: function(postId){
			return $http({
					    method: 'POST',
					    url: 'http://mashdapp.mashd.it/facebooklibs/getComments.php',
					    data: {postId: postId},
					    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					    });
		},
		facebookLikes: function(postId){
			return $http({
					    method: 'POST',
					    url: 'http://mashdapp.mashd.it/facebooklibs/getLikes.php',
					    data: {postId: postId},
					    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					    });
		},
		facebookAlbum: function(postId){
			return $http({
					    method: 'POST',
					    url: 'http://mashdapp.mashd.it/facebooklibs/facebookAlbum.php',
					    data: {post: postId},
					    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					    });
		},
		vineComments: function(postId){
			return $http({
					    method: 'POST',
					    url: 'http://mashdapp.mashd.it/vinelibs/getComments.php',
					    data: {post: postId},
					    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					    });
		}
	};
});

app.directive('design', function (){
	return{
		restrict: "C",
		
		link: function(scope,element,attributes){
			$(function(){
    			$(document).foundation();    
  			});
			
			
			
			//twitter favorite
			$(document).on('click', '.twitterFav', function(){
				var id= $(this).attr('data');
		    	console.log(id);		    
			$.ajax({url:"http://mashdapp.mashd.it/twitterlibs/favorite.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: id,
			           		  method: 'create'},
			      success:function(){
			        console.log('favorite sent!');
			        }});
			    $(this).removeClass( "twitterFav" ).addClass( "deleteTwitterFav alert" );
		    });
		    //twitter delete favorite
			$(document).on('click', '.deleteTwitterFav', function(){
				var id= $(this).attr('data');
		    	console.log(id);		    
			$.ajax({url:"http://mashdapp.mashd.it/twitterlibs/favorite.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: id,
			           		  method: 'destroy'},
			      success:function(){
			        console.log('remove favorite sent!');
			        }});
			    $(this).removeClass( "deleteTwitterFav alert" ).addClass( "twitterFav" );
		    });
		    //retweet
		    $(document).on('click', '.twitterRetweet', function(){
		    	var $this = $(this);
				var id= $this.attr('data');
		    	console.log(id);		    
			$.ajax({url:"http://mashdapp.mashd.it/twitterlibs/retweet.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: id,
			           		  method: 'retweet'},
			      success:function(data){
			        console.log('retweet sent!');
			        var response = $.parseJSON(data);
			        	var repostId = response.id_str;
			        	console.log(response.id_str);
			        	$this.attr('data', repostId);
			        }});
			    $this.removeClass( "twitterRetweet" ).addClass( "deleteTwitterRetweet alert" );
		    });
		     //un-retweet
		    /*$(document).on('click', '.deleteTwitterRetweet', function(){
		    	var $this = $(this);
				var id= $this.attr('data');
		    	console.log(id);		    
			$.ajax({url:"http://mashdapp.mashd.it/twitterlibs/unRetweet.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: id},
			      success:function(data){
			        console.log('unretweet sent!');
			        var response = $.parseJSON(data);
			        	var repostId = response.id_str;
			        	console.log(repostId);
			        	$this.attr('data', repostId);
			       }});
			    $this.removeClass( "deleteTwitterRetweet alert" ).addClass( "twitterRetweet" );
		    });*/
			//fb like
			$(document).on('click', '.fbLike', function(){
				var id= $(this).attr('data');
		    	console.log(id);
		    
			$.ajax({url:"http://mashdapp.mashd.it/facebooklibs/fbLike.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: id, 
			           	  method:'POST'},
			      success:function(){
			        console.log('like sent!');
			        	//change class of this button to deletInstagramLike
			        }});
				$(this).text('Unlike');
				var count = $(this).next().text();
				count = parseInt(count);
				count=count+1;
				$(this).next().text(count);
			    $(this).removeClass( "fbLike" ).addClass( "deleteFbLike alert" );
		    });
		    $(document).on('click', '.deleteFbLike', function(){
				var id= $(this).attr('data');
		    	console.log(id);
		    
			$.ajax({url:"http://mashdapp.mashd.it/facebooklibs/fbLike.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: id,
			           	  method:'DELETE'},
			      success:function(){
			        console.log('like sent!');
			        	//change class of this button to deletInstagramLike
			        }});
				$(this).text('Like');
				var count = $(this).next().text();
				count = parseInt(count);
				count=count-1;
				$(this).next().text(count);
			    $(this).removeClass( "deleteFbLike alert" ).addClass( "fbLike");
		    });
			//INSTAGRAM LIKE/remove likeInstagram--------------------------------------------------------+
		$(document).on('click', '.likeInstagram', function(){
				var id= $(this).parent().parent().attr('group');
		    	console.log(id);
		    
			$.ajax({url:"http://mashdapp.mashd.it/instagramlibs/instagramLike.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: id},
			      success:function(){
			        console.log('like sent!');
			        	//change class of this button to deletInstagramLike
			        }});
				$(this).text('Unlike');
			    $(this).removeClass( "likeInstagram" ).addClass( "deletInstagramLike" );
		    });
		    //REMOVE
		    $(document).on('click', '.deletInstagramLike', function(){
				var id= $(this).parent().parent().attr('group');
		    	console.log(id);
		    	$.ajax({url:"http://mashdapp.mashd.it/instagramlibs/delete_instagramLike.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: id},
			        success:function(){
			        	console.log('delete like sent!');
			        	//change class of this button to deletInstagramLike
			        }});
				$(this).text('Like');

			    $(this).removeClass( "deletInstagramLike" ).addClass("likeInstagram");
		    });

		    //VINE LIKE/COMMENT/REVINE----------------------------
		    $(document).on('click', '.vineLike', function(){
				var id= $(this).parent().parent().attr('data');
		    	console.log(id);
		    	$.ajax({url:"http://mashdapp.mashd.it/vinelibs/vineLike.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: id},
			        success:function(){
			        	console.log('like sent!');
			        	//change class of this button to deletInstagramLike
			        }});
			    $(this).removeClass( "likeVine" ).addClass( "deletVineLike alert" );
		    });
		    //REMOVE
		    $(document).on('click', '.deletVineLike', function(){
				var id= $(this).parent().parent().attr('data');
		    	console.log(id);
		    	$.ajax({url:"http://mashdapp.mashd.it/vinelibs/delete_vineLike.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: id},
			        success:function(){
			        	console.log('delete like sent!');
			        	//change class of this button to deletInstagramLike
			        }});
			    $(this).removeClass( "deletVineLike alert" ).addClass("likeVine");
		    });
		    //REVINE
		     $(document).on('click', '.vineRevine', function(){
		     	 var $this = $(this);
				var id= $this.parent().parent().attr('data');
		    	console.log(id);
		    	$.ajax({url:"http://mashdapp.mashd.it/vinelibs/vineRevine.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: id},
			        success:function(data){
			        	console.log('Revine sent!');
			        	//change class of this button to deletInstagramLike
			        	var response = $.parseJSON(data);
			        	var repostId = response.repostIdStr;
			        	console.log(repostId);
			        	$this.attr('data', repostId);
			        }});
			        	$this.removeClass( "vineRevine" ).addClass( "deletVineRevine" );
		      });

		     //UNDO-REVINE
		     $(document).on('click', '.deletVineRevine', function(){
				var id= $(this).parent().parent().attr('data');
				var repostId = $(this).attr('data');
		    	console.log(id);
		    	$.ajax({url:"http://mashdapp.mashd.it/vinelibs/delete_vineRevine.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: id,
			           		  repostId: repostId
			           		 },
			        success:function(){
			        	console.log('Revine sent!');
			        	//change class of this button to deletInstagramLike
			        }});
		    	 $(this).removeAttr('data');
			    $(this).removeClass( "deletVineRevine" ).addClass("vineRevine");
			   
		    });

			$(document).on('click', '.instaComments', function() {
			    var currentDiv, pageValue, newPage, newPageid;
			    currentDiv = $(this).attr('group');
			    pageValue = parseFloat($(this).attr('data'));
			    newPage = pageValue + 5 ;
			    newPageid =  '.' + pageValue;
			    $.ajax({url:"http://mashdapp.mashd.it/instagramlibs/instagramcommentsajax.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: currentDiv,
			                  page: pageValue},
			        success:function(result){
			          $('div[group="' + currentDiv + '"] .commentsContainer > div:first-child').append("<div class='" + pageValue + "'>&nbsp</div>");
			       $('div[group="' + currentDiv + '"] ' + newPageid).html(result);
			       $('button[group="' + currentDiv + '"]').attr('data', newPage);
			       $('button[group="' + currentDiv + '"]').off();
			    }});
			});

			$(document).on('click', '.ajaxcommentbutton1', function() {
			    var currentDiv, pageValue, newPage, newPageid;
			    currentDiv = $(this).attr('group');
			    pageValue = parseFloat($(this).attr('data'));
			    newPage = pageValue + 1;
			    newPageid =  '.' + newPage;
			    $.ajax({url:"http://mashdapp.mashd.it/vinelibs/vinecommentsajax.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: currentDiv,
			                  page: newPage},
			        success:function(result){
			          $('div[data="' + currentDiv + '"] .commentsContainer > div:first-child').before("<div class='" + newPage + "'>&nbsp</div>");
			       $('div[data="' + currentDiv + '"] ' + newPageid).html(result);
			       $('button[group="' + currentDiv + '"]').attr('data', newPage);
			       $('button[group="' + currentDiv + '"]').off();
			    }});
			});

			/*$(document).on('click', '.twitterComments', function() {
			    var currentDiv, pageValue, newPage, newPageid;
			    posterScreenName = $(this).attr('data');
			    postId = $(this).attr('data-id');
			    $.ajax({url:"http://mashdapp.mashd.it/twitterlibs/twittercommentsajax.php",
			           type:'POST',              
			       dataType:'text',
			           data: {poster: posterScreenName,
			                  post: postId},
			        success:function(result){
			          $('div[data-id="' + postId + '"] .twitterCommentContainer').html(result);
			          
			    }});
			});*/
			
		}
	};
});

app.directive('myaccount', function(){
	return{
		restrict: "C",
		link: function(scope,element,attributes){

			    var footer = $(".secondNav");
			    var pos = footer.position();
			    var height = $(window).height();
			    height = height - pos.top;
			    height = height - footer.height();
	        	footer.css({
	            	'margin': height + 'px auto'
	        	});
    		
		}
	};
});
