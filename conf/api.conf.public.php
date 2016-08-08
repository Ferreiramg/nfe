<?php

/**
 * Arquivo necessario apenas em producao!
 * ATENCAO: ARQUIVO CONTEM INFORMACOES SENCIVEIS E DE CONTEUDO PARTICULAR.
 * NUNCA ENVIE O MESMO EM PULLREQUEST PARA SERVIDOR GIT PUBLICO. 
 * LEMBRE-SE DE MANTE-LO SEMPRE NO .gitignore
 */
date_default_timezone_set('America/Sao_Paulo');

define('LOCAL_CERT', __DIR__ . '/certs.pfx');
define('PASSW_CERT', '123456');
define('LOCAL_TEMPLATE_NFE', '');
define('LOCAL_TEMPLATE_DANFE', '');
define('LOCAL_SCHEMAS', dirname(__DIR__) . '/PL_008i2/'); //caminho para os schemas xsd NFE
define('WKHTMLTOPDF_BIN', 'wkhtmltopdf');
define('URL_SERVICE_FILE', __DIR__.'/url-services.xml');
