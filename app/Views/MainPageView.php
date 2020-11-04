<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bank</title>
</head>
<body>
<form action="/update" method="get">
    <button type="submit">Update</button>
</form>
<?php foreach ($rates as $rate) : ?>
    <?php echo $rate->getName() . ' / ' . $rate->getRate(); ?>
<br>
<?php endforeach; ?>
</body>
</html>