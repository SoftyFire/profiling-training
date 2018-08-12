<?php


namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class ArticleTags
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class ArticleTags extends ActiveRecord
{
    public function rules()
    {
        return [
            [['article_id', 'tag_id'], 'integer'],
            [['title', 'text'], 'string'],
        ];
    }

    public function getTag()
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }

    public function getNews()
    {
        return $this->hasMany(Article::class, ['id' => 'article_id']);
    }
}
