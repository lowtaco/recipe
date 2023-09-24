<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Recipe</title>

        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="antialiased">
        <div id="app">
            <main-component></main-component>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
        <script>
            
	if ("paintWorklet" in CSS) {
		CSS.paintWorklet.addModule(
			"https://www.unpkg.com/css-houdini-squircle@0.3.0/squircle.min.js"
		);
	}
</script>
    </body>
</html>
