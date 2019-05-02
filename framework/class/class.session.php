<?php 

class Session{

	public static function create( $arrays ){

		if ( is_array( $arrays ) ){
            
            $_SESSION['STATUS'] = 'ACTIVE';
			$_SESSION['id'] = $arrays['id'];
			$_SESSION['account_type'] = $arrays['account_type'];
			$_SESSION['username'] = $arrays['username'];
            $_SESSION['email'] = $arrays['email'];
            $_SESSION['firstname'] = $arrays['first_name'];
            $_SESSION['middlename'] = $arrays['middle_name'];
            $_SESSION['lastname'] = $arrays['last_name'];
            $_SESSION['image'] = $arrays['image'];
            $_SESSION['college_id'] = $arrays['college_id'];
            $_SESSION['department_id'] = $arrays['department_id'];
            

			return true;

		} else {

			return false;

		}

	}
    
    public static function create_for_student( $arrays ){

		if ( is_array( $arrays ) ){
            
            $_SESSION['STATUS'] = 'ACTIVE';
			$_SESSION['id'] = $arrays['sid'];
			$_SESSION['account_type'] = 'student';
			$_SESSION['username'] = $arrays['username'];
            $_SESSION['email'] = $arrays['email'];
            $_SESSION['firstname'] = $arrays['first_name'];
            $_SESSION['middlename'] = $arrays['middle_name'];
            $_SESSION['lastname'] = $arrays['last_name'];
            $_SESSION['image'] = $arrays['image'];
            

			return true;

		} else {

			return false;

		}

	}

	public static function check_session(){
        
        if( Account::get('STATUS') == 'ACTIVE' ){

			// if account status is active then redirect to dashboard

			if ( basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == 'admin-login-portal.php' || basename($_SERVER['PHP_SELF']) == 'coordinator-login-portal.php' || basename($_SERVER['PHP_SELF']) == 'students-login-portal.php'){

				if($_SESSION['account_type'] == 'admin') {
                    header('Location: admin.php');
                } elseif( $_SESSION['account_type'] == 'coordinator') {
                    header('Location: coordinator.php');
                } else {
                    header('Location: student.php');
                }

			}

		} else {

			if ( basename($_SERVER['PHP_SELF']) != 'index.php' && basename($_SERVER['PHP_SELF']) != 'students-login-portal.php' && basename($_SERVER['PHP_SELF']) != 'coordinator-login-portal.php' && basename($_SERVER['PHP_SELF']) != 'admin-login-portal.php'){

				header('Location: index.php');

			} else {
                
                
                
            }
			
		}

//		if( Account::get('STATUS') == 'ACTIVE' ){
//
//			// if account status is active then redirect to dashboard
//
//			
//            
//            switch($_SESSION['account_type']){
//                case 'admin':
//                    if ( basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == 'admin-login-portal.php' ){
//
//                        header('Location: admin.php');
//
//                    } else {
//                        if ( basename($_SERVER['PHP_SELF']) != 'index.php' || basename($_SERVER['PHP_SELF']) != 'admin-login-portal.php' ){
//
//                            header('Location: index.php');
//
//                        }
//                    }
//                    break;
//                
//                case 'coordinator':
//                    if ( basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == 'coordinator-login-portal.php' ){
//
//                        header('Location: coordinator.php');
//
//                    } else {
//                        if ( basename($_SERVER['PHP_SELF']) != 'index.php' || basename($_SERVER['PHP_SELF']) != 'coordinator-login-portal.php' ){
//
//                            header('Location: index.php');
//
//                        }
//                    }
//                    break;
//                
//                default:
//                    if ( basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == 'students-login-portal.php' ){
//
//                        header('Location: student.php');
//
//                    } else {
//                        if ( basename($_SERVER['PHP_SELF']) != 'index.php' || basename($_SERVER['PHP_SELF']) != 'students-login-portal.php' ){
//
//                            header('Location: index.php');
//
//                        }
//                    }
//                    
//                    break;
//            }
//
//		} else {
//
//			 header('Location: index.php');
//			
//		}

	}

	public static function destroy(){

        session_destroy();
        header('Location: index.php?action=logout');   

	}

}


?>