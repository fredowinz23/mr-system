<?php
if (!defined('WEB_ROOT')) {
	exit;
}


if (isset($_GET['catId']) && (int)$_GET['catId'] > 0) {
	$catId = (int)$_GET['catId'];
	$sql2 = " AND p.cat_id = $catId";
	$queryString = "catId=$catId";
} else {
	$catId = 0;
	$sql2  = '';
	$queryString = '';
}

// for paging
// how many rows to show per page
$rowsPerPage = 100;

$username =$_SESSION["username"];

$sql = "SELECT b_id, b_name, b_borrower, b_by, b_bm, b_bd, b_disapprovedcomment,b_gso
		 FROM tbl_borrowed
		WHERE b_borrower ='$username'";
$result     = dbQuery(getPagingQuery($sql, $rowsPerPage));
$pagingLink = getPagingLink($sql, $rowsPerPage, $queryString);

$categoryList = buildCategoryOptions($catId);

?> 
<div class="table">
&nbsp;
<form action="processReservation.php?action=addReservation" method="post"  name="frmListReservation" id="frmListReservation">

  <?php
$parentId = 0;
if (dbNumRows($result) > 0) {
	$i = 0;
	
	while($row = dbFetchAssoc($result)) {
		extract($row);
		
		if($b_gso ==0)
		{
		$status ='is still pending';
		}
		else if ($b_gso==1)
		{
		$status = 'has already been approved';
		}
		else
		{
		$status ='has been disapproved because '.$b_disapprovedcomment;
		}
		
		
		$i += 1;
?>
 
 
 
 <p>
 * <?php echo $b_name;?> for <?php echo $b_by;?>-<?php echo $b_bm;?>-<?php echo $b_bd;?> <?php echo $status;?><br><br>
 
 </p>
  <?php
	} // end while
	
} else {


}
?>

 <p>&nbsp;</p>
</form>