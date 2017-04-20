<!DOCTYPE html>
<html>

<?php

/**
 * index.php
 *
 * Call to classMRTGdashboard.php functions and build the dashboard
 *
 * @author     Benjamin Ng <bkfng@hotmail.com.hk>
 * @copyright  2017 Benjamin Ng
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/BNGdev/MRTG-Dashboard-PHP-JSON
 */

include 'classMRTGdashboard.php';
ProjectArray::writeHead();
?>

<body>

<?php
ProjectArray::writeProject((empty($_GET["code"]) ? "home" : $_GET["code"]));
//echo file_get_contents('directory.htmlcode');
ProjectArray::writeDirectory();
?>

</body>
</html>
