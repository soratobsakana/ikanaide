<footer>
    <ul class="footer-links">
        <li>Terms</li>
        <li>Privacy</li>
        <li>Contact</li>
        <li>Donate</li>
        <a href="/submit"><li>Add Data</li></a>
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