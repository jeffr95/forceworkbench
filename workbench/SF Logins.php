<?php
try {

  $mySforceConnection = new SforceEnterpriseClient();

  $mySoapClient = $mySforceConnection->createConnection(SOAP_CLIENT_BASEDIR.'/enterprise.wsdl.xml');

  $mylogin = $mySforceConnection->login(reatlantadev@gmail.com, REAtlanta1);

   

  $query = 'SELECT Id,Name from SF_logins__c';

  $response = $mySforceConnection->query(($query));

 

  foreach ($response->records as $record) {

    print_r($record);

    print_r("<br>");

  }

} catch (Exception $e) {

  echo $e->faultstring;

}
?>
