<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    private $fastApiUrl = 'http://127.0.0.1:8002';  // Thay đổi port từ 8000 sang 8002

    public function __construct()
    {
        $this->middleware('web');
    }

    public function index()
    {
        return view('chatbot.index');
    }

    public function upload(Request $request)
    {
        try {
            Log::info('Upload request received', [
                'headers' => $request->headers->all(),
                'files' => $request->allFiles()
            ]);

            if (!$request->hasFile('document')) {
                Log::warning('No file uploaded');
                return response()->json([
                    'success' => false,
                    'error' => 'No file uploaded'
                ], 400);
            }

            $file = $request->file('document');
            if ($file->getClientOriginalExtension() !== 'pdf') {
                Log::warning('Invalid file type', ['extension' => $file->getClientOriginalExtension()]);
                return response()->json([
                    'success' => false,
                    'error' => 'Only PDF files are allowed'
                ], 400);
            }

            Log::info('Sending file to FastAPI', [
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize()
            ]);

            // Gửi file đến FastAPI server
            $response = Http::attach(
                'file',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )->post($this->fastApiUrl . '/api/chatbot/upload');

            Log::info('FastAPI upload response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Document uploaded successfully'
                ]);
            } else {
                Log::error('FastAPI upload error:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return response()->json([
                    'success' => false,
                    'error' => 'Error uploading document to processing server'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Upload error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function ask(Request $request)
    {
        try {
            Log::info('Ask request received', [
                'headers' => $request->headers->all(),
                'body' => $request->all()
            ]);

            $question = $request->input('question');
            if (!$question) {
                Log::warning('No question provided');
                return response()->json([
                    'success' => false,
                    'error' => 'Question is required'
                ], 400);
            }

            Log::info('Sending question to FastAPI', ['question' => $question]);

            // Gửi câu hỏi đến FastAPI server dưới dạng JSON
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->post($this->fastApiUrl . '/api/chatbot/ask', [
                'question' => $question
            ]);

            Log::info('FastAPI ask response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $answer = $data['answer'] ?? $data['content'] ?? 'No answer available';
                Log::info('Answer received', ['answer' => $answer]);
                return response()->json([
                    'success' => true,
                    'content' => $answer
                ]);
            } else {
                Log::error('FastAPI ask error:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return response()->json([
                    'success' => false,
                    'error' => 'Error getting answer from processing server'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Ask error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
} 