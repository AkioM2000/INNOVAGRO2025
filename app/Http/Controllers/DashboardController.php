<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDocuments = Document::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();
        $recentDocuments = Document::where('created_at', '>=', now()->subDays(7))->count();

        $latestDocuments = Document::with('category')
            ->latest()
            ->take(5)
            ->get();

        $documentsByCategory = Category::withCount('documents')
            ->orderBy('documents_count', 'desc')
            ->get();

        return view('dashboard', compact(
            'totalDocuments',
            'totalCategories',
            'totalUsers',
            'recentDocuments',
            'latestDocuments',
            'documentsByCategory'
        ));
    }
}
