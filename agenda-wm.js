/*
 * _____/\\\\\\\\\______________________________________________________/\\\_________________        
 *  ___/\\\\\\\\\\\\\___________________________________________________\/\\\_________________       
 *   __/\\\/////////\\\___/\\\\\\\\______________________________________\/\\\_________________      
 *    _\/\\\_______\/\\\__/\\\////\\\_____/\\\\\\\\___/\\/\\\\\\__________\/\\\___/\\\\\\\\\____     
 *     _\/\\\\\\\\\\\\\\\_\//\\\\\\\\\___/\\\/////\\\_\/\\\////\\\____/\\\\\\\\\__\////////\\\___    
 *      _\/\\\/////////\\\__\///////\\\__/\\\\\\\\\\\__\/\\\__\//\\\__/\\\////\\\____/\\\\\\\\\\__   
 *       _\/\\\_______\/\\\__/\\_____\\\_\//\\///////___\/\\\___\/\\\_\/\\\__\/\\\___/\\\/////\\\__  
 *        _\/\\\_______\/\\\_\//\\\\\\\\___\//\\\\\\\\\\_\/\\\___\/\\\_\//\\\\\\\/\\_\//\\\\\\\\/\\_ 
 *         _\///________\///___\////////_____\//////////__\///____\///___\///////\//___\////////\//__
 *					"So, what's on the agenda?"
 *					(C) Innovation Inc. 2020
 */
var detector = new MobileDetect(window.navigator.userAgent)
var highestId = 0;
var CurrentTaskbarApp = "";

function initAgendaWM() {
	//var detector = new MobileDetect(window.navigator.userAgent)
	if(!(detector.mobile())) {
		console.log("Initializing Agenda WM");
		startTime();
		console.log("Starting widgets");
		startWidgets();
		makeDraggable();
		console.log("Agenda WM Initialized");
	} else {
		initAgendaMobile();
	}
} // Initialize Agenda

// Desktop version of Agenda

function makeDraggable() {
	$(".framewrap")
        .draggable()
        .resizable();
} // Makes all applications with the framewrap class draggable. Has to be ran every time applications are launched or things get sticky.

/*function moveToFront(app) {
	var application = document.getElementById(app);
	if(openflag==true)
		application.style.display = "block";
	openflag = true;
    $('.framewrap').css('z-index', 1);
	$('#' + app).css('z-index', 9999);
	console.log("Move to front");
} // Move a clicked application to the front*/

function moveToFront(app) {
	$('.framewrap').css('z-index', 1);
	$('.framewrapMobile').css('z-index', 1);
	$('#' + app).css('z-index', 9999);
} // Move a clicked application to the front

function openApplication(app, width, height, appIcon, filename) {
	// Set width and height as default if one is <=-1
        if (width <= -1 || height <= -1 || width == undefined || height == undefined) {
	        width="500";
	        height="300";
	}
	if (filename == undefined) {
		file = "";
	} else {
		file = filename;
	}
	var i = 0;
        // Get the first available application ID.
        while ($('#' + i).length)
        	i++;
           /*
           This is just the following as a string:
           <div onclick=moveToFront('[windowID]') id='[windowID]' class='framewrap' style='width:[width]px; height=[height]px'>
               <input type='button' onclick="closeApplication('[windowID]')" value='X' />
               <input type='button' onclick="maximizeApplication('[windowID]')" value='\u25A1' />
               <input type='button' onclick="minimizeApplication('[windowID]')" value='_' />
               <iframe class='appFrame' src='apps/[application name]'></iframe>
           </div>
           [windowID] is replaced with i (defined above)
           [application name] is replaced with parameter "app" (used to determine the application name to open).

           The app parameter points to a subdirectory called apps. This means if you were to run openApplication(foo), it will attempt to open an
           Application stored at apps/foo/

           Quite frustrating to work with, but it works. I'll make it fancier later, but right now it is good enough.
           */
            //var application="<div onclick=\"moveToFront('" + i + "')\" name='" + app + "' id='" + i + "' class='framewrap' style='width:" + width + "px; height:" + height + "px'><td nowrap><input type='button' onclick=\"closeApplication('" + i + "')\" value='X' /><input type='button' onclick=\"maximizeApplication('" + i + "')\" value='\u25A1' /><input type='button' onclick=\"minimizeApplication('" + i + "')\" value='_' /><p>Application Name</p></td><iframe class='appFrame' src='apps/" + app + "/" + file + "'></iframe></div>";
			//var taskbarApp="<div id='task" + i + "' onclick=\"moveToFront('" + i + "')\" class='taskbarApps'><img src='apps/" + app + "/" + appIcon + "' style='width:32px;height:32px' align='middle' /></div>";
			if (!(detector.mobile())) {
				var application="<div onclick=\"moveToFront('" + i + "')\" name='" + app + "' id='" + i + "' class='framewrap' style='width:" + width + "px; height:" + height + "px'><input type='button' onclick=\"closeApplication('" + i + "')\" value='X' /><input type='button' onclick=\"maximizeApplication('" + i + "')\" value='\u25A1' /><input type='button' onclick=\"minimizeApplication('" + i + "')\" value='_' /><iframe name='" + i + "' id='app" + i + "' class='appFrame' src='apps/" + app + "/'></iframe></div>";
				var taskbarApp="<div onmousedown='SetCurrentTaskbarApp(" + i + ")' onmouseup='SetCurrentTaskbarApp(\"\")' id='task" + i + "' onclick=\"minimizeApplication('" + i + "')\" class='taskbarApps'><img src='apps/" + app + "/" + appIcon + "' style='width:32px;height:32px' align='middle' /></div>";
			} else {
				var application="<div onclick=\"moveToFront('" + i + "')\" name='" + app + "' id='" + i + "' class='framewrapMobile' style='width:" + width + "px; height:" + height + "px'><input type='button' onclick=\"showContextMenu('app" + i + "')\" value='&#9660;' /><iframe name='" + i + "' id='app" + i + "' class='appFrameMobile' src='apps/" + app + "/'></iframe></div>";
				var taskbarApp="<div tabindex='0' onmousedown='SetCurrentTaskbarApp(" + i + ")' id='task" + i + "' onclick=\"moveToFront('" + i + "'); SetCurrentTaskbarApp(" + i + ")\" class='taskbarApps'><img src='apps/" + app + "/" + appIcon + "' style='width:32px;height:32px' align='middle' /></div>";
				//  touchstart='SetCurrentTaskbarApp(" + i + ")' touchend='SetCurrentTaskbarApp(\"\")'
				//  onmouseup='SetCurrentTaskbarApp(\"\")'
			}
			var parent=document.getElementById('appContainer');
            parent.insertAdjacentHTML('beforeend', application);
            var parent=document.getElementById('taskbarApps');
			parent.insertAdjacentHTML('beforeend', taskbarApp);
			if (width == "max" || height == "max")
       	        maximizeApplication(i);
            moveToFront(i);
			makeDraggable();
			if (detector.mobile()) {
				maximizeApplication(i);
			}
			if (i>highestId)
				highestId=i;
        } // Opens an application.
	function openWidget(widget, filename) {
		if (filename == undefined) {
			file = "";
        	} else {
                	file = filename;
        	}
		var i = 0;
		// Get the first available application ID.
		while ($('#' + i).length)
    			i++;
		var newWidget = "<div name='" + widget + "' id='" + i + "' class='framewrap' style='width:300px;height:300px;'><br /><iframe class='appFrame' src='widgets/" + widget + "/" + file + "'></iframe></div>";
		var parent=document.getElementById('appContainer');
                parent.insertAdjacentHTML('beforeend', newWidget);
		makeDraggable();
	} // Start a new widget

	function startWidgets() {
		jQuery.get('/enabled_widgets', function(data) {
			var widgets = data.split("\n");
			for(i = 0; i < widgets.length-1; i++) {
				if(true) {
					console.log('Opening ' + widgets[i]);
					openWidget(widgets[i]);
				} else {
					console.log("ERROR: Can't open widget - a network error occurred. This probably means this widget does not exist. Ignoring.");
				}
			}
		});
	} // Start all enabled widgets

	function closeApplication(id) {
        if(idExists(id)) {
            var application = document.getElementById(id);
            var taskbarApp = document.getElementById('task' + id);
            application.parentNode.removeChild(application);
		if(taskbarApp != null)
	        taskbarApp.parentNode.removeChild(taskbarApp);
        } else {
            console.log("Application with ID " + id + " does not exist. Ignoring.");
		}
	} // Closes an application.

    function maximizeApplication(id, DoNotMoveToFront) {
		if($("#" + id).length) {
			if(document.getElementById(id).style.display == "none")
				application.style.display = "block";
			windowheight = window.innerHeight-42;
			//document.getElementById(id).setAttribute('style', "height: 92%; width: 99%; top: 42px; left: 0px");
			document.getElementById(id).setAttribute('style', "height: " + windowheight + "px; width: 100%; top: 42px; left: 0px");
			if(!DoNotMoveToFront)
				moveToFront(id);
		}
		//document.getElementById(id).setAttribute('style', "height: " + (window.innerHeight-42) + "px; width: " + window.innerHeight + "; top: 42px; left: 0px");
    } // Maximize application
        
    /*function minimizeApplication(id) {
        var application = document.getElementById(id);
        if (application.style.display === "none") {
            application.style.display = "block";
        } else {
            application.style.display = "none";
		}
		openflag=false;
		console.log("Minimize");
	} // Minimize application*/
	
	function minimizeApplication(id, DisallowUnminimize) {
		var application = document.getElementById(id);
		if (application.style.display === "none" && !DisallowUnminimize) {
			application.style.display = "block";
		} else {
			application.style.display = "none";
		}
	} // Minimize application
        
    function idExists(id) {
        if ($('#' + id).length)
            return $('#' + id).attr('name');
        else
            return false;
    } // Check if an ID exists

	function startTime() {
    	var today = new Date();
    	var h = today.getHours();
    	var m = today.getMinutes();
    	var s = today.getSeconds();
    	m = checkTime(m);
    	s = checkTime(s);
    	document.getElementById('txt').innerHTML =
    	h + ":" + m + ":" + s;
    	var t = setTimeout(startTime, 500);
	} // Tick tock, Mr. Wick...
        
	function checkTime(i) {
		if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
		return i;
	}

/*function returnStatus(req, status) {
	//console.log(req);
	if(status == 200) {
		console.log("The url is available");
		// send an event
  	} else {
		console.log("The url returned status code " + status);
		// send a different event
	}
}*/

function fetchStatus(address) {
	var client = new XMLHttpRequest();
	client.onreadystatechange = function() {
	// in case of network errors this might not give reliable results
	if(this.readyState == 4)
		return this.status;
	}
	client.open("HEAD", address);
	client.send();
}

// Below are helper functions for making the "Close Application" function in DremJS possible. They may come in handy for other reasons, too.
function SetCurrentTaskbarApp(id, AutoDisable) {
	//console.log("SET: " + id);
	CurrentTaskbarApp = "" + id;
} // Sets or mutates CurrentTaskbarApp

function GetCurrentTaskbarApp() {
	//console.log("GET: " + CurrentTaskbarApp);
	return CurrentTaskbarApp;
} // Accessor for CurrentTaskbarApp

// Mobile version of Agenda

function initAgendaMobile() {
	console.log("Initializing Agenda Mobile");
	startTime();
	console.log("Starting widgets");
	startWidgets();
	makeDraggable();
	console.log("Agenda Mobile Initialized");
}

function maximizeAllApplications() {
	for(i=0; i<=highestId; i++)
		maximizeApplication(i, true);
}

function minimizeAllApplications() {
	for(i=0; i<=highestId; i++)
		minimizeApplication(i, true);
}

$(window).resize(function() {
	if(detector.mobile())
		maximizeAllApplications();
});

/*function showContextMenu() {
	try {
		parent.showContextMenu();
	} catch(e) { }
}*/