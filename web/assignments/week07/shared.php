<?php
  function safe_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }
  function safe_get($key, $default = '') {
      return safe_input(isset($_GET[$key]) ? $_GET[$key] : $default);
  }
  function safe_post($key, $default = '') {
      return safe_input(isset($_POST[$key]) ? $_POST[$key] : $default);
  }
  function show_errors($errors) {
    if (!isset($errors) || count($errors) == 0) return;
    echo '<div class="alert alert-warning">';
    if (count($errors) == 1) {
      echo $errors[0];
    } else {
      echo '<ul>';
      foreach($errors as $error) {
        echo "<li>$error</li>";
      }
      echo '</ul>';
    }
    echo '</div>';
  }
  session_start();
  $current_page = htmlspecialchars($_SERVER['REQUEST_URI']);
  $dbUrl = getenv('DATABASE_URL');
  if (empty($dbUrl)) {
    $dbUrl = "";
  }
  $dbopts = parse_url($dbUrl);
  $dbHost = $dbopts["host"];
  $dbPort = $dbopts["port"];
  $dbUser = $dbopts["user"];
  $dbPassword = $dbopts["pass"];
  $dbName = ltrim($dbopts["path"],'/');
  try {
    $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('SET search_path TO cs313_php_project');
  }
  catch (PDOException $ex) {
    print "<p>error: $ex->getMessage() </p>\n\n";
    die();
  }
?>