<?php
function hashPassword($Plaintext)
{
    return password_hash($plainText, PASSWORD_BCRYPT);
}

function veryfyPassword($Plaintext, $hash){
    return password_veryfy ($plainText, $hash);
}