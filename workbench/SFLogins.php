<php
     require_once 'soxl/QueryObjects.php';
     require_once 'session.php';
     require_once 'shared.php';
     require_once 'async/QueryFutureTask.php';
     
     $queryRequest = new QueryRequest($defaultSettings);
     $queryRequest->setObject(SF_Login__c);
?>
