<?php
	header("Location: index.php");
	file_put_contents(getenv('DOCUMENT_ROOT').'/enabled_widgets', '');
?>
