<div class="logreg-wrapper">
    <form action="register" method="POST">
        <h1>Register</h1>
        <?php if (isset($message)) print '<p class="form-mistake">'.$message.'</p>'; ?>
        <div class="logreg-input box-wrapper">
            <div class="box-title">
                <h3><label for="username">Username</label></h3>
            </div>
            <div class="box-body">
                <input type="text" name="username" id="username">
            </div>
        </div>
            <div class="logreg-input box-wrapper">
            <div class="box-title">
                <h3><label for="email">Email</label></h3>
            </div>
            <div class="box-body">
                <input type="email" name="email" id="email">
            </div>
        </div>

        <div class="logreg-input box-wrapper">
            <div class="box-title">
                <h3><label for="password">Password</label></h3>
            </div>
            <div class="box-body">
                <input type="password" name="password" id="password">
            </div>
        </div>

        <div class="logreg-input box-wrapper">
            <div class="box-title">
                <h3><label for="confirm">Confirm password</label></h3>
            </div>
            <div class="box-body">
                <input type="password" name="confirm" id="confirm">
            </div>
        </div>

        <input class=" box submit-button__colorful" type="submit" name='register' value="Submit">
    </form>
    <p>... or <a href="login">login</a> if you already have an account.</p>
</div>