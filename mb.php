<html>
<head>
	<title>MBTI</title>
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

<div id="container" style="height: 510em;">
	<a href="./home.php"><img src="./logo.png" id="logo"></a>

<div id="title">
	<h1>Myers-Briggs Type Indicator</h1>
</div>

<div id="anchor"></div>
<div id="info">
	<center><div id="info_title">Brain Surge Site Navigation</div></center>
	<h4><i>Personality Quizzes</i></h4>
	<ul><li style="color: gray">MBTI</li>
	    <li><a href="./big5.php">The Big Five</a></li>
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
				<form method="post" action="mb.php">
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
				<form method="post" action="mb.php"><input type="submit" id="logout" name="logout" value="Log Out"></form>
			</div>
WELCOME;
	}	
	if(isset($_POST["logout"])){
		setcookie("user", "", time() - 3600);
		setcookie("first", "", time() - 3600);
		header("Location: mb.php");
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
			setcookie("user", $un);
			setcookie("first", $name);
			header("Location: mb.php");
		}
		mysqli_close($connect);
	}
?>

<div id="main">

	<center><h2>MBTI: please fill out all questions then submit</h2></center>

	<form id="mbti" method="post" action="./mb_results.php">

	<span class="quest_head">Question 1</span><br>
	<span class="quest">At a party do you:</span><br>
	<input type="radio" name="q1" value="a" required> A: Interact with many, including strangers <br>
	<input type="radio" name="q1" value="b"> B: Interact with a few, known to you <br>
	<br>

	<span class="quest_head">Question 2</span><br>
	<span class="quest">Are you more:</span><br>
	<input type="radio" name="q2" value="a" required> A: Realistic than speculative<br>
	<input type="radio" name="q2" value="b"> B: Speculative than realistic<br>
	<br>

	<span class="quest_head">Question 3</span><br>
	<span class="quest">Is it worse to:</span><br>
	<input type="radio" name="q3" value="a" required> A: Have your "head in the clouds"<br>
	<input type="radio" name="q3" value="b"> B: Be "in a rut"<br>
	<br>

	<span class="quest_head">Question 4</span><br>
	<span class="quest">Are you more impressed by:</span><br>
	<input type="radio" name="q4" value="a" required> A: Principles<br>
	<input type="radio" name="q4" value="b"> B: Emotions<br>
	<br>

	<span class="quest_head">Question 5</span><br>
	<span class="quest">Are you more drawn toward the:</span><br>
	<input type="radio" name="q5" value="a" required> A: Convincing<br> 
	<input type="radio" name="q5" value="b"> B: Touching<br>
	<br>

	<span class="quest_head">Question 6</span><br>
	<span class="quest">Do you prefer to work:</span><br>
	<input type="radio" name="q6" value="a" required> A: To deadlines<br> 
	<input type="radio" name="q6" value="b"> B: Just "whenever"<br> 
	<br>

	<span class="quest_head">Question 7</span><br>
	<span class="quest">Do you tend to choose:</span><br>
	<input type="radio" name="q7" value="a" required> A: Rather carefully<br>
	<input type="radio" name="q7" value="b"> B: Somewhat impulsively<br>
	<br>

	<span class="quest_head">Question 8</span><br>
	<span class="quest">At parties do you:</span><br>
	<input type="radio" name="q8" value="a" required> A: Stay late, with increasing energy<br>
	<input type="radio" name="q8" value="b"> B: Leave early, with decreased energy<br>
	<br>

	<span class="quest_head">Question 9</span><br>
	<span class="quest">Are you more attracted to:</span><br>
	<input type="radio" name="q9" value="a" required> A: Sensible people<br>
	<input type="radio" name="q9" value="b"> B: Imaginative people<br>
	<br>
<!--
	<span class="quest_head">Question 10</span><br>
	<span class="quest">Are you more interested in:</span><br>
	<input type="radio" name="q10" value="a" required> A: What is actual<br>
	<input type="radio" name="q10" value="b"> B: What is possible<br>
	<br>

	<span class="quest_head">Question 11</span><br>
	<span class="quest">In judging others are you more swayed by:</span><br>
	<input type="radio" name="q11" value="a" required> A: Laws than circumstances<br>
	<input type="radio" name="q11" value="b"> B: Circumstances than laws<br>
	<br>

	<span class="quest_head">Question 12</span><br>
	<span class="quest">In approaching others is your inclination to be somewhat:</span><br>
	<input type="radio" name="q12" value="a" required> A: Objective<br>
	<input type="radio" name="q12" value="b"> B: Personal<br>
	<br>

	<span class="quest_head">Question 13</span><br>
	<span class="quest">Are you more:</span><br>
	<input type="radio" name="q13" value="a" required> A: Punctual<br>
	<input type="radio" name="q13" value="b"> B: Leisurely<br>
	<br>

	<span class="quest_head">Question 14</span><br>
	<span class="quest">Does it bother you more having things:</span><br>
	<input type="radio" name="q14" value="a" required> A: Incomplete<br>
	<input type="radio" name="q14" value="b"> B: Completed<br>
	<br>

	<span class="quest_head">Question 15</span><br>
	<span class="quest">In your social groups do you:</span><br>
	<input type="radio" name="q15" value="a" required> A: Keep abreast of others' happenings<br>
	<input type="radio" name="q15" value="b"> B: Get behind on the news<br>
	<br>

	<span class="quest_head">Question 16</span><br>
	<span class="quest">In doing ordinary things are you more likely to:</span><br>
	<input type="radio" name="q16" value="a" required> A: Do it the usual way<br>
	<input type="radio" name="q16" value="b"> B: Do it your own way<br>
	<br>

	<span class="quest_head">Question 17</span><br>
	<span class="quest">Writes should:</span><br>
	<input type="radio" name="q17" value="a" required> A: Say what they mean and mean what they say<br>
	<input type="radio" name="q17" value="b"> B: Express things more by use of analogy<br>
	<br>

	<span class="quest_head">Question 18</span><br>
	<span class="quest">Which appeals to you more:</span><br>
	<input type="radio" name="q18" value="a" required> A: Consistency of thought<br>
	<input type="radio" name="q18" value="b"> B: Harmonious human relationships<br>
	<br>

	<span class="quest_head">Question 19</span><br>
	<span class="quest">Are you more comfortable making:</span><br>
	<input type="radio" name="q19" value="a" required> A: Logical judgments<br>
	<input type="radio" name="q19" value="b"> B: Value judgments<br>
	<br>

	<span class="quest_head">Question 20</span><br>
	<span class="quest">Do you want things:</span><br>
	<input type="radio" name="q20" value="a" required> A: Settled and decided<br>
	<input type="radio" name="q20" value="b"> B: Unsettled and undecided<br>
	<br>

	<span class="quest_head">Question 21</span><br>
	<span class="quest">Would you say you are more:</span><br>
	<input type="radio" name="q21" value="a" required> A: Serious and determined<br>
	<input type="radio" name="q21" value="b"> B: Easy-going<br>
	<br>

	<span class="quest_head">Question 22</span><br>
	<span class="quest">In phoning do you:</span><br>
	<input type="radio" name="q22" value="a" required> A: Rarely question that it will all be said<br>
	<input type="radio" name="q22" value="b"> B: Rehearse what you'll say<br>
	<br>

	<span class="quest_head">Question 23</span><br>
	<span class="quest">Facts:</span><br>
	<input type="radio" name="q23" value="a" required> A: Speak for themselves<br>
	<input type="radio" name="q23" value="b"> B: Illustrate principles<br>
	<br>

	<span class="quest_head">Question 24</span><br>
	<span class="quest">Visionaries are:</span><br>
	<input type="radio" name="q24" value="a" required> A: somewhat annoying<br>
	<input type="radio" name="q24" value="b"> B: rather fascinating<br>
	<br>

	<span class="quest_head">Question 25</span><br>
	<span class="quest">You are more often:</span><br>
	<input type="radio" name="q25" value="a" required> A: a cool-headed person<br>
	<input type="radio" name="q25" value="b"> B: a warm-headed person<br>
	<br>

	<span class="quest_head">Question 26</span><br>
	<span class="quest">It is worse to be:</span><br>
	<input type="radio" name="q26" value="a" required> A: unjust<br>
	<input type="radio" name="q26" value="b"> B: merciless<br>
	<br>

	<span class="quest_head">Question 27</span><br>
	<span class="quest">Should one usually let events occur:</span><br>
	<input type="radio" name="q27" value="a" required> A: by careful selection and choice<br>
	<input type="radio" name="q27" value="b"> B: randomly and by chance<br>
	<br>

	<span class="quest_head">Question 28</span><br>
	<span class="quest">Do you feel better about:</span><br>
	<input type="radio" name="q28" value="a" required> A: having purchased something<br>
	<input type="radio" name="q28" value="b"> B: having the option to buy something<br>
	<br>

	<span class="quest_head">Question 29</span><br>
	<span class="quest">With company, do you:</span><br>
	<input type="radio" name="q29" value="a" required> A: initiate conversation <br>
	<input type="radio" name="q29" value="b"> B: wait to be approached<br>
	<br>

	<span class="quest_head">Question 30</span><br>
	<span class="quest">Common sense is:</span><br>
	<input type="radio" name="q30" value="a" required> A: rarely questionable<br>
	<input type="radio" name="q30" value="b"> B: frequently questionable<br>
	<br>

	<span class="quest_head">Question 31</span><br>
	<span class="quest">Children often do not:</span><br>
	<input type="radio" name="q31" value="a" required> A: make themselves useful enough<br>
	<input type="radio" name="q31" value="b"> B: exercise their fantasy enough<br>
	<br>

	<span class="quest_head">Question 32</span><br>
	<span class="quest">In making decisions do you feel more comfortable with:</span><br>
	<input type="radio" name="q32" value="a" required> A: standards<br>
	<input type="radio" name="q32" value="b"> B: feelings<br>
	<br>

	<span class="quest_head">Question 33</span><br>
	<span class="quest">Are you more:</span><br>
	<input type="radio" name="q33" value="a" required> A: firm than gentle<br>
	<input type="radio" name="q33" value="b"> B: gentle than firm<br>
	<br>

	<span class="quest_head">Question 34</span><br>
	<span class="quest">Which is more admirable:</span><br>
	<input type="radio" name="q34" value="a" required> A: the ability to organize and be methodical<br>
	<input type="radio" name="q34" value="b"> B: the ability to adapt and make do<br>
	<br>

	<span class="quest_head">Question 35</span><br>
	<span class="quest">Do you put more value on:</span><br>
	<input type="radio" name="q35" value="a" required> A: the infinite<br>
	<input type="radio" name="q35" value="b"> B: being open-minded<br>
	<br>

	<span class="quest_head">Question 36</span><br>
	<span class="quest">Does new and non-routine interaction with others:</span><br>
	<input type="radio" name="q36" value="a" required> A: stimulate and energize you<br>
	<input type="radio" name="q36" value="b"> B: tax your reserves<br>
	<br>

	<span class="quest_head">Question 37</span><br>
	<span class="quest">Are you more frequently:</span><br>
	<input type="radio" name="q37" value="a" required> A: a practical sort of person<br>
	<input type="radio" name="q37" value="b"> B: a fanciful sort of person<br>
	<br>

	<span class="quest_head">Question 38</span><br>
	<span class="quest">Are you more likely to:</span><br>
	<input type="radio" name="q38" value="a" required> A: see how others are useful<br>
	<input type="radio" name="q38" value="b"> B: see how others see<br>
	<br>

	<span class="quest_head">Question 39</span><br>
	<span class="quest">Which is more satisfying:</span><br>
	<input type="radio" name="q39" value="a" required> A: to discuss and issue thoroughly<br>
	<input type="radio" name="q39" value="b"> B: to arrive at an agreement on an issue<br>
	<br>

	<span class="quest_head">Question 40</span><br>
	<span class="quest">Which rules you more:</span><br>
	<input type="radio" name="q40" value="a" required> A: your head<br>
	<input type="radio" name="q40" value="b"> B: your heart<br>
	<br>

	<span class="quest_head">Question 41</span><br>
	<span class="quest">Are you more comfortable with work that is:</span><br>
	<input type="radio" name="q41" value="a" required> A: contracted<br>
	<input type="radio" name="q41" value="b"> B: done on a casual basis<br>
	<br>

	<span class="quest_head">Question 42</span><br>
	<span class="quest">Do you tend to look for:</span><br>
	<input type="radio" name="q42" value="a" required> A: the orderly<br>
	<input type="radio" name="q42" value="b"> B: whatever turns up<br>
	<br>

	<span class="quest_head">Question 43</span><br>
	<span class="quest">Do you prefer:</span><br>
	<input type="radio" name="q43" value="a" required> A: many friends with brief contact<br>
	<input type="radio" name="q43" value="b"> B: a few friends with more lengthy contact<br>
	<br>

	<span class="quest_head">Question 44</span><br>
	<span class="quest">Do you go more by:</span><br>
	<input type="radio" name="q44" value="a" required> A: facts<br>
	<input type="radio" name="q44" value="b"> B: principles<br>
	<br>

	<span class="quest_head">Question 45</span><br>
	<span class="quest">Are you more interested in:</span><br>
	<input type="radio" name="q45" value="a" required> A: production and distribution<br>
	<input type="radio" name="q45" value="b"> B: design and research<br>
	<br>

	<span class="quest_head">Question 46</span><br>
	<span class="quest">Which is more of a compliment:</span><br>
	<input type="radio" name="q46" value="a" required> A: You are a very logical person<br>
	<input type="radio" name="q46" value="b"> B: You are a very sentimental person<br>
	<br>

	<span class="quest_head">Question 47</span><br>
	<span class="quest">Which do you value more about yourself:</span><br>
	<input type="radio" name="q47" value="a" required> A: being unwavering<br>
	<input type="radio" name="q47" value="b"> B: being devoted<br>
	<br>

	<span class="quest_head">Question 48</span><br>
	<span class="quest">Do you more often prefer the:</span><br>
	<input type="radio" name="q48" value="a" required> A: final and unalterable statement<br>
	<input type="radio" name="q48" value="b"> B: tentative and preliminary statement<br>
	<br>

	<span class="quest_head">Question 49</span><br>
	<span class="quest">Are you more comfortable:</span><br>
	<input type="radio" name="q49" value="a" required> A: after a decision<br>
	<input type="radio" name="q49" value="b"> B: before a decision<br>
	<br>

	<span class="quest_head">Question 50</span><br>
	<span class="quest">Do you:</span><br>
	<input type="radio" name="q50" value="a" required> A: speak easily and at length with strangers<br>
	<input type="radio" name="q50" value="b"> B: find little to say to strangers<br>
	<br>

	<span class="quest_head">Question 51</span><br>
	<span class="quest">Are you more likely to trust your:</span><br>
	<input type="radio" name="q51" value="a" required> A: experience<br>
	<input type="radio" name="q51" value="b"> B: hunch<br>
	<br>

	<span class="quest_head">Question 52</span><br>
	<span class="quest">Do you feel:</span><br>
	<input type="radio" name="q52" value="a" required> A: more practical than ingenious<br>
	<input type="radio" name="q52" value="b"> B: more ingenious than practical<br>
	<br>

	<span class="quest_head">Question 53</span><br>
	<span class="quest">Which person would you compliment more:</span><br>
	<input type="radio" name="q53" value="a" required> A: one of clear reason<br>
	<input type="radio" name="q53" value="b"> B: one of strong feeling<br>
	<br>

	<span class="quest_head">Question 54</span><br>
	<span class="quest">Are you inclined more to be:</span><br>
	<input type="radio" name="q54" value="a" required> A: fair-minded<br>
	<input type="radio" name="q54" value="b"> B: sympathetic<br>
	<br>

	<span class="quest_head">Question 55</span><br>
	<span class="quest">Is it preferable mostly to:</span><br>
	<input type="radio" name="q55" value="a" required> A: make sure things are arranged<br>
	<input type="radio" name="q55" value="b"> B: just let things happen<br>
	<br>

	<span class="quest_head">Question 56</span><br>
	<span class="quest">In relationships most things should be:</span><br>
	<input type="radio" name="q56" value="a" required> A: re-negotiable<br>
	<input type="radio" name="q56" value="b"> B: random and circumstantial<br>
	<br>

	<span class="quest_head">Question 57</span><br>
	<span class="quest">When the phone rings do you:</span><br>
	<input type="radio" name="q57" value="a" required> A: hasten to get to it first<br>
	<input type="radio" name="q57" value="b"> B: hope someone else will answer<br>
	<br>

	<span class="quest_head">Question 58</span><br>
	<span class="quest">Which do you pride yourself on more:</span><br>
	<input type="radio" name="q58" value="a" required> A: a strong sense of reality<br>
	<input type="radio" name="q58" value="b"> B: a vivid imagination<br>
	<br>

	<span class="quest_head">Question 59</span><br>
	<span class="quest">Are you drawn more to:</span><br>
	<input type="radio" name="q59" value="a" required> A: fundamentals<br>
	<input type="radio" name="q59" value="b"> B: overtones<br>
	<br>

	<span class="quest_head">Question 60</span><br>
	<span class="quest">Which seems the greater error:</span><br>
	<input type="radio" name="q60" value="a" required> A: to be too passionate<br>
	<input type="radio" name="q60" value="b"> B: to be too objective<br>
	<br>

	<span class="quest_head">Question 61</span><br>
	<span class="quest">Do you see yourself as basically:</span><br>
	<input type="radio" name="q61" value="a" required> A: hard-headed<br>
	<input type="radio" name="q61" value="b"> B: soft-headed<br>
	<br>

	<span class="quest_head">Question 62</span><br>
	<span class="quest">Which situation appeals to you more:</span><br>
	<input type="radio" name="q62" value="a" required> A: the structured and scheduled<br>
	<input type="radio" name="q62" value="b"> B: the unstructured and unscheduled<br>
	<br>

	<span class="quest_head">Question 63</span><br>
	<span class="quest">Are you a person that is more:</span><br>
	<input type="radio" name="q63" value="a" required> A: routinized than whimsical<br>
	<input type="radio" name="q63" value="b"> B: whimsical than routinized<br>
	<br>

	<span class="quest_head">Question 64</span><br>
	<span class="quest">Are you more inclined to be:</span><br>
	<input type="radio" name="q64" value="a" required> A: easy to approach<br>
	<input type="radio" name="q64" value="b"> B: somewhat reserved<br>
	<br>

	<span class="quest_head">Question 65</span><br>
	<span class="quest">In writings do you prefer:</span><br>
	<input type="radio" name="q65" value="a" required> A: the more literal<br>
	<input type="radio" name="q65" value="b"> B: the more figurative<br>
	<br>

	<span class="quest_head">Question 66</span><br>
	<span class="quest">Is it harder for you to:</span><br>
	<input type="radio" name="q66" value="a" required> A: identify with others<br>
	<input type="radio" name="q66" value="b"> B: utilize others<br>
	<br>

	<span class="quest_head">Question 67</span><br>
	<span class="quest">Which do you wish more for yourself:</span><br>
	<input type="radio" name="q67" value="a" required> A: clarity of reason<br>
	<input type="radio" name="q67" value="b"> B: strength of compassion<br>
	<br>

	<span class="quest_head">Question 68</span><br>
	<span class="quest">Which is the greater fault:</span><br>
	<input type="radio" name="q68" value="a" required> A: being indiscriminate<br>
	<input type="radio" name="q68" value="b"> B: being critical<br>
	<br>

	<span class="quest_head">Question 69</span><br>
	<span class="quest">Do you prefer the:</span><br>
	<input type="radio" name="q69" value="a" required> A: planned event<br>
	<input type="radio" name="q69" value="b"> B: unplanned event<br>
	<br>

	<span class="quest_head">Question 70</span><br>
	<span class="quest">Do you tend to be more:</span><br>
	<input type="radio" name="q70" value="a" required> A: deliberate than spontaneous<br>
	<input type="radio" name="q70" value="b"> B: spontaneous than deliberate<br>
	<br>
-->
	<input type="submit" value="Submit" name="mbti">
	<input type="reset" value="Reset">
	</form>

</div>	
<div id="footer" style="margin-top: 672em">
	<br><center>BrainSurge.com &copy; 2014 || Mitra Enterprises || Developers: Evan Johnston &amp; Irene Jea <br>
	<a href="./info.php">About the Developers</a></center>
</div>
</div>
</html>
