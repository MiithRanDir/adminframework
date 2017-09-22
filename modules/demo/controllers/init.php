<?php
/**
 * @filesource modules/demo/controllers/init.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Demo\Init;

use \Kotchasan\Http\Request;
use \Gcms\Login;
use \Kotchasan\Language;

/**
 * Init Module
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Kotchasan\KBase
{

  /**
   * ฟังก์ชั่นเริ่มต้นการทำงานของโมดูลที่ติดตั้ง
   * และจัดการเมนูของโมดูล
   *
   * @param Request $request
   * @param \Index\Menu\Controller $menu
   * @param array $login
   */
  public static function execute(Request $request, $menu, $login)
  {
    // รายการเมนูย่อย
    $submenus = array(
      array(
        'text' => 'Typography',
        'url' => 'index.php?module=demo&amp;page=typography'
      ),
      array(
        'text' => 'Form &amp; Form Component',
        'url' => 'index.php?module=demo&amp;page=form'
      ),
      array(
        'text' => 'Table',
        'url' => 'index.php?module=demo-table'
      ),
      array(
        'text' => 'Icons',
        'url' => 'skin/',
        'target' => '_blank'
      ),
    );
// สร้างเมนูบนสุดก่อนเมนู settings
    $menu->addTopLvlMenu('demo', 'Demo', null, $submenus, 'settings');
  }
}