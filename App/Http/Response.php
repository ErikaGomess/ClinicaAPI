<?php 

namespace App\Http;

class Response {

    /**
     * Código do Status HTTP
     * @var integer
     */
    private $httpCode = 200;

    /**
     * Cabeçalho do Response
     * @var array
     */
    private $headers = [];

    /**
     * Tipo de conteúdo que está sendo retornado
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Conteúdo do Response
     * @var mixed
     */
    private $content;

    /**
     * Método reponsável por iniciar a classe e definir os valores
     * @param integer $httpCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct($httpCode, $content, $contentType = 'text/html') {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /**
     * Método responsável por alterar o content type do response
     * @param string $contentType
     */
    public function setContentType($contentType) {
        $this->contentType = $contentType;
        $this->addHeaders('Content-Type', $contentType);
    }

    /**
     * método responável por adicionar um registro no cabeçalho de response
     * @param string $key
     * @param string $value
     */
    public function addHeaders($key, $value) {
        $this->headers[$key] = $value;
    }

    /**
     * Método responsável por enviar a resposta para o usuário
     */
    private function sendHedears() {
        //STATUS
        http_response_code($this->httpCode);

        //ENVIAR HEADERS
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }

    /**
     * Método responsável por enviar a resposta para o usuário
     */
    public function sendResponse() {
        //ENVIA OS HEADERS
        $this->sendHedears();

        //IMPRIME O CONTEÚDO
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
            case 'application/json':
                echo json_encode($this->content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                exit;
        }
    }

}
