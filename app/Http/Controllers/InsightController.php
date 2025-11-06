<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsightController extends Controller
{
    public function index()
    {
        $insights = Insight::where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json($insights);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ]);

        $insight = Insight::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        return response()->json($insight, 201);
    }

    public function update(Request $request, Insight $insight)
    {
        if ($insight->user_id !== Auth::id()) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ]);

        $insight->update($validated);

        return response()->json($insight);
    }

    public function destroy(Insight $insight)
    {
        if ($insight->user_id !== Auth::id()) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $insight->delete();

        return response()->json(null, 204);
    }
}
