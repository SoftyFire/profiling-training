<?php


namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Article
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property Tag[] $tags
 */
class Article extends ActiveRecord
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
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('articleTags');
    }

    public function getArticleTags()
    {
        return $this->hasMany(ArticleTags::class, ['article_id' => 'id']);
    }
}
