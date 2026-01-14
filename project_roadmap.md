# Résumé Architectural & Roadmap Obryl Tech

Ce document explique l'ordre logique des migrations actuelles et définit les fonctionnalités futures nécessaires à la croissance de la plateforme.

---

## 1. Ordre Complet des Migrations (Logique de Dépendance)

L'ordre est crucial pour respecter les clés étrangères (Foreign Keys). On ne peut pas créer un projet sans utilisateur, ni une avis sans projet.

| Ordre | Table | Pourquoi à ce rang ? |
| :--- | :--- | :--- |
| **1** | `users` | Socle de base (Laravel). Tout le système en dépend. |
| **2** | `profiles` | Dépend de `users`. Permet de qualifier l'utilisateur (Client vs Développeur) dès l'inscription. |
| **3** | `projects` | Dépend de `users` (client) et optionnellement d'un développeur. C'est l'entité centrale de l'activité. |
| **4** | `reviews` | Dépend de `projects` et `users`. Ne peut exister qu'après la création/réalisation d'un projet. |
| **5** | `commissions` | Dépend de `projects`. Gère la partie financière interne au projet. |
| **6** | `permissions` | Système transversal. Gère qui peut approuver les commissions ou éditer les articles. |
| **7** | `articles` | Dépend de `users` (auteur). Autonome par rapport aux projets mais lié aux experts. |
| **8** | `workload` | Dépend du développeur (`users`). Outil de pilotage de production. |
| **9** | `ext_commissions`| Dépend de `projects`. Gestion spécifique pour les intervenants externes. |
| **10**| `support_tickets`| Transversal. Dépend des utilisateurs et éventuellement des projets. |
| **11**| `settings` | Autonome. Configure les taux de commission et les variables globales. |
| **12**| `audit_logs` | Transversal. Enregistre les actions sur toutes les tables précédentes. |
| **13**| `notifications` | Final. Envoie des alertes basées sur les événements de toutes les autres tables. |

---

## 2. Fonctionnalités Futures & Pourquoi

Pour passer d'un MVP (Minimum Viable Product) à une plateforme de production robuste, voici les étapes recommandées :

### A. Système de Paiement Escrow (Séquestre)
- **Quoi :** Intégration de Stripe ou d'un processeur local (Mobile Money) pour bloquer les fonds du client au début du projet.
- **Pourquoi :** Garantit au développeur qu'il sera payé et au client que l'argent ne sera libéré qu'à la validation des livrables. Réduit les litiges.

### B. Module de Messagerie Temps Réel
- **Quoi :** Un chat intégré (Laravel Reverb ou Pusher) pour les discussions sur les projets et tickets de support.
- **Pourquoi :** Centralise la communication. Évite que les échanges critiques ne se perdent sur WhatsApp ou email. Améliore la réactivité.

### C. Dashboard Analytique Avancé
- **Quoi :** Graphiques de revenus (Revenu Brut, Commissions Plateforme, Croissance mensuelle).
- **Pourquoi :** Permet à l'administrateur de piloter la rentabilité de la plateforme et aux développeurs de suivre leur performance financière.

### D. Système de Parrainage (Affiliation)
- **Quoi :** Génération de liens de parrainage pour les utilisateurs.
- **Pourquoi :** Croissance organique. Les utilisateurs deviennent des ambassadeurs pour amener de nouveaux clients ou développeurs en échange d'une petite commission.

### E. Portfolio Interactif 3D / Rich Media
- **Quoi :** Support des vidéos de démonstration et intégrations type Spline/Three.js pour les projets.
- **Pourquoi :** "L'effet Wow". Pour une plateforme tech, la démonstration visuelle de l'expertise est le meilleur argument de vente.

### F. API Publique & Webhooks
- **Quoi :** Permettre à des partenaires d'intégrer les données de Obryl Tech ou de recevoir des alertes externes.
- **Pourquoi :** Scalabilité. Permet de connecter la plateforme à d'autres outils (ex: Slack, Jira, outils de comptabilité).

---

## 3. Pourquoi cette vision ?
L'architecture actuelle (consolidée) est **modulaire**. Chaque table a une responsabilité unique. Cela signifie que l'ajout du "Système de Paiement" (A) ne cassera pas le "Blog" (6) ou les "Permissions" (5). Vous avez une base solide et évolutive.
