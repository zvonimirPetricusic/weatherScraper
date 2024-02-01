<?php
    $weather = "";
    $error = "";

    if(array_key_exists('city', $_GET)){
        $city = str_replace(' ', '', $_GET['city']);
        $file_headers = @get_headers('https://www.weather-forecast.com/locations/' . $city . '/forecasts/latest');

        if($file_headers[0] == "HTTP/1.1 404 Not Found"){
            $error = "That city could not be found!";
        }else{
            $forecastPage = file_get_contents('https://www.weather-forecast.com/locations/' . $city . '/forecasts/latest');

            $pageArray = explode('Weather Today</h2> (1&ndash;3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">', $forecastPage);
            $secondPageArray = explode('</span></p></td>', $pageArray[1]);

            if(sizeof($secondPageArray > 1)){
                $weather = $secondPageArray[0];
            }else{
                $error = "That city could not be found!";
            }
        }
    }else{
        $error = "That city could not be found!";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Weather Scraper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        html{
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        body{
            background: none;
        }

        .container{
            text-align: center;
            margin-top: 100px;
            width: 450px;
        }

        input{
            margin: 20px 0;
        }

        #weather{
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>What is the weather?</h1>
        <form>
            <fieldset class="form-group">
                <label for="city">Enter the name of a city</label>
                <input type="text" class="form-control" name="city" id="city" placeholder="E.g., London, Tokyo" value="<?php
                    if(array_key_exists('city', $_GET)) {
                        echo $_GET['city'];
                    }
                ?>">
            </fieldset>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <div id="weather">
            <?php 
                if($weather){
                    echo '<div class="alert alert-success" role="alert">' . $weather . '</div>';
                }else{
                    echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
                }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>