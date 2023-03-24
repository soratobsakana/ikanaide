<div class="logreg-wrapper">
    <form action="/login" method="POST">
        <h1>Login</h1>
        <?php if (isset($message)) print '<p class="form-mistake">'.$message.'</p>'; ?>
        <div class="logreg-input box">
            <label for="username">username</label>
            <input type="text" name="username" id="username">
        </div>
        <div class="logreg-input box">
            <label for="password">password</label>
            <input type="password" name="password" id="password">
        </div>
        <input class="box" id="submit-button__colorful" type="submit" name='login' value="Submit">
    </form>
    <p>... or <a href="register">register</a> if you don't have an account.</p>
</div>