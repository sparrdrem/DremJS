<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script src="jquery.ui.touch-punch.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css"/>
		<!-- classes were from SparrOS Developer Team -->
    		<title>DremJS</title>
    		<style>
      			.framewrap {
        			width:500px;
        			height:300px;
    				padding:10px;
        			position: fixed;
        			top: 50px;
        			left: 10px;
        			background-color:#87CEEB;
					box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      			}
				.framewrapMobile {
        			width:100%;
        			height:100%;
    				/*padding:10px;*/
        			position: fixed;
        			top: 50px;
        			left: 0px;
        			background-color:#87CEEB;
					box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      			}
      			.appFrame {
        			width:99%;
        			height:93%;
    				background-color:#FFFFFF;
      			}
				.appFrameMobile {
        			width:99%;
        			height:99%;
    				background-color:#FFFFFF;
      			}
      			.cwhite {
        			color: white;
     			}
      			.br1 {
        			position: absolute;
        			bottom: 8px;
        			right: 16px;
        			font-size: 12px;
      			}
      			.br2 {
        			position: absolute;
        			bottom: 22px;
        			right: 16px;
        			font-size: 12px;
      			}
      			.br3 {
        			position: absolute;
        			bottom: 36px;
        			right: 16px;
        			font-size: 12px;
      			}
      			html { 
        			background: url(DremJS-Background.png) no-repeat center center fixed; 
        			-webkit-background-size: cover;
        			-moz-background-size: cover;
        			-o-background-size: cover;
        			background-size: cover;
      			}
				body {
					font-family: Calibri;
					margin:0px;
				}
				a:link {
        			color: black;
					text-decoration: none;
      			}
      			a:visited {
					color: black;
					text-decoration: none;
      			}
      			.cent {
        			position: relative;
				    top: 4px;
                }
      			.taskbar {
                    background-color: black;
                    position: absolute;
                    top: 0;
                    right: 0;
                    width: 100%;
					/*z-index: 20000;*/
                }
                .taskbarTime {
                    height: 42px;
                    float: left;
                }
                .taskbarApps {
                    text-align: center;
                    float: left;
                    margin-left: 5px;
                    margin-top: 2px;
                }
				.startbtn {
					background-color: transparent;
					color: black;
					padding: 8px; // Bad way of doing this but that's a problem for future Sam
					font-size: 16px;
					border: none;
					z-index: 30000;
				}
				.start-content {
					display: none;
  					position: absolute;
					right:0px;
  					background-color: #f9f9f9;
  					min-width: 200px;
  					box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  					padding: 12px 16px;
  					z-index: 30000;
				}
				.start {
					position: absolute;
					display: inline-block;
					top:0px;
					right:0px;
					z-index:30000;
				}
				.start-content a:hover {background-color: #ccc}
				.start:hover .start-content {
					display: block;
				}
				.start:hover .startbtn {
					background-color: gray;
				}
				#context-menu {
					position:fixed;
					z-index:30000;
					width:150px;
					background:#1b1a1a;
					/*border-radius:5px;*/
					transform:scale(0);
					transform-origin:top left;
				}
				#context-menu.active {
					transform:scale(1);
					transition:transform 300ms ease-in-out;
				}
				#context-menu .item {
					padding:8px 10px;
					font-size:15px;
					color:#eee;
				}
				#context-menu .item:hover {
					background:#555;
				}
				#context-menu .item i {
					display:inline-block;
					margin-right:5px;
				}
				#context-menu hr {
					margin:2px 0px;
					border-color:#555;
				}
		</style>
  	</head>
    <body onload="initAgendaWM(); touchstart();">
	<div id="main" tabindex="-1">
	  	<p class="cwhite br2">DremJS Version 0.1.7b</p>
		<p class="cwhite br1">&copy; Innovation Inc.</p>
		<div id="context-menu">
			
		</div>
		<div class="start">
			<button class="startbtn"><img src="logo.png" style="width:24px;height24px;"></button>
			<div class="start-content">
				<a onclick="openApplication('about', 800, 500, 'about.png')"><p><img src="apps/about/about.png" align="top"> About DremJS</p></a>
				<a onclick="openApplication('howto', 800, 500, 'howto.png')"><p><img src="apps/howto/howto.png" align="top"> How to Install Applications</p></a>
				<a onclick="openApplication('market', 'max', 'max', 'market.png')"><p><img src="apps/market/market.png" align="top"> DremJS Market</p></a>
				<a onclick="openApplication('debug', 700, 450, 'debug.png')"><p><img src="apps/debug/debug.png" align="top"> Report a Bug</p></a>
				<a onclick="openApplication('FileManager', 700, 450, 'filemanager.png')"><p><img src="apps/FileManager/filemanager.png" align="top" width="16" height="16"> File Manager</p></a>
				<a onclick="openApplication('Cinema', 700, 450, 'cinema.png')"><p><img src="apps/Cinema/cinema.png" align="top" width="16" height="16"> Cinema</p></a>
				<a onclick="openApplication('Notepad', 700, 450, 'notepad.png')"><p><img src="apps/Notepad/notepad.png" align="top" width="16" height="16"> Notepad</p></a>
				<a onclick="openApplication('terminal', 700, 450, 'terminal.png')"><p><img src="apps/terminal/terminal.png" align="top" width="16" height="16"> Terminal</p></a>
                <a onclick="openApplication('serverstatus', '300', '300', 'serverstatus.png')"><p><img src="apps/serverstatus/serverstatus.png" align="top" style="width:16px;height:16px;"> Server Status</p></a>
				<a onclick="openApplication('widgets-settings', -1, -1, 'widgets-settings.png')"><p><img src="apps/widgets-settings/widgets-settings.png" align="top" style="width:16px;height:16px"> Widgets Settings</p></a>
				<hr />
				<a target="_top" href="shuttingdown.html"><p><img src="shutdown.png" align="top" style="width:16px;height:16px;"> Shutdown DremJS</p></a>
			</div>
		</div>
   		<div id="appContainer">
        <!-- This is the taskbar -->
        <div id="taskbar" class="taskbar">
            <div id="taskbarTime" class="taskbarTime">
                <!-- Add apps here -->
                <div class="cwhite" style="text-align:left" id="txt"></div> <a onclick="openApplication('about', 800, 500, 'about.png')"><img src="apps/about/about.png"> |</a>
                </div>
                <div id="taskbarApps" class="taskbarApps">
            
                </div>
        	</div>
		</div>
	</div>
	<script src="mobile-detect.js"></script>
	<script src="agenda-wm.js"></script>
	<script>
		var counter;
		var pressHoldDuration = 50;
		var pressHoldEvent = new CustomEvent("pressHold");
		var timerID;
		//var currentSelectedTaskbarApp = "";
		var allowContextMenuFlag = true;
		var firstTouchFlag = false;

		$("#context-menu").hover(function() {
			allowContextMenuFlag = false;
		}, function() {
			allowContextMenuFlag = true;
		})
		window.addEventListener("contextmenu",function(event){
			event.preventDefault();
		});
		window.onmousedown = function(eventData) {
  			if (eventData.button === 2) {
				showContextMenu();
  			}
		}
		window.addEventListener("click",function(){
			closeContextMenu();
		});
		function showContextMenu(appid) {
			if(allowContextMenuFlag == false) { return; }
			// Base context menu
			var contextMenuItems = '<!-- DremJS Global Functions -->'				
				/*<div onclick="" class="item">\
				<i class="fa"></i> Item\
				</div>*/
			if(!detector.mobile()) {
				contextMenuItems+='<div onclick="minimizeAllApplications();" class="item">\
					<i class="fa"></i> Show Desktop\
				</div>'
			}
			contextMenuItems+='</hr>\
				<!-- Application-Specific Functions -->\
				\
				'
			if(GetCurrentTaskbarApp() != "") {
				contextMenuItems+='<div onclick="closeApplication(' + GetCurrentTaskbarApp() + ')" class="item">\
					<i class="fa"></i> Close Application\
				</div>';
			} else if($(":focus").attr('class') == "taskbarApps") {
				contextMenuItems+='<div onclick="closeApplication(' + $(":focus").attr('id').substr(4, $(":focus").attr('id').length) + ')" class="item">\
					<i class="fa"></i> Close Application\
				</div>';
			}
			SetCurrentTaskbarApp("");
			// Grab 2D array of elements and corresponding JavaScript functions (should be JSON but I don't know how to JSON)
			var failedFlag = false;
			//if(appid) {
			id=appid;
			//} else {
			//	var id=$(':focus').attr('id');
			//}
			try {
				var applicationFunctions = document.getElementById(id).contentWindow.GetDremJSMenuFunctions();
			} catch(e) {
				//console.log("An error occured trying to get custom context menu functions from the application. This probably means the application hasn't been updated for modern versions of DremJS. No custom context menu items will be displayed.")
				//console.log(e);
				failedFlag = true;
			}
			if (failedFlag == false) {
				contextMenuItems+="<hr />"
				for(i=0; i<applicationFunctions.length; i++) {
					if(applicationFunctions[i][0] == "<hr />")
						contextMenuItems+="<hr />";
					else
						contextMenuItems+="<div class='item' onclick=\"document.getElementById('" + id + "').contentWindow." + applicationFunctions[i][1] + "\">\n\t<i class='fa'></i> " + applicationFunctions[i][0] +"\n</div>";
				}
				//console.log(contextMenuItems);
			}
			//console.log(contextMenuItems);
			var contextElement = document.getElementById("context-menu");
			contextElement.innerHTML = '';
			contextElement.insertAdjacentHTML('beforeend', contextMenuItems);
			//posX = event.clientX;
			//posY = event.clientY;
			
			if(!(detector.mobile())) {
				posX = event.clientX;
				posY = event.clientY;
				if(appid || (document.getElementById(id) && document.getElementById(id).tagName == "IFRAME")) {
					posX = document.getElementById(id).getBoundingClientRect().left + posX;
					posY = document.getElementById(id).getBoundingClientRect().top + posY;
				}
				contextElement.style.top = posY + "px";
				contextElement.style.left = posX + "px";
			} else {
				// This is what we in the business call a bodge
				if(appid) {
					contextElement.style.top = document.getElementById(id).getBoundingClientRect().top + "px";
					contextElement.style.left = document.getElementById(id).getBoundingClientRect().left + "px";
				} else {
					contextElement.style.top = clientY + "px";
					contextElement.style.left = clientX + "px";
				}
				
			}
			setTimeout(function() { contextElement.classList.add("active"); }, 10);
		}

		function closeContextMenu() {
			document.getElementById("context-menu").classList.remove("active");
		}

		function canAccessIFrame(iframe) {
			var html = null;
    		try { 
				var doc = iframe.contentDocument || iframe.contentWindow.document;
				html = doc.body.innerHTML;
    		} catch(err){
      			return false;
    		}

    		return true;
		}
		var monitor = setInterval(function(){
			//var elem = document.activeElement;
			var elem = $(':focus');
			if(elem && $(elem).prop("tagName") == 'IFRAME' && canAccessIFrame(elem.get(0))){
				elem.contents().find("body").mousedown(function(event) {
					switch (event.which) {
						case 1:
							//console.log('Left mouse button pressed - ' +  elem.attr('name'));
							closeContextMenu();
							break;
						case 2:
							//console.log('Middle mouse button pressed');
							break;
						case 3:
							//console.log('Right mouse button pressed - ' + elem.attr('id'));
							showContextMenu(elem.attr('id'));
							break;
						default:
							console.log('You have a strange mouse');
							break;
					}
				});
			}
		}, 100);
		
		var clientX;
		var clientY;
		var startX;
		var startY;
		var currentX;
		var currentY;

		var onlongtouch; 
		var timer;
		var touchduration = 800; //length of time we want the user to touch before we do something

		window.addEventListener('touchstart', function(e) {
			clientX = e.touches[0].clientX;
			clientY = e.touches[0].clientY;
			currentX = clientX;
			currentY = clientY;
			//DelayBeforeContextMenu = setTimeout(showContextMenu(), touchduration);
		});

		function touchstart(e) {
			//e.preventDefault();
			startX = clientX;
			startY = clientY;
			if (!timer) {
				timer = setTimeout(onlongtouch, touchduration);
			}
		}

		function touchend() {
			//stops short touches from firing the event
			if (timer) {
				clearTimeout(timer);
				timer = null;
			}
		}

		onlongtouch = function() { 
			timer = null;
			if(firstTouchFlag && Math.abs(startX - currentX) < 50 && Math.abs(startY - currentY) < 50) {
				showContextMenu();
			} else {
				firstTouchFlag=true;
			}
		};

		function updateXY(e) {
			currentX = e.touches[0].clientX;
			currentY = e.touches[0].clientY;
		}

		document.addEventListener("DOMContentLoaded", function(event) { 
			window.addEventListener("touchstart", touchstart, false);
			window.addEventListener("touchend", touchend, false);
			window.addEventListener("touchmove", updateXY, true);
		});
	</script>
	</body>
</html>
