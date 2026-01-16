<?php

namespace App\Services\Admin\News;
use App\Http\Requests\Api\Admin\News\CreateNewsRequest;
use App\Http\Requests\Api\Admin\News\UpdateNewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NewsService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function store(CreateNewsRequest $request)
    {
        $data = $request->validated();
        $news = News::create([
            'title' => [
                'ar' => $data['ar_title'],
                'en' => $data['en_title']
            ],
            'description' => [
                'ar' => $data['ar_description'],
                'en' => $data['en_description']
            ],
        ]);
        foreach ($data['images'] as $image) {
            $imagepath = $image->storePublicly('news/images', 'public');
            $news->images()->create(['url' => $imagepath]);
        }
        return NewsResource::make($news);
    }
    public function update(UpdateNewsRequest $request, News $news)
    {
        $data = $request->validated();
        if (isset($data['ar_title'])) {
            $data['title']['ar'] = $data['ar_title'];
        }
        if (isset($data['en_title'])) {
            $data['title']['en'] = $data['en_title'];
        }
        if (isset($data['ar_description'])) {
            $data['description']['ar'] = $data['ar_description'];
        }
        if (isset($data['en_description'])) {
            $data['description']['en'] = $data['en_description'];
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->storePublicly('news/images', 'public');
                $news->images()->create(['url' => $imagePath]);
            }
        }
        if (isset($data['delete_images'])) {
            if (count($news->images) <= 1)
                throw new \Exception(__('messages.can_not_delete_image'), 422);
            $imagesToDelete = $news->images()->whereIn('id', $data['delete_images'])->get();
            foreach ($imagesToDelete as $image) {
                Storage::delete("public/$image->url");
                $news->images()->where('id', $image->id)->delete();
            }
        }
        $news->update($data);
        $news = News::find($news->id);
        return NewsResource::make($news);
    }
    public function destroy($news, $force = null)
    {
        if ($force) {
            $news = News::onlyTrashed()->findOrFail($news);
            // DB::afterCommit(function () use ($news) {
                foreach ($news->images as $image) {
                    if (Storage::exists("public/$image->url"))
                        Storage::delete("public/$image->url");
                }

            // });
            $news->forceDelete();
        } else {
            $news = News::where('id', $news)->first();
            $news->delete();
        }
        return true;
    }
    public function restore($news)
    {
        $news = News::withTrashed()->find($news);
        if ($news && $news->trashed()) {
            $news->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
}
