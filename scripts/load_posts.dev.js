// Load more wall posts
$(function()
{

    var more = $('#wall-more').bind('click', function()
    {
        var loader = $('#wall-loader').show();
        more.remove();
        $('#all_posts div.wall-post:hidden').delay(1000).slideDown('slow', function()
        {
            loader.remove();
            var sixth = $('#postbox5');
	    if (sixth.length)
	    {
		$(scrollableElement('html', 'body')).animate({
		    scrollTop: sixth.offset().top - 15
		}, 'slow');
	    }
            $('#pager').show();
        });
    });

});


// Scroll element selector
function scrollableElement(els)
  {
    for (var i = 0, argLength = arguments.length; i <argLength; i++) {
      var el = arguments[i],
          $scrollElement = $(el);
      if ($scrollElement.scrollTop()> 0) {
        return el;
      } else {
        $scrollElement.scrollTop(1);
        var isScrollable = $scrollElement.scrollTop()> 0;
        $scrollElement.scrollTop(0);
        if (isScrollable) {
          return el;
        }
      }
    }
    return [];
  }


/*
function showmore(e)
{

    var loader = document.getElementById("loader");
    loader.style.display = "block";

    setTimeout(function(){
        for(i = 5; i < 10; i ++)
        {
            var post = document.getElementById("postbox" + i);
            if(post != null)
	    	post.style.display = "block";
	}
	loader.parentElement.removeChild(loader);
	document.getElementById("pager").style.display = "block";
    }, 600);

    e.parentElement.removeChild(e);
}
*/

