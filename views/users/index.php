<h2><?php echo $username; ?></h2>

<?php foreach ($users as $user): ?>

        <h3><?php echo $user['username']; ?></h3>
        <div class="main">
                <?php echo $user['email']; ?>
        </div>
        <p><a href="<?php echo site_url('users/'.$user['slug']); ?>">View user</a></p>

<?php endforeach; ?>