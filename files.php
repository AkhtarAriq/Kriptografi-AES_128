<?php
// Database connection
$host = 'localhost';
$dbname = 'files';
$username = 'root';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch files from the database
$stmt = $pdo->query("SELECT id, file_name, encrypted_file_name, action, created_at FROM files ORDER BY created_at DESC");
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Processed Files</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Original File</th>
                    <th>Processed File</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($files as $file): ?>
                    <tr>
                        <td><?= $file['id'] ?></td>
                        <td><?= $file['file_name'] ?></td>
                        <td><?= $file['encrypted_file_name'] ?></td>
                        <td><?= ucfirst($file['action']) ?></td>
                        <td><?= $file['created_at'] ?></td>
                        <td><a href="download.php?file=<?= urlencode($file['encrypted_file_name']) ?>" class="btn btn-primary btn-sm">Download</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </div>
</body>
</html>
