<?php

if ($input = file_get_contents('php://input')) {

	die(base64_encode($input));

}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="initial-scale=1" />
<title>Base64 Encode File</title>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.0/css/bootstrap.min.css" />
<style>

.container {
	width: auto;
	max-width: 600px;
}

.input-group {
	width: 100%;
}

.results {
	width: 100%;
	margin: 20px 0;
	padding: 10px;
	font-family: 'Monaco', monospace;
	font-size: 12px;
	line-height: 1.3em;
	resize: none;
	cursor: default;
}

</style>
</head>

<body>

<div id="wrap">

	<div class="container">

		<div class="page-header">
			<h1>Base64 Encode File</h1>
		</div>

		<p class="lead">Drop file anywhere to base64 encode.</p>

		<div class="input-group">

			<textarea class="results" cols="60" rows="10" readonly="readonly"></textarea>

		</div>

		<p>Made by <a href="http://twitter.com/neogeek">@neogeek</a></p>

	</div>

</div>

<script>

(function () {

	'use strict';

	String.prototype.sprintf = function () {

		var value = this,
			item;

		for (item in arguments) {

			if (arguments.hasOwnProperty(item)) {

				value = value.replace(/\{\}/, arguments[item]);

			}

		}

		return value;

	};

	var results = document.querySelector('.results');

	results.addEventListener('click', function () {

		this.select();

	});

	document.addEventListener('dragover', function (e) {

		e.preventDefault();

	});

	document.addEventListener('drop', function (e) {

		var http = new XMLHttpRequest(),
			file = e.dataTransfer.files[0],
			reader = new FileReader();

		results.innerHTML = '';

		reader.onload = function(e) {

			try {

				results.innerHTML = 'data:{};base64,{}'.sprintf(file.type, btoa(e.target.result));

			} catch (error) {

				if ((file.size >> 20) < 1) {

					http.onreadystatechange = function (http) {

						results.innerHTML = 'data:{};base64,{}'.sprintf(file.type, http.target.responseText);

					};

					http.open('POST', window.location.pathname);
					http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					http.send(file);

				} else {

					alert('There was an error encoding the file locally.\n\nAlso, the file is too large (over 1MB) to upload to the server for encoding.');

				}

			}

		};

		reader.readAsText(file);

		e.preventDefault();

	});

}());

</script>

</body>
</html>