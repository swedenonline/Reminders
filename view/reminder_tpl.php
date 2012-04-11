<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
	<title>Reminder - Reminds you what to do!</title>
    <script type="text/javascript">
		function delReminder(rid)
		{
			var querystring = "<?php echo $_GET["filter"]?>";
			if(window.confirm("Do you really want to delete reminder?"))
			{
				window.location = "reminder.php?filter="+querystring+"&del="+rid;
			}
		}

		function editReminder(rid)
		{
			window.location = "edit_reminder.php?id="+rid;
		}
		
	</script>
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
                        <li><a class="selected" href="#">View Reminders</a></li>
                        	<div style="padding-left:30px;"><a href="reminder.php?filter=">show all</a></div>
                            <div style="padding-left:30px;"><a href="reminder.php?filter=e">show expired</a></div>
                            <div style="padding-left:30px;"><a href="reminder.php?filter=ne">show non-expired</a></div>
                            
                        <li><a href="add_reminder.php">Add new Reminder</a></li>
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
                    <h2>View Reminders</h2>
                </div>
                <div class="container_box_middle">
                	<br />
					<?php if($msg != "") : ?>
                    	<p class="<?php echo $class;?>"> <?php echo $msg;?> </p>
                    <?php endif; ?>
                	
					<?php if($record != NULL) : foreach($record as $r):?>
                    	    <div style="float:left; margin-right:10px; padding-left:10px; width:450px;"><?php echo $r["title"];?></div>
                            <div style="float:left; margin-right:10px;"><?php echo $r["remindme"];?></div>
                            <div style="float:left; margin-right:5px; margin-left:5px;">
                            	<img src="images/tick_mark.png" onclick="editReminder(<?php echo $r["reminder_id"];?>);" />
                            </div>
                            <div><img src="images/cross_mark.png" onclick="delReminder(<?php echo $r["reminder_id"];?>);" /></div>
                            <div style="clear:both;"></div>
                            <div style="padding-top:5px; padding-bottom:5px; border-bottom:1px dotted #CCCCCC;"></div>
                    <?php endforeach; endif;?>
					
                <br /><br /><br /><br /><br /><br /><br />
                
                </div>
                <div class="container_box_bottom">
                    <div class="container_box_bottom_inside"></div>
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