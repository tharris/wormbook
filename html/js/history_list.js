/*
 * This is a function to expand and collapse the revision history panel in 
 * the left side bar of each chapter
*/

function kadabra(el) {
  var style = document.getElementById(el).style ;
  style.display = style.display == 'block' ? 'none' : 'block'; 
}


