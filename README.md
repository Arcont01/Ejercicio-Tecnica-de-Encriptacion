# Descripción  

Existe una técnica de encriptación que ocupa una agencia para poder enviar instrucciones a sus agentes. Para enviar una instrucción, la agencia transmite un mensaje donde la instrucción aparece entre otros caracteres. Por ejemplo la instrucción CeseAlFuego puede ser enviada como XcamakCeseAlFuegoDLKmN. Al recibir el mensaje, los agentes (con la ayuda de un libro con todas las instrucciones posibles) determinan cual es la instrucción escondida en el mensaje. Máximo existe una instrucción escondida por mensaje aunque es posible que no haya ninguna instrucción en el mensaje.Desafortunadamente el transmisor que ocupan para el envío de los mensajes tiene una falla. En lugar de enviar los caracteres una sola vez, esta enviándolos una, dos o hasta tres veces. Por ejemplo, el mensaje anterior pudiera ser enviado así: XXcaaamakkCCessseAAllFueeegooDLLKmmNNN. Esto hace que sea más difícil para los agentes el encontrar una instrucción. (Nota: Ninguna instrucción en el libro de instrucciones contiene dos letras iguales seguidas)El programa recibe dos instrucciones y un mensaje, y el resultado debe ser si existe o no una instrucción escondida en el mensaje.

## Requerimientos

* PHP >= 7.3
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension

## Instrucciones de ejecucion

1. Ingresar al directorio del proyecto
2. Copiar el archivo .env.example a .env `cp .env.exampe .env`
3. Instalar paquetes del proyecto con composer `composer install`
4. Ver el proyecto en el servidor que se tiene en la maquina o correr el server con `php -S localhost:8000 -t public`

## Testing

1. Ingresar al directorio del proyecto
2. Correr pruebas con el comando `vendor/bin/phpunit`

## Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
