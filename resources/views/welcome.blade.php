<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts に追加 -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Styles に追加 -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <!-- Styles -->
    <!-- <link rel="stylesheet" href="{{ mix('/css/app.css') }}"> -->
</head>
<body>
	<div id="app">
		<v-app>
		<v-main>
			<v-container>
			    <admin-other></admin-other>
			</v-container>
		</v-main>
		</v-app>
  	</div>

	<script src=" {{ mix('js/app.js') }} "></script>
</body>
</html>