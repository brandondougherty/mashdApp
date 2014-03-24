$(document).load(function(){
			$('#pic1').hide();
			$('.brandon').show();
			// get array of elements
			var myArray = $(".brandon > div");
			var count = 0;

			// sort based on timestamp attribute
			myArray.sort(function (a, b) {
			    
			    // convert to integers from strings
			    a = parseInt($(a).attr("timestamp"));
			    b = parseInt($(b).attr("timestamp"));
			    count += 2;
			    // compare
			    if(a < b) {
			        return 1;
			    } else if(a > b) {
			        return -1;
			    } else {
			        return 0;
			    }
			});
			// put sorted results back on page
			$(".mainContainer").append(myArray);
			});

			    var footer = $(".secondNav");
			    var pos = footer.position();
			    var height = $(window).height();
			    height = height - pos.top;
			    height = height - footer.height();
	        	footer.css({
	            	'margin': height + 'px auto'
	        	});