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
				Welcome back, <a href="profile.php"><u><b>{$_COOKIE["first"]}</b></u></a>
				<form method="post" action="mb.php"><input type="submit" id="logout" name="logout" value="Log Out"></form>
			</div>
WELCOME;
	}	
	if(isset($_POST["logout"])){
		setcookie("user", "", time() - 3600);
		setcookie("first", "", time() - 3600);
		header("Location: mb_results.php");
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
			header("Location: mb_results.php");
		}
		mysqli_close($connect);
	}
?>

<div id="main">

	<?php

	function score(){

	$type="";

	$e=0;
	$i=0;

	$s=0;
	$n=0;

	$t=0;
	$f=0;

	$j=0;
	$p=0;

	for($k=1; $k<9; $k++){
	
		$question=$_POST["q".$k];
		if($k%7===1){
			if($question==="a"){
				$e++;
			}else{
				$i++;
			}
		}

		if($k%7===2){
			if($question==="a"){
				$s++;
			}else{
				$n++;
			}
		}

		if($k%7===3){
			if($question==="a"){
				$s++;
			}else{
				$n++;
			}
		}

		if($k%7===4){
			if($question==="a"){
				$t++;
			}else{
				$f++;
			}
		}

		if($k%7===5){
			if($question==="a"){
				$t++;
			}else{
				$f++;
			}
		}

		if($k%7===6){
			if($question==="a"){
				$j++;
			}else{
				$p++;
			}
		}

		if($k%7===0){
			if($question==="a"){
				$j++;
			}else{
				$p++;
			}
		}

	}

	if($e>$i){
		$type.="E, ";
	}elseif($e===$i){
		$type.="E/I, ";
	}else{
		$type.="I, ";
	}

	if($s>$n){
		$type.="S, ";
	}elseif($s===$n){
		$type.="S/N, ";
	}else{
		$type.="N, ";
	}

	if($t>$f){
		$type.="T, ";
	}elseif($t===$f){
		$type.="T/F, ";
	}else{
		$type.="F, ";
	}

	if($j>$p){
		$type.="J";
	}elseif($j===$p){
		$type.="J/P";
	}else{
		$type.="P";
	}

	//turns values into percents
	$e=floor($e/10*100);
	$i=floor($i/10*100);

	$s=floor($s/20*100);
	$n=floor($n/20*100);

	$t=floor($t/20*100);
	$f=floor($f/20*100);

	$j=floor($j/20*100);
	$p=floor($p/20*100);

	return (array($type,$e,$i,$s,$n,$t,$f,$j,$p));

	}

	function results(){

		$res=score();
		$type=$res[0];
		$data=array_slice($res, 1);

		$nums="";
		for($i=1; $i<9; $i++){
		$nums.=$res[$i]."<br>";
		}
		
	if(!isset($_COOKIE["user"])){
		$act="./login.php";
	}else{
		$act="./profile.php";
	}

	print<<<RESULTS

		<center>Your MBTI results are<br>
		<h1>$type</h1>

RESULTS;

	}

	function send_results(){
		$host = "fall-2014.cs.utexas.edu";
		//$user = "irenej";
		//$pwd = "Ap+sVVJQbw";
		//$dbs = "cs329e_irenej";
        $user = "evanaj12";
        $pwd = "_zqAskkb9~";
        $dbs = "cs329e_evanaj12";
        	$port = "3306";
		$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
		$table = "brainsurge_data";
		
        if (empty($connect))
        {
                die("mysqli_connect failed: " . mysqli_connect_error());
                return;
        }

        //print "Connected to ". mysqli_get_host_info($connect) . "<br><hr><br>\n";
		$res=score();
		$type=$res[0];
		$data=array_slice($res, 1);

	$str="";
	$str.=$type.":";
	$str.="Extraversion <br>".$data[0]."%:";
	$str.="Introversion <br>".$data[1]."%:";
	$str.="Sensing <br>".$data[2]."%:";
	$str.="Intuition <br>".$data[3]."%:";
	$str.="Thinking <br>".$data[4]."%:";
	$str.="Feeling <br>".$data[5]."%:";
	$str.="Judging <br>".$data[6]."%:";
	$str.="Perceiving <br>".$data[7]."%";
	
	$un=$_COOKIE["user"];

	$result = mysqli_query($connect, "SELECT mbti from $table where user = \"$un\"");
        $row = $result->fetch_row();

	if(count($row) == 0){	
		$stmt="INSERT INTO $table (mbti) VALUES ('$str') WHERE user = '$un'";
        	$connect->query($stmt);
	}else{
		$stmt="UPDATE $table SET mbti='$str' WHERE user='$un';";
                $connect->query($stmt);
	}
        mysqli_close($connect);
	}

	if(isset($_POST["mbti"])){
		send_results();
		results();
	}else{
		print<<<ERR
		<center>Oops! Something went wrong.<br>
ERR;
	}
	?>
		Learn more about what your MBTI results mean:
		</center>
		<ul>
		<li><a href="http://www.16personalities.com/personality-types">An interactive breakdown of each MBTI personality</a></li>
		<li><a href="http://www.learningstorm.org/wp-content/uploads/2014/02/MBTI-personality-test.pdf">A detailed account of each MBTI grouping.</a></li>
</ul>
</div>	

<div id="footer" style="margin-top: 672em">
	<br><center>BrainSurge.com &copy; 2014 || Mitra Enterprises || Developers: Evan Johnston &amp; Irene Jea <br>
	<a href="./info.php">About the Developers</a></center>
</div>
</div>
</html>
