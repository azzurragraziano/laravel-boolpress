<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>C'è un nuovo post</h1>

    <div>il titolo del post è "{{$new_post->title}}"</div>

    <a href="{{route('admin.posts.show', ['post' => $new_post->id])}}">clicca qui per vedere le informazioni a riguardo</a>
</body>
</html>