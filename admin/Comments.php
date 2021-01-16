<?php include_once( '../include/database.php'); ?>
<?php include_once( '../include/functions.php'); ?>
<?php include_once( '../include/Sessions.php'); ?>
<?php confirm_login(); ?>
<?php 
    global $connection;
    $dataError='';
    $sn=0 ;
    $sql="SELECT * FROM comments ORDER BY datetime DESC" ;
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
	<title>Comments</title>
	<style>
	</style>
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2">
				<br>
				<br>
				<br>
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
						<a class="nav-link active" href="Comments.php"> <i class="fa fa-comments" aria-hidden="true"></i>
							&nbsp;Comments <?php while($countcom = $count->fetch_assoc()){
								$unapprove = $countcom["upapproveComment"];
							} ?>
							<?php if($unapprove > 0){ ?><span class="badge badge-danger" style="float:right;"><?php echo $unapprove ?></span> <?php } ?></a>
					</li>
					<li class="nav-item">
                        <a class="nav-link" href="contacts.php">
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
				<h1 class="text-center m-5">Comments </h1>
				<div class="table-responsive m-3">
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
								<th scope="col">SN</th>
								<th scope="col">Name</th>
								<th scope="col">Email</th>
								<th scope="col">Comments</th>
								<th scope="col">Status</th>
								<th scope="col">Actions</th>
								<th scope="col">Details</th>
							</tr>
						</thead>
						<tbody>
                            <?php
                             while( $row=$result->fetch_assoc() ){ 
                                 $sn++;
                                 $id = $row["id"];
                                 $name= $row["name"]; 
                                 $email = $row["email"]; 
                                 $comments = $row["comment"]; 
                                 $publishedate = $row["datetime"]; 
								 $status = $row["status"]; 
								 $blog_id = $row["blog_id"]
                            ?>
							<tr>
								<th scope="row">
									<?php echo $sn ?>
								</th>
								<td>
									<?php 
                                         echo $name ?>
                                        </td>
								<td>
									<?php echo $email; ?>
								</td>
								<td>
									<?php
									echo $comments; ?>
								</td>
								<td>
                                    <?php if($status == "Approve"){ ?>
                                        <span class="badge badge-success"><?php echo $status; ?></span>
                                    <?php } ?>
                                    <?php if($status == "Pending"){ ?>
                                        <span class="badge badge-danger"><?php echo $status; ?></span>
                                    <?php } ?>
                                    
								</td>
								<td>
									
                                        <?php if($status == "Pending") { ?>
											<a href="ApproveComment.php?id=<?php echo $id; ?>">
                                            <button type="button" class="btn btn-success">Approve</button>
											</a>
                                        <?php } ?>
										<?php if($status == "Approve") { ?>
											<a href="disApproveComment.php?id=<?php echo $id; ?>">
                                            <button type="button" class="btn btn-warning">Dis-approve</button>
											</a>
                                        <?php } ?>
									
									
									<a href="DeleteComment.php?id=<?php echo $id; ?>">
										<button type="button" class="btn btn-danger">Delete</button>
									</a>
								</td>
								<td>
									<a href="../FullPost.php?id=<?php echo $blog_id; ?>">
										<button type="button" class="btn btn-info">View Post</button>
									</a>
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
	<div id="footer">
		<!-- Footer div -->
		<hr>
		<p>| &copy; | 2020 <a href="https://sambhattarai.com.np" target="_blank">SAMBHATTARAI</a> All Right Reserved</p>
		<hr>
	</div>
	<div style="height:10px; background-color: #283b5f"></div>
</body>

</html>