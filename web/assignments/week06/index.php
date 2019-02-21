<?php
require 'shared.php';
$page_title = 'TO-DO';
require 'header.php';

try {
    $query = $db->prepare('SELECT content, list_id FROM list WHERE user_id=:user_id');
    $query->execute(array('user_id' => $user_id));
}
catch (PDOException $ex) {
  print "<p>error: {$ex->getMessage()} </p>\n\n";
  die();
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $content = safe_post('content');

      $insert = $db->prepare('INSERT INTO list (content, user_id) VALUES (:content, :user_id);');
      $insert->execute(array('content' => $content, 'user_id' => $user_id));
      
      header("Location: index.php");
      die();
    }
  }
  catch (PDOException $ex) {
    print "<p>error: {$ex->getMessage()} </p>\n\n";
    die();
  }

require 'navigation.php';
$content = "";
?>
    <form name="form" action="<?php echo $current_page; ?>" method="post">
        <main role="main" class="container">
            <h1>Sebas's TO-DO list</h1>

            <ul class="list-group">
            <?php foreach($query as $row) { ?>
                <li class="list-group-item" style="color: #3E4649;">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Options
                        </button>
                        <?php echo $row['content']; ?>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="btn btn-primary" type="button" value="done_<?php echo $row['list_id']; ?>">Done</button>
                            <button class="btn btn-primary" type="button" value="edit_<?php echo $row['list_id']; ?>">Edit</button>
                            <button class="btn btn-primary" type="button" value="delete_<?php echo $row['list_id']; ?>">Delete</button>
                        </div>
                    </div>
                </li>
            <?php } ?>
            </ul>
        </main>
    
        <div class="md-form" style="width:100vw; text-align:center;">
            <textarea type="text" id="form7" class="md-textarea form-control" style="width:50vw;display: inline-block;" placeholder="Task to add" rows="1" name="content"><?php echo $content;?></textarea>
            <br>
            <input type="submit" class="btn btn-primary btn-sm" name="add" value="Add">
        </div>
    </form>
<?php
require 'footer.php';
?>