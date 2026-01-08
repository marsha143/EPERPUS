<!-- CORE -->
<script src="./assets/js/core/popper.min.js"></script>
<script src="./assets/js/core/bootstrap.min.js"></script>
<script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>

<!-- PLUGINS -->
<script src="./assets/js/plugins/countup.min.js"></script>
<script src="./assets/js/plugins/choices.min.js"></script>

<!-- MATERIAL KIT  -->
<script src="./assets/js/material-kit.min.js?v=3.0.0"></script>

<!-- CHART.JS (WAJIB SEBELUM chart-kunjungan.js) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- CHART KUNJUNGAN -->
<script src="./assets/js/chart-kunjungan.js"></script>
<script type="text/javascript">
    if (document.getElementById('state1')) {
        const countUp = new CountUp('state1', document.getElementById("state1").getAttribute("countTo"));
        if (!countUp.error) {
            countUp.start();
        } else {
            console.error(countUp.error);
        }
    }
    if (document.getElementById('state2')) {
        const countUp1 = new CountUp('state2', document.getElementById("state2").getAttribute("countTo"));
        if (!countUp1.error) {
            countUp1.start();
        } else {
            console.error(countUp1.error);
        }
    }
    if (document.getElementById('state3')) {
        const countUp2 = new CountUp('state3', document.getElementById("state3").getAttribute("countTo"));
        if (!countUp2.error) {
            countUp2.start();
        } else {
            console.error(countUp2.error);
        };
    }
</script>

<script>
    // get the element to animate
    var element = document.getElementById('count-stats');
    if (element) {
        var elementHeight = element.clientHeight;
    }

    // listen for scroll event and call animate function



    // check if element is in view

    if (document.getElementById('typed')) {
        var typed = new Typed("#typed", {
            stringsElement: '#typed-strings',
            typeSpeed: 90,
            backSpeed: 90,
            backDelay: 200,
            startDelay: 500,
            loop: true
        });
    }
</script>
<script>
    const header = document.querySelector('.page-header');
    if (header && typeof debounce === "function") {
        window.addEventListener('scroll', debounce(() => {
            header.style.transform = `translate3d(0, ${ window.scrollY / 3 }px, 0)`;
        }, 6));
    }
</script>
<script>
    const chatBox = document.getElementById("chat-box");
    const input = document.getElementById("user-input");
    const btn = document.getElementById("send-btn");
    const API_URL = "http://localhost:3000/chat";

    function formatAIResponse(text) {
        const proxyImgRegex = /(http:\/\/localhost:3000\/cover\/[^\s]+)/gi;

        return text.replace(proxyImgRegex, (url) => {
            return `
            <div class="book-cover">
                <img src="${url}" alt="Cover Buku"
                     onerror="this.style.display='none'">
            </div>
        `;
        });
    }

    /* ========= ADD MESSAGE ========= */
    function addMessage(text, type = "ai") {
        const div = document.createElement("div");

        if (type === "user") {
            div.className = "user-message";
            div.innerHTML = text;
        } else {
            div.className = "ai-message";
            div.innerHTML = formatAIResponse(`✨ ${text}`);
        }

        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }


    /* ========= TYPING ========= */
    function addTyping() {
        if (document.getElementById("typing")) return;

        const div = document.createElement("div");
        div.id = "typing";
        div.className = "ai-message";
        div.innerHTML = `
        <span class="typing-dot"></span>
        <span class="typing-dot"></span>
        <span class="typing-dot"></span>
    `;

        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function removeTyping() {
        const t = document.getElementById("typing");
        if (t) t.remove();
    }

    /* ========= GREETING ========= */
    window.addEventListener("load", async () => {
        try {
            const res = await fetch("http://localhost:3000/greeting");
            const data = await res.json();
            addMessage(data.reply, "ai");
        } catch {
            addMessage("Halo! Saya EPERPUS AI 👋", "ai");
        }
    });

    /* ========= SEND ========= */
    async function sendMessage() {
        const msg = input.value.trim();
        if (!msg) return;

        addMessage(msg, "user");
        input.value = "";
        addTyping();

        try {
            const res = await fetch(API_URL, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ message: msg })
            });

            const data = await res.json();
            removeTyping();
            addMessage(data.reply, "ai");
        } catch {
            removeTyping();
            addMessage("⚠️ Server sedang sibuk, coba lagi ya.", "ai");
        }
    }

    /* ========= EVENTS ========= */
    btn.addEventListener("click", sendMessage);
    input.addEventListener("keydown", e => {
        if (e.key === "Enter") sendMessage();
    });

    /* QUICK BUTTON */
    function sendQuick(text) {
        input.value = text;
        sendMessage();
    }


</script>
</body>

</html>