<php
     require_once 'soxl/QueryObjects.php';
     require_once 'session.php';
     require_once 'shared.php';
     require_once 'async/QueryFutureTask.php';
     
     $query = "SELECT Id, FirstName, LastName, Phone from Contact";
     $response = $mySforceConnection->query($query);
?>
