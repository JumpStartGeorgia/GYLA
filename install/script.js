$(function(){

    var i = 0,
    t = setTimeout(update_content, 100);

    function update_content()
    {
	$.get('import.php?i=' + i, function(response){
	    $('#status').append(response);
	});
	i ++;
	if (i < total_files)
	{
	    t = setTimeout(update_content, 100);
	}
    }

});
