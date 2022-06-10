<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ? $title : config('app.name','Laravel') }} - Simple POS</title>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.15.2/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- font  --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: 'Lato', sans-serif;
            background: #fafafa;
        } 
        
        .bg-primary {
            background: #2B9BD8 !important;
        }

        .border-primary {
            border: solid 1px #2B9BD8 !important;
        }

        .text-primary {
            color: #2B9BD8;
        }

        .menus .menu {
            margin-bottom: 20px;
        }

        a.menu:hover, a.menu.active {
            background: #2B9BD8 !important;
            color: #fff;
        } 

        a.menu:hover i,  a.menu.active i {
            color: #fff;
        }
    </style>

    @stack('css')
</head>
<body>
    @include('layouts.alert')
    @yield('content')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    @stack('js')
</body>
</html>