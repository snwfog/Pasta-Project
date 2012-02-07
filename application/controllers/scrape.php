<?php

class Scrape extends CI_Controller {
        public function search(){
          $this->load->helper('form');
          $this->load-> view('/scrape_views/form.php');
        }
	public function index()
	{
          $course_code = strtoupper($this->input->post('course_code'));
          $course_number = $this->input->post('course_number');
          if($course_code && $course_number){
          $return = $this->data_collection($course_code,$course_number,4);
          $data['course_lecture'] = $return[0];
          $data['row'] = $return[1];
          $this->load->view('/scrape_views/scrape_view.php',$data);
          }
          else{
            $this -> search();
          }
	}

        private function data_collection($course,$course_number,$season){
          $this->load->library('simple_html_dom.php');
          //ENGR 201, COMP 348, COMP 346, SOEN 341
          $html = file_get_html('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=20114&course='.$course.'&courno='.$course_number.'&campus=&type=U');
          $row = $html -> find('td');

          //scraping information
          $course_lecture = array();
          for($i=9; $i<=sizeOf($row)-1; $i++){
            if( strcasecmp(trim($row[$i]->text()), $course." ".$course_number) === 0){
                $course_title = $row[$i+1]-> text();
                $credit = $row[$i+2]-> text();
                echo "Course Title:".$course_title."<br>Credit:".$credit;
            }
            if (preg_match("/^Lect\s\w+/", $row[$i]->text(),$matches)){
              $lecture_title = trim($row[$i]->text());
              $tutorials = $this->get_tutorials($i+1, $row); // Call function to get lecture of each course
              $time_location = $this -> time_location($i, $row);
              $time_location["Teacher"] =  trim($row[$i+3]->text());
              $time_location["Tutorials"] =  $tutorials;

              $course_lecture[$lecture_title] = $time_location;
              //print_r($course_lecture);
            }
          }
         return array($course_lecture, $row);
        }

        
        private function get_tutorials($index, $row){
          $tutorial_info = array();
          for($index; $index<=sizeOf($row)-1; $index++){
            $text = trim($row[$index]->text());
            $text = preg_replace('/&nbsp;/','',$text);
            if(preg_match("/^Lect\s\w+/", $row[$index]->text(),$matches)){
              break;
            }
            if(preg_match("/Tut\s\w+/",$text)){
              $labratory_info =  $this->get_labratory($index+3, $row);
              $time_location = $this -> time_location($index,$row);
              $time_location["Labs"] = $labratory_info;
              $tutorial_info[$text] = $time_location;
            }
          }
          //print_r($tutorial_info);
          return $tutorial_info;
        }

        private function get_labratory($index,$row){
          $labratory_info = array();
          for($index; $index<=sizeOf($row)-1; $index++){
            $text = trim($row[$index]->text());
            $text = preg_replace('/&nbsp;/','',$text);
            if(preg_match("/Tut\s\w+/", $row[$index]->text(),$matches)){
              break;
            }
            if(preg_match("/Lab\s\w+/",$text)){
              $labratory_info[$text] = $this -> time_location($index,$row);
            }
          }
          return $labratory_info;
        }
        
        private function time_location($index, $row){
              $time = trim($row[$index+1]->text());
              $location = trim($row[$index+2]->text());
              return array("Time" => $time, "Location" => $location);
        }

}

/* End of file test.php */
/* Location: ./application/controllers/test.php */