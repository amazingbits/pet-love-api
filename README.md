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

<br>
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

<br>
<div>
    <h3>💎 Tecnologias</h3>
    <hr>
    <h5>Prototipação</h5>
    <div>
        <img src="https://img.shields.io/badge/figma-%23F24E1E.svg?style=for-the-badge&logo=figma&logoColor=white" alt="Figma">
        <img src="https://img.shields.io/badge/adobephotoshop-%2331A8FF.svg?style=for-the-badge&logo=adobephotoshop&logoColor=white" alt="Photoshop">
    </div>
    <h5>API</h5>
    <div>
        <img src="https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
        <img src="https://img.shields.io/badge/Insomnia-black?style=for-the-badge&logo=insomnia&logoColor=5849BE" alt="Insomnia">
        <img src="https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
        <img src="https://img.shields.io/badge/apache-%23D42029.svg?style=for-the-badge&logo=apache&logoColor=white" alt="Apache">
        <img src="https://img.shields.io/badge/phpstorm-143?style=for-the-badge&logo=phpstorm&logoColor=black&color=black&labelColor=darkorchid" alt="PHP Storm">
    </div>    
    
</div>

<br>
<div>
    <h3>🧱 Requisitos funcionais e não funcionais</h3>
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

<br>
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
drop database if exists db_petlove;
create database if not exists db_petlove;
use db_petlove;

create table if not exists tipo_usuario(
                                           id int not null auto_increment primary key,
                                           descricao text not null,
                                           criado_em datetime not null default now(),
    ativo boolean not null default true
    );

insert into tipo_usuario (descricao) values ("Cliente");
insert into tipo_usuario (descricao) values ("Empresa");

create table if not exists tipo_animal(
                                          id int not null auto_increment primary key,
                                          descricao text not null,
                                          criado_em datetime not null default now(),
    ativo boolean not null default true
    );

insert into tipo_animal (descricao) values ("Cachorro");

create table if not exists usuario(
                                      id int not null auto_increment primary key,
                                      login text not null,
                                      senha text not null,
                                      nome text not null,
                                      email text not null,
                                      telefone text not null,
                                      path_url text,
                                      nota float not null default 0,
                                      tipo_usuario int not null,
                                      criado_em datetime not null default now(),
    ativo boolean not null default true,
    constraint fk_usuario_tipo_usuario
    foreign key (tipo_usuario) references tipo_usuario (id)
    );

create table if not exists animal_comportamento(
                                                   id int not null auto_increment primary key,
                                                   descricao text not null,
                                                   criado_em datetime not null default now(),
    ativo boolean not null default true
    );

insert into animal_comportamento (descricao) values ("Dócil");
insert into animal_comportamento (descricao) values ("Companheiro");
insert into animal_comportamento (descricao) values ("Agitado");
insert into animal_comportamento (descricao) values ("Bravo");

create table animal_raca(
                            id int not null auto_increment primary key,
                            descricao text not null,
                            tipo_animal int not null,
                            ativo boolean not null default true,
                            criado_em datetime not null default now(),
                            constraint fk_raca_tipo_animal
                                foreign key (tipo_animal) references tipo_animal (id)
);

insert into animal_raca (descricao, tipo_animal) values ("Akita", 1);
insert into animal_raca (descricao, tipo_animal) values ("Basset Hound", 1);
insert into animal_raca (descricao, tipo_animal) values ("Beagle", 1);
insert into animal_raca (descricao, tipo_animal) values ("Bichon Frisé", 1);
insert into animal_raca (descricao, tipo_animal) values ("Boiadeiro Australiano", 1);
insert into animal_raca (descricao, tipo_animal) values ("Border Collie", 1);
insert into animal_raca (descricao, tipo_animal) values ("Boston Terrier", 1);
insert into animal_raca (descricao, tipo_animal) values ("Boxer", 1);
insert into animal_raca (descricao, tipo_animal) values ("Buldogue Francês", 1);
insert into animal_raca (descricao, tipo_animal) values ("Buldogue Inglês", 1);
insert into animal_raca (descricao, tipo_animal) values ("Bull Terrier", 1);
insert into animal_raca (descricao, tipo_animal) values ("Cane Corso", 1);
insert into animal_raca (descricao, tipo_animal) values ("Cavalier King Charles Spaniel", 1);
insert into animal_raca (descricao, tipo_animal) values ("Chihuahua", 1);
insert into animal_raca (descricao, tipo_animal) values ("Chow Chow", 1);
insert into animal_raca (descricao, tipo_animal) values ("Cocker Spaniel Inglês", 1);
insert into animal_raca (descricao, tipo_animal) values ("Dachshund", 1);
insert into animal_raca (descricao, tipo_animal) values ("Dálmata", 1);
insert into animal_raca (descricao, tipo_animal) values ("Doberman", 1);
insert into animal_raca (descricao, tipo_animal) values ("Dogo Argentino", 1);
insert into animal_raca (descricao, tipo_animal) values ("Dogue Alemão", 1);
insert into animal_raca (descricao, tipo_animal) values ("Fila Brasileiro", 1);
insert into animal_raca (descricao, tipo_animal) values ("Golden Retriever", 1);
insert into animal_raca (descricao, tipo_animal) values ("Husky Siberiano", 1);
insert into animal_raca (descricao, tipo_animal) values ("Jack Russell", 1);
insert into animal_raca (descricao, tipo_animal) values ("Labrador Retriever", 1);
insert into animal_raca (descricao, tipo_animal) values ("Lhasa Apso", 1);
insert into animal_raca (descricao, tipo_animal) values ("Lulu da Pomerânia", 1);
insert into animal_raca (descricao, tipo_animal) values ("Maltês", 1);
insert into animal_raca (descricao, tipo_animal) values ("Mastiff Inglês", 1);
insert into animal_raca (descricao, tipo_animal) values ("Mastim Tibetano", 1);
insert into animal_raca (descricao, tipo_animal) values ("Pastor Alemão", 1);
insert into animal_raca (descricao, tipo_animal) values ("Pastor Australiano", 1);
insert into animal_raca (descricao, tipo_animal) values ("Pastor de Shetland", 1);
insert into animal_raca (descricao, tipo_animal) values ("Pequinês", 1);
insert into animal_raca (descricao, tipo_animal) values ("Pinscher", 1);
insert into animal_raca (descricao, tipo_animal) values ("Pit Bull", 1);
insert into animal_raca (descricao, tipo_animal) values ("Poodle", 1);
insert into animal_raca (descricao, tipo_animal) values ("Pug", 1);
insert into animal_raca (descricao, tipo_animal) values ("Rottweiler", 1);
insert into animal_raca (descricao, tipo_animal) values ("Schnauzer", 1);
insert into animal_raca (descricao, tipo_animal) values ("Shar-pei", 1);
insert into animal_raca (descricao, tipo_animal) values ("Shiba", 1);
insert into animal_raca (descricao, tipo_animal) values ("Shih Tzu", 1);
insert into animal_raca (descricao, tipo_animal) values ("Staffordshire Bull Terrier", 1);
insert into animal_raca (descricao, tipo_animal) values ("Weimaraner", 1);
insert into animal_raca (descricao, tipo_animal) values ("Yorkshire", 1);
insert into animal_raca (descricao, tipo_animal) values ("Vira-lata", 1);

create table if not exists animal(
                                     id int not null auto_increment primary key,
                                     sexo enum("Macho", "Fêmea") not null,
    nome text not null,
    nascimento date not null,
    castrado boolean not null default true,
    animal_raca int not null,
    animal_comportamento int not null,
    tipo_animal int not null,
    dono int not null,
    criado_em datetime not null default now(),
    ativo boolean not null default true,
    constraint fk_animal_raca
    foreign key (animal_raca) references animal_raca (id),
    constraint fk_animal_comportamento
    foreign key (animal_comportamento) references animal_comportamento (id),
    constraint fk_tipo_animal
    foreign key (tipo_animal) references tipo_animal (id),
    constraint fk_animal_dono
    foreign key (dono) references usuario (id)
    );

create table if not exists endereco(
                                       id int not null auto_increment primary key,
                                       cep text,
                                       rua text,
                                       numero text,
                                       complemento text,
                                       cidade text,
                                       estado text,
                                       latitude text,
                                       longitude text,
                                       usuario int not null,
                                       constraint fk_endereco_usuario
                                       foreign key (usuario) references usuario (id)
    );

create table if not exists agenda(
                                     id int not null auto_increment primary key,
                                     descricao text not null,
                                     dia_semana int not null,
                                     dia_semana_ext text not null,
                                     hora_inicio time not null,
                                     hora_fim time not null,
                                     intervalo_atendimento int not null,
                                     preco numeric(8,2) not null,
    criado_em datetime not null default now(),
    ativo boolean not null default true,
    usuario int not null,
    constraint fk_agenda_usuario
    foreign key (usuario) references usuario (id)
    );

create table if not exists agenda_item(
                                          id int not null auto_increment primary key,
                                          agenda int not null,
                                          animal int not null,
                                          data date not null,
                                          hora time not null,
                                          status enum("Marcada", "Confirmada", "Cancelada"),
    constraint fk_ai_agenda
    foreign key (agenda) references agenda (id),
    constraint fk_agenda_item_animal
    foreign key (animal) references animal (id)
    );

create table if not exists bloqueio(
                                       id int not null auto_increment primary key,
                                       descricao text not null,
                                       agenda int not null,
                                       data_inicial date not null,
                                       data_final date not null,
                                       constraint fk_bloqueio_agenda
                                       foreign key (agenda) references agenda (id)
    );

create table if not exists vacina(
                                     id int not null auto_increment primary key,
                                     descricao varchar(255) not null unique,
    duracao_dias int not null,
    ativo boolean not null default true,
    criado_em datetime not null default now(),
    tipo int not null,
    constraint vacina_animal_tipo
    foreign key (tipo) references tipo_animal (id)
    );

insert into vacina (descricao, duracao_dias, tipo) values ("Antirrábica (cachorros)", 365, 1);
insert into vacina (descricao, duracao_dias, tipo) values ("Polivalente (V8 e V10)", 365, 1);
insert into vacina (descricao, duracao_dias, tipo) values ("Giardíase", 365, 1);
insert into vacina (descricao, duracao_dias, tipo) values ("Gripe Canina", 365, 1);
insert into vacina (descricao, duracao_dias, tipo) values ("Leishmaniose", 365, 1);

create table if not exists vacinacao(
                                        id int not null auto_increment primary key,
                                        animal int not null,
                                        vacina int not null,
                                        data_aplicacao date not null,
                                        constraint fk_vacinacao_animal
                                        foreign key (animal) references animal (id),
    constraint fk_vacinacao_vacina
    foreign key (vacina) references vacina (id)
    );

create table if not exists exames(
                                     id int not null auto_increment primary key,
                                     descricao text not null,
                                     data date not null,
                                     notas text,
                                     file_path text not null,
                                     animal int not null,
                                     constraint fk_exames_animal
                                     foreign key (animal) references animal (id)
    );

create table if not exists consultas(
                                        id int not null auto_increment primary key,
                                        descricao text not null,
                                        data date not null,
                                        notas text,
                                        file_path text not null,
                                        animal int not null,
                                        constraint fk_consultas_animal
                                        foreign key (animal) references animal (id)
    );

create table if not exists avaliacao(
                                        id int not null auto_increment primary key,
                                        empresa int not null,
                                        usuario int not null,
                                        nota int not null,
                                        descricao text not null,
                                        constraint fk_avaliacao_empresa
                                        foreign key (empresa) references usuario (id),
    constraint fk_avalicao_usuario
    foreign key (usuario) references usuario (id)
    );
```

<br>
<div>
    <h3>📓 UML</h3>
    <hr>
    <p>Como diagramas UML no projeto, utilizarei o <strong>
Diagrama de Classes</strong> e o <strong>Diagrama de 
Casos de Uso</strong>.</p>
    <br>
    <h5>Diagrama de Classes</h5>
    <hr>
    <img src="https://guiandrade.com.br/fotosgithub/diagrama-de-classes.jpg" 
         alt="Diagrama de Classes">
    <br>
    <h5>Diagrama de Casos de Uso</h5>
    <hr>
    <img src="https://guiandrade.com.br/fotosgithub/diagrama-de-caso-de-uso.jpg" 
         alt="Diagrama de Casos de Uso">
</div>

<br>
<div>
    <h3>🎴 Prototipação de Telas</h3>
    <hr>
    <p>Utilizando a ferramenta <strong>Figma</strong>, foram
prototipadas as telas da página web que será utilizada pelas 
empresas associadas e o layout do aplicativo mobile que será
utilizado pelo cliente.</p>
    <div style="display: inline-block">
        <a href="https://www.figma.com/proto/iPam7Cws7MKvVeqeQCxsZM/Pet-Love-Web?node-id=1%3A2&starting-point-node-id=1%3A2" target="_blank"><strong>SISTEMA WEB</strong></a>
        -- 
        <a href="https://www.figma.com/proto/bNfwsVz4wQi09xQU1EAhDR/Pet-Love-App?node-id=1%3A2&starting-point-node-id=1%3A2" target="_blank"><strong>APLICATIVO MOBILE</strong></a>
    </div>
</div>