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
<table>

    <tbody>
{{--    @foreach($certificates as $certificate)--}}
{{--        <tr>--}}
{{--            <td>{{ $certificate->name }}</td>--}}
{{--            <td>{{ $certificate->users_count }}</td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
    </tbody>
</table>

<button id="exportButton">Export</button>

<script>
    document.getElementById('exportButton').addEventListener('click', function() {
        var token = '6|oPGe75op75fjI8X36HWxPJwSAVbwzvU5giFSaKa31561d108'; // Replace with the actual admin token

        var headers = new Headers();
        headers.append('Authorization', 'Bearer ' + token);

        fetch('/api/certificates/export', {
            method: 'GET',
            headers: headers
        })
            .then(function(response) {
                // Check if the response was successful
                if (response.ok) {
                    // Create a blob from the response content
                    return response.blob();
                } else {
                    throw new Error('Export failed');
                }
            })
            .then(function(blob) {
                // Create a download link for the blob
                var downloadLink = document.createElement('a');
                downloadLink.href = URL.createObjectURL(blob);
                downloadLink.download = 'certificates.pdf';

                // Trigger the click event to start the download
                downloadLink.click();

                // Clean up the temporary URL object
                URL.revokeObjectURL(downloadLink.href);
            })
            .catch(function(error) {
                // Handle any error that occurs during the request
                console.log(error);
            });
    });
</script>
</body>
</html>
