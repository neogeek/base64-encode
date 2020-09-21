<?php

if ($input = file_get_contents('php://input')) {

    die(base64_encode($input));

}

?>
