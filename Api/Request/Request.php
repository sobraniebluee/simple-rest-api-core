<?php



namespace Api\Request;
use Api\Interfaces\RequestInterface;

define("JSON_TYPE", "application/json");
define("FORM_URL_ENCODE_TYPE", "application/x-www-form-urlencoded");
define("FROM_DATA_TYPE", "multipart/form-data");


class Request implements RequestInterface
{
    public array $form = [];
    public string $data = "";
    public array $json = [];
    public array $files = [];
    public array $headers;
    public array $params;
    public array $query;
    public string $method;
    public string|null $contentType;

    public function __construct($params, $query)
    {
        $this->params = $params;
        $this->query = $query;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->getHeaders();
        $this->getContentType();
        $this->getBody();
    }
    public function isHeader($header): bool
    {
        return array_key_exists($header, $this->headers);
    }
    protected function getHeaders(): void
    {
        $resultHeaders = [];
        $requestHeaders = getallheaders();
        foreach ($requestHeaders as $key => $val) {
            $resultHeaders[$key] = $val;
        }
        $this->headers = $resultHeaders;
    }
    protected function getContentType(): void
    {
        if ($this->isHeader('Content-Type')) {
            $contentType = explode(";", $this->headers['Content-Type'])[0];
            $this->contentType = $contentType;
        } else {
            $this->contentType = null;
        }
    }
    protected function getBody(): void
    {
        if ($this->contentType != null) {
            $body = file_get_contents("php://input");
            if (str_contains($this->contentType,JSON_TYPE)) {
                $this->parseJsonBody($body);
            } else if (str_contains($this->contentType,FORM_URL_ENCODE_TYPE)) {
                $this->parseFormUrlEncodedBody($body);
            } else if (str_contains($this->contentType,FROM_DATA_TYPE)) {
                $this->parseFormData();
            }
            $this->data = $body;
        }
    }
    protected function parseJsonBody(string $body): void
    {
        try {
            $this->json = json_decode($body, true);
        } catch (\TypeError) {}
    }
    protected function parseFormUrlEncodedBody(string $body): void
    {
        parse_str(urldecode($body), $output);
        $this->form = $output;
    }
    protected function parseFormData(): void
    {
        $this->form = $_POST;
        $this->files = $_FILES;
    }
}