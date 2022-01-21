<?php

if (empty(config('Medias')->routeFiles)){
	return;
}
 
$options = [
    'filter'    => 'login',
    'namespace' => '\Adnduweb\Ci4Medias\Controllers\Admin',
];

// Routes to Files controller
$routes->group(CI_AREA_ADMIN . '/medias', $options, function ($routes)
{
	$routes->get('/', 'Medias::list', ['as' => 'media-list']);
	$routes->get('datatable', 'Medias::ajaxDatatable', ['as' => 'medias-listajax']);
	$routes->get('datatable-dimensions', 'Medias::ajaxDatatableDimensions', ['as' => 'medias-listajax-dimensions']);
	

	$routes->get('edit/(:any)', 'Medias::edit/$2', ['as' => 'Media-edit']);
    $routes->post('edit/(:any)', 'Medias::update/$1', ['as' => 'Media-update']);

	$routes->post('upload', 'Medias::upload', ['as' => 'media-upload']);

	$routes->post('rename', 'Medias::rename', ['as' => 'media-rename']);
	$routes->delete('remove-file', 'Medias::removeFile', ['as' => 'media-remove-file']);
	$routes->delete('remove-file-custom', 'Medias::removeFileCustom', ['as' => 'media-remove-file-custom']);

	$routes->get('settings', 'Medias::settings/$1', ['as' => 'media-settings']);
	$routes->post('settings', 'Medias::saveSettings');

	$routes->post('manager-crop', 'Medias::getCropTemplate', ['as' => 'media-crop-template']);
	$routes->post('cropFile', 'Medias::cropFile', ['as' => 'media-crop-store']);
	$routes->add('get-image-manager', 'Medias::getImageManager', ['as' => 'media-image-manager']);
	$routes->add('get-upload-final', 'Medias::getUploadFinal', ['as' => 'media-upload-final']);

	

});

$routes->match(['get', 'post'], 'medias/(:segment)/(:segment)', '\Adnduweb\Ci4Medias\Controllers\RenderImage::index/$1/$2');
