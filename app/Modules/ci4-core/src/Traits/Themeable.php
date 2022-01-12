<?php

namespace Adnduweb\Ci4Core\Traits;

use CodeIgniter\View\View;

/**
 * Trait Themeable
 *
 * Provides simple theme functionality to controllers.
 *
 * @package Bonfire\View
 */
trait Themeable
{
    /**
     * The folder the theme is stored in (within /themes)
     * @var string
     */
    protected $theme = 'app';

    /** @var back */
    protected static $isBackend = false;

    /**
     * @var View
     */
    protected $renderer;

    protected function render(string $view, array $data=[], array $options=null)
    {

        $this->response->noCache();
        // Prevent some security threats, per Kevin
        // Turn on IE8-IE9 XSS prevention tools
        $this->response->setHeader('X-XSS-Protection', '1; mode=block');
        // Don't allow any pages to be framed - Defends against CSRF
        $this->response->setHeader('X-Frame-Options', 'DENY');
        // prevent mime based attacks
        $this->response->setHeader('X-Content-Type-Options', 'nosniff');

        
        $renderer = $this->getRenderer();

        return $renderer->setData($data)
            ->render($view, $options, true);
    }

    /**
     * Gets a renderer instance pointing to the appropriate
     * theme folder.
     *
     * Note: This should only be called right before use so that
     * the controller has a chance to dynamically update the
     * theme being used.
     *
     * @return View|mixed|null
     */
    protected function getRenderer()
    {
        if ($this->renderer instanceof View) {
            return $this->renderer;
        }

        if(static::$isBackend == true){
            \Adnduweb\Ci4Admin\Libraries\Theme::setTheme($this->theme);
        }else{
            // Theme::setTheme($this->theme);
            \Adnduweb\Ci4Pages\Libraries\Theme::setTheme($this->theme);
        }

        if(static::$isBackend == true){
            $path = \Adnduweb\Ci4Admin\Libraries\Theme::path();
        }else{
            //$path = Theme::path();
            $path = \Adnduweb\Ci4Pages\Libraries\Theme::path($this->theme);
        }

        if (! is_dir($path)) {
            throw new \RuntimeException("`{$this->theme}` is not a valid theme folder.");
        }

        $this->renderer = single_service('renderer', $path);

        return $this->renderer;
    }
}