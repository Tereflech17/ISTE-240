<?php
	$path = './';
	$page = '';
	#include $path. 'assets/inc/header.php';
  	require $path. '../../../../dbConnect.inc';
	if ($mysqli) {
	  if (isset($_GET['name']) && isset($_GET['comment'])) {
	  if( $_GET['name']!='' && $_GET['comment']!='' ){
		/*
			we are using client entered data - therefore we HAVE TO USE a prepared statement
            
            https://www.w3schools.com/php/php_mysql_prepared_statements.asp
            
			1)prepare my query
			2)bind
			3)execute
			4)close
		*/
		
		$stmt=$mysqli->prepare("insert into comments (name, comment) values (?, ?)");
		$stmt->bind_param("ss", $_GET['name'], $_GET['comment']);
		$stmt->execute();
		$stmt->close();
	  }//end of if to make sure data is sent using $_GET
      }//end of isset
      
	  //get contents of table and send back...
      $sql = 'select name, comment from comments';
	  $res=$mysqli->query($sql);
	  if($res){
		while($rowHolder = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$records[] = $rowHolder;
		}
	  }
	}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset = "utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" media="screen" href="assets/comment.css" />
<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
</head>
<body>
	<header class="header">
		 <div class="row">
			 <h2 class="heading">Please leave your comments below.</h2>
		 </div>
	</header>
<div class="row">
  <div class="col-3-of-4">
	<div class="comment__form">
		<form action="index.php" method="GET">
			<div class="form__group">
				<input  type="text" name="name" class="form__input" id="name" placeholder="Enter your name">
			</div>		
 			<div class="form__group">
 				<textarea class="form__textarea" name="comment" id="comment" cols="70" rows="10" placeholder="comments"></textarea>
 			</div>
			 <div class="form__group">
          <button class="btn btn--blue">Send &rarr;</button>
       </div><!-- form__group -->
			</form>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-3-of-4">
		<div class="comment">
		<table class="comment__table">
		<thead> 
      <tr>
		  	 <th>Name</th>
		 	   <th>Comments</th>
			 </tr>
		</thead> 
		<tbody>
<?php 
	//Display data from the database in a table form.
  foreach($records as $this_row){
			echo '<tr>
					<td>'. $this_row['name'] . '</td>  
					<td>'. $this_row['comment'] . '</td>
		    </tr>';
	}// end of foreach loop

?>
</tbody>
 </table>
	</div>		
</div>
</div>
</body>
</html>
