var zoomNum = 1;
var maxZoomOut = 7;
var map = null;
var map_confs = {"boundsLeft":4260630.1231925,
		"boundsBottom":4999230.0089212,
		"boundsRight":5422472.9529191,
		"boundsTop":5427277.3672416,
		"zoom":6.5,
		"lon":4876406.8229462,
		"lat":5183290.372998};
var mapspot_confs = {"boundsLeft":38.704833984374,
		     "boundsBottom":-45.120849609376,
		     "boundsRight":49.141845703124,
		     "boundsTop":-41.275634765626,
		     "zoom":7,
		     "lon":44.230957031249,
		     "lat":-43.483886718751};

function get_osm_url (bounds)
{
    var res = this.map.getResolution();
    var x = Math.round ((bounds.left - this.maxExtent.left) / (res * this.tileSize.w));
    var y = Math.round ((this.maxExtent.top - bounds.top) / (res * this.tileSize.h));
    var z = this.map.getZoom();
    var path =  z + "/" + x + "/" + y ;
   	var url = this.url;
    if (url instanceof Array) 
			{
      		url = this.selectUrl(path, url);
    		}
    return url + path;
}

/*function setUpPanControls(){
	var max_button = function(){
		map.zoomTo(map.getZoom() + zoomNum);
	};
	var min_button = function(){
		stopZoomOut();
	};	
	var filter_button = function(){
		alert("filters");
	};
	var set_button = function(){
		alert("sets");
	};
	var tag_button = function(){
		alert("tags");
	};
	var maximize = new OpenLayers.Control.Button({
		displayClass:"max",
		trigger:max_button
	});
	var minimize = new OpenLayers.Control.Button({
		displayClass:"min",
		trigger:min_button
	});
	var filters = new OpenLayers.Control.Button({
		displayClass:"filters",
		trigger:filter_button
	});
	var sets = new OpenLayers.Control.Button({
		displayClass:"sets",
		trigger:set_button
	});
	var tags = new OpenLayers.Control.Button({
		displayClass:"tags",
		trigger:tag_button
	});
	var keyboard_def = new OpenLayers.Control.KeyboardDefaults({
		slideFactor:50
	});
	return [keyboard_def,maximize,minimize,filters,sets,tags]; 
}*/

function stopZoomOut(){
	if(map.getZoom() != maxZoomOut){
		map.zoomTo(map.getZoom() - zoomNum);
	}
}

/*function buthoverEffect(but_class){
		document.getElementsByClassName(but_class)[0].onmouseover = function(){
			this.style.opacity = 1;
		}
		document.getElementsByClassName(but_class)[0].onmouseout = function(){
			this.style.opacity = 0.5;
		}
		document.getElementsByClassName(but_class)[0].onmouseover = function(){
			this.style.opacity = 1;
		}
		document.getElementsByClassName(but_class)[0].onmouseout = function(){
			this.style.opacity = 0.5;	
		}
}*/


function makeMarker(){
	//console.log(places);
    var markers = new OpenLayers.Layer.Markers( "OpenTaps::Markers" );
    map.addLayer(markers);
    var size = new OpenLayers.Size(20,20);
    var offset = new OpenLayers.Pixel(-size.w / 2, -size.h / 2);
    var ico = new OpenLayers.Icon("../images/images/marker.png",size,offset);
    var lonlat = null;
    /*console.log(places);*/
    for(var i=0;i<places.length;i++){
    
    	if( places[i][0] === 'event' )
    		lonlat = new OpenLayers.LonLat(places[i][2],places[i][1]);
    	else if(places[i][0] === 'office')
    		lonlat = new OpenLayers.LonLat(places[i][4],places[i][3]);
    	markers.addMarker(new OpenLayers.Marker(lonlat,ico));
    }
    
}

var lonlat = null;
var active_id = 0;
function show_next_popup(popup_div,active)
{
	
	if( !active ){
		active = popup_div.id;
	}
	
	var k = 0;
	var place_lon = null;
	var place_lat = null;
	for( var i=0,len=places.length;i<len;i++){
	 place_lon = places[i][0] == 'event' ? places[i][2] : places[i][4];
         place_lat = places[i][0] == 'event' ? places[i][1] : places[i][3];
    	 if( place_lon == lonlat['lon'] && place_lat == lonlat['lat'] )
    	 	k++;
    	 	}
    	 	
    	 if( k-1 != active){
    	 k=0;	
		for( var i=0,len=places.length;i<len;i++){
			 place_lon = places[i][0] == 'event' ? places[i][2] : places[i][4];
		         place_lat = places[i][0] == 'event' ? places[i][1] : places[i][3];
    	 if( place_lon == lonlat['lon'] && place_lat == lonlat['lat'] ){
    	 	if( k-1 != active )
    	 		$('#'+k).css('display','none');
    	 	else{
    	 		$('#'+k).css('display','block');
    	 		active_id = k;
    	 	     }
    	 	k++;
    	 	}
    	 	}
	 }
}
function show_back_popup(popup_div,active)
{
	if(!active )
	{
		active = popup_div.id;
	}
	
	if( popup_div.id != '0' )
	{
		var k =0;
	for( var i=0,len=places.length;i<len;i++){
	var place_lon = places[i][0] == 'event' ? places[i][2] : places[i][4];
        var place_lat = places[i][0] == 'event' ? places[i][1] : places[i][3];
    	 if( place_lon == lonlat['lon'] && place_lat == lonlat['lat'] ){
    	 	if( k != active-1 )
    	 		$('#'+k).css('display','none');
    	 	else{
    	 		$('#'+k).css('display','block');
    	 		active_id = k;
    	 	     }
    	 	k++;
    	 }
	
	}
	}
}

var popups = new Array();
function show_popup(i, id, lon, lat)
{
	
    var content = [];
    var size = { 'width':places[i][0] == 'event' ? 128 : 120, 'height':places[i][0] == 'event' ? 100 : 90 };
    lonlat = {'lon':lon,'lat':lat};
    var k=0;
    if( places[i][0] === 'event' ){
    	for( var j=0,len=places.length;j<len;j++)
    	 if( places[j][2] == lonlat['lon'] && places[j][1] == lonlat['lat'] ){
			if( k==0 ) var display = "display:block;";
			else var display = "display:none;";
           content.push('<div id="'+k+'" style="position:relative;padding: 5px;float:left;'+display+'">');
           content.push('<p style="text-align:left;font-weight: bold;margin-bottom:7px;"><a style="color:#00E" href="' + places[j][8] +'">' + places[j][3] + '</a></p>');
           content.push('<p style="text-align:left;font-size:11pt;">' + places[j][6] + '</p>');
           content.push('<p style="text-align:left;font-size:11pt;">' + places[j][7] + '</p>');
           content.push('<br /><p style="text-align:left;font-size:8pt;">' + places[j][4] + ' - ' + places[j][5] + '</p>');
           	
          if(places.length > 1){
           content.push('<a href="" style="position:absolute;bottom:5px;left:56px;font-size:8pt;text-decoration:none;color:#000;" onclick="show_back_popup(this.parentNode);return false;">&#171;</a>');
           content.push('&nbsp;<a href="" style="position:absolute;bottom:5px;left:66px;font-size:8pt;text-decoration:none;color:#000;" onclick="show_next_popup(this.parentNode);return false;">&#187;</a>');
          }
          else size['height'] = 90;
          
           content.push('</div>');
           k++;
         }
    }
    else if( places[i][0] === 'office' ){
    for( var j=0,len=places.length;j<len;j++)
    	 if( places[j][4] == lonlat['lon'] && places[j][3] == lonlat['lat'] ){
    	 	if( k==0 ) var display = "display:block;";
			else var display = "display:none;";
           content.push("<div id='"+k+"' style='position:relative;padding: 5px;float:left;"+display+"'>");
           content.push('<p style="text-align:left;font-weight: bold">' + places[j][2] + '</p>');
           content.push('<p style="text-align:left;font-size:11pt;">' + places[j][5] + '</p>');
           content.push('<p style="text-align:left;font-size:11pt;">Tel:' + places[j][6] + '</p>');
           content.push('<p style="text-align:left;font-size:11pt;">People:' + places[j][1] + '</p>');
           
     	 if(places.length > 1){
           content.push('<a href="" style="position:absolute;bottom:5px;left:52px;font-size:8pt;text-decoration:none;color:#000;" onclick="show_back_popup(this.parentNode);return false;">&#171;</a>');
           content.push('&nbsp;<a href="" style="position:absolute;bottom:5px;left:62px;font-size:8pt;text-decoration:none;color:#000;" onclick="show_next_popup(this.parentNode);return false;">&#187;</a>');
           
         }
         else size['height'] = 70;
         
           content.push("</div>");
           k++;
        }
    }
    popups[id] = new OpenLayers.Popup(
	            'chicken-' + id,
                    new OpenLayers.LonLat(lonlat['lon'], lonlat['lat']),
                    new OpenLayers.Size(size['width'], size['height']),
                    content.join(''),
                    true
                );
    popups[id].backgroundColor = "#CCC";
    popups[id].opacity = 0.9;
    popups[id].displayClass = "popup";
    popups[id].setBorder('2px');
    map.addPopup(popups[id]);
              
}

function hide_popup(id)
{
    popups[id].destroy();
    popups = new Array();
}

function configure_marker_animation()
{
    var places_id = [];
    var marker_divs = document.getElementById('OpenLayers.Map_2_OpenLayers_Container').getElementsByTagName('div');
    var marker_last_div = marker_divs[marker_divs.length-1].id;
    var k = window.parseInt(marker_last_div.substr(marker_last_div.indexOf('OpenLayers.Layer.Markers_')-1));
    for (var i=0,len=places.length;i<len;i++)
    {
        places_id.push("OL_Icon_"+k);
        k+=4;
    }
    var lon = null,
    lat = null,
    marker_image;
    for(var idx = 0, len = places_id.length; idx < len; idx++)
    {
        lon = places[idx][0] == 'event' ? places[idx][2] : places[idx][4];
        lat = places[idx][0] == 'event' ? places[idx][1] : places[idx][3];
        marker_image = $('#' + places_id[idx]).children('img:first').mouseenter(function(){
	    if(!popups[places_id[idx]]) show_popup(idx,places_id[idx], lon, lat);
            $('#chicken-' + places_id[idx]).mouseleave(function(){
                hide_popup(places_id[idx]);
            });
        });
        
/*        marker_image.live('mouseover',show_popup(lon,lat));
        marker_image.live();*/
        break;
        /*
	   	var marker_img_handle = document.getElementById(places_id[i]).getElementsByTagName('img')[0];
	    		marker_img_handle.setAttribute("onmouseover","show_popup("+lon+","+lat+")");
	    		marker_img_handle.setAttribute("onmouseout","hide_popup(this.id)");
	  */  		
    }
}


function map_init()
{

	map = new OpenLayers.Map("map",{
		controls:[],
		restrictedExtent:new OpenLayers.Bounds(map_confs.boundsLeft,map_confs.boundsBottom,map_confs.boundsRight,map_confs.boundsTop)
	});
	
	 var deven = new OpenLayers.Layer.OSM("English", "http://a.tile.mapspot.ge/ndi_en/${z}/${x}/${y}.png", {numZoomLevels: 19}, {isBaseLayer:true});
	var devka = new OpenLayers.Layer.OSM("Georgian", "http://a.tile.mapspot.ge/ndi_ka/${z}/${x}/${y}.png", {numZoomLevels: 19}, {isBaseLayer:false});
	
	/*var mapspot_layer = new OpenLayers.Layer.TMS(
			"MapSpot",
			"http://tile.mapspot.ge/new_en/",
			{type:"png",getURL:get_osm_url},
			{isBaseLayer:true}
	);*/
	
	var nav = new OpenLayers.Control.Navigation({
		handleRightClicks:true,
		wheelDown:function(evt,delta){
			stopZoomOut();
		}
	});
	nav.defaultDblRightClick = function(){
		stopZoomOut();
	};
	
	/*var conts = setUpPanControls();
	conts[0].defaultKeyPress = function(code){
				switch(code.keyCode) {
            case OpenLayers.Event.KEY_LEFT:
               this.map.pan(-this.slideFactor, 0);
               break;
	            case OpenLayers.Event.KEY_RIGHT:
	                this.map.pan(this.slideFactor, 0);
	                break;
	            case OpenLayers.Event.KEY_UP:
	                this.map.pan(0, -this.slideFactor);
	                break;
	            case OpenLayers.Event.KEY_DOWN:
	                this.map.pan(0, this.slideFactor);
	                break;
	           
	            case 33: 
	                var size = this.map.getSize();
	                this.map.pan(0, -0.75*size.h);
	                break;
	            case 34: 
	                var size = this.map.getSize();
	                this.map.pan(0, 0.75*size.h);
	                break;
	            case 35: 
	                var size = this.map.getSize();
	                this.map.pan(0.75*size.w, 0);
	                break;
	            case 36: 
	                var size = this.map.getSize();
	                this.map.pan(-0.75*size.w, 0);
	                break;
	
	            case 43:  
	            case 61:  
	            case 187: 
	            case 107: 
	                this.map.zoomIn();
	                break;
	            case 45:  
	            case 109: 
	            case 189: 
	            case 95:  
	                stopZoomOut();
	                break;
	        }
	};
	
	var panel = new OpenLayers.Control.Panel({
		div:document.getElementById("panel"),
		defaultControl:conts[0]
	});panel.addControls(conts);*/
	map.addLayers([deven,devka]);//[mapspot_layer]);
	makeMarker();
	map.addControls([/*panel,*/nav/*,new OpenLayers.Control.MousePosition()*/]);
	map.setCenter(new OpenLayers.LonLat(map_confs.lon,map_confs.lat));
	map.zoomTo(map_confs.zoom);
	/*new function (){
		var hover_control_classes = ["maxItemInactive","minItemInactive","filtersItemInactive","setsItemInactive","tagsItemInactive"];
		for(var i=0,len = hover_control_classes.length;i<len;i++)
			buthoverEffect(hover_control_classes[i]);
	}*/
	document.getElementById('OpenLayers.Map_2_OpenLayers_ViewPort').style.width = "95%";
	document.getElementById('OpenLayers.Map_2_OpenLayers_ViewPort').style.height = "95%";
	document.getElementById('OpenLayers.Map_2_OpenLayers_ViewPort').style.padding = "5px 5px 5px 5px";
	configure_marker_animation();
	
}
