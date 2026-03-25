<?php require APP_ROOT . '/views/inc/header.php'; ?>
<h1><?php echo htmlspecialchars($data['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
<ul>
<?php foreach($data['posts'] as $post) : ?>
    <li><?php echo htmlspecialchars($post->title, ENT_QUOTES, 'UTF-8'); ?></li>
<?php endforeach; ?>
</ul>
<?php require APP_ROOT . '/views/inc/footer.php'; ?>