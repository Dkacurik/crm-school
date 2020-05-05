<?php
$user = 'd3pyho7i';
$pass = 'Bo8E0yKQ03';
try {
    $dbh = new PDO('mysql:host=mariadb103.websupport.sk;dbname=d3pyho7i', $user, $pass);
    foreach($dbh->query('SELECT a.deadline, b.id, a.userid, b.email from tasks as a left join users as b on a.userid = b.id') as $row) {
        print_r($row);
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}