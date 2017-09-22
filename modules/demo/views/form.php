<?php
/**
 * @filesource modules/demo/views/form.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Demo\Form;

use \Kotchasan\Http\Request;
use \Kotchasan\Html;

/**
 * module=demo&page=form
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\View
{

  /**
   * ตัวอย่างฟอร์ม
   *
   * @return string
   */
  public function render(Request $request)
  {
    /* คำสั่งสร้างฟอร์ม */
    $form = Html::create('form', array(
        'id' => 'setup_frm',
        'class' => 'setup_frm',
        'autocomplete' => 'off',
        /*
         * คลาสรับค่าจากการ submit ปกติแล้วควรจะเป็นชื่อเดียวกันกับ Controller
         * demo/model/form/submit หมายถึงคลาสและเมธอด \Demo\Form\Model::submit()
         */
        'action' => 'index.php/demo/model/form/submit',
        /* ฟังก์ชั่น Javascript (common.js) สำหรับรับค่าที่ตอบกลับจาก Server หลังการ submit */
        'onsubmit' => 'doFormSubmit',
        /* form แบบ Ajax */
        'ajax' => true,
        /* เปิดการใช้งาน Token สำหรับรักษาความปลอดภัยของฟอร์ม */
        'token' => true
    ));
    /*
     * คำสั่งสร้าง fieldset และ legend สำหรับจัดกลุ่ม input
     * <legend><span>...</span></legend>
     */
    $fieldset = $form->add('fieldset', array(
      'title' => '{LNG_Login information}'
    ));
    /*
     * คำสั่งสร้าง input ชนิด text และ tag อื่นๆที่แวดล้อม
     */
    $fieldset->add('text', array(
      'id' => 'register_username',
      'itemClass' => 'item',
      'labelClass' => 'g-input icon-email',
      'label' => '{LNG_Email}',
      'comment' => '{LNG_Email address used for login or request a new password}',
      'maxlength' => 50,
      'value' => '',
      /*
       * คำสั่ง Javascript สำหรับตรวจสอบการกรอกข้อมูล
       * และการตรวจสอบกับฐานข้อมูลที่ \Index\Checker\Model::username()
       */
      'validator' => array('keyup,change', 'checkUsername', 'index.php/index/model/checker/username')
    ));
    // password, repassword
    $groups = $fieldset->add('groups', array(
      'comment' => '{LNG_To change your password, enter your password to match the two inputs}',
    ));
    // password
    $groups->add('password', array(
      'id' => 'register_password',
      'itemClass' => 'width50',
      'labelClass' => 'g-input icon-password',
      'label' => '{LNG_Password}',
      'placeholder' => '{LNG_Passwords must be at least four characters}',
      'maxlength' => 20,
      'validator' => array('keyup,change', 'checkPassword')
    ));
    // date
    $groups->add('date', array(
      'id' => 'register_birthday',
      'itemClass' => 'width50',
      'labelClass' => 'g-input icon-calendar',
      'label' => '{LNG_Birthday}',
      'value' => date('Y-m-d')
    ));
    $fieldset = $form->add('fieldset', array(
      'title' => '{LNG_Details of} {LNG_User}'
    ));
    $groups = $fieldset->add('groups');
    /* input ชนิด Text ที่สามารถรับค่าตัวเลขและจุดทศนิยมสองหลัก ใช้สำหรับกรอกจำนวนเงิน */
    $groups->add('currency', array(
      'id' => 'register_amount',
      'labelClass' => 'g-input icon-money',
      'itemClass' => 'width50',
      'label' => '{LNG_Amount}',
      'maxlength' => 100
    ));
    /* select */
    $groups->add('select', array(
      'id' => 'register_sex',
      'labelClass' => 'g-input icon-sex',
      'itemClass' => 'width50',
      'label' => '{LNG_Sex}',
      /* ข้อมูลใส่ลงใน select */
      'options' => array('f' => 'หญิง', 'm' => 'ชาย')
    ));
    $groups = $fieldset->add('groups');
    /* input ชนิด Text รับค่าเป็นตัวเลขเท่านั้น */
    $groups->add('number', array(
      'id' => 'register_phone',
      'labelClass' => 'g-input icon-phone',
      'itemClass' => 'width50',
      'label' => '{LNG_Phone}',
      'maxlength' => 32
    ));
    // address
    $fieldset->add('textarea', array(
      'id' => 'register_address',
      'labelClass' => 'g-input icon-address',
      'itemClass' => 'item',
      'label' => '{LNG_Address}',
      'rows' => 3,
    ));
    $groups = $fieldset->add('groups');
    // provinceID
    $groups->add('select', array(
      'id' => 'register_provinceID',
      'labelClass' => 'g-input icon-location',
      'itemClass' => 'width50',
      'label' => '{LNG_Province}',
      'options' => \Kotchasan\Province::all()
    ));
    // zipcode
    $groups->add('text', array(
      'id' => 'register_zipcode',
      'labelClass' => 'g-input icon-location',
      'itemClass' => 'width50',
      'label' => '{LNG_Zipcode}',
      'pattern' => '[0-9]+',
      'maxlength' => 10,
    ));
    /* กลุ่มของ checkbox สามารถเลือกได้หลายตัว */
    $fieldset->add('checkboxgroups', array(
      'id' => 'register_permission',
      'label' => '{LNG_Permission}',
      'labelClass' => 'g-input icon-list',
      'options' => array('can_config' => 'สามารถตั้งค่าระบบได้', 'can_access' => 'สามารถเข้าระบบได้'),
      'value' => array('can_access', 'can_config')
    ));
    /* กลุ่มของ radio สามารถเลือกได้แค่ตัวเดียว */
    $fieldset->add('radiogroups', array(
      'id' => 'register_fb',
      'label' => 'สมาชิกเฟซบุ้ค',
      'labelClass' => 'g-input icon-facebook',
      'options' => array('0' => 'ไม่ใช่', '1' => 'ใช่', 2 => 'ไม่ทราบ'),
      'value' => 1
    ));
    $fieldset = $form->add('fieldset', array(
      'class' => 'submit'
    ));
    /* ปุ่ม submit */
    $fieldset->add('submit', array(
      'class' => 'button save large',
      'value' => '{LNG_Save}'
    ));
    /* input ชนิด hidden */
    $fieldset->add('hidden', array(
      'id' => 'register_id',
      'value' => $request->request('id')->toInt()
    ));
    return $form->render();
  }
}