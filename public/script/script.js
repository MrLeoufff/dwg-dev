document.addEventListener("DOMContentLoaded", () => {
    gsap.registerPlugin(ScrollTrigger);

    gsap.utils.toArray(".card").forEach((card) => {
        const randomX = gsap.utils.random(-200, 200, true); 
        const randomY = gsap.utils.random(-200, 200, true); 
        const randomRotation = gsap.utils.random(-90, 90, true); 

        gsap.fromTo(
            card,
            { opacity: 0, x: randomX, y: randomY, rotation: randomRotation }, 
            {
                opacity: 1,
                x: 0,
                y: 0, 
                rotation: 0,
                scale: 1,
                duration: 2.5,
                ease: "elastic.out(1, 0.5)",
                scrollTrigger: {
                    trigger: card,
                    start: "top 85%",
                    end: "top 10%",
                    toggleActions: "play reverse play reverse", 
                },
            }
        );
    });

    gsap.from(".card h3", {
        scale: 0.8,
        opacity: 0,
        duration: 0.8,
        stagger: 0.2,
        scrollTrigger: {
            trigger: ".card h3",
            start: "top 85%",
        },
    });

    document.querySelectorAll(".learn-more").forEach((button) => {
        button.addEventListener("mouseover", () => {
            gsap.to(button, {
                scale: 1.1,
                duration: 0.3,
                ease: "power1.out",
            });
        });
        button.addEventListener("mouseout", () => {
            gsap.to(button, {
                scale: 1,
                duration: 0.3,
                ease: "power1.out",
            });
        });
    });

    gsap.utils.toArray("#contactForm .form-control, #contactForm button").forEach((element, index) => {
        gsap.fromTo(
            element,
            {
                opacity: 0,
                x: gsap.utils.random(-200, 200, true), 
                y: gsap.utils.random(-200, 200, true),
                rotation: gsap.utils.random(-45, 45, true),
                scale: 0.8, 
            },
            {
                opacity: 1,
                x: 0,
                y: 0, 
                rotation: 0,
                scale: 1, 
                duration: 1.5,
                delay: index * 0.2, 
                ease: "power2.out",
                scrollTrigger: {
                    trigger: "#contactForm",
                    start: "top 85%",
                    toggleActions: "play reverse play reverse", 
                },
            }
        );
    });

    gsap.from("h2", {
        opacity: 0, 
        y: -50, 
        duration: 1, 
        ease: "elastic.out(1, 0.5)", 
        stagger: 0.2,
        scrollTrigger: {
            trigger: "h2", 
            start: "top 85%",
        },
    });

    document.querySelectorAll(".learn-more").forEach((button, index) => {
        button.addEventListener("click", () => {
            const modalTitle = document.getElementById("modalTitle");
            const modalContent = document.getElementById("modalContent");
            const modalDetails = document.getElementById("modalDetails");
            modalDetails.innerHTML = ""; 

            const details = [
                {
                    title: "Création de site avec des CMS",
                    content: "Nous utilisons des CMS populaires pour créer des sites efficaces.",
                    list: [
                        "Installation et configuration de CMS (WordPress, Joomla).",
                        "Hébergement web inclus pendant 1 an.",
                        "Nom de domaine personnalisé.",
                        "Maintenance technique pendant 3 mois.",
                        "Formation à la gestion du site.",
                    ],
                },
                {
                    title: "Site vitrine entièrement personnalisable",
                    content: "Un site vitrine unique, sur mesure.",
                    list: [
                        "Design 100% personnalisé.",
                        "Hébergement web inclus pendant 1 an.",
                        "Nom de domaine personnalisé.",
                        "Optimisation pour le référencement (SEO).",
                        "Maintenance technique pendant 6 mois.",
                    ],
                },
                {
                    title: "Application web de gestion/E-commerce sur mesure",
                    content: "Une application web taillée sur mesure.",
                    list: [
                        "Développement sur mesure selon vos spécifications.",
                        "Hébergement performant inclus pendant 1 an.",
                        "Nom de domaine personnalisé.",
                        "Intégration de paiements sécurisés.",
                        "Système de gestion de produits et commandes.",
                        "Maintenance technique pendant 1 an.",
                        "Formation complète à l'utilisation.",
                    ],
                },
            ];

            const { title, content, list } = details[index];
            modalTitle.innerText = title;
            modalContent.innerText = content;
            modalDetails.innerHTML = list.map((item) => `<li>${item}</li>`).join("");

            const modal = new bootstrap.Modal(document.getElementById("serviceModal"));
            modal.show();
        });
    });
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;

    // Vérifiez si un thème est sauvegardé dans le LocalStorage
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        body.classList.add(savedTheme);
        themeToggle.innerHTML = savedTheme === 'dark-mode' ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>';    }

    // Basculer entre les thèmes
    themeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        const isDarkMode = body.classList.contains('dark-mode');
        themeToggle.innerHTML = isDarkMode ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>';
        localStorage.setItem('theme', isDarkMode ? 'dark-mode' : 'light-mode');
    });
    window.openSessionsModal = function (name, sessions) {
        console.log("Nom de la formation :", name);
        console.log("Sessions :", sessions);

        document.getElementById('modalTitleSessions').textContent = name; // Affiche le nom de la formation
        const detailsList = document.getElementById('modalDetailsSessions');
        detailsList.innerHTML = ''; // Réinitialise la liste des sessions
        console.log("Données JSON transmises :", sessions);

        if (sessions && Array.isArray(sessions) && sessions.length > 0) {
            sessions.forEach((session, index) => {
                const listItem = document.createElement('li');
                listItem.textContent = `Session ${index + 1} - Jour : ${session.day.date.substring(0, 10)} - Début : ${session.startTime.date.substring(11, 16)} - Durée : ${session.duration} minutes`;
                detailsList.appendChild(listItem);
            });
        } else {
            detailsList.innerHTML = '<p>Aucune session disponible pour cette formation.</p>';
        }
    };
});
