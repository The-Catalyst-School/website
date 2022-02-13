<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Workshop;

class CommentController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function create($entity_type, $entity_id)
    {
        $entity = [
          'type' => $entity_type,
          'id' => $entity_id,
        ];
        return Inertia::render('Comment/Create', compact('entity'));
    }

    /**
     * Handle an incoming authentication request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
          'content' => ['required'],
          'entity.type' => Rule::in(['Course', 'Lesson', 'Workshop']),
          'entity.id' => ['required']
        ]);
        $entity = $request->input('entity');
        $content = $request->input('content');
        $lentity = ('\\App\\Models\\' . $entity['type'] . '::find')($entity['id'])->comments()
          ->create([
            'content' => $content,
            'user_id' => Auth::user()->id
          ]);
        return Redirect::back()->with('success', 'Comment posted!');
    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect::back()->with('success', 'Logout succeed!');
    }
}
