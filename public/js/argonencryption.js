
function arrayBufferToBase64(buffer) {
    return btoa(
        String.fromCharCode(...new Uint8Array(buffer))
    );
}

async function encryptPrivateKey(privateKeyJwk, recoveryPassword) {
    const encoder = new TextEncoder();

    const salt = crypto.getRandomValues(new Uint8Array(16));
    const iv = crypto.getRandomValues(new Uint8Array(12));

    const argonResult = await argon2.hash({
        pass: recoveryPassword,
        salt: salt,
        type: argon2.ArgonType.Argon2id,
        time: 3,
        mem: 65536,
        hashLen: 32,
        parallelism: 2
    });

    const encryptionKey = await crypto.subtle.importKey(
        'raw',
        argonResult.hash,
        {
            name: 'AES-GCM'
        },
        false,
        ['encrypt']
    );

    const privateKeyData = encoder.encode(
        JSON.stringify(privateKeyJwk)
    );

    const encrypted = await crypto.subtle.encrypt(
        {
            name: 'AES-GCM',
            iv: iv
        },
        encryptionKey,
        privateKeyData
    );

    return {
        salt: arrayBufferToBase64(salt),
        iv: arrayBufferToBase64(iv),
        ciphertext: arrayBufferToBase64(encrypted)
    };
}

function base64ToUint8Array(base64) {
    const binary = atob(base64);
    const bytes = new Uint8Array(binary.length);

    for (let i = 0; i < binary.length; i++) {
        bytes[i] = binary.charCodeAt(i);
    }

    return bytes;
}

async function extractPrivateKey(recoveryPassword, metaData) {
    const salt = base64ToUint8Array(metaData.salt);
    const iv = base64ToUint8Array(metaData.iv);
    const ciphertext = base64ToUint8Array(metaData.cipherText);


    const argonResult = await argon2.hash({
        pass: recoveryPassword,
        salt: salt,
        type: argon2.ArgonType.Argon2id,
        time: 3,
        mem: 65536,
        hashLen: 32,
        parallelism: 2
    });

    const encryptionKey = await crypto.subtle.importKey(
        'raw',
        argonResult.hash,
        {
            name: 'AES-GCM'
        },
        false,
        ['decrypt']
    );

    const decrypted = await crypto.subtle.decrypt(
        {
            name: 'AES-GCM',
            iv: iv
        },
        encryptionKey,
        ciphertext
    );

    const decoder = new TextDecoder();
    const privateKeyJson = decoder.decode(decrypted);

    return JSON.parse(privateKeyJson);
}



window.encryptPrivateKey = encryptPrivateKey;
window.extractPrivateKey = extractPrivateKey;
