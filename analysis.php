<?php

/**
 * analysis.php
 *
 * Reformat standard MRTG page 
 *
 * @author     Benjamin Ng <bkfng@hotmail.com.hk>
 * @copyright  2017 Benjamin Ng
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/BNGdev/MRTG-Dashboard-PHP-JSON
 */

include 'classMRTGdashboard.php';

$handle = @fopen($_GET["page"], "r");
$skip = FALSE;
if ($handle) {
  while (($buffer = fgets($handle, 4096)) !== false) {
    if (strpos($buffer, '<title>Traffic Analysis') !== false) {
      echo '          <title>MRTG Dashboard</title>';
    } elseif (strpos($buffer, '<meta') == true) {
      $skip = TRUE;
    } elseif (strpos($buffer, '</style>') == true) {
      $skip = FALSE;
    } elseif (strpos($buffer, '</head>') == true) {
      echo '          <meta http-equiv="Cache-Control" content="no-cache">' . PHP_EOL;
      echo '          <meta http-equiv="Pragma" content="no-cache">' . PHP_EOL;
      echo '          <meta http-equiv="Refresh" content="600">' . PHP_EOL;
      echo '          <link rel="shortcut icon" href="res/favicon.png">' . PHP_EOL;
      echo '          <link rel="stylesheet" type="text/css" href="style.css">' . PHP_EOL . ' </head>' . PHP_EOL;
    } elseif (strpos($buffer, 'The statistics') !== false) {
      $pos1 = strpos($buffer, '<div');
      $pos2 = strpos($buffer, 'The statistics');
      echo substr($buffer, 0, $pos1);
      echo '<div class="text">' . substr($buffer, $pos2, -7);
    } elseif (strpos($buffer, 'at which time') !== false) {
      echo substr($buffer, 0, -5);
      echo PHP_EOL;
      echo ' <a href="' . $_GET['page'] . '">';
      echo '<img src="https://oss.oetiker.ch/mrtg/images/mrtg_logo.gif" height="12" width="35" alt="Original MRTG page ' . $_GET['page'] . '" ';
      echo 'title="Original MRTG page [ ' . $_GET['page'] . ' ]">';
      echo '</a></div><br/>' . PHP_EOL;
    } elseif (strpos($buffer, '<img') !== false) {
      echo '<table><tr><td>';
      echo $buffer;
      echo '</td><td>';
    } elseif (strpos($buffer, '</table') !== false) {
      echo '</table></td></tr></table>';
    } elseif (strpos($buffer, "Begin `Daily' Graph") !== false) {
      echo $buffer;
      echo '<table class="group2"><tr><td>';
    } elseif (strpos($buffer, "End `Yearly' Graph") !== false) {
      echo '</td></tr></table>';
      echo $buffer;
    } elseif (strpos($buffer, '<!-- Begin Legend -->') !== false) {
      echo PHP_EOL . PHP_EOL . '<!-- Begin Legend -->' . PHP_EOL;
      echo "<!-- End Legend -->" . PHP_EOL . PHP_EOL;
      //echo file_get_contents('directory.htmlcode');
      ProjectArray::writeDirectory();
      echo "</body></html>";
      break;
    } elseif (!$skip) {
      echo $buffer;
    }
  }
  fclose($handle);
}

?>

