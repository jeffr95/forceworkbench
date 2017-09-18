<php
     require_once 'soxl/QueryObjects.php';
     require_once 'session.php';
     require_once 'shared.php';
     require_once 'async/QueryFutureTask.php';
     
 
//Obtaining object containing record data with Lead ID
$queryLead = "SELECT Id, LastName, FirstName, Salutation, Title, Company, Street, City, State, PostalCode, Country, Phone, Email, Website FROM Lead WHERE Id='00A5150409abcyQAHB'";
$resultLead = $connection->query($queryLead);
 
//Obtaining object containing record data with Email address
$queryEmail = "SELECT Id, LastName, FirstName, Salutation, Title, Company, Street, City, State, PostalCode, Country, Phone, Email, Website FROM Lead WHERE Email='somebody@email.com'";
$resultEmail = $connection->query($queryEmail);
 
//Checking if the query for a Lead with ID returns an object
if ($resultLead->size) {
 //The lead exists
 //Display or parse values from the object
}
else {
 echo "This lead does not exist in Salesforce.";
}
?>
