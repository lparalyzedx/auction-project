document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("themeToggle");
    if (!btn) return;

    const root = document.documentElement;

    function setTheme(mode) {
        root.classList.remove("light-mode", "dark-mode");
        root.classList.add(mode + "-mode");
        localStorage.setItem("theme", mode);
    }

    function updateIcon() {
        const isDark = root.classList.contains("dark-mode");

        btn.innerHTML = isDark
            ? '<i class="bi bi-moon fs-5"></i>'
            : '<i class="bi bi-sun fs-5"></i>';
    }

    updateIcon();

    btn.addEventListener("click", () => {
        const isDark = root.classList.contains("dark-mode");
        setTheme(isDark ? "light" : "dark");
        updateIcon();
    });
});
