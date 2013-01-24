$(function()
{
    $('#divadd').click(function(){
  	$('#saved_parameters').load(
		baseurl + "people/ajax_set_sessions/",
		{
			prehtml: $('#saved_parameters').html(),
			people_parameter: $('#parameter').val(),
			people_method: $('#method').val(),
			people_value: $('#pvalue').val()
		},
		function(){}
	);

	return false;
    });


    $('#save_search_field').keyup(function(){
    	var href = baseurl + "people/save_search/" + $('#save_search_field').val();
	$('#save_search_link').attr("href", href);
    });


    $('.remove_term').click(function(){
	alert('x');
    });

});

function remove_term(e)
{
	e.load(
		baseurl + "people/ajax_unset_session/",
		{
			parameters: e.parent().find('input').val()
		},
		function(){}
	);

	e.parent().remove();
}
