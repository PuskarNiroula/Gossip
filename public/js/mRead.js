
function listenMessageReads(conversationId) {

    window.Echo.private(`conversation.${conversationId}`)
        .listen('.messages.read', (event) => {

            console.log('messages.read RECEIVED:', event);
        });
}
