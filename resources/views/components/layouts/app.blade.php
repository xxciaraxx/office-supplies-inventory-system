<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Supplies Inventory</title>
    <style>
        /* --- Base Styles --- */
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

        header h1 {
            margin: 0;
            font-size: 28px;
            font-family: 'Playfair Display', serif;
            display: flex;
            align-items: center;
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

        nav form button {
            background: #FCA5A5; 
            color: white;
            border: none;
            padding: 0.4rem 0.8rem;
            cursor: pointer;
            font-weight: 600;
            border-radius: 6px;
            transition: 0.3s;
        }

        nav form button:hover {
            background: #D6336C; 
        }

        main {
            padding: 2rem;
            max-width: 1100px;
            margin: auto;
            flex:1;
            padding: top 2rem;
        }

        .flash-message {
            background: #FCA5A5;
            color: white;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            font-weight: 600;
        }

        /* Buttons styling */
        button {
            border-radius: 6px;
            font-weight: 600;
        }

        /* Inputs styling */
        input {
            border-radius: 6px;
            border: 1px solid #D1D5DB;
            font-family: 'Nunito', sans-serif;
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

        footer a { color: white; }

        @media (max-width: 900px) {

            header {
                flex-direction: column;
                text-align: center;
                padding: 1.2rem;
            }

            header h1 {
                font-size: 22px !important;
                margin-bottom: 0.5rem;
                justify-content: center;
                text-align: center;
            }

            header h1 img {
                width: 60px !important;
                height: 60px !important;
            }

            nav {
                display: flex;
                flex-direction: column;
                gap: 0.6rem;
                margin-top: 0.5rem;
            }

            nav a {
                margin-right: 0 !important;
                font-size: 16px !important;
            }

            nav form {
                display: flex;
                flex-direction: column;
                gap: 0.6rem;
            }

            nav form button {
                width: 100%;
            }

            .flash-message {
                text-align: center;
                font-size: 14px;
            }

            main {
                padding: 1rem !important;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
                width: 100%;
            }

            table th, table td {
                font-size: 14px !important;
                padding: 8px !important;
            }

            input, button {
                width: 100% !important;
                box-sizing: border-box;
            }
        }

        @media (max-width: 500px) {
            header h1 {
                font-size: 20px !important;
            }

            table th, table td {
                font-size: 12px !important;
            }

            nav a {
                font-size: 14px !important;
            }

            .flash-message {
                font-size: 13px !important;
            }
        }

    </style>

    @livewireStyles
</head>
<body>

<header>
    <h1 style="position:sticky; display:flex; align-items:center; gap:0.5rem;">
        <img src="{{ asset('logo.png') }}" alt="Logo" style="width:80px; height:80px; border-radius:50%; object-fit:cover; display:block;">
        Office Supplies Inventory
    </h1>
    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('inventory') }}">Inventory</a>
        <a href="{{ route('reports') }}">Reports</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf

            <!-- Display logged-in user -->
            @auth
                <span style="
                    margin-left:1.5rem; 
                    margin-right:1.5rem; 
                    font-weight:600; 
                    color:#D6336C; 
                    background:#FCA5A5; 
                    padding:0.2rem 0.6rem; 
                    border-radius:6px;
                    font-style:italic;
                ">Hello, {{ auth()->user()->name }}</span>
            @endauth
            
            <button type="submit">Logout</button>
        </form>
    </nav>

</header>

<main>
    @if(session()->has('message'))
        <div class="flash-message">
            {{ session('message') }}
        </div>
    @endif

    {{ $slot }}
</main>


<footer>
    &copy; Office Supplies Inventory System.
</footer>

@livewireScripts
</body>
</html>
