<?php 
    header("Content-Type: text/html; charset=utf-8");
    if ($this->mode == 'index') {
        header("Cache-Control: must-revalidate");
    }
?>
<!DOCTYPE html>
<html dir="ltr" lang="zh-TW">
<!--
+      o     +              o   
    +             o     +       +
o          +
    o  +           +        +
+        o     o       +        o
-_-_-_-_-_-_-_,------,      o 
_-_-_-_-_-_-_-|   /\_/\  
-_-_-_-_-_-_-~|__( ^ .^)  +     +  
_-_-_-_-_-_-_-""  ""      
+      o         o   +       o
    +         +
o        o         o      o     +
    o           +
+      +     o        o      +    
-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo SITENAME; ?></title>
    <meta name="author" content="Skyarrow &amp; ATI">
    <meta name="generator" content="Super NyanCat ver.<?php echo NYAN_VERSION; ?>">
<?php if ($this->mode == 'index'): ?>
    <link rel="stylesheet" href="css/index.css">
    <!--[if lt IE 10]>
        <link rel="stylesheet" href="css/fuckyouie.css">
    <![endif]-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<?php elseif ($this->mode == 'checkout'): ?>
    <link rel="stylesheet" href="css/checkout.css">
<?php elseif ($this->mode == 'show'): ?>
    <link rel="stylesheet" href="css/show.css" media="screen">
    <link rel="stylesheet" href="css/print.css" media="print">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<?php endif; ?>
    <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>