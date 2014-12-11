<html>
<head>
<title>The Big Five</title>
	<link rel="stylesheet" href="./outline.css" type="text/css" name="style1">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script>
		$(function() {
			$( ".slider" ).slider({
				value: 3,
				min: 1,
				max: 5,
				step: 1,
				slide: function( event, ui ) {
					$(this).siblings().val(ui.value );
				}
			});
		//$(“.slider").siblings().val($(".slider").slider("value"));
		});
		
		function sticky_relocate() {
			var window_top = $(window).scrollTop();
			var div_top = $('#anchor').offset().top;
			if (window_top > div_top){
				$('#info').addClass('sticky');
			}
			else{
				$('#info').removeClass('sticky');
			}
		}	
		$(function() {
			$(window).scroll(sticky_relocate);
			sticky_relocate();
		});
	</script>
</head>

<div id="container" style="height: 425em">
	<a href="./home.php"><img src="./logo.png" id="logo"></a>

<div id="title">
	<h1>The Big Five Quiz</h1>
</div>

<div id="anchor"></div>
<div id="info">
	<center><div id="info_title">Brain Surge Site Navigation</div></center>
	<h4><i>Personality Quizzes</i></h4>
	<ul><li><a href="./mb.php">MBTI</a></li>
	    <li style="color: gray">The Big Five</li>
	    <li><a href="./typeAB.php">Type A/B</a></li>
	</ul>

	<!-- takes them to profile page, or if they aren't logged in, to register/login page-->
<?php 
	if(!isset($_COOKIE["user"])){
		print "<a href='login.php'> <h4><i>Your Profile</i></h4></a>";
	}
	else{
		print "<a href='profile.php'> <h4><i>Your Profile</i></h4></a>";
	}
?>
	<h4><i>More Information</h4></i>
	<dl><dt>Personality Theory</dt>
		<dd><a href="https://en.wikipedia.org/wiki/Personality_psychology">Personality Psychology</a></dd>
		<dd><a href="http://drdianehamilton.wordpress.com/2011/12/18/top-18-personality-theorists-including-freud-and-more/">Famous Personality Psychologists</a></dd>
	<br>
	    <dt>Social Psychology</dt>
		<dd><a href="https://en.wikipedia.org/wiki/Social_psychology">Social Psychology</a></dd>
		<dd><a href="http://www.ippanetwork.org/">Positive Psychology</a></dd>
	<br>
	    <dt>Neuropsychology</dt>
		<dd><a href="https://en.wikipedia.org/wiki/Neuropsychology">Neuropsychology</a></dd>
		<dd><a href="http://www.neuroaustin.com/">Local Neuropsychologists</a></dd>
	<br>
	    <dt>Other Fields of Psychology</dt>
		<dd><a href="https://en.wikipedia.org/wiki/Cognitive_psychology">Cognitive Psychology</a></dd>
		<dd><a href="https://en.wikipedia.org/wiki/Developmental_psychology">Developmental Psychology</a></dd>
		<dd><a href="https://en.wikipedia.org/wiki/Clinical_psychology">Clinical Psychology</a></dd>
		<dd><a href="https://en.wikipedia.org/wiki/Abnormal_psychology">Abnormal Psychology</a></dd>
	</dl>
	
	<h4><i>Contact Brain Surge</i></h4>
		<p><a href="./info.php">About Brain Surge and the developers</a></p>
</div>

<?php 
	if(!isset($_COOKIE["user"])){
		print <<<LOGIN
			<div id="login">
				<form method="post" action="big5.php">
				<b>Login Here!</b>
				<table id="loginTable">
				<tr><td>Username:</td><td><input type="text" name="username" id="id" size="15"></td></tr>
				<tr><td>Password:</td><td><input type="password" name="password" id="pw" size="15"></td></tr>
				</table>
				<input class="btn" type="submit" value="Login" name="login" id="submitL">
				<br>
				<br>New User? Register <a href="login.php"><u>Here</u></a>
				</form>
			</div>
LOGIN;
	}
	else{	
		print <<<WELCOME
			<div id="welcome">
				Welcome back, <a href="profile.php"><u><b>{$_COOKIE["name"]}</b></u></a>
				<form method="post" action="big5.php"><input type="submit" id="logout" name="logout" value="Log Out"></form>
			</div>
WELCOME;
	}	
	if(isset($_POST["logout"])){
		setcookie("user", "", time() - 3600);
		setcookie("first", "", time() - 3600);
		header("Location: big5.php");
	}
	if(isset($_POST["login"])){
		if(!empty($_POST["username"]) && !empty($_POST["password"])){
		 $un = purge($_POST["username"]);
                $pw = purge($_POST["password"]);
                $pw_protected = crypt($pw,$un);
                login($un, $pw_protected);
		}
		else{
			echo "<script type = 'text/javascript'>
				alert('Please fill in both fields to login.') </script>";
		}
	}
        //Dr. Mitra's basic purge function
        function purge ($str){
                $purged_str = preg_replace("/\W/", "", $str);
                return $purged_str;
        }
	function login($un, $pw){
		$host = "fall-2014.cs.utexas.edu";
		$user = "irenej";
		$pwd = "Ap+sVVJQbw";
		$dbs = "cs329e_irenej";
		$port = "3306";
		$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
		$table = "brainsurge";

                $un=mysqli_real_escape_string($connect, $un);
                $pw=mysqli_real_escape_string($connect, $pw);
		
		$result = mysqli_query($connect, "SELECT * from $table where Username = \"$un\"");
		$row = $result->fetch_row();
		if(count($row) == 0){
			echo "<script type = 'text/javascript'>
				alert('That username is not registered.') </script>";	
		}
		else if($row[3] != $pw){
			echo "<script type = 'text/javascript'>
				alert('Username and password do not match.') </script>";	
		}
		else{	
			$name = $row[0];
			setcookie("first", $name);
			setcookie("user", $un);
			header("Location: big5.php");
		}
		mysqli_close($connect);
	}
?>

<div id="main">
	<center><h3>The Big 5 Personality Inventory</h3>
		<h4>Rate the following statements by your level of agreement with them</h4>
		<h2>I...</h2>

	<form id="big5" method="post" action="./big_results.php">

	<div>
	<span class="quest_head">am the life of the party</span>
	<br>
	<br>
	<input type="hidden" name="q1" value="3">
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">feel little concern for others</span>
	<br>
	<br>
	<input type="hidden" name="q2" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">am always prepared</span>
	<br>
	<br>
	<input type="hidden" name="q3" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">get stressed out easily</span>
	<br>
	<br>
	<input type="hidden" name="q4" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">have a rich vocabulary</span>
	<br>
	<br>
	<input type="hidden" name="q5" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">don't talk much</span>
	<br>
	<br>
	<input type="hidden" name="q6" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">am interested in people</span>
	<br>
	<br>
	<input type="hidden" name="q7" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">leave my belongings around</span>
	<br>
	<br>
	<input type="hidden" name="q8" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">am relaxed most of the time</span>
	<br>
	<br>
	<input type="hidden" name="q9" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">have difficulty understanding abstract ideas</span>
	<br>
	<br>
	<input type="hidden" name="q10" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">feel comfortable around people</span>
	<br>
	<br>
	<input type="hidden" name="q11" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">insult people</span>
	<br>
	<br>
	<input type="hidden" name="q12" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">pay attentino to details</span>
	<br>
	<br>
	<input type="hidden" name="q13" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">worry about things</span>
	<br>
	<br>
	<input type="hidden" name="q14" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">have a vivid imagination</span>
	<br>
	<br>
	<input type="hidden" name="q15" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">keep in the background</span>
	<br>
	<br>
	<input type="hidden" name="q16" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">sympathize with others' feelings</span>
	<br>
	<br>
	<input type="hidden" name="q17" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">make a mess of things</span>
	<br>
	<br>
	<input type="hidden" name="q18" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">seldom feel blue</span>
	<br>
	<br>
	<input type="hidden" name="q19" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">am not interested in abstract ideas</span>
	<br>
	<br>
	<input type="hidden" name="q20" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">start conversations</span>
	<br>
	<br>
	<input type="hidden" name="q21" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">am not interested in other peoples' problems</span>
	<br>
	<br>
	<input type="hidden" name="q22" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">get chores done right away</span>
	<br>
	<br>
	<input type="hidden" name="q23" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">am easily disturbed</span>
	<br>
	<br>
	<input type="hidden" name="q24" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">have exellent ideas</span>
	<br>
	<br>
	<input type="hidden" name="q25" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">have little to say</span>
	<br>
	<br>
	<input type="hidden" name="q26" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">have a soft heart</span>
	<br>
	<br>
	<input type="hidden" name="q27" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">often forget to put things back in their proper place</span>
	<br>
	<br>
	<input type="hidden" name="q28" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">get upset easily</span>
	<br>
	<br>
	<input type="hidden" name="q29" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">do not have a good imagination</span>
	<br>
	<br>
	<input type="hidden" name="q30" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">talk to a lot of different people at parties</span>
	<br>
	<br>
	<input type="hidden" name="q31" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">am not really interested in others</span>
	<br>
	<br>
	<input type="hidden" name="q32" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">like order</span>
	<br>
	<br>
	<input type="hidden" name="q33" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">change my mood frequently</span>
	<br>
	<br>
	<input type="hidden" name="q34" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">am quick to understand things</span>
	<br>
	<br>
	<input type="hidden" name="q35" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">don't like to draw attention to myself</span>
	<br>
	<br>
	<input type="hidden" name="q36" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">take time out for others</span>
	<br>
	<br>
	<input type="hidden" name="q37" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">shirk my duties</span>
	<br>
	<br>
	<input type="hidden" name="q38" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">have frequent mood swings</span>
	<br>
	<br>
	<input type="hidden" name="q39" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">use difficult words</span>
	<br>
	<br>
	<input type="hidden" name="q40" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">don't mind being the center of attention</span>
	<br>
	<br>
	<input type="hidden" name="q41" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">feel others' emotions</span>
	<br>
	<br>
	<input type="hidden" name="q42" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">follow a schedule</span>
	<br>
	<br>
	<input type="hidden" name="q43" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">get irritated easily</span>
	<br>
	<br>
	<input type="hidden" name="q44" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">spend time reflecting on things</span>
	<br>
	<br>
	<input type="hidden" name="q45" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">am quiet around strangers</span>
	<br>
	<br>
	<input type="hidden" name="q46" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">make people feel at ease</span>
	<br>
	<br>
	<input type="hidden" name="q47" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">am exacting in my work</span>
	<br>
	<br>
	<input type="hidden" name="q48" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">often feel blue</span>
	<br>
	<br>
	<input type="hidden" name="q49" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<div>
	<span class="quest_head">am full of ideas</span>
	<br>
	<br>
	<input type="hidden" name="q50" value="3" >
	<div class="slider"></div>
<span class="likert">Disagree Agree</span> 
	<br>
	<br>
	<br>
	</div>

	<input type="submit" value="Submit" name="big5">
	<input type="reset" value="Reset">

	</form>
</center>

</div>
<div id="footer" style="margin-top: 560em">
	<br><center>BrainSurge.com &copy; 2014 || Mitra Enterprises || Developers: Evan Johnston &amp; Irene Jea <br>
	<a href="./info.php">About the Developers</a></center>
</div>
</div>
</html>
