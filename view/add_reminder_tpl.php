<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
	<title>Reminder - Reminds you what to do!</title>
	
    
    <link href="helper/js/jquery/jquery-ui.css" rel="stylesheet" type="text/css"/>
  	<link type="text/css" rel="stylesheet" src="helper/js/timepicker/jquery-ui-timepicker-addon.css" />
	<script src="helper/js/jquery/jquery.min.js"></script>
  	<script src="helper/js/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="helper/js/timepicker/jquery-ui-timepicker-addon.js"></script>
    
    
	<script type="text/javascript">
		$(document).ready(function() {
    		$("#remind_me_id").datetimepicker( {
				showSecond : true,
				timeFormat: 'hh:mm:ss',
				dateFormat: 'yy-mm-dd'
			});
		});
	</script>

	<style>
		/* css for timepicker */
		.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
		.ui-timepicker-div dl { text-align: left; }
		.ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
		.ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
		.ui-timepicker-div td { font-size: 90%; }
		.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
	</style>
</head>

<body>

<div id="header">
    <div id="headerWrap">
        <div id="logo">
            <img alt="Reminder" src="images/logo.jpg" />
        </div>
        <div class="slogan">
            Reminds you what to do...
        </div>
        
        <div class="user_box">
            <span class="username">Bilal Baloch</span>
            <a href="#">Settings</a>
            <a href="#">Logout</a>
            <br />
            <span class="last_login">Last Login: 11.04.2012.</span>
        </div>
        
    </div>
</div>


<div id="navigation">
    <div id="navigationWrap">
        <menu id="primary">
            <li class="selected">
                <a href="index.php">Home</a>
            </li>
            <li>
                <a href="#">Contact Us</a>
            </li>
        </menu>
    </div>
</div>

<div id="container">
    <div id="containerWrap">
        <h1 class="title">Control panel</h1>
        <div class="col_left">
            <div class="container_box">
                <div class="container_box_top">
                    <h2>Reminder options</h2>
                </div>
                <div class="container_box_middle">
                    <ul class="side_menu">
                        <li><a href="reminder.php">View Reminders</a></li>
                        <li><a class="selected" href="add_reminder.php">Add new Reminder</a></li>
                    </ul>
                </div>
                <div class="container_box_bottom">
                    <div class="container_box_bottom_inside"></div>
                </div>
            </div>
        </div>
        <div class="col_right">
            <div class="container_box">
                <div class="container_box_top">
                    <h2>Add new reminder </h2>
                </div>
                <form method="post" action="add_reminder.php">
                <div class="container_box_middle">
                	<br />
                	
                    <?php if($msg != "") : ?>
                    	<p class="<?php echo $class;?>"> <?php echo $msg;?> </p>
                    <?php endif; ?>
                	
                    <label>
                       <span>Remind me</span>
                       <input type="text" class="input_text" name="remind_me" id="remind_me_id" value="<?php echo $formvars["remind_me"]?>"/>
                    </label>
                    <label>
                        <span>Title</span>
                        <textarea rows="5" cols="41" class="message_area" name="title" id="title_id"><?php echo $formvars["title"]?></textarea>
                    </label> 
                    <input class="submit" type="submit" value="add" name="submit" />
                </div>
                </form>
                <div class="container_box_bottom">
                    <div class="container_box_bottom_inside">   
                    </div>
                </div>
            </div>
        </div>
        <br style="clear:both;"/>
    </div>
</div>

<div id="footer">
    <div id="footerWrap">
        @ 2012 Reminder
    </div>
</div>

</body>
</html>