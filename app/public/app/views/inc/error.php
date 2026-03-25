<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error | <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo URL_ROOT . '/css/main.css'; ?>">
</head>
<body>
    <h1><?php echo htmlspecialchars($errorCode, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></p>
</body>
</html>
