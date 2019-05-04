<?php
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Judgment extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // 保存自动完成列表
    protected $auto = [
        'delete_time' => NULL,
        'is_delete' => NULL, //1:允许删除 null:禁止删除
    ];

    // 更新自动完成列表
    protected $update = [];
    // 是否需要自动写入时间戳 如果设置为字符串 则表示时间字段的类型
    protected $autoWriteTimestamp = true; //自动写入
    // 更新时间字段
    protected $updateTime = 'update_time';
    // 时间字段取出后的默认时间格式
    protected $dateFormat = 'Y年m月d日';

}