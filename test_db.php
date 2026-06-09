<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=aians_local', 'root', '');
    echo 'Connected OK';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
