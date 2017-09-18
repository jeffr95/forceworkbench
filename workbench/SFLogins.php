<php
     require_once 'soxl/QueryObjects.php';
     require_once 'session.php';
     require_once 'shared.php';
     require_once 'async/QueryFutureTask.php';
     
 
function displayQueryForm($queryRequest) {
    print "<tr><td valign='top' colspan=5><br/>Enter or modify a SOQL query below:\n" .
        "<br/><textarea id='soql_query_textarea' type='text' name='soql_query' rows='" . WorkbenchConfig::get()->value("textareaRows") . "' style='width: 99%; overflow: auto; font-family: monospace, courier;'>" . htmlspecialchars($queryRequest->getSoqlQuery(),ENT_QUOTES) . "</textarea>\n" .
        "</td></tr>\n";
    print "<tr><td colspan=1><input type='submit' name='querySubmit' class='disableWhileAsyncLoading' value='Query' onclick='return parentChildRelationshipQueryBlocker();' /></td>";
    print "<td colspan=4 align='right'>";
    print "&nbsp;&nbsp;" .
        "<img onmouseover=\"Tip('Where did saved queries go? They have been replaced with bookmarkable and shareable queries! Just run a query and bookmark the URL to save or copy and paste to share.')\" align='absmiddle' src='" . getPathToStaticResource('/images/help16.png') . "'/>";
    print "</td></tr></table><p/>\n";
    print "<script>toggleFieldDisabled();toggleMatrixSortSelectors(false);</script>";
}
?>
