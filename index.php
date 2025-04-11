<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pneumatique</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>
                <img src="assets/images/download.jpg" alt="Logo">
                <strong>pneuma souche</strong>
            </h1>
            <button class="login-button">Login</button>
        </div>
    </header>
    <nav>
        <ul>
            <li><i class="fa-solid fa-chart-line"></i><a href="index.php"> Dashboard</a></li>
            <li><i class="fa-solid fa-cookie"></i><a href="modules/pneus/pneus.php"> Pneus</a></li>
            <li><i class="fa-solid fa-parachute-box"></i><a href="fournisseurs.php"> Founisseurs</a></li>
            <li><i class="fa-solid fa-truck"></i><a href="vehicules.php"> Vehicules</a></li>
            <li><i class="fa-solid fa-screwdriver-wrench"></i><a href="maintenances.php"> Maintenances</a></li>
            <li><i class="fa-solid fa-rotate"></i><a href="mutations.php"> Mutations</a></li>
            <li><i class="fa-solid fa-dumpster"></i><a href="rebus.php"> Rebus</a></li>
            <li><i class="fa-solid fa-clipboard-list"></i><a href="rapports.php"> Rapports</a></li>
        </ul>
    </nav>
    <main>
        <section class="card">
            <h2>Total de pneu <i class="fa-solid fa-cookie"></i></h2>
            <br>
            <p>Valeur: 123</p>
        </section>
        <section class="card">
            <h2>Pneus en usage <i class="fa-solid fa-cookie"></i></h2>
            <br>
            <p>Valeur: 456</p>
        </section>
        <section class="card">
            <h2>Maintenance <i class="fa-solid fa-screwdriver-wrench"></i></h2>
            <br>
            <p>Valeur: 789</p>
        </section>
        <section class="card">
            <h2>Au rebus <i class="fa-solid fa-dumpster"></i></h2>
            <br>
            <p>Valeur: 789</p>
        </section>
        <section class="table-section">
            <h2>Activitees recentes</h2>
            <div class="search-container">
                <input type="text" placeholder="Rechercher..." name="search">
                <button type="submit"><i class="fas fa-search"></i></button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Auteur</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Mutation</td>
                        <td>20/05/2025 14h00</td>
                        <td>Cedric</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Utilisateur</td>
                        <td>19/05/2025 08h00</td>
                        <td>Expert</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Maintenance</td>
                        <td>18/05/2025 11h00</td>
                        <td>Mecano</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        CopyRight reserved.
    </footer>
</body>
</html>
