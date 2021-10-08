drop database if exists snc_petlove;
create database snc_petlove;
use snc_petlove;

create table if not exists tipo_usuario(
   id int not null auto_increment primary key,
   descricao varchar(100) not null unique,
   ativo int not null default 1,
   criado_em datetime not null default now()
);

insert into tipo_usuario (descricao) value ("Administrador");
insert into tipo_usuario (descricao) value ("Cliente");
insert into tipo_usuario (descricao) value ("Clínica/Pet Shop");
insert into tipo_usuario (descricao) value ("Dog Walker");

create table if not exists usuario(
  id int not null auto_increment primary key,
  email varchar(255) not null unique,
  password varchar(255) not null,
  tipo int not null,
  telefone text not null,
  ativo int not null default 0,
  avatar_img text not null,
  constraint fk_usuario_tipo
  foreign key (tipo) references tipo_usuario (id)
);

insert into usuario (email, password, tipo, telefone, ativo, avatar_img) values ("gui-keanne@hotmail.com", "21232f297a57a5a743894a0e4a801fc3", 1, "48998149069", 1, "path_to_img");

create table if not exists sessao(
	id int not null auto_increment primary key,
    usuario int not null,
    ip text not null,
    jwt_hash text not null,
    data_login datetime not null default now(),
    data_expiracao date not null,
    constraint fk_sessao_usuario
    foreign key (usuario) references usuario (id)
);

create table if not exists horario_atendimento(
	id int not null auto_increment primary key,
    usuario int not null,
    inicio time not null,
    fim time not null,
    dia_semana enum("Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo") not null,
    constraint fk_horario_atendimento_usuario
    foreign key (usuario) references usuario (id)
);

create table if not exists endereco(
	id int not null auto_increment primary key,
    usuario int not null,
    latitude text not null,
    longitude text not null,
    rua text not null,
    numero text not null,
    complemento text,
    cidade text not null,
    estado text not null,
    constraint fk_endereco_usuario
    foreign key (usuario) references usuario (id)
);

create table if not exists tipo_animal(
	id int not null auto_increment primary key,
	descricao varchar(100) not null unique,
	ativo int not null default 1,
	criado_em datetime not null default now()
);

insert into tipo_animal (descricao) value ("Cachorro");

create table if not exists vacina(
	id int not null auto_increment primary key,
    descricao varchar(255) not null unique,
    duracao_dias int not null,
    ativo int not null default 1,
    criado_em datetime not null default now(),
    tipo int not null,
    constraint vacinas_tipo_animal
    foreign key (tipo) references tipo_animal (id)
);

insert into vacina (descricao, duracao_dias, tipo) values ("Antirrábica (cachorros)", 365, 1);
insert into vacina (descricao, duracao_dias, tipo) values ("Polivalente (V8 e V10)", 365, 1);
insert into vacina (descricao, duracao_dias, tipo) values ("Giardíase", 365, 1);
insert into vacina (descricao, duracao_dias, tipo) values ("Gripe Canina", 365, 1);
insert into vacina (descricao, duracao_dias, tipo) values ("Leishmaniose", 365, 1);

create table raca_animal(
	id int not null auto_increment primary key,
    descricao varchar(100) not null unique,
    tipo int not null,
	ativo int not null default 1,
	criado_em datetime not null default now(),
    constraint fk_raca_tipo_animal
    foreign key (tipo) references tipo_animal (id)
);

insert into raca_animal (descricao, tipo) values ("Akita", 1);
insert into raca_animal (descricao, tipo) values ("Basset Hound", 1);
insert into raca_animal (descricao, tipo) values ("Beagle", 1);
insert into raca_animal (descricao, tipo) values ("Bichon Frisé", 1);
insert into raca_animal (descricao, tipo) values ("Boiadeiro Australiano", 1);
insert into raca_animal (descricao, tipo) values ("Border Collie", 1);
insert into raca_animal (descricao, tipo) values ("Boston Terrier", 1);
insert into raca_animal (descricao, tipo) values ("Boxer", 1);
insert into raca_animal (descricao, tipo) values ("Buldogue Francês", 1);
insert into raca_animal (descricao, tipo) values ("Buldogue Inglês", 1);
insert into raca_animal (descricao, tipo) values ("Bull Terrier", 1);
insert into raca_animal (descricao, tipo) values ("Cane Corso", 1);
insert into raca_animal (descricao, tipo) values ("Cavalier King Charles Spaniel", 1);
insert into raca_animal (descricao, tipo) values ("Chihuahua", 1);
insert into raca_animal (descricao, tipo) values ("Chow Chow", 1);
insert into raca_animal (descricao, tipo) values ("Cocker Spaniel Inglês", 1);
insert into raca_animal (descricao, tipo) values ("Dachshund", 1);
insert into raca_animal (descricao, tipo) values ("Dálmata", 1);
insert into raca_animal (descricao, tipo) values ("Doberman", 1);
insert into raca_animal (descricao, tipo) values ("Dogo Argentino", 1);
insert into raca_animal (descricao, tipo) values ("Dogue Alemão", 1);
insert into raca_animal (descricao, tipo) values ("Fila Brasileiro", 1);
insert into raca_animal (descricao, tipo) values ("Golden Retriever", 1);
insert into raca_animal (descricao, tipo) values ("Husky Siberiano", 1);
insert into raca_animal (descricao, tipo) values ("Jack Russell", 1);
insert into raca_animal (descricao, tipo) values ("Labrador Retriever", 1);
insert into raca_animal (descricao, tipo) values ("Lhasa Apso", 1);
insert into raca_animal (descricao, tipo) values ("Lulu da Pomerânia", 1);
insert into raca_animal (descricao, tipo) values ("Maltês", 1);
insert into raca_animal (descricao, tipo) values ("Mastiff Inglês", 1);
insert into raca_animal (descricao, tipo) values ("Mastim Tibetano", 1);
insert into raca_animal (descricao, tipo) values ("Pastor Alemão", 1);
insert into raca_animal (descricao, tipo) values ("Pastor Australiano", 1);
insert into raca_animal (descricao, tipo) values ("Pastor de Shetland", 1);
insert into raca_animal (descricao, tipo) values ("Pequinês", 1);
insert into raca_animal (descricao, tipo) values ("Pinscher", 1);
insert into raca_animal (descricao, tipo) values ("Pit Bull", 1);
insert into raca_animal (descricao, tipo) values ("Poodle", 1);
insert into raca_animal (descricao, tipo) values ("Pug", 1);
insert into raca_animal (descricao, tipo) values ("Rottweiler", 1);
insert into raca_animal (descricao, tipo) values ("Schnauzer", 1);
insert into raca_animal (descricao, tipo) values ("Shar-pei", 1);
insert into raca_animal (descricao, tipo) values ("Shiba", 1);
insert into raca_animal (descricao, tipo) values ("Shih Tzu", 1);
insert into raca_animal (descricao, tipo) values ("Staffordshire Bull Terrier", 1);
insert into raca_animal (descricao, tipo) values ("Weimaraner", 1);
insert into raca_animal (descricao, tipo) values ("Yorkshire", 1);
insert into raca_animal (descricao, tipo) values ("Vira-lata", 1);

create table if not exists animal(
	id int not null auto_increment primary key,
    dono int not null,
    nome text,
    nascimento date not null,
    comportamento enum("Agitado", "Alegre", "Amoroso", "Bravo", "Brincalhão", "Carente", "Carinhoso", "Dócil", "Valente"),
    cor_pelagem enum("Amarelo", "Azul", "Branco", "Cinza", "Chocolate", "Creme", "Dourado", "Prateado", "Preto", "Vermelho"),
    sexo enum("Macho", "Fêmea"),
    raca int not null,
    castrado int not null default 0,
    possui_chip int not null default 0,
    numero_chip text,
    observacoes text,
    constraint fk_animal_raca
    foreign key (raca) references raca_animal (id)
);

create table if not exists condicao_medica(
	id int not null auto_increment primary key,
    animal int not null,
    descricao text not null,
    data_diagnostico date not null,
    gravidade enum("Menor", "Médio", "Principal", "Crítico") not null,
    acoes_tomadas text,
    notas text,
    constraint fk_condicao_medica_animal
    foreign key (animal) references animal (id)
);

create table if not exists cirurgia(
	id int not null auto_increment primary key,
    animal int not null,
    tipo_cirurgia text not null,
    data_cirurgia date not null,
    nome_clinica text not null,
    preco numeric(8,2) not null,
    observacoes_medicas text,
    notas text,
    constraint fk_cirurgia_animal
    foreign key (animal) references animal (id)
);

create table if not exists visita_veterinario(
	id int not null auto_increment primary key,
    animal int not null,
    descricao text not null,
    data date not null,
    nome_clinica text not null,
    preco numeric(8,2) not null,
    notas text,
    constraint fk_visita_veterinario_animal
    foreign key (animal) references animal (id)
);

create table if not exists exame(
	id int not null auto_increment primary key,
    animal int not null,
    descricao text not null,
    data date not null,
    notas text,
    constraint fk_exame_animal
    foreign key (animal) references animal (id)
);

create table if not exists vacinacao(
	id int not null auto_increment primary key,
    animal int not null,
    vacina int not null,
    data date not null,
    proxima_vacina date default null,
    foi_cuidado enum("Em casa", "Por um profissional") not null,
    notas text,
    ativo int not null default 1,
    constraint fk_vacinacao_animal
    foreign key (animal) references animal (id),
    constraint fk_vacinacao_vacina
    foreign key (vacina) references vacina (id)
);

create table if not exists agenda(
	id int not null auto_increment primary key,
    descricao text not null, 
    usuario int not null,
    dia_semana int not null,
    dia_semana_ext enum("Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo") not null,
    horario_inicio time not null,
    horario_fim time not null,
    intervalo int not null,
    preco numeric(8,2) not null,
    constraint fk_agenda_usuario
    foreign key (usuario) references usuario (id)
);

create table if not exists bloqueio(
	id int not null auto_increment primary key,
    agenda int not null,
    data_inicio date not null,
    data_fim date not null,
    descricao text not null,
    constraint fk_bloqueio_agenda
    foreign key (agenda) references agenda (id)
);

create table if not exists servico(
	id int not null auto_increment primary key,
    data date not null,
    horario time not null,
    usuario int not null,
    animal int not null,
    status enum("Marcado", "Confirmado", "Em atendimento", "Finalizado", "Faltou", "Cancelado") not null,
    constraint fk_servico_usuario
    foreign key (usuario) references usuario (id),
    constraint fk_servico_animal
    foreign key (animal) references animal (id)
);