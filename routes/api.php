<?php

use Illuminate\Support\Facades\Route;
use App\Models\Insight;
use Illuminate\Http\Request;

// API REST para gerenciamento de insights
// Todos os endpoints requerem autenticação via Sanctum

Route::middleware('auth:sanctum')->group(function () {
    
    // POST /insights - Cria um novo insight
    Route::post('/insights', function (Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ]);
        
        $insight = Insight::create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);
        
        return response()->json($insight, 201);
    });
    
    // GET /insights - Lista todos os insights do usuário (mais recente primeiro)
    Route::get('/insights', function (Request $request) {
        $insights = Insight::where('user_id', $request->user()->id)
            ->latest('created_at')
            ->get();
        
        return response()->json($insights);
    });
    
    // DELETE /insights/:id - Remove um insight específico
    Route::delete('/insights/{id}', function (Request $request, $id) {
        $insight = Insight::findOrFail($id);
        
        // Verifica se o insight pertence ao usuário autenticado
        if ($insight->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }
        
        $insight->delete();
        
        return response()->json(null, 204);
    });
});
