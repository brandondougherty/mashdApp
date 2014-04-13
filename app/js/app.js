var app = angular.module("app", ['ui.router']).config(function( $stateProvider, $urlRouterProvider){
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
    }).state("vineLogin", {
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
	});
	//twitter comment on post
	$scope.sendMessage= function(){
		var message = $scope.twitterMessage;
		console.log(postId);
		console.log(message);
		$http.post('http://localhost/MashdApp/www/twitterlibs/comment.php', 
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
	 var postId = $rootScope.postId;
	 $scope.postId = postId;
	Comments.instagram(postId).success(function(response){
		$('.comment').append(response);
	});

	$scope.sendMessage= function(){
		var message = $scope.instagramMessage;
		var iGuser = 'TEST';
		console.log(message);
		$http.post('http://localhost/MashdApp/www/instagramlibs/comments.php', 
					{id: postId,
		         status: message}).success(function(response){
		         	console.log('comment sent');
		         	
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
	});

	$scope.sendMessage= function(){
		var message = $scope.facebookMessage;
		console.log(message);
		$http.post('http://localhost/MashdApp/www/facebooklibs/postComment.php', 
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
		$http.post('http://localhost/MashdApp/www/facebooklibs/removeComment.php', 
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
	});
	$scope.goToPhoto = function(){
		console.log('like photo');
	}
});

app.controller('VineController', function(Comments, $rootScope, $scope,$http,$compile) {
	 var postId = $rootScope.postId;
	Comments.vineComments(postId).success(function(response){
		$('.comment').append($compile(response)($scope));
	});

	$scope.sendMessage= function(){
		var message = $scope.vineMessage;
		console.log(message);
		$http.post('http://localhost/MashdApp/www/vinelibs/postComment.php', 
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
      $http.get('http://localhost/MashdApp/www/social_accounts_include.php').success(function(result){
			$('.brandon').html($compile(result)($scope));
			$rootScope.cache.put('feed', result);
	  	});
	  //console.log($rootScope.cache);
  	 }else{
  	 	console.log('already cached');
  	 	//console.log($rootScope.cache.get('feed'));
  	 	result = $rootScope.cache.get('feed');
  	 	$('.brandon').html($compile(result)($scope));
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
       if($rootScope.facebook ===undefined){
	var responsePromise = $http.get('http://localhost/MashdApp/www/social_accounts.php');
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
		});
	}
         console.log($rootScope.facebook);

});

app.controller('SocialController', function($scope, $http, $rootScope) {
	if($rootScope.facebook === undefined){

	var alert = new RegExp('Logout');
	var responsePromise = $http.get('http://localhost/MashdApp/www/social_accounts.php');
	responsePromise.success(function(data, status, headers, config) {
         $rootScope.facebook = data.facebook;
         $rootScope.facebookIO = data.facebookIO;
         $rootScope.twitter = data.twitter;
         $rootScope.twitterIO = data.twitterIO;
         $rootScope.instagram = data.instagram;
         $rootScope.instagramIO = data.instagramIO;
         $rootScope.vine = data.vine;
         $rootScope.vineIO = data.vineIO;

         $scope.facebookURL = $rootScope.facebook;
         $scope.facebookURLInOrOut =  'Facebook Log' + $rootScope.facebookIO;
          console.log(alert.test($scope.facebookURLInOrOut));
          if(alert.test($scope.facebookURLInOrOut)){
          	$scope.alertFB = 'alert';
          	$rootScope.alertFB = 'alert';
          }
         $scope.twitterURL = $rootScope.twitter;
         $scope.twitterURLInOrOut = 'Twitter Log' + $rootScope.twitterIO;
          console.log(alert.test($scope.twitterURLInOrOut));
          if(alert.test($scope.twitterURLInOrOut)){
          	$scope.alertTW = 'alert';
          	$rootScope.alertTW = 'alert';
          }
         $scope.instagramURL = $rootScope.instagram;
         $scope.instagramURLInOrOut = 'Instagram Log' + $rootScope.instagramIO;
          console.log(alert.test($scope.instagramURLInOrOut));
          if(alert.test($scope.instagramURLInOrOut)){
          	$scope.alertIG = 'alert';
          	$rootScope.alertIG = 'alert';
          }
         $scope.vineURL = $rootScope.vine;
         $scope.vineURLInOrOut = 'Vine Log' + $rootScope.vineIO;
          console.log(alert.test($scope.vineURLInOrOut));
          if(alert.test($scope.vineURLInOrOut)){
          	$scope.alertVI = 'alert';
          	$rootScope.alertVI = 'alert';
          }

         console.log($rootScope.facebook);
		});
	}
       $scope.facebookURL = $rootScope.facebook;
       $scope.twitterURL = $rootScope.twitter;
       $scope.instagramURL = $rootScope.instagram;
       $scope.vineURL = $rootScope.vine;
       $scope.alertFB = $rootScope.alertFB;
       $scope.alertTW = $rootScope.alertTW;
       $scope.alertIG = $rootScope.alertIG;
       $scope.alertVI = $rootScope.alertVI;
          
        if($rootScope.facebookIO === undefined){
        	$scope.facebookURLInOrOut = 'Facebook';
        }else{
          $scope.facebookURLInOrOut =  'Facebook Log' + $rootScope.facebookIO;          
     	}
     	if($rootScope.twitterIO === undefined){
        	$scope.twitterURLInOrOut = 'Twitter';
        }else{
          $scope.twitterURLInOrOut =  'Twitter Log' + $rootScope.twitterIO;
          
     	}
        if($rootScope.instagramIO === undefined){
        	$scope.instagramURLInOrOut = 'Instagram';
        }else{
          $scope.instagramURLInOrOut =  'Instagram Log' + $rootScope.instagramIO;
          
     	}
     	if($rootScope.vineIO === undefined){
        	$scope.vineURLInOrOut = 'Vine';
        }else{
          $scope.vineURLInOrOut =  'Vine Log' + $rootScope.vineIO;
          
     	}
         console.log($rootScope.facebook);
          console.log($scope.facebookURL);
          console.log($rootScope.facebookIO);

});

app.controller('RegisterController', function($scope, $http,$location, $rootScope, MashdLogin) {
	$scope.regCredentials = {email : "", password: ""};

	$scope.register = function(){
		MashdLogin.register($scope.regCredentials).success(function(response){
			if(response.user_registered === 'true'){
				//redirect to social page to start signing into accounts
				$location.path('/social');
			}else if(response.user_registered === 'false'){
				$scope.failPrompt = response.error;
			}
		});
	}
});

app.factory('MashdLogin', function($http, $location){
	return{
		login: function(credentials){
			return $http({
					    method: 'POST',
					    url: 'http://localhost/MashdApp/www/login.php',
					    data: credentials,
					    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					    });
		},
		logout: function(){
			return $http.get('http://localhost/MashdApp/www/logout.php');
		},
		register: function(credentials){
			return $http({
				method: 'POST',
			    url: 'http://localhost/MashdApp/www/register.php',
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
					    url: 'http://localhost/MashdApp/www/twitterlibs/twittercommentsajax.php',
					    data: {poster: posterScreenName,
			                  post: postId},
					    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					    });
		},
		instagram: function(postId){
			return $http({
					    method: 'POST',
					    url: 'http://localhost/MashdApp/www/instagramlibs/commentsajax.php',
					    data: {postId: postId},
					    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					    });
		},
		facebookComments: function(postId){
			return $http({
					    method: 'POST',
					    url: 'http://localhost/MashdApp/www/facebooklibs/getComments.php',
					    data: {postId: postId},
					    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					    });
		},
		facebookLikes: function(postId){
			return $http({
					    method: 'POST',
					    url: 'http://localhost/MashdApp/www/facebooklibs/getLikes.php',
					    data: {postId: postId},
					    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					    });
		},
		facebookAlbum: function(postId){
			return $http({
					    method: 'POST',
					    url: 'http://localhost/MashdApp/www/facebooklibs/facebookAlbum.php',
					    data: {post: postId},
					    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					    });
		},
		vineComments: function(postId){
			return $http({
					    method: 'POST',
					    url: 'http://localhost/MashdApp/www/vinelibs/getComments.php',
					    data: {post: postId},
					    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					    });
		}
	};
});

app.directive('design', function (){
	return{
		restrict: "C",
		controller: function($scope, $compile,$rootScope) {
			$(document).on('click', '.loadmorefeed', function() {
			$('.loadmorefeed').remove();
		    $.ajax({url:"http://localhost/MashdApp/www/multiCall_for_more_feed.php",
		    	success:function(result){
		      $('.new1').html($compile(result)($scope));
		       var old = $rootScope.cache.get('feed');
		       $rootScope.cache.put('feed', old + result);
		       console.log('new cache');
		      // console.log(old + 'old ^^^^ new below---------------------------' + result);
		      }});
		  });
		},
		link: function(scope,element,attributes){
			$(function(){
    			$(document).foundation();    
  			});
			
			
			
			//twitter favorite
			$(document).on('click', '.twitterFav', function(){
				var id= $(this).attr('data');
		    	console.log(id);		    
			$.ajax({url:"http://localhost/MashdApp/www/twitterlibs/favorite.php",
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
			$.ajax({url:"http://localhost/MashdApp/www/twitterlibs/favorite.php",
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
			$.ajax({url:"http://localhost/MashdApp/www/twitterlibs/retweet.php",
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
			$.ajax({url:"http://localhost/MashdApp/www/twitterlibs/unRetweet.php",
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
		    
			$.ajax({url:"http://localhost/MashdApp/www/facebooklibs/fbLike.php",
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
		    
			$.ajax({url:"http://localhost/MashdApp/www/facebooklibs/fbLike.php",
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
				var id= $(this).parent().attr('group');
		    	console.log(id);
		    
			$.ajax({url:"http://localhost/MashdApp/www/instagramlibs/instagramLike.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: id},
			      success:function(){
			        console.log('like sent!');
			        	//change class of this button to deletInstagramLike
			        }});
			    $(this).removeClass( "likeInstagram" ).addClass( "deletInstagramLike alert" );
		    });
		    //REMOVE
		    $(document).on('click', '.deletInstagramLike', function(){
				var id= $(this).parent().attr('group');
		    	console.log(id);
		    	$.ajax({url:"http://localhost/MashdApp/www/instagramlibs/delete_instagramLike.php",
			           type:'POST',              
			       dataType:'text',
			           data: {id: id},
			        success:function(){
			        	console.log('delete like sent!');
			        	//change class of this button to deletInstagramLike
			        }});
			    $(this).removeClass( "deletInstagramLike alert" ).addClass("likeInstagram");
		    });

		    //VINE LIKE/COMMENT/REVINE----------------------------
		    $(document).on('click', '.vineLike', function(){
				var id= $(this).parent().attr('data');
		    	console.log(id);
		    	$.ajax({url:"http://localhost/MashdApp/www/vinelibs/vineLike.php",
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
				var id= $(this).parent().attr('data');
		    	console.log(id);
		    	$.ajax({url:"http://localhost/MashdApp/www/vinelibs/delete_vineLike.php",
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
				var id= $this.parent().attr('data');
		    	console.log(id);
		    	$.ajax({url:"http://localhost/MashdApp/www/vinelibs/vineRevine.php",
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
			        	$this.removeClass( "vineRevine" ).addClass( "deletVineRevine alert" );
		      });

		     //UNDO-REVINE
		     $(document).on('click', '.deletVineRevine', function(){
				var id= $(this).parent().attr('data');
				var repostId = $(this).attr('data');
		    	console.log(id);
		    	$.ajax({url:"http://localhost/MashdApp/www/vinelibs/delete_vineRevine.php",
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
			    $(this).removeClass( "deletVineRevine alert" ).addClass("vineRevine");
			   
		    });

			$(document).on('click', '.instaComments', function() {
			    var currentDiv, pageValue, newPage, newPageid;
			    currentDiv = $(this).attr('group');
			    pageValue = parseFloat($(this).attr('data'));
			    newPage = pageValue + 5 ;
			    newPageid =  '.' + pageValue;
			    $.ajax({url:"http://localhost/MashdApp/www/instagramlibs/instagramcommentsajax.php",
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
			    $.ajax({url:"http://localhost/MashdApp/www/vinelibs/vinecommentsajax.php",
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
			    $.ajax({url:"http://localhost/MashdApp/www/twitterlibs/twittercommentsajax.php",
			           type:'POST',              
			       dataType:'text',
			           data: {poster: posterScreenName,
			                  post: postId},
			        success:function(result){
			          $('div[data-id="' + postId + '"] .twitterCommentContainer').html(result);
			          
			    }});
			});*/

			

			$(document).on('click', '.faceBookToggle', function() {
			    	$('.fbPost').parent().toggle();
			});
			$(document).on('click', '.twitterToggle', function() {
			    	$('.twitterPost').parent().toggle();
			});
			$(document).on('click', '.instaToggle', function() {
			    	$('.instagramPost').parent().toggle();
			});
			$(document).on('click', '.vineToggle', function() {
			    	$('.vinepost').parent().toggle();
			});

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
