<?php

class Get_uploads {

	public $session_email;
	public $result;
	public $table_name = 'uploaded_image';

	public function get_sessionist( $sessionist ) {

		return $this->session_email = $sessionist;

	}

	public function parse_images() {

		global $mysql;
	
		$where = array(
				'uploader' => $this->session_email
			);

		$order = 'time DESC';

		if( $mysql->select( $this->table_name, $where, $order ) ) {

			if( $mysql->records > 0 ) {

				$res = $mysql->arrayedResult;
				
				foreach ($res as $show_res) {
					$id = $show_res['image_id'];
					$path = $show_res['thumb_path'];
					
					echo '<div class="cover-card col-sm-4" style="background: url(http://localhost/rsvp-system/'.$path.')no-repeat center top;background-size:cover;"><a href="compose.php?id='.$id.'" id='.$id.' onClick="getDataId(this.id)"><p class="fa fa-check-circle"></p></a></div>';

				}

			} else {
					
				echo 'walang imahe';
				// Message::danger("You don't have any uploads yet. Please upload atleast one.","Oops!");
			}

		}

	}


}
?>