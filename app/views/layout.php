<?php
/**
 * @var $title
 * @var $content
 */
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= htmlspecialchars($title) ?></title>

    <!-- Styles -->
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/site.css">
</head>
<body class="text-center">
    <div class="flex-center position-ref full-height">
        <?= $content ?>
    </div>

</body>
</html>


