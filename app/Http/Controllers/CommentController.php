<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, int $articleId)
    {
        // 1) Validasi dasar
        $rules = [
            'body'        => ['required', 'string', 'min:3'],
            'parent_id'   => ['nullable', 'integer', 'exists:comments,id'],
            'guest_name'  => ['nullable', 'string', 'max:100'],
            'guest_email' => ['nullable', 'email', 'max:150'],
            'website'     => ['nullable', 'string', 'max:200'], // honeypot
        ];

        // 2) Jika belum login, tamu wajib isi nama & email
        if (!Auth::check()) {
            $rules['guest_name'][]  = 'required';
            $rules['guest_email'][] = 'required';
        }

        $data = $request->validate($rules);

        // 3) Honeypot anti-spam: field "website" harus kosong
        if ($request->filled('website')) {
            abort(422, 'Spam detected');
        }

        // 4) Ambil artikel yang published
        $article = Article::published()->findOrFail($articleId);

        // 5) Validasi parent comment (harus milik artikel yang sama)
        if (!empty($data['parent_id'])) {
            $parent = Comment::whereKey($data['parent_id'])
                ->where('article_id', $article->id)
                ->first();

            abort_if(!$parent, 422, 'Invalid parent');
        }

        // 6) Buat komentar
        $comment = new Comment([
            'user_id'    => Auth::id(),
            'guest_name' => $data['guest_name'] ?? null,
            'guest_email'=> $data['guest_email'] ?? null,
            'parent_id'  => $data['parent_id'] ?? null,
            'body'       => $data['body'],
            'status'     => Auth::check() ? 'approved' : 'pending',
            'ip'         => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // 7) Simpan & update hitungan bila approved
        $article->comments()->save($comment);

        if ($comment->status === 'approved') {
            $article->increment('comment_count');
        }

        // 8) Redirect balik ke anchor #comments
        // Kalau route show=route('article.show', $article->slug)
        $to = url()->previous();
        if (str_contains($to, '#') === false) {
            $to .= (str_contains($to, '?') ? '' : '') . '#comments';
        }

        return redirect($to)->with(
            'success',
            $comment->status === 'approved'
                ? 'Komentar dipublikasikan.'
                : 'Komentar masuk moderasi admin.'
        );
    }

    public function moderate(Request $request, int $commentId)
    {
        $request->validate([
            'status' => ['required', 'in:pending,approved,rejected,spam']
        ]);

        $c   = Comment::findOrFail($commentId);
        $old = $c->status;

        $c->status = $request->status;
        $c->save();

        if ($old !== 'approved' && $c->status === 'approved') {
            $c->article->increment('comment_count');
        }
        if ($old === 'approved' && $c->status !== 'approved') {
            $c->article->decrement('comment_count');
        }

        return back()->with('success', 'Status komentar diubah.');
    }
}
