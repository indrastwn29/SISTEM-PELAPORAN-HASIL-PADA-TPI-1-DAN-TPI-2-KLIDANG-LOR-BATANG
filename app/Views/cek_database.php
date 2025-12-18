<?php
$db = \Config\Database::connect();
echo "<pre>";
print_r($db->getFieldData('karcis_bakul'));
echo "</pre>";
?>