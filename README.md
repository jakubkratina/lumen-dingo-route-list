# lumen-dingo-route-list
Route:list command support at Lumen framework application with Dingo API framework

## Installation

Install via composer:

```
composer require jakubkratina/lumen-dingo-route-list
```

Just register the command inside `$commands` array at `app/Console/Kernel.php` file:

```php
protected $commands = [
	JK\Dingo\Api\Console\Commands\RouteListCommand::class
];
```

## Run

Open your terminal and type `artisan route:list` to see output like:

```
+---------+
| Version |
+---------+
| v1      |
+---------+
+------------+---------------------------+------------------+-----------------------------------------------+-----------------+
| Method     | URI                       | Name             | Action                                        | Middleware      |
+------------+---------------------------+------------------+-----------------------------------------------+-----------------+
| GET | HEAD | api/albums                | albums.index     | App\Http\Controllers\AlbumController@index    | api.controllers |
| GET | HEAD | api/categories            | categories.index | App\Http\Controllers\CategoryController@index | api.controllers |
| GET | HEAD | api/properties            | properties.index | App\Http\Controllers\PropertyController@index | api.controllers |
| GET | HEAD | api/albums/{album}        | albums.show      | App\Http\Controllers\AlbumController@show     | api.controllers |
| GET | HEAD | api/groups/{group}        | groups.show      | App\Http\Controllers\GroupController@show     | api.controllers |
| GET | HEAD | api/properties/{property} | properties.show  | App\Http\Controllers\PropertyController@show  | api.controllers |
+------------+---------------------------+------------------+-----------------------------------------------+-----------------+
+---------+
| Version |
+---------+
| v2      |
+---------+
+------------+---------+------+---------+-----------------+
| Method     | URI     | Name | Action  | Middleware      |
+------------+---------+------+---------+-----------------+
| GET | HEAD | api/foo |      | Closure | api.controllers |
+------------+---------+------+---------+-----------------+

```

### Version argument

You can also specify your API version: `artisan route:list v2`.

```
+------------+---------+------+---------+-----------------+
| Method     | URI     | Name | Action  | Middleware      |
+------------+---------+------+---------+-----------------+
| GET | HEAD | api/foo |      | Closure | api.controllers |
+------------+---------+------+---------+-----------------+
```
