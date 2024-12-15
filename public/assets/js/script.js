// Gunakan event khusus Laravel atau tambahkan sendiri
document.addEventListener("DOMContentLoaded", initializeEventListeners);

function initializeEventListeners() {
    const hamBurger = document.querySelector(".toggle-btn");
    const navBar = document.querySelector(".navbar-hamburger");
    const sidebarResponsive = document.querySelector(".sidebarResponsive");
    const close = document.querySelector(".close");

    // Logika event listener seperti di atas
    if (hamBurger) {
        hamBurger.addEventListener("click", function () {
            const sidebar = document.querySelector("#sidebar");
            if (sidebar) {
                sidebar.classList.toggle("expand");
            }
        });
    }

    navBar.addEventListener("click", function () {
        sidebarResponsive.classList.add("activeSidebar");
    });
    close.addEventListener("click", function () {
        sidebarResponsive.classList.remove("activeSidebar");
    });
}
