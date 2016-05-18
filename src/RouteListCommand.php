<?php

namespace Wise\Dingo\Api\Console\Commands;

use Dingo\Api\Routing\Route;
use Dingo\Api\Routing\RouteCollection;
use Dingo\Api\Routing\Router;
use Illuminate\Console\Command;



class RouteListCommand extends Command
{

	/**
	 * @var string
	 */
	protected $signature = 'route:list {version=v1}';

	/**
	 * @var string
	 */
	protected $description = 'List all registered routes';



	/**
	 * @return int
	 */
	public function fire()
	{
		$collection = $this->routeCollection(
			$this->argument('version')
		);

		if ($collection === null) {
			return 1;
		}

		$this->table(
			$this->header(),
			$this->rows($collection)
		);

		return 0;
	}



	/**
	 * @param string $version
	 * @return RouteCollection|null
	 */
	private function routeCollection($version)
	{
		/** @var Router $api */
		$api = app('api.router');

		/** @var RouteCollection $routeCollection */
		$collection = $api->getRoutes();

		if (isset($collection[$version]) === false) {
			$this->error('Version [' . $version . '] is not defined.');

			return null;
		}

		return $collection[$version];
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

		/** @var Route $route */
		foreach ($collection->getRoutes() as $route) {
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

}
