var baseurl;

function setbaseurl(url)
{
    baseurl = url;
}

// Feedback Form
$(function(){

    $('a#feedback').hover(function(){
        $(this).stop().animate({
            opacity: 0.65
        }, 'fast');
    }, function(){
        $(this).stop().animate({
            opacity: 1
        }, 'fast');
    }).fancybox({
        'width': '65%',
        'height': '65%',
        'autoScale': false,
        'titleShow': false,
        'type': 'iframe'
    });

});


var Filters = 
	{
		ImagesPath: 'images/images/filters/',
		ImagesExt: 'png',
		Images: {
			Text: new Image,
			Photo: new Image,
			Video: new Image,
			Document: new Image
		},
		ImagesCache: new Object,
		PreloadImages: function ()
		{
			Filters.Images.Text.src = Filters.ImagesPath + 'text-hover.' + Filters.ImagesExt,
			Filters.Images.Photo.src = Filters.ImagesPath + 'photo-hover.' + Filters.ImagesExt,	
			Filters.Images.Video.src = Filters.ImagesPath + 'video-hover.' + Filters.ImagesExt,
			Filters.Images.Document.src = Filters.ImagesPath + 'document-hover.' + Filters.ImagesExt;									
		},
		Handlers: {
			Text: new Object,
			Photo: new Object,
			Video: new Object,
			Document: new Object
		},
		GetHandlers: function ()
		{
			Filters.Handlers.Text = $('#filter_text');
			Filters.Handlers.Photo = $('#filter_photo');
			Filters.Handlers.Video = $('#filter_video');
			Filters.Handlers.Document = $('#filter_document');
		},
		ChangeImage: function (ind)
		{		
			Filters.ImagesCache.src = Filters.Handlers[ind].css('background-image').substring(4,Filters.Handlers[ind].css('background-image').length-1);
			Filters.Handlers[ind].css('background-image','url(\'' + Filters.Images[ind].src + '\')');	
			Filters.Images[ind].src = Filters.ImagesCache.src;		
		},
		EventUp: function ()
		{
			$.each(Filters.Handlers,function (ind,val)
				{					
					val.mouseenter(function(){
						Filters.ChangeImage(ind)
					}).mouseleave(function(){
						Filters.ChangeImage(ind)
					});
				}
			);						
		}
	};


var selectID = function (theID)
		{
			return document.getElementById(theID);
		};

$(function()
{

    var text = $('#filter_text'),
    photo = $('#filter_photo'),
    video = $('#filter_video'),
    document = $('#filter_document'),
    forms = $('#new_post'),
    attachment = $('#new_post_attachment'),
    text_form = $('#text_form'),
    photo_form = $('#photo_form'),
    video_form = $('#video_form'),
    document_form = $('#document_form'),
    imagef = "images/images/filters/",
    now = false;
	
	
	
	if ( ( selectID('filter_text') && 
		 selectID('filter_photo') &&
		 selectID('filter_video')  && 
		 selectID('filter_document') ) !== null ) 
	{
		Filters.PreloadImages();
		Filters.GetHandlers();
		Filters.EventUp();
	}
	
    $('.delete_comment').live('click', function(){
        var comment_id = $(this).attr('id'),
        comment_id_parts = comment_id.split('_'),
        cid = comment_id_parts[1],
        element = $(this);
        if (typeof cid == 'undefined')
        {
            /*alert('failed typeof !!!');*/
            return FALSE;
        }
        $.get(baseurl + 'comment/ajax_delete_comment/' + cid, function(response){
            if (response != 'ok')
            {
                /*alert('failed response !!!');*/
                return FALSE;
            }
            element.parent().parent('.comments_box').fadeOut(function(){
                $(this).remove();
            /*element.parent().parent().parent().parent().find('.link_reply').html("ye");*/
            });
        });
    });

    function changebg(which, fromwhich)
    {
        if(fromwhich)
            $('#filter_' + fromwhich).css("background-image", "url(" + imagef + fromwhich + ".png)");
        $('#filter_' + which).css("background-image", "url(" + imagef + which + "-hover.png)");
    }
    function showform(which, fromwhich)
    {
        if(fromwhich)
            $('#' + fromwhich + '_form').hide();
        $('#' + which + '_form').show();
    }

    text.click(function(){
        if(forms.is(":visible") && text_form.is(":visible"))
        {
            //text.css("background-image", "url(" + imagef + "text.png)");
            forms.slideToggle('normal');
        }
        else if(forms.is(":visible") && !text_form.is(":visible"))
        {
            //changebg("text", now);
            showform("text", now);
            now = "text";
        }
        else
        {
            //text.css("background-image", "url(" + imagef + "text-hover.png)");
            forms.slideToggle('normal');
            showform("text", now);
            now = "text";
        }
    });

    photo.click(function(){
        if(forms.is(":visible") && photo_form.is(":visible"))
        {
            //photo.css("background-image", "url(" + imagef + "photo.png)");
            forms.slideToggle('normal');
        }
        else if(forms.is(":visible") && !photo_form.is(":visible"))
        {
            //changebg("photo", now);
            showform("photo", now);
            now = "photo";
        }
        else
        {
            //photo.css("background-image", "url(" + imagef + "photo-hover.png)");
            forms.slideToggle('normal');
            showform("photo", now);
            now = "photo";
        }
    });

    video.click(function(){
        if(forms.is(":visible") && video_form.is(":visible"))
        {
            //video.css("background-image", "url(" + imagef + "video.png)");
            forms.slideToggle('normal');
        }
        else if(forms.is(":visible") && !video_form.is(":visible"))
        {
            //changebg("video", now);
            showform("video", now);
            now = "video";
        }
        else
        {
            //video.css("background-image", "url(" + imagef + "video-hover.png)");
            forms.slideToggle('normal');
            showform("video", now);
            now = "video";
        }
    });

    document.click(function(){
        if(forms.is(":visible") && document_form.is(":visible"))
        {
            //document.css("background-image", "url(" + imagef + "document.png)");
            forms.slideToggle('normal');
        }
        else if(forms.is(":visible") && !document_form.is(":visible"))
        {
            //changebg("document", now);
            showform("document", now);
            now = "document";
        }
        else
        {
            //document.css("background-image", "url(" + imagef + "document-hover.png)");
            forms.slideToggle('normal');
            showform("document", now);
            now = "document";
        }
    });



    $('#showpeopleform').click(function(){
        $('#people_form').slideToggle('fast');
    });

});

$(document).ready(function() {
    $("a.single_image").fancybox();

    $("a.inline").fancybox({
        'hideOnContentClick': true
    });

    $("a.group").fancybox({
        'speedIn'		:	600,
        'speedOut'		:	200,
        'overlayShow'	:	false
    });

});

$(function(){
    $.datepicker.formatDate('yy-mm-dd', new Date(2007, 1 - 1, 26));
    $( ".datepicker").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
    });
    for(i = 1; i <= 100; i++)
    {
        $( "#datepicker" + i).datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
        	changeYear: true
        });
    }

    $("#ui-datepicker-div").css("zoom", "80%");
});


function show_comment_form(id)
{
    var cf = $('#comment_form' + id);
    var ci = $('#comment_form_input' + id);
    cf.toggle();
    ci.focus();
    $("#comments"+id).toggle();
}

function keydownhandler(e, post_id)
{
    enter_pressed = false;

    var t = $('#comment_form_input' + post_id);
    if(e.keyCode == 13 && e.shiftKey)
    {
        var w = t.height() + 15;
        t.css("height", w);
    }
    else if(e.keyCode == 13)
    {
        $('#comment_form' + post_id).submit();
        e.preventDefault();
    }
}

var t;
function get_comments(post_id)
{
    var loader = $('#loading-post-' + post_id).css({
    	'margin-top': 50
    }).show();
    
    clearTimeout(t);
    t = setTimeout(function(){
        $('#comments' + post_id).css({
        	'margin-top': 50
        }).toggle().load(baseurl + 'comment/ajax_read_comments/' + post_id, function(){
            loader.delay(1000, function(){
                $(this).hide();
                $('#comment_form_input' + post_id).focus();
            });
        });
    }, 200);
}

function submit_comment(post_id)
{
    if($('#comment_form_input' + post_id).val() == "")
        return false;

    $('#comments' + post_id).load(baseurl + "comment/ajax_submit_comment/" + post_id,{
        body: $('#comment_form_input' + post_id).val()
    }, function(){
        $('#comment_form_input' + post_id).focus();
    }).ajaxStart(function(){
        $('#comments' + post_id).html("<center><img src='" + baseurl + "images/images/ajax-loader.gif' /></center>");
    });

    return false;
}

function get_offices(person_id)
{
    person_id = person_id || '';
    $('#officesdropdown').toggle().load(baseurl + 'people/ajax_read_offices/' + person_id, function(){
        //$('#comment_form_input' + post_id).focus();
        });
}

function another_degree()
{
    addcode = '<br />' +
    '<select name="person_education_degree[]">' +
    '<option value="null" selected="selected" disabled>None</option>' +
    '<option value="bachelor">ბაკალავრი</option>' +
    '<option value="llm">მაგისტრი</option>' +
    '<option value="phd">დოქტორანტი</option>' +
    '</select> &nbsp;&nbsp;&nbsp; ' +
    'საიდან: ' +
    '<input type="text" id="datepicker" class="text_field datepicker" ' +
    'name="person_education_degree_from[]" style="width:73px;" />&nbsp;&nbsp; ' +
    'სადამდე: ' +
    '<input type="text" id="datepicker" class="text_field datepicker" ' +
    'name="person_education_degree_to[]" style="width:73px;" /><br />';

    $("#fromto").css("display", "inline").append(addcode);

    $( ".datepicker").datepicker({
        dateFormat: 'yy-mm-dd'
    });
}






$(function(){
    $('#another_phone').click(function(){
        var html = "<select name='person_phone_type[]'>" +
        "<option value='home'>სახლი</option>" +
        "<option value='mobile'>მობილური</option>" +
        "<option value='work'>სამსახური</option>" +
        "</select> " +
        "<input type='text' name='person_phone_number[]' class='text_field phonefield' id='pphone' />";
        $(this).parent().find('div').append(html);
    });

    $('#another_affiliation').click(function(){
        var html = "" +
        "<select name='person_affiliation_type[]'>" +
        "<option value='staff'>შტატის</option>" +
        "<option value='organisation'>ორგანიზაციის</option>" +
        "</select>&nbsp;&nbsp;&nbsp; " +
        "საიდან: " +
        "<input type='text' name='person_affiliation_from[]' class='text_field datepicker'" +
        "style='width: 75px; margin-right: 11px; margin-bottom: 7px;' />" +
        " სადამდე: " +
        "<input type='text' name='person_affiliation_to[]' class='text_field datepicker' style='width: 75px' />";
        $(this).parent().find('div').append(html);
        $( ".datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });

    $('#potherlanguage').change(function(){
        if ($(this).val().length == 0)
            $(this).removeAttr('name');
        else
            $(this).attr('name', 'person_languages[]');
    });

    $('#potherinterest').change(function(){
        if ($(this).val().length == 0)
            $(this).removeAttr('name');
        else
            $(this).attr('name', 'person_interested[]');
    });
});

var split = function (val)
	{
		return val.split( /,\s*/ );
	},		
	extractLast = function( term ) {
		return split( term ).pop();
	};

$(function(){
	setbaseurl('http://www.localhost.com/gyla/');
	var pref = $('#pref'),
		reference_conf = {
			source: baseurl + 'people/autocomplete/reference/'
		},
		otherlanguage_conf = 
		{
			source: function( request, response ) {
				$.getJSON( baseurl + 'people/autocomplete/language/', {
					term: extractLast( request.term )
				}, response );
			},
			search: function() {
				// custom minLength
				var term = extractLast( this.value );
				if ( term.length < 2 ) {
					return false;
				}
			},
			focus: function() {
				// prevent value inserted on focus
				return false;
			},
			select: function( event, ui ) {
				var terms = split( this.value );
				// remove the current input
				terms.pop();
				// add the selected item
				terms.push( ui.item.value );
				// add placeholder to get the comma-and-space at the end
				terms.push( "" );
				this.value = terms.join( ", " );
				return false;
			}
		};
		
	$('#pref').autocomplete(reference_conf);
	/*$('#potherlanguage').bind( "keydown", function( event ) {
		if ( event.keyCode === $.ui.keyCode.TAB &&
				$( this ).data( "autocomplete" ).menu.active ) {
			event.preventDefault();
		}
	}).autocomplete(otherlanguage_conf);*/
	
});


$(function(){
	setbaseurl('http://www.localhost.com/gyla/');
	var personLanguages = {
	 		CheckBoxes: $('input[type="checkbox"][name="person_languages[]"]'),
	 		Labels: $('.personLangLabel[for]')
		},
		otherLanguages = {
			Button: $('#other-lang'),
			Field: $('#potherlanguage'),
			theLanguages: new Array
		},
		fireUpLanguageCheckBoxes = function (lang)
		{
			$.each(lang,function(ind,val){
				$(val).bind('click',function(){
					if ( !$(this).is(':checked') ) 
					{
						$([this,$('label[for="'+$(this).attr('id')+'"]')]).each(function(){
							$(this).fadeOut(function(){
								$(this).remove();
							});
						});
					}
				});
			});						
		};		
		
	if ( personLanguages.CheckBoxes.length !== 0 )
		fireUpLanguageCheckBoxes(personLanguages.CheckBoxes);
		
	if (otherLanguages.Button.length !== 0)
		otherLanguages.Button.click(function(event){
			event.preventDefault();
			otherLanguages.theLanguages = otherLanguages.Field.attr('value').split(',');
			var trimArray = function (array)
			{
				var newArray = new Array,arrEl = null;
				for ( var i in array ){
					arrEl = $.trim(array[i]);
					if ( arrEl.length !== 0 )
						newArray.push(arrEl);
				}
				return newArray;
			};
			otherLanguages.theLanguages = trimArray(otherLanguages.theLanguages);
			personLanguages = {
	 			CheckBoxes: $('input[type="checkbox"][name="person_languages[]"]'),
	 			Labels: $('.personLangLabel[for]')
			};
			var labelValues = new Array;
			for ( var i in personLanguages.Labels ){
				var labelValue = $.trim(personLanguages.Labels[i].innerHTML);
				if ( labelValue.length > 0 )
					labelValues.push(labelValue);
			}
			
			var languagesToAdd = new Array;
			$.each(otherLanguages.theLanguages,function(index,value){
				if ( $.inArray(value,labelValues) === -1 && $.inArray(value,languagesToAdd) === -1  )
					languagesToAdd.push(value);				
			});
			
			
			for ( var i in languagesToAdd ) {
				var html = new Array;
					html.push('<input type="checkbox" name="person_languages[]" class="text_field" id="p'+languagesToAdd[i]+'" checked="checked" value="22">');
					html.push('<label class="personLangLabel" for="p'+languagesToAdd[i]+'">'+languagesToAdd[i]+'</label>');					
				$('#show_other_languages').before(html.join(''));
			}	
			
			otherLanguages.Field.attr('value','');					
			
			fireUpLanguageCheckBoxes($('input[type="checkbox"][name="person_languages[]"]'));
		});

});


$(function(){

	var Search = {
		Box: $('#search-main-box'),
		Toggle: $('#search-box-toggle'),
		Devider: $('.box-devider'),
		Form: {
			self: $('#seach-main-box form:first'),
			FillOut: function (data)
				{
									
					data = $.parseJSON(data);
					
					if ( typeof(data.person_status_state) !== "undefined" && 
						 data.person_status_state == "on" )
						 	$('#person_status_state').attr('checked','checked');
					if ( typeof(data.person_status_organization) !== "undefined" && 
						 data.person_status_organization == "on" )
							$('#person_status_organization').attr('checked','checked');
					if ( typeof(data.person_name) !== "undefined" &&
						 data.person_name.length > 0 )
						 	$('#person_name').val(data.person_name);
					if ( typeof(data.person_date_start) !== "undefined" &&
						 data.person_date_start.length > 0 )
						 	$('#person_date_start').val(data.person_date_start);
					if ( typeof(data.person_date_end) !== "undefined" &&
						 data.person_date_end.length > 0 )
						 	$('#person_date_end').val(data.person_date_end);
					if ( typeof(data.person_private_number) !== "undefined" &&
						 data.person_private_number.length > 0 && !isNaN(data.person_private_number) )
						 	$('#person_private_number').val(data.person_private_number);
					if ( typeof(data.person_gender) !== "undefined" &&
						 data.person_gender.length > 0 && isNaN(data.person_gender) && ( data.person_gender === "male" || data.person_gender === "female" ) )
						 	$('#person_gender_'+data.person_gender).attr('checked','checked');
					if ( typeof(data.person_tel) !== "undefined" &&
						 data.person_tel.length > 0 && !isNaN(data.person_tel) )
						 	$('#person_tel').val(data.person_private_number);
					if ( typeof(data.person_email) !== "undefined" &&
						 data.person_email.length > 0 )
						 	$('#person_email').val(data.person_email);
					if ( typeof(data.person_languages) !== "undefined" &&
						 data.person_languages.length > 0 )
						 	$('#person_languages').val(data.person_languages);
					if ( typeof(data.person_office) !== "undefined" &&
						 data.person_office.length > 0 && !isNaN(data.person_office) )
						 	$('#person_office').children('option[value="'+data.person_office+'"]:first').attr('selected','selected');
											 							 
				},
			Reset: function ()
				{					
				 	$('#person_status_state').removeAttr('checked');			
					$('#person_status_organization').removeAttr('checked');			
				 	$('#person_name').val('');			
				 	$('#person_date_start').val('');			
				 	$('#person_date_end').val('');			
				 	$('#person_private_number').val('');			
				 	$('#person_gender_male').attr('checked','checked');			
				 	$('#person_tel').val('');			
				 	$('#person_email').val('');			
				 	$('#person_languages').val('');			
				 	$('#person_office').children('option:first').attr('selected','selected');
				},
			Date: [$('#person_date_start'),$('#person_date_end')],
			Languages: {
				Instance: $('#person_languages'),
				AutoCompleteConf: {
					source: function( request, response ) {
						$.getJSON( baseurl + 'people/autocomplete/language/', {
							term: extractLast( request.term )
						}, response );
					},
					search: function() {
						// custom minLength
						var term = extractLast( this.value );
						if ( term.length < 2 ) {
							return false;
						}
					},
					focus: function() {
						// prevent value inserted on focus
						return false;
					},
					select: function( event, ui ) {
						var terms = split( this.value );
						// remove the current input
						terms.pop();
						// add the selected item
						terms.push( ui.item.value );
						// add placeholder to get the comma-and-space at the end
						terms.push( "" );
						this.value = terms.join( ", " );
						return false;
					}
				}
			},
			Button: {
				self: $('#person_search_save'),
				Click: function ()
					{
						var name = prompt('შეიყვანე ძებნის სახელი:');
						if ( name !== null )
							if ( name.length > 0 )
								$.post(baseurl+'people/save_search',{name:name,data:Search.Form.self.serialize()},function(data){			
									if ( data === 'Saved.' ){
										Search.Form.SavedSearchList.self.remove();
										Search.Form.Button.self.after('<select id="person_saved_search"></select>');
										Search.Form.SavedSearchList.self = $('#person_saved_search');
										Search.Form.SavedSearchList.Fill();							
									}
									else{
										alert(data);
									}
								});
							else{
								alert('Please enter name.');
								Search.Form.Button.Click();
							}
					}			
			},
			SavedSearchList: {
				self: $('#person_saved_search'),
				Fill: function ()
					{	
						$.getJSON(baseurl+'people/list_saved_search',function(data){
							Search.Form.SavedSearchList.self.empty();							
							var html = new Array('<option value="0">Select Search</option>');
								for ( var i in data ) {
									html.push('<option value="' + data[i].id + '" '+ (typeof(theSavedSearch) !== "undefined" && data[i].id == theSavedSearch ? 'selected="selected"' : null ) +'>');								
									html.push(data[i].name); 
									html.push('</option>');
								}
							Search.Form.SavedSearchList.self.html(html.join(''));
						});
					},
				GetSelected: function ()
					{
						var SelectedOption = Search.Form.SavedSearchList.self.children('option:selected:first'),
							Selected_ID = SelectedOption.attr('value');								
							if ( typeof(Selected_ID) !== "undefined" && !isNaN(Selected_ID) && Selected_ID > 0 ){
								/*var func = function(data){												
									Search.Form.FillOut(data);	
								};
								$.get(baseurl + 'people/get_saved_search',{id:Selected_ID},func);*/
								window.location = baseurl + 'people/search/?id='+Selected_ID;
							}
							else{
								Search.Form.Reset();
							}
																								
					}
			},
			Submit: $('#person_search')
		}				
	};
	
	Search.Devider.height(Search.Devider.parent().height()-65);
	for ( var i in Search.Form.Date )
		Search.Form.Date[i].datepicker({
			autoSize: true,
		    dateFormat: 'yy-mm-dd',
		    changeMonth: true,
		    changeYear: true
    	});
    Search.Form.Languages.Instance.bind( "keydown", function( event ) {
		if ( event.keyCode === $.ui.keyCode.TAB &&
				$( this ).data( "autocomplete" ).menu.active ) {
			event.preventDefault();
		}
	}).autocomplete(Search.Form.Languages.AutoCompleteConf);
	Search.Form.SavedSearchList.Fill();
	Search.Form.Button.self.click(function(event){
		event.preventDefault();		
		Search.Form.Button.Click();		
	});
	Search.Form.SavedSearchList.self.live({
		change: function(){		
			Search.Form.SavedSearchList.GetSelected();
		}
	});
	
});


