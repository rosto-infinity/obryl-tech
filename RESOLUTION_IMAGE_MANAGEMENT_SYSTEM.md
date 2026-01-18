# Résolution : Système de Gestion des Images (Filament v4 / Livewire v3)

## Problèmes identifiés
1.  **Disque de stockage incorrect** : Le disque local était utilisé par défaut au lieu du disque public.
2.  **Conflits d'accesseurs** : Des accesseurs Laravel (`Attribute`) entraient en conflit avec les colonnes raw de la DB, empêchant Filament de charger les images existantes.
3.  **URLs 404** : Les chemins bruts étaient utilisés dans les vues au lieu d'URLs générées.

## Modifications apportées

### 1. Configuration de l'environnement (`.env`)
Bascule du disque par défaut vers `public` :
```env
FILESYSTEM_DISK=public
```

### 2. Standardisation des Modèles (`Article`, `Project`, `User`, `Profile`)
- **Suppression** des accesseurs de type `Attribute` qui portaient le même nom que la colonne (ex: `featured_image`).
- **Création** d'helpers d'URL dédiés pour les vues :
    *   `featured_image_url`
    *   `avatar_url`
    *   `gallery_image_urls`
- **Fallback systématique** : Si aucune image n'est définie, une image de remplacement (placeholder) ou un avatar généré (UI Avatars) est retourné.

### 3. Configuration Filament (`ArticleForm`, `ProjectForm`)
- Ajout explicite de `->disk('public')` sur tous les champs `FileUpload`.
- Configuration de la visibilité publique et des répertoires de stockage (`articles/featured`, `projects/featured`, etc.).
- Ajout de validations (taille max 2Mo, types mime).

### 4. Optimisation des Vues
- Utilisation systématique des accesseurs `_url`.
- Ajout de l'attribut `loading="lazy"` pour les performances.
- Intégration de styles Tailwind responsives.

## Commandes utiles
S'assurer que le lien symbolique est présent sur le serveur :
```bash
php artisan storage:link
```
