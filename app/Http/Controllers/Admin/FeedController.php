<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Feed;
use App\Category;
use App\Article;
use App\RssReader as RssReader;

class FeedController extends Controller
{
    private $reader;

    public function __construct(RssReader $reader)
    {
        parent::__construct();
        $this->reader = $reader;
    }
    public function index()
    {
        $items = Feed::where('user_id', '=', auth()->user()->id)->get();
        $cats = Category::where('user_id', '=', auth()->user()->id)->get();
        return view('feeds.index', ['items' => $items, 'cats' => $cats]);
    }

    public function create(Request $request)
    {
        if (!$request->id) {
            $rules = [
                'url' => 'required|unique:feeds',
            ];
            $request->validate($rules);
            // Create Feed
            $feed = Feed::create([
                        'url' => $request->url,
                        'user_id' => auth()->user()->id,
                        'title' => $request->title,
                    ]);
            if ($request->category_id) {
                $cat = Category::find($request->category_id);
                if ($cat) {
                    $cat->assignFeed($feed);
                }
            }
            return redirect()->action('Admin\FeedController@index')->with(['message-success' => 'Add Feed Success']);
        } else {
            $rules = [
                'url' => 'required|unique:feeds,url,' . $request->id
            ];
            $request->validate($rules);
            // Update Feed
            $feed = Feed::find($request->id);
            if ($feed) {
                $feed->url = $request->url;
                $feed->title = $request->title;
                $feed->save();
                $category = Category::find($request->category_id);
                if ($category) {
                    $feed->clearCategories();
                    $feed->assignCategories($category);
                }
            } else {
                return redirect()->action('Admin\FeedController@index')->with(['message-errors' => 'Feed not found']);
            }
            return redirect()->action('Admin\FeedController@index')->with(['message-success' => 'Update Feed Success']);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->item_delete;
        $cat = Feed::find($id);
        if ($cat) {
            $cat->delete();
        }
        return redirect()->action('Admin\FeedController@index')->with(['message-success' => 'Delete Feed Success']);
    }

    public function articles($id)
    {
        $feed = Feed::find($id);
        $content = $this->reader->parseRss($feed->url);
        $bookmarks = Article::where('user_id', '=', auth()->user()->id)
                            ->pluck('url')->toArray();
        return view('articles.index', ['items' => $content, 'bookmarks' => $bookmarks]);
    }

    public function addArticles(Request $request)
    {
        $article = Article::create([
            'user_id' => auth()->user()->id,
            'url' => $request->url,
            'title' => $request->title,
            'pub_date' => date('Y/m/d H:i:s', strtotime($request->pubdate)),
        ]);
    }

    public function deleteArticles(Request $request)
    {
        Article::where('user_id', '=', auth()->user()->id)
                ->where('url', '=', $request->url)
                ->delete();
    }

    public function bookmarks()
    {
        $articles =  Article::where('user_id', '=', auth()->user()->id)->get();
        return view('articles.bookmarks', ['items' => $articles]);
    }
}
