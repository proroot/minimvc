<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    {% if uData %}
        {%  for uItem in uData if uItem % 2 == 0 %}
            {{  uItem|e }} = 
        {% endfor %}
    {% endif %}
</body>
</html>


