<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_librarian.php";
	require "header_librarian.php";
?>

<html>
	<head>
		<title>LMS</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../css/custom_checkbox_style.css">
		<link rel="stylesheet" type="text/css" href="css/pending_registrations_style.css">
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
body {
        color: black;
    }

    table {
        color: black;
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
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
		<?php
			$query = $con->prepare("SELECT username, name, email, balance FROM pending_registrations");
			$query->execute();
			$result = $query->get_result();
			$rows = mysqli_num_rows($result);
			if($rows == 0)
				echo "<h2 align='center'>None at the moment!</h2>";
			else
			{
				echo "<form class='cd-form' method='POST' action='#'>";
				echo "<center><legend>Pending Membership Registration</legend></center>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				echo "<table width='100%' cellpadding=10 cellspacing=10>
						<tr>
							<th></th>
							<th>Username<hr></th>
							<th>Name<hr></th>
							<th>Email<hr></th>
							<th>Balance<hr></th>
						</tr>";
				for($i=0; $i<$rows; $i++)
				{
					$row = mysqli_fetch_array($result);
					echo "<tr>";
					echo "<td>
							<label class='control control--checkbox'>
								<input type='checkbox' name='cb_".$i."' value='".$row[0]."' />
								<div class='control__indicator'></div>
							</label>
						</td>";
					$j;
					for($j=0; $j<3; $j++)
						echo "<td>".$row[$j]."</td>";
					echo "<td>Rs.".$row[$j]."</td>";
					echo "</tr>";
				}
				echo "</table><br /><br />";
				echo "<div style='float: right;'>";
				
				echo "<input type='submit' value='Confirm Verification' name='l_confirm' />&nbsp;&nbsp;&nbsp;";
				echo "<input type='submit' value='Reject' name='l_delete' />";
				echo "</div>";
				echo "</form>";
			}
			
			$header = 'From: <noreply@libraryms.com>' . "\r\n";
			
			if(isset($_POST['l_confirm']))
			{
				$members = 0;
				for($i=0; $i<$rows; $i++)
				{
					if(isset($_POST['cb_'.$i]))
					{
						$username =  $_POST['cb_'.$i];
						$query = $con->prepare("SELECT * FROM pending_registrations WHERE username = ?;");
						$query->bind_param("s", $username);
						$query->execute();
						$row = mysqli_fetch_array($query->get_result());
						
						$query = $con->prepare("INSERT INTO member(username, password, name, email, balance) VALUES(?, ?, ?, ?, ?);");
						$query->bind_param("ssssd", $username, $row[1], $row[2], $row[3], $row[4]);
						if(!$query->execute())
							die(error_without_field("ERROR: Couldn\'t insert values"));
						$members++;
						
						// $to = $row[3];
						// $subject = "Library membership has been accepted";
						// $message = "Your membership has been accepted by the library. You can now issue books using your account.";
						// mail($to, $subject, $message, $header);
					}
				}
				if($members > 0)
					echo success("Successfully added ".$members." members");
				else
					echo error_without_field("No registration selected");
			}
			
			if(isset($_POST['l_delete']))
			{
				$requests = 0;
				for($i=0; $i<$rows; $i++)
				{
					if(isset($_POST['cb_'.$i]))
					{
						$username =  $_POST['cb_'.$i];
						$query = $con->prepare("SELECT email FROM pending_registrations WHERE username = ?;");
						$query->bind_param("s", $username);
						$query->execute();
						$email = mysqli_fetch_array($query->get_result())[0];
						
						$query = $con->prepare("DELETE FROM pending_registrations WHERE username = ?;");
						$query->bind_param("s", $username);
						if(!$query->execute())
							die(error_without_field("ERROR: Couldn\'t delete values"));
						$requests++;
						
						$to = $email;
						$subject = "Library membership rejected";
						$message = "Your membership has been rejected by the library. Please contact a librarian for further information.";
						mail($to, $subject, $message, $header);
					}
				}
				if($requests > 0)
					echo success("Successfully Deleted ".$requests." requests");
				else
					echo error_without_field("No registration selected");
			}
		?>
	</body>
</html>