$(function(){
    $('#dropdown').hover(function(){
        $("#dropdown-list:not(:animated)").slideDown();
     }, function(){
        $("#dropdown-list").slideUp();
     });

     $('#logout').click(function(){
        window.sessionStorage.clear();
        location.reload();
     })
})