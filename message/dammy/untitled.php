<?php
	$sample = $_FILES['image_uplode']['tmp_name'];

	move_uploaded_file($sample, 'image_uplode/'.$user_id.'_'.$_FILES['image_uplode']['name']);

?>