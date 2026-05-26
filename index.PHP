<?php
$username = "root";
$servername = "127.0.0.1";
$password = "ramzi";
$dbname = "informations";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("erreur de connexion a la base de donnees". $conn->connect_error);
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom']; 
    $age = $_POST['age'];
    $niveau = $_POST['niveau'];
    $service = $_POST['services'];
    $date = $_POST['date'];
    $avis = $_POST['avis'];

    $sql = "INSERT INTO demande (nom, prenom, age, niveau, service, date, avis) VALUES ('$nom', '$prenom', $age , '$niveau','$service', '$date', '$avis')";
    if($conn->query($sql) === TRUE){
       header("location:index.php?message=yes");
    }else{
        
        header("location:index.php?message=no");
    }
}
$conn->close();
?>



<?php
$toastType = '';
$toastMessage = '';
if(isset($_GET['message'])){
    if($_GET['message'] === 'yes'){
        $toastType = 'alert-success';
        $toastMessage = 'Merci, votre demande a été envoyée avec succès.';
    } else {
        $toastType = 'alert-error';
        $toastMessage = 'Une erreur est survenue, merci de réessayer.';
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="forest">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="style.css">
    <title>Demande de services</title>
</head>
<body class="min-h-screen bg-base-200 p-6">
    <div class="mx-auto w-full max-w-5xl">
        <div class="mb-6 flex flex-col gap-4 rounded-3xl border border-base-300 bg-base-100/70 p-6 shadow-xl backdrop-blur-xl md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-4xl font-extrabold tracking-tight text-whitem">Demande de services</h1>
            </div>
            <button id="themeToggle" class="btn btn-outline btn-xs px-4 py-2">Thème sombre</button>
        </div>

        <?php if($toastMessage): ?>
            <div id="toastMessage" class="alert <?= $toastType ?> shadow-lg mb-6 transition-all duration-500">
                <div>
                    <span><?= htmlspecialchars($toastMessage, ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid gap-6 lg:grid-cols-[1.5fr_0.9fr]">
            <div class="card bg-base-100 shadow-2xl ring-1 ring-base-200">
                <div class="card-body p-8">
                    <h2 class="card-title">Votre demande</h2>
                    <p class="text-base-content/70">Remplissez le formulaire et suivez l’aperçu en temps réel.</p>

                    <form action="" method="POST" class="space-y-5 mt-6" id="serviceForm">
                        <div class="grid gap-4 lg:grid-cols-2">
                            <div class="form-control">
                                <label class="label"><span class="label-text">Nom</span></label>
                                <input id="nom" type="text" name="nom" placeholder="Nom" class="input input-bordered w-full" required>
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text">Prénom</span></label>
                                <input id="prenom" type="text" name="prenom" placeholder="Prénom" class="input input-bordered w-full" required>
                            </div>
                        </div>

                        <div class="grid gap-4 lg:grid-cols-2">
                            <div class="form-control">
                                <label class="label"><span class="label-text">Âge</span></label>
                                <input id="age" type="number" name="age" placeholder="Âge" class="input input-bordered w-full" min="1" required>
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text">Niveau scolaire</span></label>
                                <input id="niveau" type="text" name="niveau" placeholder="Niveau scolaire" class="input input-bordered w-full" required>
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Service souhaité</span></label>
                            <input id="services" type="text" name="services" placeholder="Babysitter, lavage du sol, répétiteur..." class="input input-bordered w-full" required>
                        </div>

                        <div class="grid gap-4 lg:grid-cols-2">
                            <div class="form-control">
                                <label class="label"><span class="label-text">Date souhaitée</span></label>
                                <input id="date" type="date" name="date" class="input input-bordered w-full" required>
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text">Style de service</span></label>
                                <select id="styleService" class="select select-bordered w-full">
                                    <option value="Flexible">Flexible</option>
                                    <option value="Urgent">Urgent</option>
                                    <option value="Programmé">Programmé</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Pourquoi ce service ?</span></label>
                            <textarea id="avis" name="avis" placeholder="Expliquez votre besoin..." class="textarea textarea-bordered h-32 w-full" maxlength="280" required></textarea>
                            <span id="charCount" class="text-xs text-base-content/60 mt-2">0 / 280 caractères</span>
                        </div>

                        <div class="form-control mt-6">
                            <button type="submit" class="btn btn-primary btn-block">Envoyer ma demande</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card bg-base-100 shadow-2xl ring-1 ring-base-200">
                <div class="card-body p-8">
                    <h2 class="card-title">Aperçu en direct</h2>
                    <p class="text-base-content/70 mb-5">Suivez la demande telle qu’elle se construit.</p>

                    <div id="previewPanel" class="space-y-4">
                        <div class="rounded-3xl border border-base-200 bg-base-200/80 p-4">
                            <div class="text-sm text-base-content/60">Client</div>
                            <div id="previewName" class="text-xl font-semibold">—</div>
                            <div id="previewPrenom" class="text-sm text-base-content/70">Prénom manquant</div>
                        </div>
                        <div class="rounded-3xl border border-base-200 bg-base-200/80 p-4">
                            <div class="text-sm text-base-content/60">Service</div>
                            <div id="previewService" class="text-xl font-semibold">—</div>
                            <div id="previewStyle" class="text-sm text-base-content/70">Style : Flexible</div>
                        </div>
                        <div class="rounded-3xl border border-base-200 bg-base-200/80 p-4">
                            <div class="text-sm text-base-content/60">Date & niveau</div>
                            <div id="previewDate" class="text-lg font-semibold">—</div>
                            <div id="previewLevel" class="text-sm text-base-content/70">Niveau scolaire</div>
                        </div>
                        <div class="rounded-3xl border border-base-200 bg-base-200/80 p-4">
                            <div class="text-sm text-base-content/60">Pourquoi</div>
                            <div id="previewAvis" class="text-base text-base-content/80 leading-relaxed">Décrivez votre besoin pour obtenir une réponse adaptée.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const previewMap = {
            nom: 'previewName',
            prenom: 'previewPrenom',
            services: 'previewService',
            date: 'previewDate',
            niveau: 'previewLevel',
            avis: 'previewAvis',
            styleService: 'previewStyle'
        };

        const updatePreview = () => {
            Object.entries(previewMap).forEach(([inputId, previewId]) => {
                const input = document.getElementById(inputId);
                const target = document.getElementById(previewId);
                if (!input || !target) return;
                const value = input.value.trim();
                const fallback = {
                    previewName: '—',
                    previewPrenom: 'Prénom manquant',
                    previewService: '—',
                    previewStyle: `Style : ${document.getElementById('styleService').value}`,
                    previewDate: '—',
                    previewLevel: 'Niveau scolaire',
                    previewAvis: 'Décrivez votre besoin pour obtenir une réponse adaptée.'
                };
                target.textContent = value || fallback[previewId] || '';
            });
        };

        document.querySelectorAll('#serviceForm input, #serviceForm textarea, #serviceForm select').forEach(element => {
            element.addEventListener('input', updatePreview);
        });

        const avisField = document.getElementById('avis');
        const charCount = document.getElementById('charCount');
        avisField.addEventListener('input', () => {
            charCount.textContent = `${avisField.value.length} / 280 caractères`;
        });

        const themeToggle = document.getElementById('themeToggle');
        const themes = ['forest', 'dark'];
        let themeIndex = themes.indexOf(document.documentElement.dataset.theme || 'forest');
        const setTheme = index => {
            const theme = themes[index];
            document.documentElement.dataset.theme = theme;
            localStorage.setItem('siteTheme', theme);
            themeToggle.textContent = theme === 'forest' ? 'Thème sombre' : 'Thème clair';
        };

        const storedTheme = localStorage.getItem('siteTheme');
        if(storedTheme && themes.includes(storedTheme)) {
            themeIndex = themes.indexOf(storedTheme);
            setTheme(themeIndex);
        } else {
            setTheme(themeIndex);
        }

        themeToggle.addEventListener('click', () => {
            themeIndex = (themeIndex + 1) % themes.length;
            setTheme(themeIndex);
        });

        updatePreview();
    </script>
</body>
</html>