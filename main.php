<?php

/**
 * Referências:
 * https://www.geeksforgeeks.org/how-to-receive-json-post-with-php/
 * https://www.w3schools.com/php/php_mysql_insert_multiple.asp
 */

include "sql.php";

/// json dos votos enviados ao servidor
$json = file_get_contents('php://input');
/// dados dos votos decodificados
$data = json_decode($json);

/// string de queries para o servidor mysql
$sql = "";

foreach($data as $d) {
    $sql .= "UPDATE ".$d->etapa." SET votos = votos + 1 WHERE numeros = ".$d->numero.";";
}

if ($db_connection->multi_query($sql) === TRUE) {
    echo "New records created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $db_connection->error;
}

?>
