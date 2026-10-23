{{-- Componente Reutilizable: SuperFast Chatbot Widget (Conectado a Vercel) --}}
<div id="sf-chatbot-root" class="sf-chatbot-wrapper" data-csrf="{{ csrf_token() }}" data-endpoint="{{ route('chatbot.message') }}">
    {{-- Ventana Flotante del Chat --}}
    <div id="sf-chatbot-window" class="sf-chatbot-window sf-hidden" role="dialog" aria-modal="false" aria-label="Asistente Virtual SuperFast">
        {{-- Cabecera --}}
        <div class="sf-chatbot-header">
            <div class="sf-chatbot-header-brand">
                <div class="sf-chatbot-avatar">
                    <img src="{{ asset('img/Iconos/Version compacta.jpg') }}" alt="SuperFast" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <span class="sf-chatbot-avatar-fallback" style="display:none;">SF</span>
                    <span class="sf-chatbot-status-dot" title="En lÃ­nea"></span>
                </div>
                <div>
                    <h3 class="sf-chatbot-title">SuperFast Bot</h3>
                    <p class="sf-chatbot-subtitle">Asistente IA â€¢ Conectado a Vercel</p>
                </div>
            </div>
            <div class="sf-chatbot-header-actions">
                <button type="button" id="sf-chatbot-minimize-btn" class="sf-chatbot-icon-btn" aria-label="Minimizar chat" title="Minimizar">
                    <i class="bi bi-dash-lg"></i>
                </button>
                <button type="button" id="sf-chatbot-close-btn" class="sf-chatbot-icon-btn" aria-label="Cerrar chat" title="Cerrar">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>

        {{-- Alerta informativa en caso de error o aviso de configuracin --}}
        <div id="sf-chatbot-banner" class="sf-chatbot-banner sf-hidden">
            <i class="bi bi-info-circle-fill me-1"></i>
            <span id="sf-chatbot-banner-text"></span>
        </div>

        {{-- Contenedor de Mensajes --}}
        <div id="sf-chatbot-messages" class="sf-chatbot-messages" aria-live="polite">
            {{-- Mensaje de bienvenida inicial del Asistente --}}
            <div class="sf-chat-msg sf-chat-msg-bot">
                <div class="sf-chat-bubble">
                    <p class="mb-1"><strong>Â¡Hola! ðŸ‘‹ Bienvenido a SuperFast.</strong></p>
                    <p class="mb-0">Soy tu asistente virtual impulsado por inteligencia artificial. Â¿En quÃ© puedo orientarte hoy sobre comercios, pedidos o cÃ³mo funciona la plataforma?</p>
                </div>
                <span class="sf-chat-time">{{ date('H:i') }}</span>
            </div>
        </div>

        {{-- Pldoras de sugerencias rpidas --}}
        <div id="sf-chatbot-suggestions" class="sf-chatbot-suggestions">
            <button type="button" class="sf-suggestion-chip" data-query="Â¿CÃ³mo hago un pedido en SuperFast?">
                ðŸ›’ Â¿CÃ³mo hacer un pedido?
            </button>
            <button type="button" class="sf-suggestion-chip" data-query="Â¿CÃ³mo puedo registrar mi negocio o restaurante?">
                ðŸª Registrar negocio
            </button>
            <button type="button" class="sf-suggestion-chip" data-query="Â¿CuÃ¡les son los mÃ©todos de pago disponibles?">
                ðŸ’³ MÃ©todos de pago
            </button>
        </div>

        {{-- rea de entrada de texto --}}
        <form id="sf-chatbot-form" class="sf-chatbot-form">
            <div class="sf-chatbot-input-wrapper">
                <input type="text"
                       id="sf-chatbot-input"
                       class="sf-chatbot-input"
                       placeholder="Escribe tu consulta aquÃ­..."
                       maxlength="500"
                       autocomplete="off"
                       required>
                <button type="submit" id="sf-chatbot-submit" class="sf-chatbot-send-btn" aria-label="Enviar mensaje" title="Enviar">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
            <div class="sf-chatbot-footer-caption">
                <span>SuperFast AI â€¢ Backend Serverless Vercel</span>
            </div>
        </form>
    </div>

    {{-- Botn Flotante de Accin (FAB) --}}
    <button type="button"
            id="sf-chatbot-toggle-btn"
            class="sf-chatbot-fab"
            aria-label="Abrir asistente virtual SuperFast"
            aria-expanded="false"
            title="Â¿Tienes preguntas? Chatea con SuperFast Bot">
        <span class="sf-chatbot-fab-ping"></span>
        <span class="sf-chatbot-fab-icon sf-fab-icon-chat">
            <i class="bi bi-chat-dots-fill"></i>
        </span>
        <span class="sf-chatbot-fab-icon sf-fab-icon-close sf-hidden">
            <i class="bi bi-x-lg"></i>
        </span>
    </button>
</div>

<style>
/* ==========================================================================
   ESTILOS ESPECÃFICOS DEL CHATBOT SUPERFAST (AISLADOS Y ARMONIZADOS)
   ========================================================================== */
.sf-chatbot-wrapper {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 9999;
    font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
}

/* Botn Flotante */
.sf-chatbot-fab {
    position: relative;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #FF6B35 0%, #E85822 100%);
    border: none;
    color: #FFFFFF;
    box-shadow: 0 10px 25px -5px rgba(255, 107, 53, 0.5), 0 8px 10px -6px rgba(255, 107, 53, 0.3);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease;
    outline: none;
}

.sf-chatbot-fab:hover {
    transform: scale(1.08);
    box-shadow: 0 14px 28px -4px rgba(255, 107, 53, 0.6), 0 10px 14px -6px rgba(255, 107, 53, 0.4);
}

.sf-chatbot-fab:active {
    transform: scale(0.95);
}

.sf-chatbot-fab-ping {
    position: absolute;
    top: 2px;
    right: 2px;
    width: 14px;
    height: 14px;
    background-color: #22C55E;
    border: 2.5px solid #FFFFFF;
    border-radius: 50%;
}

/* Ventana Flotante */
.sf-chatbot-window {
    position: absolute;
    bottom: 76px;
    right: 0;
    width: 380px;
    max-width: calc(100vw - 32px);
    height: 540px;
    max-height: calc(100vh - 120px);
    background-color: #FFFFFF;
    border-radius: 20px;
    box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.22), 0 0 0 1px rgba(226, 232, 240, 0.8);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: opacity 0.25s ease, transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.25s;
    transform-origin: bottom right;
}

.sf-chatbot-window.sf-hidden {
    opacity: 0;
    visibility: hidden;
    transform: scale(0.92) translateY(16px);
    pointer-events: none;
}

/* Cabecera */
.sf-chatbot-header {
    background: linear-gradient(135deg, #172554 0%, #0F172A 100%);
    border-bottom: 2.5px solid #FF6B35;
    padding: 14px 16px;
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.sf-chatbot-header-brand {
    display: flex;
    align-items: center;
    gap: 10px;
}

.sf-chatbot-avatar {
    position: relative;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background-color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}

.sf-chatbot-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.sf-chatbot-avatar-fallback {
    font-weight: 800;
    color: #FF6B35;
    font-size: 14px;
}

.sf-chatbot-status-dot {
    position: absolute;
    bottom: 1px;
    right: 1px;
    width: 8px;
    height: 8px;
    background-color: #22C55E;
    border-radius: 50%;
    border: 1.5px solid #FFFFFF;
}

.sf-chatbot-title {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #FFFFFF;
    line-height: 1.2;
}

.sf-chatbot-subtitle {
    margin: 0;
    font-size: 11px;
    color: #94A3B8;
}

.sf-chatbot-header-actions {
    display: flex;
    gap: 4px;
}

.sf-chatbot-icon-btn {
    background: transparent;
    border: none;
    color: #94A3B8;
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 15px;
    transition: background-color 0.15s, color 0.15s;
}

.sf-chatbot-icon-btn:hover {
    background-color: rgba(255, 255, 255, 0.12);
    color: #FFFFFF;
}

/* Banner de alerta */
.sf-chatbot-banner {
    background-color: #FEF3C7;
    color: #92400E;
    font-size: 11.5px;
    padding: 7px 12px;
    border-bottom: 1px solid #FDE68A;
    display: flex;
    align-items: center;
    line-height: 1.35;
}

/* Mensajes */
.sf-chatbot-messages {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    background-color: #F8FAFC;
    display: flex;
    flex-direction: column;
    gap: 12px;
    scroll-behavior: smooth;
}

.sf-chat-msg {
    display: flex;
    flex-direction: column;
    max-width: 84%;
    animation: sfFadeIn 0.2s ease-out;
}

@keyframes sfFadeIn {
    from { opacity: 0; transform: translateY(6px); }
    to { opacity: 1; transform: translateY(0); }
}

.sf-chat-msg-bot {
    align-self: flex-start;
}

.sf-chat-msg-user {
    align-self: flex-end;
}

.sf-chat-msg-bot .sf-chat-bubble {
    background-color: #FFFFFF;
    color: #1F2937;
    border: 1px solid #E2E8F0;
    border-radius: 16px 16px 16px 4px;
    padding: 11px 14px;
    font-size: 13.5px;
    line-height: 1.45;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
}

.sf-chat-msg-user .sf-chat-bubble {
    background: linear-gradient(135deg, #FF6B35 0%, #E85822 100%);
    color: #FFFFFF;
    border-radius: 16px 16px 4px 16px;
    padding: 10px 14px;
    font-size: 13.5px;
    line-height: 1.45;
    box-shadow: 0 3px 8px rgba(255, 107, 53, 0.25);
}

.sf-chat-time {
    font-size: 10px;
    color: #94A3B8;
    margin-top: 4px;
    padding: 0 4px;
}

.sf-chat-msg-user .sf-chat-time {
    align-self: flex-end;
}

/* Typing Indicator */
.sf-typing-bubble {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 12px 16px !important;
}

.sf-typing-dot {
    width: 7px;
    height: 7px;
    background-color: #94A3B8;
    border-radius: 50%;
    animation: sfBounce 1.4s infinite ease-in-out both;
}

.sf-typing-dot:nth-child(1) { animation-delay: -0.32s; }
.sf-typing-dot:nth-child(2) { animation-delay: -0.16s; }

@keyframes sfBounce {
    0%, 80%, 100% { transform: scale(0); }
    40% { transform: scale(1); }
}

/* Sugerencias */
.sf-chatbot-suggestions {
    display: flex;
    gap: 6px;
    overflow-x: auto;
    padding: 8px 14px 10px;
    background-color: #F8FAFC;
    border-top: 1px dashed #E2E8F0;
    scrollbar-width: none;
}

.sf-chatbot-suggestions::-webkit-scrollbar {
    display: none;
}

.sf-suggestion-chip {
    white-space: nowrap;
    background-color: #FFFFFF;
    border: 1px solid #CBD5E1;
    color: #334155;
    font-size: 11.5px;
    font-weight: 500;
    border-radius: 20px;
    padding: 5px 11px;
    cursor: pointer;
    transition: all 0.15s ease;
    flex-shrink: 0;
}

.sf-suggestion-chip:hover {
    background-color: #FFF0EB;
    border-color: #FF6B35;
    color: #FF6B35;
    transform: translateY(-1px);
}

/* Formulario e Input */
.sf-chatbot-form {
    background-color: #FFFFFF;
    padding: 12px 14px 8px;
    border-top: 1px solid #E2E8F0;
}

.sf-chatbot-input-wrapper {
    display: flex;
    align-items: center;
    background-color: #F1F5F9;
    border: 1.5px solid #E2E8F0;
    border-radius: 12px;
    padding: 4px 6px 4px 12px;
    transition: border-color 0.2s, background-color 0.2s, box-shadow 0.2s;
}

.sf-chatbot-input-wrapper:focus-within {
    background-color: #FFFFFF;
    border-color: #FF6B35;
    box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.15);
}

.sf-chatbot-input {
    flex: 1;
    border: none;
    background: transparent;
    font-size: 13.5px;
    color: #1F2937;
    outline: none;
    padding: 6px 0;
    font-family: inherit;
}

.sf-chatbot-input::placeholder {
    color: #94A3B8;
}

.sf-chatbot-send-btn {
    background-color: #FF6B35;
    color: #FFFFFF;
    border: none;
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.15s, transform 0.1s;
    outline: none;
}

.sf-chatbot-send-btn:hover {
    background-color: #E85822;
}

.sf-chatbot-send-btn:disabled {
    background-color: #CBD5E1;
    cursor: not-allowed;
    transform: none;
}

.sf-chatbot-footer-caption {
    text-align: center;
    font-size: 10px;
    color: #94A3B8;
    margin-top: 6px;
}

.sf-hidden {
    display: none !important;
}

@media (max-width: 480px) {
    .sf-chatbot-wrapper {
        bottom: 16px;
        right: 16px;
    }
    .sf-chatbot-window {
        position: fixed;
        bottom: 16px;
        right: 16px;
        left: 16px;
        width: auto;
        max-width: none;
        height: calc(100vh - 100px);
        border-radius: 16px;
    }
}
</style>
