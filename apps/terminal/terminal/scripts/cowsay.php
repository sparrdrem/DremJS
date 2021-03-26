<?php
	//header('Content-type: text/plain');
	$inputText = $_REQUEST['inputText'];
	$skin = $_REQUEST['skin'];
	$output = "";
	// Getting some information about the string to figure out how to make the
	// speech bubble. This is a terrible way of doing it, but that's a problem for
	// future Sam (aka years after I forget about making this when it breaks).
	if (strlen($inputText) > 39) {
		$wrapTextOnceFlag = True;
	} else {
		$wrapTextOnceFlag = False;
	}
	if (strlen($inputText) > 78) {
		$wrapTextTwiceFlag = True;
	} else {
		$wrapTextTwiceFlag = False;
	}
	// Now that we know how to process the speech bubble, we now need to process
	// the input string.
	if($wrapTextOnceFlag == True) {
		$output.=" _________________________________________<br />";
		if($wrapTextTwiceFlag == True) {
			$textArray = str_split($inputText, 39);
			$output.="/ ".$textArray[0]." \<br />";
			$counter = 1;
			while($counter < sizeof($textArray)-2) {
				$output.="| ".$textArray[$counter]." |<br />";
				//$output.="Adding line ".$counter." of ".sizeof($textArray)-2."<br /";
				$counter++;
			}
			$output.="\ ".$textArray[sizeof($textArray)-1].str_repeat(' ', 39-strlen($textArray[sizeof($textArray)-1]))." /<br />";
			$output.=" -----------------------------------------<br />";
			//$output.=$textArray[sizeof($textArray)-1];
		} else {
			$textArray = str_split($inputText, 39);
			$output.="/ ".$textArray[0]." \<br />";
			$output.="\ ".$textArray[1].str_repeat(' ', 39-strlen($textArray[1]))." /<br />";
			$output.=" -----------------------------------------<br />";
		}
	} else {
		$output.=" _".str_repeat("_", strlen($inputText))."_<br />";
		$output.="< ".$inputText." ><br />";
		$output.=" -".str_repeat("-", strlen($inputText))."-<br />";
	}
	if($skin == "tux") {
		$output.="      \\    .--.<br />";
		$output.="       \\  |_ |<br />";
		$output.="          |:_/ |<br />";
		$output.="         //   \\ \\<br />";
		$output.="        (|     | )<br />";
		$output.="       /'\\_   _/`\\<br />";
		$output.="       \\___)=(___/";
		/*
		      \    .--.
		       \  |_ |
		          |:_/ |
		         //   \ \
		        (|     | )
		       /'\_   _/`\
		       \___)=(___/
		*/
	} else {
		$output.="        \\   ^__^<br />";
		$output.="         \\  (oo)\\_______<br />";
		$output.="            (__)\\       )\\/\\<br />";
		$output.="                ||----w |<br />";
		$output.="                ||     ||";
		/*
		        \   ^__^
		         \  (oo)\_______
		            (__)\       )\/\
		                ||----w |
		                ||     ||
		*/
	}
	echo $output;
?>
