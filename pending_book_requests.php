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
		<link rel="stylesheet" type="text/css" href="css/pending_book_requests_style.css">
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
			$query = $con->prepare("SELECT * FROM pending_book_requests;");
			$query->execute();
			$result = $query->get_result();
			$rows = mysqli_num_rows($result);
			if($rows == 0)
				echo "<h2 align='center'>No requests pending</h2>";
			else
			{
				echo "<form class='cd-form' method='POST' action='#'>";
				echo "<center><legend>Pending book requests</legend></center>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				echo "<table width='100%' cellpadding=10 cellspacing=10>
						<tr>
							<th></th>
							<th>Username<hr></th>
							<th>Book<hr></th>
							<th>Time<hr></th>
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
					for($j=1; $j<4; $j++) {
						// Check if the value is not null before accessing the offset
						$value = isset($row[$j]) ? $row[$j] : '';
						echo "<td>".$value."</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
				echo "<br /><br /><div style='float: right;'>";
				echo "<input type='submit' value='Reject Request' name='l_reject' />&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<input type='submit' value='Allow' name='l_grant'/>";
				echo "</div>";
				echo "</form>";
			}
			
			// Remove mail-related code
			
			if(isset($_POST['l_grant']))
			{
				$requests = 0;
				for($i=0; $i<$rows; $i++)
				{
					if(isset($_POST['cb_'.$i]))
					{
						$request_id =  $_POST['cb_'.$i];
						$query = $con->prepare("SELECT member, book_isbn FROM pending_book_requests WHERE request_id = ?;");
						$query->bind_param("d", $request_id);
						$query->execute();
						$resultRow = mysqli_fetch_array($query->get_result());
						$member = $resultRow[0];
						$isbn = $resultRow[1];
						$query = $con->prepare("INSERT INTO book_issue_log(member, book_isbn) VALUES(?, ?);");
						$query->bind_param("ss", $member, $isbn);
						if(!$query->execute())
							die(error_without_field("ERROR: Couldn\'t issue book"));
						$requests++;
						
						// Remove mail-related code
					}
				}
				if($requests > 0)
					echo success("Granted Successfully!".$requests." requests");
				else
					echo error_without_field("No request selected");
			}
			
			if(isset($_POST['l_reject']))
			{
				$requests = 0;
				for($i=0; $i<$rows; $i++)
				{
					if(isset($_POST['cb_'.$i]))
					{
						$requests++;
						$request_id =  $_POST['cb_'.$i];
						
						$query = $con->prepare("SELECT member, book_isbn FROM pending_book_requests WHERE request_id = ?;");
						$query->bind_param("d", $request_id);
						$query->execute();
						$resultRow = mysqli_fetch_array($query->get_result());
						$member = $resultRow[0];
						$isbn = $resultRow[1];
						
						// Remove mail-related code
						
						$query = $con->prepare("DELETE FROM pending_book_requests WHERE request_id = ?");
						$query->bind_param("d", $request_id);
						if(!$query->execute())
							die(error_without_field("ERROR: Couldn\'t delete values"));
					}
				}
				if($requests > 0)
					echo success("Successfully deleted ".$requests." requests");
				else
					echo error_without_field("No request selected");
			}
		?>
	</body>
</html>
