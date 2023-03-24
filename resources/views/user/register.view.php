<div class="logreg-wrapper">
    <form action="register" method="POST">
        <h1>Register</h1>
        <?php if (isset($message)) print '<p class="form-mistake">'.$message.'</p>'; ?>
        <div class="logreg-input box">
            <label for="username">username</label>
            <input type="text" name="username" id="username">
        </div>
        <div class="logreg-input box">
            <label for="email">email</label>
            <input type="email" name="email" id="email">
        </div>
        <div class="logreg-input box">
            <label for="password">password</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="logreg-input box">
            <label for="confirm">confirm</label>
            <input type="password" name="confirm" id="confirm">
        </div>
        <input class="box" id="submit-button__colorful" type="submit" name='register' value="Submit">
    </form>
    <p>... or <a href="login">login</a> if you already have an account.</p>
</div>