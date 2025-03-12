<html>
<head>
    <title>Test Email</title>
</head>
<body>
     DD($data)
    <p>Hello, {{ $data['name'] }}!</p>
    <p>Please! Click The Link Below To Reset Your Password , Thank You</p>
    <a href="{{ route('reset.pass', ['token' => $data['token']]) }}">Reset Password</a>
</body>
</html>
