<div>
    <p align="center">
        <img width="150em"
             src="https://guiandrade.com.br/fotosgithub/logo-pet-love-modelo.png" 
             alt="Pet Love">
    </p>
</div>

<br>

<div>
    <p>Este repositório armazena os arquivos do código fonte da 
API da solução <b>PET LOVE</b>. </p>
</div>

<div>
    <h3>🎈 O Projeto</h3>
<hr>
    <p>A solução <b>PET LOVE</b> oferece ao cliente um aplicativo
mobile onde ele poderá armazenar todos os dados de consultas, 
vacinação e resultados de exames do seu pet. Neste aplicativo, 
o cliente também poderá procurar serviços através de pesquisa 
manual ou localização do dispositivo. Já as empresas que se 
associarem à solução poderão manter seus serviços e agendas em
nossa plataforma.</p>
<p>Para oferecer este serviço, o projeto se dividirá em algumas 
partes. Teremos uma API que será responsável por prover os 
dados que serão consumidos na aplicação, além de aplicar toda a
lógica para as transações de dados.</p>
<p>Será desenvolvida uma página web totalmente destinada às 
empresas associadas onde elas poderão gerenciar seus serviços 
e agendas e ficarão responsáveis por marcar consultas caso 
desejem.</p>
<p>Teremos um aplicativo mobile que será totalmente destinado 
aos clientes onde eles poderão cadastrar as vacinações, 
consultas e exames dos seus pets. Estes registros ficarão
salvos no telefone e, com isso, o dono do pet terá sempre um
resumo com as principais informações do seu companheiro para
apresentar ao médico veterinário.</p>
<p>Será desenvolvida também uma landing page estática de 
apresentação do produto.</p>
</div>

<div>
    <h3>🧱 Requisitos da API</h3>
    <hr>
    <table>
        <tr>
            <th colspan="2">RF01 - Manter Usuários</th>
        </tr>
        <tr>
            <td>RF0101</td>
            <td>Cadastrar Usuário</td>
        </tr>
        <tr>
            <td>RF0102</td>
            <td>Atualizar Usuário</td>
        </tr>
        <tr>
            <td>RF0103</td>
            <td>Listar Usuários</td>
        </tr>
        <tr>
            <td>RF0104</td>
            <td>Excluir Usuário</td>
        </tr>
        <tr>
            <td>RF0105</td>
            <td>Manter tabela de apoio para os tipos de usuários</td>
        </tr>
        <tr>
            <th colspan="2">RF02 - Manter Animais</th>
        </tr>
        <tr>
            <td>RF0201</td>
            <td>Cadastrar animal</td>
        </tr>
        <tr>
            <td>RF0202</td>
            <td>Atualizar animal</td>
        </tr>
        <tr>
            <td>RF0203</td>
            <td>Listar animais por dono</td>
        </tr>
        <tr>
            <td>RF0204</td>
            <td>Excluir animal</td>
        </tr>
        <tr>
            <td>RF0205</td>
            <td>Manter tabela de apoio para os tipos de animais</td>
        </tr>
        <tr>
            <td>RF0206</td>
            <td>Manter tabela de apoio para a raça de animais</td>
        </tr>
        <tr>
            <td>RF0207</td>
            <td>Manter tabela de apoio para o comportamento de animais</td>
        </tr>
        <tr>
            <th colspan="2">RF03 - Agendamento</th>
        </tr>
        <tr>
            <td>RF0301</td>
            <td>Cadastrar agenda</td>
        </tr>
        <tr>
            <td>RF0302</td>
            <td>Atualizar agenda</td>
        </tr>
        <tr>
            <td>RF0303</td>
            <td>Listar agendas por usuário (empresa)</td>
        </tr>
        <tr>
            <td>RF0304</td>
            <td>Excluir agenda</td>
        </tr>
        <tr>
            <td>RF0305</td>
            <td>Manter tabela de bloqueio para agendas</td>
        </tr>
        <tr>
            <td>RF0306</td>
            <td>Manter tabela de itens (consultas) para cada agenda</td>
        </tr>
        <tr>
            <th colspan="2">RF04 - Vacinação</th>
        </tr>
        <tr>
            <td>RF0401</td>
            <td>Cadastrar vacinação</td>
        </tr>
        <tr>
            <td>RF0402</td>
            <td>Atualizar vacinação</td>
        </tr>
        <tr>
            <td>RF0403</td>
            <td>Listar vacinações por animais de usuários</td>
        </tr>
        <tr>
            <td>RF0404</td>
            <td>Excluir vacinação</td>
        </tr>
        <tr>
            <td>RF0405</td>
            <td>Manter tabela de apoio para cadastrar as vacinas</td>
        </tr>
        <tr>
            <th colspan="2">RF05 - Exames</th>
        </tr>
        <tr>
            <td>RF0501</td>
            <td>Cadastrar exames</td>
        </tr>
        <tr>
            <td>RF0502</td>
            <td>Editar exames</td>
        </tr>
        <tr>
            <td>RF0503</td>
            <td>Listar exames por animais de usuários</td>
        </tr>
        <tr>
            <td>RF0504</td>
            <td>Excluir exames</td>
        </tr>
        <tr>
            <th colspan="2">RF06 - Consultas</th>
        </tr>
        <tr>
            <td>RF0601</td>
            <td>Cadastrar consultas</td>
        </tr>
        <tr>
            <td>RF0602</td>
            <td>Editar consultas</td>
        </tr>
        <tr>
            <td>RF0603</td>
            <td>Listar consultas por animais de usuários</td>
        </tr>
        <tr>
            <td>RF0604</td>
            <td>Excluir consultas</td>
        </tr>
        <tr>
            <th colspan="2">RF07 - Sistema</th>
        </tr>
        <tr>
            <td>RF0701</td>
            <td>Cliente deve poder manter seus pets</td>
        </tr>
        <tr>
            <td>RF0702</td>
            <td>Cliente deve poder gerenciar a vacinação dos seus pets</td>
        </tr>
        <tr>
            <td>RF0703</td>
            <td>Cliente deve poder gerenciar os exames dos seus pets</td>
        </tr>
        <tr>
            <td>RF0704</td>
            <td>Cliente deve poder gerenciar as consultas dos seus pets</td>
        </tr>
        <tr>
            <td>RF0705</td>
            <td>Cliente deve poder procurar serviços para os seus pets</td>
        </tr>
        <tr>
            <td>RF0706</td>
            <td>Cliente deve poder avaliar empresas das quais utilizaram algum serviço</td>
        </tr>
        <tr>
            <td>RF0707</td>
            <td>Empresa deve poder gerenciar suas agendas</td>
        </tr>
        <tr>
            <th colspan="2">Requisitos não funcionais</th>
        </tr>
        <tr>
            <td>RNF01</td>
            <td>API deve suportar autenticação JWT</td>
        </tr>
        <tr>
            <td>RNF02</td>
            <td>Deve haver responsividade em todo o layout da aplicação</td>
        </tr>
        <tr>
            <td>RNF03</td>
            <td>Sistema deve poder enviar avisos aos clientes informando sobre serviços como vacinação</td>
        </tr>
    </table>
</div>

<div>
    <h3>💽 Banco de Dados</h3>
    <hr>
    <p>Como ferramenta de banco de dados nesta solução utilizarei 
o <strong>MySQL</strong>. Para escolher esta ferramenta, foi
levado em consideração o fato que a faculdade trabalhou com ela
nas disciplinas de banco de dados.</p>
    <br>
    <h5>Modelo Lógico</h5>
    <hr>
    <p align="center">
        <img src="https://guiandrade.com.br/fotosgithub/modelo-logico.png" 
             alt="Modelo Lógico">
    </p>
    <br>
    <h5>Código SQL</h5>
    <hr>
</div>
```sql
    codigo SQL
```