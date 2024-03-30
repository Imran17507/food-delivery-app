<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Food Delivery App</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            color: #333;
        }

        header {
            background-color: #4285f4;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        .api-endpoints {
            margin: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .api-endpoints ul {
            list-style-type: none;
            padding: 0;
        }

        .api-endpoints li {
            background-color: #e8f0fe;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 4px;
            font-weight: bold;
            color: #333;
        }

        .api-endpoints li:last-child {
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <header>
        <h1>Hello Brainstation23!</h1>
    </header>
    <section class="api-endpoints">
        <ul>
            <li>/api//rider/location-history - Store Rider Location History [POST]</li>
            <li>/api/restaurant/nearest-rider - Find Nearest Rider [POST]</li>
        </ul>
    </section>
</body>

</html>
