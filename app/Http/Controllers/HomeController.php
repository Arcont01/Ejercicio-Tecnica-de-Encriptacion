<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }


    public function store(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'file' => ['required', 'file', 'mimes:txt']
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors();
            throw new CustomException($errors->first());
        }

        try {
            $file = $request->file('file');
            $content = file($file);

            $answer = $this->checkQuantities($content);

            $content = $answer['content'];
            $sizeThirdWord = $answer['sizeThirdWord'];

            $answer = $this->existWord($sizeThirdWord, $content);
            return view('success', $answer);
        } catch (\Throwable $th) {
            \Log::error($th);
            throw new CustomException('A acurrido un error inesperado');
        }
    }

    public function checkQuantities(array $content)
    {

        if (count($content) > 4) {
            throw new CustomException('El archivo no debe de contener mas de 4 lineas');
        }

        $quantities = array_shift($content);
        $quantities = explode(" ", $quantities);

        if (count($quantities) != 3) {
            throw new CustomException('Debe de tener 3 cantidades numericas la primera linea del archivo');
        }

        if (count($content) != 3) {
            throw new CustomException('Debe de terner 3 frases el archivo despues de la primera linea');
        }

        $sizeFirstWord = (int)trim($quantities[0]);
        $sizeSecondWord = (int)trim($quantities[1]);
        $sizeThirdWord = (int)trim($quantities[2]);

        foreach ($content as $key => $item) {
            $content[$key] = trim($item);
        }

        $this->checkPhrase($sizeFirstWord, $content[0], 'primera');
        $this->checkPhrase($sizeSecondWord, $content[1], 'segunda');
        $this->checkPhraseEncrypted($sizeThirdWord, $content[2]);

        return ['content' => $content, 'sizeThirdWord' => $sizeThirdWord];
    }

    public function existWord(int $sizeEncryptedWord, array $content)
    {
        $arrayStringWord = str_split($content[2]);
        $newArrayString = [];
        for ($i = 0; $i < $sizeEncryptedWord; $i++) {
            if ($i == 0) {
                $newArrayString[] = $arrayStringWord[$i];
            } else {
                $j = $i - 1;
                if ($arrayStringWord[$j] != $arrayStringWord[$i]) {
                    $newArrayString[] = $arrayStringWord[$i];
                }
            }
        }

        $newString = implode($newArrayString);
        $firstPhrase = trim($content[0]);
        $secondPhrase = trim($content[1]);

        $answers = [];

        if (strpos($newString, $firstPhrase)) {
            $answers['firstPhrase'] = 'Si es la primera frase';
        } else {
            $answers['firstPhrase'] = 'No es la primera frase';
        }

        if (strpos($newString, $secondPhrase)) {
            $answers['secondPhrase'] = 'Si es la segunda frase';
        } else {
            $answers['secondPhrase'] = 'No es la seguna frase';
        }

        return $answers;
    }

    public function checkPhrase(string $sizePhrase, string $phrase, string $numberPhrase)
    {
        if (!preg_match('/^[a-zA-Z0-9]+$/', $phrase)) {
            throw new CustomException('El texto de la ' . $numberPhrase . ' frase unicamente puede ser alfanumerico');
        }

        if ($sizePhrase < 2 || $sizePhrase > 50) {
            throw new CustomException('El tamaño de la  ' . $numberPhrase . ' frase debe estar entre 2 y 50 inclusive');
        }

        if ($sizePhrase != strlen($phrase)) {
            throw new CustomException('El tamaño dado no corresponde al tamaño de la ' . $numberPhrase . ' frase');
        }
    }

    public function checkPhraseEncrypted(string $sizePhrase, string $phrase)
    {
        if (!preg_match('/^[a-zA-Z0-9]+$/', $phrase)) {
            throw new CustomException('El texto de la frase encriptada unicamente puede ser alfanumerico');
        }

        if ($sizePhrase < 3 || $sizePhrase > 5000) {
            throw new CustomException('El tamaño de la frase encriptada debe estar entre 3 y 5000 inclusive');
        }

        if ($sizePhrase != strlen($phrase)) {
            throw new CustomException('El tamaño dado no corresponde al tamaño de la frase encriptada');
        }
    }
}
