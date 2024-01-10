<html>
	<head>
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,700">
		<!-- <link rel="stylesheet" type="text/css" href="css/header_style.css" /> -->
		<style>
			html * {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

*,
*:after,
*:before {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

body {
  font-size: 100%;
  font-family: "Open Sans", sans-serif;
  background-color: white;
  margin: 0;
}

img {
  max-width: 100%;
}

header {
  position: relative;
  height: 50px;
  background:#13631A; /* Updated background color */
}

header #cd-logo {
  float: left;
  margin: 0 0 0 5%;
  -webkit-transform-origin: 0 50%;
  -moz-transform-origin: 0 50%;
  -ms-transform-origin: 0 50%;
  -o-transform-origin: 0 50%;
  transform-origin: 0 50%;
  -webkit-transform: scale(0.8);
  -moz-transform: scale(0.8);
  -ms-transform: scale(0.8);
  -o-transform: scale(0.8);
  transform: scale(0.8);
}

header #cd-logo img,
header #cd-logo p {
  display: inline-block;
  vertical-align: middle;
}

header #cd-logo p {
  color:#FFE923;
  font-weight: bold;
  font-size: 1.4rem;
}

header::after {
  content: "";
  display: table;
  clear: both;
}

header a {
  text-decoration: none;
}

@media only screen and (min-width: 768px) {
  header {
    height: 80px;
    background-color: #13631A; /* Updated background color */
  }
  header #cd-logo {
    margin: 4px 0 0 5%;
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1);
  }
}

		</style>
	</head>
	<body>
		<header>
			<a href="./">
				<div id="cd-logo">
					<img src="img/logo.png" alt="Logo" width="45" height="45" />
					<p>Library Management System</p>
				</div>
			</a>
		</header>
	</body>
</html>