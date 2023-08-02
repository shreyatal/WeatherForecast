<?php
$weather = "";
$error = "";

if (isset($_GET["city"])) {
    $city = str_replace(' ', '', $_GET["city"]);

    $forecastpage = @file_get_contents("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
    if ($forecastpage === false) {
        $error = "There was a problem retrieving the weather information.";
    } else {
        $page = explode('(1&ndash;3 days):</div><p class="location-summary__text"><span class="phrase">', $forecastpage);
        
        if (sizeof($page) > 1) {
            $page2 = explode('</span></p></div>', $page[1]);
            
            if (sizeof($page2) > 1) {
                $weather = $page2[0];
            } else {
                $error = "Weather information not found for the specified city.";
            }
        } else {
            $error = "Weather information not found for the specified city.";
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Weather Teller</title>
    <link rel="stylesheet" type="text/css" href="w.css">
</head>
<body>
<div class="container">
    <h1>What's the weather?</h1>
    <form>
        <div class="form-group">
            <label for="city">Enter any City.</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="eg. Agra, Kanpur" value="<?php echo isset($_GET['city']) ? $_GET['city'] : ''; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div id="weather">
        <?php
        if ($weather) {
            echo '<div class="alert alert-success" role="alert">' . $weather . '</div>';
        } elseif ($error) {
            echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
        }
        ?>
    </div>
</div>
<div id="footer">
    <p><h3>&copy; Weather Teller <?php echo date("Y"); ?></h3></p>
    <p><h3>Founder <strong>Shreya Mittal</strong></h3></p>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
