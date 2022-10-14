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

            <div>
                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($images as $image)
                        <tr>
                            <td>
                                <h1>Id: {{$image->id}}</h1>
                            </td>
                            <td>
                                <img style="height: 250px; width: 250px;" src="{{asset('storage').'/'.$image->image}}" />
                            </td>
                            <td>
                                <a href="{{route('downlaod-image', $image->id)}}"> Download </a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
    </div>
</body>
</html>
