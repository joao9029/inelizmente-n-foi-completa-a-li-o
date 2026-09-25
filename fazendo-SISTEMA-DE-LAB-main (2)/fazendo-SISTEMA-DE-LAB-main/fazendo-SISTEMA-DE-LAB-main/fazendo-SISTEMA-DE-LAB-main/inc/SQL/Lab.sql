create database laboratorio;
use laboratorio;

create table labs (
  id_lab int primary key auto_increment not null,
  nr_lab int not null
);

create table professores (
  id_professor int primary key auto_increment not null,
  nm_professor varchar(100) not null,
  ds_email varchar(100),
  ds_matricula varchar(20)
);

create table turmas (
  id_turma int primary key auto_increment not null,
  nm_turma varchar(100) not null,
  ds_turma varchar(100)
);

create table reservas (
  id_reserva int primary key auto_increment not null,
  id_professor int not null,
  id_turma int not null,
  id_lab int not null,
  hr_inicio datetime not null,
  hr_saida datetime not null,
  ds_reserva enum('livre','reservado') default 'livre' not null,
  foreign key (id_professor) references professores (id_professor),
  foreign key (id_turma) references turmas (id_turma),
  foreign key (id_lab) references labs (id_lab)
);

insert into labs (nr_lab) values 
(1),
(2),
(3),
(4),
(5);

insert into professores (nm_professor, ds_email, ds_matricula) values 
('Matheus calixto', 'matheus.calixto@email.com', '12345'),
('oswaldo', 'oswaldo.gamer@email.com', '67890'),
('bananinha', 'bananinha.aura@email.com', '11223'),
('joão aura', 'joão.aura@email.com', '44556');

insert into turmas (nm_turma, ds_turma) values 
('1º ano MDS', 'turma do primeiro ano MDS'),
('2º ano MDS', 'turma do segundo ano MDS'),
('3º ano MDS', 'turma do terceiro ano MDS'),
('técnico em informática', 'turma do curso técnico');

insert into reservas (id_professor, id_turma, id_lab, hr_inicio, hr_saida, ds_reserva) values 
(1, 1, 1, '2026-09-23 08:00:00', '2026-09-23 10:00:00', 'reservado'),
(2, 2, 2, '2026-09-23 10:00:00', '2026-09-23 12:00:00', 'reservado'),
(3, 3, 3, '2026-09-24 14:00:00', '2026-09-24 16:00:00', 'reservado'),
(1, 4, 1, '2026-09-25 08:00:00', '2026-09-25 11:00:00', 'livre');