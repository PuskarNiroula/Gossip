import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

import './encryption.js';
import './helper.js';

window.Pusher = Pusher;

const token = localStorage.getItem('token');

window.Echo = new Echo({
    broadcaster: 'reverb',

    key: import.meta.env.VITE_REVERB_APP_KEY,

    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: Number(import.meta.env.VITE_REVERB_PORT ?? 8080),
    wssPort: Number(import.meta.env.VITE_REVERB_PORT ?? 443),

    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',

    enabledTransports: ['ws', 'wss'],

    auth: {
        headers: {
            Authorization: `Bearer ${token}`,
            Accept: 'application/json',
        },
    },
});


if (typeof myId !== "undefined") {
    window.Echo.private(`Message-Channel.${myId}`)
        .listen('.message-sent', (e) => {

            if (String(e.receiver_id) === String(myId)) {
                loadSidebar();

                if (e.conversation_id === conId) {
                    loadMessages(conId);
                }
            }

        });
}

if (typeof myId !== "undefined" ) {
    window.Echo
        .private(`conversation.${myId}`)
        .listen(".messages.read", (e) => {

            console.log("messages.read received:", e);

            if (String(e.conversationId) === String(conId)) {
                loadMessages(conId);
                loadSidebar();
            }
        });
}
