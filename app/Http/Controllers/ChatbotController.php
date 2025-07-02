<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DifyService;
use App\Helpers\ResponseFormatter;
use Flasher\Laravel\Http\Response;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    protected DifyService $dify;

    public function __construct(DifyService $dify)
    {
        $this->dify = $dify;
    }

    public function store(Request $request)
    {
        $user = Auth::check() ? Auth::user()->name : 'guest-' . substr(md5(request()->ip()), 0, 8);

        $result = $this->dify->send($request->message, $user, [
            [
                'type'            => 'image',
                'transfer_method' => 'remote_url',
                'url'             => 'https://cloud.dify.ai/logo/logo-site.png'
            ]
        ]);

        $chatHistory = session('chat_history', []);

        $chatHistory[] = [
            'user'     => $user,
            'message'  => $request->message,
            'response' => $result['data']['answer'] ?? 'No response.',
            'time'     => now()->toDateTimeString()
        ];

        session(['chat_history' => $chatHistory]);

        return ResponseFormatter::success(
            'Chatbot response.',
            [
                'answer' => $result['data']['answer'] ?? 'No response.'
            ]
        );
    }

    public function history(Request $request)
    {
        $user = Auth::check() ? Auth::user()->name : 'guest-' . substr(md5(request()->ip()), 0, 8);
        $history = collect(session('chat_history', []))
            ->where('user', $user)
            ->values();

        return response()->json([
            'status' => 'ok',
            'data' => $history
        ]);
    }
}
