<?php

class Coordinator {

    public static function edit_my_profile() {

        global $mysql;
        
        $table = 'account';
        $where = array(
            'id' => $_SESSION['id']
        );
        
        if($mysql->select( $table, $where )) {
            $res = $mysql->arrayedResult;
            
            //Sur Name
            $content  = '<div class="col-sm-4 form-group">';
            $content .= '<label>Family Name:</label>';
            $content .= '<input id="last_name" type="text" class="form-control" value="'.$res['last_name'].'">';
            $content .= '</div>';
            
            //Given Name
            $content .= '<div class="col-sm-4 form-group">';
            $content .= '<label>Given Name:</label>';
            $content .= '<input id="first_name" type="text" class="form-control" value="'.$res['first_name'].'">';
            $content .= '</div>';
            
            //Middle Name
            $content .= '<div class="col-sm-4 form-group">';
            $content .= '<label>Middle Name:</label>';
            $content .= '<input id="middle_name" type="text" class="form-control" value="'.$res['middle_name'].'">';
            $content .= '</div>';
            
            //Employee id
            $content .= '<div class="col-sm-4 form-group">';
            $content .= '<label>Employee Id/Username:</label>';
            $content .= '<input type="text" class="form-control" style="color: #000" value="'.$res['username'].'" readonly>';
            $content .= '</div>';
            
            //Email Address
            $content .= '<div class="col-sm-4 form-group">';
            $content .= '<label>Email Address:</label>';
            $content .= '<input id="email" type="text" class="form-control" value="'.$res['email'].'">';
            $content .= '</div>';
            
            //Position
            $content .= '<div class="col-sm-4 form-group">';
            $content .= '<label>Position:</label>';
            $content .= '<input type="text" class="form-control" value="OJT '.$res['account_type'].'" style="color: #000; text-transform: Capitalize" readonly>';
            $content .= '</div>';
            
            //Change Password
            $content .= '
                <div class="col-sm-12 change-password-wrapper">
                    <h4>CHANGE PASSWORD</h4>
                    <span>Leave blank if you don\'t want to change the password.</span>
                </div>
                
                <div class="col-sm-4 form-group">
                    <label for="old password">Old Password: </label>
                    <input id="old-password" type="password" class="form-control" name="old_password" placeholder="Enter your old password">
                </div>
                
                <div class="col-sm-4 form-group">
                    <label for="new password">New Password: </label>
                    <input id="new-password" type="password" class="form-control" name="new_password" placeholder="Replace with the new one">
                </div>
                
                <div class="col-sm-4 form-group">
                    <label for="confirm password">Confirm Password: </label>
                    <input id="confirm-password" type="password" class="form-control" name="confirm_password" placeholder="Confirm new password">
                </div>
                
                <div class="col-sm-4 pull-right">
                    <input id="updateCoordinatorBtn" type="submit" class="btn btn-success pull-right" name="submit" value="UPDATE"/>
                </div>
            
            ';
            
            echo $content;
        }
    }
    
    public static function get_profile_picture(){
        global $mysql;
        $table = 'account';
        $where = array(
            'id' => $_SESSION['id']
        );
        if( $mysql->select( $table, $where ) ) {
            $res = $mysql->arrayedResult;
            
            echo '<img src="'.$res['image'].'" style="min-height: 200px">';
            
        } else {
            echo $mysql->lastError;
        }
    }
    
    public static function register_a_student(){
        
        $content  = '<div class="col-sm-4 form-group">';
        $content .= '<input id="sr_code" type="text" class="form-control" placeholder="SR - CODE">';
        $content .= '</div>';
        $content .= '<div class="col-sm-4 form-group">';
        $content .= '<input id="email_address" type="text" class="form-control" placeholder="EMAIL ADDRESS">';
        $content .= '</div>';
        
        //Select School Year
        $content .= '<div class="col-sm-2 form-group">';
        $content .= '<select id="school_year" class="form-control">';
        
        global $mysql;
        $table = 'account';
        $where = array(
            'id' => $_SESSION['id']
        );
        
        if( $mysql->select( $table, $where ) ) {
            
            $res = $mysql->arrayedResult;
            
            if( !empty($res['sy_from']) && !empty($res['sy_to']) ) {
                
                $sy_from = unserialize($res['sy_from']);
                $sy_to = unserialize($res['sy_to']);
                
                $rows = count($sy_from);
                
                if($rows > 1) {
                    $c = 0;
                    foreach( $sy_from as $sy_f ) {
                        $content .= '<option value="'.$sy_f.'-'.$sy_to[$c].'">'.$sy_f.'-'.$sy_to[$c].'</option>';
                        $c++;
                    }
                } else {
                    $content .= '<option value="'.$sy_from.'-'.$sy_to.'">'.$sy_from.'-'.$sy_to.'</option>';
                }                
                
            } else {
                $content .= '<option value="none">No data yet. Pls contact your administrator.</option>';
            }
            
        } else {
            echo $mysql->lastError;
        }
        
        $content .= '</select>';
        $content .= '</div>'; //End # School Year
        
        
        //Select School Semester
        $content .= '<div class="col-sm-2 form-group">';
        $content .= '<select id="semester" class="form-control" style="text-transform:uppercase">';
        
        global $mysql;
        $table = 'account';
        $where = array(
            'id' => $_SESSION['id']
        );
        
        if( $mysql->select( $table, $where ) ) {
            
            $res = $mysql->arrayedResult;
            
            if( !empty($res['semester']) ) {
                
                $semester = unserialize($res['semester']);
                
                $rows = count($semester);
                
                if($rows > 1) {
                    
                    foreach( $semester as $sem ) {
                        $content .= '<option value="'.$sem.'" style="text-transform:uppercase">'.$sem.'</option>';
                    }
                    
                } else {
                    $content .= '<option value="'.$semester.'" style="text-transform:uppercase">'.$semester.'</option>';
                }                
                
            } else {
                $content .= '<option value="none">No data yet. Pls contact your administrator.</option>';   
            }
            
        } else {
            echo $mysql->lastError;
        }
        
        $content .= '</select>';
        $content .= '</div>'; //End # School Semester
        
        
        $content .= '<div class="col-sm-10 form-group">';
        $content .= '<input id="company_name" type="text" class="form-control" placeholder="COMPANY NAME">';
        $content .= '</div>';
        
        
        //button
        $content .= '<div class="col-sm-2">';
        $content .= '<button id="register-student" class="btn btn-block" style="color: #fff;">REGISTER</button>';
        $content .= '</div>';
        echo $content;
        
    }

}