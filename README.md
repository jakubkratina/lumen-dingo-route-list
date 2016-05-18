# lumen-dingo-route-list
Route:list command support at Lumen framework application with Dingo API framework

## Installation

Just register the command to `$commands` array inside `app/Console/Kernel.php` file.

```php
protected $commands = [
	Wise\Dingo\Api\Console\Commands\RouteListCommand::class
];
```

## Run

Open your terminal and type `artisan route:list` to see output like:

```
+------------+--------------------+--------------+--------------------------------------------+-----------------+
| Method     | URI                | Name         | Action                                     | Middleware      |
+------------+--------------------+--------------+--------------------------------------------+-----------------+
| GET | HEAD | api/albums         | albums.index | App\Http\Controllers\AlbumController@index | api.controllers |
| GET | HEAD | api/albums/{album} | albums.show  | App\Http\Controllers\AlbumController@show  | api.controllers |
+------------+--------------------+--------------+--------------------------------------------+-----------------+
```

### Version argument

You can also specify your API version: `artisan route:list v2`.