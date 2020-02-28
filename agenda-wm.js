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

function initAgendaWM() {
	startTime();
	makeDraggable();
} // Initialize Agenda

function makeDraggable() {
	$(".framewrap")
        .draggable()
        .resizable();
} // Makes all applications with the framewrap class draggable. Has to be ran every time applications are launched or things get sticky.

function moveToFront(app) {
        $('.framewrap').css('z-index', 1);
	$('#' + app).css('z-index', 9999);
} // Move a clicked application to the front

function openApplication(app, width, height, appIcon) {
	// Set width and height as default if one is <=-1
        if (width <= -1 || height <= -1 || width == undefined || height == undefined) {
	        width="500";
	        height="300";
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
            var application="<div onclick=\"moveToFront('" + i + "')\" name='" + app + "' id='" + i + "' class='framewrap' style='width:" + width + "px; height:" + height + "px'><input type='button' onclick=\"closeApplication('" + i + "')\" value='X' /><input type='button' onclick=\"maximizeApplication('" + i + "')\" value='\u25A1' /><input type='button' onclick=\"minimizeApplication('" + i + "')\" value='_' /><iframe class='appFrame' src='apps/" + app + "/'></iframe></div>";
            var taskbarApp="<div id='task" + i + "' onclick=\"minimizeApplication('" + i + "')\" class='taskbarApps'><img src='apps/" + app + "/" + appIcon + "' style='width:32px;height:32px' align='middle' /></div>";
            var parent=document.getElementById('appContainer');
            parent.insertAdjacentHTML('beforeend', application);
            var parent=document.getElementById('taskbarApps');
            parent.insertAdjacentHTML('beforeend', taskbarApp);
	        if (width == "max" || height == "max")
       	        maximizeApplication(i);
            moveToFront(i);
            makeDraggable();
        } // Opens an application.

	    function closeApplication(id) {
            var application = document.getElementById(id);
            var taskbarApp = document.getElementById('task' + id);
            application.parentNode.removeChild(application);
            taskbarApp.parentNode.removeChild(taskbarApp);
        } // Closes an application.

        function maximizeApplication(id) {
            document.getElementById(id).setAttribute('style', "height: 92%; width: 99%; top: 42px; left: 0px");
        } // Maximize application
        
        function minimizeApplication(id) {
            var application = document.getElementById(id);
            if (application.style.display === "none") {
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