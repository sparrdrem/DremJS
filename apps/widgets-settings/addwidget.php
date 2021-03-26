<html>
	<head>
		
	</head>
	<body>
	<script>
    document.addEventListener('contextmenu', event => event.preventDefault());
  </script>
		<?php
			echo "List of availible widgets:<br />";
                        $widgets = array_filter(glob(getenv('DOCUMENT_ROOT').'/widgets/*'), 'is_dir');
                        for($i = 0; $i<=sizeof($widgets)-1; $i++) {
				$temp = explode("/", $widgets[$i]);
                        	echo $temp[sizeof($temp)-1].' ';
			}
			echo "<br /><br />Currently enabled widgets:<br />";
			$enabledWidgets = explode("\n", file_get_contents(getenv('DOCUMENT_ROOT')."/enabled_widgets"));
			for($i = 0; $i<=sizeof($enabledWidgets)-1; $i++)
				echo $enabledWidgets[$i].' ';
			echo "<br />";
			if(array_key_exists('add', $_POST)) {
				addWidget();
			}
			function addWidget() {
				$widget = $_REQUEST['widget'];
				$widgets = array_filter(glob(getenv('DOCUMENT_ROOT').'/widgets/*'), 'is_dir');
				$enabledWidgets = explode("\n", file_get_contents(getenv('DOCUMENT_ROOT')."/enabled_widgets"));
				//print($widget.'<br />');
				//print_r($widgets);
				//print_r($enabledWidgets);
				if(in_array(getenv('DOCUMENT_ROOT').'/widgets/'.$widget, $widgets) && !(in_array($widget, $enabledWidgets))) {
					$file = fopen(getenv('DOCUMENT_ROOT').'/enabled_widgets', 'a');
					fwrite($file, $widget."\n");
					fclose($file);
					echo "Added ".$widget;
				} else {
					echo "Can't add widget - it either doesn't exist or is already enabled";
				}
			}
		?>
		<form method="post">
			<input type="text" name="widget" class="text" />
			<input type="submit" name="add" class="button" value="Add Widget" />
    		</form>
		<a href="index.php"><button type=button>Back</button></a>
	</body>
</html>
