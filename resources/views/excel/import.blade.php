<!DOCTYPE html>
<html>
<head>
    <title>Import Users</title>
</head>
<body>
    <form action="{{ url('users/import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Import</button>
    </form>
</body>
</html>
