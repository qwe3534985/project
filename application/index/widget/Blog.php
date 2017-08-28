<?php
/**
 * Created by PhpStorm.
 * User: jia
 * Date: 2017/8/27
 * Time: 20:08
 */

namespace app\index\widget;

use think\Controller;

class Blog extends Controller{

    public function head(){
        return $this->fetch('common/head');
    }
    public function right(){
        return $this->fetch('common/right');
    }
    public function footer(){
        return $this->fetch('common/footer');
    }
}