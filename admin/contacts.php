<?php include_once( '../include/database.php'); ?>
<?php include_once( '../include/functions.php'); ?>
<?php include_once( '../include/Sessions.php'); ?>
<?php confirm_login(); ?>
<?php 
    global $connection;
    $dataError='';
    $sn=0 ;
    $sql="SELECT * FROM contacts ORDER BY datetime DESC" ;
    $result=$connection->query($sql);


	$unapproveCommentCount = "SELECT count(*) as upapproveComment from comments where status='Pending'";
	$count = $connection->query($unapproveCommentCount);

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<script src="../js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../css/adminstyles.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Contacts</title>
	<style>
	</style>
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2 mt-2">
			<h1 class="text-primary text-center">DASH</h1>
				<ul id="side_menu" class="nav flex-column nav-pills">
					<li class="nav-item">
						<a class="nav-link" href="dashboard.php"> <i class="fa fa-tachometer" aria-hidden="true"></i>
							&nbsp;Dashboard</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="AddNewPost.php"> <i class="fa fa-list" aria-hidden="true"></i>
							&nbsp;Add New post</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="categories.php"> <i class="fa fa-tags" aria-hidden="true"></i>
							&nbsp;Categories</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="admins.php"> <i class="fa fa-users" aria-hidden="true"></i>
							&nbsp;Manage Admins</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="aboutus.php"> <i class="fa fa-info" aria-hidden="true"></i>
							&nbsp;About Us</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="Comments.php"> <i class="fa fa-comments" aria-hidden="true"></i>
							&nbsp;Comments <?php while($countcom = $count->fetch_assoc()){
								$unapprove = $countcom["upapproveComment"];
							} ?>
							<?php if($unapprove > 0){ ?><span class="badge badge-danger" style="float:right;"><?php echo $unapprove ?></span> <?php } ?></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"> <i class="fa fa-rss" aria-hidden="true"></i>
							&nbsp;Live Blog</a>
					</li>
					<li class="nav-item">
                        <a class="nav-link active" href="contacts.php">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            &nbsp;Contacts
                        </a>
                    </li>
					<li class="nav-item">
						<a class="nav-link" href="Logout.php"> <i class="fa fa-sign-out" aria-hidden="true"></i>
							&nbsp;Logout</a>
					</li>
				</ul>
			</div>
			<!-- ending of side area-->
			<div class="col-sm-10">
				<?php if($_SESSION["succMessage"]){ ?>
					<div class="alert alert-success alert-dismissible mt-4">
						<?php echo successMessage(); ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					</div>
				<?php } ?>
				<h4 class="m-5 text-center">All Contacts </h4>
				<div class="table-responsive">
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
								<th scope="col">SN</th>
								<th scope="col">Name</th>
								<th scope="col">Title</th>
								<th scope="col">Description </th>
								<th scope="col">Read Status</th>
							</tr>
						</thead>
						<tbody>
                            <?php
                             while( $row=$result->fetch_assoc() ){ 
                                 $sn++;
                                 $id = $row["id"];
                                 $first_name= $row["first_name"]; 
                                 $last_name= $row["last_name"]; 
                                 $title = $row["title"]; 
                                 $description = $row["description"]; 
                                 $status = $row["is_read"]; 
                            ?>
							<tr>
								<th scope="row">
									<?php echo $sn ?>
								</th>
								<td>
									<?php echo $first_name. ' '. $last_name ?>
								</td>
								<td>
									<?php  echo $title ?>
                                        </td>
								<td>
									<?php echo $description ?>
								</td>
								<td>
								<?php if($status) { ?>
											<a href="#">
                                            <button type="button" class="btn btn-success" disabled>Already Read</button>
											</a>
                                        <?php } ?>
										<?php if(!$status) { ?>
											<a href="ReadContact.php?id=<?php echo $id; ?>">
                                            <button type="button" class="btn btn-warning">Make Read</button>
											</a>
                                        <?php } ?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- ending of side area-->
		</div>
		<!-- ending  of row-->
	</div>
	<!-- ennd containger-->
	<div id="footer" class="mt-5">
		<!-- Footer div -->
		<hr>
		<p>| &copy; | 2020 <a href="https://sambhattarai.com.np" target="_blank">SAMBHATTARAI</a> All Right Reserved</p>
		<hr>
	</div>
	<div style="height:5px; background-color: #283b5f"></div>
</body>

</html>