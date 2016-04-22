<?php
include "class.model.common.php";
$a = $oSession->LogOut();
echo json_encode(array('success'=>true,'return'=>$a));
exit();
?>