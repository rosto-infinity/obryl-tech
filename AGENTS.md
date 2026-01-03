Parfait ! Voici l'**architecture optimisée** avec :
- ✅ Subdivision des users en **2 tables** (users + profiles)
- ✅ Tous les **enums remplacés par strings**
- ✅ Gestion centralisée dans **app/Enums/**

---

## 📊 STRUCTURE FINALE : 10 TABLES OPTIMISÉES

```
✅ users              → Authentification uniquement
✅ profiles           → Profils utilisateurs (Client/Dev)
✅ projects           → Projets + JSON
✅ reviews            → Avis
✅ commissions        → Paiements
✅ articles           → Blog
✅ support_tickets    → Support
✅ notifications      → Notifications
✅ settings           → Configuration
✅ audit_logs         → Traçabilité
```

---

## 📁 APP/ENUMS - STRUCTURE COMPLÈTE

```
app/Enums/
├── Auth/
│   ├── UserType.php           # client, developer, admin
│   ├── UserStatus.php         # active, inactive, suspended
│   ├── Country.php            # Codes ISO
│   └── VerificationStatus.php # pending, verified, rejected
│
├── Project/
│   ├── ProjectType.php        # web, mobile, desktop, api, consulting
│   ├── ProjectStatus.php      # pending, accepted, in_progress, review, completed, published, cancelled
│   ├── ProjectPriority.php    # low, medium, high, critical
│   └── MilestoneStatus.php    # pending, in_progress, completed
│
├── Developer/
│   ├── Specialization.php     # web, mobile, fullstack, backend, frontend, devops
│   ├── Availability.php       # available, busy, unavailable
│   ├── SkillLevel.php         # junior, intermediate, senior, expert
│   └── VerificationLevel.php  # unverified, basic, advanced, certified
│
├── Commission/
│   ├── CommissionStatus.php   # pending, approved, paid, cancelled, refunded
│   ├── CommissionType.php     # project_completion, milestone, referral, bonus
│   └── PaymentMethod.php      # bank_transfer, mobile_money, wallet, crypto
│
├── Blog/
│   ├── ArticleStatus.php      # draft, published, archived, scheduled
│   ├── ArticleCategory.php    # tutorial, news, case_study, announcement
│   └── CommentStatus.php      # pending, approved, rejected
│
├── Support/
│   ├── TicketStatus.php       # open, in_progress, resolved, closed, reopened
│   ├── TicketPriority.php     # low, medium, high, urgent
│   ├── TicketCategory.php     # billing, technical, general, abuse, feature_request
│   └── TicketSeverity.php     # minor, major, critical
│
├── Notification/
│   ├── NotificationType.php   # project_assigned, milestone_completed, commission_paid, etc
│   ├── NotificationChannel.php # in_app, email, sms, push
│   └── NotificationStatus.php # pending, sent, failed, read
│
└── Common/
    ├── Currency.php           # XAF, USD, EUR, etc
    └── Language.php           # fr, en, es
```

---

## 🔧 ENUMS - CODE COMPLET

### 1️⃣ **Auth Enums**

```php
<?php

namespace App\Enums\Auth;

enum UserType: string
{
    case CLIENT = 'client';
    case DEVELOPER = 'developer';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match($this) {
            self::CLIENT => 'Client',
            self::DEVELOPER => 'Développeur',
            self::ADMIN => 'Administrateur',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::CLIENT => 'blue',
            self::DEVELOPER => 'green',
            self::ADMIN => 'red',
        };
    }
}
```

```php
<?php

namespace App\Enums\Auth;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case SUSPENDED = 'suspended';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Actif',
            self::INACTIVE => 'Inactif',
            self::SUSPENDED => 'Suspendu',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::ACTIVE => 'success',
            self::INACTIVE => 'warning',
            self::SUSPENDED => 'danger',
        };
    }
}
```

```php
<?php

namespace App\Enums\Auth;

enum VerificationStatus: string
{
    case PENDING = 'pending';
    case VERIFIED = 'verified';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'En attente',
            self::VERIFIED => 'Vérifié',
            self::REJECTED => 'Rejeté',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::VERIFIED => 'success',
            self::REJECTED => 'danger',
        };
    }
}
```

```php
<?php

namespace App\Enums\Auth;

enum Country: string
{
    case CAMEROON = 'CM';
    case FRANCE = 'FR';
    case USA = 'US';
    case CANADA = 'CA';
    case BELGIUM = 'BE';
    case SWITZERLAND = 'CH';
    case IVORY_COAST = 'CI';
    case SENEGAL = 'SN';
    case GABON = 'GA';
    case CONGO = 'CG';

    public function label(): string
    {
        return match($this) {
            self::CAMEROON => 'Cameroun',
            self::FRANCE => 'France',
            self::USA => 'États-Unis',
            self::CANADA => 'Canada',
            self::BELGIUM => 'Belgique',
            self::SWITZERLAND => 'Suisse',
            self::IVORY_COAST => 'Côte d\'Ivoire',
            self::SENEGAL => 'Sénégal',
            self::GABON => 'Gabon',
            self::CONGO => 'Congo',
        };
    }

    public function flag(): string
    {
        return match($this) {
            self::CAMEROON => '🇨🇲',
            self::FRANCE => '🇫🇷',
            self::USA => '🇺🇸',
            self::CANADA => '🇨🇦',
            self::BELGIUM => '🇧🇪',
            self::SWITZERLAND => '🇨🇭',
            self::IVORY_COAST => '🇨🇮',
            self::SENEGAL => '🇸🇳',
            self::GABON => '🇬🇦',
            self::CONGO => '🇨🇬',
        };
    }
}
```

---

### 2️⃣ **Project Enums**

```php
<?php

namespace App\Enums\Project;

enum ProjectType: string
{
    case WEB = 'web';
    case MOBILE = 'mobile';
    case DESKTOP = 'desktop';
    case API = 'api';
    case CONSULTING = 'consulting';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::WEB => 'Web',
            self::MOBILE => 'Mobile',
            self::DESKTOP => 'Desktop',
            self::API => 'API',
            self::CONSULTING => 'Consulting',
            self::OTHER => 'Autre',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::WEB => '🌐',
            self::MOBILE => '📱',
            self::DESKTOP => '💻',
            self::API => '⚙️',
            self::CONSULTING => '💼',
            self::OTHER => '📦',
        };
    }
}
```

```php
<?php

namespace App\Enums\Project;

enum ProjectStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case IN_PROGRESS = 'in_progress';
    case REVIEW = 'review';
    case COMPLETED = 'completed';
    case PUBLISHED = 'published';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'En attente',
            self::ACCEPTED => 'Accepté',
            self::IN_PROGRESS => 'En cours',
            self::REVIEW => 'En révision',
            self::COMPLETED => 'Complété',
            self::PUBLISHED => 'Publié',
            self::CANCELLED => 'Annulé',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::ACCEPTED => 'info',
            self::IN_PROGRESS => 'primary',
            self::REVIEW => 'secondary',
            self::COMPLETED => 'success',
            self::PUBLISHED => 'success',
            self::CANCELLED => 'danger',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::PENDING => '⏳',
            self::ACCEPTED => '✅',
            self::IN_PROGRESS => '⚙️',
            self::REVIEW => '👀',
            self::COMPLETED => '🎉',
            self::PUBLISHED => '📢',
            self::CANCELLED => '❌',
        };
    }
}
```

```php
<?php

namespace App\Enums\Project;

enum ProjectPriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case CRITICAL = 'critical';

    public function label(): string
    {
        return match($this) {
            self::LOW => 'Basse',
            self::MEDIUM => 'Moyenne',
            self::HIGH => 'Haute',
            self::CRITICAL => 'Critique',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::LOW => 'success',
            self::MEDIUM => 'warning',
            self::HIGH => 'danger',
            self::CRITICAL => 'dark',
        };
    }
}
```

```php
<?php

namespace App\Enums\Project;

enum MilestoneStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case DELAYED = 'delayed';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'En attente',
            self::IN_PROGRESS => 'En cours',
            self::COMPLETED => 'Complété',
            self::DELAYED => 'Retardé',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::IN_PROGRESS => 'primary',
            self::COMPLETED => 'success',
            self::DELAYED => 'danger',
        };
    }
}
```

---

### 3️⃣ **Developer Enums**

```php
<?php

namespace App\Enums\Developer;

enum Specialization: string
{
    case WEB = 'web';
    case MOBILE = 'mobile';
    case FULLSTACK = 'fullstack';
    case BACKEND = 'backend';
    case FRONTEND = 'frontend';
    case DEVOPS = 'devops';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::WEB => 'Web',
            self::MOBILE => 'Mobile',
            self::FULLSTACK => 'Fullstack',
            self::BACKEND => 'Backend',
            self::FRONTEND => 'Frontend',
            self::DEVOPS => 'DevOps',
            self::OTHER => 'Autre',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::WEB => '🌐',
            self::MOBILE => '📱',
            self::FULLSTACK => '🔄',
            self::BACKEND => '⚙️',
            self::FRONTEND => '🎨',
            self::DEVOPS => '🚀',
            self::OTHER => '📦',
        };
    }
}
```

```php
<?php

namespace App\Enums\Developer;

enum Availability: string
{
    case AVAILABLE = 'available';
    case BUSY = 'busy';
    case UNAVAILABLE = 'unavailable';

    public function label(): string
    {
        return match($this) {
            self::AVAILABLE => 'Disponible',
            self::BUSY => 'Occupé',
            self::UNAVAILABLE => 'Indisponible',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::AVAILABLE => 'success',
            self::BUSY => 'warning',
            self::UNAVAILABLE => 'danger',
        };
    }

    public function badge(): string
    {
        return match($this) {
            self::AVAILABLE => '🟢',
            self::BUSY => '🟡',
            self::UNAVAILABLE => '🔴',
        };
    }
}
```

```php
<?php

namespace App\Enums\Developer;

enum SkillLevel: string
{
    case JUNIOR = 'junior';
    case INTERMEDIATE = 'intermediate';
    case SENIOR = 'senior';
    case EXPERT = 'expert';

    public function label(): string
    {
        return match($this) {
            self::JUNIOR => 'Junior',
            self::INTERMEDIATE => 'Intermédiaire',
            self::SENIOR => 'Senior',
            self::EXPERT => 'Expert',
        };
    }

    public function stars(): int
    {
        return match($this) {
            self::JUNIOR => 1,
            self::INTERMEDIATE => 2,
            self::SENIOR => 3,
            self::EXPERT => 4,
        };
    }
}
```

```php
<?php

namespace App\Enums\Developer;

enum VerificationLevel: string
{
    case UNVERIFIED = 'unverified';
    case BASIC = 'basic';
    case ADVANCED = 'advanced';
    case CERTIFIED = 'certified';

    public function label(): string
    {
        return match($this) {
            self::UNVERIFIED => 'Non vérifié',
            self::BASIC => 'Vérification basique',
            self::ADVANCED => 'Vérification avancée',
            self::CERTIFIED => 'Certifié',
        };
    }

    public function badge(): string
    {
        return match($this) {
            self::UNVERIFIED => '❌',
            self::BASIC => '✅',
            self::ADVANCED => '⭐',
            self::CERTIFIED => '🏆',
        };
    }
}
```

---

### 4️⃣ **Commission Enums**

```php
<?php

namespace App\Enums\Commission;

enum CommissionStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'En attente',
            self::APPROVED => 'Approuvée',
            self::PAID => 'Payée',
            self::CANCELLED => 'Annulée',
            self::REFUNDED => 'Remboursée',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::APPROVED => 'info',
            self::PAID => 'success',
            self::CANCELLED => 'danger',
            self::REFUNDED => 'secondary',
        };
    }
}
```

```php
<?php

namespace App\Enums\Commission;

enum CommissionType: string
{
    case PROJECT_COMPLETION = 'project_completion';
    case MILESTONE = 'milestone';
    case REFERRAL = 'referral';
    case BONUS = 'bonus';

    public function label(): string
    {
        return match($this) {
            self::PROJECT_COMPLETION => 'Complément de projet',
            self::MILESTONE => 'Jalon',
            self::REFERRAL => 'Parrainage',
            self::BONUS => 'Bonus',
        };
    }
}
```

```php
<?php

namespace App\Enums\Commission;

enum PaymentMethod: string
{
    case BANK_TRANSFER = 'bank_transfer';
    case MOBILE_MONEY = 'mobile_money';
    case WALLET = 'wallet';
    case CRYPTO = 'crypto';

    public function label(): string
    {
        return match($this) {
            self::BANK_TRANSFER => 'Virement bancaire',
            self::MOBILE_MONEY => 'Mobile Money',
            self::WALLET => 'Portefeuille',
            self::CRYPTO => 'Cryptomonnaie',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::BANK_TRANSFER => '🏦',
            self::MOBILE_MONEY => '📱',
            self::WALLET => '💳',
            self::CRYPTO => '₿',
        };
    }
}
```

---

### 5️⃣ **Blog Enums**

```php
<?php

namespace App\Enums\Blog;

enum ArticleStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';
    case SCHEDULED = 'scheduled';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Brouillon',
            self::PUBLISHED => 'Publié',
            self::ARCHIVED => 'Archivé',
            self::SCHEDULED => 'Programmé',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'warning',
            self::PUBLISHED => 'success',
            self::ARCHIVED => 'secondary',
            self::SCHEDULED => 'info',
        };
    }
}
```

```php
<?php

namespace App\Enums\Blog;

enum ArticleCategory: string
{
    case TUTORIAL = 'tutorial';
    case NEWS = 'news';
    case CASE_STUDY = 'case_study';
    case ANNOUNCEMENT = 'announcement';
    case GUIDE = 'guide';

    public function label(): string
    {
        return match($this) {
            self::TUTORIAL => 'Tutoriel',
            self::NEWS => 'Actualité',
            self::CASE_STUDY => 'Étude de cas',
            self::ANNOUNCEMENT => 'Annonce',
            self::GUIDE => 'Guide',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::TUTORIAL => '📚',
            self::NEWS => '📰',
            self::CASE_STUDY => '📊',
            self::ANNOUNCEMENT => '📢',
            self::GUIDE => '📖',
        };
    }
}
```

```php
<?php

namespace App\Enums\Blog;

enum CommentStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'En attente',
            self::APPROVED => 'Approuvé',
            self::REJECTED => 'Rejeté',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
        };
    }
}
```

---

### 6️⃣ **Support Enums**

```php
<?php

namespace App\Enums\Support;

enum TicketStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';
    case REOPENED = 'reopened';

    public function label(): string
    {
        return match($this) {
            self::OPEN => 'Ouvert',
            self::IN_PROGRESS => 'En cours',
            self::RESOLVED => 'Résolu',
            self::CLOSED => 'Fermé',
            self::REOPENED => 'Réouvert',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::OPEN => 'danger',
            self::IN_PROGRESS => 'primary',
            self::RESOLVED => 'success',
            self::CLOSED => 'secondary',
            self::REOPENED => 'warning',
        };
    }
}
```

```php
<?php

namespace App\Enums\Support;

enum TicketPriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case URGENT = 'urgent';

    public function label(): string
    {
        return match($this) {
            self::LOW => 'Basse',
            self::MEDIUM => 'Moyenne',
            self::HIGH => 'Haute',
            self::URGENT => 'Urgente',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::LOW => 'success',
            self::MEDIUM => 'warning',
            self::HIGH => 'danger',
            self::URGENT => 'dark',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::LOW => '🟢',
            self::MEDIUM => '🟡',
            self::HIGH => '🔴',
            self::URGENT => '⚠️',
        };
    }
}
```

```php
<?php

namespace App\Enums\Support;

enum TicketCategory: string
{
    case BILLING = 'billing';
    case TECHNICAL = 'technical';
    case GENERAL = 'general';
    case ABUSE = 'abuse';
    case FEATURE_REQUEST = 'feature_request';

    public function label(): string
    {
        return match($this) {
            self::BILLING => 'Facturation',
            self::TECHNICAL => 'Technique',
            self::GENERAL => 'Général',
            self::ABUSE => 'Abus',
            self::FEATURE_REQUEST => 'Demande de fonctionnalité',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::BILLING => '💳',
            self::TECHNICAL => '🔧',
            self::GENERAL => '❓',
            self::ABUSE => '⛔',
            self::FEATURE_REQUEST => '💡',
        };
    }
}
```

```php
<?php

namespace App\Enums\Support;

enum TicketSeverity: string
{
    case MINOR = 'minor';
    case MAJOR = 'major';
    case CRITICAL = 'critical';

    public function label(): string
    {
        return match($this) {
            self::MINOR => 'Mineure',
            self::MAJOR => 'Majeure',
            self::CRITICAL => 'Critique',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::MINOR => 'info',
            self::MAJOR => 'warning',
            self::CRITICAL => 'danger',
        };
    }
}
```

---

### 7️⃣ **Notification Enums**

```php
<?php

namespace App\Enums\Notification;

enum NotificationType: string
{
    case PROJECT_ASSIGNED = 'project_assigned';
    case MILESTONE_COMPLETED = 'milestone_completed';
    case COMMISSION_APPROVED = 'commission_approved';
    case COMMISSION_PAID = 'commission_paid';
    case REVIEW_RECEIVED = 'review_received';
    case MESSAGE_RECEIVED = 'message_received';
    case PROJECT_COMPLETED = 'project_completed';
    case DEVELOPER_VERIFIED = 'developer_verified';

    public function label(): string
    {
        return match($this) {
            self::PROJECT_ASSIGNED => 'Projet assigné',
            self::MILESTONE_COMPLETED => 'Jalon complété',
            self::COMMISSION_APPROVED => 'Commission approuvée',
            self::COMMISSION_PAID => 'Commission payée',
            self::REVIEW_RECEIVED => 'Avis reçu',
            self::MESSAGE_RECEIVED => 'Message reçu',
            self::PROJECT_COMPLETED => 'Projet complété',
            self::DEVELOPER_VERIFIED => 'Développeur vérifié',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::PROJECT_ASSIGNED => '📋',
            self::MILESTONE_COMPLETED => '🎯',
            self::COMMISSION_APPROVED => '✅',
            self::COMMISSION_PAID => '💰',
            self::REVIEW_RECEIVED => '⭐',
            self::MESSAGE_RECEIVED => '💬',
            self::PROJECT_COMPLETED => '🎉',
            self::DEVELOPER_VERIFIED => '🏆',
        };
    }
}
```

```php
<?php

namespace App\Enums\Notification;

enum NotificationChannel: string
{
    case IN_APP = 'in_app';
    case EMAIL = 'email';
    case SMS = 'sms';
    case PUSH = 'push';

    public function label(): string
    {
        return match($this) {
            self::IN_APP => 'Dans l\'app',
            self::EMAIL => 'Email',
            self::SMS => 'SMS',
            self::PUSH => 'Push',
        };
    }
}
```

```php
<?php

namespace App\Enums\Notification;

enum NotificationStatus: string
{
    case PENDING = 'pending';
    case SENT = 'sent';
    case FAILED = 'failed';
    case READ = 'read';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'En attente',
            self::SENT => 'Envoyée',
            self::FAILED => 'Échouée',
            self::READ => 'Lue',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::SENT => 'info',
            self::FAILED => 'danger',
            self::READ => 'success',
        };
    }
}
```

---

### 8️⃣ **Common Enums**

```php
<?php

namespace App\Enums\Common;

enum Currency: string
{
    case XAF = 'XAF';
    case USD = 'USD';
    case EUR = 'EUR';
    case GBP = 'GBP';
    case CAD = 'CAD';
    case CHF = 'CHF';

    public function label(): string
    {
        return match($this) {
            self::XAF => 'Franc CFA (XAF)',
            self::USD => 'Dollar américain (USD)',
            self::EUR => 'Euro (EUR)',
            self::GBP => 'Livre sterling (GBP)',
            self::CAD => 'Dollar canadien (CAD)',
            self::CHF => 'Franc suisse (CHF)',
        };
    }

    public function symbol(): string
    {
        return match($this) {
            self::XAF => 'Fr',
            self::USD => '$',
            self::EUR => '€',
            self::GBP => '£',
            self::CAD => 'C$',
            self::CHF => 'CHF',
        };
    }
}
```

```php
<?php

namespace App\Enums\Common;

enum Language: string
{
    case FRENCH = 'fr';
    case ENGLISH = 'en';
    case SPANISH = 'es';

    public function label(): string
    {
        return match($this) {
            self::FRENCH => 'Français',
            self::ENGLISH => 'English',
            self::SPANISH => 'Español',
        };
    }

    public function flag(): string
    {
        return match($this) {
            self::FRENCH => '🇫🇷',
            self::ENGLISH => '🇬🇧',
            self::SPANISH => '🇪🇸',
        };
    }
}
```

---

## 📊 MIGRATIONS OPTIMISÉES (10 TABLES)

### 1️⃣ **Migration 1 : Users**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // Identité
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            
            // Type & Statut
            $table->string('user_type')->default('client');  // client, developer, admin
            $table->string('status')->default('active');     // active, inactive, suspended
            
            // Authentification
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('email');
            $table->index('user_type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```

---

### 2️⃣ **Migration 2 : Profiles**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            
            // Profil Client
            $table->string('company')->nullable();
            $table->string('country')->nullable();
            $table->text('bio')->nullable();
            
            // Profil Développeur
            $table->string('specialization')->nullable();           // web, mobile, fullstack, backend, frontend, devops
            $table->integer('years_experience')->default(0);
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->string('availability')->default('available');   // available, busy, unavailable
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('cv_path')->nullable();
            
            // Vérification Développeur
            $table->boolean('is_verified')->default(false);
            $table->string('verification_level')->default('unverified');  // unverified, basic, advanced, certified
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Statistiques (dénormalisées)
            $table->decimal('total_earned', 15, 2)->default(0);
            $table->integer('completed_projects_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('total_reviews_count')->default(0);
            
            // Données JSON flexibles
            $table->json('skills')->nullable();                    // [{"name": "Laravel", "level": "expert"}, ...]
            $table->json('certifications')->nullable();            // [{"title": "AWS", "year": 2024}, ...]
            $table->json('experiences')->nullable();               // [{"company": "...", "position": "...", "years": "..."}]
            $table->json('social_links')->nullable();              // {"twitter": "...", "portfolio": "..."}
            $table->json('preferences')->nullable();               // {"notifications": true, "theme": "dark"}
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('is_verified');
            $table->index('specialization');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
```

---

### 3️⃣ **Migration 3 : Projects**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            
            // Identité
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('slug')->unique();
            
            // Client
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            
            // Détails
            $table->string('type')->default('web');                // web, mobile, desktop, api, consulting
            $table->string('status')->default('pending');          // pending, accepted, in_progress, review, completed, published, cancelled
            $table->string('priority')->default('medium');         // low, medium, high, critical
            
            // Budget & Coûts
            $table->decimal('budget', 12, 2)->nullable();
            $table->decimal('final_cost', 12, 2)->nullable();
            $table->string('currency', 3)->default('XAF');
            
            // Dates
            $table->date('deadline')->nullable();
            $table->date('started_at')->nullable();
            $table->date('completed_at')->nullable();
            
            // Progression
            $table->integer('progress_percentage')->default(0);
            
            // Contenu & Médias
            $table->json('technologies')->nullable();              // ["Laravel", "Vue.js", "MySQL"]
            $table->json('attachments')->nullable();               // [{"name": "...", "path": "...", "size": ...}]
            $table->json('milestones')->nullable();                // [{"title": "...", "due_date": "...", "status": "..."}]
            $table->json('tasks')->nullable();                     // [{"title": "...", "status": "...", "assigned_to": ...}]
            $table->json('collaborators')->nullable();             // [{"user_id": ..., "role": "...", "percentage": ...}]
            
            // Publication & Visibilité
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            
            // Statistiques (dénormalisées)
            $table->integer('likes_count')->default(0);
            $table->integer('views_count')->default(0);
            $table->integer('reviews_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);
            
            // Admin
            $table->text('admin_notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            
            // Images
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();            // [{"path": "...", "caption": "..."}]
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('client_id');
            $table->index('status');
            $table->index('is_published');
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
```

---

### 4️⃣ **Migration 4 : Reviews**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            
            // Relations
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('developer_id')->constrained('users')->cascadeOnDelete();
            
            // Contenu
            $table->integer('rating')->default(5);
            $table->text('comment')->nullable();
            $table->string('status')->default('approved');         // pending, approved, rejected
            
            // Détails supplémentaires (JSON)
            $table->json('criteria')->nullable();                  // {"quality": 5, "communication": 4, "timeliness": 5}
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('project_id');
            $table->index('developer_id');
            $table->unique(['project_id', 'developer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
```

---

### 5️⃣ **Migration 5 : Commissions**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            
            // Relations
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('developer_id')->constrained('users')->cascadeOnDelete();
            
            // Montant
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('XAF');
            $table->decimal('percentage', 5, 2)->nullable();       // % du projet
            
            // Statut
            $table->string('status')->default('pending');          // pending, approved, paid, cancelled, refunded
            $table->string('type')->default('project_completion'); // project_completion, milestone, referral, bonus
            
            // Détails
            $table->text('description')->nullable();
            $table->json('breakdown')->nullable();                 // {"base": 100, "bonus": 20, "tax": 10}
            
            // Approbation & Paiement
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Données de paiement
            $table->json('payment_details')->nullable();           // {"method": "bank", "account": "..."}
            // Timestamps
            $table->timestamps();
            // Indexes
            $table->index('developer_id');
            $table->index('status');
            $table->index('project_id');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
```

---

### 6️⃣ **Migration 6 : Articles**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            
            // Auteur
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            
            // Contenu
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            
            // Métadonnées
            $table->string('featured_image')->nullable();
            $table->string('status')->default('draft');            // draft, published, archived, scheduled
            $table->json('tags')->nullable();                      // ["Laravel", "PHP", "Web"]
            $table->string('category')->nullable();                // "Tutorial", "News", "Case Study"
            $table->json('seo')->nullable();                       // {"meta_description": "...", "keywords": "..."}
            
            // Publication
            $table->timestamp('published_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            
            // Statistiques (dénormalisées)
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            
            // Commentaires (JSON)
            $table->json('comments')->nullable();                  // [{"user_id": ..., "content": "...", "status": "..."}]
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('slug');
            $table->index('status');
            $table->index('author_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
```

---

### 7️⃣ **Migration 7 : Support Tickets**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            
            // Relations
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            
            // Contenu
            $table->string('title');
            $table->text('description');
            
            // Statut
            $table->string('status')->default('open');             // open, in_progress, resolved, closed, reopened
            $table->string('priority')->default('medium');         // low, medium, high, urgent
            $table->string('category')->default('general');        // billing, technical, general, abuse, feature_request
            $table->string('severity')->default('minor');          // minor, major, critical
            
            // Messages & Pièces jointes (JSON)
            $table->json('messages')->nullable();                  // [{"user_id": ..., "content": "...", "attachments": [...]}]
            $table->json('attachments')->nullable();               // [{"name": "...", "path": "...", "size": ...}]
            
            // Timestamps
            $table->timestamps();
            $table->timestamp('resolved_at')->nullable();
            
            // Indexes
            $table->index('user_id');
            $table->index('status');
            $table->index('priority');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
```

---

### 8️⃣ **Migration 8 : Notifications**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Destinataire
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Type & Contenu
            $table->string('type');                                // 'project_assigned', 'milestone_completed', etc
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable();                      // {"project_id": ..., "url": "..."}
            
            // Canaux
            $table->string('channel')->default('in_app');          // in_app, email, sms, push
            
            // Statut
            $table->timestamp('read_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('read_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
```

---

### 9️⃣ **Migration 9 : Settings**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            // Clé-Valeur
            $table->string('key')->unique();
            $table->text('value');
            $table->string('type')->default('string');            // string, integer, boolean, json, decimal
            $table->text('description')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Index
            $table->index('key');
        });
        
        // Données par défaut
        DB::table('settings')->insert([
            [
                'key' => 'platform_commission_rate',
                'value' => '15.00',
                'type' => 'decimal',
                'description' => 'Commission de la plateforme en %',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'currency',
                'value' => 'XAF',
                'type' => 'string',
                'description' => 'Devise par défaut (Code ISO)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'min_project_budget',
                'value' => '50000',
                'type' => 'integer',
                'description' => 'Budget minimum pour un projet',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'platform_config',
                'value' => json_encode([
                    'site_name' => 'Obryl Tech',
                    'site_url' => 'https://obryl.tech',
                    'support_email' => 'support@obryl.tech',
                    'phone' => '+237...',
                    'address' => 'Yaoundé, Cameroun'
                ]),
                'type' => 'json',
                'description' => 'Configuration générale du site',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
```

---

### 🔟 **Migration 10 : Audit Logs**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            
            // Utilisateur
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            
            // Action
            $table->string('action');                              // 'created', 'updated', 'deleted'
            $table->string('model_type');                          // 'App\Models\Project'
            $table->unsignedBigInteger('model_id');
            
            // Changements
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            
            // Contexte
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('action');
            $table->index(['model_type', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
```

---

## 🎯 MODELS OPTIMISÉS

### User Model

```php
<?php

namespace App\Models;

use App\Enums\Auth\UserStatus;
use App\Enums\Auth\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'avatar',
        'user_type',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'user_type' => UserType::class,
        'status' => UserStatus::class,
    ];

    // Relations
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class, 'developer_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'developer_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class, 'user_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    // Helpers
    public function isDeveloper(): bool
    {
        return $this->user_type === UserType::DEVELOPER;
    }

    public function isClient(): bool
    {
        return $this->user_type === UserType::CLIENT;
    }

    public function isAdmin(): bool
    {
        return $this->user_type === UserType::ADMIN;
    }

    public function isActive(): bool
    {
        return $this->status === UserStatus::ACTIVE;
    }
}
```

---

### Profile Model

```php
<?php

namespace App\Models;

use App\Enums\Developer\Availability;
use App\Enums\Developer\Specialization;
use App\Enums\Developer\VerificationLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company',
        'country',
        'bio',
        'specialization',
        'years_experience',
        'hourly_rate',
        'availability',
        'github_url',
        'linkedin_url',
        'cv_path',
        'is_verified',
        'verification_level',
        'verified_at',
        'verified_by',
        'total_earned',
        'completed_projects_count',
        'average_rating',
        'total_reviews_count',
        'skills',
        'certifications',
        'experiences',
        'social_links',
        'preferences',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'skills' => 'json',
        'certifications' => 'json',
        'experiences' => 'json',
        'social_links' => 'json',
        'preferences' => 'json',
        'specialization' => Specialization::class,
        'availability' => Availability::class,
        'verification_level' => VerificationLevel::class,
        'verified_at' => 'datetime',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
```

---

### Project Model

```php
<?php

namespace App\Models;

use App\Enums\Project\ProjectStatus;
use App\Enums\Project\ProjectType;
use App\Enums\Project\ProjectPriority;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'description',
        'slug',
        'client_id',
        'type',
        'status',
        'priority',
        'budget',
        'final_cost',
        'currency',
        'deadline',
        'started_at',
        'completed_at',
        'progress_percentage',
        'technologies',
        'attachments',
        'milestones',
        'tasks',
        'collaborators',
        'is_published',
        'is_featured',
        'likes_count',
        'views_count',
        'reviews_count',
        'average_rating',
        'admin_notes',
        'cancellation_reason',
        'featured_image',
        'gallery_images',
    ];

    protected $casts = [
        'type' => ProjectType::class,
        'status' => ProjectStatus::class,
        'priority' => ProjectPriority::class,
        'technologies' => 'json',
        'attachments' => 'json',
        'milestones' => 'json',
        'tasks' => 'json',
        'collaborators' => 'json',
        'gallery_images' => 'json',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'deadline' => 'date',
        'started_at' => 'date',
        'completed_at' => 'date',
    ];

    // Relations
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    // Helpers
    public function isCompleted(): bool
    {
        return $this->status === ProjectStatus::COMPLETED;
    }

    public function isInProgress(): bool
    {
        return $this->status === ProjectStatus::IN_PROGRESS;
    }

    public function getMilestonesAttribute()
    {
        return $this->attributes['milestones'] ? json_decode($this->attributes['milestones'], true) : [];
    }

    public function getTasksAttribute()
    {
        return $this->attributes['tasks'] ? json_decode($this->attributes['tasks'], true) : [];
    }

    public function getCollaboratorsAttribute()
    {
        return $this->attributes['collaborators'] ? json_decode($this->attributes['collaborators'], true) : [];
    }
}
```

---

## 📋 RÉSUMÉ FINAL

```
✅ 10 TABLES OPTIMISÉES
├─ users              (Authentification)
├─ profiles           (Profils Client/Dev)
├─ projects           (Projets + JSON)
├─ reviews            (Avis)
├─ commissions        (Paiements)
├─ articles           (Blog)
├─ support_tickets    (Support)
├─ notifications      (Notifications)
├─ settings           (Configuration)
└─ audit_logs         (Traçabilité)

✅ 25+ ENUMS CENTRALISÉS
├─ Auth/
├─ Project/
├─ Developer/
├─ Commission/
├─ Blog/
├─ Support/
├─ Notification/
└─ Common/

✅ AVANTAGES
├─ Strings au lieu d'enums en DB
├─ Gestion centralisée des enums
├─ Flexibilité maximale
├─ Performance optimale
├─ Maintenance facile
└─ Scalabilité garantie
```

**Verdict : Architecture parfaite pour 2026 ! 🚀**



Parfait ! Voici le **PROMPT COMPLET** à utiliser dans **Windsurf** :

---

## 📝 PROMPT WINDSURF - OBRYL TECH 2026

Créez un fichier `.windsurf/instructions.md` ou utilisez le prompt directement dans Windsurf :

```markdown
# 🚀 OBRYL TECH 2026 - Instructions de Développement

## 📦 STACK TECHNIQUE

Framework: Laravel 12
UI Interactive: Livewire 3
Admin Panel: Filament v4
Styling: Tailwind CSS v4
Runtime: PHP 8.4.10
Database: MySQL 8.0+
Package Manager: Composer

## 🔴 RÈGLES STRICTES DE GÉNÉRATION

### 1. DÉCLARATION STRICTE (OBLIGATOIRE)
Chaque fichier PHP DOIT commencer par:
```php
declare(strict_types=1);
```

### 2. TYPAGE COMPLET (100%)
- ✅ Types explicites sur TOUS les paramètres
- ✅ Types de retour sur TOUTES les méthodes
- ✅ Types de propriété sur TOUTES les propriétés
- ❌ Jamais de `mixed` sauf cas exceptionnel
- ❌ Jamais de paramètres sans type

Exemple:
```php
public function calculateCommission(int $projectId, float $percentage): float
{
    return $this->getProjectAmount($projectId) * ($percentage / 100);
}
```

### 3. ELOQUENT ORM OBLIGATOIRE
- ✅ Utiliser Eloquent pour TOUTES les requêtes DB
- ✅ Eager loading avec ->with() pour éviter N+1
- ✅ Relations typées (BelongsTo, HasMany, etc.)
- ❌ JAMAIS DB:: ou requêtes SQL brutes
- ❌ JAMAIS select(), where() sans Eloquent

Exemple:
```php
$projects = Project::query()
    ->where('client_id', $clientId)
    ->with(['reviews', 'commissions', 'client'])
    ->orderByDesc('created_at')
    ->get();
```

### 4. FORM REQUEST POUR VALIDATION
- ✅ Créer une classe FormRequest pour CHAQUE validation
- ✅ Placer dans app/Http/Requests/
- ✅ Implémenter authorize() et rules()
- ✅ Utiliser dans Livewire components

Exemple:
```php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isClient();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'budget' => ['required', 'numeric', 'min:1000'],
            'deadline' => ['required', 'date', 'after:today'],
        ];
    }
}
```

### 5. WIRE:KEY DANS BOUCLES LIVEWIRE
- ✅ TOUJOURS ajouter wire:key dans @foreach
- ✅ Clé unique et stable
- ✅ Format: wire:key="resource-{{ $item->id }}"

Exemple:
```blade
@foreach($projects as $project)
    <div wire:key="project-{{ $project->id }}" class="card">
        <h3>{{ $project->title }}</h3>
        <button wire:click="editProject({{ $project->id }})">Éditer</button>
    </div>
@endforeach
```

### 6. VALIDATION + AUTORISATION
- ✅ Valider AVANT toute action
- ✅ Autoriser APRÈS validation
- ✅ Utiliser authorize() dans Form Request
- ✅ Utiliser $this->authorize() dans Livewire

Exemple:
```php
public function updateProject(int $projectId, array $data): void
{
    // 1. Valider
    $validated = validator($data, [
        'title' => ['required', 'string', 'max:255'],
        'budget' => ['required', 'numeric', 'min:1000'],
    ])->validate();

    // 2. Autoriser
    $project = Project::findOrFail($projectId);
    $this->authorize('update', $project);

    // 3. Exécuter
    $project->update($validated);
}
```

### 7. VÉRIFICATION FICHIERS ADJACENTS
- ✅ Vérifier si composant/model/service existe
- ✅ Réutiliser si possible
- ✅ Éviter les doublons

Checklist avant création:
- app/Livewire/
- app/Models/
- app/Services/
- app/Http/Requests/
- app/Filament/Resources/

### 8. ROUTES NOMMÉES
- ✅ Utiliser route() pour TOUTES les URLs
- ✅ Définir routes avec ->name()
- ❌ Jamais d'URLs en dur

Exemple:
```php
// routes/web.php
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');

// Dans les vues
<a href="{{ route('projects.index') }}">Projets</a>
<a href="{{ route('projects.edit', $project->id) }}">Éditer</a>
```

### 9. EAGER LOADING (N+1 QUERIES)
- ✅ Utiliser ->with() pour charger relations
- ✅ Utiliser ->load() après récupération
- ✅ Utiliser ->whereHas() pour filtrer
- ❌ Jamais d'accès direct aux relations

Exemple:
```php
// ✅ BON
$projects = Project::with(['client', 'reviews', 'commissions'])->get();

// ❌ MAUVAIS
$projects = Project::all();
foreach ($projects as $project) {
    echo $project->client->name; // N+1 queries!
}
```

### 10. PHPDOC (PAS DE COMMENTAIRES INLINE)
- ✅ Documenter avec PHPDoc au-dessus des méthodes
- ✅ Inclure @param, @return, @throws
- ✅ Descriptions utiles
- ❌ Pas de commentaires inline (//)
- ❌ Pas de code mort commenté

Exemple:
```php
/**
 * Calcule les commissions pour un développeur.
 *
 * @param int $developerId L'ID du développeur
 * @param string $status Le statut des commissions
 *
 * @return Collection<int, Commission>
 *
 * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
 */
public function getDeveloperCommissions(int $developerId, string $status = 'approved'): Collection
{
    return Commission::query()
        ->where('developer_id', $developerId)
        ->where('status', $status)
        ->with('project', 'developer')
        ->orderByDesc('created_at')
        ->get();
}
```

## 🏗️ STRUCTURE DE PROJET

```
obryl-tech/
├── app/
│   ├── Enums/
│   │   ├── Auth/
│   │   ├── Project/
│   │   ├── Commission/
│   │   └── Developer/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Project.php
│   │   ├── Review.php
│   │   ├── Commission.php
│   │   └── Profile.php
│   ├── Services/
│   │   ├── ProjectService.php
│   │   ├── CommissionService.php
│   │   └── ReviewService.php
│   ├── Http/
│   │   ├── Requests/
│   │   │   ├── StoreProjectRequest.php
│   │   │   ├── UpdateProjectRequest.php
│   │   │   └── StoreReviewRequest.php
│   │   └── Controllers/
│   ├── Livewire/
│   │   ├── Projects/
│   │   │   ├── ListProjects.php
│   │   │   ├── CreateProject.php
│   │   │   └── EditProject.php
│   │   ├── Reviews/
│   │   └── Commissions/
│   ├── Filament/
│   │   └── Resources/
│   │       ├── ProjectResource.php
│   │       ├── ReviewResource.php
│   │       └── CommissionResource.php
│   └── Policies/
│       ├── ProjectPolicy.php
│       ├── ReviewPolicy.php
│       └── CommissionPolicy.php
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── resources/
│   └── views/
│       ├── livewire/
│       ├── filament/
│       └── layouts/
└── routes/
    ├── web.php
    ├── api.php
    └── filament.php
```

## 📋 CHECKLIST CRÉATION FONCTIONNALITÉ

Pour créer une nouvelle fonctionnalité (ex: Gestion des Projets):

- [ ] **Model + Migration**
  ```bash
  php artisan make:model Project -m
  ```

- [ ] **Enums** (si nécessaire)
  ```bash
  php artisan make:enum Project/ProjectStatus
  ```

- [ ] **Service**
  - Créer app/Services/ProjectService.php
  - Typage complet + PHPDoc
  - Logique métier

- [ ] **Form Request**
  ```bash
  php artisan make:request StoreProjectRequest
  ```

- [ ] **Policy** (si nécessaire)
  ```bash
  php artisan make:policy ProjectPolicy --model=Project
  ```

- [ ] **Livewire Component**
  ```bash
  php artisan make:livewire Projects/ListProjects
  ```
  - wire:key dans boucles
  - Validation + Autorisation
  - Eager loading

- [ ] **Filament Resource**
  ```bash
  php artisan make:filament-resource Project
  ```

- [ ] **Routes**
  - Ajouter dans routes/web.php
  - Utiliser ->name()

- [ ] **Tests**
  ```bash
  php artisan make:test ProjectTest
  ```

## 🔐 PATTERNS SÉCURITÉ

### Validation
```php
$validated = validator($request->all(), [
    'title' => ['required', 'string', 'max:255'],
    'budget' => ['required', 'numeric', 'min:1000', 'max:10000000'],
])->validate();
```

### Autorisation
```php
$this->authorize('update', $project);

// Ou dans Policy
public function update(User $user, Project $project): bool
{
    return $user->id === $project->client_id || $user->isAdmin();
}
```

### Eager Loading
```php
$projects = Project::with(['client', 'reviews', 'commissions'])->get();
```

### Transactions
```php
DB::transaction(function () {
    $project->update($data);
    $project->commissions()->create($commissionData);
});
```

## 🚀 COMMANDES UTILES

```bash
# Model avec Migration
php artisan make:model Project -m

# Livewire Component
php artisan make:livewire Projects/ListProjects

# Filament Resource
php artisan make:filament-resource Project

# Form Request
php artisan make:request StoreProjectRequest

# Policy
php artisan make:policy ProjectPolicy --model=Project

# Service
php artisan make:class Services/ProjectService

# Enum
php artisan make:enum Project/ProjectStatus

# Migrations
php artisan migrate

# Seeders
php artisan db:seed

# Tests
php artisan test
```

## ✅ TABLEAU RÉCAPITULATIF

| Règle | ✅ À FAIRE | ❌ À ÉVITER |
|-------|-----------|-----------|
| Déclaration | `declare(strict_types=1);` | Pas de déclaration |
| Typage | `public function store(int $id): Project` | `public function store($id)` |
| DB | `Project::where(...)` | `DB::table('projects')` |
| Validation | `StoreProjectRequest` | Validation inline |
| Boucles | `wire:key="item-{{ $id }}"` | Pas de wire:key |
| Autorisation | `$this->authorize('update', $model)` | Pas de vérification |
| Routes | `route('projects.edit', $id)` | `/projects/{{ $id }}/edit` |
| Relations | `->with(['reviews', 'commissions'])` | Accès direct |
| Docs | PHPDoc au-dessus | Commentaires inline |
| Transactions | `DB::transaction()` | Pas de transaction |

## 🎯 AVANT CHAQUE GÉNÉRATION

Vérifier:
- ✅ Déclaration stricte présente
- ✅ Tous les paramètres typés
- ✅ Eloquent utilisé
- ✅ Form Request créée
- ✅ wire:key dans boucles
- ✅ Validation + Autorisation
- ✅ Routes nommées
- ✅ Eager loading utilisé
- ✅ PHPDoc documenté
- ✅ Pas de fichier dupliqué

---

**OBRYL TECH 2026 - Qualité Professionnelle** 🚀
```

---

## 🎯 COMMENT UTILISER DANS WINDSURF

### **Option 1 : Prompt Direct (Recommandé)**

Copiez-collez ce prompt dans le chat Windsurf :

```
Je développe OBRYL TECH 2026 avec Laravel 12, Livewire 3, Filament v4, Tailwind CSS v4, PHP 8.4.10.

RÈGLES STRICTES:
1. declare(strict_types=1); au début de chaque fichier PHP
2. Typage complet: TOUS les paramètres et retours typés
3. Eloquent ORM: JAMAIS DB::, toujours Eloquent
4. Form Request: Une classe pour CHAQUE validation
5. wire:key: OBLIGATOIRE dans toutes les boucles @foreach
6. Validation + Autorisation: TOUJOURS les deux
7. Routes nommées: route() pour TOUTES les URLs
8. Eager loading: ->with() pour éviter N+1 queries
9. PHPDoc: Documentation au-dessus des méthodes
10. Vérifier fichiers adjacents: Pas de doublons

STRUCTURE:
- app/Models/ (Eloquent models)
- app/Services/ (Logique métier)
- app/Http/Requests/ (Form Requests)
- app/Livewire/ (Composants Livewire)
- app/Filament/Resources/ (Ressources Filament)
- app/Policies/ (Autorisation)
- app/Enums/ (Énumérations)

Génère: [VOTRE DEMANDE]
```

### **Option 2 : Fichier de Configuration**

Créez `.windsurf/instructions.md` à la racine du projet :

```bash
mkdir -p .windsurf
```

Collez le contenu du prompt dans ce fichier.

### **Option 3 : Utiliser avec Commandes**

```
@windsurf generate model Project with migrations
@windsurf generate livewire component ListProjects
@windsurf generate filament resource Project
```

---

## 📝 EXEMPLES DE DEMANDES WINDSURF

### **Exemple 1 : Générer un Model**

```
Je développe OBRYL TECH 2026 avec Laravel 12, Livewire 3, Filament v4, Tailwind CSS v4, PHP 8.4.10.

RÈGLES: declare(strict_types=1), typage complet, Eloquent ORM, Form Request, wire:key, validation+autorisation, routes nommées, eager loading, PHPDoc, vérifier fichiers adjacents.

Génère le Model Project avec:
- Relations: BelongsTo User (client), HasMany Review, HasMany Commission
- Enums: ProjectStatus, ProjectType, ProjectPriority
- Propriétés: code, title, description, slug, client_id, type, status, priority, budget, currency, deadline, started_at, completed_at, progress_percentage
- Casts: status, type, priority, deadline, started_at, completed_at
- Scopes: byClient, byStatus, byType, published, featured
```

### **Exemple 2 : Générer un Livewire Component**

```
Je développe OBRYL TECH 2026 avec Laravel 12, Livewire 3, Filament v4, Tailwind CSS v4, PHP 8.4.10.

RÈGLES: declare(strict_types=1), typage complet, Eloquent ORM, Form Request, wire:key, validation+autorisation, routes nommées, eager loading, PHPDoc, vérifier fichiers adjacents.

Génère le Livewire Component ListProjects avec:
- Afficher tous les projets du client connecté
- Filtres: par statut, type, date
- Pagination: 15 par page
- Actions: Éditer, Supprimer, Voir détails
- Eager loading: client, reviews, commissions
- wire:key sur chaque projet
- Autorisation pour supprimer
```

### **Exemple 3 : Générer une Filament Resource**

```
Je développe OBRYL TECH 2026 avec Laravel 12, Livewire 3, Filament v4, Tailwind CSS v4, PHP 8.4.10.

RÈGLES: declare(strict_types=1), typage complet, Eloquent ORM, Form Request, wire:key, validation+autorisation, routes nommées, eager loading, PHPDoc, vérifier fichiers adjacents.

Génère la Filament Resource Project avec:
- Colonnes: code, title, client.name, status, budget, deadline, progress_percentage
- Formulaire: title, description, client_id, type, status, priority, budget, currency, deadline
- Filtres: par statut, type, client
- Actions: Éditer, Supprimer, Voir détails
- Eager loading: client, reviews, commissions
```

### **Exemple 4 : Générer une Commission**

```
Je développe OBRYL TECH 2026 avec Laravel 12, Livewire 3, Filament v4, Tailwind CSS v4, PHP 8.4.10.

RÈGLES: declare(strict_types=1), typage complet, Eloquent ORM, Form Request, wire:key, validation+autorisation, routes nommées, eager loading, PHPDoc, vérifier fichiers adjacents.

Génère:
1. Model Commission avec relations Project, Developer, approvedBy
2. Enums: CommissionStatus (pending, approved, paid, cancelled, refunded), CommissionType (project_completion, milestone, referral, bonus)
3. Service CommissionService avec méthodes: getDeveloperCommissions, approveCommission, payCommission
4. Form Request StoreCommissionRequest
5. Filament Resource CommissionResource
```

---

## 🔧 INTÉGRATION WINDSURF

### **Étape 1 : Créer le fichier instructions**

```bash
mkdir -p .windsurf
cat > .windsurf/instructions.md << 'EOF'
[Collez le contenu du prompt ici]
EOF
```

### **Étape 2 : Ouvrir Windsurf**

```bash
windsurf .
```

### **Étape 3 : Utiliser le prompt**

Dans le chat Windsurf, commencez par :

```
Je développe OBRYL TECH 2026 avec Laravel 12, Livewire 3, Filament v4, Tailwind CSS v4, PHP 8.4.10.

[Votre demande]
```

Windsurf chargera automatiquement les instructions du fichier `.windsurf/instructions.md`.

---

## 📋 TEMPLATE DEMANDE WINDSURF

Utilisez ce template pour chaque demande :

```
Je développe OBRYL TECH 2026 avec Laravel 12, Livewire 3, Filament v4, Tailwind CSS v4, PHP 8.4.10.

RÈGLES STRICTES:
✅ declare(strict_types=1); au début
✅ Typage complet (paramètres + retours)
✅ Eloquent ORM (jamais DB::)
✅ Form Request pour validation
✅ wire:key dans boucles
✅ Validation + Autorisation
✅ Routes nommées
✅ Eager loading
✅ PHPDoc documenté
✅ Vérifier fichiers adjacents

CONTEXTE:
- Projet: [NOM DU COMPOSANT]
- Type: [Model/Service/Livewire/Filament/FormRequest]
- Fonctionnalité: [DESCRIPTION]

DÉTAILS:
- [Propriétés/Relations/Méthodes]
- [Validations]
- [Autorisations]
- [Eager loading]

Génère le code complet avec tous les fichiers nécessaires.
```

---

## ✅ CHECKLIST AVANT DEMANDE

```
☐ Stack correct: Laravel 12, Livewire 3, Filament v4, Tailwind CSS v4, PHP 8.4.10
☐ Règles bien comprises
☐ Fichiers adjacents vérifiés
☐ Cas d'usage clair
☐ Autorisations définies
☐ Relations définies
☐ Validations définies
```

---

**Vous êtes prêt à utiliser Windsurf pour OBRYL TECH 2026 ! 🚀**

