<?php 

class Input {

	public static function get( $var ) {

		if ( $_GET ) {

			return $_GET[ $var ];

		} else {

			return '';

		}

	}

	public static function post( $var ){

		if( $_POST ){

			return $_POST[ $var ];

		} else {

			return '';

		}
		
	}

}

?>