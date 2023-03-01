<footer>
    <ul class="footer-links">
        <li>Terms</li>
        <li>Privacy</li>
        <li>Contact</li>
        <li>Donate</li>
        <li>Twitter</li>
        <?php
            if (isset($_SESSION["loggedin"])) {
                ?>
                <li>Logout</li>
                <?php
            }
        ?>
    </ul>
    <p class="footer_copyright">© Ikanaide All rights reserved.</p>
</footer>