<html>
<head>
	<title>Type A Type B</title>
	<link rel="stylesheet" href="./outline.css" type="text/css" name="style1">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"> </script>
	<script type="text/javascript">
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

<div id="container" style="height: 215em">
	<a href="./home.php"><img src="./logo.png" id="logo"></a>

<div id="title">
	<h1>Personality Type A/B Quiz</h1>
</div>

<div id="anchor"></div>
<div id="info">
	<center><div id="info_title">Brain Surge Site Navigation</div></center>
	<h4><i>Personality Quizzes</i></h4>
	<ul><li><a href="./mb.php">MBTI</a></li>
	    <li><a href="./big5.php">The Big Five</a></li>
	    <li style="color: gray">Type A/B</li>
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
				<form method="post" action="typeAB.php">
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
				Welcome back, <a href="profile.php"><u><b>{$_COOKIE["user"]}</b></u></a>
				<form method="post" action="typeAB.php"><input type="submit" id="logout" name="logout" value="Log Out"></form>
			</div>
WELCOME;
	}	
	if(isset($_POST["logout"])){
		setcookie("user", "", time() - 3600);
		header("Location: typeAB.php");
	}
	if(isset($_POST["login"])){
		if(!empty($_POST["username"]) && !empty($_POST["password"])){
			$un = $_POST["username"];
			$pw = $_POST["password"];
			login($un, $pw);
		}
		else{
			echo "<script type = 'text/javascript'>
				alert('Please fill in both fields to login.') </script>";
		}
	}	
	function login($un, $pw){
		$host = "fall-2014.cs.utexas.edu";
		$user = "irenej";
		$pwd = "Ap+sVVJQbw";
		$dbs = "cs329e_irenej";
		$port = "3306";
		$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
		$table = "brainsurge";
		
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
			setcookie("user", $name);
			header("Location: typeAB.php");
		}
		mysqli_close($connect);
	}
?>


<div id="main">

	<center><h2>Type A/B Personality test</h2><br>
		<h3>Please complete the questions below</h3><br>
		<br></center>

	<form method="post" action="">
		
	<span class="quest_head">1. When you are faced with an unfamiliar problem, what do you usually do?</span><br> 
	<input value ="20" type="radio" required name="q1">Address the problem immediately<br>
  	<input value ="10" type="radio" required name="q1">Think about what to do and then take action<br>
	<input value ="5" type="radio" required name="q1">Sit back and let things work out for themselves<br>
	<br>

	<span class="quest_head">2. Compared with other students, how quickly do you usually complete your class assignments?</span><br>
	<input value ="25" type="radio" required name="q2">I am usually finished before everyone else<br> 
  	<input value ="15" type="radio" required name="q2">I finish faster than most of my classmates<br> 
	<input value ="5" type="radio" required name="q2">I finish right on time<br> 
	<input value ="0" type="radio" required name="q2">I frequently turn in assignments late<br> 
	<br>

	<span class="quest_head">3. Has anyone ever told you that you talk too much</span><br> 
	<input value ="0" type="radio" required name="q3">Yes, often<br>
	<input value ="0" type="radio" required name="q3">A couple of times<br> 
	<input value ="0" type="radio" required name="q3">Once<br> 
	<input value ="0" type="radio" required name="q3">No, never<br> 
	<br>

	<span class="quest_head">4. During normal conversation, how quickly do you speak?</span><br> 
	<input value ="15" type="radio" required name="q4">Faster than most people<br>
	<input value ="5" type="radio" required name="q4">At an average pace<br> 
	<input value ="2" type="radio" required name="q4">Slower than most people<br> 
	<br>

	<span class="quest_head">5. How often do you finish other people's sentences because they speak too slowly?</span><br> 
	<input value ="20" type="radio" required name="q5">Frequently<br>
	<input value ="10" type="radio" required name="q5">Sometimes<br> 
	<input value ="2" type="radio" required name="q5">Almost never<br> 
	<br>

	<span class="quest_head">6. Have you ever been waiting at the doctor's office 30 minutes past your appointment time, and have several chores to do when you get home.&nbsp; What do you do?</span><br> 
	<input value ="0" type="radio" required name="q6">Read a magazine<br>
	<input value ="5" type="radio" required name="q6">Keep checking your watch<br> 
	<input value ="15" type="radio" required name="q6">Get impatient and somewhat angry<br> 
	<input value ="15" type="radio" required name="q6">Complain to the nurse<br> 
	<br>

	<span class="quest_head">7. How often are you late for appointments?</span><br> 
	<input value ="2" type="radio" required name="q7">Most of the time<br>
	<input value ="2" type="radio" required name="q7">Sometimes<br> 
  	<input value ="5" type="radio" required name="q7">Rarely<br> 
  	<input value ="15" type="radio" required name="q7">Never<br> 
	<br>

	<span class="quest_head">8. When you are playing a game, how important is it for you to win?</span><br> 
	<input value ="50" type="radio" required name="q8">Very important<br>
	<input value ="30" type="radio" required name="q8">Sometimes important<br> 
	<input value ="2" type="radio" required name="q8">Not important at all<br> 
	<br>

	<span class="quest_head">9. How would your classmates and friends rate you?</span><br> 
	<input value ="70" type="radio" required name="q9">Always hardworking and serious<br>
	<input value ="50" type="radio" required name="q9">Sometimes hardworking and serious<br> 
  	<input value ="10" type="radio" required name="q9">Rarely hardworking and serious<br> 
  	<input value ="5" type="radio" required name="q9">Carefree<br>
	<br>

	<span class="quest_head">10. How would your parents (or previous guardians) rate you?</span><br> 
	<input value ="0" type="radio" required name="q10">Always helpful<br>
	<input value ="0" type="radio" required name="q10">Mostly helpful<br> 
	<input value ="0" type="radio" required name="q10">Sometimes helpful<br> 
  	<input value ="0" type="radio" required name="q10">Never helpful<br> 
	<br>

	<span class="quest_head">11. How would your closest friends rate your general activity level?</span><br> 
	<input value ="3" type="radio" required name="q11">Too slow - never gets anything done<br>
	<input value ="5" type="radio" required name="q11">Slow - but gets things done<br> 
	<input value ="10" type="radio" required name="q11">Average - reasonable busy<br> 
  	<input value ="25" type="radio" required name="q11">Too active - should slow down<br> 
	<br>

	<span class="quest_head">12. How often do you worry about future events?</span><br> 
	<input value ="0" type="radio" required name="q12">Constantly<br>
	<input value ="0" type="radio" required name="q12">Frequently<br> 
	<input value ="0" type="radio" required name="q12">Sometimes<br> 
  	<input value ="0" type="radio" required name="q12">Never<br> 
	<br>

	<span class="quest_head">13. When you have free time, what would you prefer to do?</span><br> 
	<input value ="2" type="radio" required name="q13">Sleep<br>
	<input value ="5" type="radio" required name="q13">Watch TV<br> 
  	<input value ="10" type="radio" required name="q13">Go Shopping<br> 
  	<input value ="15" type="radio" required name="q13">Catch up on work or household chores<br> 
	<br>

	<span class="quest_head">14. Looking back now, how would you rate your behavior as a child?</span><br> 
	<input value ="30" type="radio" required name="q14">I was a problem child<br>
	<input value ="20" type="radio" required name="q14">I was difficult to discipline<br> 
	<input value ="10" type="radio" required name="q14">I was an ordinary child<br> 
  	<input value ="2" type="radio" required name="q14">I was a little angel<br> 
	<br>

	<span class="quest_head">15. You have a large amount of homework to do, but your closest friends are having a party.&nbsp; What do you do?</span><br> 
	<input value ="0" type="radio" required name="q15">Join the party<br>
	<input value ="0" type="radio" required name="q15">Do some homework and then join the party<br> 
  	<input value ="0" type="radio" required name="q15">Finish all of your homework and miss the party<br> 
	<br>

	<span class="quest_head">16. Do you keep a daily schedule or calendar of your plans?</span><br> 
	<input value ="3" type="radio" required name="q16">No, never<br>
	<input value ="10" type="radio" required name="q16">Sometimes<br> 
	<input value ="20" type="radio" required name="q16">Yes, always<br> 
	<br>

	<span class="quest_head">17. When you are in a group situation (like completing a group project), how do you usually act?</span><br> 
	<input value ="2" type="radio" required name="q17">I rarely participate<br>
	<input value ="10" type="radio" required name="q17">I act as a team player<br> 
  	<input value ="25" type="radio" required name="q17">I take charge<br> 
	<br>

	<span class="quest_head">18. How far in advance would you study for a major test?</span><br> 
	<input value ="20" type="radio" required name="q18">Two weeks ahead or more<br>
	<input value ="15" type="radio" required name="q18">About one week before the test<br> 
  	<input value ="10" type="radio" required name="q18">A day or two beforehand<br> 
  	<input value ="3" type="radio" required name="q18">I usually don't study<br> 
	<br>

	<span class="quest_head">19. What is an ordinary day in your life like?</span><br> 
	<input value ="10" type="radio" required name="q19">Full of problems<br>
	<input value ="2" type="radio" required name="q19">Full of fun<br> 
  	<input value ="5" type="radio" required name="q19">A mixture of problems and fun<br> 
  	<input value ="15" type="radio" required name="q19">There are never enough things to keep me busy<br> 
	<br>
  
	<span class="quest_head">20. How many days per week do you engage in physical exercise?</span><br> 
	<input value ="0" type="radio" required name="q20">Four or more<br>
	<input value ="0" type="radio" required name="q20">Two or three<br> 
  	<input value ="0" type="radio" required name="q20">One<br> 
  	<input value ="0" type="radio" required name="q20">I don't exercise<br>  
	<br>

	<input type="submit" value="Submit">
	<input type="reset" value="Reset">
	</form>

</div>

<div id="footer" style="margin-top: 280em">
	<br><center>BrainSurge.com &copy; 2014 || Mitra Enterprises || Developers: Evan Johnston &amp; Irene Jea <br>
	<a href="./info.php">About the Developers</a></center>
</div>

</div>
</html>








