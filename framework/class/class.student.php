<?php

class Student {
    
    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $email_address = '';
    public $sr_code = '';
    public $course = '';
    public $students_course = '';
    public $year_section = '';
    public $contact_number = '';
    public $number_of_hours = '';
    public $school_year = '';
    public $semester = '';
    public $company_name = '';
    public $company_address = '';
    public $coordinator = '';
    public $department = '';
    public $college = '';
    public $start_date = '';
    public $end_date = '';
    public $start_of_training = '';
    public $end_of_training = '';
    
    public function get_students_info() {
        
        global $mysql;
        
        $table = 'students';
        $where = array(
            'sid' => $_SESSION['id']
        );
        
        if( $mysql->select( $table, $where ) ) {
            $res = $mysql->arrayedResult;
            
            $this->first_name = $res['first_name'];
            $this->middle_name = $res['middle_name'];
            $this->last_name = $res['last_name'];
            $this->email_address = $res['email'];
            $this->sr_code = $res['username'];
            $this->year_section = $res['year_section'];
            $this->contact_number = $res['contact_number'];
            $this->number_of_hours = $res['no_of_hours'];
            $this->school_year = $res['school_year'];
            $this->semester = $res['semester'];
            $this->company_name = $res['company_name'];
            $this->company_address = $res['company_address'];
            
            if(empty($res['course'])) {
                $cid = $res['cid'];
                $tbl = 'account';
                $where = array(
                    'id' => $cid
                );
                
                if( $mysql->select( $tbl, $where ) ) {
                    
                    $result = $mysql->arrayedResult;
                    
                    $courses_ids = unserialize($result['courses_ids']);
                    
                    $rows = count($courses_ids);
                    
                    if( $rows > 1) {
                        $content = '<select id="course" class="form-control">';
                        
                        foreach($courses_ids as $id) {
                            
                            $courses_table = 'courses';
                            
                            $where = array( 'course_id' => $id);
                            if( $mysql->select( $courses_table, $where ) ) {
                                $the_result = $mysql->arrayedResult;
                                $content .= '<option value="'.$the_result['course_name'].'">'.$the_result['course_name'].'</option>';
                            } else {
                                echo $mysql->lastError;
                            }
                            
                        }
                        $content .= '</select>';
                        
                        $this->course = $content;
                    } else {
                        
                        $courses_table = 'courses';
                            
                        $where = array( 'course_id' => $courses_ids);
                        if( $mysql->select( $courses_table, $where ) ) {
                            $the_result = $mysql->arrayedResult;
                            
                            $this->course = '<input id="course" type="text" class="form-control" value="'.$the_result['course_name'].'" readonly style="background-color: #fff; color: #000;">';
                            
                            // $content .= '<option value="'.$the_result['course_name'].'">'.$the_result['course_name'].'</option>';
                        } else {
                            echo $mysql->lastError;
                        }
                            
                        
                        
                    }
                    
                }
            } else {
                $this->course = '<input type="text" id="course" class="form-control" value="'.$res['course'].'" readonly style="background-color: #fff; color: #000;">';
                $this->students_course = $res['course'];
            }
            
            
            $college_table = 'college';
            $where = array(
                'college_id' => $res['college_id']
            );
            
            if( $mysql->select( $college_table, $where ) ) {
                $college_res = $mysql->arrayedResult;
                $this->college = $college_res['college_name'];
            } else {
                echo $mysql->lastError;
            }
            
            $department_table = 'department';
            $where = array(
                'department_id' => $res['department_id']
            );
            
            if( $mysql->select( $department_table, $where ) ) {
                $department_result = $mysql->arrayedResult;
                $this->department = $department_result['department_name'];
            } else {
                echo $mysql->lastError;
            }
            
            
            //Get Name of Coordinator
            $account_table = 'account';
            $where = array(
                'id' => $res['cid']
            );
            
            if( $mysql->select( $account_table, $where ) ) {
                $account_res = $mysql->arrayedResult;
                $this->coordinator = $account_res['first_name'].' '.$account_res['last_name'];
            } else {
                echo $mysql->lastError;
            }

            //Get Start Date of Training
            if( empty($res['start_date']) ) {
                $this->start_date = '
                    <div class="form-group col-sm-6">
                        <label>Start Date of Training</label>
                        <input id="start_date" type="text" class="form-control" placeholder="Start of Training">
                    </div>';
            } else {
                $this->start_date = '
                    <input id="start_date" type="text" class="form-control sr-only" value="'.$res['start_date'].'">';
                $this->start_of_training = $res['start_date'];
            }
            
            //Get End Date of Training
            if( empty($res['end_date']) ) {
                $this->end_date = '
                    <div class="form-group col-sm-6">
                        <label>End Date of Training</label>
                        <input id="end_date" type="text" class="form-control" placeholder="End of Training">
                    </div>';
            } else {
                $this->end_date = '
                    <input id="start_date" type="text" class="form-control sr-only" value="'.$res['end_date'].'">';
                $this->end_of_training = $res['end_date'];
            }
            
            
        }
        
    }
    
    public static function get_profile_picture(){
        global $mysql;
        $table = 'students';
        $where = array(
            'sid' => $_SESSION['id']
        );
        if( $mysql->select( $table, $where ) ) {
            $res = $mysql->arrayedResult;
            
            echo '<img src="'.$res['image'].'" style="min-height: 200px">';
            
        } else {
            echo $mysql->lastError;
        }
    }
    
    public function view_students_profile($id) {
        
        global $mysql;
        
        $table = 'students';
        $where = array(
            'sid' => $id
        );
        
        if( $mysql->select( $table, $where ) ) {
            $res = $mysql->arrayedResult;
            
            
            $college_table = 'college';
            $where = array(
                'college_id' => $res['college_id']
            );
            
            if( $mysql->select( $college_table, $where ) ) {
                $college_res = $mysql->arrayedResult;
                $college = $college_res['college_name'];
            } else {
                echo $mysql->lastError;
            }
            
            $department_table = 'department';
            $where = array(
                'department_id' => $res['department_id']
            );
            
            if( $mysql->select( $department_table, $where ) ) {
                $department_result = $mysql->arrayedResult;
                $department = $department_result['department_name'];
            } else {
                echo $mysql->lastError;
            }
            
            
            //Get Name of Coordinator
            $account_table = 'account';
            $where = array(
                'id' => $res['cid']
            );
            
            if( $mysql->select( $account_table, $where ) ) {
                $account_res = $mysql->arrayedResult;
                $coordinator = $account_res['first_name'].' '.$account_res['last_name'];
            } else {
                echo $mysql->lastError;
            }            
            
            // End of Queries
            
            
            $content = '<div class="col-sm-12 img-profile-wrapper text-center" style="padding-bottom: 15px">';
                $content .= '<img src="'.$res['image'].'" style="min-height: 200px">';
            $content .= '</div>';
            
            $content .= '<div class="col-sm-12 text-center" style="padding-bottom: 15px;text-transfrom: uppercase">';
                $content .= '<strong>'.$res['first_name'].' '.$res['middle_name'].' '.$res['last_name'].'</strong>';
            $content .= '</div>';
            
            $content .= '<div class="col-sm-12 text-center" style="padding-bottom: 15px">';
                $content .= '<a href="view-journal.php?s='.$res['sid'].'" class="btn" style="color: #fff">VIEW JOURNAL</a>';
            $content .= '</div>';
            
            $content .= '<div class="row students-info-wrapper">';
                $content .= '<div class="col-sm-12">';
                    $content .= '<p><strong>SR Code:</strong> '.$res['username'].'</p>';
                $content .= '</div>';
            
                $content .= '<div class="col-sm-12">';
                    $content .= '<p><strong>First Name:</strong> '.$res['first_name'].'</p>';
                $content .= '</div>';
            
                $content .= '<div class="col-sm-12">';
                    $content .= '<p><strong>Middle Name:</strong> '.$res['middle_name'].'</p>';
                $content .= '</div>';
            
                $content .= '<div class="col-sm-12">';
                    $content .= '<p><strong>Last Name:</strong> '.$res['last_name'].'</p>';
                $content .= '</div>';
            
                $content .= '<div class="col-sm-12">';
                    $content .= '<p><strong>Contact Number:</strong> '.$res['contact_number'].'</p>';
                $content .= '</div>';
            
                $content .= '<div class="col-sm-12">';
                    $content .= '<p><strong>Course:</strong> '.$res['course'].'</p>';
                $content .= '</div>';
            
                $content .= '<div class="col-sm-12">';
                    $content .= '<p><strong>Year/Section:</strong> '.$res['year_section'].'</p>';
                $content .= '</div>';
            
                $content .= '<div class="col-sm-12">';
                    $content .= '<p><strong>Department:</strong> '.$department.'</p>';
                $content .= '</div>';
            
                $content .= '<div class="col-sm-12">';
                    $content .= '<p><strong>College:</strong> '.$college.'</p>';
                $content .= '</div>';
            
                $content .= '<div class="col-sm-12 text-center">';
                    $content .= '<h4>On-the-Job Training Info</h4>';
                $content .= '</div>';
            
                $content .= '<div class="col-sm-12">';
                    $content .= '<p><strong>OJT Coordinator:</strong> '.$coordinator.'</p>';
                $content .= '</div>';
            
                $content .= '<div class="col-sm-12">';
                    $content .= '<p><strong>Name of Company:</strong> '.$res['company_name'].'</p>';
                $content .= '</div>';
            
                $content .= '<div class="col-sm-12">';
                    $content .= '<p><strong>Address of Company:</strong> '.$res['company_address'].'</p>';
                $content .= '</div>';
            
                $content .= '<div class="col-sm-12">';
                    $content .= '<p><strong>Duration of Training:</strong> '.$res['no_of_hours'].' hrs</p>';
                $content .= '</div>';
            
                $content .= '<div class="col-sm-12">';
                    $content .= '<p><strong>Start Date <span style="font-size: 14px">[ yyyy-mm-dd ]</span>:</strong> '.$res['start_date'].' </p>';
                $content .= '</div>';
            
                $content .= '<div class="col-sm-12">';
                    $content .= '<p><strong>End Date <span style="font-size: 14px">[ yyyy-mm-dd ]</span>:</strong> '.$res['end_date'].' </p>';
                $content .= '</div>';
            
            $content .= '</div>'; // end
            
            
            echo $content;
            
        } else {
            echo $mysql->lastError;
        }
        
    }
    
}