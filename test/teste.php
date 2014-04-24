<?
define('C_PATH_RAIZ',      '../../');
define('C_PATH_VIEW',      C_PATH_RAIZ . 'views/' );
define('C_PATH_INFO',      C_PATH_RAIZ . 'info_data/' );
define('C_PATH_BOOT',      C_PATH_RAIZ . 'externos/bootstrap-3.1.1-dist/' );
define('C_PATH_ANGULAR',   C_PATH_RAIZ . 'externos/angularjs/angular.min.js' );

/**
 * Mostra o valor da variavel
 * @param $a variavel
 */
function vl($a)
{
    echo var_dump($a);
    echo "<HR>";
}

/**
 * Esta fun��o ajuda a gente a puxar as classes e ao mesmo tempo
 * utilizar o pacote do phpunit
 */
function IMAutoLoadPHPUNIT( $pClassName ) 
{
   $path = __DIR__;
   $path = str_replace( "test", "", $path );

   if ( $pClassName != 'PHPUnit_Extensions_Story_TestCase' )
   {
      if ( file_exists($path . "/" . $pClassName . ".php") )
      {
         require_once( $path . "/" . $pClassName . ".php");
      }
      else
      {
         // echo "AQUI: $pClassName \n\n\n";

         if ( file_exists( $pClassName . ".php") )
         {            
            require_once( $pClassName . ".php" );
         }
         else
         {
            // echo "\n\nN�o consegui:" .  $path . "/" . $pClassName . ".php\n\n";
         }
      }
   }

    // echo $pClassName . "\n\n";   
}

spl_autoload_register("IMAutoLoadPHPUNIT");


use imclass\banco_dados\IMConexaoAtributos;
use imclass\base\IMErro;
use imclass\imphp\IMPDOStatement;
use imclass\banco_dados\IMConexaoBancoDados;


$objIMConexaoAtributos = new IMConexaoAtributos();

$objIMConexaoAtributos->setNomeBanco("unimestre");
$objIMConexaoAtributos->setLogin("aaa");
$objIMConexaoAtributos->setSenha("aaa");
$objIMConexaoAtributos->setBanco("adriano");
$objIMConexaoAtributos->setHost("localhost");
$objIMConexaoAtributos->setPorta("");


$objIMConexaoBancoDados = new IMConexaoBancoDados();

try 
{
   $conectou = $objIMConexaoBancoDados->conectarMysql( 
      $objIMConexaoAtributos
   ); 
}
catch ( \Exception $e ) 
{
   echo 'aaa' .  $e->getMessage();
}
?>