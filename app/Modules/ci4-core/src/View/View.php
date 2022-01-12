<?php

namespace Adnduweb\Ci4Core\View;

use CodeIgniter\Debug\Toolbar\Collectors\Views;
use CodeIgniter\View\Exceptions\ViewException;
use CodeIgniter\View\View as CIView;
use Config\Toolbar;
use Adnduweb\Ci4Core\View\ComponentRenderer;
use MatthiasMullie\Minify;

class View extends CIView
{
	/**
	 * @var \Bonfire\View\ComponentRenderer
	 */
	private $components;

	private $hash = 'Doudou et chacha et aurore. Life de ma life!';

	public function __construct(...$params)
	{
		parent::__construct(...$params);

		$this->components = new ComponentRenderer();
	}

	/**
	 * Recreates CodeIgniter's render() method to
	 * provide custom html tags, called components.
	 *
	 * @todo Look into refactoring the base View class for 5.0 so it's more easily overridden/extended
	 *
	 * Valid $options:
	 *  - cache      Number of seconds to cache for
	 *  - cache_name Name to use for cache
	 *
	 * @param string       $view     File name of the view source
	 * @param array|null   $options  Reserved for 3rd-party uses since
	 *                               it might be needed to pass additional info
	 *                               to other template engines.
	 * @param boolean|null $saveData If true, saves data for subsequent calls,
	 *                               if false, cleans the data after displaying,
	 *                               if null, uses the config setting.
	 *
	 * @return string
	 */
	public function render(string $view, array $options = null, bool $saveData = null): string
	{
		$this->renderVars['start'] = microtime(true);

		// Store the results here so even if
		// multiple views are called in a view, it won't
		// clean it unless we mean it to.
		$saveData                    = $saveData ?? $this->saveData;
		$fileExt                     = pathinfo($view, PATHINFO_EXTENSION);
		$realPath                    = empty($fileExt) ? $view . '.php' : $view; // allow Views as .html, .tpl, etc (from CI3)
		$this->renderVars['view']    = $realPath;
		$this->renderVars['options'] = $options ?? [];

		// Was it cached?
		if (isset($this->renderVars['options']['cache']))
		{
			$cacheName = $this->renderVars['options']['cache_name'] ?? str_replace('.php', '', $this->renderVars['view']);
			$cacheName = str_replace(['\\', '/'], '', $cacheName);

			$this->renderVars['cacheName'] = $cacheName;

			if ($output = cache($this->renderVars['cacheName']))
			{
				$this->logPerformance($this->renderVars['start'], microtime(true), $this->renderVars['view']);

				return $output;
			}
		}
		

        $this->renderVars['file'] = $this->viewPath . $this->renderVars['view'];
        

		if (! is_file($this->renderVars['file']))
		{
			$this->renderVars['file'] = $this->loader->locateFile($this->renderVars['view'], 'Views', empty($fileExt) ? 'php' : $fileExt);
		}

		// locateFile will return an empty string if the file cannot be found.
		if (empty($this->renderVars['file']))
		{
			throw ViewException::forInvalidFile($this->renderVars['view']);
		}

		// Make our view data available to the view.
		$this->tempData = $this->tempData ?? $this->data;

		if ($saveData)
		{
			$this->data = $this->tempData;
		}

		// Save current vars
		$renderVars = $this->renderVars;

		$output = (function (): string {
			extract($this->tempData);
			ob_start();
			include $this->renderVars['file'];
			return ob_get_clean() ?: '';
		})();

		// Get back current vars
		$this->renderVars = $renderVars;

		// When using layouts, the data has already been stored
		// in $this->sections, and no other valid output
		// is allowed in $output so we'll overwrite it.
		if (! is_null($this->layout) && $this->sectionStack === [])
		{
			
			$layoutView   = $this->layout;
			$this->layout = null;
			// Save current vars
			$renderVars = $this->renderVars;
			$output     = $this->render($layoutView, $options, $saveData);
			// Get back current vars
			$this->renderVars = $renderVars;
		}

		$output = $this->components->render($output);

		$this->logPerformance($this->renderVars['start'], microtime(true), $this->renderVars['view']);

		if (($this->debug && (! isset($options['debug']) || $options['debug'] === true))
		    && in_array('CodeIgniter\Filters\DebugToolbar', service('filters')->getFiltersClass()['after'], true)
		)
		{
			$toolbarCollectors = config(Toolbar::class)->collectors;

			if (in_array(Views::class, $toolbarCollectors, true))
			{
				// Clean up our path names to make them a little cleaner
				$this->renderVars['file'] = clean_path($this->renderVars['file']);
				$this->renderVars['file'] = ++$this->viewsCount . ' ' . $this->renderVars['file'];

				$output = '<!-- DEBUG-VIEW START ' . $this->renderVars['file'] . ' -->' . PHP_EOL
				          . $output . PHP_EOL
				          . '<!-- DEBUG-VIEW ENDED ' . $this->renderVars['file'] . ' -->' . PHP_EOL;
			}
		}

		// Should we cache?
		if (isset($this->renderVars['options']['cache']))
		{
			cache()->save($this->renderVars['cacheName'], $output, (int) $this->renderVars['options']['cache']);
		}

		$this->tempData = null;

		return $output;
	}


	 /**
     * Renders a section's contents.
     */
    public function renderSection(string $sectionName)
    {
        if (! isset($this->sections[$sectionName])) {
            echo '';
            return;
		}

		//print_r($this->getData()); exit;

		
		if (env('CI_ENVIRONMENT') == 'production') {

			if($sectionName == 'AdminAfterExtraJs' ) {
				
				$i = 0;
				$minifiedPathArray = [];
				if (! $admin_script_js = cache('asj_' . md5($this->getData()['controller'] . $this->getData()['method']))) {

					//print_r($this->sections['AdminAfterExtraJs']); exit;
					foreach ($this->sections['AdminAfterExtraJs'] as $key => $contents) {
						$minifier = new Minify\JS();
						if(strpos($contents, '<script type="text/javascript">')){

							$new_content = str_replace(['<script type="text/javascript">',  '</script>'], ['', ''], $contents);
							$minifier->add('/** '.$key.' **/' .$new_content);
							
						}
						$nameFile = hash('md5',$this->hash . 'AdminAfterExtraJs' . $this->getData()['controller'] . $this->getData()['method']);

						$minifiedPathArray[] = $minifiedPath = ROOTPATH .'public/backend/themes/'.service('settings')->get('App.theme_bo', 'name').'/cache/asj_' . md5($this->getData()['controller'] . $this->getData()['method'] . $key).'.min.js';
						$minifier->minify($minifiedPath);
						echo '<script type="text/javascript" src="backend/themes/'.service('settings')->get('App.theme_bo', 'name').'/cache/asj_' . md5($this->getData()['controller'] . $this->getData()['method'] . $key).'.min.js?ver=' . time() . '"></script>' . "\n";
						
						$i++;
					}
					cache()->save('asj_' . md5($this->getData()['controller'] . $this->getData()['method']), $minifiedPathArray, Config('Admin')->ttl);
				}

				if(!empty($admin_script_js)){
					$admin_script_js = (!is_array($admin_script_js)) ? [$admin_script_js] : $admin_script_js; 
					foreach($admin_script_js as $js){
						$js = str_replace(ROOTPATH .'public', '', $js);
						echo '<script type="text/javascript" src="' . base_url() . $js .'?ver=' . time() . '"></script>' . "\n";
					}
				}
			}else{
				foreach ($this->sections[$sectionName] as $key => $contents) {
					echo $contents;
					unset($this->sections[$sectionName][$key]);
				}
			}
		}else{
			foreach ($this->sections[$sectionName] as $key => $contents) {
				echo $contents;
				unset($this->sections[$sectionName][$key]);
			}
		}
       
    }
}