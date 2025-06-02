<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentDeletionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Helpers\DateHelper;

class DeletedDocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = DocumentDeletionRequest::with(['requester', 'processor'])
            ->where('status', 'approved');

        // If user is not admin or manager, only show their own deleted files
        if (!Auth::user()->hasRole(['admin', 'manager'])) {
            $query->where('requested_by', Auth::id());
        }

        $query->latest('processed_at');

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('document', function($q) use ($searchTerm) {
                    $q->where('title', 'like', "%{$searchTerm}%")
                        ->orWhere('description', 'like', "%{$searchTerm}%")
                        ->orWhere('file_number', 'like', "%{$searchTerm}%");
                })
                ->orWhereHas('requester', function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%");
                });
            });
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = DateHelper::parseIndonesianDate($request->start_date);
            $endDate = DateHelper::parseIndonesianDate($request->end_date);

            if ($startDate && $endDate) {
                $query->whereBetween('processed_at', [$startDate, $endDate]);
            }
        }

        $deletedDocuments = $query->paginate(10);

        return view('deleted-documents.index', compact('deletedDocuments'));
    }
}
