<x-app-layout>
    <main class="max-w-3xl mx-auto px-6 py-10 w-full">

        <!-- Cabecera -->
        <div style="background:var(--mid); border-radius:16px; padding:1.25rem 1.5rem; margin-bottom:1.5rem; border:1px solid rgba(255,193,147,.15); display:flex; align-items:center; gap:1rem;">
            <a href="{{ route('chat.index') }}" style="color:var(--muted); text-decoration:none; font-size:1.2rem; padding:.25rem .5rem; border-radius:8px; transition:color .2s;"
               onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='var(--muted)'">←</a>
            @if($user->photo)
                <img src="{{ Storage::url($user->photo) }}" style="width:42px; height:42px; border-radius:10px; object-fit:cover; border:2px solid rgba(255,55,55,.3);">
            @else
                <div style="width:42px; height:42px; border-radius:10px; background:linear-gradient(135deg,var(--orange),var(--red)); display:flex; align-items:center; justify-content:center; font-family:'Playfair Display',serif; font-weight:700; color:#fff;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <p style="font-family:'Playfair Display',serif; font-weight:700; color:var(--beige); font-size:1rem;">{{ $user->username }}</p>
                @if($user->city)<p style="color:var(--muted); font-size:.78rem;">{{ $user->city }}</p>@endif
            </div>
        </div>

        <!-- Mensajes -->
        <div id="messages-box" style="background:var(--mid); border-radius:16px; padding:1.5rem; border:1px solid rgba(255,193,147,.15); display:flex; flex-direction:column; gap:.75rem; min-height:400px; max-height:500px; overflow-y:auto; margin-bottom:1rem;">
            @forelse($messages as $msg)
                <div style="display:flex; justify-content:{{ $msg->sender_id === auth()->id() ? 'flex-end' : 'flex-start' }};">
                    <div style="max-width:70%; padding:.65rem 1rem; border-radius:12px; font-size:.88rem; line-height:1.5;
                        {{ $msg->sender_id === auth()->id()
                            ? 'background:var(--red); color:#fff; border-bottom-right-radius:4px;'
                            : 'background:rgba(255,255,255,.07); color:var(--beige); border-bottom-left-radius:4px;' }}">
                        <p>{{ $msg->body }}</p>
                        <p style="font-size:.7rem; opacity:.6; margin-top:.3rem; text-align:right;">{{ $msg->created_at->format('H:i') }}</p>
                    </div>
                </div>
            @empty
                <div style="flex:1; display:flex; align-items:center; justify-content:center; color:var(--muted); font-size:.9rem;">
                    Aún no hay mensajes. ¡Empieza la conversación!
                </div>
            @endforelse
        </div>

        <!-- Input -->
        <div style="background:var(--mid); border-radius:16px; padding:1rem 1.25rem; border:1px solid rgba(255,193,147,.15); display:flex; gap:.75rem; align-items:center;">
            <input id="message-input" type="text" placeholder="Escribe un mensaje..."
                style="flex:1; background:rgba(255,255,255,.05); border:1px solid rgba(255,193,147,.2); border-radius:10px; padding:.65rem 1rem; color:var(--beige); font-size:.9rem; outline:none; transition:border-color .2s;"
                onfocus="this.style.borderColor='var(--orange)'" onblur="this.style.borderColor='rgba(255,193,147,.2)'"
                onkeydown="if(event.key==='Enter') sendMessage()">
            <button onclick="sendMessage()"
                style="padding:.65rem 1.25rem; background:var(--red); color:#fff; border:none; border-radius:10px; font-size:.85rem; font-weight:600; cursor:pointer; transition:background .2s;"
                onmouseover="this.style.background='var(--salmon)'" onmouseout="this.style.background='var(--red)'">
                Enviar
            </button>
        </div>

    </main>

    @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const myId = {{ auth()->id() }};
    const receiverId = {{ $user->id }};
    const sendUrl = "{{ route('chat.send', $user) }}";
    const csrfToken = "{{ csrf_token() }}";

    const box = document.getElementById('messages-box');
    box.scrollTop = box.scrollHeight;

    function appendMessage(body, isMine, time) {
        const wrapper = document.createElement('div');
        wrapper.style.cssText = `display:flex; justify-content:${isMine ? 'flex-end' : 'flex-start'};`;
        const bubble = document.createElement('div');
        bubble.style.cssText = `max-width:70%; padding:.65rem 1rem; border-radius:12px; font-size:.88rem; line-height:1.5;
            ${isMine
                ? 'background:var(--red); color:#fff; border-bottom-right-radius:4px;'
                : 'background:rgba(255,255,255,.07); color:var(--beige); border-bottom-left-radius:4px;'}`;
        bubble.innerHTML = `<p>${body}</p><p style="font-size:.7rem;opacity:.6;margin-top:.3rem;text-align:right;">${time}</p>`;
        wrapper.appendChild(bubble);
        box.appendChild(wrapper);
        box.scrollTop = box.scrollHeight;
    }

    async function sendMessage() {
        const input = document.getElementById('message-input');
        const body = input.value.trim();
        if (!body) return;
        input.value = '';

        try {
            const res = await fetch(sendUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ body }),
            });

            if (!res.ok) {
                const err = await res.text();
                console.error('Error al enviar:', err);
                return;
            }

            const data = await res.json();
            appendMessage(data.body, true, data.created_at);
        } catch (e) {
            console.error('Error de red:', e);
        }
    }

    window.sendMessage = sendMessage;

    window.Echo.private(`chat.${myId}`)
        .listen('MessageSent', (e) => {
            if (e.sender_id === receiverId) {
                appendMessage(e.body, false, e.created_at);
            }
        });
});
</script>
@endpush
</x-app-layout>