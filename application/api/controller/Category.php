<?php
namespace app\api\controller;

use think\Controller;

class Category extends Controller
{
    public function getCategoryByParentId($id)
    {
        if(!$id) {
            $this->error('ID不合法');
        }
        $categorys = model('Category')->getNormalCategoryByParentId($id);
        if(!$categorys) {
            return show(0, 'error');
        }
        return show(1, 'success', $categorys);
    }
}