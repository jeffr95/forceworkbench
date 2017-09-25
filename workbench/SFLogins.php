<head>
        <meta http-equiv="Content-Language" content="UTF-8" />
        <meta http-equiv="Content-Type" content="text/xhtml; charset=UTF-8" />

        <link rel="shortcut icon" href="<?php echo getPathToStaticResource('/images/favicon.ico'); ?>" />

        <link rel="stylesheet" type="text/css" href="<?php echo getPathToStaticResource('/style/master.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo getPathToStaticResource('/style/pro_dropdown.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo getPathToStaticResource('/style/simpletree.css'); ?>" />

        <?php
        $myPage = getMyPage();
        $title = $myPage->showTitle ? ": " . $myPage->title : "";
        print "<title>Workbench$title</title>";
        print "<script type='text/javascript'>var getPathToStaticResource = " . getPathToStaticResourceAsJsFunction() . ";</script>";
        ?>
        
		<script type="text/javascript" src="<?php echo getPathToStaticResource('/script/pro_dropdown.js'); ?>"></script>
    </head>

<php>
<form>
  <p><input type="button" value="Login" onclick="window.open('https://www.salesforce.com/login.jsp?un=relationedgeatlanta@gmail.com&pw=Atlanta12345')"/>     RelationEdge Prod</p>
  <p><input type="button" value="Login" onclick="window.open('https://test.salesforce.com/login.jsp?un=jrichards@relationedge.dev1.com&pw=REPassword1')"/>     RelationEdge Sandbox</p>
</form>
</php>
