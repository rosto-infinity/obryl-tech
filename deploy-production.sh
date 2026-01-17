#!/bin/bash

# SCRIPT DE DÉPLOIEMENT PRODUCTION - OBRYL TECH
# Création des rôles et permissions

echo "🚀 DÉPLOIEMENT PRODUCTION - OBRYL TECH"
echo "========================================"
echo ""

# Vérifier si nous sommes en environnement de production
if [ "$APP_ENV" != "production" ]; then
    echo "⚠️  ATTENTION: Ce script est conçu pour la production"
    echo "   Environnement actuel: $APP_ENV"
    echo ""
    read -p "Voulez-vous continuer? (y/N): " -n 1 -r
    echo ""
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        echo "❌ Annulation du déploiement"
        exit 1
    fi
fi

echo "📋 ÉTAPES DE DÉPLOIEMENT:"
echo "1. Mise à jour du code"
echo "2. Installation des dépendances"
echo "3. Configuration de l'environnement"
echo "4. Migration de la base de données"
echo "5. Création des rôles et permissions"
echo "6. Optimisation de l'application"
echo ""

read -p "Commencer le déploiement? (Y/n): " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Nn]$ ]]; then
    echo "❌ Déploiement annulé"
    exit 1
fi

# Étape 1: Installation des dépendances
echo ""
echo "📦 Installation des dépendances..."
composer install --optimize-autoloader --no-dev --no-interaction

# Étape 2: Configuration de l'environnement
echo ""
echo "⚙️  Configuration de l'environnement..."
php artisan config:clear
php artisan cache:clear

# Étape 3: Migration de la base de données
echo ""
echo "🗄️  Migration de la base de données..."
php artisan migrate --force

# Étape 4: Création des rôles et permissions
echo ""
echo "👥 Création des rôles et permissions..."
php artisan db:seed --class=ProductionRoleSeeder --force

# Étape 5: Optimisation de l'application
echo ""
echo "⚡ Optimisation de l'application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Étape 6: Nettoyage
echo ""
echo "🧹 Nettoyage..."
php artisan cache:clear

echo ""
echo "✅ DÉPLOIEMENT TERMINÉ AVEC SUCCÈS!"
echo "=================================="
echo ""
echo "📊 Rôles créés:"
php artisan tinker --execute="
\$roles = Spatie\Permission\Models\Role::with('permissions')->get();
foreach (\$roles as \$role) {
    echo '  • ' . strtoupper(\$role->name) . ': ' . \$role->permissions->count() . ' permissions' . PHP_EOL;
}
"
echo ""
echo "🔐 Utilisateur Super Admin:"
echo "   Email: admin@obryl.tech"
echo "   Mot de passe: [définir dans .env]"
echo ""
echo "🌐 URL de l'application: $APP_URL"
echo "📊 Panel Filament: $APP_URL/admin"
echo ""
echo "🎉 OBRYL TECH est prêt pour la production!"
