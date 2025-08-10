<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{


    public function sendMessage(Request $request)
    {
        $message = strtolower($request->input('message'));  // chuyển về lowercase để so sánh dễ

        $reply = '';

        // Check xem message có chứa keyword truy vấn dữ liệu không
        if (strpos($message, 'thể loại') !== false) {
            $genres = Genre::where('status_genre', 0)->get();
            if ($genres->isEmpty()) {
                $reply = 'Hiện tại chưa có thể loại nào.';
            } else {
                $reply = "Danh mục thể loại hiện có:<br>";
                foreach ($genres as $genre) {
                    $reply .= '- <a class="link" href="' . url('/movies') . '?genres[]=' . $genre->id . '">' . $genre->name_genre . '</a><br>';
                }
            }
        } elseif (strpos($message, 'phim') !== false) {
            $movies = Movie::where('status_movie', '!=', 1)->limit(5)->get();
            if ($movies->isEmpty()) {
                $reply = 'Hiện tại chưa có phim nào.';
            } else {
                $reply = "Một số phim nổi bật:<br>";
                foreach ($movies as $movie) {
                    $reply .= '- <a class="link" href="' . url('/movie/' . $movie->id) . '">' . $movie->name_movie . '</a><br>';
                }
                $reply .= '<br><a class="link" href="' . url('/movies') . '">Xem thêm phim tại đây</a>';
            }
        } else {
            // Nếu không phải các câu lệnh trên thì gọi GPT như cũ
            $response = Http::withHeaders([
                'Authorization' => env('OPENAI_API_KEY'),
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'Bạn là trợ lý hỗ trợ người dùng chọn phim. Chỉ trả lời các câu hỏi liên quan đến phim.'],
                    ['role' => 'user', 'content' => $message],
                ],
                'max_tokens' => 500,
            ]);

            $data = $response->json();
            $reply = $data['choices'][0]['message']['content'] ?? 'Xin lỗi, tôi chưa hiểu câu hỏi của bạn.';
        }

        // Lưu lịch sử vào session
        $chatHistory = session()->get('chatbot_history', []);
        $chatHistory[] = ['role' => 'user', 'message' => $message];
        $chatHistory[] = ['role' => 'bot', 'message' => $reply];
        session(['chatbot_history' => $chatHistory]);

        return response()->json(['reply' => $reply]);
    }

    public function getHistory()
    {
        $chatHistory = session()->get('chatbot_history', []);
        return response()->json($chatHistory);
    }
}
