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
    <link rel="stylesheet" href="Assets/Styles/header.css" />
    <link rel="stylesheet" href="Assets/Styles/button.css" />
    <link rel="stylesheet" href="Assets/Styles/breadcrumb.css" />
    <link rel="stylesheet" href="Assets/Styles/menu.css" />
    <link rel="stylesheet" href="Assets/Styles/inputs.css" />
    <link rel="stylesheet" href="Assets/Styles/form.css" />
    <link rel="stylesheet" href="Assets/Styles/brand.css" />
    <link rel="stylesheet" media="only screen and (min-width: 600px)" href="Assets/Styles/600.css">
    <link rel="stylesheet" media="only screen and (min-width: 768px)" href="Assets/Styles/768.css">
    <link rel="stylesheet" href="Assets/Styles/extend.css" />
    <!--[if IE]>
    	<link rel="stylesheet" href="Assets/Styles/IE.css" />
    <![endif]-->
    <script src="Assets/Scripts/Utils/respond.min.js"></script>
</head>
<?php flush(); ?>
<body>
	<?php include 'Assets/Includes/Header.php'; ?>
    <!--<ol class="hoz crumb cf">
        <li><a href="#">Home</a></li>
        <li><a href="#">Pages</a></li>
        <li>Page Title</li>
    </ol>-->
    <div class="contain body cf">
        <article class="article">
        	<h1 class="heading gradbar">Page tile</h1>
            <form class="module form cf">
            	<p>Incase you need to explain a few things before the <strong>inputs</strong> you can just use a simple p tag. It is <a href="#">styled</a> to just co-operate with its surroundings.</p>
                <p>You can even add multiple lines if you wish, sometimes it's best when it's broken up.</p>
                <h2 class="title">Title for description</h2>
                <p>Thought it would be good to style a title just incase a point needs to be outlined!</p>
            	<label class="label" for="">Label</label>
                <input class="input">
                <label class="label" for="img">Image</label>
                <span class="img"><img src="Assets/Images/Core/test.jpg" alt="" /></span>
                <ol class="hoz btns img-opts">
                	<li><input type="submit" class="btn f-btn" value="Upload"></li>
                	<li><input type="submit" class="btn e-btn" value="Remove image"></li>
                </ol>
            	<label class="label" for="">Label</label>
                <input class="input">
                <small class="hint">Little hint</small>
            	<label class="label" for="">Label</label>
                <input class="input input-med">
            	<label class="label" for="">Label</label>
                <input class="input input-sml">
                <small class="hint">Little hint</small>
            	<label class="label" for="">D.O.B</label>
                <input class="input input-trio" maxlength="2">
                <input class="input input-trio" maxlength="2">
                <input class="input input-trio" maxlength="4">
                <span class="container">
                    <label class="label" for="">URL</label>
                    <input id="url" class="input input-abbr">
                    <label for="url" class="gradbar abbr">http://</label>
                </span>
                <span class="container">
                    <label class="label" for="">Twitter</label>
                    <input id="twitter" class="input input-abbr">
                    <label for="twitter" class="gradbar abbr">@</label>
                </span>
                <span class="container">
                	<input type="checkbox" id="cool" class="btn checkb">
                    <label class="" for="cool">Would you like me to do something cool for you?</label>
                </span>
            	<label class="label" for="">Label</label>
                <input class="input">
                <small class="hint">Little hint</small>
                <input type="submit" class="btn" value="Submit">
            </form>
        </article>
    </div>
    <!--<script data-main="Assets/Scripts/main" src="Assets/Scripts/Require.min.js"></script>-->
</body>
</html>