<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;
use App\Models\Logs;
use App\Models\Komentar;
use App\Models\Forum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layout.index', function ($view) {

            Carbon::setLocale('id');

            $userData = auth()->user();

            $pfp = null;

            $currentUserId = $userData->id_akun; // Assuming you're using authentication

            $logEntries = Logs::where('table', 'komentar')
                ->whereIn('action', ['INSERT'])
                ->orderBy('date', 'DESC')
                ->get();

            $notifications = [];

            foreach ($logEntries as $log) {
                $commentId = $log->row;

                // Fetch the corresponding comment information
                $comment = Komentar::find($commentId);

                if ($comment && $comment->id_forum) {
                    // Fetch the corresponding forum information
                    $forum = Forum::find($comment->id_forum);

                    // Check if the forum's creator matches the current user
                    if ($forum && $forum->id_pembuat == $currentUserId) {

                        $forumDate = Carbon::parse($forum->tanggal_post);

                        $diffInDays = $forumDate->diffInDays();

                        if ($diffInDays > 7) {
                            $diffInWeeks = $forumDate->diffInWeeks();
                             $formattedDate = $diffInWeeks . 'm';
                        } else {
                            $diffInMinutes = $forumDate->diffInMinutes();
                            $diffInHours = $forumDate->diffInHours();
            
                            if ($diffInMinutes < 60) {
                                $formattedDate = $diffInMinutes . 'm';
                            } elseif ($diffInHours < 24) {
                                $formattedDate = $diffInHours . 'j';
                            } else {
                                $formattedDate = $diffInDays . 'h';
                            }
                        }

                        $notification = [
                            'id_logs' => $log->id_logs,
                            'actor' => $log->actor,
                            'action' => $log->action,
                            'table' => $log->table,
                            'row' => $log->row,
                            'date' => $log->date,
                            'id_komentar' => $comment->id_komentar,
                            'komentar' => $comment->komentar,
                            'tanggal_post' => $formattedDate,
                            'forum_id' => $forum->id_forum, // Assuming the forum ID column name is 'id_forum'
                        ];

                        $notifications[] = $notification;
                    }
                }
            }


            if ($userData) {
                if ($userData->role == 'alumni') {
                    if ($userData->alumni->foto !== null) {
                        $pfp = $userData->alumni->foto;
                    }
                } elseif ($userData->role == 'admin') {
                    if ($userData->admin->foto !== null) {
                        $pfp = $userData->admin->foto;
                    }
                } elseif ($userData->role == 'superAdmin') {
                    if ($userData->superAdmin->foto !== null) {
                        $pfp = $userData->superAdmin->foto;
                    }
                }
            }

            $view->with(['pfp' => $pfp, 'notifications' => $notifications]);
        });
    }
}
