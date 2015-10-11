<!DOCTYPE html>
<html lang="en" ng-app="App">
<head>
    <meta charset="UTF-8">
    <title>{{ test }}</title>

    <script src="https://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.6/angular.min.js"></script>
    <script src="{{ pathApp }}App/Public/JS/App.js"></script>
    <script src="{{ pathApp }}App/Public/JS/Controllers.js"></script>
    <script src="{{ pathApp }}App/Public/JS/Services.js"></script>

</head>
<body>
<!-- <div ng-controller="Test">
    <button ng-click="test('Il')">Test</button>
</div>

<div ng-controller="Test2">
    <button ng-click="test('Il')">Test</button>
</div> -->

<div id="example-one" contenteditable="true"></div>

<button onclick="test();">test</button>

<script>
    function test()
    {
        alert($('#example-one').html());
    }
</script>
</body>
</html>