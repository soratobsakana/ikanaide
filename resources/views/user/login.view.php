<div class="logreg-wrapper">
    <form action="/login" method="POST">
        <h1>Login</h1>
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
                <h3><label for="password">Password</label></h3>
            </div>
            <div class="box-body">
                <input type="password" name="password" id="password">
            </div>
        </div>
        <input class="submit-button__colorful box" type="submit" name='login' value="Submit">
    </form>
    <p>... or <a href="register">register</a> if you don't have an account.</p>
</div>