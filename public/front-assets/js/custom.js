var showChar = 400;  
var dots = "....";
var moretext = "Read more +";
var lesstext = "Read less";


$('.more').each(function() {
    var content = $(this).html();

    if(content.length > showChar) {

        var shownText = content.substr(0, showChar);
        var hidden = content.substr(showChar, content.length - showChar);

        var html = shownText + '<span class="moreellipses">' + dots+
         '&nbsp;</span> <span class="morecontent"><span>' 
         + hidden + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

        $(this).html(html);
    }

});

$(".morelink").click(function(){
    if($(this).hasClass("less")) {
        $(this).removeClass("less");
        $(this).html(moretext);
    } else {
        $(this).addClass("less");
        $(this).html(lesstext);
    }
    $(this).parent().prev().toggle(); // to remove dotswhen read more is clicked
    $(this).prev().toggle(); //to display hidden text
    return false;
});