<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'hedo.puzzlestudio.eu' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'root' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', 'root' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'N1r++LPW1L)aoO7 `?F XKc+KX#aR]W,/oDF=9Ga;#w#kPH+~~fq@kOlH:_tMJ]%' );
define( 'SECURE_AUTH_KEY',  'Q1oxSXZ.HOwZ..rLUrfGPIqbq$!},Nmgt?S>^QDq0*9P+e`.*XZDu_8^SW/}}|GU' );
define( 'LOGGED_IN_KEY',    'O;NlUfZ<Q8:>M<?4K<onB|}:hj^ER7>^Hcw#&$Xm&W_n$[q{m%n;_)xTe;r+7<cS' );
define( 'NONCE_KEY',        '4,kp/sFOZNFuuxnBR}AZc;=b 8,F37*:>I]?NxL^l_,78#WYdAwm262hE>g?%g*y' );
define( 'AUTH_SALT',        'GN%vcE9^]b{a[H*/`F8h7hL$IJB9[[Mq]-nvsD#]10#wY8z!f)V&`Lm^/|oB[p/N' );
define( 'SECURE_AUTH_SALT', '<[<U<o|yF]]q}:rizKYGib<KN%Ufv/(TR80lAru]J8&+p-hp8!f<?-O2t9(P`IF+' );
define( 'LOGGED_IN_SALT',   'F78QjIUNc0y|sk:#[oQZMlM!M2rZzW(Fp1cMfj_6e&%6AYkH;^uf3^+rd.:M(`D8' );
define( 'NONCE_SALT',       'Q4*l^cEI60O?uxmf.w #wi}#S:/[++FJvc.fsO~dE)9C#IsqP;$`x%je[`Pl}Nu>' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
