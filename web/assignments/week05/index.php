<?php
require 'shared.php';
$page_title = 'TO-DO';
require 'header.php';
try {
    $query = $db->prepare('SELECT content FROM list WHERE user_id=:user_id');
    $query->execute(array('user_id' => $user_id));
}
catch (PDOException $ex) {
  print "<p>error: {$ex->getMessage()} </p>\n\n";
  die();
}
require 'navigation.php';
$add_content = "";
?>
    <main role="main" class="container">
        <h1>Sebas's TO-DO list</h1>

        <ul class="list-group">
        <?php foreach($query as $row) { ?>
            <li class="list-group-item"><?php echo $row['content']; ?></li>
        <?php } ?>
        </ul>
    </main>
    
    <div class="md-form" style="width:100vw; text-align:center;">
        <textarea type="text" id="form7" class="md-textarea form-control" style="width:50vw;display: inline-block;" placeholder="Task to add" rows="1"><?php echo $add_content;?></textarea>
        <br>
        <input type="submit" class="btn btn-primary btn-sm" name="add" value="Add">
    </div>
<?php
require 'footer.php';
?>