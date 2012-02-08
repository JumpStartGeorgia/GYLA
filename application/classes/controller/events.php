<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_Events extends Controller_Application
{

    public function before()
    {
        parent::before();
        $this->check_access('events', 'view');
    }

    private function districts()
    {
        return DB::select()
                ->from('districts')
                ->where('language', '=', 'ka')
                ->execute()
                ->as_array();
    }

    public function action_index()
    {
        $sql = DB::select('events.*', array('districts.name', 'district'))
                ->from('events')
                ->join('districts')
                ->on('events.district_id', '=', 'districts.id')
                ->order_by('start_at');
        $e = $this->db->query(Database::SELECT, $sql)->as_array();
        $this->template->content = View::factory('events');
        $this->template->content->events = $e;
        $this->template->content->allow_edit = $this->check_access('events', 'edit', FALSE);
    }

    public function action_calendar()
    {
        $this->check_access('events', 'calendar');

        $m = array(
            "იანვარი",
            "თებერვალი",
            "მარტი",
            "აპრილი",
            "მაისი",
            "ივნისი",
            "ივლისი",
            "აგვისტო",
            "სექტემბერი",
            "ოქტომბერი",
            "ნოემბერი",
            "დეკემბერი"
        );
        $date = $this->request->param('id');
        if (empty($date))
        {
            $month = date("n");
            $year = date("Y");
        }
        else
        {
            $date = explode('-', $date);
            $month = $date[1];
            $year = $date[0];
        }

        $this->template->content = View::factory('calendar');
        $this->template->content->calendar = $this->draw_calendar($month, $year);
        $this->template->content->current_date = $m[$month - 1] . " " . $year;
        $this->template->content->event_years = $this->get_unique_event_years();
        $this->template->content->now = array('month' => $month, 'year' => $year);
    }

    public function action_create()
    {
        $this->check_access('events', 'add');

        $columns = array
            (
            'name',
            'type',
            'district_id',
            'address',
            'start_at',
            'end_at',
            'contact_info',
            'user_id'
        );
        $values = array
            (
            $_POST['event_name'],
            $_POST['event_type'],
            $_POST['event_district'],
            $_POST['event_address'],
            $_POST['event_start_at_date'] . " " . $_POST['event_start_at_hour'],
            //2011-08-11 12:24:27
            $_POST['event_end_at_date'] . " " . $_POST['event_end_at_hour'],
            $_POST['event_contact_info'],
            $_SESSION['userid']
        );
        $query = DB::insert('events', $columns)->values($values)->execute();
        if ($query)
            $this->request->redirect(URL::site('events'));
    }

    public function action_new()
    {
        $this->check_access('events', 'add');

        $this->template->content = View::factory('forms/event');
        $this->template->content->districts = $this->districts();
        $this->template->content->event = array(
            'id' => NULL, 'user_id' => NULL, 'name' => NULL, 'type' => NULL,
            'district' => NULL, 'address' => NULL, 'start_at' => NULL, 'end_at' => NULL,
            'contact_info' => NULL, 'e_name' => NULL, 'd_name' => NULL, 'district_id' => NULL
        );
    }

    public function action_edit()
    {

        $this->check_access('events', 'edit');

        $query = DB::select('events.*')
                ->from('events')
                ->join('districts')
                ->on('events.district_id', '=', 'districts.id')
                ->where('events.id', '=', $this->request->param('id'));
        $e = $this->db->query(Database::SELECT, $query)->as_array();
        if (empty($e))
            $this->request->redirect(URL::site('events'));
        $this->template->content = View::factory('forms/event');
        $this->template->content->districts = $this->districts();
        $this->template->content->event = $e[0];
    }

    public function action_update()
    {
        $this->check_access('events', 'edit');

        $id = $this->request->param('id');

        $query = DB::update('events')
                ->set(array(
                    'name' => $_POST['event_name'],
                    'type' => $_POST['event_type'],
                    'district_id' => $_POST['event_district'],
                    'address' => $_POST['event_address'],
                    'start_at' => $_POST['event_start_at_date'] . " " . $_POST['event_start_at_hour'],
                    'end_at' => $_POST['event_end_at_date'] . " " . $_POST['event_end_at_hour'],
                    'contact_info' => $_POST['event_contact_info']
                ))
                ->where('id', '=', $id)
                ->execute();

        //if($query){
        $this->request->redirect(URL::site('events'));
        die('redirect');
        //}
    }

    public function action_map()
    {
        $this->check_access('events', 'map');

        $type = (isset($_GET['type']) AND in_array((string) $_GET['type'], array('events', 'offices'))) ? (string) $_GET['type'] : 'events';

        if ($type == 'events')
        {
            $query = DB::select('events.*', 'districts.latitude', 'districts.longitude', array('events.name', 'event_name'))
                    ->from('events')
                    ->join('districts')
                    ->on('events.district_id', '=', 'districts.id')
                    ->execute()
                    ->as_array();
            $result = $query;
            $coordinates = array();
            foreach ($result AS $event)
            {
                if (empty($event['latitude']) OR empty($event['longitude']))
                    continue;

                $link = URL::site("events/index/#event" . $event['id']);
                $coordinates[] = json_encode(array(
                    'event',
                    $event['latitude'],
                    $event['longitude'],
                    $event['event_name'],
                    date('Y.m.d', strtotime($event['start_at'])),
                    date('Y.m.d', strtotime($event['end_at'])),
                    $event['type'],
                    $event['address'],
                    $link
                        ));
            }
        }
        elseif ($type == 'offices')
        {
            $query = DB::select('offices.*', 'districts.latitude', 'districts.longitude', array('offices.name', 'office_name'))
                    ->from('offices')
                    ->join('districts')
                    ->on('offices.district_id', '=', 'districts.id')
                    ->execute()
                    ->as_array();
            $result = $query;
            $coordinates = array();
            foreach ($result AS $office)
            {

                if (empty($office['latitude']) OR empty($office['longitude']))
                    continue;

                $count_people = DB::select(array('COUNT("id")', 'num'))
                        ->from('people')
                        ->where('office_id', '=', $office['id'])
                        ->execute()
                        ->as_array();
                $coordinates[] = json_encode(array(
                    'office',
                    $count_people[0]['num'],
                    $office['office_name'],
                    $office['latitude'],
                    $office['longitude'],
                    $office['address'],
                    $office['phone']
                        ));
                //$coordinates[] = "[{$office['latitude']}, {$office['longitude']}, {$office['name']}, {$office['address']},]";
            }
        }
        $coordinates = array_unique($coordinates);

        $this->template->scripts[] = 'scripts/OpenLayers.js';
        $this->template->scripts[] = 'scripts/map.js';

        $this->template->content = View::factory('map', array(
                    'coordinates' => implode(', ', $coordinates)
                ));
    }

    public function action_districts()
    {
        $districts = DB::select()
                ->from('districts')
                ->where('geojson', '!=', array('NULL'))
                ->execute()
                ->as_array();
        if (empty($districts))
            $districts = array();
        else
        {

            // Count total number of events
            $count_result = DB::select(array('COUNT("id")', 'total'))
                    ->from('events')
                    ->execute()
                    ->as_array();

            // Assign GeoJSON to the data
            $features = array();
            foreach ($districts AS $district)
            {
                $json = unserialize($district['geojson']);

                // Get district info
                $sql = "
                    SELECT *, (select count(id) from events where e.id = events.id) AS total
                    FROM events as e
                    WHERE district_id = :district_id
                    AND DATE(start_at) > CURDATE()
                    ORDER BY DATE(start_at) ASC
                    "./*LIMIT 1*/"
                    ;";
                $district_events = DB::query(Database::SELECT, $sql)
                        ->bind(':district_id', $district['id'])
                        ->execute()
                        ->as_array();

                // Calculate proportions
                if (empty($district_events[0]['total']) OR empty($count_result[0]['total']))
                    $proportion = 0;
                else
                    $proportion = round(($district_events[0]['total'] * 100) / $count_result[0]['total']);
                $json->properties->proportion = $proportion;

                // Retrieve event info
                $events_info = array();
                if
                (
                        !empty($district_events[0]['name'])
                        AND !empty($district_events[0]['address'])
                        AND !empty($district_events[0]['start_at'])
                )
                {
                    foreach ($district_events as $de)
                    {
			if (empty($de))
			{
			    continue;
			}
			$events_info[] = array(
			    'id' => $de['id'],
			    'name' => trim($de['name']),
			    'address' => trim($de['address']),
			    'start_at' => date('Y-m-d', strtotime($de['start_at']))
			);
                    }
                }
                $json->properties->event = $events_info;

                $features[] = $json;
            }
            $districts = $features;
        }
        $data = array(
            'type' => 'FeatureCollection',
            'features' => $districts
        );
        //print_r($data);
        //exit;
        exit(json_encode($data));
    }

    public function action_districts_new()
    {
        $mappings = DB::select()
                ->from('mapping')
                //->where('coordinates', '!=', array('NULL'))
                ->execute()
                ->as_array();


        if (empty($mappings))
            $mappings = array();
        else
        {
            header('Content-type: text/html; charset=UTF-8');

            // Count total number of events
            $count_result = DB::select(array('COUNT("id")', 'total'))
                    ->from('events')
                    ->execute()
                    ->as_array();

            // Assign GeoJSON to the data
            $features = array();
            $idx = 0;
            foreach ($mappings AS $mapping)
            {
                if ($idx == 5)
                    break;
                $idx++;


                // Get district info
                $sql = "
                    SELECT *, COUNT(id) AS total
                    FROM events
                    WHERE district_id = :district_id
                    AND DATE(start_at) > CURDATE()
                    ORDER BY DATE(start_at) ASC
                    LIMIT 1
                    ;";
                $mapping_events = DB::query(Database::SELECT, $sql)
                        ->bind(':district_id', $mapping['id'])
                        ->execute()
                        ->as_array();

                // Calculate proportions
                $proportion = 0;
                if (!empty($mapping_events[0]['total']) AND !empty($count_result[0]['total']))
                    $proportion = round(($mapping_events[0]['total'] * 100) / $count_result[0]['total']);

                // Retrieve event info
                $event_info = FALSE;
                if (!empty($mapping_events[0]['name']) AND !empty($mapping_events[0]['address']) AND !empty($mapping_events[0]['start_at']))
                {
                    $event_info = array(
                        'name' => trim($mapping_events[0]['name']),
                        'address' => trim($mapping_events[0]['address']),
                        'start_at' => date('Y-m-d', strtotime($mapping_events[0]['start_at']))
                    );
                }

                $features[] = array(
                    'type' => 'Feature',
                    'properties' => array(
                        //'region' => $mapping['region_ka'],
                        'district' => $mapping['district_ka'],
                        'proportion' => $proportion,
                        'event' => $event_info
                    ),
                    'geometry' => unserialize($mapping['geometry'])
                );
            }
            $mappings = $features;
        }
        exit(json_encode(array(
                    'type' => 'FeatureCollection',
                    'features' => $mappings
                )));
    }

    private function draw_calendar($month, $year)
    {
        /* draw table */
        $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

        /* table headings */
        $headings = array('ორშაბათი', 'სამშაბათი', 'ოთხშაბათი', 'ხუთშაბათი', 'პარასკევი', 'შაბათი', 'კვირა');
        $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';

        /* days and weeks vars now ... */
        $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
        if ($running_day != 0)
            $running_day--;
        $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
        $days_in_this_week = 1;
        $day_counter = 0;
        $dates_array = array();

        /* row for week one */
        $calendar.= '<tr class="calendar-row">';

        /* print "blank" days until the first of the current week */
        for ($x = 0; $x < $running_day; $x++):
            $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
            $days_in_this_week++;
        endfor;

        /* keep going with days.... */
        list($nyear, $nmonth, $nday) = explode('-', date("Y-m-d"));
        for ($list_day = 1; $list_day <= $days_in_month; $list_day++):
            $today = ($list_day == $nday AND $month == $nmonth AND $year == $nyear) ? ' style="background-color:#A0A0A0;" title="today"' : NULL;
            $calendar.= '<td class="calendar-day"' . $today . '>';
            /* add in the day number */
            $calendar.= '<div class="day-number">' . $list_day . '</div>';

            /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! * */
            $date = $year . "-";
            $date.= ( $month < 10 AND strlen($month) == 1) ? "0" . $month . "-" : $month . "-";
            $date.= ( $list_day < 10 AND strlen($list_day) == 1) ? "0" . $list_day : $list_day;
            $events = $this->get_events_for_date($date);
            foreach ($events as $event)
                $calendar .= "
	      		<a href='" . URL::site('events/index#event' . $event['id']) . "' class='eventlink'>" .
                        substr($event['start_at'], 11, 5) . "<br />" . $event['name'] . "
	      		 </a>
	      	";
            //$calendar.= str_repeat('<p></p>',2);

            $calendar.= '</td>';
            if ($running_day == 6):
                $calendar.= '</tr>';
                if (($day_counter + 1) != $days_in_month):
                    $calendar.= '<tr class="calendar-row">';
                endif;
                $running_day = -1;
                $days_in_this_week = 0;
            endif;
            $days_in_this_week++;
            $running_day++;
            $day_counter++;
        endfor;

        /* finish the rest of the days in the week */
        if ($days_in_this_week < 8):
            for ($x = 1; $x <= (8 - $days_in_this_week); $x++):
                $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
            endfor;
        endif;

        /* final row */
        $calendar.= '</tr>';

        /* end the table */
        $calendar.= '</table>';

        /* all done, return result */
        return $calendar;
    }

    private function get_events_for_date($date)
    {
        $query = DB::select()->from('events')->where('start_at', 'LIKE', "%" . $date . "%");
        return $this->db->query(Database::SELECT, $query)->as_array();
    }

    private function get_unique_event_years()
    {
        $sql = "SELECT DISTINCT YEAR(`start_at`) AS `year` FROM `events` ORDER BY `start_at` DESC;";
        $result = $this->db->query(Database::SELECT, $sql)->as_array();
        $years = array();
        if (empty($result))
            $years[] = date('Y');
        else
        {
            foreach ($result AS $item)
                $years[] = $item['year'];
        }
        return $years;
    }

    function action_to_geo()
    {

        function to_geo($text)
        {
            $alphabet = array(
                'latin' => array('a', 'b', 'g', 'd', 'e', 'v', 'z', 't', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'zh', 'r', 's', 't', 'u', 'f', 'q', 'gh', 'y', 'sh', 'ch', 'ts', 'dz', 'w', 'ch', 'kh', 'j', 'h'),
                'unicode' => array('ა', 'ბ', 'გ', 'დ', 'ე', 'ვ', 'ზ', 'თ', 'ი', 'კ', 'ლ', 'მ', 'ნ', 'ო', 'პ', 'ჟ', 'რ', 'ს', 'ტ', 'უ', 'ფ', 'ქ', 'ღ', 'ყ', 'შ', 'ჩ', 'ც', 'ძ', 'წ', 'ჭ', 'ხ', 'ჯ', 'ჰ')
            );
            return str_replace($alphabet['latin'], $alphabet['unicode'], $text);
        }

        $sql = "SELECT * FROM mapping;";
        $result = $this->db->query(Database::SELECT, $sql)->as_array();
        foreach ($result AS $item)
        {
            $lowered = strtolower($item['district_ka'][0]);
            DB::update('mapping')
                    ->set(array('district_ka' => to_geo($lowered)))
                    ->where('district_ka', '=', $item['district_ka'])
                    ->execute();
        }
    }

    public function action_districts_blue()
    {

$json = '
{
"type": "FeatureCollection",
                                                                                
"features": [
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1034, "NAME_1": "Abkhazia", "ID_2": 14128, "NAME_2": "Gagra", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.AB.GG", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.81627706875, "Shape_Area": 0.124431462621 }, "geometry": { "type": "LineString", "coordinates": [ [ 40.425495085131416, 43.160368276436699 ], [ 40.409112141315994, 43.191905443281392 ], [ 40.434710491027587, 43.241668635120739 ], [ 40.426109445524496, 43.271874687780432 ], [ 40.440956488357223, 43.294708415723179 ], [ 40.447714452681083, 43.338942364024824 ], [ 40.488569418820795, 43.37887578957492 ], [ 40.4998326926939, 43.405088499679593 ], [ 40.482528208288862, 43.473282503311296 ], [ 40.462254315317274, 43.491508528305957 ], [ 40.503109281456986, 43.4931468226875 ], [ 40.507102624011992, 43.529394085879126 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1034, "NAME_1": "Abkhazia", "ID_2": 14129, "NAME_2": "Gali", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.AB.GL", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.47428319959, "Shape_Area": 0.101566420723 }, "geometry": { "type": "LineString", "coordinates": [ [ 41.898936094531109, 42.806906263618927 ], [ 41.824905667165162, 42.761238807733434 ], [ 41.755482942747307, 42.78233184789579 ], [ 41.749339338816519, 42.744855863918012 ], [ 41.70705086509296, 42.74434389692378 ], [ 41.687084152317908, 42.729496854091046 ], [ 41.622064344050443, 42.717312039628325 ], [ 41.529705498290994, 42.668265601580899 ], [ 41.487007450972044, 42.658435835291648 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1034, "NAME_1": "Abkhazia", "ID_2": 14130, "NAME_2": "Gudauta", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.AB.GT", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 2.12046406533, "Shape_Area": 0.154067517005 }, "geometry": { "type": "LineString", "coordinates": [ [ 41.172966896710136, 42.7920592207862 ], [ 41.185766071565936, 42.804039248451225 ], [ 41.188428299935943, 42.840900872035931 ], [ 41.283858947660782, 42.885032426938729 ], [ 41.310071657765462, 42.957526953321981 ], [ 41.336693941465526, 42.973705110339715 ], [ 41.42987193441575, 42.993262249519375 ], [ 41.565133614291845, 43.001556114825931 ], [ 41.719747646549912, 43.066678316492244 ], [ 41.978905339030149, 43.047325964110271 ], [ 42.037883936765674, 43.069238151463402 ], [ 42.129526028733203, 43.146135593997052 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1034, "NAME_1": "Abkhazia", "ID_2": 14131, "NAME_2": "Gulripshi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.AB.GP", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 2.9247005314, "Shape_Area": 0.233619556644 }, "geometry": { "type": "LineString", "coordinates": [ [ 41.331471878124361, 43.332696366695188 ], [ 41.314884147511243, 43.287131304208543 ], [ 41.284473308053862, 43.273512982161975 ], [ 41.218736745994477, 43.204499831339497 ], [ 41.202251408780207, 43.166307093569792 ], [ 41.18013443462938, 43.031147807092545 ], [ 41.077945822580674, 42.951895316385432 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1034, "NAME_1": "Abkhazia", "ID_2": 14132, "NAME_2": "Ochamchire", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.AB.OC", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 2.70747378487, "Shape_Area": 0.192293358111 }, "geometry": { "type": "LineString", "coordinates": [ [ 40.895173605639854, 43.049476225486046 ], [ 40.928861033860315, 43.089716831232685 ], [ 40.922717429929534, 43.115519967741974 ], [ 40.892920950865232, 43.121253998077378 ], [ 40.907460813501416, 43.148900215765906 ], [ 40.899678915189092, 43.173884205084427 ], [ 40.865684306772089, 43.20849317389451 ], [ 40.862305324610155, 43.252727122196156 ], [ 40.829129863383926, 43.281294880474299 ], [ 40.780492998931884, 43.279758979491604 ], [ 40.735951870433702, 43.296653890301258 ], [ 40.773632641209176, 43.360752157979107 ], [ 40.721104827600968, 43.459459394467032 ], [ 40.743119408352946, 43.47533037128823 ], [ 40.781926506515731, 43.477890206259389 ], [ 40.802302792886167, 43.498676066225208 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1034, "NAME_1": "Abkhazia", "ID_2": 14133, "NAME_2": "Sokhumi", "VARNAME_2": "Sukhumi", "NL_NAME_2": null, "HASC_2": "GE.AB.SU", "CC_2": null, "TYPE_2": "K\'alak\'i", "ENGTYPE_2": "City", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 2.13258350885, "Shape_Area": 0.168483848556 }, "geometry": { "type": "LineString", "coordinates": [ [ 41.934671390728504, 41.510093867229273 ], [ 41.878252627964137, 41.546033950224356 ], [ 41.754868582354227, 41.549105752189753 ], [ 41.738895212134189, 41.600916812006027 ], [ 41.805246134586653, 41.628870209891097 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1035, "NAME_1": "Ajaria", "ID_2": 14134, "NAME_2": "Batumi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.AJ.BT", "CC_2": null, "TYPE_2": "K\'alak\'i", "ENGTYPE_2": "City", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.28751947889, "Shape_Area": 0.045515130445 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.079250869899617, 41.698804901303184 ], [ 42.03747436317029, 41.699931228690495 ], [ 41.999076838602889, 41.717645286690924 ], [ 41.952692628925469, 41.710068175176289 ], [ 41.907127566438824, 41.65436616620385 ], [ 41.805246134586653, 41.628870209891097 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1035, "NAME_1": "Ajaria", "ID_2": 14135, "NAME_2": "Keda", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.AJ.KD", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.02058302523, "Shape_Area": 0.049236007556 }, "geometry": { "type": "LineString", "coordinates": [ [ 41.805246134586653, 41.628870209891097 ], [ 41.785074635013913, 41.662864818308101 ], [ 41.752308747383069, 41.662250457915022 ], [ 41.703159915936794, 41.689896675603549 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1035, "NAME_1": "Ajaria", "ID_2": 14136, "NAME_2": "Khulo", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.AJ.KL", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.19005308319, "Shape_Area": 0.0745692132165 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.306052248344393, 41.777954998611456 ], [ 42.30369720017093, 41.755326057466398 ], [ 42.242670734458478, 41.708327487395898 ], [ 42.251476566759266, 41.684060251869305 ], [ 42.237243884319618, 41.667370127857339 ], [ 42.259360858470437, 41.606855629139119 ], [ 42.27748449006625, 41.589243964537538 ], [ 42.469881686498638, 41.499956920743479 ], [ 42.494456102221775, 41.464938378338012 ], [ 42.51135101303143, 41.466986246314939 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1035, "NAME_1": "Ajaria", "ID_2": 14137, "NAME_2": "Kobuleti", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.AJ.KB", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.41690862348, "Shape_Area": 0.0738878406805 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.086418407818869, 41.51152737481312 ], [ 42.091538077761186, 41.557706797692845 ], [ 42.076588641529611, 41.583509934202141 ], [ 42.106589907391609, 41.627948669301475 ], [ 42.107921021576615, 41.656721214377313 ], [ 42.079250869899617, 41.698804901303184 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1035, "NAME_1": "Ajaria", "ID_2": 14138, "NAME_2": "Shuakhevi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.AJ.SH", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.54402692682, "Shape_Area": 0.0642182127855 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.079250869899617, 41.698804901303184 ], [ 42.116112493484323, 41.710580142170521 ], [ 42.130549962721666, 41.756145204657173 ], [ 42.182258629139099, 41.766691724738351 ], [ 42.202737308908382, 41.794235549028031 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1036, "NAME_1": "Guria", "ID_2": 14139, "NAME_2": "Chokhatauri", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.GU.CK", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.46244646447, "Shape_Area": 0.083741335584 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.306052248344393, 41.803553348323057 ], [ 42.306052248344393, 41.777954998611456 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1036, "NAME_1": "Guria", "ID_2": 14140, "NAME_2": "Lanchkhuti", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.GU.LK", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.71072832909, "Shape_Area": 0.058011126 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.481656927365975, 41.798740858577276 ], [ 42.439470847041257, 41.800174366161123 ], [ 42.394212964751148, 41.838674284127372 ], [ 42.364314092287998, 41.837445563341213 ], [ 42.306052248344393, 41.803553348323057 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1036, "NAME_1": "Guria", "ID_2": 14141, "NAME_2": "Ozurgeti", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.GU.OZ", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.3837646018, "Shape_Area": 0.06751407211 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.306052248344393, 41.803553348323057 ], [ 42.254855548921199, 41.804167708716129 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1037, "NAME_1": "Imereti", "ID_2": 14142, "NAME_2": "Bagdati", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.IM.BG", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.55328180212, "Shape_Area": 0.0849348929745 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.203863636295686, 42.070492939115617 ], [ 42.16321345695367, 42.070697725913313 ], [ 42.121744130420879, 42.04960468575095 ], [ 42.11682924727625, 42.00854493281355 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1037, "NAME_1": "Imereti", "ID_2": 14143, "NAME_2": "Chiatura", "VARNAME_2": "Tchiatura", "NL_NAME_2": null, "HASC_2": "GE.IM.CT", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.11092992892, "Shape_Area": 0.0592881441915 }, "geometry": { "type": "LineString", "coordinates": [ [ 41.986892024140168, 42.000353460905835 ], [ 42.009316178487531, 41.98233222270887 ], [ 42.032149906430277, 41.991138055009657 ], [ 42.048737637043395, 42.015917257530489 ], [ 42.085496867229253, 41.998715166524292 ], [ 42.11682924727625, 42.00854493281355 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1037, "NAME_1": "Imereti", "ID_2": 14144, "NAME_2": "Kharagauli", "VARNAME_2": "Xaragauli", "NL_NAME_2": null, "HASC_2": "GE.IM.KG", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.3474426431, "Shape_Area": 0.0922719541655 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.11682924727625, 42.00854493281355 ], [ 42.154305231254028, 41.985301631275412 ], [ 42.163725423947902, 41.948440007690706 ], [ 42.262739840632371, 41.87246410574668 ], [ 42.268678657765463, 41.84553464185008 ], [ 42.254855548921199, 41.804167708716129 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1037, "NAME_1": "Imereti", "ID_2": 14145, "NAME_2": "Khoni", "VARNAME_2": "Xoni", "NL_NAME_2": "????", "HASC_2": "GE.IM.KN", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.06321321839, "Shape_Area": 0.042809949704 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.254855548921199, 41.804167708716129 ], [ 42.202737308908382, 41.794235549028031 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1037, "NAME_1": "Imereti", "ID_2": 14146, "NAME_2": "Kutaisi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.IM.KT", "CC_2": null, "TYPE_2": "K\'alak\'i", "ENGTYPE_2": "City", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 0.146472319604, "Shape_Area": 0.001271801997 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.202737308908382, 41.794235549028031 ], [ 42.190450101046814, 41.813485508011155 ], [ 42.162291916364047, 41.823724847895797 ], [ 42.06307271288189, 41.808877805063069 ], [ 42.055495601367255, 41.82474878188426 ], [ 42.01668850320447, 41.833452220786199 ], [ 41.995493069643267, 41.851063885387781 ], [ 41.949928007156615, 41.852906966567019 ], [ 41.946753811792377, 41.881679511642858 ], [ 41.919926741294624, 41.894683473296347 ], [ 41.770432378978882, 41.902772551805214 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1037, "NAME_1": "Imereti", "ID_2": 14147, "NAME_2": "Sachkhere", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.IM.SC", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.52399997232, "Shape_Area": 0.092575147731 }, "geometry": { "type": "LineString", "coordinates": [ [ 41.756814056932306, 42.007520998825086 ], [ 41.774425721533888, 41.996257724951981 ], [ 41.850708803674458, 42.009876046998549 ], [ 41.896683439756487, 41.998305592928908 ], [ 41.972249768105129, 42.028921219183978 ], [ 41.986892024140168, 42.000353460905835 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1037, "NAME_1": "Imereti", "ID_2": 14148, "NAME_2": "Samtredia", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.IM.SM", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.13411293619, "Shape_Area": 0.0353356027785 }, "geometry": { "type": "LineString", "coordinates": [ [ 43.358144421491154, 42.102132499359158 ], [ 43.423983376949394, 42.125375800897288 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1037, "NAME_1": "Imereti", "ID_2": 14149, "NAME_2": "Terjola", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.IM.TJ", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 0.982024630791, "Shape_Area": 0.037344653939 }, "geometry": { "type": "LineString", "coordinates": [ [ 43.099601089403997, 41.832940253791968 ], [ 43.092945518478977, 41.870621024567448 ], [ 43.055469534501199, 41.92192011738949 ], [ 42.987787497863728, 41.977724519760777 ], [ 42.994545462187588, 42.008237752617006 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1037, "NAME_1": "Imereti", "ID_2": 14150, "NAME_2": "Tkibuli", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.IM.TQ", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.11752271231, "Shape_Area": 0.051004743225 }, "geometry": { "type": "LineString", "coordinates": [ [ 43.198001145695386, 42.109709610873793 ], [ 43.280223044969048, 42.129471536851142 ], [ 43.358144421491154, 42.102132499359158 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1037, "NAME_1": "Imereti", "ID_2": 14151, "NAME_2": "Tskaltubo", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.IM.TS", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.5151200882, "Shape_Area": 0.0764292784015 }, "geometry": { "type": "LineString", "coordinates": [ [ 43.490539086199554, 42.065680449369836 ], [ 43.449888906857531, 42.088309390514894 ], [ 43.423983376949394, 42.125375800897288 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1037, "NAME_1": "Imereti", "ID_2": 14152, "NAME_2": "Vani", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.IM.VA", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.20163505273, "Shape_Area": 0.0602018123385 }, "geometry": { "type": "LineString", "coordinates": [ [ 43.423983376949394, 42.125375800897288 ], [ 43.425212097735546, 42.159882376308524 ], [ 43.401252042405488, 42.179439515488191 ], [ 43.392446210104701, 42.206471372783639 ], [ 43.362752124439247, 42.223571070390989 ], [ 43.375551299295047, 42.2516268616749 ], [ 43.336334627536871, 42.290536353236533 ], [ 43.328245549028004, 42.337842103503569 ], [ 43.268550197500559, 42.370915171330957 ], [ 43.249505025315123, 42.410643810083357 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1037, "NAME_1": "Imereti", "ID_2": 14153, "NAME_2": "Zestaponi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.IM.ZP", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.17010050312, "Shape_Area": 0.044849885828 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.377420447340334, 42.220089694830207 ], [ 42.441518715018184, 42.231148181905617 ], [ 42.473772635654797, 42.21998730143136 ], [ 42.493227381435617, 42.225209364772532 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1038, "NAME_1": "Kakheti", "ID_2": 14154, "NAME_2": "Akhmeta", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.KA.AM", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 2.66882361701, "Shape_Area": 0.247887647058 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.386635853236513, 42.044894589404016 ], [ 42.327145288506756, 42.050833406537109 ], [ 42.294481794274752, 42.031378660756296 ], [ 42.220758547105348, 42.048068784768255 ], [ 42.203863636295686, 42.070492939115617 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1038, "NAME_1": "Kakheti", "ID_2": 14155, "NAME_2": "Dedoplis Tskaro", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.KA.DD", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 2.74207433117, "Shape_Area": 0.276189960443 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.203863636295686, 42.070492939115617 ], [ 42.206730651463388, 42.084418441358729 ], [ 42.229052412411903, 42.097217616214529 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1038, "NAME_1": "Kakheti", "ID_2": 14156, "NAME_2": "Gurjaani", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.KA.GJ", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.34919562761, "Shape_Area": 0.0906452262805 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.31475568724634, 42.250807714484132 ], [ 42.336872661397166, 42.250090960692205 ], [ 42.377420447340334, 42.220089694830207 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1038, "NAME_1": "Kakheti", "ID_2": 14157, "NAME_2": "Kvareli", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.KA.QV", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.46630459584, "Shape_Area": 0.102298680108 }, "geometry": { "type": "LineString", "coordinates": [ [ 43.092945518478977, 42.263709282738773 ], [ 43.100113056398229, 42.225721331766763 ], [ 43.118851048387121, 42.205037865199792 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1038, "NAME_1": "Kakheti", "ID_2": 14158, "NAME_2": "Lagodekhi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.KA.LG", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.56369747584, "Shape_Area": 0.100195614304 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.750337205938926, 42.166947520828927 ], [ 42.720540726874624, 42.166537947233543 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1038, "NAME_1": "Kakheti", "ID_2": 14159, "NAME_2": "Sagarejo", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.KA.SG", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 2.04051704787, "Shape_Area": 0.159577093948 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.702929062273043, 42.220089694830207 ], [ 42.724226889233094, 42.245688044541808 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1038, "NAME_1": "Kakheti", "ID_2": 14160, "NAME_2": "Signagi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.KA.SI", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 2.50579359082, "Shape_Area": 0.14281243457 }, "geometry": { "type": "LineString", "coordinates": [ [ 43.121718063554816, 42.34439528102974 ], [ 43.109328462294407, 42.288590878658454 ], [ 43.092945518478977, 42.263709282738773 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1038, "NAME_1": "Kakheti", "ID_2": 14161, "NAME_2": "Telavi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.KA.TE", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.89335001722, "Shape_Area": 0.128896931645 }, "geometry": { "type": "LineString", "coordinates": [ [ 43.092945518478977, 42.263709282738773 ], [ 43.044103867229246, 42.248145486114126 ], [ 42.973350028626385, 42.267497838496091 ], [ 42.875154759132691, 42.241387521790259 ], [ 42.787096436124784, 42.257258498611449 ], [ 42.724226889233094, 42.245688044541808 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1039, "NAME_1": "Kvemo Kartli", "ID_2": 14162, "NAME_2": "Bolnisi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.KK.BL", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.5349508239, "Shape_Area": 0.088230870012 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.724226889233094, 42.245688044541808 ], [ 42.717980891903466, 42.275279736808422 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1039, "NAME_1": "Kvemo Kartli", "ID_2": 14163, "NAME_2": "Dmanisi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.KK.DM", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.79829648715, "Shape_Area": 0.12315070085 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.865734566438817, 42.451498776223076 ], [ 42.806551181905597, 42.392315391689856 ], [ 42.726479544007717, 42.381256904614446 ], [ 42.745729502990841, 42.313472474578127 ], [ 42.717980891903466, 42.275279736808422 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1039, "NAME_1": "Kvemo Kartli", "ID_2": 14164, "NAME_2": "Gardabani", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.KK.GD", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 2.5929495843, "Shape_Area": 0.140005427005 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.717980891903466, 42.275279736808422 ], [ 42.682347989104919, 42.252957975859907 ], [ 42.702929062273043, 42.220089694830207 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1039, "NAME_1": "Kvemo Kartli", "ID_2": 14165, "NAME_2": "Marneuli", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.KK.MN", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.92768298156, "Shape_Area": 0.102160350065 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.702929062273043, 42.220089694830207 ], [ 42.703441029267275, 42.184149611835124 ], [ 42.720540726874624, 42.166537947233543 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1039, "NAME_1": "Kvemo Kartli", "ID_2": 14166, "NAME_2": "Tetri Tskaro", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.KK.TR", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.74649568024, "Shape_Area": 0.117495248673 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.720540726874624, 42.166537947233543 ], [ 42.695966311151487, 42.119846557359587 ], [ 42.655930492202543, 42.103566006943005 ], [ 42.64384807113867, 42.085032801751808 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1039, "NAME_1": "Kvemo Kartli", "ID_2": 14167, "NAME_2": "Tsalka", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.KK.TK", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.59729503336, "Shape_Area": 0.109745043582 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.52046402552876, 42.097320009613377 ], [ 42.522819073702223, 42.128140422666142 ], [ 42.49117951345869, 42.133567272805003 ], [ 42.483295221747518, 42.14841431563773 ], [ 42.441928288613568, 42.144318579683876 ], [ 42.497630297586014, 42.195105705511686 ], [ 42.493227381435617, 42.225209364772532 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1040, "NAME_1": "Mtskheta-Mtianeti", "ID_2": 14168, "NAME_2": "Akhalgori", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.MM.AG", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.70192037924, "Shape_Area": 0.104213946352 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.493227381435617, 42.225209364772532 ], [ 42.504081081713331, 42.251422074877205 ], [ 42.488517285088683, 42.290741140034228 ], [ 42.535515855159176, 42.333234400555483 ], [ 42.527529170049156, 42.372655859111347 ], [ 42.609341495727435, 42.395899160649478 ], [ 42.632072830271333, 42.435525406003038 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1040, "NAME_1": "Mtskheta-Mtianeti", "ID_2": 14169, "NAME_2": "Dusheti", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.MM.DU", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 3.26709460271, "Shape_Area": 0.332968294777 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.867065680623824, 42.455082545182698 ], [ 42.865734566438817, 42.451498776223076 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1040, "NAME_1": "Mtskheta-Mtianeti", "ID_2": 14170, "NAME_2": "Kazbegi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.MM.QZ", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.74941171524, "Shape_Area": 0.14094995107 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.506436129886801, 42.093429060457211 ], [ 42.52046402552876, 42.097320009613377 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1040, "NAME_1": "Mtskheta-Mtianeti", "ID_2": 14171, "NAME_2": "Mtskheta", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.MM.MK", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.75651631238, "Shape_Area": 0.0909873798365 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.52046402552876, 42.097320009613377 ], [ 42.555892141529611, 42.085851948942576 ], [ 42.64384807113867, 42.085032801751808 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1040, "NAME_1": "Mtskheta-Mtianeti", "ID_2": 14172, "NAME_2": "Tianeti", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.MM.TI", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.83950050089, "Shape_Area": 0.096208736892 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.64384807113867, 42.085032801751808 ], [ 42.714909089938068, 42.063427794595214 ], [ 42.732520754539649, 42.039774919461699 ], [ 42.769279984725507, 42.027692498397826 ], [ 42.792932859859029, 41.992878742790047 ], [ 42.735899736701583, 41.919360282418332 ], [ 42.708458305810751, 41.86273673285627 ], [ 42.712554041764605, 41.833657007583895 ], [ 42.678354646549906, 41.809696952253837 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1041, "NAME_1": "Racha-Lechkhumi-Kvemo Svaneti", "ID_2": 14173, "NAME_2": "Ambrolauri", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.RK.AL", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.65522392328, "Shape_Area": 0.120944717564 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.649684494872915, 41.833452220786199 ], [ 42.643643284340975, 41.912602318094471 ], [ 42.630536929288638, 41.929087655308741 ], [ 42.55845197650077, 41.932876211066059 ], [ 42.472851095065181, 41.974652717795387 ], [ 42.420016101260437, 41.984892057680028 ], [ 42.386635853236513, 42.044894589404016 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1041, "NAME_1": "Racha-Lechkhumi-Kvemo Svaneti", "ID_2": 14174, "NAME_2": "Lentekhi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.RK.LE", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 2.41928440257, "Shape_Area": 0.159486047045 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.386635853236513, 42.044894589404016 ], [ 42.387250213629592, 42.065066088976756 ], [ 42.402506830057703, 42.0781724440291 ], [ 42.389195688207671, 42.116877148793037 ], [ 42.506436129886801, 42.093429060457211 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1041, "NAME_1": "Racha-Lechkhumi-Kvemo Svaneti", "ID_2": 14175, "NAME_2": "Oni", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.RK.ON", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 2.24556440746, "Shape_Area": 0.217773215762 }, "geometry": { "type": "LineString", "coordinates": [ [ 43.118851048387121, 42.205037865199792 ], [ 43.161856275902608, 42.204116324610169 ], [ 43.205475863811174, 42.182818497650118 ], [ 43.211312287545418, 42.158448868724676 ], [ 43.186021118030361, 42.13561514078193 ], [ 43.198001145695386, 42.109709610873793 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1041, "NAME_1": "Racha-Lechkhumi-Kvemo Svaneti", "ID_2": 14176, "NAME_2": "Tsageri", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.RK.TG", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.4858175817, "Shape_Area": 0.0766335169945 }, "geometry": { "type": "LineString", "coordinates": [ [ 43.198001145695386, 42.109709610873793 ], [ 43.196260457914995, 42.067933104144458 ], [ 43.05055465135657, 42.017350765114337 ], [ 42.994545462187588, 42.008237752617006 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1042, "NAME_1": "Samegrelo-Zemo Svaneti", "ID_2": 14177, "NAME_2": "Abasha", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SZ.AS", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 0.870553331733, "Shape_Area": 0.031542289927 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.994545462187588, 42.008237752617006 ], [ 42.976524223990623, 42.039262952467467 ], [ 42.912323562913933, 42.050219046144029 ], [ 42.872799710959221, 42.110426364665713 ], [ 42.758938251442025, 42.140222843730015 ], [ 42.750337205938926, 42.166947520828927 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1042, "NAME_1": "Samegrelo-Zemo Svaneti", "ID_2": 14178, "NAME_2": "Chkhorotsku", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SZ.CQ", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.36549129817, "Shape_Area": 0.0709413898645 }, "geometry": { "type": "LineString", "coordinates": [ [ 42.750337205938926, 42.166947520828927 ], [ 42.867168074022672, 42.15814168852814 ], [ 42.912221169515085, 42.131724191625764 ], [ 42.951540234672102, 42.131109831232685 ], [ 43.024751514847281, 42.172886337962019 ], [ 43.099805876201692, 42.178517974898568 ], [ 43.118851048387121, 42.205037865199792 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1042, "NAME_1": "Samegrelo-Zemo Svaneti", "ID_2": 14179, "NAME_2": "Khobi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SZ.KH", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.81893521052, "Shape_Area": 0.073619905846 }, "geometry": { "type": "LineString", "coordinates": [ [ 45.93057378070926, 41.801300693548434 ], [ 45.837293394360195, 41.836933596346981 ], [ 45.809032816278588, 41.862941519653965 ], [ 45.726401343409542, 41.900519897030591 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1042, "NAME_1": "Samegrelo-Zemo Svaneti", "ID_2": 14180, "NAME_2": "Martvili", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SZ.MV", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.53650392725, "Shape_Area": 0.0911486098695 }, "geometry": { "type": "LineString", "coordinates": [ [ 45.994364868190573, 41.709760994979753 ], [ 45.975934056398216, 41.743857996795604 ], [ 45.935181483657352, 41.760957694402954 ], [ 45.93057378070926, 41.801300693548434 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1042, "NAME_1": "Samegrelo-Zemo Svaneti", "ID_2": 14181, "NAME_2": "Mestia", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SZ.MS", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 3.49120490861, "Shape_Area": 0.376724314602 }, "geometry": { "type": "LineString", "coordinates": [ [ 45.93057378070926, 41.801300693548434 ], [ 45.951052460478543, 41.82782058384965 ], [ 45.99272657380903, 41.845739428647768 ], [ 46.088873975325797, 41.852394999572788 ], [ 46.090921843302723, 41.889461409955182 ], [ 46.122049436552032, 41.933183391262595 ], [ 46.100854002990829, 41.992469169194663 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1042, "NAME_1": "Samegrelo-Zemo Svaneti", "ID_2": 14182, "NAME_2": "Senaki", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SZ.SN", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.37584443335, "Shape_Area": 0.058139903249 }, "geometry": { "type": "LineString", "coordinates": [ [ 45.212898448194842, 41.898369635654824 ], [ 45.236960896923748, 41.878812496475156 ], [ 45.280580484832313, 41.872156925550144 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1042, "NAME_1": "Samegrelo-Zemo Svaneti", "ID_2": 14183, "NAME_2": "Tsalenjikha", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SZ.TL", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.25218674509, "Shape_Area": 0.0666911738585 }, "geometry": { "type": "LineString", "coordinates": [ [ 45.527143789254445, 41.801812660542666 ], [ 45.555404367336052, 41.738226359859048 ], [ 45.608853721533876, 41.710170568575137 ], [ 45.63854780719933, 41.679247762123524 ], [ 45.649401507477052, 41.644434006515745 ], [ 45.598716775048082, 41.593339700491391 ], [ 45.666194024887858, 41.537023331125873 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1042, "NAME_1": "Samegrelo-Zemo Svaneti", "ID_2": 14184, "NAME_2": "Zugdidi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SZ.ZG", "CC_2": null, "TYPE_2": "K\'alak\'i", "ENGTYPE_2": "City", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.50185363654, "Shape_Area": 0.068437699056 }, "geometry": { "type": "Polygon", "coordinates": [ [ 46.204066549027999, 41.636037747810342 ], [ 46.271236618671239, 41.624876867336084 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1043, "NAME_1": "Samtskhe-Javakheti", "ID_2": 14185, "NAME_2": "Adigeni", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SJ.AD", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.36702467696, "Shape_Area": 0.0829835699985 }, "geometry": { "type": "LineString", "coordinates": [ [ 46.409979674108108, 41.475177718222646 ], [ 46.341273703482173, 41.437906521042557 ], [ 46.304616866695163, 41.433913178487551 ], [ 46.27307969985047, 41.449476975112205 ], [ 46.274820387630861, 41.48766971288191 ], [ 46.149183687246328, 41.489717580858837 ], [ 46.076074800469996, 41.511117801217736 ], [ 46.020679971694094, 41.566717416791327 ], [ 45.966923437299734, 41.563645614825937 ], [ 45.915317164281149, 41.538047265114336 ], [ 45.911938182119215, 41.513677636188895 ], [ 45.887670946592621, 41.498421019760784 ], [ 45.870878429181815, 41.465040771736852 ], [ 45.853778731574465, 41.370736451399324 ], [ 45.880093835077986, 41.343499807306181 ], [ 45.874257411343741, 41.325478569109215 ], [ 45.849682995620604, 41.312884181051103 ], [ 45.847123160649446, 41.283087701986801 ], [ 45.770942471907723, 41.240082474471315 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1043, "NAME_1": "Samtskhe-Javakheti", "ID_2": 14186, "NAME_2": "Akhalkalaki", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SJ.AK", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 2.11607238059, "Shape_Area": 0.132549080368 }, "geometry": { "type": "LineString", "coordinates": [ [ 45.548236829416808, 41.410362696752877 ], [ 45.571377737556091, 41.448555434522582 ], [ 45.611311163106187, 41.47118437566764 ], [ 45.666194024887858, 41.537023331125873 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1043, "NAME_1": "Samtskhe-Javakheti", "ID_2": 14187, "NAME_2": "Akhaltsikhe", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SJ.AT", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.58080364921, "Shape_Area": 0.102469437863 }, "geometry": { "type": "LineString", "coordinates": [ [ 45.666194024887858, 41.537023331125873 ], [ 45.68616073766291, 41.543064541657813 ], [ 45.695683323755624, 41.560778599658242 ], [ 45.758348083849619, 41.566307843195943 ], [ 45.818453008972455, 41.613204019867595 ], [ 45.883165637043383, 41.641464597949202 ], [ 45.92012965402693, 41.675766386562749 ], [ 45.961906160756264, 41.687029660435847 ], [ 45.994364868190573, 41.709760994979753 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1043, "NAME_1": "Samtskhe-Javakheti", "ID_2": 14188, "NAME_2": "Aspindza", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SJ.AZ", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.55424257754, "Shape_Area": 0.090094305875 }, "geometry": { "type": "LineString", "coordinates": [ [ 45.994364868190573, 41.709760994979753 ], [ 46.026106821832954, 41.690715822794324 ], [ 46.204066549027999, 41.636037747810342 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1043, "NAME_1": "Samtskhe-Javakheti", "ID_2": 14189, "NAME_2": "Borjomi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SJ.BR", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.84793880943, "Shape_Area": 0.126866792447 }, "geometry": { "type": "LineString", "coordinates": [ [ 45.542502799081404, 42.206164192587096 ], [ 45.606703460158101, 42.217837040055585 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1043, "NAME_1": "Samtskhe-Javakheti", "ID_2": 14190, "NAME_2": "Ninotsminda", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SJ.NI", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.8582333266, "Shape_Area": 0.14877495428 }, "geometry": { "type": "LineString", "coordinates": [ [ 45.755685855479612, 42.137253435163473 ], [ 45.68616073766291, 42.067011563554843 ], [ 45.564414986434535, 42.013664602755867 ], [ 45.57393757252725, 41.983868123691565 ], [ 45.65626186519976, 41.953354890835335 ], [ 45.68257696870328, 41.922944051377954 ], [ 45.726401343409542, 41.900519897030591 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1044, "NAME_1": "Shida Kartli", "ID_2": 14191, "NAME_2": "Gori", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SD.GR", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 2.86582733688, "Shape_Area": 0.246006537954 }, "geometry": { "type": "LineString", "coordinates": [ [ 45.726401343409542, 41.900519897030591 ], [ 45.641312428968185, 41.842155659688146 ], [ 45.527143789254445, 41.801812660542666 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1044, "NAME_1": "Shida Kartli", "ID_2": 14192, "NAME_2": "Java", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SD.JV", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.9284880889, "Shape_Area": 0.113235874525 }, "geometry": { "type": "LineString", "coordinates": [ [ 45.527143789254445, 41.801812660542666 ], [ 45.451270280709267, 41.80590839649652 ], [ 45.381847556291405, 41.790446993270713 ], [ 45.329319742683204, 41.799560005768043 ], [ 45.297065822046584, 41.827411010254266 ], [ 45.280580484832313, 41.872156925550144 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1044, "NAME_1": "Shida Kartli", "ID_2": 14193, "NAME_2": "Kareli", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SD.KR", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.75972385194, "Shape_Area": 0.117669103416 }, "geometry": { "type": "LineString", "coordinates": [ [ 45.280580484832313, 41.872156925550144 ], [ 45.311196111087391, 41.878607709677468 ], [ 45.337101640995527, 41.899700749839823 ], [ 45.341197376949388, 41.932773817667211 ], [ 45.385431325251027, 41.962058329737282 ], [ 45.403145383251456, 41.992059595599279 ], [ 45.392394076372582, 42.080015525208331 ], [ 45.345907473296322, 42.14237310510579 ], [ 45.383076277077564, 42.205345045396328 ], [ 45.419118753471494, 42.216505925870585 ], [ 45.421064228049573, 42.261456627964158 ], [ 45.450655920316187, 42.272719901837256 ], [ 45.518645137150195, 42.253674729651827 ], [ 45.517928383358274, 42.225516544969068 ], [ 45.542502799081404, 42.206164192587096 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1044, "NAME_1": "Shida Kartli", "ID_2": 14194, "NAME_2": "Kaspi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SD.KP", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.45960772806, "Shape_Area": 0.0858624978275 }, "geometry": { "type": "LineString", "coordinates": [ [ 44.277227569536443, 41.432377277504855 ], [ 44.253677087801769, 41.406471747596711 ], [ 44.276920389339907, 41.376572875133569 ], [ 44.318799289468082, 41.363261733283537 ], [ 44.387198079897473, 41.362442586092762 ], [ 44.393956044221341, 41.341247152531558 ], [ 44.438497172719522, 41.321894800149586 ], [ 44.432148781991046, 41.295170123050681 ], [ 44.3879148336894, 41.269059806344849 ], [ 44.401737942533664, 41.250424207754804 ], [ 44.389757914868639, 41.214176944563178 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1044, "NAME_1": "Shida Kartli", "ID_2": 14195, "NAME_2": "Khashuri", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.SD.KS", "CC_2": null, "TYPE_2": "Raioni", "ENGTYPE_2": "District", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 1.09992766232, "Shape_Area": 0.0626736433105 }, "geometry": { "type": "LineString", "coordinates": [ [ 45.066271101046802, 41.83754795674006 ], [ 45.134260317880809, 41.765770184148735 ], [ 45.18914317966248, 41.765258217154503 ], [ 45.231431653386046, 41.651806331232692 ], [ 45.189962326853255, 41.609517857509125 ], [ 45.205116549882518, 41.58105249262983 ], [ 45.201123207327512, 41.559857059068619 ], [ 45.216789397351008, 41.540709493484343 ], [ 45.289591103930796, 41.531289300790476 ], [ 45.311708078081622, 41.516954224951981 ], [ 45.308533882717384, 41.496475545182697 ], [ 45.330036496475124, 41.46145700277723 ] ] } }
,
{ "type": "Feature", "properties": { "ID_0": 81, "ISO": "GEO", "NAME_0": "Georgia", "ID_1": 1045, "NAME_1": "Tbilisi", "ID_2": 14196, "NAME_2": "Tbilisi", "VARNAME_2": null, "NL_NAME_2": null, "HASC_2": "GE.TB.TB", "CC_2": null, "TYPE_2": "K\'alak\'i", "ENGTYPE_2": "City", "VALIDFR_2": "Unknown", "VALIDTO_2": "Present", "REMARKS_2": null, "Shape_Leng": 0.966844043898, "Shape_Area": 0.0255430360585 }, "geometry": { "type": "LineString", "coordinates": [ [ 44.560857284340969, 41.200763409314298 ], [ 44.553177779427493, 41.27458904988255 ], [ 44.582257504699868, 41.28431642277296 ], [ 44.59495428615682, 41.306228610126091 ], [ 44.649632361140796, 41.320051718970355 ], [ 44.663045896389676, 41.336229875988082 ], [ 44.692842375453978, 41.316365556611885 ], [ 44.764517754646462, 41.372374745780867 ], [ 44.771275718970323, 41.401249684255546 ], [ 44.757350216727211, 41.420090069643287 ], [ 44.770149391583011, 41.439442422025259 ], [ 44.758476544114522, 41.460433068788767 ], [ 44.734106915189081, 41.470365228476865 ] ] } }

]
}';

$dec = json_decode($json);

//die($json);
//die((string)count($dec->features));
print_r(serialize(json_decode($json)));die;
    }

}
