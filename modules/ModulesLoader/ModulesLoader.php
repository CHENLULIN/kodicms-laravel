<?php namespace KodiCMS\ModulesLoader;

use Profiler;
use KodiCMS\Support\Helpers\File;
use Illuminate\Contracts\Foundation\Application;
use KodiCMS\ModulesLoader\Contracts\ModuleContainerInterface;

class ModulesLoader
{
	/**
	 * @var
	 */
	public static $defaultContainerClass = \KodiCMS\ModulesLoader\ModuleContainer::class;

	/**
	 * @var array
	 */
	protected $registeredModules = [];

	/**
	 * @param array $modulesList
	 */
	public function __construct(array $modulesList)
	{
		foreach ($modulesList as $moduleName => $modulePath)
		{
			$moduleNamespace = null;

			if (is_array($modulePath))
			{
				$moduleNamespace = array_get($modulePath, 'namespace');
				$modulePath = array_get($modulePath, 'path');
			}
			else if (is_numeric($moduleName))
			{
				$moduleName = $modulePath;
				$modulePath = null;
			}

			if (is_null($modulePath))
			{
				$modulePath = base_path('modules' . DIRECTORY_SEPARATOR . $moduleName);
			}

			$this->addModule($moduleName, $modulePath, $moduleNamespace);
		}

		$this->addModule('App', base_path(), '');
	}

	/**
	 * @return array
	 */
	public function getRegisteredModules()
	{
		return $this->registeredModules;
	}

	/**
	 * @param string $moduleName
	 *
	 * @return ModuleContainerInterface|null
	 */
	public function getRegisteredModule($moduleName)
	{
		return array_get($this->getRegisteredModules(), $moduleName);
	}

	/**
	 * @param string $moduleName
	 * @param string|null $modulePath
	 * @param string|null $namespace
	 * @param string|null $moduleContainerClass
	 * @return $this
	 */
	public function addModule($moduleName, $modulePath = null, $namespace = null, $moduleContainerClass = null)
	{
		$token = Profiler::start('Modules Loader', $moduleName);

		if (is_null($namespace))
		{
			$namespace = 'KodiCMS\\' . $moduleName;
		}

		$namespace = trim($namespace, '\\');

		if (is_null($moduleContainerClass))
		{
			$moduleContainerClass = '\\' . $namespace . '\\ModuleContainer';
		}

		$defaultModuleClass = '\\KodiCMS\\ModulesLoader\\' . $moduleName . 'ModuleContainer';

		if (!class_exists($moduleContainerClass))
		{
			$moduleContainerClass = class_exists($defaultModuleClass)
				? $defaultModuleClass
				: static::$defaultContainerClass;
		}

		$moduleContainer = new $moduleContainerClass($moduleName, $modulePath, $namespace);

		$this->registerModule($moduleContainer);

		Profiler::stop($token);

		return $this;
	}

	/**
	 * @param ModuleContainerInterface $module
	 */
	public function registerModule(ModuleContainerInterface $module)
	{
		$this->registeredModules[$module->getName()] = $module;
	}

	/**
	 * @param Application $app
	 * @return $this
	 */
	public function registerModules(Application $app)
	{
		foreach ($this->getRegisteredModules() as $module)
		{
			$module->register($app);
		}

		return $this;
	}

	/**
	 * @param Application $app
	 * @return $this
	 */
	public function bootModules(Application $app)
	{
		foreach ($this->getRegisteredModules() as $module)
		{
			$module->boot($app);
		}

		return $this;
	}
}