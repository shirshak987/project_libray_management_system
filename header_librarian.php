<!-- <html>
	<head>
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,700">
		<link rel="stylesheet" type="text/css" href="css/header_librarian_style.css" />
	</head>
	<body>
		<header>
			<div id="cd-logo">
				<a href="../">
					<img src="img/ic_logo2.svg" alt="Logo" width="45" height="45" />
					<p>Library Management System</p>
				</a>
			</div>
			
			<div class="dropdown">
				<button class="dropbtn"> 
					<p id="librarian-name"> @<?php echo $_SESSION['username'] ?></p>
				</button>
				<div class="dropdown-content">
					<a href="../logout.php">Logout</a>
				</div>
			</div>
		</header>
	</body>
</html> -->

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,700">
    <link rel="stylesheet" type="text/css" href="css/header_librarian_style.css" />
</head>
<body>
    <header>
        <div id="cd-logo">
            <a href="../">
                <img src="img/logo.png" alt="Logo" width="45" height="45" />
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
                    