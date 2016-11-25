select id_cotizacion, razon_social, fecha, id_servicio, precio, cantidad, servicio, count(id_servicio) as total_servicio, count(precio) as total from v_cotizacion group by id_cotizacion, razon_social, fecha, id_servicio, precio, cantidad, servicio

select id_cotizacion, razon_social, fecha, count(id_servicio) as total_servicio, count(precio) as total from v_cotizacion group by id_cotizacion, razon_social, fecha, id_servicio, precio, cantidad, servicio

select id_cotizacion, razon_social, fecha, count(id_servicio) as total_servicio, count(precio) as total from v_cotizacion group by id_cotizacion, razon_social, fecha, id_servicio, precio, cantidad, servicio

insert into servicio values(10, 'Contador Diabólico')
