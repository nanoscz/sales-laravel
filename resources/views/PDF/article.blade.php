<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <div>
        <h3>list of article {{ now()}}</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Categoria</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Description</th>
                    <th>State</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $item)
                    <tr>
                        <td>{{ $item->code }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->stock }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->state?'Active':'Disable' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
        <p><strong>total articles:</strong>{{$count}}</p>
        </div>
    </div>
</body>
</html>