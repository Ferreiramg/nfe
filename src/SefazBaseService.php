<?php

namespace NFe;

/**
 * Description of NFeServiceBase
 *
 * @codeCoverageIgnore
 * @author Luis
 */
class SefazBaseService
{

    const URL = 'http://www.portalfiscal.inf.br/nfe';
    const TYPE_HOMOLOGACAO = 2;
    const TYPE_PRODUCAO = 1;
    const VERSION_NFE = '3.10';
    const URL_SERVICE_FILE = URL_SERVICE_FILE;

    private $uf;
    public $type;
    public $cUF;
    private static $usageservices = array(
        'recepcao' => 'RecepcaoEvento',
        'inutilizar' => 'NfeInutilizacao',
        'consultar' => 'NfeConsulta',
        'status' => 'NfeStatusServico',
        'cadastro' => 'CadConsultaCadastro',
        'protocolo' => 'NfeConsultaProtocolo',
        'autorizar' => 'NfeAutorizacao',
        'recibo' => 'NfeRetAutorizacao'
    );
    private static $codeUF = array('AC' => '12',
        'AL' => '27', 'AM' => '13', 'AP' => '16',
        'BA' => '29', 'CE' => '23', 'DF' => '53',
        'ES' => '32', 'GO' => '52', 'MA' => '21',
        'MG' => '31', 'MS' => '50', 'MT' => '51',
        'PA' => '15', 'PB' => '25', 'PE' => '26',
        'PI' => '22', 'PR' => '41', 'RJ' => '33',
        'RN' => '24', 'RO' => '11', 'RR' => '14',
        'RS' => '43', 'SC' => '42', 'SE' => '28',
        'SP' => '35', 'TO' => '17', 'SVAN' => '91');
    private static $evento = array(
        '110110' => 'Carta de Correcao',
        '110111' => 'Cancelamento',
        '110140' => 'EPEC',
        '111501' => 'Pedido de Prorrogacao',
        '111502' => 'Cancelamento de Pedido de Prorrogacao',
        '210200' => 'Confirmacao da Operacao',
        '210210' => 'Ciencia da Operacao',
        '210220' => 'Desconhecimento da Operacao',
        '210240' => 'Operacao nao Realizada'
    );

    public function __construct($uf, $type = self::TYPE_HOMOLOGACAO)
    {
        $this->cUF = (int) $this->getUfCode($uf); //validate
        $this->uf = (string) strtoupper($uf);
        $this->type = (int) $type;
    }

    public static function getServiceByName($nameservice)
    {
        if (isset(self::$usageservices[$nameservice])) {
            return self::$usageservices[$nameservice];
        }
        throw new \InvalidArgumentException(sprintf("Serviço %s não é valido!", $nameservice));
    }

    public static function getUfCode($uf)
    {
        if (isset(self::$codeUF[strtoupper($uf)])) {
            return self::$codeUF[strtoupper($uf)];
        }
        throw new \InvalidArgumentException(sprintf("Estado %s não existe!", $uf));
    }

    public static function getEvent($evento)
    {
        if (isset(self::$evento[$evento])) {
            return [$evento, self::$evento[$evento]];
        }
        throw new \InvalidArgumentException(sprintf("Evento %s não encontrado!", $evento));
    }

    public function getServiceWsdl($servicename)
    {
        $loadconfig = $this->loadXmlConfig();
        $service = self::getServiceByName($servicename);
        return sprintf('%s/wsdl/%s', self::URL, $loadconfig->{$service}->attributes()->operation);
    }

    /**
     * 
     * @return SimpleXMLElement 
     */
    public function serviceConfig()
    {
        $xml = new \SimpleXMLElement(self::URL_SERVICE_FILE, 0, true);
        return $xml->xpath(sprintf(
                    '/WS/UF[sigla="%s"]/%s', $this->uf, $this->getAmbiente()
            ))[0];
    }

    private function getAmbiente()
    {
        return $this->type === 1 ? 'producao' : 'homologacao';
    }
}
