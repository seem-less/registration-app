<?php
echo '<h2>ID number: '.$user['id'].'</h2>';
echo '<h2>'.$user['username'].'</h2>';
echo $user['email'];
?>
<br>
<a class="btn btn-primary" href="<?php echo site_url('users/'); ?>" role="button">Return to List</a>