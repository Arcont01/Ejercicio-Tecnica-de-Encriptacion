<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 1</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

</head>

<body>
    <header>
        <nav class="navbar navbar-dark bg-info">
            <span class="navbar-brand mb-0 h1">Practica 1</span>
        </nav>
    </header>

    <section class="container my-5">
        <div class="row">
            <div class="col-12 mb-5">
                <form action="/" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file">Subir archivo</label>
                        <input type="file" name="file" id="file" class="form-control rounded-pill">
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill">Enviar</button>
                </form>
            </div>
            <div class="col-12">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (!isset($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                ?>
                        <div class="alert alert-danger" role="alert">
                            Error al subir archivo
                        </div>
                        <?php
                    } else {
                        $fileTempPath = $_FILES['file']['tmp_name'];
                        $fileName = $_FILES['file']['name'];
                        $fileNameCmps = explode(".", $fileName);
                        $fileExtension = strtolower(end($fileNameCmps));
                        $allowedfileExtensions = array('txt');
                        $winnerPlayers = [];
                        $differences = [];
                        if (in_array($fileExtension, $allowedfileExtensions)) {
                            $content = file($fileTempPath);
                            $quantities = array_shift($content);
                            $quantities = explode(" ", $quantities);
                            
                            $arrayString = str_split($content[2]);
                            
                            $newArrayString = [];
                            for ($i = 0; $i < (int)$quantities[2]; $i++) {
                                if ($i == 0) {
                                    $newArrayString[] =  $arrayString[$i];
                                } else {
                                    $j = $i - 1;
                                    if ($arrayString[$j] != $arrayString[$i]) {
                                        $newArrayString[] = $arrayString[$i];
                                    }
                                }
                            }
                            $newString = implode($newArrayString);
                            $firstPhrase = trim($content[0]);
                            $secondPhrase = trim($content[1]);
                        ?>
                            <div class="alert alert-info m-3" role="alert">
                                Frase uno: <?php echo $firstPhrase; ?> <br>
                                Frase dos: <?php echo $secondPhrase; ?> <br>
                                Texto encriptado: <?php echo $content[2]; ?> <br>
                                Texto desencriptado: <?php echo $newString; ?> <br>
                            </div>
                            <?php
                            if (strpos($newString, $firstPhrase)) {
                            ?>
                                <div class="alert alert-success m-3" role="alert">
                                    El texto <?php echo $firstPhrase . ' ' . $newString; ?> esta en el texto encriptado
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="alert alert-danger m-3" role="alert">
                                    El texto <?php echo $firstPhrase; ?> no esta en el texto encriptado
                                </div>
                            <?php
                            }

                            if (strpos($newString, $secondPhrase)) {
                                ?>
                                    <div class="alert alert-success m-3" role="alert">
                                        El texto <?php echo $secondPhrase; ?> esta en el texto encriptado
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-danger m-3" role="alert">
                                        El texto <?php echo $secondPhrase; ?> no esta en el texto encriptado
                                    </div>
                                <?php
                                }
                        } else {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                El archivo debe ser tipo .txt
                            </div>
                <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
    </section>
</body>

</html>