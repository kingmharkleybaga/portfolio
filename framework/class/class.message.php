<?php 

class Message{

	public static function success( $string , $header = '' ){

		// echo success message dialog

		echo '<div id="message-wrapper" class="alert alert-success alert-dismissible" role="alert">';
		echo '	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		echo '	<strong>' . $header . '</strong> ' . $string;
		echo '</div>';

	}

	public static function danger( $string , $header = '' ){

		// echo success message dialog

		echo '<div id="message-wrapper" class="alert alert-danger alert-dismissible" role="alert">';
		echo '	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		echo '	<strong>' . $header . '</strong> ' . $string;
		echo '</div>';

	}
    
    public static function get_message($id) {
        
        global $mysql;
        
        
        $table = 'messages';
        $where = array(
            'id' => $id
        );
        
        if( $mysql->select( $table, $where ) ) {
            
            $res = $mysql->arrayedResult;
            $message_body = unserialize($res['message_body']);
            $date_sent = unserialize($res['date_sent']);
            $sent_by = unserialize($res['sent_by']);
            $student_id = $res['student_id'];
            
            $student_table = 'students';
            $where = array(
                'sid' => $student_id
            );
            if( $mysql->select($student_table, $where)) {
                $result = $mysql->arrayedResult;
                $fname = $result['first_name'];
                $lname = $result['last_name'];
                $course = $result['course'];
                $company = $result['company_name'];
            } else {
                echo $mysql->lastError;
            }
            
            $content = '<hr>';
            $content .= '<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"></div>';
            $content .= '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 message-header">';
                $content .= '<span><b>Name of Student: </b>'.$fname.' '.$lname.'</span><br>';
                $content .= '<span><b>Course: </b>'.$course.'</span><br>';
                $content .= '<span><b>Company: </b>'.$company.'</span>';
            $content .= '</div>';
            
            $rows = count($message_body);
            
            if( $rows > 1 ) {
                
                
                $x = 0;
                $content .= '<div>';
                foreach( $message_body as $msg ) {
                    
                    $content  .= '<div class="col-sm-12 msg-wrapper">';
                        
//                        $content .= '<div style="width: 100%;border-bottom"></div>';
                        $content .= '<div style="border-bottom: 1px solid #ccc;padding-top: 20px">';
                        
                            
                            //Date Sent
                            $content .= '<div class="text-left col-sm-12" style="padding-bottom: 20px">';
                                $content .= '<span style="font-style:italic;font-size: 14px;">Date Sent:<strong> '.$date_sent[$x].'</strong></span>';
                            $content .= '</div>';
                    
                            //Message
                            $content .= '<div class="col-sm-12">';
                            $content .= nl2br($msg);
                            $content .= '</div>';
                    
                            //Sender
                            $content .= '<div class="text-right col-sm-12" style="padding-top: 20px;">';
                                $content .= '<span style="font-style:italic;font-size: 14px">Sender: <strong>'.$sent_by[$x].'</strong></span>';
                            $content .= '</div>';
                    
                        $content .= '</div>';
                    $content .= '</div>';
                    $x++;
                }
                
            } else {
                
                if(strlen($message_body[0]) > 1) {
                    $msg_body = $message_body[0];  
                    $sent_date = $date_sent[0];
                    $sender = $sent_by[0];
                } else {
                    $msg_body = $message_body; 
                    $sent_date = $date_sent;
                    $sender = $sent_by;
                }
                
                
                
                $content  = '<div class="col-sm-12 msg-wrapper">';
            
                    $content .= '<hr>';
                        $content .= '<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"></div>';
                        $content .= '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 message-header">';
                            $content .= '<span><b>Name of Student: </b>'.$fname.' '.$lname.'</span><br>';
                            $content .= '<span><b>Course: </b>'.$course.'</span><br>';
                            $content .= '<span><b>Company: </b>'.$company.'</span>';
                        $content .= '</div>';
                    
                    $content .= '<div>';
                    
                        $content .= '<div class="text-right col-sm-12"><hr>';
                            $content .= '<span style="font-style:italic;font-size: 14px">'.$sent_date.'</span>';
                        $content .= '</div>';
                        $content .= nl2br($msg_body);
                            $content .= '<div class="text-right col-sm-12" style="padding-top: 20px;">';
                                $content .= '<span style="font-style:italic;font-size: 14px">Sent by: <strong>'.$sender.'</strong></span>';
                            $content .= '</div>';
                    $content .= '</div>';

                $content .= '<div>';
            }
            
            
            $content .= '<div>';
            echo $content;
            
        } else {
            echo $mysql->lastError;
        }
    }
    
    
    public static function count_messages() {
        
        global $mysql;
        
        $table = 'messages';
        $where = array(
            'coordinator_id' => $_SESSION['id']
        );
        
        if( $mysql->select( $table, $where ) ) {
            
            echo $mysql->records;
            
        } else {
            echo '0';
            echo $mysql->lastError;

        }
        
        
    }
    
    public static function count_all_messages() {
        
        global $mysql;
        
        $table = 'messages';
        
        if( $mysql->select( $table ) ) {
            
            echo $mysql->records;
            
        } else {
            echo '0';
            echo $mysql->lastError;

        }
        
        
    }
    
    public static function count_notifications() {
        
        global $mysql;
        $table = 'messages';
        $where = array(
            'student_id' => $_SESSION['id']
        );
        
        if( $mysql->select( $table, $where ) ) {
            $res = $mysql->arrayedResult;
            
            $total_notif = 0;
            foreach( $res as $result ) {
                
                $notif = $result['notification'];
                $total_notif += $notif;
            }
            if( $total_notif != 0 ) {
                echo ' &nbsp;&nbsp;<i class="fa fa-envelope-o fa-lg"></i><span class="badge menu-notif"> '.$total_notif.'</span>';
            } else {
                echo '';
            }
        } else {
            echo $mysql->lastError;
        }
        
    }

}

?>