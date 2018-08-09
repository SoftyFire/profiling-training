<?php


namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class News
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property Tag[] $tags
 */
class News extends ActiveRecord
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'text'], 'string'],
        ];
    }

    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('newsTags');
    }

    public function getNewsTags()
    {
        return $this->hasMany(NewsTags::class, ['news_id' => 'id']);
    }
}
