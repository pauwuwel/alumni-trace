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

            $logEntries = Logs::whereIn('action', ['INSERT', 'ACCEPT', 'REJECT'])
                            ->whereIn('table', ['komentar', 'forum'])
                            ->orderBy('date', 'DESC')
                            ->get();

            $notifications = [];

            foreach ($logEntries as $log) {
                if ($log->action === 'INSERT' && $log->table === 'komentar') {
                    $commentId = $log->row;

                    // Fetch the corresponding comment information
                    $comment = Komentar::find($commentId);

                    if ($comment && $comment->id_forum) {
                        // Fetch the corresponding forum information
                        $forum = Forum::find($comment->id_forum);

                        // Check if the comment is made by someone other than the forum creator
                        if ($forum && $forum->id_pembuat != $comment->id_pembuat) {
                            // Check if the forum's creator matches the current user
                            if ($forum && $forum->id_pembuat == $currentUserId) {
                                $forumDate = Carbon::parse($log->date);
                                $diffInMonths = $forumDate->diffInMonths();

                                if ($diffInMonths > 0) {
                                    $formattedDate = $diffInMonths . 'b';
                                } else {
                                    $diffInSeconds = $forumDate->diffInSeconds();
                                    $diffInMinutes = $forumDate->diffInMinutes();
                                    $diffInHours = $forumDate->diffInHours();

                                    if ($diffInSeconds < 60) {
                                        $formattedDate = $diffInSeconds . 'd';
                                    } elseif ($diffInMinutes < 60) {
                                        $formattedDate = $diffInMinutes . 'm';
                                    } elseif ($diffInHours < 24) {
                                        $formattedDate = $diffInHours . 'j';
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
                } elseif (($log->action === 'ACCEPT' || $log->action === 'REJECT') && $log->table === 'forum') {
                    $forumId = $log->row;

                    // Fetch the corresponding forum information
                    $forum = Forum::find($forumId);

                    // Check if the forum's creator matches the current user
                    if ($forum && $forum->id_pembuat == $currentUserId) {
                        $forumDate = Carbon::parse($log->date);
                        $diffInMonths = $forumDate->diffInMonths();

                        if ($diffInMonths > 0) {
                            $formattedDate = $diffInMonths . 'b';
                        } else {
                            $diffInSeconds = $forumDate->diffInSeconds();
                            $diffInMinutes = $forumDate->diffInMinutes();
                            $diffInHours = $forumDate->diffInHours();

                            if ($diffInSeconds < 60) {
                                $formattedDate = $diffInSeconds . 'd';
                            } elseif ($diffInMinutes < 60) {
                                $formattedDate = $diffInMinutes . 'm';
                            } elseif ($diffInHours < 24) {
                                $formattedDate = $diffInHours . 'j';
                            }
                        }

                        $notification = [
                            'id_logs' => $log->id_logs,
                            'actor' => $log->actor,
                            'action' => $log->action,
                            'table' => $log->table,
                            'row' => $log->row,
                            'date' => $log->date,
                            'forum_id' => $forum->id_forum, // Assuming the forum ID column name is 'id_forum'
                            'forum_judul' => $forum->judul,
                            'tanggal_post' => $formattedDate,
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
