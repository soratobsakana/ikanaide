<div class="logreg-wrapper">
    <form action="controllers/logreg.php">
        <h1>Register</h1>
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
        <input class="box" type="submit" name='register' value="Submit">
    </form>
    <p>... or <a href="login">login</a> if you don't have an account.</p>
</div>