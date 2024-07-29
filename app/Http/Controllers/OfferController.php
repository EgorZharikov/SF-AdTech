<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Topic;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    public function index(Offer $offer)
    {
        return view('offer.index', ['offers' => Offer::with('topic')->get()]);
    }

    public function create()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
        return view('offer.create', compact('wallet'));
    }

    public function store()
    {


        $data = request()->validate([
            'title' => '',
            'url' => '',
            'award' => '',
            'content' => '',
            'topic' => '',
            'preview_image' => ['required', 'image'],
            'uniqueIp' => '',
        ]);

        try {

            DB::beginTransaction();
            $data['preview_image'] = Storage::put('/previews', $data['preview_image']);

            $topic = Topic::firstOrCreate([
                'name' => $data['topic'],
            ]);

            Offer::create([
                'title' => $data['title'],
                'url' => $data['url'],
                'award' => $data['award'],
                'content' => $data['content'],
                'preview_image' => $data['preview_image'],
                'topic_id' => $topic->id,
                'user_id' => Auth::id(),
                'unique_ip' => $data['uniqueIp']
            ]);

            DB::commit();

            return redirect()->route('offer.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }

    public function show(Offer $offer)
    {
        return view('offer.show', compact('offer'));
    }

    public function update(Request $request, Offer $offer)
    {
        $data = request()->validate([
            'title' => '',
            'url' => '',
            'award' => '',
            'content' => '',
            'topic' => '',
            'preview_image' => ['required', 'image'],
            'uniqueIp' => '',
        ]);




        try {
            DB::beginTransaction();
            Storage::delete($offer->preview_image);
            $data['preview_image'] = Storage::put('/previews', $data['preview_image']);

            $topic = Topic::firstOrCreate([
                'name' => $data['topic'],
            ]);

            $offer->update([
                'title' => $data['title'],
                'url' => $data['url'],
                'award' => $data['award'],
                'content' => $data['content'],
                'preview_image' => $data['preview_image'],
                'topic_id' => $topic->id,
                'user_id' => Auth::id(),
                'unique_ip' => $data['uniqueIp']
            ]);

            DB::commit();

            return redirect()->route('offer.index');
            
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }

    public function edit(Offer $offer)
    {
        $topic = Topic::where('id', $offer->topic_id)->first();
        $wallet = Wallet::where('user_id', Auth::id())->first();
        return view('offer.edit', compact('wallet', 'offer', 'topic'));
    }

    public function unpublish(Offer $offer)
    {
        $offer->status = 0;
        $offer->save();
        $offer->refresh();

        return redirect()->route('offer.index');
    }
}
