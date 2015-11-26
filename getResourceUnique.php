<?php
/**
 * 	getResourceUnique
 *
 * 	DESCRIPTION
 *
 * 	This Snippet select distinct resource by name.
 *
 * 	VERSION:
 *	
 *	bata-0.0.1
 *
 * 	USAGE:
 *	
 *	[[!getResourceUnique? 
 *	&limit=`1000` --> limit of result output
 *	&template=`7` --> limit result from defined template
 *	&field_search=`pagetitle` --> the field i select distinc  
 *	&tpl=`childItem-prodotti-row` --> template of output
 *	&id=`17` --> start parent id
 *	]]
 *
 */

$limit = (isset($limit)) ? $limit : 10;
$template = (isset($template)) ? $template : '';
$field_search = (isset($field_search)) ? $field_search : 'pagetitle';
$tpl = $modx->getOption('tpl',$scriptProperties,'childItem-prodotti-row');
$id = (int)$modx->getOption('id',$scriptProperties,17);



$c = $modx->newQuery('modResource');

$c->where(array(
  'deleted' => false,
  'hidemenu' => $showHidden,
  'template' => $template
));
$children = $modx->getChildIds($id);



if (count($children) > 0) {
    $c->where(array(
        'id:IN' => $children,
    ));
}
$c->sortby('pagetitle','ASC');

$resources = $modx->getIterator('modResource',$c);

$output = '';
$string_search = '';

foreach($resources as $resource) {
 	
   	if ($i < $limit) {
		$resourceArray = $resource->toArray();

		if($string_search != $resource->get($field_search)){
    		$output .= $modx->getChunk($tpl,$resourceArray);
		}
		
		$string_search = $resource->get($field_search);
	}
 	$i++;
 
}

return $output;
