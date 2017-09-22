<?php
/**
 * @filesource modules/demo/models/table.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Demo\Form;

use \Kotchasan\Http\Request;
use \Gcms\Login;
use \Kotchasan\Language;

/**
 * รับค่าจากฟอร์ม
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{

  /**
   * รับค่าจากฟอร์ม (form.php)
   *
   * @param Request $request
   */
  public function submit(Request $request)
  {
    $ret = array();
    // session, token, member
    if ($request->initSession() && $request->isSafe() && $login = Login::isMember()) {
      // รับค่าจากการ POST
      $save = array(
        'username' => $request->post('register_username')->url(),
        'password' => $request->post('register_password')->password(),
        'birthday' => $request->post('register_birthday')->date(),
        'amount' => $request->post('register_amount')->toDouble(),
        'sex' => $request->post('register_sex')->filter('fm'),
        'phone' => $request->post('register_phone')->number(),
        'address' => $request->post('register_address')->textarea(),
        'provinceID' => $request->post('register_provinceID')->number(),
        'zipcode' => $request->post('register_zipcode')->number(),
        'permission' => $request->post('register_permission', array())->topic(),
        'fb' => $request->post('register_fb', array())->toInt(),
        'id' => $request->post('register_id')->toInt(),
      );
      //print_r($_POST);
      //print_r($save);
      if ($save['username'] == '') {
        $ret['ret_register_username'] = 'Please fill in';
      }
      if (empty($ret)) {
        // บันทึกลงฐานข้อมูล
        //$this->db()->update($this->getTableName('user'), $save['id'], $save);
        // คืนค่า
        $ret['alert'] = Language::get('Saved successfully');
        // ไปหน้าแสดงรายการข้อมูล
        $ret['location'] = $request->getUri()->postBack('index.php', array('module' => 'demo-table', 'id' => null));
        // เคลียร์
        $request->removeToken();
      }
    }
    if (empty($ret)) {
      $ret['alert'] = Language::get('Unable to complete the transaction');
    }
    // คืนค่าเป็น JSON
    echo json_encode($ret);
  }
}