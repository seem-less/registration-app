<nav class="navbar navbar-expand navbar-light sticky-top bg-white d-flex">
        <h1 class="navbar-brand">Welcome! Here is the list of registered users.</h1>
        <a class="btn btn-primary ml-auto" href="<?php echo site_url(); ?>" role="button">Register</a>
</nav>
<div class="row d-flex align-items-center justify-content-center">
        <table class="table mx-3">
                <thead>
                        <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email Address</th>
                                <th scope="col">User details</th>
                        </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                        <tr>
                                <th scope="row"><?php echo $user['id']; ?></th>
                                <td><?php echo $user['username']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><a href="<?php echo site_url('users/'.$user['slug']); ?>">View user</a></td>
                        </tr>
                <?php endforeach; ?>
                </tbody>
        </table>
</div>