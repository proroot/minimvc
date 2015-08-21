<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ test }}</title>
</head>
<body>
    <form method="POST" action="{{ pathApp }}test2">
        <input type="text" name="test1">
        <input type="text" name="test2">
        <input type="text" name="test3">
        <input type="text" name="test4">
        <button>Post</button>
    </form>
    <img src="{{ pathApp }}App/Public/Images/test.bmp">
</body>
</html>