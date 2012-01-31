<?php

class Scrape extends CI_Controller {
	public function index()
	{
          $data['row'] = $this->data_collection("COMP",232,4);
          $this->load->view('scrape_view.php',$data);
	}

        private function data_collection($course,$course_number,$season){
          $this->load->library('simple_html_dom.php');
          $html = file_get_html('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=20114&course=COMP&courno=346&campus=&type=U');
          $row = $html -> find('td');

          $course_lecture = array();

          for($i=9; $i<=sizeOf($row)-1; $i++){
          //trim only remove beginning and end white space, text() is used to get the text of html element
            if( strcasecmp(trim($row[$i]->text()), "COMP 346") === 0){
                $course_title = $row[$i+1]-> text();
                $credit = $row[$i+2]-> text();
                echo "Course Title:".$course_title."<br>Credit:".$credit;
            }
            if (preg_match("/^Lect\s\w+/", $row[$i]->text(),$matches)){
              $lecture_title = trim($row[$i]->text());
              $tutorials = $this->get_tutorials($i, $row);
              $course_lecture[$lecture_title] = array("Time" => trim($row[$i+1]->text()), "Location" => trim($row[$i+2]->text()), "Teacher" => trim($row[$i+3]->text()), "Tutorials" => $tutorials);
              
              //print_r($course_lecture);
            }
          }

         /* foreach($course_lecture as $title => $information){
           echo "<br>Title: ".$title."<br>";
           foreach($information as $type => $value){
             if(strcmp($type,"Tutorials")===0){
               foreach($value as $key => $value){
                 echo $key."<br>";
                  foreach($value as $key => $value){
                    echo $key.": ".$value."<br>";
                  }
               }
             }else{
               echo $type.": ".$value."<br>";
             }

           }
         }

         print_r($course_lecture["Lect NN"]["Tutorials"]);  */
         return $html -> find('td');
        }

        
        private function get_tutorials($index, $row){
          $tutorial_sections = array();
          for($index; $index<=sizeOf($row)-1; $index++){
            $text = trim($row[$index]->text());
            $text = preg_replace('/&nbsp;/','',$text);
            if(preg_match("/Tut\s\w+/",$text)){
              $tutorial_info[$text] = array( "Time" => trim($row[$index+1]->text()), "Location" => trim($row[$index+2]->text()));
            }
          }
          return $tutorial_info;
        }
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */