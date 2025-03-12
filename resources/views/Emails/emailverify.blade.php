<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
    <p>Hello, {{ $data['name'] }}</p>
    {{-- <p>Your email: {{ $data['id'] }}</p> --}}
    <p>Please click the link below to verify your email. Thank you!</p>

    <p>
        <a href="{{ route('verify.email', ['id' => $data['id']]) }}" 
           style="display: inline-block; padding: 10px 20px; background-color: #28a745; color: #fff; text-decoration: none; border-radius: 5px;">
           Verify Email
        </a>
    </p>
</body>
</html>
