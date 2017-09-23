<?php
/**
 * @filesource modules/demo/controllers/table.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Demo\Table;

use \Kotchasan\Http\Request;
use \Kotchasan\Language;
use \Kotchasan\Html;
use \Gcms\Login;

/**
 * module=demo-table
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Gcms\Controller
{

  /**
   * Controller สำหรับคัดเลือกหน้าของโมดูล demo
   *
   * @param Request $request
   * @return string
   */
  public function render(Request $request)
  {
    // ข้อความ title bar
    $this->title = Language::get('Admin Framework');
    // เลือกเมนู
    $this->menu = 'demo';
    // ตรวจสอบ premission (can_config)
    if ($login = Login::checkPermission(Login::isMember(), 'can_config')) {
      // แสดงผล
      $section = Html::create('section');
      // breadcrumbs
      $breadcrumbs = $section->add('div', array(
        'class' => 'breadcrumbs'
      ));
      $ul = $breadcrumbs->add('ul');
      $ul->appendChild('<li><span class="icon-home">{LNG_Home}</span></li>');
      $section->add('header', array(
        'innerHTML' => '<h2 class="icon-template">'.$this->title.'</h2>'
      ));
      // แสดงตาราง
      $section->appendChild(createClass('Demo\Table\View')->render($request));
      return $section->render();
    }
    // 404.html
    return \Index\Error\Controller::page404();
  }
}