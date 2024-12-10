<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\About;
use App\Models\Advertise;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\HomeSection;
use App\Models\News;
use App\Models\ReceivedMail;
use App\Models\SocialMedia;
use App\Models\Subscriber;
use App\Models\Tag;
use Auth;
use Illuminate\Http\Request;
use Mail;

class Homecontroller extends Controller
{
    public function index()
    {
        $breakingNews = News::where('is_breaking_news', 1)->activeEntries()->withLocalize()
            ->orderBy('id', 'DESC')->take(5)->get();

        $sliderNews = News::where('show_at_slider', 1)->activeEntries()->withLocalize()
            ->orderBy('id', 'DESC')->take(7)->get();

        $recentNews = News::activeEntries()->withLocalize()
            ->orderBy('id', 'DESC')->take(6)->get();

        $popularNews = News::where('show_at_popular', 1)->activeEntries()->withLocalize()
            ->orderBy('id', 'DESC')->take(4)->get();

        $homeSection = HomeSection::where('language', getLanguage())->first();

        $categorySectionOne = News::where('category_id', $homeSection->category_section_one)
            ->activeEntries()->withLocalize()
            ->orderBy('id', 'DESC')->take(8)->get();

        $categorySectionTwo = News::where('category_id', $homeSection->category_section_two)
            ->activeEntries()->withLocalize()
            ->orderBy('id', 'DESC')->take(6)->get();

        $categorySectionThree = News::where('category_id', $homeSection->category_section_three)
            ->activeEntries()->withLocalize()
            ->orderBy('id', 'DESC')->take(4)->get();

        $mostViewedPost = News::activeEntries()->withLocalize()
            ->orderBy('views', 'DESC')->take(3)->get();

        $mostCommonTags = $this->mostCommonTags();

        $advertise = Advertise::first();

        return view('frontend.home', compact(
            'breakingNews',
            'sliderNews',
            'recentNews',
            'popularNews',
            'categorySectionOne',
            'categorySectionTwo',
            'categorySectionThree',
            'mostViewedPost',
            'mostCommonTags',
            'advertise'
        ));
    }

    public function showNewsDetail(string $slug)
    {
        $news = News::where('slug', $slug)->activeEntries()->withLocalize()->first();

        $recentNews = News::where('slug', '!=', $news->slug)->activeEntries()->withLocalize()
            ->orderBy('id', 'DESC')->take(4)->get();

        $mostCommonTags = $this->mostCommonTags();

        $previousPost = News::where('id', '<', $news->id)->activeEntries()->withLocalize()
            ->orderBy('id', 'DESC')->first();

        $nextPost = News::where('id', '>', $news->id)->activeEntries()->withLocalize()
            ->orderBy('id', 'ASC')->first();

        $relatedPosts = News::where('slug', '!=', $news->slug)->where('category_id', $news->category_id)
            ->activeEntries()->withLocalize()
            ->take(5)->get();

        $advertise = Advertise::first();

        $socials = SocialMedia::where('status', 1)->get();

        $this->countViews($news);

        return view('frontend.news-detail', compact(
            'news',
            'recentNews',
            'mostCommonTags',
            'previousPost',
            'nextPost',
            'relatedPosts',
            'advertise',
            'socials'
        ));
    }

    public function showNews(Request $request)
    {
        $news = News::query();

        $news->when($request->has('tag'), function ($query) use ($request) {
            $query->whereHas('tags', function ($query) use ($request) {
                $query->where('name', $request->tag);
            });
        });

        $news->when($request->has('category') && !empty($request->category), function ($query) use ($request) {
            $query->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        });

        $news->when($request->has('search'), function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('content', 'LIKE', '%' . $request->search . '%');
            })->orWhereHas('category', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            });
        });

        $news = $news->activeEntries()->withLocalize()->paginate(8);

        $recentNews = News::activeEntries()->withLocalize()
            ->orderBy('id', 'DESC')->take(4)->get();

        $mostCommonTags = $this->mostCommonTags();

        $categories = Category::where(['status' => 1, 'language' => getLanguage()])->get();

        $advertise = Advertise::first();

        return view('frontend.news', compact(
            'news',
            'recentNews',
            'mostCommonTags',
            'categories',
            'advertise'
        ));
    }

    public function countViews($news)
    {
        if (session()->has('viewed_posts')) {
            $postIds = session('viewed_posts');
            if (!in_array($news->id, $postIds)) {
                $postIds[] = $news->id;
                $news->increment('views');
            }
            session(['viewed_posts' => $postIds]);
        } else {
            session(['viewed_posts' => [$news->id]]);
            $news->increment('views');
        }
    }

    public function mostCommonTags()
    {
        return Tag::select('name', \DB::raw('COUNT(*) AS count'))->where('language', getLanguage())
            ->groupBy('name')->orderBy('count', 'DESC')->take(15)->get();
    }

    public function handleComment(Request $request)
    {
        $request->validate([
            'comment' => ['required', 'string', 'max:1000']
        ]);

        Comment::create([
            'news_id' => $request->news_id,
            'user_id' => Auth::user()->id,
            'parent_id' => $request->parent_id,
            'comment' => $request->comment
        ]);

        toast(__('frontend.Comment successfully!'), 'success');

        return redirect()->back();
    }

    public function handleCommentReply(Request $request)
    {
        $request->validate([
            'reply_comment' => ['required', 'string', 'max:1000']
        ]);

        Comment::create([
            'news_id' => $request->news_id,
            'user_id' => Auth::user()->id,
            'parent_id' => $request->parent_id,
            'comment' => $request->reply_comment
        ]);

        toast(__('frontend.Reply comment successfully!'), 'success');

        return redirect()->back();
    }

    public function handleCommentDelete(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        if (Auth::user()->id === $comment->user_id) {
            $comment->delete();
            return response(['status' => 'success', 'message' => __('frontend.Comment deleted successfully!')]);
        }
        return response(['status' => 'error', 'message' => __('frontend.Delete failed!')]);
    }

    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:subscribers,email']
        ], [
            'email.unique' => __('frontend.Email is already subscribed!')
        ]);

        Subscriber::create([
            'email' => $request->email
        ]);

        return response(['status' => 'success', 'message' => __('frontend.Subscribed successfully!')]);
    }

    public function about()
    {
        $about = About::where('language', getLanguage())->first();

        return view('frontend.about', ['about' => $about]);
    }

    public function contact()
    {
        $contact = Contact::where('language', getLanguage())->first();
        $socials = SocialMedia::where('status', 1)->get();

        return view('frontend.contact', ['contact' => $contact, 'socials' => $socials]);
    }

    public function handleContact(Request $request)
    {
        $request->validate([
            'email' => ['required', 'max:255', 'email'],
            'subject' => ['required', 'max:255'],
            'message' => ['required', 'max:500'],
        ]);

        try {
            $toMail = Contact::where('language', 'en')->first();
            Mail::to($toMail->email)->send(new ContactMail($request->subject, $request->message, $request->email));

            ReceivedMail::create([
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message
            ]);

            toast(__('frontend.Message sent successfully!'), 'success');
            return redirect()->back();
        } catch (\Throwable $th) {
            toast(__($th->getMessage()));
        }
    }
}