<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AES Encryption/Decryption</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Show success message as a popup
        function showMessage(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</head>

<body onload="showMessage('<?php echo isset($_GET['message']) ? $_GET['message'] : ''; ?>')">
    <div class="container mt-5">
        <h1 class="text-center">File Encryption & Decryption (AES-128)</h1>
        <form action="proses.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="file" class="form-label">Upload File</label>
                <input type="file" class="form-control" id="file" name="file" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="action" value="encrypt" class="btn btn-primary">Encrypt</button>
            <button type="submit" name="action" value="decrypt" class="btn btn-success">Decrypt</button>
        </form>
        <hr>
        <a href="files.php" class="btn btn-info">View Encrypted/Decrypted Files</a>
    </div>
</body>

</html>