<?php


namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Tag
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 *
 * @property int $id
 * @property string $name
 * @property News[] $news
 */
class Tag extends ActiveRecord
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function getNews()
    {
        return $this->hasMany(News::class, ['id' => 'news_id'])->via('tagNews');
    }

    public function getTagNews()
    {
        return $this->hasMany(NewsTags::class, ['tag_id' => 'id']);
    }
}
