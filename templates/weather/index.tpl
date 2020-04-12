<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="form">
        <form action="<?=$action?>">
            <label>
                City:
                <input type="text" value="<?=$weatherCity?>" name="weather-city"><br>
            </label>
            <label>
                Region:
                <input type="text" value="<?=$weatherRegion?>" name="weather-region"><br>
            </label>
            <label>
                Country code:
                <input type="text" value="<?=$weatherCountry?>" name="weather-country"><br>
            </label>
            <input type="submit" name="formWeather" value="Submit">
        </form>
    </div>
    <div class="weather">
        <?if($isError):?>
            <p><?=$errorMessage?></p>
        <?else:?>
            <p>current city: <?=$cityName?></p>
            <p>current temperature: <?=$temp?> &deg;C feels like: <?=$feelsLikeTemp?> &deg;C</p>
            <p>wind speed: <?=$speedWind?> meter/sec</p>
            <p>humidity: <?=$humidity?> &#37;</p>
            <p>pressure: <?=$pressure?> mmHg</p>
            <div>
                <p>description weather:&nbsp;
                    <?foreach($weathers as $weather):?>
                    <?=$weather['description']?> <img src="<?=$weather['iconPath']?>" alt="<?=$weather['main']?>">
                    <?endforeach;?>
                </p>
            </div>
            <?if (!empty($weatherTip)):?>
            <p>weather tips: <?=$weatherTip?></p>
            <?endif;?>
        <?endif;?>
    </div>
</body>
</html>