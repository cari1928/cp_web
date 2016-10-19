crate table usuario_rol (id_usuario int not null, id_rol int not null,
          constraint usuarioRolpk primary key(id_usuario, id_rol),
          constraint usuarioRolfk foreign key (id_usuario) references usuario(id_usuario),
          constraint usuarioRolfk2 foreign key (id_rol) references rol(id_rol))
create table rol_privilegio (id_rol int not null, id_privilegio int not null
          constraint rol_privilegiopk primary key (id_rol, id_privilegio),
          constraint rol_privilegiofk foreign key (id_rol) references rol(id_rol),
          constraint rol_privilegiofk2 foreign key (id_privilegio) references privilegio(id_privilegio))
