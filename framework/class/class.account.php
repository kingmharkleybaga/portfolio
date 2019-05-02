<?php 

class Account{

	public static function validate( $post ){

		global $mysql;

		if( isset( $post ) ){
            
            $table = 'account';

			$where = array(

				'username' => @$post['username'],
				'password' => md5( @$post['password'] )

            );

			if ( $mysql->select( $table, $where ) ){

				$res = $mysql->arrayedResult;

				if( $res['account_type'] == 'admin' ){

					$table_name = 'account';
					$where = array(

						'id' => $res['id']

				    );

					$set = array(

						'last_login' => date('j-m-Y h:i A')

				    );

					if( $mysql->update( $table_name , $set, $where ) ){

						Session::create( $mysql->arrayedResult );

						header('Location: admin.php');
                        
//                        $table = 'logs';
//                        $args = array(
//                            'id' => '',
//                            'name' => $res['branch_name'],
//                            'username' => $res['username'],
//                            'action' => 'logged in',
//                            'date_log' => date('j-m-Y h:i A'),
//                            'bid' => $_SESSION['id']
//                        );
                        
//                        if( $mysql->insert( $table, $args )) {
//                            //nothing to do
//                        } else {
//                            Message::danger( $mysql->lastError,'Error:' );
//                        }

					} else {
						Message::danger( $mysql->lastError , 'Error: ');
					}

					

				} else {

					$table_name = 'account';
				    $where = array(

				        'id' => $res['id']

                    );

                    $set = array(

				        'last_login' => date('j-m-Y h:i A')

				    );

				    if( $mysql->update( $table_name , $set, $where ) ){

				        Session::create( $mysql->arrayedResult );

				        header('Location: coordinator.php');

//				        $table = 'logs';
//                        $args = array(
//                            'id' => '',
//                            'name' => $res['branch_name'],
//                            'username' => $res['username'],
//                            'action' => 'logged in',
//                            'date_log' => date('j-m-Y h:i A'),
//                            'bid' => $_SESSION['id']
//                        );
//                        
//                        if( $mysql->insert( $table, $args )) {
//                            //nothing to do
//                        } else {
//                            Message::danger( $mysql->lastError,'Error:' );
//                        }

				    } else {
				        Message::danger( $mysql->lastError , 'Error: ');
				    }

				} 
				
			} else {

				if( isset( $_POST ) &&  !empty( $_POST ) ) {

					Message::danger('Please check the username and password you have entered.','Invalid!');

				} 
			}

		} else {

			return false;

		}

	}
    
    public static function validate_student( $post ){

		global $mysql;

		if( isset( $post ) ){
            
            $table = 'students';

			$where = array(

				'username' => @$post['username'],
				'password' => md5( @$post['password'] )

            );

			if ( $mysql->select( $table, $where ) ){

				$res = $mysql->arrayedResult;

				$table = 'students';
				
                $where = array(

				    'sid' => $res['sid']

				);

				$set = array(

                    'last_login' => date('j-m-Y h:i:A')

				);

				if( $mysql->update( $table , $set, $where ) ){

					Session::create_for_student( $mysql->arrayedResult );

					if(empty($res['first_name']) && empty($res['last_name'])) {
                        header('Location: update-profile.php');
                    } else {
                        header('Location: student.php');
                    }

				} else {
						Message::danger( $mysql->lastError , 'Error: ');
				}
				
			} else {

				if( isset( $_POST ) &&  !empty( $_POST ) ) {

					Message::danger('Please check the username and password you have entered.','Invalid!');

				} 
			}

		} else {

			return false;

		}

	}

	public static function get( $index ){

		if ( isset ( $_SESSION[ $index ] ) ) {

			return $_SESSION[ $index ];

		} else {

			return '';

		}

	}
    
    public static function check_profile(){
        
        switch($_SESSION['account_type']) {
            case 'coordinator':
                $profile = 'staff-profile.php';
                break;
            
            default:
                $profile = 'profile.php';
                break;
        }
        
    }
    
    public static function get_assigned_college() {
        
        global $mysql;
        $table = 'account';
        $where = array( 'id' => $_SESSION['id']);
        if( $mysql->select( $table, $where ) ) {
            
            $res = $mysql->arrayedResult;
            $college_id = $res['college_id'];
            
            $college_table = 'college';
            $where_id = array( 'college_id' => $college_id);
            if( $mysql->select( $college_table, $where_id ) ) {
                
                $result = $mysql->arrayedResult;
                echo $result['college_name'];
            } else {
                echo $mysql->lastError;
            }
            
        } else {
            echo $mysql->lastError;
        }
        
        
    }
    
    public static function get_assigned_department() {
        
        global $mysql;
        $table = 'account';
        $where = array( 'id' => $_SESSION['id']);
        if( $mysql->select( $table, $where ) ) {
            
            $res = $mysql->arrayedResult;
            $department_id = $res['department_id'];
            
            $department_table = 'department';
            $where_id = array( 'department_id' => $department_id);
            if( $mysql->select( $department_table, $where_id ) ) {
                
                $result = $mysql->arrayedResult;
                echo $result['department_name'];
            } else {
                echo $mysql->lastError;
            }
            
        } else {
            echo $mysql->lastError;
        }
        
        
    }
    
    public static function get_assigned_courses() {
        
        global $mysql;
        $table = 'account';
        $where = array( 'id' => $_SESSION['id']);
        if( $mysql->select( $table, $where ) ) {
            
            $res = $mysql->arrayedResult;
            
            if(!empty($res['courses_ids'])) {
                
                
                
                $ids = unserialize($res['courses_ids']);
                $no_of_ids = count($ids);
                
                if($no_of_ids == 1) {
                    
                    $courses_table = 'courses';
                    $where_id = array('course_id' => $ids);
                    if( $mysql->select( $courses_table, $where_id ) ) {
                        
                        $result_of_query = $mysql->arrayedResult;
                        
                        $course_name = $result_of_query['course_name'];
                        
                    } else {
                        
                        echo $mysql->lastError;
                    
                    }
                    
                    $content  = '<p>Assigned Course/s </p>';
                    $content .= '<p>• '.$course_name.'</p>';
                    echo $content;
                    
                } else {
                    
                    $content  = '<p>Assigned Course/s: </p>';
                    
                    foreach($ids as $id){
                        
                        $courses_table = 'courses';
                        $where_id = array('course_id' => $id);
                        if( $mysql->select( $courses_table, $where_id ) ) {

                            $result_of_query = $mysql->arrayedResult;

                            $course_name = $result_of_query['course_name'];

                        } else {

                            echo $mysql->lastError;

                        }

                        
                        $content .= '<p>• '.$course_name.'</p>';
                        
                    }
                    
                    echo $content;
                    
                }
                
            } else {
                echo '<p>No assigned courses.</p>';
            }
            
        } else {
            echo $mysql->lastError;
        }
        
        
    }
    
    public static function get_image() {
        
        switch( $_SESSION['account_type'] ) {
            case 'admin':
                global $mysql;
                
                $table = 'account';
                $where = array(
                    'id' => $_SESSION['id']
                );
                if( $mysql->select( $table, $where ) ) {
                    $res = $mysql->arrayedResult;
                    echo $res['image'];
                } else {
                    echo $mysql->lastError;
                }
                
                break;
                
            case 'coordinator':
                global $mysql;
                
                $table = 'account';
                $where = array(
                    'id' => $_SESSION['id']
                );
                if( $mysql->select( $table, $where ) ) {
                    $res = $mysql->arrayedResult;
                    echo $res['image'];
                } else {
                    echo $mysql->lastError;
                }
                
                break;
                
            default:
                global $mysql;
                
                $table = 'students';
                $where = array(
                    'sid' => $_SESSION['id']
                );
                if( $mysql->select( $table, $where ) ) {
                    $res = $mysql->arrayedResult;
                    echo $res['image'];
                } else {
                    echo $mysql->lastError;
                }
                
                break;
        }
        
    }
    
    public static function get_name() {
        
        switch( $_SESSION['account_type'] ) {
            case 'admin':
                global $mysql;
                
                $table = 'account';
                $where = array(
                    'id' => $_SESSION['id']
                );
                if( $mysql->select( $table, $where ) ) {
                    $res = $mysql->arrayedResult;
                    echo $res['first_name'].' '.$res['middle_name'].' '.$res['last_name'];
                } else {
                    echo $mysql->lastError;
                }
                
                break;
                
            case 'coordinator':
                global $mysql;
                
                $table = 'account';
                $where = array(
                    'id' => $_SESSION['id']
                );
                if( $mysql->select( $table, $where ) ) {
                    $res = $mysql->arrayedResult;
                    echo $res['first_name'].' '.$res['middle_name'].' '.$res['last_name'];
                } else {
                    echo $mysql->lastError;
                }
                
                break;
                
            default:
                global $mysql;
                
                $table = 'students';
                $where = array(
                    'sid' => $_SESSION['id']
                );
                if( $mysql->select( $table, $where ) ) {
                    $res = $mysql->arrayedResult;
                    echo $res['first_name'].' '.$res['middle_name'].' '.$res['last_name'];
                } else {
                    echo $mysql->lastError;
                }
                
                break;
        }
        
    }

}

?>