<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? htmlspecialchars($data['title'], ENT_QUOTES, 'UTF-8') . ' | ' . SITE_NAME : SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo URL_ROOT . '/css/main.css'; ?>">
</head>
<body>