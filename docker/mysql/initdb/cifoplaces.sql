-- Base de datos para CifoPlaces

DROP DATABASE IF EXISTS cifoplaces;
CREATE DATABASE cifoplaces DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE cifoplaces;

-- ------------------------------------------------------------------------------------
-- PARA EL FRAMEWORK FASTLIGHT
-- ------------------------------------------------------------------------------------
-- tabla users
-- se pueden crear campos adicionales o relaciones con otras entidades si es necesario
CREATE TABLE users(
  id INT PRIMARY KEY auto_increment,
  displayname VARCHAR(32) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE KEY,
  phone VARCHAR(32) NOT NULL UNIQUE KEY,
  password VARCHAR(255) NOT NULL,
  roles VARCHAR(1024) NOT NULL DEFAULT '["ROLE_USER"]',
  picture VARCHAR(256) DEFAULT NULL,
  template VARCHAR(32) NULL DEFAULT NULL COMMENT 'Template a cargar, de entre los que se encuentran en la carpeta templates',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- usuarios para las pruebas, podéis crear tantos como necesitéis
INSERT INTO users(id, displayname, email, phone, picture, password, roles) VALUES
  (1, 'admin', 'admin@fastlight.org', '000001', 'admin.png', md5('1234'), '["ROLE_USER", "ROLE_ADMIN"]'),
  (2, 'editor', 'editor@fastlight.org', '000002', 'editor.png', md5('1234'), '["ROLE_USER", "ROLE_EDITOR"]'),
  (3, 'user', 'user@fastlight.org', '000003', 'user.png', md5('1234'), '["ROLE_USER"]'),
  (4, 'test', 'test@fastlight.org', '000004', 'test.png', md5('1234'), '["ROLE_USER", "ROLE_TEST"]'),
  (5, 'api', 'api@fastlight.org', '000005', 'api.png', md5('1234'), '["ROLE_API"]'),
  (6, 'blocked', 'blocked@fastlight.org', '000006', 'blocked.png', md5('1234'), '["ROLE_USER", "ROLE_BLOCKED"]'),
  (7, 'default', 'default@fastlight.org', '000007', NULL, md5('1234'), '[]'),
  (8, 'Robert', 'robert@fastlight.org', '000008', 'other.png', md5('1234'), '["ROLE_USER", "ROLE_ADMIN", "ROLE_TEST"]')
;



-- tabla errors
-- por si queremos registrar los errores en base de datos.
CREATE TABLE errors(
  id INT PRIMARY KEY auto_increment,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    type CHAR(3) NOT NULL DEFAULT 'WEB',
    level VARCHAR(32) NOT NULL DEFAULT 'ERROR',
    url VARCHAR(256) NOT NULL,
  message VARCHAR(2048) NOT NULL,
  user VARCHAR(128) DEFAULT NULL,
  ip CHAR(15) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- tabla stats
-- por si queremos registrar las estadísticas de visitas a las disintas URLs de nuestra aplicación.
CREATE TABLE stats(
  id INT PRIMARY KEY auto_increment,
    url VARCHAR(250) NOT NULL UNIQUE KEY,
  count INT NOT NULL DEFAULT 1,
  user VARCHAR(128) DEFAULT NULL,
  ip CHAR(15) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




-- ------------------------------------------------------------------------------------
-- PARA EL PROYECTO WEB
-- ------------------------------------------------------------------------------------

-- Creación de la tabla para los lugares
CREATE TABLE places(
	id INT PRIMARY KEY auto_increment,
    name VARCHAR(128) NOT NULL,
    type VARCHAR(128) NOT NULL,
    location VARCHAR(128) NOT NULL,
    description TEXT,
    mainpicture VARCHAR(128) NULL DEFAULT NULL,
    iduser INT NULL,
    latitude DOUBLE NULL DEFAULT NULL,
    longitude DOUBLE NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY(iduser) REFERENCES users(id)
		ON UPDATE CASCADE ON DELETE SET NULL
);

-- Inserción de algunos datos de lugares
INSERT INTO places (id, name, type, location, description, mainpicture, iduser, latitude, longitude) VALUES
(1, 'Castell del Foix', 'Pantano', 'Castellet i la Gornal', 'Un castillo', 'castillo.jpg', 2, NULL, NULL),
(2, 'Nova Creu Alta', 'Estadio', 'Sabadell', 'Un estadio', 'creualta.jpg', 2, NULL, NULL),
(3, 'Platja de les Salines', 'Playa', 'Cubelles', 'Una playa para perros', 'playa.jpg', 2, NULL, NULL),
(4, 'Sagrada Família', 'Templo', 'Barcelona', 'Un templo', 'sagrada.jpg', 3, NULL, NULL),
(5, 'CIFO Sabadell', 'Centro de formación', 'Terrassa', 'Un centro de formación', 'cifo.jpg', 3, NULL, NULL),
(6, 'Parc Central de Cubelles', 'Parque', 'Cubelles, Barcelona', 'Amplio parque urbano con zonas verdes y juegos infantiles.', 'parc_central.jpg', 2, 41.2098, 1.6723),
(7, 'Platja Llarga', 'Playa', 'Cubelles, Barcelona', 'Playa tranquila con paseo marítimo y chiringuitos.', 'platja_llarga.jpg', 3, 41.2045, 1.6691),
(8, 'Museu del Mar', 'Museo', 'Vilanova i la Geltrú', 'Museo dedicado a la historia marítima local.', 'museu_mar.jpg', 4, 41.2172, 1.7265),
(9, 'Plaça de la Vila', 'Plaza', 'Cubelles, Barcelona', 'Centro neurálgico del pueblo con cafeterías y el ayuntamiento.', 'placa_vila.jpg', 5, 41.2071, 1.6742),
(10, 'Riu Foix', 'Río', 'Cubelles, Barcelona', 'Zona natural protegida ideal para caminatas y observación de aves.', 'riu_foix.jpg', 6, 41.1989, 1.6610),
(11, 'Biblioteca Municipal', 'Edificio público', 'Carrer Major 12, Cubelles', 'Biblioteca con sala de lectura y acceso a internet.', 'biblioteca.jpg', 7, 41.2065, 1.6729),
(12, 'Mercat Setmanal', 'Mercado', 'Plaça del Mercat, Cubelles', 'Mercado tradicional los jueves por la mañana.', 'mercat.jpg', 8, 41.2068, 1.6735),
(13, 'Ermita de Sant Antoni', 'Iglesia', 'Camí de Sant Antoni, Cubelles', 'Pequeña ermita del siglo XVIII en una colina.', 'ermita_santantoni.jpg', 2, 41.2133, 1.6658),
(14, 'Castell de Cubelles', 'Monumento', 'Carrer del Castell, Cubelles', 'Edificio histórico restaurado, sede de exposiciones.', 'castell.jpg', 3, 41.2080, 1.6737),
(15, 'Passeig Marítim', 'Zona recreativa', 'Cubelles, Barcelona', 'Paseo junto al mar con carril bici y bancos para descansar.', 'passeig_maritm.jpg', 4, 41.2050, 1.6702),
(16, 'Jardins del Mar', 'Parque', 'Cubelles, Barcelona', 'Pequeño jardín junto a la playa, ideal para picnic.', 'jardins_mar.jpg', 5, 41.2039, 1.6684),
(17, 'Centre Cívic', 'Centro comunitario', 'Carrer Nou 15, Cubelles', 'Centro donde se organizan actividades culturales y talleres.', 'centre_civic.jpg', 6, 41.2067, 1.6725),
(18, 'Museu de Cubelles', 'Museo', 'Carrer Major 22, Cubelles', 'Museo local con exposiciones sobre la historia del municipio.', 'museu_cubelles.jpg', 7, 41.2074, 1.6722),
(19, 'Parc del Torrent', 'Parque', 'Avinguda del Torrent, Cubelles', 'Zona verde con senderos y juegos infantiles.', 'parc_torrent.jpg', 8, 41.2112, 1.6679),
(20, 'Platja de les Gavines', 'Playa', 'Cubelles, Barcelona', 'Playa familiar con duchas y acceso adaptado.', 'platja_gavines.jpg', 2, 41.2018, 1.6661),
(21, 'Espai Jove', 'Centro juvenil', 'Carrer de la Pau 10, Cubelles', 'Espacio para jóvenes con actividades, talleres y música.', 'espai_jove.jpg', 3, 41.2063, 1.6714),
(22, 'Camp Municipal d’Esports', 'Instalación deportiva', 'Cubelles, Barcelona', 'Campo de fútbol y pistas polideportivas.', 'camp_esports.jpg', 4, 41.2101, 1.6718),
(23, 'Passeig del Foix', 'Sendero', 'Cubelles, Barcelona', 'Ruta de senderismo que sigue el cauce del río Foix.', 'passeig_foix.jpg', 5, 41.1975, 1.6608),
(24, 'Zona Picnic Mas Trader', 'Área recreativa', 'Urbanització Mas Trader, Cubelles', 'Área con mesas de picnic y barbacoas bajo los pinos.', 'picnic_mastrader.jpg', 6, 41.2140, 1.6619),
(25, 'Torre de defensa', 'Monumento histórico', 'Cubelles, Barcelona', 'Antigua torre medieval que vigilaba la costa.', 'torre_defensa.jpg', 7, 41.2085, 1.6693),
(26, 'Ateneu Cubellenc', 'Centro cultural', 'Carrer Sant Antoni 8, Cubelles', 'Edificio histórico donde se realizan conciertos y obras.', 'ateneu.jpg', 8, 41.2079, 1.6731),
(27, 'Parc Infantil Les Salines', 'Parque', 'Cubelles, Barcelona', 'Zona infantil con columpios y pista de patinaje.', 'parc_salines.jpg', 2, 41.2035, 1.6672),
(28, 'Platja de la Mota', 'Playa', 'Cubelles, Barcelona', 'Playa de arena fina ideal para pasear al atardecer.', 'platja_mota.jpg', 3, 41.2007, 1.6650),
(29, 'Mirador del Garraf', 'Mirador', 'Cubelles, Barcelona', 'Punto panorámico con vistas al Mediterráneo.', 'mirador_garraf.jpg', 4, 41.2181, 1.6612),
(30, 'Carrer dels Artesans', 'Zona comercial', 'Cubelles, Barcelona', 'Pequeña calle con tiendas de productos locales y artesanía.', 'carrer_artesans.jpg', 5, 41.2076, 1.6728);


-- Creación de la tabla para las fotos
CREATE TABLE photos(
	id INT PRIMARY KEY auto_increment,
    name VARCHAR(128) NOT NULL,
    file VARCHAR(256) NOT NULL,
    alt VARCHAR(256) NOT NULL,
    description TEXT,
    date DATE NULL DEFAULT NULL,
    time TIME NULL DEFAULT NULL,
    iduser INT NULL,
    idplace INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

	FOREIGN KEY(iduser) REFERENCES users(id)
		ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY(idplace) REFERENCES places(id)
		ON UPDATE CASCADE ON DELETE CASCADE
);

-- Inserción de 25 registros de ejemplo en la tabla photos
INSERT INTO photos (id, name, file, alt, description, date, time, iduser, idplace)
VALUES
(1, 'Parc Central - Vista general', 'parc_central_01.jpg', 'Vista general del Parc Central de Cubelles', 'Fotografía panorámica del parque tomada al atardecer.', '2025-04-10', '18:45:00', 2, 6),
(2, 'Platja Llarga - Amanecer', 'platja_llarga_01.jpg', 'Amanecer en la Platja Llarga', 'El sol saliendo sobre el mar en la Platja Llarga.', '2025-05-02', '06:25:00', 3, 7),
(3, 'Museu del Mar - Entrada', 'museu_mar_01.jpg', 'Entrada principal del Museu del Mar', 'Vista de la fachada del museo con banderas y visitantes.', '2025-03-21', '10:10:00', 4, 8),
(4, 'Plaça de la Vila - Tarde', 'placa_vila_01.jpg', 'Ambiente en la Plaça de la Vila', 'Foto capturada un domingo con terrazas llenas.', '2025-07-18', '19:15:00', 5, 9),
(5, 'Riu Foix - Puente', 'riu_foix_01.jpg', 'Puente sobre el Riu Foix', 'Puente peatonal rodeado de vegetación.', '2025-06-04', '11:30:00', 6, 10),
(6, 'Biblioteca Municipal - Interior', 'biblioteca_01.jpg', 'Interior de la Biblioteca Municipal', 'Zona de lectura con estanterías modernas.', '2025-03-09', '16:05:00', 7, 11),
(7, 'Mercat Setmanal - Paradas', 'mercat_01.jpg', 'Paradas del Mercat Setmanal', 'Diversos puestos de frutas y verduras frescas.', '2025-08-11', '09:45:00', 8, 12),
(8, 'Ermita de Sant Antoni - Fachada', 'ermita_01.jpg', 'Fachada de la Ermita de Sant Antoni', 'Pequeña iglesia encalada sobre una colina.', '2025-01-23', '12:00:00', 2, 13),
(9, 'Castell de Cubelles - Torre', 'castell_01.jpg', 'Torre principal del Castell de Cubelles', 'Imagen detallada de la torre del castillo.', '2025-09-02', '17:40:00', 3, 14),
(10, 'Passeig Marítim - Bicicletas', 'passeig_maritm_01.jpg', 'Ciclistas en el Passeig Marítim', 'Ciclistas disfrutando del paseo junto al mar.', '2025-04-12', '10:55:00', 4, 15),
(11, 'Jardins del Mar - Flores', 'jardins_mar_01.jpg', 'Flores en los Jardins del Mar', 'Flores de temporada en el parque cercano al mar.', '2025-05-27', '14:20:00', 5, 16),
(12, 'Centre Cívic - Actividades', 'centre_civic_01.jpg', 'Entrada al Centre Cívic', 'Cartel de actividades culturales en la entrada.', '2025-02-16', '18:00:00', 6, 17),
(13, 'Museu de Cubelles - Exposición', 'museu_cubelles_01.jpg', 'Exposición del Museu de Cubelles', 'Exposición sobre la historia local del municipio.', '2025-03-03', '11:00:00', 7, 18),
(14, 'Parc del Torrent - Árboles', 'parc_torrent_01.jpg', 'Zona arbolada del Parc del Torrent', 'Sendero entre árboles y bancos de madera.', '2025-07-10', '17:25:00', 8, 19),
(15, 'Platja de les Gavines - Verano', 'platja_gavines_01.jpg', 'Playa de les Gavines en verano', 'Turistas disfrutando del sol y el mar.', '2025-08-05', '15:40:00', 2, 20),
(16, 'Espai Jove - Concierto', 'espai_jove_01.jpg', 'Concierto en el Espai Jove', 'Grupo local tocando en el escenario principal.', '2025-09-14', '21:10:00', 3, 21),
(17, 'Camp Municipal d’Esports - Partido', 'camp_esports_01.jpg', 'Partido en el Camp Municipal d’Esports', 'Encuentro de fútbol local en la tarde del sábado.', '2025-04-06', '17:00:00', 4, 22),
(18, 'Passeig del Foix - Caminata', 'passeig_foix_01.jpg', 'Senderistas en el Passeig del Foix', 'Familias recorriendo el sendero natural.', '2025-10-01', '09:35:00', 5, 23),
(19, 'Zona Picnic Mas Trader - Domingo', 'picnic_mastrader_01.jpg', 'Zona de picnic en Mas Trader', 'Familias comiendo bajo los pinos.', '2025-06-22', '13:10:00', 6, 24),
(20, 'Torre de Defensa - Detalle', 'torre_defensa_01.jpg', 'Detalle de la Torre de Defensa', 'Muro de piedra y ventana original restaurada.', '2025-05-01', '10:15:00', 7, 25),
(21, 'Ateneu Cubellenc - Evento', 'ateneu_01.jpg', 'Concierto en el Ateneu Cubellenc', 'Evento musical en el interior del Ateneu.', '2025-03-14', '20:30:00', 8, 26),
(22, 'Parc Infantil Les Salines - Niños', 'parc_salines_01.jpg', 'Niños jugando en el Parc Infantil Les Salines', 'Zona infantil con columpios nuevos.', '2025-02-09', '11:20:00', 2, 27),
(23, 'Platja de la Mota - Puesta de sol', 'platja_mota_01.jpg', 'Puesta de sol en la Platja de la Mota', 'El cielo se tiñe de naranja sobre el mar.', '2025-09-19', '19:50:00', 3, 28),
(24, 'Mirador del Garraf - Vistas', 'mirador_garraf_01.jpg', 'Vista panorámica desde el Mirador del Garraf', 'Se aprecia toda la costa y el Mediterráneo.', '2025-06-11', '18:35:00', 4, 29),
(25, 'Carrer dels Artesans - Feria', 'carrer_artesans_01.jpg', 'Feria en el Carrer dels Artesans', 'Puestos de artesanía local durante la feria anual.', '2025-05-25', '12:45:00', 5, 30);



-- Creación de la tabla comentarios
CREATE TABLE comments(
	id INT PRIMARY KEY auto_increment,
    text TEXT,
    iduser INT NULL,
    idphoto INT NULL,
    idplace INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(iduser) REFERENCES users(id)
		ON UPDATE CASCADE ON DELETE SET NULL,

    FOREIGN KEY(idplace) REFERENCES places(id)
		ON UPDATE CASCADE ON DELETE CASCADE,

	FOREIGN KEY(idphoto) REFERENCES photos(id)
		ON UPDATE CASCADE ON DELETE CASCADE
);

-- Inserción de 100 registros en la tabla comments
INSERT INTO comments (id, text, iduser, idphoto, idplace)
VALUES
(1, 'Muy buen sitio para pasear en familia.', 2, NULL, 1),
(2, 'El parque está muy limpio y cuidado.', 3, NULL, 1),
(3, 'Fui un domingo y estaba bastante lleno.', 4, 2, NULL),
(4, 'La playa es tranquila y el agua muy clara.', 5, NULL, 2),
(5, 'Faltan duchas cerca del acceso principal.', 6, NULL, 2),
(6, 'Museo pequeño pero interesante.', 7, 3, NULL),
(7, 'Perfecto para visitar con niños.', 8, NULL, 3),
(8, 'La plaza tiene mucho ambiente los fines de semana.', 2, NULL, 4),
(9, 'Me gustó mucho el mercado local.', 3, NULL, 6),
(10, 'El personal de la biblioteca es muy amable.', 4, NULL, 6),
(11, 'Muy buen servicio en la biblioteca.', 5, NULL, 6),
(12, 'Ideal para tomar algo con amigos.', 6, NULL, 7),
(13, 'La ermita es preciosa, vale la pena subir.', 7, 8, NULL),
(14, 'Bonitas vistas desde la colina.', 8, NULL, 8),
(15, 'Interesante historia del castillo.', 2, 9, NULL),
(16, 'Faltan más paneles informativos.', 3, NULL, 9),
(17, 'Un paseo muy agradable al atardecer.', 4, 10, NULL),
(18, 'Perfecto para ir en bici.', 5, NULL, 10),
(19, 'Los jardines están bien mantenidos.', 6, NULL, 11),
(20, 'Ideal para hacer picnic.', 7, NULL, 11),
(21, 'Buen sitio para eventos culturales.', 8, NULL, 12),
(22, 'El centro cívico tiene muchas actividades.', 2, NULL, 12),
(23, 'La exposición del museo fue excelente.', 3, NULL, 13),
(24, 'Personal muy atento en el museo.', 4, NULL, 13),
(25, 'Buen lugar para pasear con los niños.', 5, NULL, 14),
(26, 'Los columpios están en buen estado.', 6, 14, NULL),
(27, 'La playa estaba limpia y tranquila.', 7, NULL, 15),
(28, 'El agua un poco fría pero muy clara.', 8, NULL, 15),
(29, 'Excelente ambiente juvenil.', 2, NULL, 16),
(30, 'Actividades muy divertidas.', 3, 16, NULL),
(31, 'Campo de fútbol en perfecto estado.', 4, NULL, 18),
(32, 'Las gradas están un poco deterioradas.', 5, NULL, 18),
(33, 'Ruta muy bien señalizada.', 6, NULL, 19),
(34, 'Ideal para hacer running.', 7, 18, NULL),
(35, 'Lugar tranquilo para descansar.', 8, NULL, 20),
(36, 'La vista del mar es impresionante.', 2, 19, NULL),
(37, 'Edificio con mucha historia.', 3, NULL, 21),
(38, 'El ateneo ofrece conciertos de calidad.', 4, 20, NULL),
(39, 'Parque muy divertido para los niños.', 5, NULL, 23),
(40, 'Zona infantil muy bien equipada.', 6, NULL, 23),
(41, 'La playa es ideal para dar un paseo.', 7, NULL, 24),
(42, 'Arena fina y limpia, muy recomendable.', 8, NULL, 24),
(43, 'El mirador tiene vistas espectaculares.', 2, NULL, 25),
(44, 'Perfecto para ver la puesta de sol.', 3, 3, NULL),
(45, 'Buena variedad de tiendas artesanas.', 4, NULL, 26),
(46, 'Los productos locales son excelentes.', 5, NULL, 26),
(47, 'El parque es ideal para descansar.', 6, NULL, 27),
(48, 'Zona muy tranquila y agradable.', 7, NULL, 27),
(49, 'Buen sitio para nadar y relajarse.', 8, NULL, 28),
(50, 'La playa no suele estar llena.', 2, NULL, 28),
(51, 'Bonito entorno natural.', 3, NULL, 30),
(52, 'Lugar recomendable para visitar.', 4, 7, NULL),
(53, 'Muy limpio y bien cuidado.', 5, NULL, 1),
(54, 'Perfecto para ir con mascotas.', 6, 8, NULL),
(55, 'Los precios del bar son razonables.', 7, NULL, 3),
(56, 'Ambiente familiar y tranquilo.', 8, 9, NULL),
(57, 'Me encanta venir a leer aquí.', 2, NULL, 6),
(58, 'El personal muy servicial.', 3, NULL, 7),
(59, 'La ermita es un lugar de paz.', 4, NULL, 8),
(60, 'El castillo tiene una vista magnífica.', NULL, 11, 9),
(61, 'El paseo marítimo está impecable.', 6, NULL, 10),
(62, 'Los jardines tienen mucha sombra.', 7, NULL, 11),
(63, 'Excelente organización de eventos.', 8, NULL, 12),
(64, 'Museo interesante, entrada gratuita.', 2, 13, NULL),
(65, 'El parque está muy bien cuidado.', 3, NULL, 14),
(66, 'La playa es amplia y tranquila.', 4, 14, NULL),
(67, 'Excelente trato en el Espai Jove.', 5, NULL, 16),
(68, 'Las pistas del campo deportivo son nuevas.', 6, 15, NULL),
(69, 'Buena ruta para caminar con amigos.', 7, NULL, 19),
(70, 'Paisaje precioso cerca del río.', 8, NULL, 19),
(71, 'Buen sitio para ver aves.', 2, NULL, 20),
(72, 'Atención excelente en el Ateneu.', 3, NULL, 21),
(73, 'Parque limpio y agradable.', 4, NULL, 23),
(74, 'Las playas de Cubelles son las mejores.', 5, NULL, 24),
(75, 'Vistas preciosas del Garraf.', 6, NULL, 25),
(76, 'Muy recomendable al amanecer.', 7, 19, NULL),
(77, 'Tienda con productos artesanales únicos.', 8, NULL, 26),
(78, 'Excelente atención al cliente.', 2, 20, NULL),
(79, 'Zona verde muy cuidada.', 3, NULL, 27),
(80, 'Lugar muy tranquilo para leer.', 4, NULL, 27),
(81, 'Buena playa para nadar.', 5, NULL, 28),
(82, 'Arena fina y mar tranquilo.', 6, 2, NULL),
(83, 'Excelente mirador sobre la costa.', 7, NULL, 25),
(84, 'Ideal para fotografías.', 8, 3, NULL),
(85, 'Calle con ambiente agradable.', 2, NULL, 30),
(86, 'Buena oferta de productos locales.', 3, NULL, 30),
(87, 'Lugar con encanto natural.', 4, NULL, 10),
(88, 'Perfecto para pasear al atardecer.', 5, NULL, 10),
(89, 'Bonita vista del mar.', 6, NULL, 24),
(90, 'Ambiente relajante en el paseo.', 7, 6, NULL),
(91, 'Trato excelente en el museo.', 8, NULL, 13),
(92, 'Muy recomendable para aprender historia.', 2, NULL, 13),
(93, 'Ideal para excursiones familiares.', 3, NULL, 19),
(94, 'Camino bien señalizado.', 4, 8, NULL),
(95, 'Área de picnic muy limpia.', 5, NULL, 20),
(96, 'Perfecto para pasar el día.', 6, 9, NULL),
(97, 'El castillo es una joya arquitectónica.', 7, NULL, 9),
(98, 'Bonito entorno natural en Cubelles.', 8, NULL, 14),
(99, 'Lugar con mucho encanto y vistas.', 2, NULL, 21),
(100, 'Excelente opción para visitar en familia.', 3, NULL, 21);



-- Vista que muestra los datos de los lugares ampliados
CREATE OR REPLACE VIEW v_places AS
SELECT u.displayname AS username, u.picture AS userpicture, pl.*
FROM places pl LEFT JOIN users u ON pl.iduser = u.id;


-- Vista que muestra los datos de las fotos ampliados
CREATE OR REPLACE VIEW v_pictures AS
SELECT u.displayname AS username, u.picture AS userpicture, pl.name AS placename, pl.location AS placelocation, p.*
FROM photos p LEFT JOIN users u ON p.iduser = u.id
	LEFT JOIN places pl ON p.idplace = pl.id;


-- Vista que muestra los datos de los comentarios ampliados
CREATE OR REPLACE VIEW v_comments AS
SELECT u.displayname AS username, u.picture AS userpicture, pl.name AS placename, p.name AS photoname, c.*
FROM comments c LEFT JOIN users u ON u.id = c.iduser
	LEFT JOIN photos p ON p.id = c.idphoto
    LEFT JOIN places pl ON pl.id = c.idplace;