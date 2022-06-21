<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
//        $reply->topic->increment('reply_count', 1);
        $reply->topic->updateReplyCount();

        // 通知话题作者有新的评论
        /**
         * 默认的 User 模型中使用了 trait —— Notifiable，
         * 它包含着一个可以用来发通知的方法 notify() ，
         * 此方法接收一个通知实例做参数。
         */
        $reply->topic->user->notify(new TopicReplied($reply));
    }

    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function updating(Reply $reply)
    {
        //
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->updateReplyCount();
    }
}
