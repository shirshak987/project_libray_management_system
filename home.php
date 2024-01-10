<?php
	require "../db_connect.php";
	require "verify_librarian.php";
	require "header_librarian.php";
?>

<html>
	<head>
		<title>LMS</title>
		<link rel="stylesheet" type="text/css" href="css/home_style.css" />
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
		<div id="allTheThings">
			
			<a href="insert_book.php">
				<input type="button" value="Insert New Book Record" />
			</a><br />

			<a href="update_copies.php">
				<input type="button" value="Update Copies of a Book" />
			</a><br />

			<a href="delete_book.php">
				<input type="button" value="Delete Book Records" />
			</a><br />

			<a href="display_books.php">
				<input type="button" value="Display Available Books" />
			</a><br />

			<a href="pending_book_requests.php">
				<input type="button" value="Manage Pending Book Requests" />
			</a><br />

			<a href="pending_registrations.php">
				<input type="button" value="Manage Pending Membership Registrations" />
			</a><br />

			
			<a href="view_issuedbook.php">
				<input type="button" value="View Issued Book" />
			</a><br />

			<a href="update_balance.php">
				<input type="button" value="Update Balance of Members" />
			</a><br />

			<!-- <a href="due_handler.php">
				<input type="button" value="Today's Reminder" /> -->	
			</a><br /><br />

		</div>
	</body>
</html>