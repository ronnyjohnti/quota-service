<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\Contract\ConfigInterface;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Contract\ResponseInterface;

/** @TODO: Estudar se existe uma maneira melhor de fazer isso */

#[Controller]
class IndexController extends AbstractController
{
    #[GetMapping(path: '')]
    public function index(): ResponseInterface
    {
        $this->response->write(<<<'HTML'
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
      name="description"
      content="SwaggerUI"
    />
    <title>SwaggerUI</title>
    <link rel="stylesheet" href="https://unpkg.hyperf.wiki/swagger-ui-dist@4.5.0/swagger-ui.css" />
  </head>
  <body>
  <div id="swagger-ui"></div>
  <script src="https://unpkg.hyperf.wiki/swagger-ui-dist@4.5.0/swagger-ui-bundle.js" crossorigin></script>
  <script src="https://unpkg.hyperf.wiki/swagger-ui-dist@4.5.0/swagger-ui-standalone-preset.js" crossorigin></script>
  <script>
    window.onload = () => {
      window.ui = SwaggerUIBundle({
        url: GetQueryString("search"),
        dom_id: '#swagger-ui',
        presets: [
          SwaggerUIBundle.presets.apis,
          SwaggerUIStandalonePreset
        ],
        layout: "StandaloneLayout",
      });
    };
    function GetQueryString(name) {
      var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
      var r = window.location.search.substr(1).match(reg); //获取url中"?"符后的字符串并正则匹配
      var context = "";
      if (r != null)
        context = decodeURIComponent(r[2]);
      reg = null;
      r = null;
      return context == null || context == "" || context == "undefined" ? "/http.json" : context;
    }
  </script>
  </body>
</html>
HTML);
        return $this->response;
    }

    #[GetMapping(path: '/http.json')]
    public function json(): \Psr\Http\Message\ResponseInterface
    {
        $swaggerConfig = $this->container->get(ConfigInterface::class)->get('swagger');
        $jsonFilename = $swaggerConfig['json_dir'] . '/http.json';
        return $this->response->raw(file_get_contents($jsonFilename));
    }
}
