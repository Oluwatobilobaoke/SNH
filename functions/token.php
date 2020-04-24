<?php

function generateToken()
{
    $token = "";  // work on token generation

    $alpha = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L"];

    for ($i = 0; $i < 30; $i++) {
        //get random numbers
        //get elements in alphabets at the index of random number
        //add that to the token string
        $tokenTobeGotten = mt_rand(0, count($alpha) - 1);
        $token .= $alpha[$tokenTobeGotten];
    }
    return $token;
}

function findToken($email = "")
{
    $allUserTokens = scandir("db/tokens/"); //return @array (2 filled)

    $countAllUserTokens = count($allUserTokens);

    for ($counter = 0; $counter < $countAllUserTokens; $counter++) {

        $current_Token_File = $allUserTokens[$counter];
        if ($current_Token_File == $email . ".json") {

            $tokenContent = file_get_contents("db/tokens/" . $current_Token_File);

            $tokenObject = json_decode($tokenContent);
            return $tokenObject;
        }
    }

    return false;
}
