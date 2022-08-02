<?php 
if(isset($_POST) && !empty($_POST)) {
	include('library/phpqrcode/qrlib.php');
	$codesDir = "codes/";	
	$codeFile = date('d-m-Y-h-i-s').'.png';
	$formData = $_POST['formData'];
	// generating QR code
	QRcode::png( $formData, $codesDir.$codeFile, 'L', 3); 
	// display generated QR code
	echo '<img class="img-thumbnail" src="/'.$codesDir.$codeFile.'" />';
}
?>