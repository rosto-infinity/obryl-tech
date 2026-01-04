@extends('components.layouts.public')

@section('content')
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Conditions Générales d'Utilisation (CGU)</h1>
            
            <div class="space-y-6 text-gray-700">
                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">Préambule</h2>
                    <p class="mb-3">
                        Les présentes Conditions Générales d'Utilisation (ci-après "CGU") régissent l'utilisation 
                        des services proposés par Obryl Tech, entreprise spécialisée dans le génie informatique, 
                        le développement d'applications, le graphisme et les services numériques.
                    </p>
                    <p>
                        En accédant à nos services et en utilisant notre plateforme, vous acceptez sans réserve 
                        les présentes CGU. Si vous n'acceptez pas ces conditions, vous ne devez pas utiliser nos services.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">1. Définitions</h2>
                    <ul class="list-disc list-inside ml-4 space-y-2">
                        <li><strong>Client :</strong> toute personne physique ou morale utilisant les services d'Obryl Tech</li>
                        <li><strong>Prestataire :</strong> Obryl Tech, société de génie informatique</li>
                        <li><strong>Services :</strong> ensemble des prestations proposées par Obryl Tech</li>
                        <li><strong>Plateforme :</strong> le site web et les outils mis à disposition des clients</li>
                        <li><strong>Projet :</strong> mission confiée par le Client au Prestataire</li>
                        <li><strong>Livrable :</strong> résultat final du projet (application, design, etc.)</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">2. Objet</h2>
                    <p>
                        Les présentes CGU ont pour objet de définir les conditions dans lesquelles Obryl Tech 
                        fournit ses services de développement d'applications, de graphisme et de conseil numérique 
                        à ses clients, ainsi que les droits et obligations de chaque partie.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">3. Services proposés</h2>
                    
                    <h3 class="text-lg font-medium text-gray-800 mb-2">3.1 Développement d'applications</h3>
                    <ul class="list-disc list-inside ml-4 space-y-2 mb-3">
                        <li>Applications web et mobiles sur mesure</li>
                        <li>Développement front-end et back-end</li>
                        <li>Intégration d'API et bases de données</li>
                        <li>Maintenance et évolution d'applications existantes</li>
                    </ul>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">3.2 Graphisme et design</h3>
                    <ul class="list-disc list-inside ml-4 space-y-2 mb-3">
                        <li>Création d'identité visuelle (logo, charte graphique)</li>
                        <li>Design d'interface utilisateur (UI/UX)</li>
                        <li>Maquettage web et mobile</li>
                        <li>Création de contenus visuels (bannières, illustrations)</li>
                    </ul>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">3.3 Conseil et accompagnement</h3>
                    <ul class="list-disc list-inside ml-4 space-y-2">
                        <li>Audit technique et stratégique</li>
                        <li>Formation et transfert de compétences</li>
                        <li>Accompagnement projet</li>
                        <li>Optimisation des processus numériques</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">4. Conditions d'utilisation des services</h2>
                    
                    <h3 class="text-lg font-medium text-gray-800 mb-2">4.1 Inscription et compte utilisateur</h3>
                    <p class="mb-3">Pour accéder à certains services, vous devez créer un compte utilisateur en fournissant :</p>
                    <ul class="list-disc list-inside ml-4 space-y-2 mb-3">
                        <li>Des informations exactes, complètes et à jour</li>
                        <li>Une adresse email valide</li>
                        <li>Un mot de passe sécurisé</li>
                    </ul>
                    <p class="mb-3">Vous êtes responsable de la confidentialité de vos identifiants de connexion.</p>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">4.2 Utilisation de la plateforme</h3>
                    <p class="mb-3">Vous vous engagez à :</p>
                    <ul class="list-disc list-inside ml-4 space-y-2 mb-3">
                        <li>Utiliser la plateforme à des fins légales et professionnelles</li>
                        <li>Ne pas tenter d'interrompre ou dégrader le fonctionnement du site</li>
                        <li>Respecter les droits de propriété intellectuelle</li>
                        <li>Ne pas diffuser de contenu illégal, diffamatoire ou inapproprié</li>
                        <li>Fournir des informations exactes pour vos projets</li>
                    </ul>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">4.3 Contenu utilisateur</h3>
                    <p class="mb-3">
                        Vous conservez la propriété du contenu que vous nous fournissez (textes, images, documents). 
                        En nous fournissant ce contenu, vous nous accordez une licence d'utilisation nécessaire 
                        à l'exécution du projet.
                    </p>
                    <p>
                        Vous garantissez que le contenu fourni ne viole aucun droit de tiers.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">5. Conditions tarifaires et paiement</h2>
                    
                    <h3 class="text-lg font-medium text-gray-800 mb-2">5.1 Tarification</h3>
                    <p class="mb-3">Les tarifs sont fixés selon :</p>
                    <ul class="list-disc list-inside ml-4 space-y-2 mb-3">
                        <li><strong>Forfait projet :</strong> prix fixe pour un périmètre défini</li>
                        <li><strong>Tarification horaire :</strong> basée sur le temps de travail effectif</li>
                        <li><strong>Abonnement :</strong> pour les services de maintenance</li>
                    </ul>
                    <p>Les tarifs sont détaillés dans le devis ou le contrat correspondant.</p>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">5.2 Modalités de paiement</h3>
                    <ul class="list-disc list-inside ml-4 space-y-2 mb-3">
                        <li><strong>Acompte :</strong> 30% à la signature du contrat</li>
                        <li><strong>Versements intermédiaires :</strong> selon jalons de projet</li>
                        <li><strong>Solde :</strong> à la livraison finale</li>
                    </ul>
                    <p>Les paiements s'effectuent par virement bancaire, mobile money ou autres moyens convenus.</p>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">5.3 Retard de paiement</h3>
                    <p>
                        Tout retard de paiement entraîne l'application de pénalités de retard au taux légal 
                        et peut suspendre l'exécution du projet jusqu'à régularisation.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">6. Propriété intellectuelle</h2>
                    
                    <h3 class="text-lg font-medium text-gray-800 mb-2">6.1 Droits sur les livrables</h3>
                    <p class="mb-3">
                        Les droits de propriété intellectuelle sur les livrables sont cédés au Client après 
                        paiement intégral des prestations, sauf accord contraire.
                    </p>
                    <p class="mb-3">
                        Obryl Tech conserve la propriété des outils, méthodes et savoir-faire développés 
                        dans le cadre de son activité.
                    </p>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">6.2 Utilisation des livrables</h3>
                    <p>
                        Le Client s'engage à ne pas utiliser les livrables à des fins commerciales sans 
                        autorisation expresse, sauf si cela fait partie du périmètre du projet convenu.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">7. Responsabilité et garanties</h2>
                    
                    <h3 class="text-lg font-medium text-gray-800 mb-2">7.1 Garanties</h3>
                    <p class="mb-3">Obryl Tech garantit :</p>
                    <ul class="list-disc list-inside ml-4 space-y-2 mb-3">
                        <li>L'exécution des prestations avec diligence et compétence professionnelle</li>
                        <li>La conformité des livrables aux spécifications convenues</li>
                        <li>Une période de garantie de 3 mois sur les développements (corrections de bugs)</li>
                    </ul>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">7.2 Limitation de responsabilité</h3>
                    <p class="mb-3">
                        La responsabilité d'Obryl Tech est limitée aux dommages directs prévisibles 
                        découlant de l'exécution des prestations.
                    </p>
                    <p>
                        Obryl Tech ne pourra être tenue responsable des dommages indirects, 
                        perte de données, perte d'exploitation ou préjudice commercial.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">8. Confidentialité</h2>
                    <p class="mb-3">
                        Les deux parties s'engagent à maintenir la confidentialité des informations 
                        échangées dans le cadre du projet.
                    </p>
                    <p>
                        Cette obligation de confidentialité persiste après la fin du projet 
                        et s'étend à tous les collaborateurs et sous-traitants.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">9. Durée et résiliation</h2>
                    
                    <h3 class="text-lg font-medium text-gray-800 mb-2">9.1 Durée</h3>
                    <p>
                        Les présentes CGU entrent en vigueur dès votre première utilisation des services 
                        et demeurent en vigueur pendant toute la durée de la relation contractuelle.
                    </p>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">9.2 Résiliation</h3>
                    <p class="mb-3">La résiliation peut intervenir :</p>
                    <ul class="list-disc list-inside ml-4 space-y-2 mb-3">
                        <li><strong>D'un commun accord :</strong> par décision mutuelle des parties</li>
                        <li><strong>Pour faute :</strong> en cas de manquement grave aux obligations</li>
                        <li><strong>Unilatéralement :</strong> avec préavis de 30 jours pour les services récurrents</li>
                    </ul>
                    <p>
                        En cas de résiliation, le Client s'engage à régler les prestations effectuées 
                        et à prendre possession des livrables correspondants.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">10. Litiges</h2>
                    <p class="mb-3">
                        En cas de litige relatif à l'interprétation ou à l'exécution des présentes CGU, 
                        les parties s'engagent à rechercher une solution amiable.
                    </p>
                    <p>
                        À défaut d'accord amiable, le litige sera porté devant les tribunaux 
                        compétents du ressort de [Ville, Pays].
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">11. Dispositions diverses</h2>
                    
                    <h3 class="text-lg font-medium text-gray-800 mb-2">11.1 Force majeure</h3>
                    <p class="mb-3">
                        Obryl Tech ne pourra être tenue responsable de l'inexécution ou du retard 
                        dans l'exécution de ses obligations en cas de force majeure.
                    </p>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">11.2 Modification des CGU</h3>
                    <p class="mb-3">
                        Obryl Tech se réserve le droit de modifier les présentes CGU. 
                        Les modifications seront notifiées aux clients par email ou via la plateforme.
                    </p>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">11.3 Loi applicable</h3>
                    <p>
                        Les présentes CGU sont régies par le droit camerounais.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">12. Contact</h2>
                    <p>
                        Pour toute question relative aux présentes CGU, contactez-nous :<br>
                        <strong>Email :</strong> legal@obryl-tech.com<br>
                        <strong>Téléphone :</strong> [+237 XXX XXX XXX]<br>
                        <strong>Adresse :</strong> [Adresse complète]<br>
                        <strong>Site web :</strong> https://obryl-tech.com
                    </p>
                </section>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-500 text-center">
                        Dernière mise à jour : {{ date('d/m/Y') }}<br>
                        Version : 1.0<br>
                        Obryl Tech - Génie Informatique
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
