var util = util || {};
var infinateLoopDetect;
var i = 0;
var f = 0;
var moduleTypeFlag = 0;
var cmdString = "";
var modules = [];
var moduleCode = [];
var modInstall;
var firstLine = "";

document.addEventListener('contextmenu', event => event.preventDefault());

util.toArray = function(list) {
  return Array.prototype.slice.call(list || [], 0);
};

function show_image(src, width, height, alt) {
    var img = document.createElement("img");
    img.src = src;
    img.width = width;
    img.height = height;
    img.alt = alt;

    // This next line will just add it to the <body> tag
    document.body.appendChild(img);
}

var Terminal = Terminal || function(cmdLineContainer, outputContainer) {
  window.URL = window.URL || window.webkitURL;
  window.requestFileSystem = window.requestFileSystem || window.webkitRequestFileSystem;

  var cmdLine_ = document.querySelector(cmdLineContainer);
  var output_ = document.querySelector(outputContainer);

  cmds = [
    'cat', 'clear', 'clock', 'date', 'echo', 'help', 'uname', 'cmd_fm', 'procman', 'insmod', 'rmmod', 'swaptheme', 'cowsay'
  ];
  
  var fs_ = null;
  var cwd_ = null;
  var history_ = [];
  var histpos_ = 0;
  var histtemp_ = 0;

  window.addEventListener('click', function(e) {
    cmdLine_.focus();
  }, false);

  cmdLine_.addEventListener('click', inputTextClick_, false);
  cmdLine_.addEventListener('keydown', historyHandler_, false);
  cmdLine_.addEventListener('keydown', processNewCommand_, false);

  //
  function inputTextClick_(e) {
    this.value = this.value;
  }

  //
  function historyHandler_(e) {
    if (history_.length) {
      if (e.keyCode == 38 || e.keyCode == 40) {
        if (history_[histpos_]) {
          history_[histpos_] = this.value;
        } else {
          histtemp_ = this.value;
        }
      }

      if (e.keyCode == 38) { // up
        histpos_--;
        if (histpos_ < 0) {
          histpos_ = 0;
        }
      } else if (e.keyCode == 40) { // down
        histpos_++;
        if (histpos_ > history_.length) {
          histpos_ = history_.length;
        }
      }

      if (e.keyCode == 38 || e.keyCode == 40) {
        this.value = history_[histpos_] ? history_[histpos_] : histtemp_;
        this.value = this.value; // Sets cursor to end of input.
      }
    }
  }

  //
  function processNewCommand_(e) {

    if (e.keyCode == 9) { // tab
      e.preventDefault();
      // Implement tab suggest.
    } else if (e.keyCode == 13) { // enter
      // Save shell history.
      if (this.value) {
        history_[history_.length] = this.value;
        histpos_ = history_.length;
      }

      // Duplicate current input and append to output section.
      var line = this.parentNode.parentNode.cloneNode(true);
      line.removeAttribute('id')
      line.classList.add('line');
      var input = line.querySelector('input.cmdline');
      input.autofocus = false;
      input.readOnly = true;
      output_.appendChild(line);

      if (this.value && this.value.trim()) {
        /*var args = this.value.split(' ').filter(function(val, i) {
          return val;
        });*/
	var args = [].concat.apply([], this.value.split('"').map(function(v,i){
		return i%2 ? v : v.split(' ')
	})).filter(Boolean);
        var cmd = args[0].toLowerCase();
        args = args.splice(1); // Remove cmd from arg list.
      }
      //infinateLoopDetect = setTimeout(function(){ alert("Infinate Loop!"); }, 10000);
      switch (cmd) {
        case 'cat':
          var url = args.join(' ');
          if (!url) {
            output('Usage: ' + cmd + ' https://s.codepen.io/...');
            output('Example: ' + cmd + ' https://s.codepen.io/AndrewBarfield/pen/LEbPJx.js');
            break;
          }
          $.get( url, function(data) {
            var encodedStr = data.replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
               return '&#'+i.charCodeAt(0)+';';
            });
            output('<pre>' + encodedStr + '</pre>');
          });
          break;
        case 'clear':
          output_.innerHTML = '';
          this.value = '';
          return;
        case 'clock':
          var appendDiv = jQuery($('.clock-container')[0].outerHTML);
          appendDiv.attr('style', 'display:inline-block');
          output_.appendChild(appendDiv[0]);
          break;
        case 'date':
          output( new Date() );
          break;
        case 'echo':
          output( args.join(' ') );
          break;
        case 'help':
          if (!arguments || (args[0] != "modules")) {
	      cmdString = "";
              output('DremJS Terminal Help Menu');
              output('All default commands (without modules) for the terminal are as follows:');
              for (i = 0; i < cmds.length; i++)
                  cmdString += cmds[i] + " ";
              output(cmdString);
              cmdString = "";
	      output('Module commands:');
	      for (i = 0; i < modules.length; i++)
	          cmdString += modules[i] + " ";
	      output(cmdString);
	      cmdString = "";
	      output('For information on Modules, run "help modules"');
          } else if (args[0] == "modules") {
              output('DremJS Terminal Help Menu - Modules');
              output('What are Modules?');
              output('Modules are a simple way to temporarily add new functionality to DremJS. Modules have a .djsm (DremJS Module) file extension and contain JavaScript code which can be ran immediately or from a terminal. DremJS Modules can also be installed in batch with a .djsms (DremJS Module Script). These scripts will automatically handle installations of modules that may be too complex to fit into one file and therefor have multiple modules.\n\n');
              output('Currently, there are three different types of modules: immediate, terminal, and parentscript. An immediate module does exactly what it says: run the code immediately. A terminal module adds functionality to the terminal, such as a new command. However, terminal modules are not persistent after you close the terminal (yet). A parentscript module adds functionality to the main Agenda WM script.\n\n');
              output('The pros and cons of modules');
              output('The pros of modules is that you can add new functionality to DremJS or the terminal without having to install an application.');
              output('The cons of a module is that, since it adds or runs code on-the-fly to DremJS, they are very insecure. A man-in-the-middle attack or other naughty module can cause your data to be stolen (please never use DremJS with any personal data), DremJS to become unstable, or completely crash. This is why we made it so modules are not permanently installed. If you want code that stays put, it is recommended to use an application.');
          }
          break;
        case 'uname':
          output(navigator.appVersion);
          break;
        /*case 'whoami':
          var result = "<img src=\"" + codehelper_ip["Flag"]+ "\"><br><br>";
          for (var prop in codehelper_ip)
            result += prop + ": " + codehelper_ip[prop] + "<br>";
          output(result);
          break;*/
        case 'cmd_fm':
            window.open("https://cmd.to/fm","_self")
          break;
        case 'spin':
            //show_image('spin.gif', 100, 100, 'Spinny');
	    output('<img align="left" src="spin.gif" width="100" height="100">');
          break;
        case 'procman':
            var arguments = args.join(' ');
            if (!arguments || (args[0] != "list" && args[0] != "kill")) {
                output('Process Manager (procman) help');
                output('procman kill - kill a process');
                output('procman list - list all processes');
                break;
            } else if (args[0] == "list") {
                var i = 0;
                output('ID\t\tName');
                while (i <= 1000) {
                    if (parent.idExists(i))
                        output(i + "\t\t" + parent.idExists(i));
                    i++;
                }
                break;
            } else if (args[0] == "kill") {
                if (!args[1]) {
                    output("fatal: no application ID provided!");
                } else if (parent.idExists(args[1])) {
                    output("Killing application with ID " + args[1]);
                    parent.closeApplication(args[1])
                } else {
                    output("fatal: application ID " + args[1] + " does not exist.");
                }
            }
        break;
        case 'insmod':
            i=0;
            modInstall="";
            firstLine="";
            if (!arguments || (args[0] != "remote" && args[0] != "local")) {
                output('Install Module (insmod) help');
		output('NOTICE: insmod is currently a prototype and is not yet feature-complete or secured at all. NEVER INSTALL A MODULE UNLESS YOU ARE ON YOUR LOCAL NETWORK!');
                output('To install a module not inside the DremJS folder (not recommended, insecure):');
                output('insmod remote https://example.com/path/to/foo.djsm\n');
                output('To install a module inside the DremJS folder');
		output('insmod remote http://your.local.ip.address/path/to/foo.djsm');
		output('Planned features that aren\'t yet implimented:');
		output('Batch installs (DremJS Module Installation Scripts)');
		output('Local installations');               
		//output('insmod local path/to/module.djsm\n');
                //output('To run a module installation script for batch installations that is not inside the DremJS folder:');
                //output('insmod remote https://example.com/foo.djsms\n');
                //output('To run a module installation script that is not inside the DremJS folder:');
                //output('insmod local path/to/script.djsms\n');
                output('For more information on modules, please run: help modules');
            } else if (args[0] == "remote") {
                if (args[1] != undefined) {
                    if ((args[1].substring(args[1].length-5)) == ".djsm") {
                        output('[insmod] Loading modue at ' + args[1] + '...');
			var modInstall;
			jQuery.get(args[1], function(data) {
			    // Welcome to callback hell
			    modInstall = data;
			    output('[insmod] Parsing module...');
			    i=0;
			    while (modInstall.charAt(i) != ';' && i < 50) {
			        firstLine += modInstall.charAt(i);
			        i++;
			    }
			    modInstall = modInstall.substring(i+1, modInstall.length);
			    if (firstLine == "type immediate") {
			        output('[insmod] module type is immediate');
			        moduleTypeFlag = 1;
				output('[insmod] fatal: module type "immediate" not implimented. Maybe 0.1.6b?');
			    } else if (firstLine == "type terminal") {
			        output('[insmod] module type is terminal');
			        moduleTypeFlag = 2;
				firstLine = "";
				i=0;
				while (modInstall.charAt(i) != ';' && i < 50) {
					firstLine += modInstall.charAt(i);
					i++;
				}
				newCmdName = firstLine.substring(6, firstLine.length);
				output('[insmod] adding command with name "' + newCmdName + '" to terminal modules list...');
				modules.push(newCmdName);
				output('[insmod] installing module...');
				modInstall = modInstall.substring(3+firstLine.length, modInstall.length);
				moduleCode.push(modInstall);
			    } else if (firstLine == "type parentscript") {
                                output('[insmod] module type is parentscript');
                                moduleTypeFlag = 3;
				output('[insmod] fatal: module type "parentscript" not implimented. Maybe 0.1.6b?');
			    } else {
                                output('[insmod] fatal: the input file is not a DremJS Module or DremJS Module Script');
				moduleTypeFlag = 0;
                            }
			    /*if (moduleTypeFlag = 1) {
			        output('[insmod] fatal: not implimented. Maybe 0.1.6b?');
			    } else if */
			});
                        
			//output('[insmod] Installing module...');

                        break;
                    } else if ((args[1].substring(args[1].length-6)) == ".djsms") {
                        //output('Running module installation script at ' + args[1] + '...');
			output('[insmod] fatal: module installation scripts are not implimented. Maybe 0.1.6b?');
                    } else {
                        output('[insmod] fatal: the input file is not a DremJS Module or DremJS Module Script');
                        break;
                    }
                } else {
                        output('[insmod] fatal: no input file was provided.');
                        break;
                }
            } else if (args[0] == "local") {
                output('[insmod] fatal: local installation is not yet implimented. Remote installation can do this. For example: insmod remote http://localhost:8000/modules/foo-0.0.0.djsm');
            }
        break;
        case 'rmmod':
            output('[rmmod] fatal: not implimented. Maybe 0.1.6b?');
        break;
	case 'swaptheme':
		$.ajax({
			url: 'terminal/scripts/swapTheme.php'
		});
		output('Theme swapped. Please restart the terminal and refresh it a few times.');
	break;
	case 'cowsay':
		if(args[0] == null) {
			output("cowsay [text] &lt;skin&gt;<br />Availible skins:<br />default\t\ttux<br />If no skin is provided or it is invalid, the default is used instead.");
		} else {
			var oReq = new XMLHttpRequest();
			oReq.onload = function() {
				output(this.responseText);
			};
			if(args[1] == null)
				args[1] = "cow";
			oReq.open("get", "terminal/scripts/cowsay.php?inputText=" + args[0] + "&skin=" + args[1], true);
			oReq.send();
		}
	break;
        default:
          var notFoundFlag = 1;
          if (cmd != undefined) {
	  // Checks if the default terminal command exists
              for (i = 0; i < cmds.length; i++)
                  if (cmd != cmds[i])
                      notFoundFlag = 1;
                  else {
                      notFoundFlag = 0;
                      i = cmds.length;
                  }

	  // Checks if a module with the command name is installed
	      for (i = 0; i < modules.length; i++) {
	          if (cmd != modules[i])
		      notFoundFlag = 1;
		  else {
		      notFoundFlag = 0;
		      eval(moduleCode[i]);
		  }
	      }
          } else {
              cmd = "";
          }
	  
          if (notFoundFlag == 1) {
              output(cmd + ': command not found');
          }
      };

      window.scrollTo(0, getDocHeight_());
      this.value = ''; // Clear/setup line for next input.
    }
    //clearTimeout(infinateLoopDetect);
  }

  //
  function formatColumns_(entries) {
    var maxName = entries[0].name;
    util.toArray(entries).forEach(function(entry, i) {
      if (entry.name.length > maxName.length) {
        maxName = entry.name;
      }
    });

    var height = entries.length <= 3 ?
        'height: ' + (entries.length * 15) + 'px;' : '';

    // 12px monospace font yields ~7px screen width.
    var colWidth = maxName.length * 7;

    return ['<div class="ls-files" style="-webkit-column-width:',
            colWidth, 'px;', height, '">'];
  }

  //
  function output(html) {
    output_.insertAdjacentHTML('beforeEnd', '<p style="white-space:pre;">' + html + '</p>');
  }

  function sleep(delay) {
    var start = new Date().getTime();
    while (new Date().getTime() < start + delay);
  } // Cyclefucker 1000

  function fileToVar(t) {
    modInstall = t;
    alert(modInstall);
  }

  // Cross-browser impl to get document's height.
  function getDocHeight_() {
    var d = document;
    return Math.max(
        Math.max(d.body.scrollHeight, d.documentElement.scrollHeight),
        Math.max(d.body.offsetHeight, d.documentElement.offsetHeight),
        Math.max(d.body.clientHeight, d.documentElement.clientHeight)
    );
  }

  //
  return {
    init: function() {
		jQuery.get('terminal/configs/theme.conf', function(data) {
			if(data == "1") {
				output('<img align="left" src="termlogo-lite.png" width="100" height="100" style="padding: 0px 10px 20px 0px"><h2 style="letter-spacing: 4px">DremJS Terminal</h2><p>' + new Date() + '</p><p>Enter "help" for more information.</p>');
			} else {
				output('<img align="left" src="termlogo-dark.png" width="100" height="100" style="padding: 0px 10px 20px 0px"><h2 style="letter-spacing: 4px">DremJS Terminal</h2><p>' + new Date() + '</p><p>Enter "help" for more information.</p>');
			}
		});
    },
    output: output
  }
};
