// window.onload=function() {
//
//     function setActive() {
//       aObj = document.getElementsByTagName('nav navbar-nav side-nav').getElementsByTagName('a');
//       alert(aObj);
//       for(i=0;i<aObj.length;i++) {
//         if(document.location.href.indexOf(aObj[i].href)>=0) {
//           aObj[i].className='active';
//         }
//       }
//     }
// }

$(document).ready(function() {
	$('#nav navbar-nav side-nav a[href^="/' + location.pathname.split("/")[1] + '"]').addClass('active');
});
