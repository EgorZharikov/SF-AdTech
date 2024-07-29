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



        $data['preview_image'] = Storage::put('/previews', $data['preview_image']);

        try {

            DB::beginTransaction();

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
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }

    public function show(Offer $offer)
    {
        return view('offer.show', compact('offer'));
    }
}
