<?php

namespace Config;

class Themes
{
    /**
     * ---------------------------------------------------------------
     * THEME COLLECTIONS
     * ---------------------------------------------------------------
     *
     * Contains the "root" folders that hold our themes. Each theme
     * must be a direct child of the root folder.
     *
     * For example:
     *  $themeCollection = [ROOTPATH.'themes']
     *  /themes         - the "collection" folder
     *      /admin      - a theme
     *      /app        - a theme
     *
     * @var array
     */
    public $collectionsBackend = [
        ROOTPATH .'resources/Views/backend',
    ];


      /**
     * ---------------------------------------------------------------
     * THEME COLLECTIONS
     * ---------------------------------------------------------------
     *
     * Contains the "root" folders that hold our themes. Each theme
     * must be a direct child of the root folder.
     *
     * For example:
     *  $themeCollection = [ROOTPATH.'themes']
     *  /themes         - the "collection" folder
     *      /admin      - a theme
     *      /app        - a theme
     *
     * @var array
     */
    public $collectionsFrontend = [
        ROOTPATH .'resources/Views/frontend',
    ];


    /**
     * Whether or not we should expect to find
     * a "Components" folder within the theme folders.
     *
     * @var bool
     */
    public $haveComponents = true;
}