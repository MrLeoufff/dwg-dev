document.addEventListener("DOMContentLoaded", () => {
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        body.classList.add(savedTheme);
        themeToggle.innerHTML = savedTheme === 'dark-mode' ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>';
    }

    themeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        const isDarkMode = body.classList.contains('dark-mode');
        themeToggle.innerHTML = isDarkMode ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>';
        localStorage.setItem('theme', isDarkMode ? 'dark-mode' : 'light-mode');
    });

    window.openSessionsModal = function (name, sessions) {
        document.getElementById('modalTitleSessions').textContent = name;
        const detailsList = document.getElementById('modalDetailsSessions');
        detailsList.innerHTML = '';

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
