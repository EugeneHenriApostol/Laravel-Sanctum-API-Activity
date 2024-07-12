<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #faf0e6; 
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label, input {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: calc(100% - 22px); /* Adjust width to match form padding */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button[type="submit"], button[type="reset"] {
            background-color: #a86add;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 10px;
        }

        button[type="submit"]:hover, button[type="reset"]:hover {
            background-color: #c785ec;
        }

        .error {
            color: red;
            font-size: 0.8em;
        }

        .login-link {
            margin-top: 10px;
            font-size: 0.9em;
        }

    </style>
</head>
<body>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password">
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation">
        </div>
        <div>
            <button type="submit">Register</button>
            <button type="reset">Clear</button>
        </div>
        <div class="login-link">
        Already registered? Login <a href="{{ route('register') }}">Here</a>.
    </div>
    </form>
</body>
</html>
