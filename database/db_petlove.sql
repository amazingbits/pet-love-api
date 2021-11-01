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
    senha text not null,
    nome text not null,
    email text not null,
    telefone text not null,
    path_url text,
    nota float not null default 5,
    tipo_usuario int not null,
    criado_em datetime not null default now(),
    ativo boolean not null default true,
    constraint fk_usuario_tipo_usuario
    foreign key (tipo_usuario) references tipo_usuario (id)
);

insert into usuario (senha, nome, email, telefone, path_url, tipo_usuario) values ("21232f297a57a5a743894a0e4a801fc3", "Guilherme Andrade", "gui-keanne@hotmail.com", "48998149069", "courage.png", 1);

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

insert into animal (sexo, nome, nascimento, animal_raca, animal_comportamento, tipo_animal, dono) values ("Fêmea", "Vivi", "2017-05-01", 48, 1, 1, 1);

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
    created_at datetime not null default now(),
    ativo int not null default 1,
    constraint fk_endereco_usuario
    foreign key (usuario) references usuario (id)
);

insert into endereco (cep, rua, numero, complemento, cidade, estado, latitude, longitude, usuario) values ("88047210", "Tv. Debrandino Machado", "197", "fundos", "Florianópolis", "SC", "-27.635548", "-48.5230657", 1);

create table if not exists agenda(
	id int not null auto_increment primary key,
    descricao text not null,
    dia_semana int not null,
    dia_semana_ext text not null,
    hora_inicio time not null,
    hora_fim time not null,
    intervalo_atendimento int not null,
    preco numeric(8,2) not null default 0,
    criado_em datetime not null default now(),
    ativo boolean not null default true,
    usuario int not null,
    constraint fk_agenda_usuario
    foreign key (usuario) references usuario (id)
);

create table if not exists agenda_item(
	id int not null auto_increment primary key,
    agenda int not null,
    descricao text,
    data date not null,
    hora time not null,
    status enum("Marcada", "Confirmada", "Cancelada"),
    constraint fk_item_agenda
    foreign key (agenda) references agenda (id)
);

create table if not exists bloqueio(
	id int not null auto_increment primary key,
    descricao text not null,
    agenda int not null,
    usuario int not null,
    data_inicial date not null,
    data_final date not null,
    criado_em datetime not null default now(),
    ativo int not null default 1,
    constraint fk_bloqueio_agenda
    foreign key (agenda) references agenda (id),
    constraint fk_bloqueio_usuario
    foreign key (usuario) references usuario (id)
);

create table if not exists vacina(
	id int not null auto_increment primary key,
    descricao varchar(255) not null,
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
    criado_em datetime not null default now(),
    ativo int not null default 1,
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
    criado_em datetime not null default now(),
    ativo int not null default 1,
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
    criado_em datetime not null default now(),
    ativo int not null default 1,
    constraint fk_consultas_animal
    foreign key (animal) references animal (id)
);

create table if not exists avaliacao(
	id int not null auto_increment primary key,
    empresa int not null,
    usuario int not null,
    nota int not null,
    descricao text not null,
    criado_em datetime not null default now(),
    ativo int not null default 1,
    constraint fk_avaliacao_empresa
    foreign key (empresa) references usuario (id),
    constraint fk_avalicao_usuario
    foreign key (usuario) references usuario (id)
);

/* SEEDS */

-- Empresas

-- Clínica veterinária 3 irmãos
insert into usuario (senha, nome, email, telefone, path_url, tipo_usuario) values ("e10adc3949ba59abbe56e057f20f883e", "Clínica Veterinária 3 Irmãos", "tresirmaos@email.com", "4833223390", "3-irmaos.png", 2);
insert into endereco(cep, rua, numero, complemento, cidade, estado, latitude, longitude, usuario) values ("88015160", "Rua Luís Delfino", "34", "", "Florianópolis", "SC", "-48.5490324", "-27.5889147", 2);

-- Puro encanto pet center
insert into usuario (senha, nome, email, telefone, path_url, tipo_usuario) values ("e10adc3949ba59abbe56e057f20f883e", "Puro Encanto Pet Shop", "puroencanto@email.com", "48999313382", "puro-encanto-pet-center.png", 2);
insert into endereco(cep, rua, numero, complemento, cidade, estado, latitude, longitude, usuario) values ("88037010", "Rua Joe Collaço", "270", "", "Florianópolis", "SC", "-48.5150899", "-27.5983681", 3);

-- Pet Shop Patas e Raizes
insert into usuario (senha, nome, email, telefone, path_url, tipo_usuario) values ("e10adc3949ba59abbe56e057f20f883e", "Patas e Raízes", "patas@email.com", "4832286406", "patas-e-raizes.png", 2);
insert into endereco(cep, rua, numero, complemento, cidade, estado, latitude, longitude, usuario) values ("88020000", "Avenida Hercílio Luz", "853", "", "Florianópolis", "SC", "-48.5483593", "-27.5963383", 4);

-- Pet Family
insert into usuario (senha, nome, email, telefone, path_url, tipo_usuario) values ("e10adc3949ba59abbe56e057f20f883e", "Pet Family", "pet-family@email.com", "4832234518", "pet-family.png", 2);
insert into endereco(cep, rua, numero, complemento, cidade, estado, latitude, longitude, usuario) values ("88020020", "Rua Herman Blumenau", "71", "", "Florianópolis", "SC", "-48.5479768", "-27.5939949", 5);

-- Dog walker Marcos Oliveira
insert into usuario (senha, nome, email, telefone, path_url, tipo_usuario) values ("e10adc3949ba59abbe56e057f20f883e", "Marcos Oliveira", "marcos-oliveira@email.com", "48998149069", "marcos-oliveira.jpg", 2);
insert into endereco(cep, rua, numero, complemento, cidade, estado, latitude, longitude, usuario) values ("88036135", "Rua Europa", "200", "", "Florianópolis", "SC", "-48.5289028", "-27.585531", 6);

-- Agendas

-- Agendas 3 irmãos 2
-- Banho e Tosa - Segunda-feira - 10:00 - 14:00
insert into agenda (descricao, dia_semana, dia_semana_ext, hora_inicio, hora_fim, intervalo_atendimento, usuario) values ("Banho e tosa", 1, "Segunda", "10:00", "14:00", 30, 2);
-- Banho e Tosa - Quarta-feira - 10:00 - 14:00
insert into agenda (descricao, dia_semana, dia_semana_ext, hora_inicio, hora_fim, intervalo_atendimento, usuario) values ("Banho e tosa", 3, "Quarta", "10:00", "14:00", 30, 2);

-- Agendas puro encanto
-- Castração - Segunda-feira - 08:00 - 18:00
insert into agenda (descricao, dia_semana, dia_semana_ext, hora_inicio, hora_fim, intervalo_atendimento, usuario) values ("Castração", 1, "Segunda", "08:00", "18:00", 30, 3);
-- Banho e tosa - Segunda-feira - 08:00 - 12:00
insert into agenda (descricao, dia_semana, dia_semana_ext, hora_inicio, hora_fim, intervalo_atendimento, usuario) values ("Banho", 1, "Segunda", "08:00", "12:00", 30, 3);
-- Castração - Sexta-feira - 08:00 - 16:00
insert into agenda (descricao, dia_semana, dia_semana_ext, hora_inicio, hora_fim, intervalo_atendimento, usuario) values ("Castração", 5, "Sexta", "08:00", "16:00", 30, 3);
-- Banho e Tosa - Sexta-feira - 08:00 - 12:00
insert into agenda (descricao, dia_semana, dia_semana_ext, hora_inicio, hora_fim, intervalo_atendimento, usuario) values ("Banho", 5, "Sexta", "08:00", "12:00", 30, 3);

-- Agendas Marcos Oliveira
-- Passeio - Segunda-feira - 08:00 - 18:00
insert into agenda (descricao, dia_semana, dia_semana_ext, hora_inicio, hora_fim, intervalo_atendimento, usuario) values ("Passeio", 1, "Segunda", "08:00", "18:00", 30, 6);
-- Passeio - Terça-feira - 08:00 - 18:00
insert into agenda (descricao, dia_semana, dia_semana_ext, hora_inicio, hora_fim, intervalo_atendimento, usuario) values ("Passeio", 2, "Terça", "08:00", "18:00", 30, 6);
-- Passeio - Quarta-feira - 08:00 - 18:00
insert into agenda (descricao, dia_semana, dia_semana_ext, hora_inicio, hora_fim, intervalo_atendimento, usuario) values ("Passeio", 3, "Quarta", "08:00", "18:00", 30, 6);
-- Passeio - Quinta-feira - 08:00 - 18:00
insert into agenda (descricao, dia_semana, dia_semana_ext, hora_inicio, hora_fim, intervalo_atendimento, usuario) values ("Passeio", 4, "Quinta", "08:00", "18:00", 30, 6);
-- Passeio - Sexta-feira - 08:00 - 18:00
insert into agenda (descricao, dia_semana, dia_semana_ext, hora_inicio, hora_fim, intervalo_atendimento, usuario) values ("Passeio", 5, "Sexta", "08:00", "18:00", 30, 6);