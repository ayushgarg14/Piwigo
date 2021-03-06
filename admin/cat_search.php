<?php
// +-----------------------------------------------------------------------+
// | This file is part of Piwigo.                                          |
// |                                                                       |
// | For copyright and license information, please view the COPYING.txt    |
// | file that was distributed with this source code.                      |
// +-----------------------------------------------------------------------+

if (!defined('PHPWG_ROOT_PATH'))
{
  die('Hacking attempt!');
}

include_once(PHPWG_ROOT_PATH.'admin/include/functions.php');

// +-----------------------------------------------------------------------+
// | Check Access and exit when user status is not ok                      |
// +-----------------------------------------------------------------------+
check_status(ACCESS_ADMINISTRATOR);


// +-----------------------------------------------------------------------+
// | tabs                                                                  |
// +-----------------------------------------------------------------------+

$page['tab'] = 'search';
include(PHPWG_ROOT_PATH.'admin/include/albums_tab.inc.php');

// +-----------------------------------------------------------------------+
// | Get Categories                                                        |
// +-----------------------------------------------------------------------+

$categories = array();

$query = '
SELECT id, name, status, uppercats
  FROM '.CATEGORIES_TABLE;

$result = query2array($query);

foreach ($result as $cat) 
{ 
  $private = ($cat['status'] == 'private')? 1:0;

  $parents = explode(',', $cat['uppercats']);
  
  $content = array($cat['name'], $parents, $private);
  $categories[$cat['id']] = $content;
}

// +-----------------------------------------------------------------------+
// |                       template initialization                         |
// +-----------------------------------------------------------------------+
$template->set_filename('cat_search', 'cat_search.tpl');
$template->assign('data_cat', $categories);

// +-----------------------------------------------------------------------+
// |                          sending html code                            |
// +-----------------------------------------------------------------------+
$template->assign_var_from_handle('ADMIN_CONTENT', 'cat_search');
?>
