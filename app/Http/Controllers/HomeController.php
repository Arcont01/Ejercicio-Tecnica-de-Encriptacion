<?php

namespace App\Http\Controllers;

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
            $data['errors'] = $validate->errors();
            return view('home', $data);
        }

        $file = $request->file('file');
        $content =  file($file);

        $answer = $this->checkQuantities($content);

        if (array_key_exists('error', $answer)) {
            $answer['error_requirements'] = $answer['error'];
            return view('home', $answer);
        }

        $content = $answer['content'];
        $sizeThirdWord = $answer['sizeThirdWord'];

        $answer = $this->existWord($sizeThirdWord, $content);

        return view('success', $answer);
    }

    public function checkQuantities(array $content)
    {
        $quantities = array_shift($content);
        $quantities = explode(" ", $quantities);

        if (count($quantities) != 3) {
            return ['error' => 'Debe de tener 3 cantidades numericas la primera linea del archivo'];
        }

        if (count($content) != 3) {
            return ['error' => 'Debe de terner 3 frases el archivo despues de la primera linea'];
        }

        $sizeFirstWord = (int)trim($quantities[0]);
        $sizeSecondWord = (int)trim($quantities[1]);
        $sizeThirdWord = (int)trim($quantities[2]);

        foreach ($content as $key => $item) {
            $content[$key] = trim($item);
        }

        if ($sizeFirstWord < 2 || $sizeFirstWord > 50) {
            return ['error' => 'El tamaño de la primera frase debe estar entre 2 y 50 inclusive'];
            if ($sizeFirstWord != count($content[0])) {
                return ['error' => 'El tamaño dado no corresponde al tamaño de la frase'];
            }
        }

        if ($sizeSecondWord < 2 || $sizeSecondWord > 50) {
            return ['error' => 'El tamaño de la primera frase debe estar entre 2 y 50 inclusive'];
            if ($sizeSecondWord != count($content[1])) {
                return ['error' => 'El tamaño dado no corresponde al tamaño de la frase'];
            }
        }

        if ($sizeThirdWord < 3 || $sizeThirdWord > 5000) {
            return ['error' => 'El tamaño de la primera frase debe estar entre 3 y 5000 inclusive'];
            if ($sizeThirdWord != count($content[2])) {
                return ['error' => 'El tamaño dado no corresponde al tamaño de la frase'];
                if (!preg_match('/[a-zA-Z0-9]/', $content[2])) {
                    return ['error' => 'El texto encriptado unicamente puede ser alfanumerico'];
                }
            }
        }

        return ['content' => $content, 'sizeThirdWord' => $sizeThirdWord];
    }

    public function existWord(int $sizeEncryptedWord, array $content)
    {
        $arrayStringWord = str_split($content[2]);
        $newArrayString = [];
        for ($i = 0; $i < $sizeEncryptedWord; $i++) {
            if ($i == 0) {
                $newArrayString[] =  $arrayStringWord[$i];
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
        }else{
            $answers['firstPhrase'] = 'No es la primera frase';
        }

        if (strpos($newString, $secondPhrase)) {
            $answers['secondPhrase'] = 'Si es la segunda frase';
        }else{
            $answers['secondPhrase'] = 'No es la seguna frase';
        }

        return $answers;
    }
}
