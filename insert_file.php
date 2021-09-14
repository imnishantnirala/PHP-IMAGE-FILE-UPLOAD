<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>File Upload !</title>
  </head>
  <body>

		<?php
		$showError = false;
		$showAlert = false;;

		if( isset($_POST['upload']) ){
			include('database_connection.php');
			$title = $_POST['title'];

			$image_name = $_FILES['image_name']['name'];
			$temp_name = $_FILES['image_name']['tmp_name'];
			$image_type = $_FILES['image_name']['type'];
			$image_size =$_FILES['image_name']['size'];
			$image_ext=strtolower(end(explode('.',$_FILES['image_name']['name'])));

			$allowed_image_extension = array( "png", "jpg", "jpeg" );
			
			if( in_array($image_ext, $allowed_image_extension)=== false ){
					$showError = "extension not allowed, please choose a JPG,JPEG or PNG file.";
			}

			if( $image_size>2097152 ){
				$showError = "File size must be excately 2 MB";
			}

			if( empty($showError) == true ){
				move_uploaded_file($temp_name, "images/".$image_name);
				$showAlert = "Upload/Move Image Successefully !!";

				$sql="INSERT INTO `image_files` (`title`, `image`) VALUES ('$title', '$image_name')";
				$result = mysqli_query($connect,$sql);

				if( $result == true ){
					$showAlert =  "Image Upload Successefully !";
					echo "<script> alert('Image Upload Successefully !'); </script>";
					header("location:success.php");
				}else{
					$showError = "Image not insert in database Something wrong !";
				}

			}else{
				$showError = "imahe is not upload something went wrong !";
			}
		}
		?>

		<?php 
		if($showError){
			echo ' <div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <strong>Worning !</strong> '.$showError.'
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div> ';
			}
		if($showAlert){
			echo ' <div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <strong>Successe !</strong> '.$showAlert.'
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div> ';
			} 
		?>
		<div class="container">
			<div class="row col-sm-6 mt-5 border border-primary p-5">
				<h1 class="text-primary text-center"> Upload Images !</h1>
				<form method="post" enctype="multipart/form-data" >
				    <div class="mb-3">
				      <label class="form-label">Image Title</label>
				   	  <input type="text" class="form-control" name="title" required>
				      <div class="form-text">Write here unique title for images</div>
				   </div>
				  	<div class="input-group mb-3">
					  <input type="file" class="form-control" name="image_name" required>
					  <label class="input-group-text">Upload</label>
					</div>
				  <button type="submit" class="btn btn-primary" name="upload">Submit</button>
				</form>
			</div>
		</div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  </body>
</html>