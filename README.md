# La Boîte Noire de Lo — site vitrine

Site vitrine développé pour une photographe indépendante spécialisée en spectacle vivant,
événementiel et photographie associative. Projet réel, développé de bout en bout (cadrage,
direction artistique, développement, administration de contenu) pour une cliente.

🔗 **Démo en ligne** : *à venir*
📸 **Aperçu** : *captures d'écran à ajouter*

---

## Stack technique

- **Backend** : PHP 8.2, Symfony 7
- **Base de données** : MySQL, Doctrine ORM
- **Templating** : Twig, composants Twig (`symfony/ux-twig-component`)
- **Admin** : EasyAdminBundle
- **Gestion d'images** : VichUploaderBundle (upload) + LiipImagineBundle (génération de
  variantes WebP à la volée : miniatures, formats portfolio)
- **Frontend** : CSS custom (pas de framework type Bootstrap), polices auto-hébergées
  (Poppins, Inter), pas de dépendance CDN
- **Tests** : *(à compléter selon avancement)*

## Fonctionnalités

- Vitrine publique : accueil, portfolio filtré par catégorie, page contact
- Formulaire de contact avec validation et envoi d'email (Symfony Mailer)
- Back-office (EasyAdmin) permettant à la cliente de gérer elle-même ses catégories et
  ses photos, sans intervention technique
- Upload d'images avec génération automatique de variantes optimisées (WebP, plusieurs
  résolutions) via LiipImagineBundle
- Composant Twig réutilisable pour les blocs éditoriaux photo + titre (alternance
  gauche/droite, tailles de titre variables), reproduisant fidèlement la direction
  artistique validée avec la cliente

## Points techniques à noter

- **Direction artistique pilotée par le contenu existant de la cliente** : la charte
  (typographie, palette, mise en page éditoriale avec titres qui chevauchent les photos)
  a été extraite et reproduite à partir de son book PDF existant, pas inventée à partir
  de rien.
- **Composant Twig anonyme** (`PhotoTitreBloc`) pour éviter la duplication de markup
  entre les sections de la page d'accueil et du portfolio.
- **Pas de CDN externe** : polices et icônes auto-hébergées pour la fiabilité et les
  performances (indépendance vis-à-vis de services tiers).
- **Scope volontairement maîtrisé** : pas d'espace client, pas de système de devis en
  ligne — le besoin réel de la cliente a été priorisé plutôt que d'ajouter des
  fonctionnalités superflues.

## Installation locale

Prérequis : PHP 8.2+, Composer, MySQL, extensions PHP `zip`, `gd`, `fileinfo` activées.

```bash
git clone https://github.com/Thomas2216/site-laura-joly.git
cd site-laura-joly
composer install
```

Créer un fichier `.env.local` à la racine avec vos identifiants MySQL :

```
DATABASE_URL="mysql://root:VOTRE_MOT_DE_PASSE@127.0.0.1:3306/site_laura_joly?serverVersion=8.0&charset=utf8mb4"
```

Puis :

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
symfony serve
```

Le site est accessible sur `https://localhost:8000`, l'administration sur
`https://localhost:8000/admin`.

## Auteur

Thomas Vallé — développeur web junior (stack PHP/Symfony), en reconversion professionnelle.
[thomas-valle.dev](https://thomas-valle.dev) · [GitHub](https://github.com/Thomas2216)
