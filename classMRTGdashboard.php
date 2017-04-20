<?php

/**
 * classMRTGdashboard.php
 *
 * Organize the MRTG graphs according to information in projects.json and directory.json
 *
 * @author     Benjamin Ng <bkfng@hotmail.com.hk>
 * @copyright  2017 Benjamin Ng
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/BNGdev/MRTG-Dashboard-PHP-JSON
 */

class ProjectArray
{
  public static function writeHead() {
    echo '<head>';
    echo '  <meta http-equiv="Cache-Control" content="no-cache">';
    echo '  <meta http-equiv="Pragma" content="no-cache">';
    echo '  <meta http-equiv="Refresh" content="600">';
    echo '  <link rel="shortcut icon" href="res/favicon.png">';
    echo '  <title>MRTG Dashboard</title>';
    echo '  <link rel="stylesheet" type="text/css" href="style.css">';
    echo '</head>';
  }

  public static function writeProject($project) {
    $list = json_decode(file_get_contents("projects.json"), true);

    for ($pcode = 0; $pcode < count($list); $pcode++) {
      if ($project == $list[$pcode]["code"] ) { break; };
    }

    echo '<h1>' . ($pcode < count($list) ? $list[$pcode]["desc"] : "Access Denied!") . '</h1>';

    if ($pcode === count($list)) {
      echo '<img src="res/delete-icon-md.png" height="276" title="Access Denied !">';
    } elseif (count($list[$pcode]["group"]) === 0) {
      echo '<img src="res/under-construction-md.png" title="Under Constuction !">';
    } else {
      if ($pcode < count($list)) {
        for ($j = 0; $j < count($list[$pcode]["group"]); $j++) {
          echo '<table class="group">' . PHP_EOL;
          echo '<tr><td><h2>' . $list[$pcode]["group"][$j]["name"] . '</h2></td></tr>' . PHP_EOL;
          $left = True;
          for ($k = 0; $k < count($list[$pcode]["group"][$j]["interface"]); $k++) {
            $desc = $list[$pcode]["group"][$j]["interface"][$k]["desc"];
            $port = $list[$pcode]["group"][$j]["interface"][$k]["port"];
            if ($left) { echo '<tr>'; }
            if (empty($desc)) {
              echo '<td></td>';
            } elseif (!file_exists($port . '-day.png')) {
              echo '<td><img src="res/blank.png"></td>';
            } else {
              echo '<td><b>' . $desc . '</b><br/>';
              echo '<a href="analysis.php?page=' . $port;
              echo '.html"><img alt="' . $port;
              echo '" src="' . $port . '-day.png"></a></td>';
            }
            if (!$left) { echo '</tr>'; }
            $left = !$left;
          }
          echo "</table>" . PHP_EOL;
        }
      }
    }
  }

  public static function writeDirectory() {
    $list = json_decode(file_get_contents("directory.json"), true);
    $level = [""];

    echo '<div id="directory">';
    for ($k = 0; $k < count($list); $k++) {
      $top = array_search(max($level), $level) + 1;
      $l = $list[$k]["level"];
      $level[$l] = ($l < $top ? $level[$l] : "") . '<a href="index.php?code=' . $list[$k]["code"] . '" class="' . $list[$k]["button"] . '">' . $list[$k]["name"] . '</a>';
    }
    $top = array_search(max($level), $level) + 1;
    for ($m = 0; $m < $top; $m++) {

      echo (array_key_exists($m, $level) ? $level[$m] : "") . "<br/>";
    }
    echo '</div><br/>';

    echo '<div id="footer">';
    echo 'A dashboard system for MRTG graphs by <a target="_blank" href="https://github.com/bngdev">BNGdev</a><br/>';
    echo 'Graphs by <a target="_blank" href="http://oss.oetiker.ch/mrtg/"><img src="http://oss.oetiker.ch/mrtg/images/foot_logo.gif" alt="MRTG" height="12"/></a>';
    echo '</div>';
  }
}

?>


