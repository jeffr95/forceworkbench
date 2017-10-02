<?php
require_once 'session.php';
require_once 'shared.php';
require_once 'header.php';

$query = 'SELECT Id,Name from Account limit 5';
?>
print($query);
<style>
table#t01, table#t01 th, table#t01 td{
    border: 1px solid black;
    border-collapse: collapse;
}
</style>

<form>
  <table id="t01" style="width:100%">
  <h4>RelationEdge Projects</h1>
  <tr>
      <th style="text-align:center">Production</th>
      <th style="text-align:center">Sandbox</th>
  </tr>
  <tr>
    <td><input type="button" value="Login" onclick="window.open('https://www.salesforce.com/login.jsp?un=relationedgeatlanta@gmail.com&pw=')"/>     RelationEdge Prod</td>
    <td><input type="button" value="Login" onclick="window.open('https://test.salesforce.com/login.jsp?un=jrichards@relationedge.dev1.com&pw=')"/>     RelationEdge Sandbox</td>
  </tr>
  </table>
</form>
