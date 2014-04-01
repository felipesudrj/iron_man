<?php
namespace test\imclass\apps\inputs;

use imclass\apps\inputs\iInput;
use imclass\apps\inputs\InputConexoesMysql;

use org\bovigo\vfs\vfsStream;

class InputConexoesMysqlTest extends \PHPUnit_Framework_TestCase
{
   var $objInputConexoesMysql;
   var $arrArquivosTest;

   // cria a classe mockada
   public function setUp()
   {
      $this->objInputConexoesMysql = new InputConexoesMysql();     

      // criando o mock
      $dir_test     = 'exemplo_dir';  
      $nome_arquivo = 'arquivo.txt';    

      $dir_mock = vfsStream::setup($dir_test);

      vfsStream::newFile( $nome_arquivo )
         ->at( $dir_mock )
         ->setContent("The new contents of the file");

      $this->objInputConexoesMysql->setDirConexoes( vfsStream::url($dir_test) ); 

      $this->arrArquivosTest = array(
         0 => $nome_arquivo
      );
   }

   public function dadosParaTeste()
   {
      return array( array( 'nome' ) );
   }

   /**
    * @dataProvider dadosParaTeste
    */
   public function testsetNome( $nome )
   {      
      $this->objInputConexoesMysql->setNome( $nome );

      $this->assertEquals( $this->objInputConexoesMysql->getNome(), $nome );   
   }

   /**
    * @depends testsetNome
    * @dataProvider dadosParaTeste
    */
   public function testgetNome( $nome ) 
   {      
      $this->objInputConexoesMysql->setNome( $nome );
      $this->assertEquals( $this->objInputConexoesMysql->getNome(), $nome );   
   }

   /**
    * @depends testsetNome
    * @dataProvider dadosParaTeste
    */
   public function testsetLabel( $nome )
   {
      $this->objInputConexoesMysql->setLabel( $nome );

      $this->assertEquals( $this->objInputConexoesMysql->getLabel(), $nome );   
   }

   /**
    * @depends testsetNome
    * @dataProvider dadosParaTeste
    */
   public function testgetLabel( $nome )
   {
      $this->objInputConexoesMysql->setLabel( $nome );
      $this->assertEquals( $this->objInputConexoesMysql->getLabel(), $nome );   
   }

   public function testgetAllConexoes()
   {
      $this->assertEquals( $this->objInputConexoesMysql->getAllConexoes(), $this->arrArquivosTest );
   }

   /**
    * @depends testgetNome
    * @depends testgetLabel
    * @dataProvider dadosParaTeste
    */
   public function testgetComponente( $nome )
   {
      $this->objInputConexoesMysql->setLabel( $nome );
      $this->objInputConexoesMysql->setNome( $nome );

      $campo = '
      <div class="row">
      <div class="col-lg-6">
      <div class="input-group">
      <div class="input-group-btn">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Conexões<span class="caret">
      </span></button>
      <ul class="dropdown-menu">
      ';

      foreach ( $this->arrArquivosTest as $key => $value ) 
      {
         $campo .= '<li><a href="#" onclick="$(\'#'. $nome . '\').val(\''. $value .'\');">'. $value .'</a></li>';
      }

      $campo .= '
      </ul>
      </div>
      <!-- /btn-group -->
      <input type="text" class="form-control" id="'. $nome .'" name="'. $nome .'">
      </div><!-- /input-group -->
      </div><!-- /.col-lg-6 -->
      ';

      $this->assertEquals( $this->objInputConexoesMysql->getComponente(), $campo );   
   }

   public function testgetTipo()
   {
      return $this->assertEquals( $this->objInputConexoesMysql->getTipo(), 'InputConexoesMysql' );
   }
}
?>