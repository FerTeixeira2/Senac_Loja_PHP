<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css">
    <title>Cidade</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #768185;
        }

        .content-container {
            width: 90%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 45px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .header-title {
            font-size: 1.5rem;
            color: #333;
            text-align: center;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 1rem;
            color: #333;
            margin-bottom: 5px;
        }

        .input-text {
            padding: 8px;
            font-size: 1rem;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 200px;
        }

        .submit-button {
            padding: 8px 12px;
            font-size: 1rem;
            color: #fff;
            background-color: #050a1c;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .submit-button:hover {
            background-color: #48a;
        }

        .main-content {
            text-align: center;
            margin-top: 20px;
        }

        .city-title, .air-quality {
            color: #333;
        }

        .table-container {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-header {
            color: white;
        }

        .table-cell, .table-header-cell {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .table-row:nth-child(even) {
            background-color: #f9f9f9;
        }

        .muito-bom { background-color: #69db69; }    
        .bom { background-color: #b2e0b2; } 
        .moderada { background-color: #eda155; } 
        .ruim { background-color: #db5837; }    
        .horrivel { background-color: #e83c3c; } 

        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
    <script>
        window.onload = function() {
            if (performance.navigation.type === 1) {
                window.location.href = 'index.php';
            }
        };
    </script>
</head>
<body>
    <div class="content-container">
        <header>
            <h1 class="header-title">Pesquise aqui a cidade que deseja verificar a poluição do ar</h1>
        </header>
        <div class="form-container">
            <form method="POST">
                <label for="buscar" class="form-label">Digite aqui o nome da Cidade:</label>
                <input type="text" name="buscar" id="buscar" class="input-text">
                <button type="submit" class="submit-button">Buscar</button>
            </form>
            <?php
            $qualidade = '';
            $gas = [];
            $errorMessage = ''; 
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (empty($_POST['buscar'])) { 
                    $errorMessage = "Por favor, digite o nome de uma cidade!";
                } else {
                    $name = str_replace(" ", "_", htmlspecialchars($_POST['buscar']));

                    $curl = curl_init();
                    curl_setopt_array($curl, [
                        CURLOPT_URL => "http://api.openweathermap.org/geo/1.0/direct?q=".$name. "&limit=1&appid=78c11097f6abc26f902c5a84bd31b8c3",
                        CURLOPT_RETURNTRANSFER => true
                    ]);

                    $response = curl_exec($curl);
                    curl_close($curl);
                    $cidades = json_decode($response, true);

                    if (!empty($cidades)) {
                        foreach ($cidades as $cidade) {
                            $lat = $cidade['lat'];
                            $lon = $cidade['lon'];
                            $nomeCidade = $cidade['name'];

                            $curl = curl_init();
                            curl_setopt_array($curl, [
                                CURLOPT_URL => "http://api.openweathermap.org/data/2.5/air_pollution?lat=" .$lat. "&lon=" .$lon. "&appid=2bfcecf82ccbcc074f22bdef6e2540b9",
                                CURLOPT_RETURNTRANSFER => true
                            ]);

                            $airResponse = curl_exec($curl);
                            curl_close($curl);

                            $air = json_decode($airResponse, true);

                            if (!empty($air['list'])) {
                                $qualidadeAr = $air['list'][0]['main']['aqi'];
                                $gas = $air['list'][0]['components'];

                                switch($qualidadeAr) {
                                    case 1:
                                        $qualidade = "Muito Bom";
                                        $class = "muito-bom";
                                        break;
                                    case 2:
                                        $qualidade = "Bom";
                                        $class = "bom";
                                        break;
                                    case 3:
                                        $qualidade = "Moderada";
                                        $class = "moderada";
                                        break;
                                    case 4:
                                        $qualidade = "Ruim";
                                        $class = "ruim";
                                        break;
                                    case 5:
                                        $qualidade = "Horrível";
                                        $class = "horrivel";
                                        break;
                                }
                            } else {
                                $errorMessage = "Não consegui encontrar a qualidade do ar!";
                            }
                        }
                    } else {
                        $errorMessage = "Não encontrei nenhuma cidade!";
                    }
                }
            }
            ?>
            <?php if ($errorMessage): ?>
                <div class="error-message"><?= $errorMessage ?></div>
            <?php endif; ?>
        </div>
        <?php if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['buscar']) && !empty($cidades) && empty($errorMessage)) :?>
        <main class="main-content">

            <div id="lat"><?=$lat?></div>
            <div id="lon"><?=$lon?></div>

            <div>
                <h1 class="city-title">CIDADE: <?= $nomeCidade ?></h1>
            </div>
            <div>
                <h2 class="air-quality">Índice de qualidade do ar: <?= $qualidade ?></h2>
                <h3>Componentes de poluição:</h3>
                <table class="table-container">
                    <thead>
                        <tr class="table-header">
                            <th class="table-header-cell <?= $class ?>">PM2.5</th>
                            <th class="table-header-cell <?= $class ?>">PM10</th>
                            <th class="table-header-cell <?= $class ?>">NO2</th>
                            <th class="table-header-cell <?= $class ?>">SO2</th>
                            <th class="table-header-cell <?= $class ?>">O3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-row">
                            <td class="table-cell"><?= $gas['pm2_5'] ?? 'N/A' ?></td>
                            <td class="table-cell"><?= $gas['pm10'] ?? 'N/A' ?></td>
                            <td class="table-cell"><?= $gas['no2'] ?? 'N/A' ?></td>
                            <td class="table-cell"><?= $gas['so2'] ?? 'N/A' ?></td>
                            <td class="table-cell"><?= $gas['o3'] ?? 'N/A' ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
                <div id="map"></div>
        </main>
        <?php endif; ?>
    </div>
</body>
<script src="javascript/script.js"></script>
</html>