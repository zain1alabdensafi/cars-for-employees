<!DOCTYPE html>
<html>
<head>
    <title>Add Car</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #4CAF50;
        }
        .container {
            display: flex;
            justify-content: space-between;
        }
        .form-container, .table-container {
            width: 48%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <h1>Add Car for Employee</h1>
    @if(isset($employees) && count($employees) > 0)
        <div class="container">
            <div class="form-container">
                <form action="{{ route('add_car') }}" method="POST">
                    @csrf
                    <label for="type">Car Type:</label>
                    <input type="text" id="type" name="type" required><br><br>

                    <label for="license_plate">License Plate:</label>
                    <input type="text" id="license_plate" name="license_plate" required><br><br>

                    <label for="employee_id">Employee:</label>
                    <select id="employee_id" name="employee_id" required>
                        @foreach($employees as $employee)
                            <option value="{{ $employee['id'] }}">{{ $employee['first_name'] ?? 'No Name' }}</option>
                        @endforeach
                    </select><br><br>
                    <button type="submit">Add Car</button>
                </form>
            </div>
            
            <div class="table-container">
                <h2>Employee List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee['id'] }}</td>
                                <td>{{ $employee['first_name'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p>No employees found.</p>
    @endif

    @if ($errors->any())
        <h2 class="error">
            @foreach ($errors->all() as $error)
                <span>{{ is_array($error) ? implode(', ', $error) : $error }}</span>
            @endforeach
        </h2>
    @endif

    @if (session('success'))
        <h2 class="success">
            {{ session('success') }}
        </h2>
    @endif
</body>
</html>
