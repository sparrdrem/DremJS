<?php
	header('Refresh:10');
	function displayInfo() {
		$systemInfo = '<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
					<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>
					<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
					<script type="text/javascript">
						$(function() {
							var content = \'<center><p>CPU Usage: '.getCpuUsage().'%</p><div id="cpuUsageBar"></div><br /><p>Memory Usage (see docs): '.memory_usage()."KB/".memory_total()."KB".'</p><div id="memoryUsageBar"></div></center>\';
							
							var parent=document.getElementById("container");
							parent.insertAdjacentHTML("beforeend", content);
							
							$( "#cpuUsageBar" ).progressbar({
                                                                value: '.getCpuUsage().'
                                                        });
                                                        $( "#memoryUsageBar" ).progressbar({
                                                                        value: '.round((memory_usage()/memory_total())*100, 2).'
                                                        });
						});
						function startRefresh() {
							$.get("index.php", function(data) {
								$(document.body).html(data);    
							});
						}
						$(function() {
							setTimeout(startRefresh,5000);
						});
					</script>
					<style>
						body {
							font-family: Calibri;
						}
						.buttonA, .buttonB {
							display: inline-block;
						}
						.buttons {
                                			width: 100%;
                                			top: 0px;
                                			left: 0px;
                                			position: sticky;
                                			background-color: #D3D3D3;
                        			}
					</style>
				</head>
				<body>
				<script>
    				document.addEventListener("contextmenu", event => event.preventDefault());
  				</script>
					<div class="buttons">
						<button type="button" class="buttonA" disabled>Status</button>
						<a href="TaskManager.html"><button type="button" class="buttonB">Task Manager</button></a>
					</div>
					<div id="container">

					</div>
				</body>
				</html>';
		echo($systemInfo);
		//ob_flush();
		//flush();
	}

	function memory_usage() {
		return memory_total() - memory_free();
	}

	function memory_free() {
		$fh = fopen('/proc/meminfo','r');
                $mem = 0;
                while ($line = fgets($fh)) {
                        $pieces = array();
                        if (preg_match('/^MemFree:\s+(\d+)\skB$/', $line, $pieces)) {
                                $mem = $pieces[1];
                                break;
                        }
                }
                fclose($fh);
                return $mem;
	}
	
	function memory_total() {
		$fh = fopen('/proc/meminfo','r');
  		$mem = 0;
  		while ($line = fgets($fh)) {
    			$pieces = array();
    			if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
      				$mem = $pieces[1];
      				break;
    			}
  		}
		fclose($fh);
		return $mem;
	}
	
	function getCpuUsage() {
		if(stristr(PHP_OS, 'win')) {
			$_ENV['typeperfCounter'] = '\processor(_total)\% processor time';
			exec('typeperf -sc 1 "'.$_ENV['typeperfCounter'].'"', $p);
			$line = explode(',', $p[2]);
			$load = trim($line[1], '"');
			return $load;
		} else {
			$usage = sys_getloadavg();
			return $usage[0];
		}
	}

	displayInfo();
?>
