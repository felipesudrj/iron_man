<?
define('C_PATH', '../');
define('C_PATH_VIEW', C_PATH . 'views/' );
define('C_PATH_CLASS', C_PATH . 'class/' );
define('C_PATH_INFO', C_PATH . 'info_data/' );
define('C_PATH_TEST', C_PATH . 'test/' );
define('C_PATH_BOOT', C_PATH . 'externos/bootstrap-3.1.1-dist/' );
define('C_PATH_ANGULAR', C_PATH . 'externos/angularjs/angular.min.js' );

/**
 * Mostra o valor da variavel
 * @param $a variavel
 */
function vl($a)
{
    echo var_dump($a);
    echo "<HR>";
}
?>