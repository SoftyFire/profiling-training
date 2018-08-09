<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Initializes tables.
 *
 * @author Dmitry Naumenko <d.naumenko.a@gmail.com>
 */
class m170618_000000_db_init extends Migration
{
    public function up()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'text' => $this->text(),
        ]);

        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);

        $this->createTable('news_tags', [
            'news_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('news');
        $this->dropTable('tag');
        $this->dropTable('news_tags');
    }
}
