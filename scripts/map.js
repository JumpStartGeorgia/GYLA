var map, base, layer, options = {
    'boundsLeft': 4260630.1231925,
    'boundsBottom': 4999230.0089212,
    'boundsRight': 5422472.9529191,
    'boundsTop': 5427277.3672416,
    'zoom': 7,
    'lat': 42.236652,
    'lon': 43.59375
};

function map_init()
{

    // Map
    map = new OpenLayers.Map('map', {
        controls: [],
        restrictedExtent: new OpenLayers.Bounds(options.boundsLeft, options.boundsBottom, options.boundsRight, options.boundsTop)/*,
        projection: 'EPSG:900913'*/
    });

    // Base Layer
    base = new OpenLayers.Layer.OSM('Georgia', 'http://a.tile.mapspot.ge/ndi_en/${z}/${x}/${y}.png', {
    //base = new OpenLayers.Layer.OSM('Georgia', 'http://tile.openstreetmap.org/${z}/${x}/${y}.png', {
        numZoomLevels: 19
    });
    base.setOpacity(0);

    // Overlay Layer
    layer = new OpenLayers.Layer.GML('Districts', '/gyla/events/districts', {
        format: OpenLayers.Format.GeoJSON,
        styleMap: map_styles()/*,
        projection: 'EPSG:900913'*/
    });

    // Selection
    var select = new OpenLayers.Control.SelectFeature(layer, {
        hover: true,
        onSelect: function(feature)
        {
            var info = ['<b style="font-weight: bold;">' + feature.attributes.name_2_geo + '</b> - '],
            events = feature.attributes.event,
            content = '';
            /*info += (events.length > 0 ? 'მოვლენები: ' + events.length : '');*/
            info += (events.length > 0 ? 'მოვლენები: ' + events.length : 'არ არის მოვლენები');
            $('#map-info').html(info).show(0);
            /*if (feature.attributes.event !== false)
            {
                if (typeof(feature.attributes.event.name) !== 'undefined')
                    content.push(feature.attributes.event.name);
                if (typeof(feature.attributes.event.address) !== 'undefined')
                    content.push(feature.attributes.event.address);
                if (typeof(feature.attributes.event.start_at) !== 'undefined')
                    content.push(feature.attributes.event.start_at);
            }
            $('#map-info').html(content.join(', ')).show(0);*/

	    /*for (i in events)
	    {
		content += 
		    '<div><a href="' + baseurl + 'events/index#event' + events[i].id + '">' +
		        events[i].name + ', ' + ' ' +  events[i].address + ', ' + events[i].start_at +
		    '</a></div>';
	    }
            $('#map_events').prepend(content);

            console.log(feature);*/
        },
        onUnselect: function()
        {
            $('#map-info').hide(0, function(){
                $(this).text('');
            });
        },
        clickFeature: function(feature)
        {
            var events = feature.attributes.event,
            content = '';

	    for (i in events)
	    {
		content += 
		    '<div class="switch"><a href="' + baseurl + 'events/view/' + events[i].id + '">' +
		        events[i].name + ', ' + ' ' +  events[i].address + ', ' + events[i].start_at +
		    '</a></div>';
	    }
            $('#map_events').html(content);
        }
    });

    map.addControl(select);
    select.activate();

    // Configuration
    map.addLayers([
	base,
	layer
    ]);
    map.setCenter(new OpenLayers.LonLat(options.lon, options.lat));
    map.zoomTo(options.zoom);

}

function map_styles()
{
    var theme = new OpenLayers.Style(),
    rules = [],
    property = 'proportion',
    comparisons = [
    {
        from: 0,
        to: 16,
        color: '9183B5'//'F5CC00',
    },
    {
        from: 16,
        to: 33,
        color: '7A6DA0'//'F5A300'
    },
    {
        from: 33,
        to: 50,
        color: '64588C'//'F57A00'
    },
    {
        from: 50,
        to: 66,
        color: '4D4277'//'F55200'
    },
    {
        from: 66,
        to: 82,
        color: '372D63'//'F52900'
    },
    {
        from: 82,
        to: 100,
        color: '21184F'//'F50000'
    },
    {
        from: 100,
        to: 9999,
        color: '000000'
    }
    ],
    first_filter_type = OpenLayers.Filter.Comparison.GREATER_THAN;

    // Default
    rules.push(new OpenLayers.Rule({
        filter: new OpenLayers.Filter.Logical({
            type: OpenLayers.Filter.Logical.AND,
            filters: [new OpenLayers.Filter.Comparison({
                type: OpenLayers.Filter.Comparison.EQUAL_TO,
                property: property,
                value: 0
            })
            ]
        }),
        symbolizer: {
            'Polygon': {
                'fillColor': '#beaede',
                'strokeColor': '#fff',
                'strokeWidth': 1,
                'fillOpacity': 1
            }
        }
    }));

    // Rules
    for (var idx in comparisons)
    {
        if (idx > 0)
            first_filter_type = OpenLayers.Filter.Comparison.GREATER_THAN_OR_EQUAL_TO;
        rules.push(new OpenLayers.Rule({
            filter: new OpenLayers.Filter.Logical({
                type: OpenLayers.Filter.Logical.AND,
                filters: [
                new OpenLayers.Filter.Comparison({
                    type: first_filter_type,
                    property: property,
                    value: parseInt(comparisons[idx].from)
                }),
                new OpenLayers.Filter.Comparison({
                    type: OpenLayers.Filter.Comparison.LESS_THAN_OR_EQUAL_TO,
                    property: property,
                    value: parseInt(comparisons[idx].to)
                })
                ]
            }),
            symbolizer: {
                'Polygon': {
                    'fillColor': '#' + comparisons[idx].color,
                    'strokeColor': '#fff',
                    'fillOpacity': 1
                }
            }
        }));
    }

    theme.addRules(rules);

    return new OpenLayers.StyleMap({
        'default': theme,
        'select': {
            'strokeColor': '#fff',
            'fillColor': '#9183B5',
            'strokeWidth': 0,
            'fillOpacity': .9
        }
    });
}
