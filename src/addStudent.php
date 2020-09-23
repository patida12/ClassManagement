<?php include './addUser.php';
    include './head.php'; ?>
<body class="link-tab">
    </section>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blue; color: white;">
                <h4 class="modal-title">Add new student!</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>User Name</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span style="color: red;" class="help-block"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control"
                                value="<?php echo $password; ?>">
                            <span style="color: red;" class="help-block"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control"
                                value="<?php echo $confirm_password; ?>">
                            <span style="color: red;" class="help-block"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($fullname_err)) ? 'has-error' : ''; ?>">
                            <label>Full Name</label>
                            <input type="text" name="fullname" class="form-control" value="<?php echo $fullname; ?>">
                            <span style="color: red;" class="help-block"><?php echo $fullname_err; ?></span>
                        </div>
                        <div class="form-group">
                          <label>Email</label>
                          <input type="email" class="form-control" name="email" aria-describedby="emailHelpId" value="<?php echo $email; ?>">
                          <small id="emailHelpId" class="form-text text-muted">Help text</small>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phonenumber" class="form-control" value="<?php echo $phonenumber; ?>">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <input type="reset" class="btn btn-default" value="Reset">
                            <a href='javascript:history.back(1);' style="float: right;">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
