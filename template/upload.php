<?php

//Check if the uploaded file has template code.
$template = file_get_contents($_FILES['template']['tmp_name']);
if (!strstr($template, '[RAPID-CODE]')) {
    echo "
    <script>
    alert('This template file does not have the template string [RAPID-CODE].');
    parent.document.getElementById('template').value='';
    parent.document.getElementById('template').focus();
    </script>
    ";
    exit();
} else {
    copy($_FILES['template']['tmp_name'], './template.php');
}
?>