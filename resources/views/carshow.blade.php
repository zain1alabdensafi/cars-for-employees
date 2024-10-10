<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Car</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #77aaff 3px solid;
        }
        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        header ul {
            padding: 0;
            list-style: none;
        }
        header li {
            float: right;
            display: inline;
            padding: 0 20px 0 20px;
        }
        .car-info {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .car-info h2 {
            margin-top: 0;
        }
        .employee-info {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>View Car</h1>
            <ul>
                <li><a href="#">Home</a></li>
            </ul>
        </div>
    </header>
    <div class="container">
        <div class="car-info">
            <h2>Car information</h2>
            <p>Car Name: {{ $car->type }}</p>
            <p>Car license plate: {{ $car->license_plate }}</p>
        </div>
        <div class="employee-info">
            <h2>Employee information</h2>
            <p>Employee Name: {{ $employee->first_name }}</p>
            
        </div>
    </div>
</body>
</html>
