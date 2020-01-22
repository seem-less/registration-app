
    <div class="row h-100 d-flex align-items-center justify-content-center">
        <div class="card">
            <?php echo validation_errors(); ?>

            <?php echo form_open('users/create', 'class="col-12"'); ?>
                <div class="form-group pt-3">
                    <label for="username">Username</label>
                    <input name="username" type="text" class="form-control" id="username" aria-describedby="usernameInsert" placeholder="Insert your username"/>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input name="email" type="email" class="form-control" id="email" aria-describedby="emailInsert" placeholder="Insert your email address"></input>
                </div>
                <form action="?" method="POST">
                    <div class="g-recaptcha" data-sitekey="6LfYxdEUAAAAAG9bvJpqf0PZwuZAyx9Zmy9FQx0q"></div>
                    <br/>
                    <button type="submit" name="submit" class="btn btn-primary d-flex ml-auto">Register</button>
                </form>
            </form>

        </div>
    </div>
