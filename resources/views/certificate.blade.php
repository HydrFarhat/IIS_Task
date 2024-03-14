<!DOCTYPE html>
<html>
<head>
    <title>Certificates Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h1>Certificates Report</h1>
@foreach($certificates as $certificate)
    <h2>{{ $certificate?->name }}</h2>
    <p>User Count: {{ $certificate?->users_count }}</p>
    <hr>
@endforeach
</body>
</html>
