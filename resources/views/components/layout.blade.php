<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Office Supplies Inventory' }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#FCE7F3; margin:0; padding:0;">

    <header style="background-color:#BE185D; color:white; padding:20px; text-align:center;">
        <h1>Office Supplies Inventory</h1>
    </header>

    <main style="max-width:1100px; margin:auto; padding:20px;">
        {{ $slot }}
    </main>
</body>
</html>
