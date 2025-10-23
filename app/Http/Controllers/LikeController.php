<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request, int $articleId)
    {
        $article = Article::published()->findOrFail($articleId);

        $userId = Auth::id();
        $fp = $request->input('fp'); // fingerprint dari JS (wajib di sisi klien)
        if (!$userId && !$fp) {
            return response()->json(['ok'=>false,'msg'=>'Fingerprint diperlukan untuk non-login'], 422);
        }

        $query = ArticleLike::where('article_id',$article->id);
        if ($userId) $query->where('user_id',$userId);
        else $query->where('fingerprint',$fp);

        $like = $query->first();

        if ($like) {
            $like->delete();
            return response()->json(['ok'=>true,'liked'=>false]);
        } else {
            ArticleLike::create([
                'article_id'=>$article->id,
                'user_id'=>$userId,
                'fingerprint'=>$userId ? null : $fp,
            ]);
            return response()->json(['ok'=>true,'liked'=>true]);
        }
    }
}
