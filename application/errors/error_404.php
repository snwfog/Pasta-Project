<!DOCTYPE html>
<html lang="en">
<head>
<title>404 Page Not Found</title>
<style type="text/css">
	* {
		font-family: 'Helvetica Neue', 'Helvetica', 'Calibri';
		font-weight: lighter;
		color:  white;
	}

	h1, h2, h3, h4, h5 {
		text-shadow: 1px 1px rgba(0, 0, 0, 1);
	}
	#error {
		text-align: center;
		margin-top: 10%;
	}

	body {
		background-image: url('http://localhost:8888/pasta/assets/img/error-hor.jpg');
		background-size: 100%;
		height: 100%;
	}
	
	/*****************/
	/* Media Queries */
	/*****************/
	@media screen and (max-width: 780px) {
		body {
			background-image: url('http://localhost:8888/pasta/assets/img/error-ver.jpg');
		}
	}
</style>
</head>
<body>
	<div id="container">
        <div id="error">
            <h1>=(^_^)=</h1>
            <h1>Sorry, the page that you've requested does not exists.</h1>
            <h2>404<h2>
        </div>
	</div>
</body>
</html>
