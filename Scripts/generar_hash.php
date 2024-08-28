<?php
$contrasena1 = 'admin';  // Contraseña de "admin"
$contrasena2 = '123';    // Contraseña de "SOTO"
$contrasena3 = '123';    // Contraseña de "yael"

// Generar hashes
$hash1 = password_hash($contrasena1, PASSWORD_BCRYPT);
$hash2 = password_hash($contrasena2, PASSWORD_BCRYPT);
$hash3 = password_hash($contrasena3, PASSWORD_BCRYPT);

// Imprimir los hashes
echo "Hash para admin: " . $hash1 . "<br>";
echo "Hash para SOTO: " . $hash2 . "<br>";
echo "Hash para yael: " . $hash3 . "<br>";
?>
