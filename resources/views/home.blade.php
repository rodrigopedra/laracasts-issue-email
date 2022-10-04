<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mail example</title>
</head>
<body>
<form method="POST" action="/">
    @csrf
    <button type="submit">send email</button>
</form>
<hr>
<pre>{{ $log }}</pre>
</body>
</html>
