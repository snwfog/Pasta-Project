<?php

class Scrape extends CI_Controller {
	public function index()
	{
          $data['row'] = $this->data_collection("COMP",232,4);
          $this->load->view('/scrape_views/scrape_view.php',$data);
	}

        private function data_collection($course,$course_number,$season){
          $this->load->library('simple_html_dom.php');
          //ENGR 201, COMP 348, COMP 346, SOEN 341
          $html = file_get_html('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=20114&course=ELEC&courno=275&campus=&type=U');
          $row = $html -> find('td');

          $course_lecture = array();

          for($i=9; $i<=sizeOf($row)-1; $i++){
          //trim only remove beginning and end white space, text() is used to get the text of html element
            if( strcasecmp(trim($row[$i]->text()), "ELEC 275") === 0){
                $course_title = $row[$i+1]-> text();
                $credit = $row[$i+2]-> text();
                echo "Course Title:".$course_title."<br>Credit:".$credit;
            }
            if (preg_match("/^Lect\s\w+/", $row[$i]->text(),$matches)){
              $lecture_title = trim($row[$i]->text());
              $tutorials = $this->get_tutorials($i+1, $row); // Call function to get lecture of each course
              $course_lecture[$lecture_title] = array("Time" => trim($row[$i+1]->text()), "Location" => trim($row[$i+2]->text()), "Teacher" => trim($row[$i+3]->text()), "Tutorials" => $tutorials);

              //print_r($course_lecture);
            }
          }

         // JUST OUTPUT TESTING. DELETE AFTER DONE OR COMMENT OUT // FUCKEN BUNCH OF LOOPS
         foreach($course_lecture as $title => $information){
           echo "<br><br>Title: ".$title."<br>";
           foreach($information as $type => $value){
             if(strcmp($type,"Tutorials")===0){
               foreach($value as $key => $value){
                 echo "----------------------------------------------------<br>".$key."<br>";
                  foreach($value as $key => $value){
                    if(strcmp($key,"Labs")===0){
                      foreach($value as $key => $value){
                        echo "<br>".$key."<br>";
                        foreach($value as $key => $value){
                          echo $key.": ".$value."<br>";
                        }
                      }
                    }
                    echo $key.": ".$value."<br>";
                  }
               }
             }else{
               echo $type.": ".$value."<br>";
             }

           }
         }
         // END OF OUTPUT TESTING

         return $html -> find('td');
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
              $tutorial_info[$text] = array( "Time" => trim($row[$index+1]->text()), "Location" => trim($row[$index+2]->text()), "Labs" => $labratory_info );
            }
          }
          print_r($tutorial_info);
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
              $labratory_info[$text] = array( "Time" => trim($row[$index+1]->text()), "Location" => trim($row[$index+2]->text()));
            }
          }
          return $labratory_info;
        }
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */