<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTables Implementation</title>
    @vite(['resources/js/app.js', 'resources/js/datatables.js'])
</head>
<body>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">DataTables Implementation</h1>
        
        <!-- Example DataTable -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Employee DataTable</h2>
            <table class="data-table w-full">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>john@example.com</td>
                        <td>Engineering</td>
                        <td>
                            <button class="btn btn-primary">Edit</button>
                            <button class="btn btn-secondary">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>jane@example.com</td>
                        <td>Marketing</td>
                        <td>
                            <button class="btn btn-primary">Edit</button>
                            <button class="btn btn-secondary">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Additional DataTables can be added here -->
    </div>
</body>
</html>
