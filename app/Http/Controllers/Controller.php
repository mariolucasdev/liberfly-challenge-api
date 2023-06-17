<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Server(url="http://localhost:8000/api")
 * @OA\Info(
 *      title="Api Libertfly Posts",
 *      description="API com autenticação JWT para com as principais operações para o recuros de Posts.",
 *      version="0.0.1",
 *      termsOfService="http://swagger.io/terms/",
 *      @OA\Contact(
 *         email="mariolucasdev@gmail.com"
 *      ),
 * ),
 * @OA\SecurityScheme(
 *      type="http",
 *      scheme="bearer",
 *      securityScheme="bearerAuth"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
}
