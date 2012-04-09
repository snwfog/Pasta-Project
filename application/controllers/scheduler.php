<?php
class Scheduler extends MY_Controller {
    public function index() {
    }
    public function time_table() {
        $form_data = $this->input->post();
        //If no post data, use session stored data
        if (empty($form_data)) {
            $time_table = $this->session->userdata['time_table'];
            if (empty($time_table)) {
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $form_data = $time_table;
            }
        }
        $this->session->set_userdata("time_table", $form_data);
        $time_table = $this->sort_by_day($form_data);
        $data["time_table"] = $time_table;
        $data['title'] = 'P.A.S.T.A. Time Table';
        $this->put("scheduleBuilder_views/time_table", $data);
    }
    private function sort_by_day($set_of_courses) {
        $time_table = array("M" => array(), "T" => array(), "W" => array(), "J" => array(), "F" => array());
        foreach($set_of_courses as $course) {
            $lecture_days = explode(",", $course["lecture"]["day"]);
            foreach($lecture_days as $day) {
                $course["lecture"]["code"] = $course["code"];
                $course["lecture"]["number"] = $course["number"];
                $course["lecture"]["type"] = "lecture";
                array_push($time_table[$day], $course["lecture"]);
            }
            if (isset($course["tutorial"])) {
                $tutorial_days = explode(",", $course["tutorial"]["day"]);
                foreach($tutorial_days as $day) {
                    $course["tutorial"]["code"] = $course["code"];
                    $course["tutorial"]["number"] = $course["number"];
                    $course["tutorial"]["type"] = "tutorial";
                    array_push($time_table[$day], $course["tutorial"]);
                }
            }
            if (isset($course["lab"])) {
                $lab_days = explode(",", $course["lab"]["day"]);
                foreach($lecture_days as $day) {
                    $course["lab"]["code"] = $course["code"];
                    $course["lab"]["number"] = $course["number"];
                    $course["lab"]["type"] = "lab";
                    array_push($time_table[$day], $course["lab"]);
                }
            }
        }
        return $this->sort_courses_in_each_day($time_table);
    }
    private function sort_courses_in_each_day($time_table) {
        $sorted_time_table = array();
        foreach($time_table as $key => $day) {
            for ($i = 0;$i < count($day);$i++) {
                for ($k = $i + 1;$k < count($day);$k++) {
                    if ($day[$i]["start_time"] > $day[$k]["start_time"]) {
                        $temp = $day[$i];
                        $day[$i] = $day[$k];
                        $day[$k] = $temp;
                        $temp = null;
                    }
                }
            }
            $sorted_time_table[$key] = $day;
        }
        return $sorted_time_table;
    }
}
// End of Scheduler.php