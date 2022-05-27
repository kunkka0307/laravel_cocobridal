<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<title>ココ ブライダル</title>
<meta name="description" content="ココ ブライダル">
<meta name="keywords" content="ココ ブライダル">

<!-- favicon -->
<link rel="icon" href="/images/favicon.png">
<!-- /favicon -->

<!-- All css links from here -->
<link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
<style>
	.invalid {
		color: #F63876;
	}
</style>
</head>
<body>
	<header>
		<div class="container header">
			<a href="/"><img src="/images/logo.png" class="header_logo"></a>
		</div>
	</header>
    
    @yield('content')

	<footer>
		<ul class="footer_menu">
		</ul>
		<div class="footer_logo"><a href="/"><img src="/images/footer-logo.png"></a></div>
		<ul class="footer_sns">
			<li><a href=""><img src="/images/twitter.png"></a></li>
			<li><a href=""><img src="/images/facebook.png"></a></li>
			<li><a href=""><img src="/images/instagram.png"></a></li>
		</ul>
	    <div class="copyright">Copyright © PartyParty All Rights Reserved.</div>
    </footer>
    
    {{-- Load the application scripts --}}
    <script src="{{ mix('dist/js/app.js') }}"></script>
</body>