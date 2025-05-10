<?php
/**
 * Este archivo es un helper de PHPDoc que ayuda a Intelephense (u otros IDEs) a reconocer
 * las propiedades mágicas de CodeIgniter, como $db, $input, $session, y más.
 *
 * Este archivo no necesita ser cargado la aplicación, solo está aquí para
 * ayudar al autocompletado y evitar errores en los IDEs.
 *
 * @property CI_DB_mysqli_driver $db
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property CI_Form_validation $form_validation
 * @property CI_URI $uri
 * @property CI_Output $output
 * @property CI_Lang $lang
 * @property CI_Upload $upload
 * @property CI_Email $email
 * @property CI_Security $security
 * @property Server $server
 */
class CI_Controller {}

/**
 * Clase que ayuda a Intelephense a reconocer los métodos y propiedades de CI_Email
 *
 * @property string $useragent El user agent
 * @property string $mailpath Path al sendmail
 * @property string $protocol Protocolo de envío (mail, sendmail, smtp)
 * @property string $smtp_host Host SMTP
 * @property string $smtp_user Usuario SMTP
 * @property string $smtp_pass Contraseña SMTP
 * @property int $smtp_port Puerto SMTP
 * @property int $smtp_timeout Timeout SMTP
 * @property string $smtp_crypto Tipo de encriptación (tls, ssl)
 * @property bool $wordwrap Word wrap
 * @property string $wrapchars Caracteres por línea en word wrap
 * @property string $mailtype Tipo de email (text, html)
 * @property string $charset Set de caracteres
 * @property bool $validate Validar email
 * @property int $priority Prioridad del email
 * @property string $crlf Tipo de salto de línea
 * @property string $newline Tipo de nueva línea
 * @property bool $bcc_batch_mode Modo de copia oculta en lote
 * @property int $bcc_batch_size Tamaño del lote de copias ocultas
 * @property bool $dsn Active la notificación de estado de entrega
 *
 * @method bool initialize(array $config = array())
 * @method CI_Email from(string $from, string $name = '', string $return_path = null)
 * @method CI_Email reply_to(string $reply_to, string $name = '')
 * @method CI_Email to(string|array $to)
 * @method CI_Email cc(string|array $cc)
 * @method CI_Email bcc(string|array $bcc)
 * @method CI_Email subject(string $subject)
 * @method CI_Email message(string $body)
 * @method CI_Email set_alt_message(string $str)
 * @method CI_Email set_header(string $header, string $value)
 * @method CI_Email clear(bool $clear_attachments = false)
 * @method CI_Email attach(string $filename, string $disposition = '', string $newname = null, string $mime = '')
 * @method bool send(bool $auto_clear = true)
 * @method string print_debugger(array $include = ['headers', 'subject', 'body'])
 * @method CI_Email set_newline(string $newline)
 * @method CI_Email set_crlf(string $crlf)
 */
class CI_Email {
    /** @var string */
    public $useragent = 'CodeIgniter';

    /** @var string */
    public $mailpath = '/usr/sbin/sendmail';

    /** @var string */
    public $protocol = 'mail';

    /** @var string */
    public $smtp_host = '';

    /** @var string */
    public $smtp_user = '';

    /** @var string */
    public $smtp_pass = '';
}

/**
 * Clase que ayuda a Intelephense a reconocer los métodos y propiedades de CI_Upload
 *
 * @property array $data Datos del archivo subido
 * @property array $error_msg Mensajes de error
 *
 * @method bool initialize(array $config = array())
 * @method bool do_upload(string $field = 'userfile')
 * @method array data(string $index = null)
 * @method string display_errors(string $open = '<p>', string $close = '</p>')
 * @method void set_error(string $msg)
 * @method array get_multi_upload_data()
 * @method void set_filename(string $path, string $filename)
 * @method string clean_file_name(string $filename)
 */
class CI_Upload {
    /** @var array */
    public $data = [];

    /** @var array */
    public $error_msg = [];
}

/**
 * Definición de la librería Server para CodeIgniter
 *
 * @property array $INSTANCE Instancia de CodeIgniter
 * @property string $tabla Tabla principal
 * @property array $uniones Uniones de tablas
 * @property array $filtros Filtros WHERE
 * @property array $busquedas Campos para búsqueda
 * @property array $columnas Columnas del DataTable
 * @property array $resultados Resultados procesados
 */
class Server {
    /** @var bool */
    private $inicializado = false;

    /** @var CI_Controller */
    private $INSTANCE;

    /** @var string */
    private $tabla;

    /** @var array */
    private $uniones;

    /** @var array */
    private $filtros;

    /** @var array */
    private $busquedas;

    /** @var array */
    private $columnas;

    /** @var array */
    private $resultados;

    /**
     * Inicializa la clase Server con un helper específico
     * @param string $helper Nombre del helper sin la palabra 'helper'
     * @return void
     */
    public function inicializar($helper) {}

    /**
     * Obtiene los registros filtrados
     * @return array
     */
    public function registros() {}

    /**
     * Agrega una fila al conjunto de resultados
     * @param array $fila
     * @return void
     */
    public function agregar($fila) {}

    /**
     * Retorna el resultado en formato JSON para DataTables
     * @return string
     */
    public function resultado() {}
}

/**
 * Este archivo también puede ayudar a que Intelephense entienda las propiedades de CI_Model.
 *
 * @property CI_DB_mysqli_driver $db
 * @property CI_Loader $load
 */
class CI_Model {}

/**
 * Clase que ayuda a Intelephense a reconocer los métodos encadenados en CI_Output.
 *
 * @method CI_Output set_content_type(string $mime_type)
 * @method CI_Output set_output(string $output)
 */
class CI_Output {}

/**
 * Clase que ayuda a Intelephense a reconocer los métodos del Query Builder.
 *
 * @method CI_DB_mysqli_driver select(string $select = '*', bool $escape = null)
 * @method CI_DB_mysqli_driver where(string|array $key, string $value = null, bool $escape = true)
 * @method CI_DB_mysqli_driver or_where(string|array $key, string $value = null, bool $escape = true)
 * @method CI_DB_mysqli_driver where_in(string $key, array $values)
 * @method CI_DB_mysqli_driver or_where_in(string $key, array $values)
 * @method CI_DB_mysqli_driver or_like(string $field, string $match = '', string $side = 'both')
 * @method CI_DB_mysqli_driver join(string $table, string $condition, string $type = '')
 * @method CI_DB_mysqli_driver from(string $from)
 * @method CI_DB_mysqli_driver like(string $field, string $match = '', string $side = 'both')
 * @method CI_DB_mysqli_driver group_by(string $by)
 * @method CI_DB_mysqli_driver having(string $key, string $value = '', bool $escape = true)
 * @method CI_DB_mysqli_driver order_by(string $orderby, string $direction = '')
 * @method CI_DB_mysqli_driver limit(int $value, int $offset = 0)
 * @method CI_DB_mysqli_driver offset(int $offset)
 * @method CI_DB_mysqli_driver set(string|array $key, string $value = '', bool $escape = true)
 * @method mixed get(string $table = '', int $limit = null, int $offset = null)
 * @method mixed get_where(string $table = '', array $where = null, int $limit = null, int $offset = null)
 * @method int insert(string $table = '', array $set = null)
 * @method int update(string $table = '', array $set = null, mixed $where = null, int $limit = null)
 * @method int delete(string $table = '', mixed $where = '', int $limit = null, bool $reset_data = true)
 * @method string last_query()
 * @method int count_all_results(string $table = '')
 * @method int count_all(string $table = '')
 * @method bool truncate(string $table = '')
 */
class CI_DB_mysqli_driver {}