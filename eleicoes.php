<?php

/**
 * Referências:
 * https://www.w3schools.com/php/php_mysql_select.asp
 * https://stackoverflow.com/questions/28225931/how-to-get-single-value-from-mysql-query-in-php
 * https://www.w3schools.com/php/php_mysql_select_orderby.asp
 * https://www.w3schools.com/php/php_echo_print.asp
 */

include "sql.php";

/// dados dos vereadores do banco de dados
$vereadores = $db_connection->query("SELECT * FROM Vereador ORDER BY votos DESC, nome ASC;");
/// dados dos prefeitos do banco de dados
$prefeitos = $db_connection->query("SELECT * FROM Prefeito ORDER BY votos DESC, nome ASC;");
/// dados dos prefeitos do banco de dados
$vices = $db_connection->query("SELECT * FROM Vice ORDER BY nome ASC;");

/// array booleano indicando se houve empate na eleição
$empate = [false, false];
/// número de votos obtido pelo candidato vencedor
$maior_voto_vereador = 0;
/// array contendo o(s) vencedor(es) da eleição para vereador
$vereadores_vencedor = [];
/// número de votos obtido pelo candidato vencedor
$maior_voto_prefeito = 0;
/// array contendo o(s) vencedor(es) da eleição para prefeito
$prefeitos_vencedor = [];

print_header();
print_table_head_vereadores();
print_table_vereadores($vereadores, $empate, $maior_voto_vereador, $vereadores_vencedor);
print_vencedor_vereador($empate, $vereadores_vencedor, $maior_voto_vereador);
print_table_head_prefeitos();
print_table_prefeitos($prefeitos, $empate, $maior_voto_prefeito, $prefeitos_vencedor, $db_connection);
print_vencedor_prefeito($empate, $prefeitos_vencedor, $maior_voto_prefeito);

/**
 * Imprime o header da página de resultados
 */
function print_header(){
    echo "
    <header>
    <div class='container'>
    <div id='branding'>
        <h1>Resultado das Eleições</h1>
    </div>
    </div>
    </header>";
}

/**
 * Imprime o header (título e nome das colunas) da tabela de vereadores
 */
function print_table_head_vereadores(){
    echo "
    <section id='showcase'>
            <div class='container'>
                <table id='tabela-vereador'>
                    <h2>Candidatos a Vereador</h2>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Partido</th>
                                <th>Numeros</th>
                                <th>Votos</th>
                            </tr>
                        </thead>
                        <tbody>";
}

/**
 * Imprime os dados da tabela de vereadores. Insere os votos computados na tabela.
 * Descobre que é (são) os candidatos que receberam mais votos.
 * 
 * @param[vereadores] dados da tabela dos vereadores
 * @param[empate] array booleano; indica se houve empate na eleição
 * @param[maior_voto_vereador] quantidade de votos que o vencedor obteve
 * @param[vereadores_vencedor] array contendo o(s) vencedor(es)
 */
function print_table_vereadores($vereadores, &$empate, &$maior_voto_vereador, &$vereadores_vencedor){
    foreach($vereadores as $v){
        if($v["votos"] > $maior_voto_vereador) {
            $empate[0] = false;
            $maior_voto_vereador = $v["votos"];
            $vereadores_vencedor = [];
            array_push($vereadores_vencedor, $v["nome"]);
        }
        else if($v["votos"] == $maior_voto_vereador) {
            array_push($vereadores_vencedor, $v["nome"]);
            $empate[0] = true;
        }

        echo "
        <tr>
            <td>".$v["nome"]."</td>
            <td>".$v["partido"]."</td>
            <td>".$v["numeros"]."</td>
            <td class='votos'>".$v["votos"]."</td>
        </tr>
        ";
    }

    // fecha tabela de vereadores
    echo "
    </tbody>
    </table>
    </div>";
}

/**
 * Imprime o nome do(s) vencedor(es) da eleição para vereador.
 * No caso de empate, todos os candidatos que conseguiram o maior número de 
 * votos são considerados vencedores.
 * 
 * @param[empate] array booleano; indica se houve empate na eleição
 * @param[vereadores_vencedor] array contendo o(s) vencedor(es)
 * @param[maior_voto_vereador] quantidade de votos que o vencedor obteve
 */
function print_vencedor_vereador($empate, $vereadores_vencedor, $maior_voto_vereador){
    if($maior_voto_vereador > 0){
        if($empate[0] == false){
            echo "
            <div class='resultado'>
                <div>Vencedor(a)</div>";
            
            echo $vereadores_vencedor[0];
            
            echo "</div>";
        }
        else{
            echo "
            <div class='resultado'>
                <div>Vencedores(as)</div>";
            
            foreach($vereadores_vencedor as $v) {
                if(!next($vereadores_vencedor)){
                    echo $v.". \n";
                }
                else
                    echo $v.", \n";
            }
                
            echo "</div>";
        }
    }
}

/**
 * Imprime o header (título e nome das colunas) da tabela de prefeitos
 */
function print_table_head_prefeitos(){
    echo "
    <div class='container'>
        <table id='tabela-vereador'>
            <h2>Candidatos a Prefeito</h2>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Vice</th>
                        <th>Partido</th>
                        <th>Numeros</th>
                        <th>Votos</th>
                    </tr>
                </thead>
                <tbody>";
}

/**
 * Imprime os dados da tabela de prefeitos. Insere os votos computados na tabela.
 * Descobre que é (são) os candidatos que receberam mais votos.
 * 
 * @param[prefeitos] dados da tabela dos prefeitos
 * @param[empate] array booleano; indica se houve empate na eleição
 * @param[maior_voto_prefeito] quantidade de votos que o vencedor obteve
 * @param[prefeitos_vencedor] array contendo o(s) vencedor(es)
 * @param[db_connection] conexão para o servidor mysql
 */
function print_table_prefeitos($prefeitos, &$empate, &$maior_voto_prefeito, &$prefeitos_vencedor, $db_connection){
    foreach($prefeitos as $p){
        if($p["votos"] > $maior_voto_prefeito) {
            $empate[1] = false;
            $maior_voto_prefeito = $p["votos"];
            $prefeitos_vencedor = [];
            array_push($prefeitos_vencedor, $p["nome"]);
        }
        else if($p["votos"] == $maior_voto_prefeito) {
            $empate[1] = true;
            array_push($prefeitos_vencedor, $p["nome"]);
        }

        $vice = $db_connection->query("SELECT * FROM Vice WHERE numeros = ".$p["numeros"].";");
        $v = $vice->fetch_array();
        echo "
        <tr>
            <td>".$p["nome"]."</td>
            <td>".$v["nome"]."</td>
            <td>".$p["partido"]."</td>
            <td>".$p["numeros"]."</td>
            <td class='votos'>".$p["votos"]."</td>
        </tr>
        ";
    }

    // fecha tabela de prefeitos
    echo "
    </tbody>
    </table>
    </div>";
}

/**
 * Imprime o nome do(s) vencedor(es) da eleição para prefeito. 
 * No caso de empate, todos os candidatos que conseguiram o maior número de 
 * votos são considerados vencedores.
 * 
 * @param[empate] array booleano; indica se houve empate na eleição
 * @param[prefeitos_vencedor] array contendo o(s) vencedor(es)
 * @param[maior_voto_prefeito] quantidade de votos que o vencedor obteve
 */
function print_vencedor_prefeito($empate, $prefeitos_vencedor, $maior_voto_prefeito){
    if($maior_voto_prefeito > 0){
        if($empate[1] == false){
            echo "
            <div class='resultado'>
                <div>Vencedor(a)</div>";
            
            echo $prefeitos_vencedor[0];
            
            echo "</div>";
        }
        else{
            echo "
            <div class='resultado'>
                <div>Vencedores(as)</div>";
            
            foreach($prefeitos_vencedor as $p){
                if(!next($prefeitos_vencedor)){
                    echo $p.". \n";
                }
                else
                    echo $p.", \n";
            }
            echo "</div>";
        }
    }
}

?>

<style>

body{
    font: 15px/1.5 Arial, Helvetica,sans-serif;
    padding:0;
    margin:0;
    background-color:#f4f4f4;
}

.container{
    width:80%;
    margin:auto;
    overflow:hidden;
    text-align: center;
}

#tabela-vereador, #tabela-prefeito{
    width: 30%;
    margin:auto;
    margin-bottom: 20px;
}

#tabela-vereador td, #tabela-vereador th,
#tabela-prefeito td, #tabela-prefeito th {
    border: 1px solid #000;
    padding: 8px;
    text-align: center;
}

.resultado {
    width: 10%;
    margin: auto;
    text-align: center;
    font-size: large;
}

.resultado div {
    border: #000 1px solid;
}
</style>
