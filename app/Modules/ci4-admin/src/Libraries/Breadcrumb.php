<?php

/**
 * --------------------------------------------------------------------
 * CODEIGNITER 4 - CI4 Breadcrumbs
 * --------------------------------------------------------------------
 *
 * This content is released under the MIT License (MIT)
 *
 * @package    CI4 Breadcrumbs
 * @author     GeekLabs - Lee Skelding 
 * @license    https://opensource.org/licenses/MIT	MIT License
 * @link       https://github.com/GeekLabsUK/CI4-Breadcrumbs
 * @since      Version 2.0
 * 
 */

namespace Adnduweb\Ci4Admin\Libraries;

//use CodeIgniter\HTTP\URI;

class Breadcrumb
{

    private $breadcrumbs = array();
    private $tags;

    public function __construct()
    {
        $this->URI = service('uri');

        // SHOULD THE LAST BREADCRUMB BE A CLICKABLE LINK? iF SO SET TO TRUE
        $this->clickable = true;

        // create our bootstrap html elements
        $this->tags['navopen']   = "<nav aria-label=\"breadcrumb\">";
        $this->tags['navclose']  = "</nav>";
        $this->tags['olopen']    = "<ol class=\"breadcrumb\">";
        $this->tags['olclose']   = "</ol>";
        $this->tags['separator'] = "<li class=\"breadcrumb-item\"><span class=\"bullet bg-gray-200 w-5px h-2px\"></span></li>";
        $this->tags['liopen']    = "<li class=\"breadcrumb-item\">";
        $this->tags['liclose']   = "</li>";
    }

    public function add($crumb, $href, $icon)
    {

        if (!$crumb or !$href) return; // if the title or Href not set return 

        $this->breadcrumbs[] = array(
            'crumb' => $crumb,
            'href' => $href,
            'icon' => !empty($icon) ? service('Theme')->getSVG($icon, 'menu-icon') : '',
        );
    }


    public function render()
    {
        $output = '';
       // $output  = $this->tags['navopen'];
        // $output .= $this->tags['olopen'];

        //print_r($this->breadcrumbs); exit;

        $count = count($this->breadcrumbs) - 1;

        foreach ($this->breadcrumbs as $index => $breadcrumb) {

            if ($index == $count) {
                $output .= $this->tags['liopen'];
                $output .= $breadcrumb['crumb'];
                $output .= $this->tags['liclose'];
            } else {
                $output .= $this->tags['liopen'];
                $output .= '<a href="' . base_url() . $breadcrumb['href'] . '">';
                $output .= $breadcrumb['icon'] . ' ' . $breadcrumb['crumb'];
                $output .= '</a>';
                $output .= $this->tags['liclose'];
            }
            $output .= $this->tags['separator'];  
        }

       // $output .= $this->tags['olclose'];
       // $output .= $this->tags['navclose'];

        return $output;
    }

    public function buildAuto()
    {

        $urisegments = $this->URI->getSegments();

        // $output  = $this->tags['navopen'];
        // $output .= $this->tags['olopen'];

        $crumbs = array_filter($urisegments);

        $result = array();
        $path = '';

        // SUBTRACT 1 FROM COUNT IF THE LAST LINK IS TO NOT BE A LINK
        $count = count($crumbs) ;

        if ($this->clickable){

            $count = count($crumbs) -1;
        }
        

        foreach ($crumbs as $k => $crumb) {

            $path .= '/' . $crumb;

            $name = str_replace(array(".php", "_"), array("", " "), $crumb);
            $name = str_replace('-', ' ', $name);

            if($crumb == CI_AREA_ADMIN){
                $name = 'home';
            }

            if ($k != $count) {

                $result[] = $this->tags['liopen'] . '<a href="' . $path . '"> ' . lang('Core.'. $name) . '</a>' . $this->tags['liclose'];
                $result[] = $this->tags['separator'];  

            } else {

                $result[] = $this->tags['liopen'] . lang('Core.'. $name . '_' . service('router')->methodName()) . $this->tags['liclose'];

            }

            
        }

        $output = implode($result);
        // $output .= $this->tags['olclose'];
        // $output .= $this->tags['navclose'];

        return $output;
    }
}