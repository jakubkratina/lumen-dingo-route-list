<?php

namespace JK\Dingo\Api\Console\Commands;

use Dingo\Api\Routing\Route;
use Dingo\Api\Routing\RouteCollection;
use Dingo\Api\Routing\Router;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;



class RouteListCommand extends Command
{

	/**
	 * @var string
	 */
	protected $signature = 'route:list {version?}';

	/**
	 * @var string
	 */
	protected $description = 'List all registered routes';


    /**
     * @return int
     */
	public function handle()
    {
        $version = $this->argument('version');

        $collection = $this->routeCollection($version);

        if ($collection === null) {
            return 1;
        }

        $version === null
            ? $this->printAllVersions($collection)
            : $this->printVersion($collection, $version);

        return 0;
    }


	/**
     * For backward compatibility, before Lumen 5.5 was used fire method instead of handle()
	 * @return int
	 */
	public function fire()
	{
		return $this->handle();
	}



	/**
	 * @param string $version
	 * @return array|null
	 */
	private function routeCollection($version)
	{
		/** @var Router $api */
		$api = app('api.router');

		$collection = $api->getRoutes();

		if ($version !== null && isset($collection[$version]) === false) {
			$this->error('Version [' . $version . '] is not defined.');

			return null;
		}

		return $collection;
	}



	/**
	 * @return string[]
	 */
	private function header()
	{
		return ['Method', 'URI', 'Name', 'Action', 'Middleware'];
	}



	/**
	 * @param RouteCollection $collection
	 * @return array
	 */
	private function rows(RouteCollection $collection)
	{
		$rows = [];

		$routes = self::alphabetically($collection->getRoutes());

		/** @var Route $route */
		foreach ($routes as $route) {
			array_push($rows, [
				'method'     => implode(' | ', $route->getMethods()),
				'uri'        => $route->uri(),
				'name'       => $route->getName(),
				'action'     => $route->getActionName(),
				'middleware' => implode(' | ', $route->getMiddleware()),
			]);
		}

		return $rows;
	}



	/**
	 * @param array $collection
	 */
	private function printAllVersions(array $collection)
	{
		foreach ($collection as $version => $routes) {
			$this->table(['Version'], [compact('version')]);

			$this->printTable($routes);
		}
	}



	/**
	 * @param array $collection
	 * @param string $version
	 */
	private function printVersion(array $collection, $version)
	{
		$this->printTable($collection[$version]);
	}



	/**
	 * @param RouteCollection $routes
	 */
	private function printTable(RouteCollection $routes)
	{
		$this->table(
			$this->header(),
			$this->rows($routes)
		);
	}



	/**
	 * @param array $routes
	 * @return array
	 */
	private static function alphabetically(array $routes)
	{
		usort($routes, function (Route $a, Route $b) {
			return $a->uri() > $b->uri();
		});

		return $routes;
	}
}
