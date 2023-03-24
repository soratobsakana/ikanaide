<footer>
    <ul class="footer-links">
        <a href="/terms"><li>Terms</li></a>
        <a href="/privacy"><li>Privacy</li></a>
        <a href="/contact"><li>Contact</li></a>
        <a href="/support"><li>Support</li></a>
        <a href="/submit"><li>Add Data</li></a>
        <?php
        if (isset($_COOKIE["session"])) {
            if ($_COOKIE['session'] === 'Yes') {
                ?>
            <a href="/logout"><li>Logout</li></a>
            <?php
            }
        }
        ?>
    </ul>
    <p class="footer_copyright">© Ikanaide All rights reserved.</p>
</footer>