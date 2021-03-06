<?php
namespace test\imclass\apps;

use imclass\apps\AppExecucoes;

use imclass\entidades\internos\execucoes\IMExecucoes;
use imclass\repositorios\internos\execucoes\IMExecucoesRespositorio;

// conexao com o banco de testes
use test\imclass\banco_dados\IMDoctrineTest;

class AppExecucoesTest extends \PHPUnit_Framework_TestCase
{
    var $objAppExecucoes;
    var $classe_teste;

    public function __construct()
    {
        $this->objAppExecucoes = new AppExecucoes();
        $this->classe_teste = 'UnitTestApagar';
    }

    public function apagarExecucaoTest()
    {        
        $this->objAppExecucoes
            ->apagarExecucaoPorCodigo(
                1
            );
    }

    public function registerDoctrineTest()
    {
        $objIMDoctrineTest = new IMDoctrineTest();
        $objIMDoctrine = $objIMDoctrineTest->getObjTest();

        $this->objAppExecucoes
            ->registerDoctrine($objIMDoctrine);

        $this->assertEquals(
            'imclass\banco_dados\IMDoctrine',
            get_class($this->objAppExecucoes->getIMDoctrine())
        );

        // apaga todas as execuções
        $this->objAppExecucoes
            ->apagarExecucao(
                $this->classe_teste, 
                $this->classe_teste
            );
    }

    public function testGetExecucoes()
    {
        // inicia conexao
        $this->registerDoctrineTest();

        $this->objAppExecucoes
            ->apagarExecucaoPorCodigo(
                1
            );

        // cria objeto
        $objIMExecucoes = $this->criaTest();

        // salva objeto
        $objIMDoctrine = $this->objAppExecucoes
            ->getIMDoctrine();

        $objIMDoctrine->persist($objIMExecucoes);
        $objIMDoctrine->flush();

        // teste
        $ds_nome_classe = $this->classe_teste;
        $ds_path_classe = $this->classe_teste;

        $arrObjs = $this->objAppExecucoes
            ->getExecucoes(
                $ds_nome_classe,
                $ds_path_classe
            );

        $this->assertEquals(
            'imclass\entidades\internos\execucoes\IMExecucoes',
            get_class($arrObjs[ 0 ])
        );
    }

    public function testGetExecucaoFromCodigo()
    {
        // inicia conexao
        $this->registerDoctrineTest();

        $this->objAppExecucoes
            ->apagarExecucaoPorCodigo(
                1
            );

        // cria objeto
        $objIMExecucoes = $this->criaTest();
        $objIMExecucoes->setCdExecucao(1);

        // salva objeto
        $objIMDoctrine = $this->objAppExecucoes
            ->getIMDoctrine();

        $objIMDoctrine->persist($objIMExecucoes);
        $objIMDoctrine->flush();

        // teste
        $ds_nome_classe = $this->classe_teste;
        $ds_path_classe = $this->classe_teste;

        $arrObjs = $this->objAppExecucoes
            ->getExecucaoFromCodigo(
                1
            );

        $this->assertEquals(
            // 'imclass\entidades\internos\execucoes\IMExecucoes',
            'test\imclass\apps\AppExecucoesTest',
            get_class($arrObjs[ 0 ])
        );
    }


    /**
     * mock
     */
    public function criaTest()
    {
        $objIMExecucoes = new IMExecucoes();

        $objIMExecucoes->setCdExecucao(1);

        $objIMExecucoes->setDsNomeClasse(
            $this->classe_teste
        );

        $objIMExecucoes->setDsPathClasse(
            $this->classe_teste
        );

        $objIMExecucoes->setDtExecucao(
            new \DateTime("now")
        );

        return $objIMExecucoes;
    }


    /**
     * finaliza este test limpando tudo
     */
    public function tearDown()
    {
        $this->apagarExecucaoTest();
    }
}