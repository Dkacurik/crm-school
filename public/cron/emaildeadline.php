<?php
$user = 'd3pyho7i';
$pass = 'Bo8E0yKQ03';
$today = date('Y-m-d');
try {
    $dbh = new PDO('mysql:host=mariadb103.websupport.sk;port=3313;dbname=d3pyho7i', $user, $pass);
    foreach($dbh->query('SELECT a.deadline, b.id, a.userid, b.email, a.title, a.content, a.completed from tasks as a left join users as b on a.userid = b.id and a.completed = 0') as $row) {
        if($today == date('Y-m-d', strtotime('-1 day', strtotime($row['deadline'])))){
            $message = '';
            $message .= 'Task title : '. $row['title'] . '<br>';
            $message .= 'Task deadline : '. $row['deadline']. '<br>';
            $message .= 'Task content : '. $row['content'] . '<br>';
            $message .= 'https:crm.werise.dev/tasks' . '<br>';
            $headers = 'From: info@werise.dev' . "\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8";
            mail($row['email'], "Deadline", $message, $headers);
        }
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}