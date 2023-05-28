# Simulador de Eleições

![Graph Example](https://github.com/cadu1979/Simulador-de-Eleicoes/blob/main/screenshot.jpg?raw=true)

Instruções <br/>

Primeiramente deve-se criar um servidor apache para que seja possível utilizar a aplicação. Todos os arquivos devem ser extraídos no servidor.
Após esse passo, deve-se criar um banco de dados MySQL, e nele executar o arquivo 'db.sql'.

Esse projeto foi feito considerando um banco de dados de nome 'urna', o que pode ser modificado na pela variável '$dbName' no arquivo 'sql.php'. Também nesse arquivo podem ser modificados o nome do servidor ($servername), o nome do usuário que pode acessar o servidor ($username), e a senha do usuário ($password).

<hr>

A urna pode ser acessada pela página 'index.html' no diretório raiz.
Se o usuário desejar conferir os resultados das eleições, ele deve acessar 'eleicoes.php'.
Se as configurações default da aplicação não forem modificadas, então os endereços de acesso às páginas acima são, respectivamente:

localhost/index.html

localhost/eleicoes.php

<hr>

A documentação doxygen dos arquivos php estão na pasta 'doxygen', a documentação jsdoc dos arquivos javascript estão na pasta 'js', nas pastas 'util jsdoc' e 'script jsdoc'.

Todo o código foi testado utilizando XAMPP.
