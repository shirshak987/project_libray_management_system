
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,700">
    <link rel="stylesheet" type="text/css" href="css/header_librarian_style.css" />
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


@media only screen and (min-width: 768px) {
  header {
    height: 90px;
    background-color: #13631A; /* Updated background color */
  }
}
	</style>
</head>
<body>
    <header>
        <div id="cd-logo">
            <a href="../">
                <img src="img/logo.png" alt="Logo" width="35" height="35" />
                <p>Library Management System</p>
            </a>
        </div>

        <div class="dropdown">
            <button class="dropbtn"> 
                <p id="librarian-name"> 
                    <?php
                    // Start the PHP session (if not already started)
                    // session_start();

                    // Check if the username is set in the session
                    if (isset($_SESSION['username'])) {
                        echo "" . $_SESSION['username'];
                    } else {
                        echo 'pratik';
                    }
                    ?>
                </p>
            </button>
            <div class="dropdown-content">
                <a href="../logout.php">Logout</a>
            </div>
        </div>
    </header>
</body>
</html>

<?php
require "../db_connect.php";
require "../message_display.php";
require "verify_librarian.php";
require 'dompdf/vendor/autoload.php'; // Include the Composer autoloader

use Dompdf\Dompdf;

// Function to generate PDF
function generatePDF($data) {
    $pdf = new Dompdf();
    $html = '<h1 style="text-align: center;">Issued Books</h1><table border="1" cellspacing="0" cellpadding="8"><tr><th>Issue ID</th><th>Username</th><th>Book ISBN</th><th>Due Date</th><th>Title</th><th>Author</th><th>Category</th></tr>';

    foreach ($data as $row) {
        $html .= '<tr>';
        foreach ($row as $value) {
            $html .= '<td>' . $value . '</td>';
        }
        $html .= '</tr>';
    }

    $html .= '</table>';
    $pdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $pdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $pdf->render();

    // Output the generated PDF to Browser
    $pdf->stream();
}

// Retrieve information from book_issue_log and join with book table
$query = $con->prepare("SELECT l.issue_id, l.member, l.book_isbn, l.due_date, b.title, b.author, b.category FROM book_issue_log l JOIN book b ON l.book_isbn = b.isbn;");
$query->execute();
$result = $query->get_result();
$rows = mysqli_num_rows($result);

if ($rows == 0) {
    echo "<h2 align='center'>No issued books available</h2>";
} else {
    ?>
    <form class='cd-form' method='POST' action='#'>
        <center><legend>Issued Books</legend></center>
        <div class='error-message' id='error-message'>
            <p id='error'></p>
        </div>
        <table width='100%' cellpadding=10 cellspacing=10>
            <tr>
                <th>Select</th>
                <th>Issue ID<hr></th>
                <th>Username<hr></th>
                <th>Book ISBN<hr></th>
                <th>Due Date<hr></th>
                <th>Title<hr></th>
                <th>Author<hr></th>
                <th>Category<hr></th>
            </tr>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td><label class='control control--checkbox'><input type='checkbox' name='cb_" . $row['member'] . "' value='" . $row['member'] . "' /><div class='control__indicator'></div></label></td>";
                for ($j = 0; $j < 7; $j++) {
                    echo "<td>" . $row[$j] . "</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
        <br>
        <input type='submit' value='Generate PDF' name='generate_pdf' />
    </form>
    <?php
}

// Generate PDF on button click
if (isset($_POST['generate_pdf'])) {
    $selectedUsers = array();
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'cb_') === 0) {
            $selectedUsers[] = substr($key, 3);
        }
    }

    if (count($selectedUsers) > 0) {
        $selectedData = array();
        $query = $con->prepare("SELECT l.issue_id, l.member, l.book_isbn, l.due_date, b.title, b.author, b.category FROM book_issue_log l JOIN book b ON l.book_isbn = b.isbn WHERE l.member IN ('" . implode("','", $selectedUsers) . "');");
        $query->execute();
        $result = $query->get_result();
        while ($row = mysqli_fetch_array($result)) {
            $selectedData[] = $row;
        }

        generatePDF($selectedData);
    } else {
        echo error_without_field("Please select at least one user to generate the report");
    }
}
?>
