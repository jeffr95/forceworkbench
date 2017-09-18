<php
     $queryString = "SELECT Name, Account.Name FROM Contact";

$queryString .= " LIMIT 1";

$queryResult = $sfdc->query($queryString);

  

 if ($queryResult->size > 0) {

  $records = $queryResult->records;

  foreach ($records as $record) {

   $sObject = new SObject($record);

   echo '<pre>';

   print_r($sObject);

   echo '</pre>';

  }

 }

?>
