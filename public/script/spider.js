document.addEventListener("DOMContentLoaded", () => {
    const spiderContainer = document.querySelector(".spider-container");
    
    if (!spiderContainer) {
        console.error("Le conteneur .spider-container est introuvable.");
        return;
    }
    
    const observer = new MutationObserver(() => {
        if (document.body.classList.contains("dark-mode")) {
            if (spiderContainer.children.length === 0) {
                addSpiders(spiderContainer, 5);
            }
        } else {
            spiderContainer.innerHTML = ""; // Supprime les araignées si le mode Dark est désactivé
        }
    });

    observer.observe(document.body, { attributes: true, attributeFilter: ["class"] });

    function addSpiders(container, spiderCount) {
        for (let i = 0; i < spiderCount; i++) {
            
            const spider = document.createElement("div");
            spider.classList.add("spider");
            
            const web = document.createElement("div");
            web.classList.add("web");
            
            const body = document.createElement("div");
            body.classList.add("spider-body");
            
            for (let j = 1; j <= 4; j++) {
                const leg = document.createElement("div");
                leg.classList.add("leg", `leg${j}`);
                body.appendChild(leg);
            }
            
            const randomX = Math.random() * 90 + 5;
            spider.style.left = `${randomX}%`;
            spider.style.position = "absolute"; 
            
            spider.appendChild(web);
            spider.appendChild(body);
            container.appendChild(spider);

            attachSpiderEvents(spider);
        }
    }

    function attachSpiderEvents(spider) {
        let clickTimeout;
    
        // Effet de survol
        spider.addEventListener("mouseover", () => {
            spider.classList.add("spider-hover");
        });
    
        spider.addEventListener("mouseleave", () => {
            spider.classList.remove("spider-hover");
        });

        // Déplacement au double-clic
        spider.addEventListener("click", () => {
            clearTimeout(clickTimeout); // Annule le clic simple
            const randomX = Math.random() * 90;
            const randomY = Math.random() * 90;
            spider.style.transform = `translate(${randomX}vw, ${randomY}vh)`;
            spider.style.transition = "transform 1s ease";
        });
    }
});



