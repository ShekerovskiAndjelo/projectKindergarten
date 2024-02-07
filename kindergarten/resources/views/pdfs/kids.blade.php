<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kids Information</title>
    <style>
        /* Define your CSS styles here */
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #333;
        }
        /* Add more styles as needed */
    </style>
</head>
<body>
    <h1>Kids Information</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kids as $kid)
            <tr>
                <td>{{ $kid->name }}</td>
                <td>{{ $kid->age }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
