/**
 * SuperFast Chatbot Client Module
 * Se comunica exclusivamente con el backend de Laravel (/chatbot/message),
 * el cual actúa como BFF seguro hacia el microservicio en Vercel.
 *
 * NUNCA expone credenciales ni tokens privados en el navegador.
 */

class SuperFastChatbot {
    constructor() {
        this.isOpen = false;
        this.isTyping = false;

        // Referencias del DOM
        this.root = document.getElementById('sf-chatbot-root');
        if (!this.root) return;

        // Endpoint relativo y token CSRF inyectados de forma segura desde Laravel
        this.endpoint = this.root.dataset.endpoint || '/chatbot/message';
        this.csrfToken = this.root.dataset.csrf || document.querySelector('meta[name="csrf-token"]')?.content || '';

        this.window = document.getElementById('sf-chatbot-window');
        this.toggleBtn = document.getElementById('sf-chatbot-toggle-btn');
        this.closeBtn = document.getElementById('sf-chatbot-close-btn');
        this.minimizeBtn = document.getElementById('sf-chatbot-minimize-btn');
        this.messagesArea = document.getElementById('sf-chatbot-messages');
        this.suggestionsArea = document.getElementById('sf-chatbot-suggestions');
        this.form = document.getElementById('sf-chatbot-form');
        this.input = document.getElementById('sf-chatbot-input');
        this.submitBtn = document.getElementById('sf-chatbot-submit');
        this.banner = document.getElementById('sf-chatbot-banner');
        this.bannerText = document.getElementById('sf-chatbot-banner-text');

        this.fabIconChat = this.toggleBtn.querySelector('.sf-fab-icon-chat');
        this.fabIconClose = this.toggleBtn.querySelector('.sf-fab-icon-close');

        this.init();
    }

    init() {
        // Eventos de apertura / cierre
        this.toggleBtn.addEventListener('click', () => this.toggleChat());
        if (this.closeBtn) this.closeBtn.addEventListener('click', () => this.closeChat());
        if (this.minimizeBtn) this.minimizeBtn.addEventListener('click', () => this.closeChat());

        // Cerrar con tecla Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.closeChat();
            }
        });

        // Evento de envío de formulario
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            const text = this.input.value.trim();
            if (text && !this.isTyping) {
                this.handleSendMessage(text);
            }
        });

        // Eventos en píldoras de sugerencias
        if (this.suggestionsArea) {
            this.suggestionsArea.addEventListener('click', (e) => {
                const chip = e.target.closest('.sf-suggestion-chip');
                if (chip && !this.isTyping) {
                    const query = chip.getAttribute('data-query');
                    if (query) {
                        this.handleSendMessage(query);
                    }
                }
            });
        }
    }

    toggleChat() {
        if (this.isOpen) {
            this.closeChat();
        } else {
            this.openChat();
        }
    }

    openChat() {
        this.isOpen = true;
        this.window.classList.remove('sf-hidden');
        this.toggleBtn.setAttribute('aria-expanded', 'true');
        if (this.fabIconChat) this.fabIconChat.classList.add('sf-hidden');
        if (this.fabIconClose) this.fabIconClose.classList.remove('sf-hidden');

        setTimeout(() => {
            this.scrollToBottom();
            if (window.innerWidth > 480) {
                this.input.focus();
            }
        }, 100);
    }

    closeChat() {
        this.isOpen = false;
        this.window.classList.add('sf-hidden');
        this.toggleBtn.setAttribute('aria-expanded', 'false');
        if (this.fabIconChat) this.fabIconChat.classList.remove('sf-hidden');
        if (this.fabIconClose) this.fabIconClose.classList.add('sf-hidden');
    }

    async handleSendMessage(text) {
        if (this.isTyping) return;

        // 1. Mostrar mensaje del usuario en la interfaz
        this.appendMessage('user', text);
        this.input.value = '';
        this.isTyping = true;
        this.submitBtn.disabled = true;

        // 2. Mostrar indicador de mecanografía
        this.showTypingIndicator();
        this.scrollToBottom();

        // 3. Ocultar sugerencias tras el primer mensaje
        if (this.suggestionsArea) {
            this.suggestionsArea.style.display = 'none';
        }

        try {
            // Petición al endpoint interno de Laravel (protegido por CSRF y Rate Limit)
            const response = await fetch(this.endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ message: text })
            });

            this.hideTypingIndicator();

            if (response.status === 429) {
                this.appendMessage('bot', '⏳ Has alcanzado el límite de 10 mensajes por minuto. Por favor espera un momento.');
                return;
            }

            if (response.status === 419) {
                this.appendMessage('bot', '⚠️ La sesión ha expirado. Por favor recarga la página para continuar chateando.');
                return;
            }

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                const errorMessage = data.error || `Error del servidor (${response.status})`;
                this.appendMessage('bot', `⚠️ ${errorMessage}`);
                return;
            }

            const reply = data.reply || 'No se recibió respuesta del modelo.';
            this.appendMessage('bot', reply);

        } catch (error) {
            console.error('[SuperFast Chatbot Error]', error);
            this.hideTypingIndicator();
            this.appendMessage('bot', '🔌 No se pudo comunicar con el servidor de SuperFast. Revisa tu conexión a internet.');
        } finally {
            this.isTyping = false;
            this.submitBtn.disabled = false;
            this.scrollToBottom();
            if (window.innerWidth > 480) {
                this.input.focus();
            }
        }
    }

    appendMessage(role, text) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `sf-chat-msg sf-chat-msg-${role}`;

        const bubbleDiv = document.createElement('div');
        bubbleDiv.className = 'sf-chat-bubble';

        const formattedHtml = this.formatMarkdown(text);
        bubbleDiv.innerHTML = formattedHtml;

        const timeSpan = document.createElement('span');
        timeSpan.className = 'sf-chat-time';
        const now = new Date();
        timeSpan.textContent = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;

        msgDiv.appendChild(bubbleDiv);
        msgDiv.appendChild(timeSpan);

        this.messagesArea.appendChild(msgDiv);
    }

    formatMarkdown(text) {
        if (!text) return '';
        let safe = text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        safe = safe.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        // Convertir viñetas markdown (- o *) a puntos limpios
        safe = safe.replace(/(?:^|\n)[-*]\s+(.+)/g, '<br>• $1');
        safe = safe.replace(/\n/g, '<br>');

        return safe;
    }

    showTypingIndicator() {
        this.hideTypingIndicator();
        const typingDiv = document.createElement('div');
        typingDiv.id = 'sf-chatbot-typing-indicator';
        typingDiv.className = 'sf-chat-msg sf-chat-msg-bot';
        typingDiv.innerHTML = `
            <div class="sf-chat-bubble sf-typing-bubble">
                <span class="sf-typing-dot"></span>
                <span class="sf-typing-dot"></span>
                <span class="sf-typing-dot"></span>
            </div>
        `;
        this.messagesArea.appendChild(typingDiv);
    }

    hideTypingIndicator() {
        const typing = document.getElementById('sf-chatbot-typing-indicator');
        if (typing) typing.remove();
    }

    scrollToBottom() {
        if (this.messagesArea) {
            this.messagesArea.scrollTop = this.messagesArea.scrollHeight;
        }
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => new SuperFastChatbot());
} else {
    new SuperFastChatbot();
}

export default SuperFastChatbot;
