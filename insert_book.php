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
		<link rel="stylesheet" href="css/insert_book_style.css">
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
			<center><legend>Add New Book Details</legend></center>
			
				<div class="error-message" id="error-message">
					<p id="error"></p>
				</div>
				
				<div class="icon">
					<input class="b-isbn" id="b_isbn" type="number" name="b_isbn" placeholder="ISBN" required />
				</div>
				
				<div class="icon">
					<input class="b-title" type="text" name="b_title" placeholder="Book Title" required />
				</div>
				
				<div class="icon">
					<input class="b-author" type="text" name="b_author" placeholder="Author Name" required />
				</div>
				
				<div>
				<h4>Category</h4>
				
					<p class="cd-select icon">
						<select class="b-category" name="b_category">
							<option>History</option>
							<option>Comics</option>
							<option>Fiction</option>
							<option>Non-Fiction</option>
							<option>Biography</option>
							<option>Medical</option>
							<option>Fantasy</option>
							<option>Education</option>
							<option>Sports</option>
							<option>Technology</option>
							<option>Literature</option>
						</select>
					</p>
				</div>
				
				<div class="icon">
					<input class="" type="number" name="b_price" placeholder="Enter price in रू" required />
				</div>
				
				<div class="icon">
					<input class="b-copies" type="number" name="b_copies" placeholder="Number of Copies" required />
				</div>
				
				<br />
				<input class="b-isbn" type="submit" name="b_add" value="Add book" />
		</form>
	<body>
	
	<?php
		if(isset($_POST['b_add']))
		{
			$query = $con->prepare("SELECT isbn FROM book WHERE isbn = ?;");
			$query->bind_param("s", $_POST['b_isbn']);
			$query->execute();
			
			if(mysqli_num_rows($query->get_result()) != 0)
				echo error_with_field("A book with that ISBN already exists", "b_isbn");
			else
			{
				$query = $con->prepare("INSERT INTO book VALUES(?, ?, ?, ?, ?, ?);");
				$query->bind_param("ssssdd", $_POST['b_isbn'], $_POST['b_title'], $_POST['b_author'], $_POST['b_category'], $_POST['b_price'], $_POST['b_copies']);
				
				if(!$query->execute())
					die(error_without_field("ERROR: Couldn't add book"));
				echo success("New book record has been added");
			}
		}
	?>
</html>
