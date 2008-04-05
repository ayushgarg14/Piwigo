<?php
// +-----------------------------------------------------------------------+
// | Piwigo - a PHP based picture gallery                                  |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2008      Piwigo Team                  http://piwigo.org |
// | Copyright(C) 2003-2008 PhpWebGallery Team    http://phpwebgallery.net |
// | Copyright(C) 2002-2003 Pierrick LE GALL   http://le-gall.net/pierrick |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+


//--------------------------------------------------------------------- include
define('PHPWG_ROOT_PATH','./');
include_once(PHPWG_ROOT_PATH.'include/common.inc.php');
check_status(ACCESS_NONE);
include_once(PHPWG_ROOT_PATH.'include/functions_notification.inc.php');
include_once(PHPWG_ROOT_PATH.'include/functions_mail.inc.php');
include_once(PHPWG_ROOT_PATH.'admin/include/functions.php');
include_once(PHPWG_ROOT_PATH.'admin/include/functions_notification_by_mail.inc.php');
// Translations are in admin file too
load_language('admin.lang');
// Need to update a second time
trigger_action('loading_lang');
load_language('local.lang');



// +-----------------------------------------------------------------------+
// | Main                                                                  |
// +-----------------------------------------------------------------------+
$page['errors'] = array();
$page['infos'] = array();

if (isset($_GET['subscribe'])
    and preg_match('/^[A-Za-z0-9]{16}$/', $_GET['subscribe']))
{
  subscribe_notification_by_mail(false, array($_GET['subscribe']));
}
else
if (isset($_GET['unsubscribe'])
    and preg_match('/^[A-Za-z0-9]{16}$/', $_GET['unsubscribe']))
{
  unsubscribe_notification_by_mail(false, array($_GET['unsubscribe']));
}
else
{
  array_push($page['errors'], l10n('nbm_unknown_identifier'));
}

// +-----------------------------------------------------------------------+
// | template initialization                                               |
// +-----------------------------------------------------------------------+
$title = l10n('nbm_item_notification');
$page['body_id'] = 'theNBMPage';
include(PHPWG_ROOT_PATH.'include/page_header.php');

$template->set_filenames(array('nbm'=>'nbm.tpl'));

// +-----------------------------------------------------------------------+
// | errors & infos                                                        |
// +-----------------------------------------------------------------------+
$template->assign(
    array(
      'errors' => $page['errors'],
      'infos' => $page['infos'],
    )
  );

// +-----------------------------------------------------------------------+
// | html code display                                                     |
// +-----------------------------------------------------------------------+
$template->parse('nbm');
include(PHPWG_ROOT_PATH.'include/page_tail.php');
?>
