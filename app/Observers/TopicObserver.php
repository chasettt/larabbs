<?php

namespace App\Observers;

use Illuminate\Support\Facades\DB;
use App\Jobs\TranslateSlug;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);


    }

    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if (!$topic->slug) {
            dispatch(new TranslateSlug($topic));
        }
    }

    /**
     * @param Topic $topic
     */
    public function deleted(Topic $topic)
    {
        // 在模型监听器中，数据库操作需避免再次触发 Eloquent 事件，以免造成联动逻辑冲突。
        //所以这里我们使用了 DB 类进行操作。
        DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}
