var selector = '.nav li';
   
function myFunction() {
    $(selector).on('click', function(){
    $(selector).removeClass('active');
    $(this).addClass('active');
});
 
}
$(document).ready(function() {

$('#spacecontent').hide();
$('#forumcontent').hide();
$('#studentcontent').hide();
$('.profiletab').click(function() {
    $('#profilecontent').show();
    $('#spacecontent').hide();
    $('#forumcontent').hide();
	$('#studentcontent').hide();
});
$('.studenttab').click(function(){
	$('#profilecontent').hide();
    $('#spacecontent').hide();
    $('#forumcontent').hide();
	$('#studentcontent').show();
});
$('.spacetab').click(function() {
    $('#profilecontent').hide();
    $('#spacecontent').show();
    $('#forumcontent').hide();
	$('#studentcontent').hide();
});
$('.forumtab').click(function() {
    $('#profilecontent').hide();
    $('#spacecontent').hide();
    $('#forumcontent').show();
	$('#studentcontent').hide();
});
});

function myFunctiona(){
  $('.dropdown-toggle').dropdown()
}