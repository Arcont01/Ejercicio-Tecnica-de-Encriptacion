<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\UploadedFile;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;


class EncriptionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testApplication()
    {
        $homeController = new HomeController();
        $responseCheckRounds = $homeController->checkQuantities(['11 15 38', 'CeseAlFuego', 'CorranACubierto', 'XXcaaamakkCCessseAAllFueeegooDLLKmmNNN']);

        $this->assertArrayHasKey('content', $responseCheckRounds);
        $this->assertArrayHasKey('sizeThirdWord', $responseCheckRounds);

        $responseCheckRounds = $homeController->existWord(38, ['CeseAlFuego', 'CorranACubierto', 'XXcaaamakkCCessseAAllFueeegooDLLKmmNNN']);

        $this->assertArrayHasKey('firstPhrase', $responseCheckRounds);
        $this->assertArrayHasKey('secondPhrase', $responseCheckRounds);
    }
}
