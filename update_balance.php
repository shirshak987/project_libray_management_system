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
		<link rel="stylesheet" href="css/update_balance_style.css">
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
			<center><legend>Update Member's Total Balance</legend></center>
			
				<div class="error-message" id="error-message">
					<p id="error"></p>
				</div>
				
				<div class="icon">
					<input class="m-user" type='text' name='m_user' id="m_user" placeholder="Member username" required />
				</div>
				
				<div class="icon">
					<input class="m-balance" type="number" name="m_balance" placeholder="Balance to add" required />
				</div>
				
				<input type="submit" name="m_add" value="Update Balance" />
		</form>
	</body>
	
	<?php
		if(isset($_POST['m_add']))
		{
			$query = $con->prepare("SELECT username FROM member WHERE username = ?;");
			$query->bind_param("s", $_POST['m_user']);
			$query->execute();
			if(mysqli_num_rows($query->get_result()) != 1)
				echo error_with_field("Invalid username", "m_user");
			else
			{
				$query = $con->prepare("UPDATE member SET balance = balance + ? WHERE username = ?;");
				$query->bind_param("ds", $_POST['m_balance'], $_POST['m_user']);
				if(!$query->execute())
					die(error_without_field("ERROR: Couldn\'t add balance"));
				echo success("Balance successfully updated");
			}
		}
	?>
</html>