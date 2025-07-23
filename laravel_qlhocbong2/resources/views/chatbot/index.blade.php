<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chatbot Hỗ Trợ - IUH</title>
    
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;600;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, rgba(161, 199, 224, 0.95) 0%, rgba(41, 128, 185, 0.95) 100%);
        }
        
        .chat-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .message {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .user-message {
            background-color: #e3f2fd;
            margin-left: 2rem;
        }

        .bot-message {
            background-color: #f5f5f5;
            margin-right: 2rem;
        }

        .chat-session {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .chat-session:hover {
            background-color: #f8fafc;
        }

        .chat-session.active {
            background-color: #e3f2fd;
            border-color: #90caf9;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-radius: 50%;
            border-top: 3px solid #3498db;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="antialiased">
    <!-- Header -->
    <header class="hero-gradient text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <a href="{{ url('/') }}" class="hover:opacity-90 transition">
                        <img src="{{ asset('backend/images/logo.png') }}" alt="IUH Logo" class="h-16">
                    </a>
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold">Chatbot Hỗ Trợ</h1>
                        <p class="text-sm md:text-base opacity-90">Trường Đại học Công nghiệp TP.HCM</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Chat Sessions Sidebar -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-lg shadow p-4">
                        <h2 class="text-lg font-semibold mb-4">Cuộc trò chuyện</h2>
                        <button id="newChatBtn" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg mb-4 hover:bg-blue-700 transition">
                            <i class="fas fa-plus mr-2"></i>Cuộc trò chuyện mới
                        </button>
                        <div id="chatSessions" class="space-y-2">
                            <!-- Chat sessions will be added here -->
                        </div>
                    </div>
                </div>

                <!-- Chat Interface -->
                <div class="md:col-span-3">
                    <div class="chat-container p-6">
                        <!-- Document Upload Form -->
                        <form id="uploadForm" class="mb-6">
                            @csrf
                            <div class="mb-4">
                                <label for="document" class="block text-gray-700 font-medium mb-2">Upload PDF Document</label>
                                <div class="flex items-center space-x-4">
                                    <input type="file" class="flex-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="document" name="document" accept=".pdf" required>
                                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Upload</button>
                                </div>
                            </div>
                        </form>

                        <!-- Chat Messages -->
                        <div class="mb-6">
                            <div id="chatHistory" class="h-96 overflow-y-auto p-4 border border-gray-200 rounded-lg mb-4">
                                <!-- Messages will be added here -->
                            </div>
                            
                            <form id="questionForm" class="flex space-x-4">
                                @csrf
                                <input type="text" class="flex-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="question" placeholder="Type your question here..." required>
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>© 2023 Trường Đại học Công nghiệp TP.HCM. Bảo lưu mọi quyền.</p>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const uploadForm = document.getElementById('uploadForm');
        const questionForm = document.getElementById('questionForm');
        const chatHistory = document.getElementById('chatHistory');
        const chatSessions = document.getElementById('chatSessions');
        const newChatBtn = document.getElementById('newChatBtn');

        // Khởi tạo chat session
        let currentSessionId = localStorage.getItem('currentSessionId') || generateSessionId();
        let sessions = JSON.parse(localStorage.getItem('chatSessions')) || {};
        
        if (!sessions[currentSessionId]) {
            sessions[currentSessionId] = {
                id: currentSessionId,
                title: 'Cuộc trò chuyện mới',
                messages: [],
                timestamp: new Date().toISOString()
            };
            saveSessions();
        }

        // Hiển thị chat sessions
        function renderSessions() {
            chatSessions.innerHTML = '';
            Object.values(sessions).sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp)).forEach(session => {
                const sessionDiv = document.createElement('div');
                sessionDiv.className = `chat-session ${session.id === currentSessionId ? 'active' : ''}`;
                sessionDiv.innerHTML = `
                    <div class="flex justify-between items-center">
                        <span class="truncate">${session.title}</span>
                        <button class="delete-session text-red-500 hover:text-red-700" data-session-id="${session.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                sessionDiv.addEventListener('click', (e) => {
                    if (!e.target.closest('.delete-session')) {
                        switchSession(session.id);
                    }
                });
                chatSessions.appendChild(sessionDiv);
            });
        }

        // Chuyển đổi giữa các sessions
        function switchSession(sessionId) {
            // Xóa dữ liệu trong khung chat
            chatHistory.innerHTML = '';
            
            // Cập nhật session hiện tại
            currentSessionId = sessionId;
            localStorage.setItem('currentSessionId', sessionId);
            
            // Hiển thị lại danh sách sessions và messages
            renderSessions();
            renderMessages();
        }

        // Tạo session mới
        newChatBtn.addEventListener('click', () => {
            // Xóa dữ liệu trong khung chat
            chatHistory.innerHTML = '';
            
            const newSessionId = generateSessionId();
            sessions[newSessionId] = {
                id: newSessionId,
                title: 'Cuộc trò chuyện mới',
                messages: [],
                timestamp: new Date().toISOString()
            };
            saveSessions();
            switchSession(newSessionId);
        });

        // Xóa session
        chatSessions.addEventListener('click', (e) => {
            const deleteBtn = e.target.closest('.delete-session');
            if (deleteBtn) {
                const sessionId = deleteBtn.dataset.sessionId;
                if (confirm('Bạn có chắc muốn xóa cuộc trò chuyện này?')) {
                    delete sessions[sessionId];
                    saveSessions();
                    if (sessionId === currentSessionId) {
                        const firstSession = Object.keys(sessions)[0];
                        if (firstSession) {
                            switchSession(firstSession);
                        } else {
                            currentSessionId = generateSessionId();
                            sessions[currentSessionId] = {
                                id: currentSessionId,
                                title: 'Cuộc trò chuyện mới',
                                messages: [],
                                timestamp: new Date().toISOString()
                            };
                            saveSessions();
                        }
                    }
                    renderSessions();
                }
            }
        });

        // Lưu sessions vào localStorage
        function saveSessions() {
            localStorage.setItem('chatSessions', JSON.stringify(sessions));
        }

        // Hiển thị messages
        function renderMessages() {
            chatHistory.innerHTML = '';
            const currentSession = sessions[currentSessionId];
            if (currentSession) {
                currentSession.messages.forEach(msg => {
                    appendMessage(msg.content, msg.type, false);
                });
            }
        }

        // Thêm message mới
        function appendMessage(message, type, save = true) {
            if (!message) return;
            
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${type}-message`;
            messageDiv.textContent = message;
            chatHistory.appendChild(messageDiv);
            chatHistory.scrollTop = chatHistory.scrollHeight;

            if (save) {
                const currentSession = sessions[currentSessionId];
                if (currentSession) {
                    currentSession.messages.push({
                        content: message,
                        type: type,
                        timestamp: new Date().toISOString()
                    });
                    // Cập nhật tiêu đề session nếu là message đầu tiên
                    if (currentSession.messages.length === 1) {
                        currentSession.title = message.substring(0, 30) + (message.length > 30 ? '...' : '');
                    }
                    saveSessions();
                    renderSessions();
                }
            }
        }

        // Upload form handler
        uploadForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const fileInput = document.getElementById('document');
            if (!fileInput.files.length) {
                appendMessage('System: Vui lòng chọn file để upload', 'bot');
                return;
            }

            const formData = new FormData();
            formData.append('document', fileInput.files[0]);
            formData.append('_token', csrfToken);

            try {
                const response = await fetch('/api/chatbot/upload', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                
                if (data.success) {
                    appendMessage('System: Document uploaded successfully!', 'bot');
                } else {
                    appendMessage('System: Error uploading document: ' + (data.error || 'Unknown error'), 'bot');
                }
            } catch (error) {
                appendMessage('System: Error uploading document: ' + error.message, 'bot');
            }
        });

        // Question form handler
        questionForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const questionInput = document.getElementById('question');
            const question = questionInput.value;
            if (!question.trim()) {
                appendMessage('Vui lòng nhập câu hỏi', 'bot');
                return;
            }
            
            // Xóa câu hỏi trong ô input ngay lập tức
            questionInput.value = '';
            
            appendMessage(question, 'user');
            
            try {
                const response = await fetch('/api/chatbot/ask', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        question: question
                    })
                });

                const data = await response.json();

                if (data.success) {
                    const message = data.content || data.answer || 'Không có câu trả lời';
                    appendMessage(message, 'bot');
                } else {
                    appendMessage('Error: ' + (data.error || 'Đã xảy ra lỗi khi xử lý câu hỏi'), 'bot');
                }
            } catch (error) {
                appendMessage('Error: ' + (error.message || 'Đã xảy ra lỗi khi gửi câu hỏi'), 'bot');
            }
        });

        // Helper function to generate session ID
        function generateSessionId() {
            return 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        }

        // Initial render
        renderSessions();
        renderMessages();
    });
    </script>
</body>
</html> 