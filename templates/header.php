<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/css/callout.css">
    <!-- Fontawesome (Icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title><?= $title; ?> | Bbc MVC</title>
</head>
<body>

<?php session_start(); ?>

<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container">
        <a class="navbar-brand" href="/">gibbit</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto w-50">
                <li class="nav-item <?php echo (\App\Dispatcher\UriParser::getControllerName() === 'Default') ? 'active' : ''; ?> w-25 text-center">
                    <!-- Gives class 'active' when selected -->
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item <?php echo (\App\Dispatcher\UriParser::getControllerName() === 'Post') ? 'active' : ''; ?> w-25 text-center">
                    <!-- Gives class 'active' when selected -->
                    <a class="nav-link" href="/post">Posts</a>
                </li>
                <li class="nav-item <?php echo (\App\Dispatcher\UriParser::getControllerName() === 'About') ? 'active' : ''; ?> w-25 text-center">
                    <!-- Gives class 'active' when selected -->
                    <a class="nav-link" href="/about">Über Uns</a>
                </li>
                <li class="nav-item w-25 text-center">
                    <div class="dropdown show">
                        <a class="nav-link" href="#" role="button" id="userManagementMenuLink" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-lg fa-user"></i>&nbsp;<i class="fa fa-chevron-down"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userManagementMenuLink">
                            <?php if(isset($_SESSION['isLoggedIn'])): ?>
                            <a class="dropdown-item" href="#"><?= $_SESSION['username']; ?></a>
                            <a class="dropdown-item" href="/user/logout">Logout</a>
                            <?php else: ?>
                            <a class="dropdown-item" href="/user/index">Einloggen</a>
                            <a class="dropdown-item" href="/user/create">Registrieren</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        </div>
    </nav>
</header>
<!-- Breadcrumb -->
<!-- source: https://stackoverflow.com/a/2594624/7986808 -->
<?php

// This function will take $_SERVER['REQUEST_URI'] and build a breadcrumb based on the user's current path
function breadcrumbs($home = 'Home') {
    // This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
    $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));

    // This will build our "base URL" ... Also accounts for HTTPS :)
    $base = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

    // Initialize a temporary array with our breadcrumbs. (starting with our home page, which I'm assuming will be the base URL)
    $breadcrumbs = Array("<a href=\"$base\">$home</a>");

    // Find out the index for the last value in our path array
    $array = array_keys($path);
    $last = end($array);

    // Build the rest of the breadcrumbs
    foreach ($path AS $x => $crumb) {
        // Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
        $title = ucwords(str_replace(Array('.php', '_'), Array('', ' '), $crumb));
        // Workaround to create plural form of a title
        if ($title == 'Post') {
            $title = $title . "s";
        }
        // If we are not on the last index, then display an <a> tag
        if ($x != $last)
            $breadcrumbs[] = "<a href=\"$base$crumb\">$title</a>";
        // Otherwise, just display the title (minus)
        else
            $breadcrumbs[] = $title;
    }

    // Build our temporary array (pieces of bread) into one big string :)
    return $breadcrumbs;
}

?>
<nav aria-label="breadcrumb" class="container mt-5 pt-3">
    <?php $crumbs = breadcrumbs()?>
    <ol class="breadcrumb">
        <?php foreach ($crumbs as $crumb): ?>
            <li class="breadcrumb-item" aria-current="page"><?= $crumb?></li>
        <?php endforeach; ?>
    </ol>
</nav>

<main class="container">
