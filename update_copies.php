<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_librarian.php";
	require "header_librarian.php";
?>

<html>
	<head>
		<title>LMS</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css" />
		<link rel="stylesheet" type="text/css" href="../css/form_styles.css" />
		<link rel="stylesheet" href="css/update_copies_style.css">
		<style>
						
header {
  position: relative;
  height: 50px;
  background:#13631A; /* Updated background color */
}

header #cd-logo p {
  font-size: 2.2rem !important;
  color: #FFE923;
  font-weight: bold;
  font-size: 1.4rem;
}


#allTheThings input[type="button"] {
  width: 100%;
  border: none;
  border-radius: 30px;
  background: #3e363f;
  /* border-radius: 0.25em; */
  padding: 16px 20px;
  margin-bottom: 20px;
  color: #ffffff;
  font-weight: bold;
  font-family: "Open Sans", sans-serif;
  font-size: 1.6rem;
  float: right;
  cursor: pointer;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  -webkit-appearance: none;
  -moz-appearance: none;
  -ms-appearance: none;
  -o-appearance: none;
  appearance: none;
}

#allTheThings input[type="button"]:focus {
  outline: none;
  background: #58485a;
}

@media only screen and (min-width: 768px) {
  header {
    height: 80px;
    background-color: #13631A; /* Updated background color */
  }
}

		</style>
	</head>
	<body>
		<form class="cd-form" method="POST" action="#">
			<center><legend>Update Book Copies</legend></center>
			
				<div class="error-message" id="error-message">
					<p id="error"></p>
				</div>
				
				<div class="icon">
					<input class="b-isbn" type='text' name='b_isbn' id="b_isbn" placeholder="Book ISBN" required />
				</div>
					
				<div class="icon">
					<input class="b-copies" type="number" name="b_copies" placeholder="Copies to add" required />
				</div>
						
				<input type="submit" name="b_add" value="Update Book Copies" />
		</form>
	</body>
	
	<?php
		if(isset($_POST['b_add']))
		{
			$query = $con->prepare("SELECT isbn FROM book WHERE isbn = ?;");
			$query->bind_param("s", $_POST['b_isbn']);
			$query->execute();
			if(mysqli_num_rows($query->get_result()) != 1)
				echo error_with_field("Invalid ISBN", "b_isbn");
			else
			{
				$query = $con->prepare("UPDATE book SET copies = copies + ? WHERE isbn = ?;");
				$query->bind_param("ds", $_POST['b_copies'], $_POST['b_isbn']);
				if(!$query->execute())
					die(error_without_field("ERROR: Couldn\'t update book copies"));
				echo success("Number of book copies has been updated");
			}
		}
	?>
</html>