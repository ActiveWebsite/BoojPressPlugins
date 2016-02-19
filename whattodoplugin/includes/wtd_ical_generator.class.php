<?php

if (!class_exists('wtd_ical_generator')){

    class wtd_ical_generator{

        public function __construct(){

            add_action('init', array(&$this,'build_ical'));

        }

        public function dateToCal($timestamp) {
            return date('Ymd\THis\Z', $timestamp);
        }

        function escapeString($string) {
            return preg_replace('/([\,;])/','\\\$1', $string);
        }

        public function build_ical(){

            if (!empty($_REQUEST['wtd_build_ical']) && !empty($_REQUEST['wtd_data'])){
                global $wtd_connector;
                $data = $wtd_connector->decrypt_parse_response($_REQUEST['wtd_data']);
                if (!empty ($data->events))
                    $events = $data->events;
                if (!empty ($data->specials))
                    $events = $data->specials;
                elseif(!empty($data->event))
                    $events = array($data->event);
                elseif(!empty($data->special))
                    $events = array($data->special);
                else
                    $events = $data;
                header('Content-type: text/calendar; charset=utf-8');
                header('Content-Disposition: attachment; filename=wtd_ical_events.ics');
                ?>
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
CALSCALE:GREGORIAN
<?php
foreach ($events as $event){
    if (!empty($event->specialDate))
        $event_date = $event->specialDate->iso;
    else
        $event_date = $event->eventDate->iso;

?>
BEGIN:VEVENT
UID:<?php echo uniqid()."\r\n"; ?>
DTSTAMP:<?php echo $this->dateToCal(time())."\r\n"; ?>
LOCATION:''
DESCRIPTION:<?php echo '"'.str_replace("\n",'',stripcslashes($this->escapeString(strip_tags($event->description)))).'"'."\r\n"; ?>
URL;VALUE=URI:<?php echo $this->escapeString($event->website)."\r\n"; ?>
SUMMARY:<?php echo $this->escapeString($event->name)."\r\n"; ?>
DTSTART:<?php echo $this->dateToCal(strtotime($event_date))."\r\n"; ?>
DTEND:<?php echo $this->dateToCal(strtotime($event_date) + 24 * 60 * 60)."\r\n"; ?>
END:VEVENT
<?php
}
?>
END:VCALENDAR
<?php

                die();

            }

        }

    }

    $wtd_ical_generator = new wtd_ical_generator();

}

?>