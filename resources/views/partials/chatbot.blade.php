<div id="chatbot-container" class="fixed bottom-4 right-4 z-40 flex flex-col items-end space-y-3">
    <div id="chatbot-box"
        class="hidden flex flex-col bg-white border border-gray-300 rounded-xl shadow-2xl w-80 h-[550px] overflow-hidden transition-all duration-300">

        <div class="bg-primary text-white px-4 py-3 font-semibold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <img data-src="{{ asset('assets/image/bot.png') }}" alt="Avatar Bot"
                    class="size-10 rounded-full object-cover lazyload aspect-square" />
                <div class="text-sm">
                    <div class="text-white font-light text-sm">Chat With</div>
                    <div class="font-semibold text-xs">GulAI Assistant!</div>
                </div>
            </div>
            <button id="chatbot-close-btn" class="hover:text-gray-200">
                <i class="ti ti-x text-lg"></i>
            </button>
        </div>

        <div id="chatbot-messages" class="flex-1 p-3 overflow-y-auto space-y-3 text-sm">
        </div>

        <div class="p-3 border-t border-gray-200">
            <div class="flex gap-2">
                <input id="chatbot-input" type="text" placeholder="Enter your message..."
                    class="flex-1 border border-muted/50 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring focus:border-primary" />
                <x-button id="chatbot-send" class="btn-icon">
                    <i class="ti ti-send text-lg"></i>
                </x-button>
            </div>
        </div>
    </div>

    <div class="relative inline-block">
        <div id="chatbot-toggle-greeting"
            class="absolute bottom-full mb-2 right-0 px-4 py-2 bg-primary text-white text-sm rounded-xl shadow hidden z-10 whitespace-nowrap">
            👋 Hi there! Need help?
        </div>

        <button id="chatbot-toggle-btn"
            class="flex items-center justify-center p-3 text-white bg-primary hover:bg-primary/90 transition-all duration-300 shadow-xl rounded-full"
            title="Chatbot" style="border-radius: 50% 50% 50% 0;">
            <i class="ti ti-message-chatbot-filled text-xl"></i>
            <span class="sr-only">Chatbot</span>
        </button>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/lib/marked.umd.js"></script>
    <script>
        $(function() {
            const $chatbotBox = $('#chatbot-box');
            const $btn = $('#chatbot-toggle-btn');
            const $input = $('#chatbot-input');
            const $send = $('#chatbot-send');
            const $messages = $('#chatbot-messages');
            const $close = $('#chatbot-close-btn');
            let historyLoaded = false;
            let textLoaded = false;
            const TEXT_KEY = 'chatbot_text_hidden_at';
            const EXPIRY_DURATION = 1000 * 60 * 5; // 5 minutes
            const el = $('#chatbot-toggle-greeting');

            const now = Date.now();
            const lastHidden = localStorage.getItem(TEXT_KEY);

            if (!lastHidden || now - parseInt(lastHidden) > EXPIRY_DURATION) {
                if (el) {
                    $btn.css('border-radius', $chatbotBox.hasClass('hidden') ? '0 50% 50% 50%' :
                            '50% 50% 50% 0');
                    el.removeClass('hidden');
                }

                setTimeout(() => {
                    if (el) {
                        textLoaded = true;

                        $btn.css('border-radius', $chatbotBox.hasClass('hidden') ? '50% 50% 50% 0' :
                            '0 50% 50% 50%');

                        el.addClass('hidden');

                        localStorage.setItem(TEXT_KEY, Date.now().toString());
                    }
                }, 5000);
            }

            $btn.on('click', function() {
                $chatbotBox.toggleClass('hidden');
                el.addClass('hidden');
                $btn.css('border-radius', $chatbotBox.hasClass('hidden') ? '50% 50% 50% 0' :
                            '0 50% 50% 50%');
                if (!$chatbotBox.hasClass('hidden') && !historyLoaded) {
                    $.ajax({
                        url: '{{ route('chatbot.history') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success(res) {
                            if (res.data && res.data.length) {
                                res.data.forEach(row => {
                                    appendMessage('user', row.message);
                                    appendMessage('bot', row.response);
                                });
                            }
                        }
                    });
                    historyLoaded = true;
                }
            });

            function sendMessage() {
                const userMessage = $input.val().trim();
                if (!userMessage) return;

                appendMessage('user', userMessage);
                $input.val('');

                $input.prop('disabled', true);
                $send.prop('disabled', true);

                $.ajax({
                    url: '{{ route('chatbot.store') }}',
                    method: 'POST',
                    data: {
                        message: userMessage,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend() {
                        appendMessage('bot', 'Typing...');
                    },
                    success(res) {
                        $('#chatbot-messages .typing').remove();
                        appendMessage('bot', res.data.answer || 'Sorry i can\'t answer that.');
                    },
                    error(err) {
                        $('#chatbot-messages .typing').remove();
                        appendMessage('bot', '❌ An error occurred.');
                    },
                    complete() {
                        $input.prop('disabled', false).focus();
                        $send.prop('disabled', false);
                    }
                });
            }

            $close.on('click', function() {
                $chatbotBox.addClass('hidden');
                $btn.css('border-radius', $chatbotBox.hasClass('hidden') ? '50% 50% 50% 0' :
                    '0 50% 50% 50%');
            });

            $send.on('click', function() {
                sendMessage();
            });

            $input.on('keypress', function(e) {
                if (e.which === 13 && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });

            function appendMessage(sender, text) {
                if (!text) return;
                const messageHtml = `
                <div class="${sender === 'user' ? 'text-right' : 'text-left'} ${text === 'Typing...' ? 'typing' : ''}">
                    <div class="inline-block px-3 py-2 rounded-lg ${sender === 'user' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-800'}">
                        ${marked.parse(text)}
                    </div>
                </div>`;
                $messages.append(messageHtml);
                $messages.scrollTop($messages[0].scrollHeight);
            }
        });
    </script>
@endpush
