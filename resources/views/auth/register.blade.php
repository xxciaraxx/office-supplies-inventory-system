<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Office Supplies Inventory System</title>
    <link rel="favicon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Playfair+Display:wght@700&display=swap');

        body {
            margin: 0;
            font-family: 'Nunito', Arial, sans-serif;
            background-color: #FFF5F7;
            color: #4B4B4B; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        a {
            color: #D6336C;
            text-decoration: none;
        }

        a:hover {
            color: #BE185D;
        }

        header {
            background: linear-gradient(to right, #FCA5A5, #D6336C);
            padding: 20px 30px;
            text-align: center;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        header h1 {
            margin: 0;
            font-size: 28px;
            font-family: 'Playfair Display', serif;
            color: white;
        }

        header p {
            margin: 5px 0 0;
            font-size: 16px;
            color: #FFF1F3;
        }

        .box {
            width: 350px;
            margin: 40px auto;
            background: white;
            padding: 30px 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .box h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-family: 'Playfair Display', serif;
            color: #D6336C;
        }

        input {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 10px;
            border: 1px solid #D1D5DB;
            font-size: 14px;
        }

        .btn-pink {
            background: #D6336C;
            border: none;
            padding: 10px;
            width: 100%;
            color: white;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: 0.2s ease-in-out;
        }

        .btn-pink:hover {
            background: #BE185D;
        }

        p {
            margin-top: 15px;
            font-size: 14px;
        }

        footer {
            margin-top: auto;
            background: #FCA5A5;
            padding: 15px 0;
            text-align: center;
            font-size: 14px;
            color: white;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            box-shadow: 0 -4px 8px rgba(0,0,0,0.03);
        }

        .error-box {
            background-color: #FFF1F3;
            color: #D6336C;
            border: 1px solid #FCA5A5;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 12px;
            text-align: left;
            font-size: 14px;
        }

        .error-box ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>

<header>
    <h1>Create an Account</h1>
    <p>And start managing your inventory.</p>
</header>

<div class="box">
    <h2>Register</h2>

    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/register" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required><br>

        <button class="btn-pink" type="submit">Create Account</button>
    </form>

    <p>Already have an account? <a href="/login">Log in</a></p>
</div>

<footer>
    &copy; Office Supplies Inventory System.
</footer>

</body>
</html>
