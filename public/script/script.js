document.addEventListener("DOMContentLoaded", () => {
    gsap.registerPlugin(ScrollTrigger);

    // Animation douce des cartes au scroll
    gsap.utils.toArray(".card").forEach((card) => {
        gsap.fromTo(
            card,
            { opacity: 0, y: 50 },
            {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: card,
                    start: "top 85%",
                },
            }
        );
    });

    // Animation douce des titres
    gsap.from("h2", {
        opacity: 0,
        y: -20,
        duration: 0.8,
        ease: "power2.out",
        stagger: 0.2,
        scrollTrigger: {
            trigger: "h2",
            start: "top 85%",
        },
    });

    // Animation des boutons
    document.querySelectorAll(".learn-more").forEach((button) => {
        button.addEventListener("mouseover", () => {
            gsap.to(button, { scale: 1.05, duration: 0.2 });
        });
        button.addEventListener("mouseout", () => {
            gsap.to(button, { scale: 1, duration: 0.2 });
        });
    });

    // Gestion des modales
    document.querySelectorAll(".learn-more").forEach((button, index) => {
        button.addEventListener("click", () => {
            const modalTitle = document.getElementById("modalTitle");
            const modalContent = document.getElementById("modalContent");
            const modalDetails = document.getElementById("modalDetails");
            modalDetails.innerHTML = "";

            const details = [
                {
                    title: "Création de site avec des CMS",
                    content: "Sites efficaces avec WordPress, Joomla, etc.",
                    list: [
                        "Installation et configuration",
                        "Hébergement 1 an",
                        "Nom de domaine",
                        "Maintenance 3 mois",
                        "Formation utilisateur",
                    ],
                },
                {
                    title: "Site vitrine personnalisé",
                    content: "Un design unique adapté à vos besoins.",
                    list: [
                        "Design sur mesure",
                        "Hébergement 1 an",
                        "Nom de domaine",
                        "SEO optimisé",
                        "Maintenance 6 mois",
                    ],
                },
                {
                    title: "E-commerce sur mesure",
                    content: "Une solution adaptée pour la vente en ligne.",
                    list: [
                        "Développement personnalisé",
                        "Hébergement performant",
                        "Paiements sécurisés",
                        "Gestion des produits et commandes",
                        "Maintenance 1 an",
                    ],
                },
            ];

            const { title, content, list } = details[index];
            modalTitle.innerText = title;
            modalContent.innerText = content;
            modalDetails.innerHTML = list.map((item) => `<li>${item}</li>`).join("");

            new bootstrap.Modal(document.getElementById("serviceModal")).show();
        });
    });

    // Gestion du mode sombre
    const themeToggle = document.getElementById("theme-toggle");
    const body = document.body;

    // Appliquer le thème sauvegardé
    const savedTheme = localStorage.getItem("theme") || "dark-mode";
    body.classList.add(savedTheme);
    themeToggle.innerHTML = savedTheme === "dark-mode" ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>';

    // Toggle du mode sombre
    themeToggle.addEventListener("click", () => {
        body.classList.toggle("dark-mode");
        const isDarkMode = body.classList.contains("dark-mode");
        themeToggle.innerHTML = isDarkMode ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>';
        localStorage.setItem("theme", isDarkMode ? "dark-mode" : "light-mode");
    });

    // Gestion des sessions modales
    window.openSessionsModal = function (name, sessions) {
        document.getElementById("modalTitleSessions").textContent = name;
        const detailsList = document.getElementById("modalDetailsSessions");
        detailsList.innerHTML = "";

        if (sessions && Array.isArray(sessions) && sessions.length > 0) {
            sessions.forEach((session, index) => {
                const listItem = document.createElement("li");
                listItem.textContent = `Session ${index + 1} - Jour : ${session.day.date.substring(0, 10)} - Début : ${session.startTime.date.substring(11, 16)} - Durée : ${session.duration} min`;
                detailsList.appendChild(listItem);
            });
        } else {
            detailsList.innerHTML = "<p>Aucune session disponible.</p>";
        }
    };
});
