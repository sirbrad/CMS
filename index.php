<!doctype html>
<!--[if IE 7]><html class="no-js ie7" lang="en"><![endif]-->
<!--[if IE 8]><html class="no-js ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="no-js ie9" lang="en"><![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>	
    <title><?= (basename($_SERVER['PHP_SELF']) === 'index.php') ? 'Welcome' : ucwords(str_replace(array('.php', '-'), array('', ' '), basename($_SERVER['PHP_SELF']))); ?> | Site Name</title>
    <script src="Assets/Scripts/Utils/modernizr.min.js"></script>
    <meta charset="utf-8">
    <meta name="author" content="Storm Creative" />
    <link type="text/plain" rel="author" href="humans.txt">
    <link rel="stylesheet" href="Assets/Styles/structure.css" />
    <link rel="stylesheet" href="Assets/Styles/skin.css" />
    <link rel="stylesheet" href="Assets/Styles/brand.css" />
    <link rel="stylesheet" href="Assets/Styles/inputs.css" />
    <link rel="stylesheet" href="Assets/Styles/login.css" />
    <link rel="stylesheet" href="Assets/Styles/button.css" />
    <link rel="stylesheet" href="Assets/Styles/feedback.css" />
    <!--[if IE]>
    	<link rel="stylesheet" href="Assets/Styles/IE.css" />
    <![endif]-->
    <script src="Assets/Scripts/Utils/respond.min.js"></script>
</head>
<?php flush(); ?>
<body>	
	<form class="login">
    <p class="fbk error">Details are incorrect</p>
    	<div class="inputs">
            <div>
                <input type="email" name="email" class="input" placeholder="Username" />
                <input type="password" name="password" class="input" placeholder="Password" />
                <a data-login="switch" href="#">Have you forgotten your password?</a>
            </div>
            <div class="hide-elem">
                <input type="email" name="fpass" class="input" placeholder="Email address" />
                <a data-login="switch" href="#">« Back to Login</a>
            </div>
         </div>
        <div class="opts gradbar">
            <input name="remember_me" id="remember" value="yes" type="checkbox" class="btn checkb"><label for="remember">Remember me</label>
            <button class="btn-submit" id="submit">Login</button>
            <img src="Assets/Images/Core/loader.gif" class="loader" alt="" />
        </div>
    </form>
    <!--<script data-main="Assets/Scripts/main" src="Assets/Scripts/Require.min.js"></script>-->
</body>
</html>