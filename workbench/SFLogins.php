<php
     require_once 'soxl/QueryObjects.php';
     require_once 'session.php';
     require_once 'shared.php';
     require_once 'async/QueryFutureTask.php';
     
 
function displayQueryForm($queryRequest) {
    registerShortcut("Ctrl+Alt+W",
        "addFilterRow(document.getElementById('numFilters').value++);".
            "toggleFieldDisabled();");
    if ($queryRequest->getObject()) {;
        $describeSObjectResult = WorkbenchContext::get()->describeSObjects($queryRequest->getObject());
        $fieldValuesToLabels = array();
        foreach ($describeSObjectResult->fields as $field) {
            $fieldValuesToLabels[$field->name] = $field->name;
        }
    } else {
        displayInfo('First choose an object to use the SOQL builder wizard.');
    }
    print "<script type='text/javascript'>\n";
        print "var field_type_array = new Array();\n";
        if (isset($describeSObjectResult)) {
            foreach ($describeSObjectResult->fields as $fields => $field) {
                print " field_type_array[\"$field->name\"]=[\"$field->type\"];\n";
            }
        }
        $ops = array(
            '=' => '=',
            '!=' => '&ne;',
            '<' => '&lt;',
            '<=' => '&le;',
            '>' => '&gt;',
            '>=' => '&ge;',
            'starts' => 'starts with',
            'ends' => 'ends with',
            'contains' => 'contains',
            'IN' => 'in',
            'NOT IN' => 'not in',
            'INCLUDES' => 'includes',
            'EXCLUDES' => 'excludes'
        );
        print "var compOper_array = new Array();\n";
        foreach ($ops as $opValue => $opLabel) {
            print " compOper_array[\"$opValue\"]=[\"$opLabel\"];\n";
        }
    print "</script>\n";
    print "<script src='" . getPathToStaticResource('/script/query.js') . "' type='text/javascript'></script>\n";
    print "<form method='POST' id='query_form' name='query_form' action='query.php'>\n";
    print getCsrfFormTag();
    print "<input type='hidden' name='justUpdate' value='0' />";
    print "<input type='hidden' id='numFilters' name='numFilters' value='" . count($queryRequest->getFilters()) ."' />";
    print "<p class='instructions'>Choose the object, fields, and critera to build a SOQL query below:</p>\n";
    print "<table border='0' style='width: 100%;'>\n";
    print "<tr><td valign='top' width='1'>Object:";
    printObjectSelection($queryRequest->getObject(), 'QB_object_sel', "16", "onChange='updateObject();'", "queryable");
    print "<p/>Fields:<select id='QB_field_sel' name='QB_field_sel[]' multiple='mutliple' size='4' style='width: 16em;' onChange='buildQuery();'>\n";
    if (isset($describeSObjectResult)) {
        print   " <option value='count()'";
        if ($queryRequest->getFields() != null) { //check to make sure something is selected; otherwise warnings will display
            foreach ($queryRequest->getFields() as $selectedField) {
                if ('count()' == $selectedField) print " selected='selected' ";
            }
        }
        print ">count()</option>\n";
        //print ">$field->name</option>\n";
        foreach ($describeSObjectResult->fields as $fields => $field) {
            print   " <option value='$field->name'";
            if ($queryRequest->getFields() != null) { //check to make sure something is selected; otherwise warnings will display
                foreach ($queryRequest->getFields() as $selectedField) {
                    if ($field->name == $selectedField) print " selected='selected' ";
                }
            }
            print ">$field->name</option>\n";
        }
    }
    print "</select></td>\n";
    print "<td valign='top'>";
    print "<table border='0' align='right' style='width:100%'>\n";
    print "<tr><td valign='top' colspan=2>View as:<br/>" .
        "<label><input type='radio' id='export_action_screen' name='export_action' value='screen' ";
    if ($queryRequest->getExportTo() == 'screen') print "checked='true'";
    print " onClick='toggleMatrixSortSelectors(true);'>List</label>&nbsp;";
    print "<label><input type='radio' id='export_action_matrix' name='export_action' value='matrix' ";
    if ($queryRequest->getExportTo() == 'matrix') print "checked='true'";
    print " onClick='toggleMatrixSortSelectors(true);'>Matrix</label>";
    if (WorkbenchConfig::get()->value("allowQueryCsvExport")) {
        print "<label><input type='radio' id='export_action_csv' name='export_action' value='csv' ";
        if ($queryRequest->getExportTo() == 'csv') print "checked='true'";
        print " onClick='toggleMatrixSortSelectors(true);'>CSV</label>&nbsp;";
    }
    print "<label><input type='radio' id='export_action_async_csv' name='export_action' value='async_CSV' ";
    if ($queryRequest->getExportTo() == 'async_CSV') print "checked='true'";
    print " onClick='toggleMatrixSortSelectors(true);'>Bulk CSV</label>&nbsp;";
    print "<label><input type='radio' id='export_action_async_xml' name='export_action' value='async_XML' ";
    if ($queryRequest->getExportTo() == 'async_XML') print "checked='true'";
    print " onClick='toggleMatrixSortSelectors(true);'>Bulk XML</label>&nbsp;";
    print "<td valign='top' colspan=2>Deleted and archived records:<br/>" .
        "<label><input type='radio' name='query_action' value='Query' ";
    if ($queryRequest->getQueryAction() == 'Query') print "checked='true'";
    print " >Exclude</label>&nbsp;";
    print "<label><input type='radio' name='query_action' value='QueryAll' ";
    if ($queryRequest->getQueryAction() == 'QueryAll') print "checked='true'";
    print " >Include</label></td></tr></table>\n";
    print "<table id='QB_right_sub_table' border='0' align='right' style='width:100%'>\n";
    print "<tr id='matrix_selection_headers' style='display: none;'><td><br/>Columns:</td> <td><br/>Rows:</td> <td>&nbsp;</td></tr>\n";
    print "<tr id='matrix_selection_row' style='display: none;'><td><select id='matrix_cols' name='matrix_cols' style='width: 15em;' onChange='toggleFieldDisabled();buildQuery();' onkeyup='toggleFieldDisabled();buildQuery();'>";
    if(isset($fieldValuesToLabels)) printSelectOptions(array_merge(array(""=>""),$fieldValuesToLabels), $queryRequest->getMatrixCols());
    print "</select></td> <td><select id='matrix_rows' name='matrix_rows' style='width: 15em;' onChange='toggleFieldDisabled();buildQuery();' onkeyup='toggleFieldDisabled();buildQuery();'>";
    if(isset($fieldValuesToLabels)) printSelectOptions(array_merge(array(""=>""),$fieldValuesToLabels), $queryRequest->getMatrixRows());
    print "</select></td> <td><img onmouseover=\"Tip('Matrix view groups records into columns and rows of common field values.')\" align='absmiddle' src='" . getPathToStaticResource('/images/help16.png') . "'/></td></tr>\n";
    print "<tr id='sort_selection_headers'><td colspan='2'><br/>Sort results by:</td> <td><br/>Max Records:</td></tr>\n";
    print "<tr id='sort_selection_row'>";
    print "<td colspan='2'><select id='QB_orderby_field' name='QB_orderby_field' style='width: 16em;' onChange='buildQuery();'>\n";
    print "<option value=''></option>\n";
    if (isset($describeSObjectResult)) {
        foreach ($describeSObjectResult->fields as $fields => $field) {
            print   " <option value='$field->name'";
            if ($queryRequest->getOrderByField() != null && $field->name == $queryRequest->getOrderByField()) print " selected='selected' ";
            print ">$field->name</option>\n";
        }
    }
    print "</select>\n";
    $qBOrderbySortOptions = array(
        'ASC' => 'A to Z',
        'DESC' => 'Z to A'
    );
    print "<select id='QB_orderby_sort' name='QB_orderby_sort' style='width: 6em;' onChange='buildQuery();' onkeyup='buildQuery();'>\n";
    foreach ($qBOrderbySortOptions as $opKey => $op) {
        print "<option value='$opKey'";
        if (isset($_POST['QB_orderby_sort']) && $opKey == $_POST['QB_orderby_sort']) print " selected='selected' ";
        print ">$op</option>\n";
    }
    print "</select>\n";
    $qBNullsOptions = array(
        'FIRST' => 'Nulls First',
        'LAST' => 'Nulls Last'
    );
    print "<select id='QB_nulls' name='QB_nulls' style='width: 10em;' onChange='buildQuery();' onkeyup='buildQuery();'>\n";
    foreach ($qBNullsOptions as $opKey => $op) {
        print "<option value='$opKey'";
        if ($queryRequest->getOrderByNulls() != null && $opKey == $queryRequest->getOrderByNulls()) print " selected='selected' ";
        print ">$op</option>\n";
    }
    print "</select></td>\n";
    print "<td><input type='text' id='QB_limit_txt' size='10' name='QB_limit_txt' value='" . htmlspecialchars($queryRequest->getLimit() != null ? $queryRequest->getLimit() : null,ENT_QUOTES) . "' onkeyup='buildQuery();' /></td>\n";
    print "</tr>\n";
    print "</table>\n";
    print "</td></tr>\n";
    $filterRowNum = 0;
    foreach ($queryRequest->getFilters() as $filter) {
        print "<script>addFilterRow(" .
            $filterRowNum++ . ", " .
            "\"" . $filter->getField()     . "\", " .
            "\"" . $filter->getCompOper()  . "\", " .
            "\"" . htmlspecialchars($filter->getValue(), ENT_QUOTES)     . "\"" .
            ");</script>";
    }
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
