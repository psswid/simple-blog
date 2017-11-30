<?php

require 'classes/Database.php';

$database = new Database;



$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if($_POST['delete']){
  $del_id = $_POST['delete_id'];
  $database->query('DELETE FROM posts WHERE id= :id');
  $database->bind(':id', $del_id);
  $database->execute();
}

if($post['submit']){
  $id = $post['id'];
  $title = $post['title'];
  $body = $post['body'];

  $database->query('UPDATE posts SET title= :title, body= :body WHERE id= :id');
  $database->bind(':title', $title);
  $database->bind(':body', $body);
  $database->bind(':id', $id);
  $database->execute();


}
$database->query('SELECT * FROM posts');
$rows = $database->resultset();
?>
<h1>Add new post</h1>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method='post'>
  <label for="">Post ID</label><br>
  <input type="text" name='id' placeholder="Specify ID"><br>
  <label for="">Post Title</label><br>
  <input type="text" name='title' placeholder="Add a Title..."><br>
  <label for="">Post Body</label><br>
  <textarea name="body" id="" cols="30" rows="10"></textarea><br><br>
  <input type="submit" name='submit' value='Submit'>
</form>
<h1>Posts</h1>
<div>
<?php foreach($rows as $row) : ?>
  <div>
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['body']; ?></p>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method='post'>
      <input type="hidden" name='delete_id' value='<?php echo $row['id']; ?>'>
      <input type="submit" name='delete' value='Delete'>
    </form>
  </div>
<?php endforeach; ?>
</div>
