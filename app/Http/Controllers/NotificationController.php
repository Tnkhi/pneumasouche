<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Notification::with('user');

        // Recherche par terme
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('message', 'like', "%{$searchTerm}%")
                  ->orWhere('type', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(20);
        $notifications->appends($request->query());

        $stats = [
            'total' => Notification::count(),
            'non_lues' => Notification::nonLues()->count(),
            'lues' => Notification::lues()->count(),
            'aujourd_hui' => Notification::whereDate('created_at', today())->count()
        ];

        return view('notifications.index', compact('notifications', 'stats'));
    }

    /**
     * Marquer une notification comme lue
     */
    public function marquerCommeLu(Notification $notification): JsonResponse
    {
        $notification->marquerCommeLu();

        return response()->json([
            'success' => true,
            'message' => 'Notification marquée comme lue'
        ]);
    }

    /**
     * Marquer une notification comme non lue
     */
    public function marquerCommeNonLu(Notification $notification): JsonResponse
    {
        $notification->marquerCommeNonLu();

        return response()->json([
            'success' => true,
            'message' => 'Notification marquée comme non lue'
        ]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function marquerToutesCommeLues(): JsonResponse
    {
        Notification::nonLues()->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Toutes les notifications ont été marquées comme lues'
        ]);
    }

    /**
     * Obtenir les notifications non lues (pour AJAX)
     */
    public function getNonLues(): JsonResponse
    {
        $notifications = Notification::nonLues()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'count' => $notifications->count()
        ]);
    }

    /**
     * Supprimer une notification
     */
    public function destroy(Notification $notification): RedirectResponse
    {
        $notification->delete();

        return redirect()->route('notifications.index')
            ->with('success', 'Notification supprimée avec succès.');
    }

    /**
     * Supprimer toutes les notifications lues
     */
    public function supprimerLues(): RedirectResponse
    {
        $count = Notification::lues()->count();
        Notification::lues()->delete();

        return redirect()->route('notifications.index')
            ->with('success', "{$count} notifications lues ont été supprimées.");
    }


    /**
     * Afficher les détails d'une notification
     */
    public function show(Notification $notification): View
    {
        // Marquer comme lue si ce n'est pas déjà fait
        if (!$notification->is_read) {
            $notification->marquerCommeLu();
        }

        return view('notifications.show', compact('notification'));
    }
}
