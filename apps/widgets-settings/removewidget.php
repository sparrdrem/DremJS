<?php
	header("Location: index.php");
	file_put_contents(getenv('DOCUMENT_ROOT').'/etc/enabled_widgets', '');
?>
