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
  $('.brandon').append(myArray);
});