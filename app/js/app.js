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

app.controller('MyAccountController', function($http, $rootScope) {
	$http.get('http://localhost/MashdApp/www/social_accounts_include.php').success(function(result){
				$('.brandon').html(result);
	});
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


/*app.controller('MyAccountController', function($scope){
	$scope.$watch( AuthService.isLoggedIn, function (isLoggedIn) {
    	$scope.isLoggedIn = isLoggedIn;
	});
});*/

app.directive('design', function (){
	return{
		restrict: "C",
		link: function(scope,element,attributes){
			$(function(){
    			$(document).foundation();    
  			});

			$(document).on('click', '.loadmorefeed', function() {
		    $.ajax({url:"http://localhost/MashdApp/www/vinelibs/vineajax.php",success:function(result){
		      $("#myDiv").html(result);
		      
		    }});
		  });
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

			$(document).on('click', '.twitterComments', function() {
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
			});

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
