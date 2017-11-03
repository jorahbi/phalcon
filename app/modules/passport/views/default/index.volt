<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>passport</title>
    {{ javascript_include("/js/require/require.js") }}
    {{ javascript_include("/js/require/config.js") }}
</head>
<body>
    <div class="container">
        {{ content() }}
    </div>
    <!-- new Vue({
      delimiters: ['${', '}']
    }) -->

</body>
{{ javascript_include("/js/plugins/jquery.min.js") }}
</html>
