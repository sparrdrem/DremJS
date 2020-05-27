<html>
	<head>
		
	</head>
	<body>
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
				addWidgets();
			} else if(array_key_exists('remove', $_POST)) {
				removeWidgets();
			}
			function addWidgets() {
				echo "Add";
			}
			function removeWidgets() {
				echo "Remove";
			}
		?>
		<a href="addwidget.php"><button type=button>Add Widget</button></a>
		<a href="removewidget.php"><button type=button>Clear Widget List</button></a>
		<p>Changes take effect after restart.</p>
	</body>
</html>
