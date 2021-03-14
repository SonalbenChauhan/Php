<?php
# this bit of code will execute immediately in every PHP script that it is added to
# it initializes the PDO interface

try {
    $GLOBALS['db'] = new PDO("mysql:host=localhost; dbname=ecommphp", 'root', '');
    $GLOBALS['db']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo ("in here");
    echo $e->getMessage();
}

# start or continue this user's session
session_start();

# utility function to validate a date
# ISO-8601 format date is expected default
# in JavaScript, new Date().toISOString() will return this format
function isValidDate($date, $format = DateTimeInterface::ISO8601)
{
    $d = DateTime::createFromFormat($format, $date);

    # JavaScript provides a different format of timezone than does PHP
    # so only pay attention to the first 19 characters (up to but not including the timezone)
    return $d && substr($d->format($format), 0, 19) == substr($date, 0, 19);
}

# utility function to check if this session is associated with a valid user
function isLoggedIn(){
    return isset($_SESSION['UserId']) && $_SESSION['UserId'] > 0;
}
