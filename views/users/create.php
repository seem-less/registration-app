
    <div class="row h-100 d-flex align-items-center justify-content-center">
        <div class="card">

            <?php echo form_open('users/create', 'class="col-12" novalidate'); ?>
                <div class="form-group pt-3">
                    <label for="username">Username</label>
                    <input name="username" type="text" class="form-control" id="username" aria-describedby="usernameInsert" placeholder="Insert your username"/>
                    <small id="usernameHelp" class="text-danger">
                    <?php echo form_error('username'); ?>
                    </small> 
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input name="email" type="email" class="form-control" id="email" aria-describedby="emailInsert" placeholder="Insert your email address"></input>
                    <small id="emailHelp" class="text-danger">
                    <?php echo form_error('email'); ?>
                    </small> 
                </div>
                <div class="g-recaptcha" data-sitekey="6LfYxdEUAAAAAG9bvJpqf0PZwuZAyx9Zmy9FQx0q"></div>
                <small id="gHelp" class="text-danger">
                    <?php echo form_error('g-recaptcha-response'); ?>
                </small>
                <br/>
                <button type="submit" name="submit" class="btn btn-primary d-flex ml-auto">Register</button>
            </form>
        </div>
    </div>
