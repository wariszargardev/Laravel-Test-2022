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
    <div>
        @foreach($images as $image)
            <div>
                <h1>Id: {{$image->id}}</h1>
                <img src="{{asset('storage').'/'.$image->image}}" />
            </div>
        @endforeach
    </div>
</body>
</html>
