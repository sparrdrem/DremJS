<?php
    $file = "/home/user/Pictures/Default.png";

    function GenerateTagForMedia($path) {
        global $file;
        // What even is this massive statement? The answer may shock you.
        // (it's laziness)
        if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "shuffle") {
            return ShuffleMusic();
        }
        if(isset($_REQUEST["openfile"])) {
            if(file_exists($_SERVER["DOCUMENT_ROOT"].$_REQUEST["openfile"]) && !is_dir($_SERVER["DOCUMENT_ROOT"].$_REQUEST["openfile"])) {
                $mime = mime_content_type($_SERVER["DOCUMENT_ROOT"].$_REQUEST["openfile"]);
                if(strstr($mime, "video/")){
                    return "<video class='media' controls autoplay>\
                                <source src='".$_REQUEST["openfile"]."' type='".$mime."'>\
                            </video>";
                            // This basically depends on the video tag to support the video and is dumb. 
                }else if(strstr($mime, "image/")){
                    return "<img class='media' src='".$_REQUEST['openfile']."'>";
                }else if(strstr($mime, "audio/")){
                    return "<audio controls autoplay>\
                                <source src='".$_REQUEST["openfile"]."' type='".$mime."'>\
                            </audio>";
                }
            } else {
                return "<img class='media' src='assets/images/Default.png'>";
            }
        } else {
            return "<img class='media' src='assets/images/Default.png'>";
        }
    }

    function ShuffleMusic() {
        // Build array of all music in the user's Music directory
        $files = scandir("/home/user/Music/");
        $music = array();
        $temp = "";
        
        // Find all files that have .mp3, .wav, or .ogg (not case sensitive) and put them into the $music array
        for ($i = 0; $i < count($files); $i++) {
            if (count($temp) >= 5) {
                $temp = substr($files[$i], count($files[$i]-4));
            } else {
                $temp = "StringTooSmallSkipping";
            }
            if($temp == ".mp3" || $temp == ".wav" || $temp == ".ogg") {
                $music[] = $files[$i];
            }
        }
    }

    /*if($_REQUEST["action"] == "shuffle") {
        ShufleMusic();
    }*/
?>

<html>
    <head>
        <style>
            body {
		        font-family: Calibri;
                background-color: white;
	        }
            .container {
	            width: 80%;
	            margin: auto;
	            padding: 0px;
            }
            .left {
	            width: 30%;
	            float: left;
           	}
            .right {
	            margin-left: 5%;
            }
            .openDialog {
                position: absolute;
                background: #D3D3D3;
                top: 5%;
                left: 5%;
                width: 90%;
                padding: 5px;
                display: none;
            }

            .aboutDialog {
                position: absolute;
                background: #D3D3D3;
                top: 5%;
                left: 5%;
                width: 90%;
                height: 90%;
                padding: 5px;
                display: none;
            }
            .actionbar {
                height: 42px;
                width: 100%;
                background-color: black;
            }
            .actionbarbutton {
                width: 32px;
                height: 32px;
                border: 10px;
            }
            .media {
                height: 95%;
                width: auto;
                vertical-align: middle;
            }
        </style>
    </head>
    <body onload="Init();">
        <script type="text/javascript">
            document.addEventListener('contextmenu', event => event.preventDefault());
            function GetDremJSMenuFunctions() {
                return [
                    ["Open", "OpenDocumentDialog();"],
                    ["<hr />", ""],
                    ["Shuffle", "ShuffleMusic();"],
                    ["<hr />", ""],
                    ["Toggle Light", "ToggleLight();"],
                    ["<hr />", ""],
                    ["About", "About();"]
                ];
            }

            CurrentFile = "/home/user/";
            var MediaTag = "";

            function Init() {
                //document.getElementById("writingto").innerHTML = "Writing to: " + CurrentFile;
                MediaTag = "<?php echo GenerateTagForMedia("/home/user/Pictures/Default.png"); ?>";
                document.getElementById("open").value = CurrentFile;
                
                document.getElementById('MediaBox').innerHTML=MediaTag;
            }

            function OpenDocumentDialog() {
                document.getElementById("openDialog").style.display = "block";
            }

            function OpenDocument() {
                /*$.ajax({
                    url : window.location.href,
                    type : "POST",
                    data : {action : "open", open : document.getElementById("open").value},
                    success: function(data, textStatus, jqXHR) { 
                        //console.log(data);// You can see the result which is created in chat.php
                        console.log("Successfully Opened");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);// if there is an error
                    }
                });*/
                //CurrentFile = document.getElementById("open").value;
                //CancelOpen();
                //Init();
                window.location.href = "index.php?action=open&openfile=" + document.getElementById("open").value;
            }

            function CancelOpen() {
                document.getElementById("openDialog").style.display = "none";
            }

            function About() {
                document.getElementById("aboutDialog").style.display = "block";
            }

            function CloseAbout() {
                document.getElementById("aboutDialog").style.display = "none";
            }

            function ToggleLight() {
                if (document.getElementsByTagName("body")[0].style.backgroundColor === "black") {
			        document.getElementsByTagName("body")[0].style.backgroundColor = "white";
		        } else {
			        document.getElementsByTagName("body")[0].style.backgroundColor = "black";
		        }
            }

            function ShuffleMusic() {
                $.ajax({
                    type:'POST',
                    url:'index.php',
                    data:'action=shuffle',
                    success:function(data) {
                        if(data=="Something") {
                            // Do Something
                        } else {
                            // Do Something
                        }   
                    }           
                });
                window.location.href = "index.php?action=shuffle";
            }
        </script>
        <!--<div id="actionBar" class="actionbar">
            <div id="light" class="actionbarbutton left">
                <img style="width:42px;height:42px;" src="assets/images/lightbulb-on-white.png" />
            </div>
        </div>-->
        <center>
            <div id="MediaBox">

            </div>
        </center>

        <div id="openDialog" class="openDialog">
            <p>Input the path to the media file you would like to open. You can use the File Manager to find the path.</p>
            <!--<form action="index.php" method="POST">
                <input type="hidden" name="action" value="open" />-->
            <input type="text" id="open" name="open" size="50" />
            <input type="submit" id="OpenFile" onclick="OpenDocument()" value="Open File" />
            <!--</form>-->
            <input type="button" onclick="CancelOpen()" value="Cancel" />
        </div>

        <div id="aboutDialog" class="aboutDialog container">
            <div class="left">
			    <img src="cinema.png" style="width:128px;height:128px" />
		    </div>
		    <div class="right">
			    <h1>About DremJS Cinema</h1>
			    <h2>Version: 0.1.0b</h2>
            </div>
            <p>
                Open: Opens a media file.<br />
                Toggle Light: Toggles the background to be white or black (easier on the eyes)<br />
            </p>
            <center><input type="button" onclick="CloseAbout()" value="Close" /></center>
            <p>
        </div>


    </body>
</html>