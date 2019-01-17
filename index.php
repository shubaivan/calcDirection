<?php require_once __DIR__ . '/vendor/autoload.php'; ?>
<?php

//example
//3 5 start 120 walk 3
//4 1 start 45 walk 6
//8 1 start 60 walk 6

/** @var \App\Router $router */
$router = new \App\Router(new \App\Request());
$router->get('/', function() {
    return <<<HTML
<html>
<head>
    <title>Test</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>   
</head>
<body>
    <form method="post" id="form">
        <label for="input">Input</label>
        <br>
        <textarea name="input" id="input" cols="100" rows="10"></textarea>
        <br>             
        <button id="test" type="button">test</button>
    </form>
    <div id="result">

    </div>
</body>
</html>
<script src="script.js"></script>
HTML;
});

$router->post('/data', function($request) {
    /** @var $request \App\Request */
    if ($request->getData()) {
        return json_encode(App\Navigation::make($request->getData())->calc());
    }

    return json_encode('empty');
});