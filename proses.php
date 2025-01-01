<?php
// Database credentials
$host = 'localhost';
$dbname = 'files';
$username = 'root';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $password = $_POST['password'];

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileContent = file_get_contents($fileTmpPath);

        $method = 'AES-128-CBC';
        $key = hash('sha256', $password, true);
        $iv = substr($key, 0, 16); // Use the first 16 bytes of the key as IV

        if ($action === 'encrypt') {
            $encryptedData = openssl_encrypt($fileContent, $method, $key, OPENSSL_RAW_DATA, $iv);
            $outputFileName = 'encrypted_' . $fileName;

            // Save to database
            $stmt = $pdo->prepare("INSERT INTO files (file_name, encrypted_file_name, password_hash, action) VALUES (?, ?, ?, ?)");
            $stmt->execute([$fileName, $outputFileName, password_hash($password, PASSWORD_BCRYPT), 'encrypt']);

            // Output the file
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $outputFileName);
            echo $encryptedData;
        } elseif ($action === 'decrypt') {
            $decryptedData = openssl_decrypt($fileContent, $method, $key, OPENSSL_RAW_DATA, $iv);
            $outputFileName = 'decrypted_' . $fileName;

            // Save to database
            $stmt = $pdo->prepare("INSERT INTO files (file_name, encrypted_file_name, password_hash, action) VALUES (?, ?, ?, ?)");
            $stmt->execute([$fileName, $outputFileName, password_hash($password, PASSWORD_BCRYPT), 'decrypt']);

            // Output the file
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $outputFileName);
            echo $decryptedData;
        }
    } else {
        echo "Error uploading file!";
    }
} else {
    echo "Invalid request!";
}
