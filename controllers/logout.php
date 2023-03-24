<?php

setcookie('session', "No", time()-1000);
setcookie('session', 'No', time()-1000, '/');

header("Location: /home");