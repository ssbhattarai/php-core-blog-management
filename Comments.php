<?php include_once( 'include/database.php'); ?>
<?php include_once( 'include/functions.php'); ?>
<?php 
    global $connection;
    $dataError='';
    $sn=0 ;
    $sql="SELECT * FROM comments ORDER BY datetime DESC" ;
    $result=$connection->query($sql);

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/adminstyles.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Comments</title>
	<style>
	</style>
</head>

<body>
	<div style="height:10px;background: #227b5a;"></div>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
				<div class="nav-header">
					<a href="index.php" style="argin: -6px;margin-right: 10px;">
						<img src="static/sundarBlog.png" alt="sundarblog" style="width:8em;">
					</a>
				</div>
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li class="nav-item active"> <a class="nav-link" href="index.php">Home</a>
					</li>
					<li class="nav-item"> <a class="nav-link" href="blog.php" target="_blank">Blog</a>
					</li>
					<li class="nav-item"> <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
					</li>
				</ul>
				<!-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form> -->
			</div>
		</div>
	</nav>
	<div style="height:10px;background: #227b5a;"></div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2">
				<br>
				<br>
				<br>
				<ul id="side_menu" class="nav flex-column nav-pills">
					<li class="nav-item">
						<a class="nav-link active" href="dashboard.php"> <i class="fa fa-tachometer" aria-hidden="true"></i>
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
						<a class="nav-link" href="#"> <i class="fa fa-users" aria-hidden="true"></i>
							&nbsp;Manage Admins</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="Comments.php"> <i class="fa fa-comments" aria-hidden="true"></i>
							&nbsp;Comments</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"> <i class="fa fa-rss" aria-hidden="true"></i>
							&nbsp;Live Blog</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"> <i class="fa fa-sign-out" aria-hidden="true"></i>
							&nbsp;Logout</a>
					</li>
				</ul>
			</div>
			<!-- ending of side area-->
			<div class="col-sm-10">
				<h1>Comments </h1>
				<div class="table-responsive">
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
									<?php echo $comments; ?>
								</td>
								<td>
                                    <?php if($status == "Pending"){ ?>
                                        <span class="badge badge-success"><?php echo $status; ?></span>
                                    <?php } ?>
                                    <?php if($status == "Approve"){ ?>
                                        <span class="badge badge-danger"><?php echo $status; ?></span>
                                    <?php } ?>
                                    
								</td>
								<td>
									<a href="#">
										<button type="button" class="btn btn-success">Edit</button>
									</a>
									<a href="#">
										<button type="button" class="btn btn-danger">Delete</button>
									</a>
								</td>
								<td>
									<a href="">
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