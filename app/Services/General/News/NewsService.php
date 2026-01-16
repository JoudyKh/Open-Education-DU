<?php

namespace App\Services\General\News;
use App\Constants\Constants;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsService
{
    /**
     * Create a new class instance.
     */
    protected $isAdmin;
    public function __construct()
    {
        $this->isAdmin = Auth::user()?->hasRole(Constants::SUPER_ADMIN_ROLE);
    }
    public function index(Request $request)
    {
        $news = News::with('images')->orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        if ($request->trash && $this->isAdmin) {
            $news->onlyTrashed();
        }
        $news = $news->paginate(config('app.pagination_limit'));
        return NewsResource::collection($news);
    }
    public function show(News $news)
    {
        return NewsResource::make($news);
    }
}
