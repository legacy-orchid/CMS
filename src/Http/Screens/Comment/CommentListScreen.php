<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Screens\Comment;

use Orchid\Press\Http\Layouts\Comment\CommentListLayout;
use Orchid\Press\Models\Comment;
use Orchid\Screen\Screen;

class CommentListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Comments';
    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'User Comments';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $comments = Comment::with([
            'post' => function ($query) {
                $query->select('id', 'type', 'slug');
            },
        ])->latest()
            ->paginate();

        return [
            'comments' => $comments,
        ];
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar() : array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            CommentListLayout::class,
        ];
    }
}
