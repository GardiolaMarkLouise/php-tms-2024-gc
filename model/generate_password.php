<?php
    function generatePassword($length = 12) {
        $charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()";
        $password = '';
        $charsetLength = strlen($charset);

        for ($i = 0; $i < $length; $i++) {
            $randomIndex = random_int(0, $charsetLength - 1);
            $password .= $charset[$randomIndex];
        }

        return $password;
    }// Generate and return a new autogenerated password
    echo generatePassword();
?>
