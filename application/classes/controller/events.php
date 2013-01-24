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

    public static function districts_sorted()
    {
        $tbilisi =  DB::select('id', 'name')
                ->from('districts')
                ->where('name', '=', 'თბილისი')
                ->or_where('name', '=', 'Tbilisi')
                ->execute()
                ->as_array();
        $districts =  DB::select('id', 'name')
                ->from('districts')
                ->where('language', '=', 'ka')
                ->and_where('parent', 'is', NULL)
                ->and_where('name', '!=', 'თბილისი')
                ->and_where('name', '!=', 'Tbilisi')
                ->order_by('name')
                ->execute()
                ->as_array();
        $districts = array_merge($tbilisi, $districts);
        foreach ($districts as &$d)
        {
            $indis = DB::select('id', 'name')
                            ->from('districts')
                            ->where('language', '=', 'ka')
                            ->and_where('parent', '=', $d['id'])
                            ->order_by('name')
                            ->execute()
                            ->as_array();
            empty($indis) or $d['districts'] = $indis;
        }
        return $districts;
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
        $this->template->content->allow_delete = $this->check_access('events', 'delete', FALSE);
    }

    public function action_view()
    {
        $id = $this->request->param('id');
        $event = DB::select('events.*', array('districts.name', 'district'))
                ->from('events')
                ->join('districts')
                ->on('events.district_id', '=', 'districts.id')
                ->where('events.id', '=', $id)
                ->execute()
                ->as_array();
        empty($event) and $this->request->redirect(URL::site('events'));;
        $this->template->content = View::factory('event');
        $this->template->content->event = $event[0];
        $this->template->content->allow_edit = $this->check_access('events', 'edit', FALSE);
        $this->template->content->allow_delete = $this->check_access('events', 'delete', FALSE);
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
        $this->template->content->districts = $this->districts_sorted();
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
        $this->template->content->districts = $this->districts_sorted();
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
        $this->request->redirect(URL::site('events/view/' . $id));
        die('redirect');
        //}
    }

    public function action_delete()
    {
        $id = $this->request->param('id');
        empty($id) and $this->request->redirect('events');
        DB::delete('events')->where('id', '=', $id)->execute();
        $this->request->redirect('events');
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
                    SELECT e.*, d.name as district_name, (select count(id) from events where e.id = events.id) AS total
                    FROM events as e
                    inner join districts as d
                    on d.id = e.district_id
                    WHERE district_id = :district_id
                    AND DATE(start_at) > CURDATE()
                    ORDER BY DATE(start_at) ASC
                    "./*LIMIT 1*/"
                    ;";
                $district_events = DB::query(Database::SELECT, $sql)
                        ->bind(':district_id', $district['id'])
                        ->execute()
                        ->as_array();
                if ('თბილისი' == $district['name'])
                {
                    $district_events = array_merge
                    (
                        $district_events,
                        DB::query
                        (
                            Database::SELECT,
                            "SELECT e.*, d.name as district_name, (select count(id) from events where e.id = events.id) AS total
                            FROM events as e
                            inner join districts as d
                            on d.id = e.district_id
                            WHERE d.id IN (select id from districts where parent = :parent)
                            AND DATE(start_at) > CURDATE()
                            ORDER BY DATE(start_at) ASC;"
                        )
                        ->bind(':parent', $district['id'])
                        ->execute()
                        ->as_array()
                    );
                }

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
                        //AND !empty($district_events[0]['address'])
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
                            'district_name' => trim($de['district_name']),
                            'start_at' => Controller_People::reformat_date($de['start_at'])//date('Y-m-d', strtotime($de['start_at']))
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
                              <a href='" . URL::site('events/view/' . $event['id']) . "' class='eventlink'>" .
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

    /*public function action_tbilisi()
    {
        $events = DB::select('events.id', 'events.name', 'address', 'start_at')
                  ->from('events')
                  ->join('districts')
                  ->on('events.district_id', '=', 'districts.id')
                  ->where
                  (
                        'districts.parent',
                        '=',
                        DB::select('id')->from('districts')->where('name', '=', 'თბილისი')->execute()->get('id')
                  )
                  ->and_where('DATE("start_at")', '>', date('Y-m-d'))
                  ->order_by('start_at', 'ASC')
                  ->execute()
                  ->as_array();
        foreach ($events as &$event)
        {
            $event['start_at'] = Controller_People::reformat_date($event['start_at']);
        }
        echo json_encode($events);
        die;
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

    public function action_districts_blue()
    {
        $json = file_get_contents('districts.json');
        header('Content-type: text/html; charset=UTF-8');
        function eng_to_geo($text)
        {
            $alphabet = array(
                'latin' => array('a', 'b', 'g', 'd', 'e', 'v', 'z', 't', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'j', 'r', 's', 't', 'u', 'f', 'q', 'gh', 'y', 'sh', 'ch', 'ts', 'dz', 'w', 'ch', 'kh', 'j', 'h'),
                'unicode' => array('ა', 'ბ', 'გ', 'დ', 'ე', 'ვ', 'ზ', 'თ', 'ი', 'კ', 'ლ', 'მ', 'ნ', 'ო', 'პ', 'ჟ', 'რ', 'ს', 'ტ', 'უ', 'ფ', 'ქ', 'ღ', 'ყ', 'შ', 'ჩ', 'ც', 'ძ', 'წ', 'ჭ', 'ხ', 'ჯ', 'ჰ')
            );
            return str_replace($alphabet['latin'], $alphabet['unicode'], $text);
        }
        $dec = json_decode($json);
        $sql = '';
        foreach ($dec->features as &$feature)
        {
            $feature->properties->name_2_geo = eng_to_geo(strtolower($feature->properties->NAME_2));
            $geojson = serialize($feature);
            $name = $feature->properties->name_2_geo;
            $sql .= "insert into districts(name,language,geojson) values('{$name}','ka','{$geojson}'); \n";
        }
        die($sql);

        die($json);
        print_r(serialize(json_decode($json)));die;
    }*/

}
