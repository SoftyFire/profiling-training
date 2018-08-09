<?php


namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class NewsTags
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class NewsTags extends ActiveRecord
{
    public function rules()
    {
        return [
            [['news_id', 'tag_id'], 'integer'],
            [['title', 'text'], 'string'],
        ];
    }

    public function getTag()
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }

    public function getNews()
    {
        return $this->hasMany(News::class, ['id' => 'news_id']);
    }
}
