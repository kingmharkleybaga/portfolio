<?php 
class Image{

	// public $category_count;
	public $url = 'http://localhost/rsvp-system';
	public $last_image_inserted;
	public $images_count;
	public $table_name = 'uploaded_image';

	public function selected_image($id) {
		global $mysql;
		$table = 'uploaded_image';

		$where = array(
				'image_id' => $id
			);

		if( $mysql->select( $table, $where ) ) {

			$res = $mysql->arrayedResult;
			$selected = $res['hd_path'];

			echo '<img src="'. $this->url . '/' .$selected.'"/>';
		}

	}

	public function last_inserted_image() {

		global $mysql;

		// Select thumb_path FROM uploaded_image ORDER BY date_uploaded DESC LIMIT 1;
		
		$where = '';
		$order = 'time DESC';
		$limit = 1;
		
		if( $mysql->select( $this->table_name, $where, $order , $limit ) ) {

			$this->last_image_inserted = $mysql->records;
			$reslt = $mysql->arrayedResult;

			$rsvp_img = $reslt['hd_path'];

			echo '<img src="'. $this->url . '/' .$rsvp_img.'"/>';

		} else {
			echo $mysql->lastError;
		}

	}

	public function upload_image(){

		global $mysql;

		$target_dir = "img/uploads/hi-res/";
		$target_dir_thumb = "img/uploads/thumbs/";
		$target_dir_large = "img/uploads/larger/";
		$target_file = $target_dir . basename($_FILES["file"]["name"]);
		$target_file_thumb = $target_dir_thumb . basename($_FILES["file"]["name"]);
		$target_file_large = $target_dir_large . basename($_FILES["file"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, something went wrong while uploading your image. Please try again!";
		// if everything is ok, try to upload file
		} else {

			$image_name = explode( '.', basename($_FILES["file"]["name"]) );

			$vars = array(

				'image_id' => '',
				'name' => $image_name[0],
				'uploader' => $_SESSION['email'],
				'image_path' =>  $target_file,
				'thumb_path' =>  $target_file_thumb,
				'hd_path' =>  $target_file_large,
				'file_type' => strtoupper( $image_name[1] ),
				'date_uploaded' => date('F j, Y'),
				'time' => time(),
				);

			if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

				$this->createThumbnail( $_FILES["file"]["name"] );
				$this->createLarger( $_FILES["file"]["name"] );

				if( $mysql->insert( $this->table_name, $vars ) ){

					echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";

				}

			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}

	}


	public function add_category(){

		global $mysql;

		$table_name = 'image_categories';

		$category_name = Input::get('category_name');
		$custom_slug = Input::get('slug');

		// check if the category name is already in the database else add it in.

		$where = array( 'name' => $category_name );

		$mysql->select( $table_name , $where ); 

		if( $mysql->records > 0 ){

				// Means that the category is already in the database 

			echo 'The category ' . $category_name . ' is already in the database.';


		} else {

				// Insert it to the database.

			$slug = strtolower(str_replace( ' ', '-', $category_name ));


			$vars = array( 
				'id' => '',
				'name' => $category_name,
				'slug' => $slug,
				'date_registered' => date('F j, Y'),
				'created_by' => $_SESSION['email']
				);

			if( $mysql->insert( $table_name , $vars ) ){

				// If inserted succesfully

				echo 'The category ' . $category_name . ' has successfully added.';

			}
		}

	}

	public function delete_category( $id , $path ){

		global $mysql;

		$table_name = 'image_categories';

		$where = array( 'id' => $id );

		if( $mysql->delete ( $table_name , $where ) ){
			
			$result = array( 'status' => 'deleted' );

			return $result;

		}

	}

	public function get_categories(){

		global $mysql;

		$table_name = 'image_categories';

		if( $mysql->select( $table_name ) ){

			$this->category_count = $mysql->records;

			return $mysql->arrayedResult;

		}


	}

	public function get_pending_images(){

		global $mysql;

		$where = array( 'status' => 'pending' );

		if( $mysql->select( $this->table_name , $where ) ){

			$this->pending_count = $mysql->records;

			return $mysql->arrayedResult;

		}

	}

	public function get_images( $where = '', $order = '' , $page = 1 ){

		global $mysql;

		if( $mysql->select( $this->table_name , $where , $order , $page . ',40' ) ) {

			$this->images_count = $mysql->records;

			return $mysql->arrayedResult;

		}

	}

	public function get_pages( $cat = '' ){

		global $mysql;

		if( $cat != '' ){

			$where = array(
				'category' => $cat
				);

		} else {
			$where = '';
		}

		

		if( $mysql->select( $this->table_name , $where ) ){

			return $mysql->records;

		}

	}

	public function load_image( $where = '', $order = '' , $limit ){

		global $mysql;

		if( $mysql->select( $this->table_name , $where , $order , $limit ) ) {

			$html = '';

			if( $mysql->records == 0 ){
				// no records anymore.

			} elseif( $mysql->records == 1 ){
				// only 1 record
			} else {
				// multple records returned

				foreach( $mysql->arrayedResult as $res ){

					$html .= '<div class="item">';
					$html .= '	<div class="thumbnail">';
					$html .= '		<a href="#" class="image-item" data-id="' . $res['id'] . '">';
					$html .= '			<div class="overlay">';
					$html .= '				<div class="color-overlay"></div>';
					$html .= '				<img src="' . $res['thumb_path'] . '" alt="...">';
					$html .= '			</div>';
					$html .= '			<div class="caption">';
					$html .= '				<p><strong>' . $res['name'] . '</strong> ';
					if( $res['status'] == 'pending' ) {
						$html .= '					<span class="label label-warning">Pending</span>';
					}
					$html .= '				</p>';
					$html .= '				<p class="uploader text-right" style="font-size: 10px; margin-bottom: -5px;">' . $res['uploader'] . '</p>';
					$html .= '			</div>';
					$html .= '		</a>';
					$html .= '	</div>';
					$html .= '</div><!-- end item -->';

				}

			}

			$return_array = array( 
				'html' => $html,
				'limit' => $limit,
				);

			return $return_array;

		}

	}

	public function get_image( $id ){

		global $mysql;

		$where = array( 'id' => $id );

		if( $mysql->select( $this->table_name , $where ) ) {

			return $mysql->arrayedResult;

		}

	}

	public function update_pending(){

		global $mysql;

		$id = Input::get('id');
		$name = Input::get('name');
		$category = Input::get('category');
		$description = Input::get('description');
		$tags = Input::get('tags');
		$used_in = Input::get('used_in');


		$where = array( 'id' => $id );

		$set = array( 
			'name' => $name,
			'category' => $category,
			'description' => $description,
			'tags' => $tags,
			'used_in' => $used_in,
			'status' => 'Approved',
			);

		if( $mysql->update( $this->table_name , $set, $where ) ) {

			$return_array = array( 'status' => 'updated' , 'textarea' => Input::get('description') );

			return $return_array;

		}

	}

	public function createThumbnail($filename) {

		$final_width_of_image = 300;

		$path_to_thumbs_directory = 'img/uploads/thumbs/';

		$path_to_image_directory = 'img/uploads/hi-res/';

		if(preg_match('/[.](jpg)$/', $filename)) {
			$im = imagecreatefromjpeg($path_to_image_directory . $filename);
		} else if (preg_match('/[.](gif)$/', $filename)) {
			$im = imagecreatefromgif($path_to_image_directory . $filename);
		} else if (preg_match('/[.](png)$/', $filename)) {
			$im = imagecreatefrompng($path_to_image_directory . $filename);
		}

		$ox = imagesx($im);
		$oy = imagesy($im);

		$nx = $final_width_of_image;
		$ny = floor($oy * ($final_width_of_image / $ox));

		$nm = imagecreatetruecolor($nx, $ny);

		imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

		if(!file_exists($path_to_thumbs_directory)) {
			if(!mkdir($path_to_thumbs_directory)) {
				die("There was a problem. Please try again!");
			} 
		}

		imagejpeg($nm, $path_to_thumbs_directory . $filename);
		$tn = '<img src="' . $path_to_thumbs_directory . $filename . '" alt="image" />';
		$tn .= '<br />Congratulations. Your file has been successfully uploaded, and a      thumbnail has been created.';
		echo $tn;
	}

	public function createLarger($filename) {

		$final_width_of_image = 1024;

		$path_to_thumbs_directory = 'img/uploads/larger/';

		$path_to_image_directory = 'img/uploads/hi-res/';

		if(preg_match('/[.](jpg)$/', $filename)) {
			$im = imagecreatefromjpeg($path_to_image_directory . $filename);
		} else if (preg_match('/[.](gif)$/', $filename)) {
			$im = imagecreatefromgif($path_to_image_directory . $filename);
		} else if (preg_match('/[.](png)$/', $filename)) {
			$im = imagecreatefrompng($path_to_image_directory . $filename);
		}

		$ox = imagesx($im);
		$oy = imagesy($im);

		$nx = $final_width_of_image;
		$ny = floor($oy * ($final_width_of_image / $ox));

		$nm = imagecreatetruecolor($nx, $ny);

		imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

		if(!file_exists($path_to_thumbs_directory)) {
			if(!mkdir($path_to_thumbs_directory)) {
				die("There was a problem. Please try again!");
			} 
		}

		imagejpeg($nm, $path_to_thumbs_directory . $filename);
		$tn = '<img src="' . $path_to_thumbs_directory . $filename . '" alt="image" />';
		$tn .= '<br />Congratulations. Your file has been successfully uploaded, and a thumbnail has been created.';
		echo $tn;
	}
}

?>