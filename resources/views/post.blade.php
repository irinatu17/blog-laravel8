<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="/assets/css/app.css">
<title>My Post</title>
</head>
<body>
    <article>
        <h1><?= $post->title; ?></h1>
    <div>
    <?= $post->body; ?>

    </div>
    </article>
    
    <a href="/">Go back</a>

</body>
</html>