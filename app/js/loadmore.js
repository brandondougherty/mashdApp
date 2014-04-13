$(document).ready(function(){
// get array of elements
  var myArray = $('.new1 > div');
  var count = 0;

  // sort based on timestamp attribute
  myArray.sort(function (a, b) {
      
      // convert to integers from strings
      a = parseInt($(a).attr('timestamp'));
      b = parseInt($(b).attr('timestamp'));
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
  $('.new1').append(myArray);

$(".new1").addClass("old").removeClass("new1");
$(".mainContainer").append("<div class='new1'></div>");
$(".mainContainer").append("<button class='loadmorefeed'>Load More</button>");
$(".loadmorefeed").show();
});