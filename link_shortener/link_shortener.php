<!DOCTYPE html>

<html lang="en">

	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Link Shortener</title>
		<link rel="stylesheet" href="../../../assets/css/style.css" media="screen">
		<link rel="stylesheet" href="../../../assets/css/media-queries.css" media="screen">
        <link rel="stylesheet" href="assets/css/style.css" media="screen">
        <!-- jQuery & Bootstrap -->
		<script src="../../../bootstrap/jquery-1.11.0.min.js"></script>
        <link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
        <script src="../../../bootstrap/js/bootstrap.min.js"></script>
        <!-- JavaScript File -->
        <script src="assets/js/script.js"></script>

		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.js"></script>
		<![endif]-->

	</head>

	<body>

		<div class="container">

			<header>
				<div class="title">
					Link Shortener
				</div>
			</header>

			<center>
                <div class="input">
                    <form class="form-horizontal url_form" role="form">
                      <div class="form-group url_input_group">
                        <label class="control-label col-sm-3 url_input_label" for="url_input"></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" id="url_input" placeholder="Please enter an url to shorten...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" id="url_input_button" type="button" onclick="shortenUrl(document.getElementById('url_input').value);">Shorten URL!</button>
                                </span>
                            </div>
                        </div>
                      </div>
                    </form>
                </div>
                <br>
                <div class="result_message"></div>
			</center>
			
			<footer>&copy; 2014 Infinifty Enterpise.</footer>
		</div>
	</body>
</html>