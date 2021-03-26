<?php
    //if(!isset($_POST["open"])) {
    $file = "/home/user/Documents/NewFile.txt";
    //} else {
    //$file = $_POST["open"];
    //}
    function GetFileContents() {
        global $file;
        if(isset($_REQUEST["openfile"]))
            return file_get_contents($_SERVER["DOCUMENT_ROOT"].$_REQUEST["openfile"]);
        return file_get_contents($_SERVER["DOCUMENT_ROOT"].$file);
    }

    function SaveDocument() {
        //$currentUser = $_SERVER["DOCUMENT_ROOT"]."/home/user";
        $writeto = fopen($_SERVER["DOCUMENT_ROOT"].$_REQUEST["file"], "w");
        fwrite($writeto, $_REQUEST["text"]);
        fclose($writeto);
    }
    if (isset($_REQUEST["action"])) {
        if($_REQUEST["action"] == "save") {
            SaveDocument();
        } elseif ($_REQUEST["action"] == "open") {
            global $file;
            $file = $_REQUEST["openfile"];
            if(!is_file($_SERVER["DOCUMENT_ROOT"].$file)) {
                $writeto = fopen($_SERVER["DOCUMENT_ROOT"].$file, "w");
                fclose($writeto);
            }
        } else {
        
        }
    }
?>

<html>
    <head>
        <style>
            body {
		        font-family: Calibri;
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
        </style>
    </head>
    <body onload="Init();">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            CurrentFile = "<?php echo $file; ?>";
            
            function Init() {
                document.getElementById("writingto").innerHTML = "Writing to: " + CurrentFile;
                document.getElementById("inputbox").value = "<?php echo GetFileContents(); //echo file_get_contents($_SERVER["DOCUMENT_ROOT"].$file); ?>";
                document.getElementById("open").value = CurrentFile;
            }

            document.addEventListener('contextmenu', event => event.preventDefault());
            function GetDremJSMenuFunctions() {
                return [
                    ["Open", "OpenDocumentDialog();"],
                    ["Save", "SaveDocument();"],
                    ["<hr />", ""],
                    ["Copy", "CopyText();"],
                    ["Paste", "PasteText();"],
                    ["<hr />", ""],
                    ["About", "About();"]
                ];
                // Scrapped
                // ["New", "NewDocument();"],
                // ["Save As...", "SaveDocumentAs();"],
                // ["Delete", "DeleteSelected();"],
            }

            function SaveDocument() {
                //document.getElementById("form").submit();
                //console.log(document.getElementById("inputbox").value);
                $.ajax({ 
                    url : window.location.href, 
                    type: "POST", 
                    data : {action : "save", text : document.getElementById("inputbox").value, file : CurrentFile}, 
                    success: function(data, textStatus, jqXHR) { 
                        //console.log(data);// You can see the result which is created in chat.php
                        console.log("Successfully Saved");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);// if there is an error
                    }
                });
                //Init();
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
                //console.log(document.getElementById("open").value);
                window.location.href = "index.php?action=open&openfile=" + document.getElementById("open").value;
            }

            function CancelOpen() {
                document.getElementById("openDialog").style.display = "none";
            }

            function CopyText() {
                document.execCommand("copy");
            }

            function PasteText() {
                box = document.getElementById("inputbox");
                box.focus();
                navigator.clipboard.readText()
                    .then(text => {
                        loc = box.value.slice(0, box.selectionStart).length;
                        value = document.getElementById("inputbox").value;
                        document.getElementById("inputbox").value = value.substring(0, loc) + text + value.substring(loc, value.length);
                    })
                    .catch(err => {
                        console.error('Failed to read clipboard contents: ', err);
                    });
            }

            function About() {
                document.getElementById("aboutDialog").style.display = "block";
            }

            function CloseAbout() {
                document.getElementById("aboutDialog").style.display = "none";
            }
        </script>
        <!--<form>
            <label>DremJS Notepad</label>
            <br />
            <textarea id="inputbox" name="inputbox" rows="50" columns="500"></textarea>
        </form>-->
        <div id="openDialog" class="openDialog">
            <p>Input the path to the document you would like to open. You can use the File Manager to find the path.</p>
            <!--<form action="index.php" method="POST">
                <input type="hidden" name="action" value="open" />-->
            <input type="text" id="open" name="open" size="50" />
            <input type="submit" id="OpenFile" onclick="OpenDocument()" value="Open File" />
            <!--</form>-->
            <input type="button" onclick="CancelOpen()" value="Cancel" />
        </div>
        <div id="aboutDialog" class="aboutDialog container">
            <div class="left">
			    <img src="notepad.png" style="width:128px;height:128px" />
		    </div>
		    <div class="right">
			    <h1>About DremJS Notepad</h1>
			    <h2>Version: 0.1.0b</h2>
            </div>
            <p>
                Open: Opens or creates a new document.<br />
                Save: Saves the current document.<br />
                Copy: Copies selected text to the clipboard.<br />
                Paste: Pastes the text in the clipboard to where the cursor is (requires clipboard access).
            </p>
            <center><input type="button" onclick="CloseAbout()" value="Close" /></center>
            <p>

        </div>
        <textarea id="inputbox" name="text" rows="23" cols="90"></textarea>
        <p id="writingto"></p>
    </body>
</html>