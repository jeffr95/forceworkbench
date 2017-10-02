<?php
require_once 'session.php';
require_once 'shared.php';
require_once 'header.php';
?>

<style>
table#t01, table#t01 th, table#t01 td
{
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
  
  <table id="t01" style="width:100%">
  <h4>MJ Bean Projects</h4>                                 
      <tr>
          <th style="text-align:center">Production</th>
          <th style="text-align:center">Sandbox</th>
          <th style="text-align:center">Login to Workbench</th>
      </tr>
      <tr>
        <td><input type="button" value="Login" onclick="window.open('https://www.salesforce.com/login.jsp?un=relationedgeatlanta@gmail.com&pw=')"/>     Trailhead Prod</td>
        <td><input type="button" value="Login" onclick="window.open('https://test.salesforce.com/login.jsp?un=jrichards@relationedge.dev1.com&pw=')"/>     Trailhead Sandbox</td>
        <td><input type="button" value="Login" onclick="window.open('https://relationedgeatlantaworkbench.herokuapp.com/login.php?un=m_bean@trailhead.com&pw=&atl=')"/>     Trailhead Prod</td>
      </tr>
  </table>
</form>
