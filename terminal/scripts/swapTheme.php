<?php
	$theme = file_get_contents('../configs/theme.conf');

	if($theme == "1") {
		file_put_contents('../configs/theme.conf', '0');
	} else {
		file_put_contents('../configs/theme.conf', '1');
	}

?>
