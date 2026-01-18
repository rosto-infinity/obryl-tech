Utilisateurs

Aperçu
#Introduction
Par défaut, tous App\Models\Userles utilisateurs peuvent accéder à Filament en local. Pour leur permettre d'y accéder en production, vous devez effectuer quelques étapes supplémentaires afin de garantir que seuls les utilisateurs autorisés aient accès à l'application.

#Autorisation d'accès au panneau
Pour configurer votre App\Models\Useraccès à Filament dans des environnements non locaux, vous devez implémenter le FilamentUsercontrat :

<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    // ...

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
    }
}

La canAccessPanel()méthode renvoie vrai trueou falsefaux selon que l'utilisateur est autorisé à accéder au site $panel. Dans cet exemple, nous vérifions si l'adresse e-mail de l'utilisateur se termine par « .example.com » @yourdomain.comet si elle est vérifiée.

Puisque vous avez accès à la version actuelle $panel, vous pouvez écrire des vérifications conditionnelles pour différents panneaux. Par exemple, vous pouvez restreindre l'accès au seul panneau d'administration tout en autorisant tous les utilisateurs à accéder aux autres panneaux de votre application.

<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    // ...

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
        }

        return true;
    }
}

#Autorisation d'accès aux ressources
Consultez la section Autorisation dans la documentation des ressources pour contrôler l'accès aux pages de ressources et à leurs enregistrements de données.

#Configuration des avatars des utilisateurs
Par défaut, Filament utilise ui-avatars.com pour générer les avatars à partir du nom de l'utilisateur. Toutefois, si votre modèle utilisateur possède un avatar_urlattribut, c'est celui-ci qui sera utilisé. Pour personnaliser la manière dont Filament obtient l'URL de l'avatar d'un utilisateur, vous pouvez implémenter le HasAvatarcontrat :

<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    // ...

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }
}

Cette getFilamentAvatarUrl()méthode permet de récupérer l'avatar de l'utilisateur actuel. Si nullcette méthode ne renvoie aucune valeur, Filament utilisera ui-avatars.com par défaut .

#Utiliser un fournisseur d'avatar différent
Vous pouvez facilement remplacer ui-avatars.com par un autre service en créant un nouveau fournisseur d'avatars.

Dans cet exemple, nous créons un nouveau fichier pour app/Filament/AvatarProviders/BoringAvatarsProvider.phpboringavatars.com . La get()méthode accepte une instance du modèle utilisateur et renvoie l'URL de l'avatar de cet utilisateur :

<?php

namespace App\Filament\AvatarProviders;

use Filament\AvatarProviders\Contracts;
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class BoringAvatarsProvider implements Contracts\AvatarProvider
{
    public function get(Model | Authenticatable $record): string
    {
        $name = str(Filament::getNameForDefaultAvatar($record))
            ->trim()
            ->explode(' ')
            ->map(fn (string $segment): string => filled($segment) ? mb_substr($segment, 0, 1) : '')
            ->join(' ');

        return 'https://source.boringavatars.com/beam/120/' . urlencode($name);
    }
}

Enregistrez maintenant ce nouveau fournisseur d'avatar dans la configuration :

use App\Filament\AvatarProviders\BoringAvatarsProvider;
use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->defaultAvatarProvider(BoringAvatarsProvider::class);
}

#Configuration de l'attribut nom de l'utilisateur
Par défaut, Filament utilise l' nameattribut de l'utilisateur pour afficher son nom dans l'application. Pour modifier ce comportement, vous pouvez implémenter le HasNamecontrat :

<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser, HasName
{
    // ...

    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}

Cette getFilamentName()méthode permet de récupérer le nom de l'utilisateur actuel.

#Fonctionnalités d'authentification
Vous pouvez facilement activer les fonctionnalités d'authentification pour un panneau dans le fichier de configuration :

use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->login()
        ->registration()
        ->passwordReset()
        ->emailVerification()
        ->emailChangeVerification()
        ->profile();
}

Filament prend également en charge l'authentification multifactorielle, que vous pouvez découvrir dans la section Authentification multifactorielle .

#Personnalisation des fonctionnalités d'authentification
Si vous souhaitez remplacer ces pages par les vôtres, vous pouvez transmettre n'importe quelle classe de page Filament à ces méthodes.

La plupart des utilisateurs pourront effectuer les personnalisations souhaitées en étendant la classe de page de base du code source de Filament, en redéfinissant des méthodes comme form(), puis en passant la nouvelle classe de page à la configuration :

use App\Filament\Pages\Auth\EditProfile;
use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->profile(EditProfile::class);
}

Dans cet exemple, nous allons personnaliser la page de profil. Nous devons créer une nouvelle classe PHP à l'emplacement suivantapp/Filament/Pages/Auth/EditProfile.php :

<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('username')
                    ->required()
                    ->maxLength(255),
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}

Cette classe étend la classe de page de profil de base du code source de Filament. Voici d'autres classes de page que vous pourriez étendre :

Filament\Auth\Pages\Login
Filament\Auth\Pages\Register
Filament\Auth\Pages\EmailVerification\EmailVerificationPrompt
Filament\Auth\Pages\PasswordReset\RequestPasswordReset
Filament\Auth\Pages\PasswordReset\ResetPassword
Dans la form()méthode de cet exemple, nous appelons des méthodes getNameFormComponent()pour obtenir les composants de formulaire par défaut de la page. Vous pouvez personnaliser ces composants selon vos besoins. Pour connaître toutes les options de personnalisation disponibles, consultez la EditProfileclasse de page de base dans le code source de Filament ; elle contient toutes les méthodes que vous pouvez redéfinir pour apporter des modifications.

#Personnaliser un champ d'authentification sans avoir à redéfinir le formulaire
Si vous souhaitez personnaliser un champ dans un formulaire d'authentification sans avoir à définir une nouvelle form()méthode, vous pouvez étendre la méthode spécifique du champ et enchaîner vos personnalisations :

use Filament\Schemas\Components\Component;

protected function getPasswordFormComponent(): Component
{
    return parent::getPasswordFormComponent()
        ->revealable(false);
}

#Vérification du changement d'adresse e-mail
Si vous utilisez cette profile()fonctionnalité emailChangeVerification(), les utilisateurs qui modifient leur adresse e-mail dans leur profil devront la vérifier avant de pouvoir se connecter. Pour ce faire, un e-mail de vérification sera envoyé à la nouvelle adresse. Cet e-mail contient un lien sur lequel l'utilisateur devra cliquer pour valider sa nouvelle adresse. L'adresse e-mail enregistrée dans la base de données ne sera mise à jour qu'après ce clic.

Le lien envoyé à l'utilisateur est valable 60 minutes. Simultanément à l'envoi du courriel à la nouvelle adresse, un courriel est également envoyé à l'ancienne adresse, contenant un lien permettant de bloquer la modification. Il s'agit d'une mesure de sécurité visant à protéger l'utilisateur contre toute action malveillante.

#Utilisation d'une barre latérale sur la page de profil
Par défaut, la page de profil n'utilise pas la mise en page standard avec barre latérale. Ceci afin d'assurer sa compatibilité avec la gestion des locataires ; sans cela, elle serait inaccessible si l'utilisateur n'avait pas de locataire, car les liens de la barre latérale sont redirigés vers le locataire actuel.

Si vous n'utilisez pas la gestion de locataires dans votre panneau et que vous souhaitez que la page de profil utilise la mise en page standard avec une barre latérale, vous pouvez transmettre le isSimple: falseparamètre $panel->profile()lors de l'enregistrement de la page :

use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->profile(isSimple: false);
}

#Personnalisation des slugs des routes d'authentification
Vous pouvez personnaliser les slugs d'URL utilisés pour les routes d'authentification dans la configuration :

use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->loginRouteSlug('login')
        ->registrationRouteSlug('register')
        ->passwordResetRoutePrefix('password-reset')
        ->passwordResetRequestRouteSlug('request')
        ->passwordResetRouteSlug('reset')
        ->emailVerificationRoutePrefix('email-verification')
        ->emailVerificationPromptRouteSlug('prompt')
        ->emailVerificationRouteSlug('verify')
        ->emailChangeVerificationRoutePrefix('email-change-verification')
        ->emailChangeVerificationRouteSlug('verify');
}

#Configuration du garde d'authentification
Pour définir le mécanisme d'authentification utilisé par Filament, vous pouvez transmettre le nom du mécanisme à la méthode authGuard() de configuration :

use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->authGuard('web');
}

#Configuration du courtier de mots de passe
Pour définir le gestionnaire de mots de passe utilisé par Filament, vous pouvez transmettre le nom du gestionnaire à la méthode authPasswordBroker() de configuration :

use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->authPasswordBroker('users');
}

#Désactivation de la saisie de mots de passe visibles
Par défaut, tous les champs de mot de passe des formulaires d'authentification sont affichés revealable()en clair. Cela permet à l'utilisateur de voir le mot de passe saisi en cliquant sur un bouton. Pour désactiver cette fonctionnalité, vous pouvez passer l'option correspondante falseà la méthode revealablePasswords() de configuration :

use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->revealablePasswords(false);
}

Vous pouvez également désactiver cette fonctionnalité champ par champ en appelant ->revealable(false)l'objet champ lors de l'extension de la classe de page de base .

#Configurer l'accès invité à un panneau
Par défaut, Filament ne fonctionne qu'avec des utilisateurs authentifiés. Pour autoriser les invités à accéder à un panneau, vous devez éviter d'utiliser des composants nécessitant une connexion (comme les profils et les avatars) et supprimer le middleware d'authentification intégré.

Supprimez la valeur par défaut Authenticate::classdu authMiddleware()tableau dans la configuration du panneau.
Supprimez ->login()toutes les autres fonctionnalités d'authentification du panneau.
Supprimez la valeur par défaut AccountWidgetdu widgets()tableau, car elle lit les données de l'utilisateur actuel.
#Autoriser les invités dans les politiques
Lorsque Filament est présent, il utilise les politiques de modèle Laravel pour le contrôle d'accès. Pour accorder un accès en lecture aux utilisateurs invités dans une politique de modèle , créez la politique et mettez à jour les viewAny()méthodes view()`get` et `get`, en rendant le User $userparamètre ?User $user`optional` facultatif return true;. Vous pouvez également supprimer complètement ces méthodes de la politique.


Optimizing Filament for production
To optimize Filament for production, you should run the following command in your deployment script:

php artisan filament:optimize

This command will cache the Filament components and additionally the Blade Icons, which can significantly improve the performance of your Filament panels. This command is a shorthand for the commands php artisan filament:cache-components and php artisan icons:cache.

To clear the caches at once, you can run:

php artisan filament:optimize-clear

#Caching Filament components
If you’re not using the filament:optimize command, you may wish to consider running php artisan filament:cache-components in your deployment script, especially if you have large numbers of components (resources, pages, widgets, relation managers, custom Livewire components, etc.). This will create cache files in the bootstrap/cache/filament directory of your application, which contain indexes for each type of component. This can significantly improve the performance of Filament in some apps, as it reduces the number of files that need to be scanned and auto-discovered for components.

However, if you are actively developing your app locally, you should avoid using this command, as it will prevent any new components from being discovered until the cache is cleared or rebuilt.

You can clear the cache at any time without rebuilding it by running php artisan filament:clear-cached-components.

#Caching Blade Icons
If you’re not using the filament:optimize command, you may wish to consider running php artisan icons:cache locally, and also in your deployment script. This is because Filament uses the Blade Icons package, which can be much more performant when cached.

#Enabling OPcache on your server
To check if OPcache is enabled, run:

php -r "echo 'opcache.enable => ' . ini_get('opcache.enable') . PHP_EOL;"

You should see opcache.enable => 1. If not, enable it by adding the following line to your php.ini:

opcache.enable=1 # Enable OPcache

From the Laravel Forge documentation:

TIP

Optimizing the PHP OPcache for production will configure OPcache to store your compiled PHP code in memory to greatly improve performance.

Please use a search engine to find the relevant OPcache setup instructions for your environment.

#Optimizing your Laravel app
You should also consider optimizing your Laravel app for production by running php artisan optimize in your deployment script. This will cache the configuration files and routes.

#Ensuring assets are up to date
During the Filament installation process, Filament adds the php artisan filament:upgrade command to the composer.json file, in the post-autoload-dump script. This command will ensure that your assets are up to date whenever you download the package.

We strongly suggest that this script remains in your composer.json file, otherwise you may run into issues with missing or outdated assets in your production environment. However, if you must remove it, make sure that the command is run manually in your deployment process.


