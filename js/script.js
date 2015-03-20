var selector = '.nav li';
   
function myFunction() {
    $(selector).on('click', function(){
    $(selector).removeClass('active');
    $(this).addClass('active');
});
 
}
$(document).ready(function() {
$('#assessmentcontent').hide();
$('#ranktabscontent').hide();
$('#rankstabcontent').hide();
$('#criteriacontent').hide();
$('#spacecontent').hide();
$('#forumcontent').hide();
$('#studentcontent').hide();
$('#rankcontent').hide();
$('#assessment-form').hide();
$('.profiletab').click(function() {
    $('#profilecontent').show();
    $('#spacecontent').hide();
    $('#forumcontent').hide();
	$('#studentcontent').hide();
	$('#rankcontent').hide();
});
$('.studenttab').click(function(){
	$('#profilecontent').hide();
    $('#spacecontent').hide();
    $('#forumcontent').hide();
	$('#studentcontent').show();
	$('#rankcontent').hide();
    $('#assessmentcontent').hide();
    $('#rankstabcontent').hide();
    $('#criteriacontent').hide();
});
$('.spacetab').click(function() {
    $('#profilecontent').hide();
    $('#spacecontent').show();
    $('#forumcontent').hide();
	$('#studentcontent').hide();
	$('#rankcontent').hide();
});
$('.forumtab').click(function() {
    $('#profilecontent').hide();
    $('#spacecontent').hide();
    $('#forumcontent').show();
	$('#studentcontent').hide();
	$('#rankcontent').hide();
});
$('.ranktab').click(function() {
    $('#profilecontent').hide();
    $('#spacecontent').hide();
    $('#forumcontent').hide();
	$('#studentcontent').hide();
	$('#rankcontent').show();
});
$('.profiletab').click(function() {
    $('#profilecontent').show();
    $('#studentcontent').hide();
    $('#assessmentcontent').hide();
    $('#rankstabcontent').hide();
    $('#criteriacontent').hide();
});
$('.grouptab').click(function() {
    $('#profilecontent').hide();
    $('#studentcontent').hide();
    $('#assessmentcontent').show();
    $('#rankstabcontent').hide();
    $('#criteriacontent').hide();
});
$('.rankstab').click(function() {
    $('#profilecontent').hide();
    $('#studentcontent').hide();
    $('#assessmentcontent').hide();
    $('#rankstabcontent').show();
    $('#criteriacontent').hide();
});
$('.criteriatab').click(function() {
    $('#criteriacontent').show();
    $('#profilecontent').hide();
    $('#studentcontent').hide();
    $('#assessmentcontent').hide();
    $('#rankstabcontent').hide();
});
});

function myFunctiona(){
  $('.dropdown-toggle').dropdown()
}

$(function(){
      $('.navbar-header').load("header.html");
      $('#footer').load("footer.html");
    });

var selector = '.nav li';
    //$('#whitespace').on('click', function (e) {
function myFunction() {
    $(selector).on('click', function(){
    $(selector).removeClass('active');
    $(this).addClass('active');
});
    
}