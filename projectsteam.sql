-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-01-2022 a las 19:32:26
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `projectsteam`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  `donation` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `donor_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `donations`
--

INSERT INTO `donations` (`id`, `id_user`, `id_project`, `donation`, `date`, `donor_name`) VALUES
(1, 6, 8, 498, '2022-01-02 03:47:08', 'Teo Nikolaeva'),
(2, 8, 8, 512, '2022-01-02 03:49:33', 'Sol Torres'),
(3, 8, 9, 168, '2022-01-02 03:55:38', 'Sol Torres'),
(10, 8, 10, 87, '2022-01-03 06:36:34', 'Anónimo'),
(11, 10, 10, 150, '2022-01-05 18:08:37', 'Pikachu'),
(12, 10, 11, 1500, '2022-01-05 18:11:13', 'Pikachu'),
(13, 10, 12, 2500, '2022-01-05 18:12:09', 'Pikachu'),
(14, 10, 13, 80, '2022-01-05 18:13:00', 'Pikachu'),
(15, 10, 13, 150, '2022-01-05 18:13:35', 'Pikachu'),
(16, 10, 13, 455, '2022-01-05 18:14:10', 'Pikachu'),
(17, 10, 14, 2000, '2022-01-05 18:14:53', 'Pikachu'),
(18, 10, 15, 950, '2022-01-05 18:16:47', 'Pikachu'),
(19, 10, 16, 2000, '2022-01-05 18:17:30', 'Pikachu'),
(20, 10, 17, 1111, '2022-01-05 18:18:13', 'Pikachu'),
(21, 10, 19, 999, '2022-01-05 18:19:16', 'Pikachu'),
(22, 10, 18, 1500, '2022-01-05 18:19:56', 'Pikachu');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects`
--

CREATE TABLE `projects` (
  `title` text NOT NULL,
  `subtitle` text NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text NOT NULL,
  `picture` text NOT NULL,
  `moneyGoal` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  `science` tinyint(1) NOT NULL,
  `tech` tinyint(1) NOT NULL,
  `eng` tinyint(1) NOT NULL,
  `art` tinyint(1) NOT NULL,
  `math` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `projects`
--

INSERT INTO `projects` (`title`, `subtitle`, `organizer_id`, `start_date`, `end_date`, `description`, `picture`, `moneyGoal`, `id_project`, `science`, `tech`, `eng`, `art`, `math`) VALUES
('tether - protegiendo zonas seguras alrededor de bicicletas', '   Un dispositivo de seguridad de bicicleta conectado; una luz, sensor y comunicador que hace que las carreteras sean más seguras, menos estresantes y más felices.   ', 6, '2022-01-01 06:57:41', '2022-02-02 22:59:59', '   &lt;p&gt;&lt;b&gt;tether:&lt;/b&gt; carreteras más seguras, impulsadas por ciclistas &lt;br&gt;\r\n                &lt;br&gt;Un dispositivo de seguridad para bicicletas que proyecta una zona segura alrededor de su bicicleta, responde a los usuarios de la carretera que lo rodean, identificando carreteras seguras e inseguras en su ciudad. \r\n                &lt;br&gt;Creemos que el ciclismo es la mejor manera de viajar por una ciudad. También puede ser realmente peligroso y estresante. \r\n                &lt;br&gt;Los pasos cercanos adelantando a los automóviles son la mayor causa de accidentes fatales o graves que involucran a ciclistas. La furia vial está en aumento ya que la comunicación entre ciclistas y automovilistas es limitada, y tenemos poca comprensión de la ruta más segura para andar en bicicleta a través de nuestra ciudad. Tether se inventó para resolver este problema y conectarse a una nueva comunidad que crea carreteras más seguras para todos cuanto más lo usan.\r\n                &lt;br&gt;\r\n                &lt;br&gt;&lt;b&gt;¿Qué hace?&lt;/b&gt;   \r\n                \r\n                &lt;ul&gt;\r\n                  &lt;li&gt;Tether se adhiere a su manillar y proyecta lo que llamamos &#039;La Burbuja&#039; una zona segura alrededor de su bicicleta, alentando a los conductores a darle suficiente espacio a medida que adelantan.&lt;/li&gt;\r\n                  &lt;li&gt;Los sensores integrados monitorean y detectan continuamente a otros usuarios de la carretera y vehículos que adelantan, publicando esto en tiempo real en una aplicación complementaria.&lt;/li&gt;\r\n                  &lt;li&gt;Las ubicaciones de los adelantamientos se registran para identificar zonas seguras e inseguras en su ciudad para ayudar a planificar rutas más seguras.&lt;/li&gt;\r\n                &lt;/ul&gt;\r\n                &lt;/p&gt;', 'media/projects_pics/73ce16163bcb88b01fdc097be20d9ba2p_tether.png', 2030, 8, 0, 1, 1, 0, 0),
('Bonjour | Reloj despertador inteligente con IA', 'Su reloj despertador ahora es un asistente\r\npersonal. Al conocer su agenda y sus pasatiempos, Bonjour le ayuda a aprovechar al máximo cada día.', 6, '2022-01-01 18:25:39', '2022-01-30 22:59:59', '', 'media/projects_pics/658bbc7f136e0a525512fec0d1f4p_bonjour.png', 200, 9, 0, 0, 1, 0, 0),
('El Tamaño Atómico importa', 'Una tesis doctoral en química teórica del estado sólido... en forma de cómic.      ', 9, '2022-01-03 03:37:54', '2022-01-20 22:59:59', '    &lt;b&gt;Sobre este cómic&lt;/b&gt;&lt;br&gt;\r\nEscribí e ilustré este libro como una versión de mi tesis doctoral en química, hecha para no científicos.  Mi investigación de posgrado se centró en la pregunta de por qué los sólidos cristalinos forman los patrones que forman. Específicamente, nos interesamos en los orígenes de los cuasicristales, un tipo de material sólido que tiene simetría rotacional, pero el patrón nunca se repite.  &lt;br&gt; &lt;br&gt;\r\n\r\nTodo el libro te lleva desde los conceptos básicos detrás de este trabajo hasta su conexión con los cuasicristales en seis secciones: &lt;br&gt;\r\n&lt;ul&gt;\r\n&lt;li&gt;Por qué nos preocupamos por las estructuras sólidas &lt;/li&gt; \r\n&lt;li&gt;Nuestra idea de la presión química y nuestra comprensión de la forma en que los átomos interactúan &lt;/li&gt; \r\n&lt;li&gt;Cómo usamos las computadoras para llevar nuestro modelo a tres dimensiones &lt;/li&gt; \r\n&lt;li&gt;Introducción de un CaCu5 como sistema modelo para comprender la presión química&lt;/li&gt;\r\n&lt;li&gt;Extendiendo nuestro modelo a un material ganador del premio nobel: cuasicristales &lt;/li&gt;\r\n&lt;li&gt;Hacia dónde va esta investigación en el futuro &lt;/li&gt;\r\n&lt;/ul&gt; &lt;br&gt;\r\n\r\nEl libro en sí se imprimirá en papel de alta calidad, con una encuadernación perfecta al estilo de un cómic de bolsillo comercial.  Los $ 20 que pagará por una copia cubrirán los costos de impresión y la entrega de la impresora a mí.  La tarifa de envío adicional es para que pueda hacerte llegar el libro. &lt;br&gt; &lt;br&gt;\r\n\r\nCuando era niño, me hubiera encantado aprender un poco sobre la investigación científica actual, presentada en un formato familiar.  Si tengo éxito en esta campaña, he presupuestado hacer algunas copias adicionales para poder entregar el libro a la biblioteca y bibliotecas de mi escuela secundaria en Madison, WI, donde hice mi trabajo de posgrado.\r\n', 'media/projects_pics/bef3d685da86c8f29a175c82153b5ca4p_chemistrymatters.png', 785, 10, 1, 0, 0, 0, 0),
('COMIXSCAPE Colección 1!', '¡Un ómnibus de más de 150 páginas de los primeros 3 volúmenes de mi serie de webcomic COMIXSCAPE, además de algunos extras muy especiales para lectores nuevos y antiguos!', 6, '2022-01-04 19:08:30', '2022-01-28 22:59:59', 'COMIXSCAPE es una serie de cómics web cómica que narra la vida de un preadolescente perpetuo y de ojos brillantes llamado Tyler y su compañero mapache Rocky en su nuevo vecindario. En el camino se hace amigo de una chica llamada Nia y juntos, se involucran gradualmente en Y descubriendo sucesos extraños e inusuales que suceden en su ciudad. El cómic se centra principalmente en los tres valores clave de la vida: la amistad, la familia y los videojuegos. ¡Puedes leerlo en www.comixscape.net!\r\n\r\nAunque he estado dibujando la serie desde 2012, he tenido varios de estos personajes conmigo desde la infancia en viejos cuadernos de bocetos, páginas de hojas sueltas y demasiados cuadernos de la escuela primaria.\r\n\r\nCrecí con estos personajes y significan mucho para mí. Si bien la serie comenzó como un webcomic, desde entonces la he publicado en un trío de libros (y hay más en camino) que vendí desde mi sitio web. , tiendas de cómics, escuelas y convenciones.\r\n\r\nEste Kickstarter es para un libro general que serviría como una gran edición recopilada de los primeros 3 volúmenes (capítulos 1-4) de COMIXSCAPE (que equivalen a más de 150 páginas de cómics) en uno, junto con arte invitado de una variedad de Si bien los Volúmenes lo han hecho muy bien a lo largo de los años, ¡la Colección es algo que estoy elaborando como una forma más grande y definitiva de experimentar esta primera mitad de esta historia! ', 'media/projects_pics/9d9244e8eaf5d152e91ea499c41f2324p_comic.png', 5000, 11, 0, 0, 0, 1, 0),
('El juego “Bunny Numbers” ayuda a niños a aprender matemáticas', 'Aprender tablas de multiplicar jugando el juego. Los niños disfrutan jugando a este juego - los disfrutarás aprendiendo matemáticas', 6, '2022-01-04 19:13:33', '2022-02-26 22:59:59', 'Hola, bienvenido a nuestra familia.\r\n\r\nCuando nuestro hijo mayor cumplió 4 años, como cualquier padre, quería infundir confianza en él, especialmente en matemáticas.\r\n\r\nComencé a buscar diferentes herramientas educativas, libros, juegos, tarjetas didácticas, pero no pudimos captar la atención de nuestro hijo y mantenerlo interesado.\r\n\r\n¡Así que decidí hacer mi propio juego!\r\n\r\nBueno, en primer lugar, ¡definitivamente debería ser un juego! Quiero decir, ¡¿Quién no ama los juegos?! Aprender a través de los juegos es más divertido y efectivo.\r\n\r\nOk, el juego debería incluir números, ¡cierto! También consideré el elemento de competencia que mantendría las cosas interesantes.\r\n\r\nA partir de este concepto, se nos ocurrió un juego llamado &quot;Bunny Numbers&quot;. El juego es muy simple de jugar y al mismo tiempo muy efectivo y divertido. El juego consta de 72 fichas, en un lado de cada ficha hay un número de 1 a 12, y cada número se puede encontrar 6 veces.\r\n\r\nHay muchas formas diferentes de jugar al juego de los &quot;números de conejito&quot;.\r\n\r\nAhora déjame compartir nuestras experiencias contigo ...\r\n\r\nComenzamos aprendiendo las adiciones. Pusimos todas las fichas boca abajo en el centro de la mesa y cada uno de nosotros tomó 2 fichas, sumamos los números y anunciamos el resultado, el que tuviera la puntuación más alta se llevaría las 4 fichas. Repita el proceso hasta que no queden baldosas.\r\n\r\nAl final, cada uno de nosotros contaba la cantidad total de fichas que nos quedaban y el que tenía más fichas ganaba.\r\n\r\n¡Fue muy simple e interesante para todos nosotros sin mencionar la diversión! ¡Mi hijo siempre pedía jugar un juego más!\r\n\r\nCuando su confianza creció, comenzamos a restar números y después de eso, comenzamos a multiplicar números. Como resultado, cuando tenía 5 años, podía sumar, restar y multiplicar números con confianza.\r\n\r\nNuestros hijos han llegado a disfrutar tanto del juego que a menudo juegan sin mí. Como padres, estamos muy orgullosos de ellos y de sus logros.\r\n\r\n¡Así que decidimos compartir nuestra historia y nuestro divertido método de aprender matemáticas con todos!', 'media/projects_pics/1aed1fea4d9a83bc9112b278768d7f51p_bunny.png', 4200, 12, 0, 0, 0, 0, 1),
('Deck: El videojuego de carrera de construcción de Decks', 'Deck RX combina elementos tradicionales de construcción de mazos roguelike con el género de los videojuegos de carreras.', 9, '2022-01-04 19:17:21', '2022-03-31 21:59:59', 'Después de siglos de guerra, las Deck Races lograron lo que nadie había logrado antes: la paz. Humanos, Aliens, Cyborgs y Sentinent AIs compiten por la inmortalidad en el deporte más visto de la Galaxia. Solo uno lo logrará. El resto morirá en el proceso.\r\n\r\nComo un pequeño estudio de juegos independiente, no tenemos esa red de seguridad que tienen las principales empresas, por lo que estamos haciendo todo lo posible para llevar este proyecto a su estado final. Hemos invertido nuestros fondos, vidas, ilusiones y sueños en esto. aventura que es el desarrollo de juegos independientes y realmente creemos que se compensarán con Deck Rx. Si tenemos que hablar sobre nuestro principal riesgo, este debería ser el retraso en la fecha de lanzamiento, pero en este punto realmente creemos que deberíamos estar a tiempo teniendo el juego listo para las tiendas.\r\n\r\nAdemás, las recompensas de las que la gestión depende 100% de nosotros, se entregarán a tiempo (o al menos intentaremos lograrlo)\r\n\r\nAquí en Meteorbyte Studios somos humanos como todos ustedes. Tenemos el temor común de lanzar un proyecto como &quot;Oh, no, no les gustará nuestro juego&quot; o &quot;¡Apúrate, vamos a llegar tarde con esto!&quot; Al final del día, estamos emocionados de que al día siguiente se presenten nuevos contenidos y nuevas ideas para Deck Rx.', 'media/projects_pics/4ab2779c908f927fc6a9f240ed7b8718p_deckrx.png', 10000, 13, 0, 1, 1, 0, 0),
('Kit de actividades STEMpowerkids', 'STEMpowerkids ofrece kits de actividades de ciencia, tecnología, ingeniería y matemáticas mensuales para niños de 3 a 8 años.', 9, '2022-01-04 19:18:47', '2022-04-27 21:59:59', ' ', 'media/projects_pics/f7b81c7a3d982227a9ddac81c6869872p_stempower.png', 6820, 14, 1, 1, 1, 0, 1),
('The Class That Harnessed the Wind', 'Los estudiantes de secundaria aprenden principios de diseño, ingeniería y publicación al construir una turbina eólica en funcionamiento.', 9, '2022-01-04 19:24:35', '2022-01-22 22:59:59', 'Nos sentimos inspirados para comenzar este proyecto porque leímos el libro de William Kamkwamba, &#039;El niño que aprovechó el viento&#039; este verano y tuvimos el placer de escucharlo hablar en nuestra escuela este otoño.\r\n\r\nNuestro objetivo es caminar en los zapatos de William Kamkwamba diseñando y construyendo una turbina eólica en funcionamiento y escribiendo un libro sobre nuestra experiencia.\r\n\r\nEste proyecto será dirigido por los estudiantes de la clase de Introducción a la Ingeniería del Sr. Joslin en la New Hampton School. Aunque no construiremos una réplica exacta del molino de viento de Kamkwamba, creemos que será emocionante pasar por un proceso similar al suyo. ..\r\n\r\nA medida que construimos la turbina eólica, también aprenderemos los principios del proceso de ingeniería y diseño. Al usar Kickstarter, aprendemos cómo lanzar una empresa, llevar una idea del concepto a la realidad y cómo asegurar el respaldo. A través de la escritura de un libro ¡Esperamos que el libro sea informativo e inspire a otros estudiantes a soñar en grande, construir algo emocionante y compartir su experiencia con otros!\r\n\r\nTodos los fondos que recaudemos más allá de nuestra meta se utilizarán para proyectos futuros e incluso podríamos ayudar a otros estudiantes que realizan un trabajo interesante aquí en Kickstarter.', 'media/projects_pics/46daa4a4e641af3bcd754a51fc55d854p_wind.png', 1000, 15, 0, 0, 1, 1, 0),
('Informe de química del suelo de Kenneth Mbene', 'Tesis sobre la capacidad de fijación de fósforo en suelos y cuerpos de agua volcánicos del suroeste de Camerún.', 8, '2022-01-04 19:26:09', '2022-03-11 22:59:59', 'Uno de mis amigos más cercanos en el mundo, Kenneth Mbene, quien es la persona más amable y con los pies en la tierra, es estudiante de doctorado en Química (Ciencias del suelo) en la Universidad de Buea en Camerún. sin embargo, no existe ninguna instalación capaz de analizar adecuadamente el suelo / líquidos para determinar el pH, la temperatura, el carbono orgánico, los metales pesados, la conductividad eléctrica, el sulfato y otros parámetros a un nivel alto en Camerún, ni tampoco en ningún otro lugar de África Occidental.\r\n\r\nLa única opción de Ken es enviar sus muestras al extranjero para su análisis, probablemente a India, donde es más rentable. Recaudar más de $ 5,000 en una nación de bajos ingresos como Camerún, para un padre de dos hijos como Ken, es realmente una tarea difícil. esfuerzo Y Ken responderá personalmente a CADA donación. Cualquier ayuda que usted pueda brindarle, será muy apreciada. Y Ken responderá personalmente a CADA donación.\r\n\r\nMás específicamente, su dinero se destinará a dos recipientes diferentes. El recipiente 1 consistirá en importar ciertos materiales clave, como pipetas, tubos de centrífuga, tubos de hidrómetro y resina de grado nuclear, de modo que se puedan realizar algunas de las pruebas más sencillas. en el país. Esto también beneficiará a los futuros químicos cameruneses mucho después de que Ken complete su doctorado. El pozo 2 se destinará a enviar suelo al extranjero para hacer frente a los análisis requeridos más costosos (como las pruebas XRD y SEM). Todavía estamos en el proceso No dude en enviarnos un mensaje a Ken oa mí para obtener más información sobre cómo elegir la opción más asequible, pero lo más probable es que sea un laboratorio de Kenia o India.\r\n\r\nAdemás, tenemos la suerte de contar con la ayuda de Richard Marinos, un investigador actual de ciencias del suelo en la Universidad de Duke, y Justin Shih, un ingeniero de UC Berkeley que anteriormente realizó trabajo de campo en ciencias del suelo en la Universidad de Ciencia y Tecnología Kwame Nkrumah en Kumasi, Ghana. ..\r\n\r\nEn pocas palabras, este proyecto es para 1) ayudar a Ken a producir su tesis sobre la calidad del suelo y la química en el suroeste de Camerún (se enviará una copia electrónica a todos los patrocinadores tan pronto como esté completa), y 2) proporcionar algunos materiales básicos a los cameruneses investigadores en ciencias agrícolas para que dificultades como estas puedan atenuarse en el futuro.', 'media/projects_pics/68cb6a02b565879e6ea3769986417883p_chemistryreport.png', 5000, 16, 1, 0, 0, 0, 0),
('Cortometraje &quot;¿Y si pudieses elegir?', 'Un grupo de apasionados del cine vamos a grabar un corto y necesitamos lo básico para pagar a actores, alquilar el local y equipo necesario. Contribuye para apoyar la cultura!\r\n    ', 8, '2022-01-04 19:29:05', '2022-03-22 22:59:59', 'Cualquier ayuda de 5 o 10 euros será perfecta, no es necesario más! Eso es casi como tomarse dos o tres refrescos!\r\n\r\nSi haces una donación pública, te incluiremos en los créditos finales.', 'media/projects_pics/58e653207d2fd2f3d048922a7d618978p_cortoElegir.png', 5000, 17, 0, 0, 0, 1, 0),
('SciLynk: Una nueva era para la ciencia', 'Nuestro objetivo es crear una red de acceso abierto donde las barreras físicas de las instituciones ya no separen a las mentes más brillantes del mundo', 8, '2022-01-04 19:31:46', '2022-06-22 21:59:59', '“Los problemas más difíciles de la ciencia pura y aplicada solo pueden resolverse con la colaboración abierta de la comunidad científica mundial.” (Kenneth G. Wilson, Premio Nobel de Física). El Dr. Wilson, sin duda, estaba en algo. Sin embargo, incluso Claro, existen bases de datos en línea de científicos y artículos, pero no existe una comunidad global vibrante para que TODOS los amantes de la ciencia se comuniquen, interactúen y compartan investigaciones.\r\n\r\nY ahí es donde entra SciLynk: es SU academia científica completa, ya sea que sea un estudiante, profesor, científico o un entusiasta ocasional de la ciencia. Creemos que al construir un puente entre los profesionales de la industria y los futuros investigadores potenciales, podemos crear un futuro Si usted es un investigador que busca realizar un seguimiento de las métricas y los artículos de investigación, SciLynk puede hacerlo. SciLynk realmente puede hacerlo todo, y nosotros esperamos sinceramente que pueda. Los comentarios que hemos recibido de ellos han tardado meses en desarrollarse y, finalmente, cree la mejor plataforma posible adaptada a sus necesidades. ¡Únase a nosotros en este viaje de construir la red científica más extensa que existe!', 'media/projects_pics/c797a8fe6c9a0fdbc148e08ae684e968p_sciLynk.png', 10000, 18, 1, 1, 0, 0, 0),
('UFACTORY Lite 6 – El brazo robotico colaborativo más asequible', 'Hoy en día, los robots se utilizan ampliamente en las grandes fábricas. Son caros, grandes y pesados, trabajan principalmente en tareas pesadas.', 9, '2022-01-04 19:35:12', '2022-08-03 21:59:59', ' Hoy en día, los robots se utilizan ampliamente en las grandes fábricas. Son caros, grandes y pesados, trabajan principalmente en tareas pesadas. Sin embargo, pocos de ellos están diseñados para tareas ligeras y económicas. Esto plantea un verdadero desafío para mantener la rapidez ROI en estas tareas mediante el uso de robots Un brazo robótico duradero y asequible con accesorios de grado industrial es clave.\r\n\r\nDiseñado con seis ejes, Lite 6 es perfecto para tareas simples, repetitivas y monótonas. Proporciona la velocidad y precisión que requieren los fabricantes, mientras que garantiza calidad y precisión. La flexibilidad de Lite 6 permite a los fabricantes optimizar el flujo de trabajo, aumentar la productividad y reducir la utilización del espacio en el piso. , menores costos de producción.', 'media/projects_pics/920b9280d703b0b1d35d73c1bece2210p_ufactory.png', 50000, 19, 0, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `profile_pic` text NOT NULL,
  `id_user` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`name`, `email`, `password`, `profile_pic`, `id_user`, `active`) VALUES
('Teo Nikolaeva', 'teo@example.com', '$2y$10$dczy3OESfdxXnuDQFm7lqeu3x2VKRMHIifQ0S9oiV6MrzDcmFBlKe', 'media/users_pp/074880e62103ce95a1c589dbf922143eteo.png', 6, 1),
('Sol Torres', 'sol@example.com', '$2y$10$bQuB1pIQHhWlgyoW1DlgDu9ZcC6vr5X2IcPlaecpuxrkszRRVJ88m', '', 8, 1),
('UEM', 'uem@live.uem.es', '$2y$10$18pB9db0TBo9fH21dlanL..cJz3Py6O6U8GOu.9Cm5jcg8ke2r6oe', 'media/users_pp/658bbc7f136e0a525512fec0d1f4bbccuem.jpg', 9, 1),
('Pikachu', 'pikachuchu@example.com', '$2y$10$zyWY5lt6CKodYLS/HhFtVOokfDmK76uR..nO4/vdFknn5vW8Q7dT.', 'media/users_pp/75e356df923f2cf78cec4d1981fecd0a1037761.jpg', 10, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_project` (`id_project`);

--
-- Indices de la tabla `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id_project`),
  ADD KEY `id_project` (`id_project`),
  ADD KEY `organizer_id` (`organizer_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `projects`
--
ALTER TABLE `projects`
  MODIFY `id_project` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`id_project`) REFERENCES `projects` (`id_project`),
  ADD CONSTRAINT `donations_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
