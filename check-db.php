<?php
// Script sederhana untuk cek database MySQL
$host = '127.0.0.1';
$db = 'rpl';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Koneksi database berhasil!\n\n";
    
    // Cek semua tabel
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "=== DAFTAR TABEL ===\n";
    foreach ($tables as $table) {
        echo "- $table\n";
    }
    echo "\n";
    
    // Cek struktur tabel penting
    $importantTables = ['categories', 'menus', 'tables', 'orders', 'order_details'];
    
    foreach ($importantTables as $tableName) {
        if (in_array($tableName, $tables)) {
            echo "\n=== STRUKTUR TABEL: $tableName ===\n";
            $columns = $pdo->query("DESCRIBE $tableName")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($columns as $col) {
                echo "  {$col['Field']} ({$col['Type']}) {$col['Null']} {$col['Key']} {$col['Extra']}\n";
            }
            
            // Cek jumlah data
            $count = $pdo->query("SELECT COUNT(*) FROM $tableName")->fetchColumn();
            echo "  → Total data: $count baris\n";
            
            // Tampilkan sample data jika ada
            if ($count > 0 && $count <= 5) {
                echo "  → Sample data:\n";
                $samples = $pdo->query("SELECT * FROM $tableName LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($samples as $row) {
                    echo "    " . json_encode($row, JSON_UNESCAPED_UNICODE) . "\n";
                }
            }
        } else {
            echo "\n✗ Tabel '$tableName' TIDAK DITEMUKAN!\n";
        }
    }
    
} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
