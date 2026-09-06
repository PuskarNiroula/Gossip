@extends('Layouts.layout')

@section('title', 'Gossip')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    /* =========================================================
   CHAT LAYOUT - DESKTOP
   ========================================================= */

    .chat-area {
        flex: 1 1 auto;
        min-width: 0;
        min-height: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .chat-messages {
        flex: 1 1 auto;
        min-height: 0;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .chat-input-area {
        flex-shrink: 0;
    }

    .chat-logo {
        flex: 1 1 auto;
        min-width: 0;
        height: 100%;
    }


    /* =========================================================
       TABLET
       ========================================================= */

    @media (max-width: 768px) {

        .chat-sidebar {
            width: 280px;
            min-width: 280px;
        }

        .sidebar-header {
            min-height: 56px;
            padding: 0 14px;
        }

        .sidebar-title h5 {
            font-size: 18px;
        }

        .search-wrap {
            padding-left: 10px;
            padding-right: 10px;
        }

        .chat-item {
            padding: 10px 12px;
        }

        .chat-area {
            min-width: 0;
        }

        .chat-header {
            min-height: 58px;
            padding: 8px 12px;
        }

        .chat-messages {
            padding: 10px;
        }

        .chat-input-area {
            padding: 8px;
        }

        .chat-logo {
            padding: 20px;
            text-align: center;
        }

        .chat-logo img {
            max-width: 180px;
            width: 60%;
            height: auto;
        }
    }


    /* =========================================================
       MOBILE
       ========================================================= */

    @media (max-width: 576px) {

        /*
         * On mobile, don't allow sidebar + chat to squeeze
         * each other. Only one screen should be visible.
         */

        .d-flex.w-100.h-100 {
            width: 100% !important;
            height: 100dvh !important;
            min-height: 0 !important;
            overflow: hidden;
            position: relative;
        }

        .chat-sidebar {
            width: 100%;
            min-width: 100%;
            max-width: 100%;
            height: 100%;
            flex: 0 0 100%;
            border-right: none;
        }

        .chat-sidebar.collapsed {
            display: none;
        }

        .chat-area {
            width: 100%;
            min-width: 100%;
            max-width: 100%;
            height: 100%;
            flex: 0 0 100%;
            min-height: 0;
        }

        .chat-header {
            flex-shrink: 0;
            min-height: 56px;
            padding: 8px 10px;
        }

        .chat-header img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .chat-header h6 {
            max-width: 180px;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-header small {
            font-size: 11px;
        }

        .chat-messages {
            flex: 1 1 0;
            width: 100%;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 8px;
            -webkit-overflow-scrolling: touch;
        }

        .chat-input-area {
            width: 100%;
            flex-shrink: 0;
            min-height: 58px;
            padding: 8px;
            padding-bottom: max(8px, env(safe-area-inset-bottom));
            display: flex;
            gap: 8px;
        }

        #message_to_be_sent {
            min-width: 0;
            flex: 1 1 auto;
            width: auto;
        }

        .btn-send {
            flex: 0 0 42px;
            width: 42px;
            height: 42px;
        }

        .msg-row {
            max-width: 100%;
        }

        .msg-bubble {
            max-width: 82%;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        .msg-text {
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        .chat-logo {
            width: 100%;
            min-width: 100%;
            height: 100%;
            flex: 0 0 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
        }

        .chat-logo img {
            width: min(55vw, 180px);
            max-width: 180px;
            height: auto;
        }

        .chat-logo p {
            font-size: 13px;
            margin-top: 15px;
        }

        /* Search results must stay inside the phone */
        #searchResults {
            width: 100%;
            max-width: 100%;
            left: 0;
            right: 0;
            overflow-x: hidden;
        }

        /* Dropdown should not overflow */
        .dropdown-menu {
            max-width: calc(100vw - 20px);
        }
    }


    /* =========================================================
       VERY SMALL PHONES
       ========================================================= */

    @media (max-width: 380px) {

        .sidebar-header {
            padding: 0 10px;
        }

        .sidebar-title h5 {
            font-size: 17px;
        }

        .chat-header {
            padding: 6px 8px;
        }

        .chat-header img {
            width: 36px;
            height: 36px;
        }

        .chat-header h6 {
            max-width: 140px;
            font-size: 14px;
        }

        .chat-messages {
            padding: 6px;
        }

        .msg-bubble {
            max-width: 88%;
        }

        .chat-input-area {
            padding: 6px;
        }

        #message_to_be_sent {
            font-size: 14px;
        }
    }
</style>
@endsection

@section('content')
    <div class="d-flex w-100 h-100">

        <div class="chat-sidebar" id="chatSidebar">

            <div class="sidebar-header">

                <div class="sidebar-title">
                    <h5>Gossip</h5>
                </div>

                <div class="sidebar-actions">

                    <div class="dropdown">
                        <i class="bi bi-three-dots-vertical"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false"></i>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="/group-chat/create">
                                    <i class="bi bi-people me-2"></i>Create Group Chat
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>



            </div>



            <div class="search-wrap position-relative">
                <i class="bi bi-search search-icon"></i>

                <input type="text"
                       id="searchInput"
                       placeholder="Search or start new chat"
                       autocomplete="off">

                <div id="searchResults"></div>
            </div>

            <div class="chat-list" id="chatList"></div>

        </div>


        <div id="start-chatting" class="chat-area" style="display:none;">

            <div class="chat-header">
                <div class="d-flex align-items-center flex-grow-1">
                    <img id="avatar-pic" src="{{ asset('/images/avatars/avatar.jpg') }}" alt="avatar">
                    <div>
                        <h6 id="chat_user">User</h6>
                        <small id="chat_status">online</small>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div id="group-options" class="dropdown d-none">
                        <i class="bi bi-three-dots-vertical icon-btn"
                           role="button"
                           data-bs-toggle="dropdown"></i>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>
                                <a class="dropdown-item" href="#" onclick="gotoGroupChatEditPage()">
                                    <i class="bi bi-pencil me-2"></i>Edit Group
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#" onclick="gotoGroupDetailsPage()">
                                    <i class="bi bi-info-circle me-2"></i>View Group Details
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="gotoAddMemberPage()">
                                    <i class="bi bi-person-plus me-2"></i>Add Members
                                </a>
                            </li>

                            <li class="admin-only" id="remove-members-option">
                                <a class="dropdown-item text-danger" href="#" onclick="gotoRemoveMembers()">
                                    <i class="bi bi-person-dash me-2"></i>Remove Members
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="leaveGroup()">
                                    <i class="bi bi-box-arrow-right me-2"></i>Leave Group
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="chat-messages" id="chatMessages"></div>

            <div class="chat-input-area">
                <input type="text" id="message_to_be_sent" placeholder="Type a message">
                <button class="btn-send" id="sendBtn">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>

        <div id="logo-image-div" class="chat-logo">
            <img id="logo-image" src="{{ asset('/images/logo.jpeg') }}" alt="We Chat">
            <p>Click on a conversation to start chatting</p>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/groupChatHelpers.js') }}"></script>
    <script>


        const chatSidebar = document.getElementById('chatSidebar');
        const chatSidebarToggle = document.getElementById('chatSidebarToggle');

        let chatSidebarCollapsed =
            localStorage.getItem('chatSidebarCollapsed') === 'true';

        if (chatSidebarCollapsed) {
            chatSidebar.classList.add('collapsed');
        }

        chatSidebarToggle.addEventListener('click', function () {
            chatSidebar.classList.toggle('collapsed');

            const collapsed = chatSidebar.classList.contains('collapsed');

            localStorage.setItem('chatSidebarCollapsed', collapsed);

            if (collapsed) {
                chatSidebarToggle.title = 'Show Chats';
                chatSidebarToggle.querySelector('i').className =
                    'bi bi-layout-sidebar-inset-reverse';
            } else {
                chatSidebarToggle.title = 'Hide Chats';
                chatSidebarToggle.querySelector('i').className =
                    'bi bi-layout-sidebar-inset';
            }
        });


        let selectedUserId = null;
        let conId = null;
        const myId = `{{ Auth::id() }}`;

        const chatMessages = document.getElementById('chatMessages');
        const chatUserEl = document.getElementById('chat_user');
        const sendBtn = document.getElementById('sendBtn');
        const msgInput = document.getElementById('message_to_be_sent');


        function buildBubble({text, time, isSent, avatar, senderName, showAvatar, decryptFailed, isGroup,isRead}) {
            const row = document.createElement('div');
            row.classList.add('msg-row', isSent ? 'sent' : 'received');

            if (!isSent && isGroup) {
                const img = document.createElement('img');
                img.src = avatarUrl(avatar);
                img.className = 'msg-avatar' + (showAvatar ? '' : ' hidden');
                img.alt = '';
                row.appendChild(img);
            }

            const bubble = document.createElement('div');
            bubble.classList.add('msg-bubble', isSent ? 'sent' : 'received');


            if (isGroup) {
                const nameEl = document.createElement('div');
                nameEl.className = 'msg-sender-name';
                nameEl.textContent = senderName;
                bubble.appendChild(nameEl);
            }


            const textEl = document.createElement('div');
            textEl.className = 'msg-text' + (decryptFailed ? ' msg-decrypt-error' : '');
            textEl.textContent = decryptFailed ? '' : text;
            bubble.appendChild(textEl);

            const meta = document.createElement('div');
            meta.className = 'msg-meta';

            const timeEl = document.createElement('span');
            timeEl.className = 'msg-time';
            timeEl.textContent = formatTime(time);
            meta.appendChild(timeEl);

            if (isRead) {
                const ticks = document.createElement('span');
                ticks.className = 'msg-ticks';
                ticks.innerHTML = '<i class="bi bi-check2-all tick-icon"></i>';
                meta.appendChild(ticks);
            }

            bubble.appendChild(meta);
            row.appendChild(bubble);
            return row;
        }

        async function loadMessages(conversationId) {
            try {
                document.getElementById('start-chatting').style.display = 'flex';
                document.getElementById('logo-image-div').style.display = 'none';

                const meta = await secureFetch(`/api/conversation/${conversationId}/meta`);
                document.getElementById('avatar-pic').src = avatarUrl(meta.avatar);
                chatUserEl.textContent = meta.name;

                const groupOptions = document.getElementById('group-options');
                meta.is_group
                    ? groupOptions.classList.remove('d-none')
                    : groupOptions.classList.add('d-none');

                if (meta.is_admin === false) {
                    document.getElementById('remove-members-option').classList.add('d-none');
                }
                if (meta.status === "InActive") {
                    document.querySelector('.chat-input-area').style.display = 'none';
                }


                conId = conversationId;

                const res = await secureFetch(`/getMessages/${conversationId}`, {method: 'GET'});
                const messages = res.messages || [];

                chatMessages.innerHTML = '';

                if (!messages.length) {
                    chatMessages.innerHTML = `
                    <div class="date-divider">
                        <span>No messages yet</span>
                    </div>`;
                    return;
                }
                const lateKeyForThisConversation = getLatestKey(conId);

                const decrypted = await Promise.all(
                    messages.slice().reverse().map(async (msg) => {
                        try {
                            const text = await decryptMessage(msg.message, conId, msg.iv, msg.key_version, lateKeyForThisConversation);
                            return {...msg, text, failed: false};
                        } catch {
                            return {...msg, text: null, failed: true};
                        }
                    })
                );

                let lastDate = null;
                let lastSender = null;

                for (let i = 0; i < decrypted.length; i++) {
                    const msg = decrypted[i];
                    const isSent = msg.sender_id === parseInt(myId);

                    if (!lastDate || !isSameDay(lastDate, msg.time)) {
                        const div = document.createElement('div');
                        div.className = 'date-divider';
                        div.innerHTML = `<span>${formatDate(msg.time)}</span>`;
                        chatMessages.appendChild(div);
                        lastDate = msg.time;
                        lastSender = null;
                    }

                    const showAvatar = msg.sender_id !== lastSender;
                    lastSender = msg.sender_id;


                    if (!msg.failed) {
                        let boolIsRead =false;

                        if(msg.sender_id+"" === myId) {
                            boolIsRead = msg.is_read;
                        }
                        const bubble = buildBubble({
                            text: msg.text,
                            time: msg.time,
                            isSent,
                            avatar: msg.avatar,
                            senderName: null,
                            showAvatar,
                            decryptFailed: msg.failed,
                            isGroup: meta.is_group,
                            isRead:boolIsRead,
                        });
                        chatMessages.appendChild(bubble);
                    }


                }

                chatMessages.scrollTop = chatMessages.scrollHeight;

            } catch (err) {

            }
        }

        async function sendMessage() {
            const message = msgInput.value.trim();
            if (!message || !conId) return;

            msgInput.value = '';

            const tempBubble = buildBubble({
                text: message,
                time: new Date().toISOString(),
                isSent: true,
                showAvatar: false,
                decryptFailed: false,
                isGroup: false,
                isRead: false,
            });
            chatMessages.appendChild(tempBubble);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            try {
                const keyVersion = await getLatestKey(conId);

                const sharedKey = await getSharedKeyByVersion(conId, keyVersion, keyVersion);
                const encrypted = await encryptMessage(message, sharedKey);


                await secureFetch('/sendMessage', {
                    method: 'POST',
                    body: {
                        conversation_id: conId,
                        encrypted_message: encrypted.data,
                        iv: encrypted.iv,
                        key_version: keyVersion,
                    }
                });

                loadSidebar();
            } catch (err) {
                tempBubble.querySelector('.msg-text').classList.add('msg-decrypt-error');
                tempBubble.querySelector('.msg-text').textContent = '⚠ Failed to send';
            }
        }

        sendBtn.addEventListener('click', sendMessage);
        msgInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) sendMessage();
        });

        async function loadSidebar() {
            try {
                const users = await secureFetch('/getSidebarMembers');
                const chatList = document.getElementById('chatList');
                chatList.innerHTML = '';

                for (const user of users) {

                    let preview = '';

                    try {
                        if (user.last_message && user.iv) {
                            preview = await decryptMessage(
                                user.last_message,
                                user.conversation_id,
                                user.iv,
                                user.key_version);
                        }
                    } catch {
                        preview = '';
                    }

                    const item = document.createElement('div');
                    item.className = 'chat-item' + (conId === user.conversation_id ? ' active' : '');

                    item.innerHTML = `
                    <img src="${avatarUrl(user.avatar)}" alt="">
                    <div class="chat-info">
                        <h6>${user.chat_name || 'Unknown'}</h6>
                        <small>${preview}</small>
                    </div>
                    <div class="chat-item-meta">
                        <span class="chat-item-time">${user.last_time ? formatTime(user.last_time) : ''}</span>
                    </div>`;

                    item.addEventListener('click', () => {
                        document.querySelectorAll('.chat-item').forEach(el => el.classList.remove('active'));
                        item.classList.add('active');

                        conId = user.conversation_id;
                        selectedUserId = user.chat_member_id;
                        chatUserEl.textContent = user.chat_name;

                        loadMessages(conId);
                    });

                    chatList.appendChild(item);
                }
            } catch (err) {
            }
        }


        const resultsContainer = document.getElementById('searchResults');
        const searchInput = document.getElementById('searchInput');

        async function search(query) {
            if (!query) {
                resultsContainer.style.display = 'none';
                return;
            }
            resultsContainer.innerHTML = '<div class="search-item text-muted">Searching…</div>';
            resultsContainer.style.display = 'block';

            try {
                const results = await secureFetch(`/search/${encodeURIComponent(query)}`, {method: 'GET'});
                resultsContainer.innerHTML = '';

                if (!results.length) {
                    resultsContainer.style.display = 'none';
                    return;
                }

                results.forEach(({id, name, avatar}) => {
                    const div = document.createElement('div');
                    div.className = 'search-item';
                    div.innerHTML = `
                    <img src="${avatarUrl(avatar)}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;" alt="user Image">
                    <span>${name}</span>`;
                    div.addEventListener('click', () => {
                        resultsContainer.style.display = 'none';
                        searchInput.value = '';
                        createOrOpenChat(id);
                    });
                    resultsContainer.appendChild(div);
                });
            } catch (err) {
            }
        }

        searchInput.addEventListener('input', debounce((e) => search(e.target.value), 500));
        searchInput.addEventListener('blur', () => setTimeout(() => resultsContainer.style.display = 'none', 150));
        searchInput.addEventListener('focus', () => {
            if (searchInput.value.trim()) search(searchInput.value);
        });
        resultsContainer.addEventListener('mousedown', (e) => e.preventDefault());

        async function createOrOpenChat(user_id) {
            try {
                selectedUserId = user_id;
                let data = await secureFetch(`/api/conversation/${user_id}/check`, {method: 'GET'});

                if (!data || !data.conversationId) {
                    data = await createConversation(user_id);
                }

                conId = data.conversationId;
                chatUserEl.textContent = data.name;

                if (data.avatar) {
                    document.getElementById('avatar-pic').src = avatarUrl(data.avatar);
                }

                loadMessages(conId);
            } catch (err) {
            }
        }

        async function createConversation() {
            const roomKey = crypto.getRandomValues(new Uint8Array(16));

            const senderRes = await getMyPublicKey();
            const receiverRes = await getPublicKey(selectedUserId);

            const encryptedRoomKeyForSender = await encryptWithPublicKey(roomKey, senderRes.public_key);
            const encryptedRoomKeyForReceiver = await encryptWithPublicKey(roomKey, receiverRes.public_key);

            const response = await secureFetch('/api/conversation/create-private-conversation', {
                method: 'POST',
                body: {
                    sender_id: myId,
                    receiver_id: selectedUserId,
                    encrypted_room_key_for_sender: encryptedRoomKeyForSender,
                    encrypted_room_key_for_receiver: encryptedRoomKeyForReceiver,
                }

            });
            let key_name = localStorage.getItem('user_id') + "-" + "-" + response.conversationId + "-" + response.latestKeyVersion;
            localStorage.setItem(key_name, encryptedRoomKeyForSender);
            return response;
        }


        document.addEventListener('DOMContentLoaded', () => {
            loadSidebar();
            if (conId && selectedUserId) loadMessages(conId);
        });

        async function leaveGroup() {
            const response = await leaveGroupChat(conId);

            if (response.status === "success") {
                Swal.fire({
                    title: 'Success',
                    text: 'You have left the group successfully',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '/dashboard';
                });
            }
        }

    </script>
@endsection
