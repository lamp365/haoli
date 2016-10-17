<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-10-11
 * Time: 下午12:06
 */
namespace Admin\Model;
use Think\Model;
class UserModel extends Model {
    /**
    1、自动验证格式：
    array(
    array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
    array(验证字段2,验证规则,错误提示,[验证条件,附加规则,验证时间]),
    ......
    );
    验证条件：
    self::EXISTS_VALIDATE 或者0 存在字段就验证（默认）
    self::MUST_VALIDATE 或者1 必须验证
    self::VALUE_VALIDATE或者2 值不为空的时候验证
    验证时间：
    self::MODEL_INSERT或者1新增数据时候验证
    self::MODEL_UPDATE或者2编辑数据时候验证
    self::MODEL_BOTH或者3全部情况下验证（默认）

     * 2、自动完成格式：
    array(
    array(完成字段1,完成规则,[完成条件,附加规则]),
    array(完成字段2,完成规则,[完成条件,附加规则]),
    ......
    );
    完成时间：
    self::MODEL_INSERT或者1   新增数据的时候处理（默认）
    self::MODEL_UPDATE或者2   更新数据的时候处理
    self::MODEL_BOTH或者3 所有情况都进行处理
     */
    /* 自动验证 */
    protected $_validate = array(
        array('mobile', '', '手机号已经注册过！', self::VALUE_VALIDATE, 'unique', self::MODEL_INSERT),
        array('email', '', '该邮箱已经注册过！', self::VALUE_VALIDATE, 'unique', self::MODEL_INSERT),
        array('pid', 'number', '父id不对必须是数字！', self::VALUE_VALIDATE, '', self::MODEL_INSERT),
        array('pwd', 'require', '没有填写密码！', self::EXISTS_VALIDATE, '', self::MODEL_INSERT),
        array('repwd', 'pwd', '重复密码不正确！', self::EXISTS_VALIDATE, 'confirm', self::MODEL_INSERT),
        array('mobile','11','手机号码位数不对！', self::EXISTS_VALIDATE, 'length', self::MODEL_INSERT),
        array('email', 'email', '邮箱格式不正确！',self::VALUE_VALIDATE, '', self::MODEL_INSERT)
    );

    /* 自动完成 */
    protected $_auto = array(
        array('pwd', 'encrypt', self::MODEL_INSERT, 'callback'),
        array('createtime', 'nowTime', self::MODEL_INSERT, 'callback'),
        array('lasttime', 'nowTime', self::MODEL_INSERT, 'callback'),
        array('email', 'checkEmail', self::MODEL_INSERT, 'callback')
    );

    /* 给密码加密 */
    public function encrypt() {
        return md5Pwd(I('post.pwd'));
    }

    /* 创建时间 */
    public function nowTime() {
        return time();
    }

    /* 上传头像 */
    public function uploadFace() {

    }

    public function checkEmail(){
        if(empty(I('post.email'))){
            return uniqid();
        }
        return I('post.email');
    }
}