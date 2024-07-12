<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password">
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <button type="submit">Login</button>
    </form>
</body>
</html>
