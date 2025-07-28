<?php

if (! function_exists('generateRandomPassword')) {
    function generateRandomPassword($length = 12) {
        // Define character sets for the password
        $upperCase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowerCase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()-_=+<>?';

        // Combine all character sets
        $allChars = $upperCase . $lowerCase . $numbers . $specialChars;

        // Ensure the password includes at least one character from each set
        $password = $upperCase[random_int(0, strlen($upperCase) - 1)] .
                    $lowerCase[random_int(0, strlen($lowerCase) - 1)] .
                    $numbers[random_int(0, strlen($numbers) - 1)] .
                    $specialChars[random_int(0, strlen($specialChars) - 1)];

        // Fill the rest of the password length with random characters from all sets
        for ($i = 4; $i < $length; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        // Shuffle the password to ensure randomness
        return str_shuffle($password);
    }
}
