<?
use imclass\apps\AppConcreto;
use imclass\apps\inputs\InputText;
use imclass\apps\inputs\InputConexoesMysql;
use imclass\uteis\base\IMGetConexaoBancoFromNome;
use imclass\conversores\imarray\IMArrayToHTMLTable;

/**
 * Recupera os grupos usados no sistema de estagios
 */
class getGruposSistemaEstagio extends AppConcreto
{

    /**
     * Construtor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDescricao('Recupera os grupos usados no sistema de estagios');
        $this->setCampos();
    }

    /**
     * Cria os campos necessários
     */
    public function setCampos()
    {
        $objInputConexoesMysql = new InputConexoesMysql();
        $objInputConexoesMysql->setNome('nm_obj_conexao');

        $this->getObjAppInputs()->addInput($objInputConexoesMysql);
    }

    /**
     * Executa a função
     */
    public function executar()
    {
        $retorno = '';
        $cd_estagio = $this->getObjAppInputs()->getInputValor('cd_estagio');
        $nm_obj_conexao = $this->getObjAppInputs()->getInputValor('nm_obj_conexao');

        $objIMConexaoBancoDados = IMGetConexaoBancoFromNome::getConexao($nm_obj_conexao);

        if ($objIMConexaoBancoDados != null) {
            $this->query = "
            select
               *
            from
               nu_grupos
            where
               ds_papel in (
                  'USUARIO',
                  'FUNCIONARIO',
                  'EMPRESAS',
                  'C_ESTNC_TPESS_TI_IE',
                  'C_ESTNC_TPESS_SUPERV',
                  'C_ESTNC_TPESS_REPRE_IE',
                  'C_ESTNC_TPESS_REPRE_CONTAT',
                  'C_ESTNC_TPESS_REPRE_CONCE',
                  'C_ESTNC_TPESS_ORIENT_EST',
                  'C_ESTNC_TPESS_GER_ACAD',
                  'C_ESTNC_TPESS_AI',
                  'ALUNO',
                  'ADMIN'
               )
            Group by
               ds_papel
            order by
               cd_grupo
         ";


            $arrValores = $objIMConexaoBancoDados->query($this->query);
            $this->setResultado($arrValores);
        }
    }

    public function getResultadoOutput()
    {
        $arrValores = $this->getResultado();
        $objIMArrayToHTMLTable = new IMArrayToHTMLTable();

        $objIMHtmlTable = $objIMArrayToHTMLTable->convertTabelaHorizontal(
            $arrValores
        );

        $html = $this->getHTML(
            $objIMHtmlTable
        );

        $html .= "<BR> " . $this->query;

        return $html;
    }


    private function getHTML($objIMHtmlTable)
    {

        $objIMHtmlTable->setAttr(' class="table" ');

        $html = '
         <div class="panel panel-default">         
         <div class="panel-heading">Resultado</div>
      ';

        $html .= $objIMHtmlTable->getHTML();
        $html .= '</div>';

        return $html;
    }
}

?>