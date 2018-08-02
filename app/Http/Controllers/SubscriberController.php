<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticatedRequest;
use App\Http\Requests\Subscriber\StoreRequest;
use App\Repositories\SubscriberRepository;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(StoreRequest $request, SubscriberRepository $repository)
    {
        $subscriber = $repository->firstOrCreate([
            'user_id' => $request->user()->id,
            'locality' => trim($request->locality),
            'street' => trim($request->street),
        ]);

        if($subscriber && $subscriber->wasRecentlyCreated) {
            flash()->success('New place added');
        }elseif($subscriber) {
            flash()->info('Place already watched');
        } else {
            flash()->error('Could not add place to watch');
        }

        return redirect(route('home'));
    }

    public function destroy(AuthenticatedRequest $request, SubscriberRepository $repository, $id)
    {
        $subscriber = $repository->find($id);

        if($subscriber && $subscriber->user_id == $request->user()->id) {
            $repository->delete($id);

            flash()->success('Place deleted');
        }
        else {
            flash()->error('Could not delete place');
        }

        return redirect(route('home'));
    }
}
