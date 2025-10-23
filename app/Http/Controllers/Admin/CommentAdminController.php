<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentAdminController extends Controller
{
    public function index(Request $request)
    {
        $status    = $request->query('status'); // null|pending|approved|rejected|spam
        $q         = $request->query('q');
        $articleId = $request->query('article_id');

        $query = Comment::with(['article:id,title_id,slug', 'user:id,name,email'])
            ->when($status, fn($qq) => $qq->where('status', $status))
            ->when($articleId, fn($qq) => $qq->where('article_id', $articleId))
            ->when($q, function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('body', 'like', "%{$q}%")
                      ->orWhere('guest_name', 'like', "%{$q}%")
                      ->orWhere('guest_email', 'like', "%{$q}%")
                      ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%"));
                });
            })
            ->latest();

        $comments = $query->paginate(20)->withQueryString();

        // hitungan untuk tab
        $counts = Comment::selectRaw("status, COUNT(*) as total")->groupBy('status')->pluck('total', 'status');
        $countsAll = Comment::count();

        $articles = Article::orderBy('title_id')->get(['id', 'title_id']);

        return view('admin.comments.index', compact('comments', 'counts', 'countsAll', 'status', 'q', 'articleId', 'articles'));
    }

    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected,spam'],
        ]);

        $old = $comment->status;
        $comment->status = $data['status'];
        $comment->save();

        $this->syncCounterOnTransition($comment, $old, $comment->status);

        return back()->with('success', 'Komentar diperbarui.');
    }

    public function bulk(Request $request)
    {
        $data = $request->validate([
            'action' => ['required', 'in:approve,reject,spam,delete'],
            'ids'    => ['required', 'array'],
            'ids.*'  => ['integer', 'exists:comments,id'],
        ]);

        $comments = Comment::with('article')->whereIn('id', $data['ids'])->get();

        foreach ($comments as $c) {
            $old = $c->status;

            if ($data['action'] === 'delete') {
                // jika approved, turunkan counter lalu hapus
                if ($c->status === 'approved') {
                    $c->article?->decrement('comment_count');
                }
                $c->delete();
                continue;
            }

            // set status baru
            $new = match ($data['action']) {
                'approve' => 'approved',
                'reject'  => 'rejected',
                'spam'    => 'spam',
            };

            if ($old !== $new) {
                $c->status = $new;
                $c->save();
                $this->syncCounterOnTransition($c, $old, $new);
            }
        }

        return back()->with('success', 'Aksi massal berhasil.');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->status === 'approved') {
            $comment->article?->decrement('comment_count');
        }
        $comment->delete();

        return back()->with('success', 'Komentar dihapus.');
    }

    private function syncCounterOnTransition(Comment $c, string $old, string $new): void
    {
        // dari non-approved -> approved : +1
        if ($old !== 'approved' && $new === 'approved') {
            $c->article?->increment('comment_count');
        }
        // dari approved -> non-approved : -1
        if ($old === 'approved' && $new !== 'approved') {
            $c->article?->decrement('comment_count');
        }
    }
}
