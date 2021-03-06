<?php
/**
 * Kunena Plugin
 *
 * @package     Kunena.Plugins
 * @subpackage  Comprofiler
 *
 * @copyright   (C) 2008 - 2018 Kunena Team. All rights reserved.
 * @license     https://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link        https://www.kunena.org
 **/
defined('_JEXEC') or die();

class KunenaAvatarComprofiler extends KunenaAvatar
{
	protected $params = null;

	/**
	 * KunenaAvatarComprofiler constructor.
	 *
	 * @param $params
	 */
	public function __construct($params)
	{
		$this->params = $params;
	}

	/**
	 * @param $userlist
	 */
	public function load($userlist)
	{
		CBuser::advanceNoticeOfUsersNeeded($userlist);
	}

	/**
	 * @return string
	 */
	public function getEditURL()
	{
		global $_CB_framework;

		return $_CB_framework->userProfileEditUrl();
	}

	/**
	 * @param $user
	 * @param $sizex
	 * @param $sizey
	 *
	 * @return string
	 */
	protected function _getURL($user, $sizex, $sizey)
	{
		global $_CB_framework;
		$app  = JFactory::getApplication();
		$user = KunenaFactory::getUser($user);

		$cbclient_id = $app->getClientId() == 0 ? $cbclient_id = 1 : $cbclient_id = 2;
		$_CB_framework->cbset('_ui', $cbclient_id);

		// Get CUser object
		$cbUser = null;

		if ($user->userid)
		{
			$cbUser = CBuser::getInstance($user->userid);
		}

		if ($cbUser === null)
		{
			if ($sizex <= 90)
			{
				return selectTemplate() . 'images/avatar/tnnophoto_n.png';
			}

			return selectTemplate() . 'images/avatar/nophoto_n.png';
		}

		if ($sizex <= 90)
		{
			return $cbUser->getField('avatar', null, 'csv');
		}

		return $cbUser->getField('avatar', null, 'csv', 'none', 'list');
	}
}
