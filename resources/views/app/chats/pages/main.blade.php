@extends('dashboard.modules.chats.index')
@section('title', 'Chats')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Ajouter une nouvelle discussion</h1>
            <p class="text-muted mb-0">
                Remplissez le formulaire ci-dessous pour ajouter un nouvel utilisateur à l'application.
                <small class="d-block mt-1">Le symbole <span class="text-danger">*</span> indique un champ
                    obligatoire.</small>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('discussions.create') }}" class="btn btn-outline-dark">
                <i class="bi bi-plus"></i><span class="d-none d-sm-inline ms-2">Nouvelle Discussion</span>
            </a>
        </div>
    </div>
    {{-- <style>
        :root {
            --chat-primary: #0d6efd;
            --chat-secondary: #f8f9fa;
            --chat-header-height: 64px;
            --chat-footer-height: 76px;
            --message-max-width: 75%;
            --transition-speed: 0.3s;
        }


        /* Chat Container */
        .chat-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--bs-white);
        }

        /* Chat Header */
        .chat-header {
            height: var(--chat-header-height);
            background: var(--bs-white);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-status {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #198754;
            border: 2px solid white;
            position: absolute;
            bottom: 0;
            right: 0;
        }

        /* Chat Messages */
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
            background: var(--chat-secondary);
        }

        .message {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            max-width: var(--message-max-width);
        }

        .message.sent {
            margin-left: auto;
            flex-direction: row-reverse;
        }

        .message-content {
            background: white;
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            position: relative;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .sent .message-content {
            background: var(--chat-primary);
            color: white;
        }

        .message-text {
            margin-bottom: 0.25rem;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .message-meta {
            font-size: 0.75rem;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sent .message-meta {
            color: rgba(255, 255, 255, 0.8);
            justify-content: flex-end;
        }

        /* Chat Input */
        .chat-input {
            height: var(--chat-footer-height);
            background: white;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .chat-input .form-control {
            border-radius: 1.5rem;
            padding: 0.75rem 1.25rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: all var(--transition-speed);
        }

        .chat-input .form-control:focus {
            border-color: var(--chat-primary);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .chat-input .btn {
            width: 42px;
            height: 42px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .chat-input .btn:hover {
            transform: translateY(-1px);
        }

        /* Scrollbar Styling */
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.2);
        }

        /* Message Status */
        .status-icon {
            font-size: 0.875rem;
        }

        .status-sent {
            color: rgba(255, 255, 255, 0.8);
        }

        .status-delivered {
            color: rgba(255, 255, 255, 0.8);
        }

        .status-read {
            color: #3b82f6;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .chat-header {
                padding: 0.5rem;
            }

            .chat-messages {
                padding: 1rem;
            }

            .message {
                max-width: 85%;
            }

            .chat-input {
                padding: 0.75rem;
            }
        }

        /* Loading Animation */
        @keyframes blink {
            0% {
                opacity: 0.4;
            }

            50% {
                opacity: 0.8;
            }

            100% {
                opacity: 0.4;
            }
        }

        .typing-indicator {
            display: flex;
            gap: 0.25rem;
            padding: 0.75rem 1rem;
            background: white;
            border-radius: 1rem;
            width: fit-content;
            margin-bottom: 1.5rem;
        }

        .typing-dot {
            width: 6px;
            height: 6px;
            background: #6c757d;
            border-radius: 50%;
            animation: blink 1.5s infinite;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }
    </style>
    <div class="chat-container">
        <!-- Chat Header -->
        <div class="chat-header">
            <button class="btn btn-light d-md-none" type="button">
                <i class="bi bi-arrow-left"></i>
            </button>
            <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                    alt="User avatar" class="user-avatar" />
                <div class="user-status"></div>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0">John Doe</h6>
                <small class="text-muted">Online</small>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-light" type="button" title="Voice call">
                    <i class="bi bi-telephone"></i>
                </button>
                <button class="btn btn-light" type="button" title="Video call">
                    <i class="bi bi-camera-video"></i>
                </button>
                <button class="btn btn-light" type="button" title="More options">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
            </div>
        </div>

        <!-- Chat Messages -->
        <div class="chat-messages">
            <!-- Received Message -->
            <div class="message">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                    alt="User avatar" class="user-avatar" />
                <div class="message-content">
                    <div class="message-text">Hi! How are you doing?</div>
                    <div class="message-meta">
                        <span>10:30 AM</span>
                    </div>
                </div>
            </div>

            <!-- Sent Message -->
            <div class="message sent">
                <div class="message-content">
                    <div class="message-text">
                        Hey! I'm doing great, thanks for asking. How about
                        you?
                    </div>
                    <div class="message-meta">
                        <span>10:31 AM</span>
                        <i class="bi bi-check2-all status-icon status-read"></i>
                    </div>
                </div>
            </div>

            <!-- Received Message -->
            <div class="message">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                    alt="User avatar" class="user-avatar" />
                <div class="message-content">
                    <div class="message-text">
                        I'm doing well too! Just working on some new
                        projects.
                    </div>
                    <div class="message-meta">
                        <span>10:32 AM</span>
                    </div>
                </div>
            </div>

            <!-- Sent Message -->
            <div class="message sent">
                <div class="message-content">
                    <div class="message-text">
                        That sounds interesting! What kind of projects are
                        you working on?
                    </div>
                    <div class="message-meta">
                        <span>10:33 AM</span>
                        <i class="bi bi-check2-all status-icon status-delivered"></i>
                    </div>
                </div>
            </div>

            <!-- Typing Indicator -->
            <div class="typing-indicator">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="chat-input">
            <button class="btn btn-light" type="button" title="Add attachment">
                <i class="bi bi-paperclip"></i>
            </button>
            <input type="text" class="form-control" placeholder="Type a message..." aria-label="Type a message" />
            <button class="btn btn-light" type="button" title="Choose emoji">
                <i class="bi bi-emoji-smile"></i>
            </button>
            <button class="btn btn-primary" type="button" title="Send message">
                <i class="bi bi-send"></i>
            </button>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chatMessages = document.querySelector(".chat-messages");
            const messageInput =
                document.querySelector(".chat-input input");
            const sendButton = document.querySelector(
                ".chat-input .btn-primary"
            );

            // Scroll to bottom of messages
            chatMessages.scrollTop = chatMessages.scrollHeight;

            // Send message on enter
            messageInput.addEventListener("keypress", function(e) {
                if (e.key === "Enter" && !e.shiftKey && this.value.trim()) {
                    sendMessage();
                }
            });

            // Send message on button click
            sendButton.addEventListener("click", function() {
                if (messageInput.value.trim()) {
                    sendMessage();
                }
            });

            function sendMessage() {
                const text = messageInput.value.trim();
                const time = new Date().toLocaleTimeString([], {
                    hour: "2-digit",
                    minute: "2-digit",
                });

                const messageHtml = `
                    <div class="message sent">
                        <div class="message-content">
                            <div class="message-text">${text}</div>
                            <div class="message-meta">
                                <span>${time}</span>
                                <i class="bi bi-check2 status-icon status-sent"></i>
                            </div>
                        </div>
                    </div>
                `;

                // Add message to chat
                const typingIndicator =
                    document.querySelector(".typing-indicator");
                typingIndicator.insertAdjacentHTML(
                    "beforebegin",
                    messageHtml
                );

                // Clear input
                messageInput.value = "";

                // Scroll to bottom
                chatMessages.scrollTop = chatMessages.scrollHeight;

                // Simulate message status updates
                setTimeout(() => {
                    const statusIcon = document.querySelector(
                        ".message:last-of-type .status-icon"
                    );
                    statusIcon.classList.remove("bi-check2", "status-sent");
                    statusIcon.classList.add(
                        "bi-check2-all",
                        "status-delivered"
                    );

                    setTimeout(() => {
                        statusIcon.classList.add("status-read");
                    }, 1000);
                }, 1000);
            }
        });
    </script> --}}
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="vh-100">

                </div>
                {{--

                --}}
                <div class="card card-ghost shadow-lg sticky-bottom">
                    <div class="card-body p-3">
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-dark" type="button" title="Add attachment">
                                <i class="bi bi-paperclip"></i>
                            </button>
                            <input type="text" class="form-control" placeholder="Type a message..."
                                aria-label="Type a message" />
                            <button class="btn btn-outline-dark" type="button" title="Choose emoji">
                                <i class="bi bi-emoji-smile"></i>
                            </button>
                            <button class="btn btn-success" type="button" title="Send message">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
