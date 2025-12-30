- J'ai utilisé React pour le frontend et comme environnement Node.js avec les fichiers  package.json et node_modules.

- Le fichier services/api.js me sert à récupérer les données de mon backend

- Le fichier App.js stocke les informations 'variables' de mon site, c'est-à-dire que il récupère la liste des produits par exemple depuis ma base de donnée et les affiches, etc...
Au lieu de faire comme du PHP classique ou chaque page est un fichier, App.js me permet de directement simuler la vue avec la variable vue.
Et des que l'utilisateur clique sur un bouton, par exemple payer, acheter, c'est ce fichier qui va envoyer la commande à mon backend PHP

- J'ai géré le style avec du CSS, sans framework particulier.


J'utilise composer comme gestionnaire de dépendances

J'ai opté pour un pattern MVC avec les Controllers, Models et View, pour la logique métier, la gestion avec la BDD et afficher la vue

Le fichier index.php gère globalement les redirections vers les bons controleurs (ProductController, OrderController etc..).
