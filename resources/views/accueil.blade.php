<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Accueil Afrik'Hub</title>

<style>
/* ======== RESET ======== */
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: "Poppins", sans-serif; background: #f4f4f4; }

/* ======== HEADER (desktop) ======== */
header {
    background: linear-gradient(135deg, #006d77, #00afb9);
    color: white;
    padding: 12px 20px;
    display: none;
    align-items: center;
    justify-content: space-between;
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 50;
    box-shadow: 0 4px 10px rgba(0,0,0,0.25);
}
@media (min-width: 768px) {
    header { display: flex; }
}

header img {
    height: 65px;
    object-fit: contain;
}

header ul {
    display: flex;
    list-style: none;
    gap: 20px;
}

header ul li a {
    color: white;
    font-weight: 600;
    text-decoration: none;
    padding: 6px 12px;
    transition: 0.3s;
    border-radius: 8px;
}

header ul li a:hover {
    background: rgba(255,255,255,0.3);
}

/* ======== TOGGLER MOBILE ======== */
#sidebarToggle {
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 60;
    background: white;
    border: none;
    padding: 10px 14px;
    border-radius: 10px;
    font-size: 20px;
    font-weight: bold;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    display: block;
}
@media (min-width: 768px) {
    #sidebarToggle { display: none; }
}

/* ======== SIDEBAR ======== */
#sidebarOverlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(3px);
    z-index: 59;
    display: none;
}

#sidebar {
    position: fixed;
    top: 0; left: 0;
    height: 100%;
    width: 280px;
    background: linear-gradient(180deg,#006d77,#00afb9);
    color: white;
    transform: translateX(-100%);
    transition: 0.35s ease;
    padding: 20px;
    z-index: 60;
}

#sidebar.open { transform: translateX(0); }
#sidebarOverlay.show { display: block; }

#sidebar .closeBtn {
    font-size: 32px;
    cursor: pointer;
    position: absolute;
    right: 15px;
    top: 10px;
}

#sidebar ul { margin-top: 70px; list-style: none; }
#sidebar ul li {
    margin: 16px 0;
}
#sidebar ul li a {
    color: white;
    font-size: 18px;
    text-decoration: none;
    font-weight: 600;
    display: block;
    padding: 10px 10px;
    border-radius: 8px;
    transition: 0.3s;
}
#sidebar ul li a:hover {
    background: rgba(255,255,255,0.2);
}

/* ======== ACCUEIL SECTION ======== */
#accueil {
    margin-top: 80px;
    background: linear-gradient(rgba(0,91,107,0.7), rgba(0,91,107,0.5)),
                url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e') center/cover;
    height: 680px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 0 1rem;
    color: white;
}

#accueil h2 {
    font-size: 3rem;
    font-weight: 800;
    text-shadow: 3px 3px 10px rgba(0,0,0,0.6);
}

#accueil span {
    font-size: 18px;
    display: block;
    margin-top: 10px;
}

/* BUTTON */
.btn-reserver {
    display: inline-block;
    padding: 12px 28px;
    margin: 12px 6px;
    font-size: 18px;
    font-weight: bold;
    color: #fff;
    background: #007bff;
    border-radius: 30px;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: background 0.3s ease;
    animation: bounce 2s infinite;
}
.btn-reserver:hover { background: #0056b3; }

@keyframes bounce {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* FOOTER */
footer {
    background: #006d77;
    color: white;
    padding: 18px;
    text-align: center;
    font-size: 14px;
    margin-top: 50px;
}
</style>
</head>

<body>

<!-- BUTTON MOBILE -->
<button id="sidebarToggle">☰</button>

<!-- SIDEBAR OVERLAY -->
<div id="sidebarOverlay"></div>

<!-- SIDEBAR -->
<div id="sidebar">
    <span class="closeBtn">&times;</span>
    <ul>
        <li><a href="#">Connexion</a></li>
        <li><a href="#">Inscription</a></li>
        <li><a href="#">Admin</a></li>
        <li><a href="#hebergement">Hébergements</a></li>
        <li><a href="#location">Location</a></li>
        <li><a href="#contact">Contact</a></li>
    </ul>
</div>

<!-- HEADER DESKTOP -->
<header>
    <img src="https://via.placeholder.com/180x60?text=AfrikHub" alt="Logo">
    <ul>
        <li><a href="#">Connexion</a></li>
        <li><a href="#">Inscription</a></li>
        <li><a href="#">Admin</a></li>
        <li><a href="#hebergement">Hébergements</a></li>
        <li><a href="#location">Véhicules</a></li>
        <li><a href="#contact">Contact</a></li>
    </ul>
</header>

<!-- ACCUEIL -->
<section id="accueil">
    <div>
        <h2>Bienvenue</h2>
        <span>Explorez l'Afrique autrement avec Afrik’Hub</span>
        <br><br>
        <a href="#" class="btn-reserver">Réserver</a>
        <a href="#" class="btn-reserver">Ajouter un bien</a>
    </div>
</section>

<footer>
    © 2025 Afrik’Hub — Tous droits réservés
</footer>


<script>
// ========== SIDEBAR SCRIPT ==========
const toggle = document.getElementById("sidebarToggle");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("sidebarOverlay");
const closeBtn = document.querySelector(".closeBtn");

toggle.onclick = () => {
    sidebar.classList.add("open");
    overlay.classList.add("show");
};

closeBtn.onclick = () => {
    sidebar.classList.remove("open");
    overlay.classList.remove("show");
};

overlay.onclick = () => {
    sidebar.classList.remove("open");
    overlay.classList.remove("show");
};
</script>

</body>
</html>
