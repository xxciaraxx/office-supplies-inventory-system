<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Supplies Inventory</title>
    <link rel="favicon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Playfair+Display:wght@700&display=swap');

        body {
            margin: 0;
            font-family: 'Nunito', Arial, sans-serif;
            background-color: #FFF5F7;
            color: #4B4B4B;
        }

        header {
            background: linear-gradient(to right, #FCA5A5, #D6336C);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            position: sticky;
            top:0;
            z-index: 1000;
        }

        header h1 img {
            height: 40px;
            margin-right: 10px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 1.5rem;
            font-weight: 600;
            transition: 0.3s;
        }

        nav a:hover {
            color: #FCA5A5;
        }

        main {
            padding: 2rem;
            max-width: 1100px;
            margin: auto;
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
        
    </style>

    @livewireStyles
</head>
<body>

<header>
    <h1 style="display:flex; align-items:center;">
        <img src="{{ asset('logo.png') }}" alt="Logo" style="width:80px; height:80px; border-radius:50%; object-fit:cover;">
        Office Supplies Inventory
    </h1>

    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('inventory') }}">Inventory</a>
        <a href="{{ route('reports') }}">Reports</a>
        
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            @auth
                <span style="
                    margin-right:1rem;
                    font-weight:600;
                    color:#D6336C;
                    background:#FCA5A5;
                    padding:0.2rem 0.6rem;
                    border-radius:6px;">
                    Hello, {{ auth()->user()->name }}
                </span>
            @endauth
            <button type="submit" style="background:#FCA5A5; color:white; padding:5px 12px; border-radius:6px;">Logout</button>
        </form>
    </nav>
</header>

<main>
    {{ $slot }}
</main>

<footer>
    &copy; Office Supplies Inventory System.
</footer>

@livewireScripts
</body>
</html>
