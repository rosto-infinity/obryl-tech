@extends('components.layouts.public')

@section('content')
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Politique de Confidentialité</h1>
            
            <div class="space-y-6 text-gray-700">
                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">Introduction</h2>
                    <p class="mb-3">
                        Obryl Tech s'engage à protéger la vie privée de ses clients, partenaires et visiteurs de son site web. 
                        Cette politique de confidentialité explique comment nous collectons, utilisons, protégeons et partageons 
                        vos informations personnelles lorsque vous utilisez nos services ou naviguez sur notre site.
                    </p>
                    <p>
                        En utilisant nos services, vous acceptez les pratiques décrites dans cette politique de confidentialité.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">1. Données personnelles collectées</h2>
                    
                    <h3 class="text-lg font-medium text-gray-800 mb-2">1.1 Informations que vous nous fournissez</h3>
                    <p class="mb-3">Nous collectons les informations suivantes lorsque vous utilisez nos services :</p>
                    <ul class="list-disc list-inside ml-4 space-y-2 mb-4">
                        <li><strong>Informations d'identification :</strong> nom, prénom, email, numéro de téléphone</li>
                        <li><strong>Informations professionnelles :</strong> entreprise, fonction, secteur d'activité</li>
                        <li><strong>Informations de projet :</strong> détails des projets, exigences techniques</li>
                        <li><strong>Informations de paiement :</strong> coordonnées bancaires (sécurisées)</li>
                        <li><strong>Communications :</strong> messages, demandes de support, feedback</li>
                    </ul>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">1.2 Informations collectées automatiquement</h3>
                    <ul class="list-disc list-inside ml-4 space-y-2">
                        <li><strong>Données de navigation :</strong> adresse IP, type de navigateur, pages visitées</li>
                        <li><strong>Données d'utilisation :</strong> temps passé sur le site, interactions</li>
                        <li><strong>Cookies :</strong> pour améliorer votre expérience de navigation</li>
                        <li><strong>Données techniques :</strong> type d'appareil, système d'exploitation</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">2. Utilisation des données personnelles</h2>
                    <p class="mb-3">Nous utilisons vos informations personnelles pour :</p>
                    <ul class="list-disc list-inside ml-4 space-y-2">
                        <li><strong>Fournir nos services :</strong> développement d'applications, graphisme, conseil</li>
                        <li><strong>Gérer les projets :</strong> suivi, communication, livraison</li>
                        <li><strong>Traiter les paiements :</strong> facturation, gestion des transactions</li>
                        <li><strong>Améliorer nos services :</strong> analyse, feedback, personnalisation</li>
                        <li><strong>Communication :</strong> newsletters, offres commerciales, support technique</li>
                        <li><strong>Sécurité :</strong> protection contre les fraudes, respect des obligations légales</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">3. Partage des données personnelles</h2>
                    <p class="mb-3">Nous ne partageons vos informations personnelles que dans les circonstances suivantes :</p>
                    
                    <h3 class="text-lg font-medium text-gray-800 mb-2">3.1 Partenaires de service</h3>
                    <ul class="list-disc list-inside ml-4 space-y-2 mb-3">
                        <li><strong>Prestataires techniques :</strong> hébergement, messagerie, outils de développement</li>
                        <li><strong>Prestataires de paiement :</strong> solutions de paiement sécurisées</li>
                        <li><strong>Sous-traitants :</strong> freelances et collaborateurs pour les projets</li>
                    </ul>

                    <h3 class="text-lg font-medium text-gray-800 mb-2">3.2 Obligations légales</h3>
                    <p>Nous pouvons partager vos informations si :</p>
                    <ul class="list-disc list-inside ml-4 space-y-2">
                        <li>La loi nous y oblige (réquisition judiciaire, enquête légale)</li>
                        <li>Nous devons protéger nos droits, nos biens ou notre sécurité</li>
                        <li>Nous devons prévenir une fraude ou une activité illégale</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">4. Protection des données</h2>
                    <p class="mb-3">
                        Obryl Tech met en œuvre des mesures de sécurité appropriées pour protéger vos informations 
                        personnelles contre la perte, l'utilisation abusive, l'accès non autorisé, la divulgation, 
                        l'altération ou la destruction.
                    </p>
                    <p class="mb-3">Nos mesures de sécurité incluent :</p>
                    <ul class="list-disc list-inside ml-4 space-y-2">
                        <li><strong>Chiffrement :</strong> données sensibles cryptées</li>
                        <li><strong>Accès sécurisé :</strong> authentification forte, mots de passe complexes</li>
                        <li><strong>Serveurs sécurisés :</strong> hébergement protégé</li>
                        <li><strong>Formation du personnel :</strong> sensibilisation à la sécurité</li>
                        <li><strong>Surveillance :</strong> détection des menaces et intrusions</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">5. Durée de conservation des données</h2>
                    <p class="mb-3">Nous conservons vos informations personnelles uniquement pendant la durée nécessaire :</p>
                    <ul class="list-disc list-inside ml-4 space-y-2">
                        <li><strong>Données clients :</strong> durée de la relation commerciale + 10 ans</li>
                        <li><strong>Données de projet :</strong> 5 ans après la fin du projet</li>
                        <li><strong>Données de navigation :</strong> 13 mois maximum</li>
                        <li><strong>Données comptables :</strong> 10 ans (obligation légale)</li>
                    </ul>
                    <p>
                        Après cette période, vos données sont soit supprimées, soit anonymisées conformément aux réglementations applicables.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">6. Vos droits</h2>
                    <p class="mb-3">Conformément à la législation, vous disposez des droits suivants :</p>
                    <ul class="list-disc list-inside ml-4 space-y-2">
                        <li><strong>Droit d'accès :</strong> connaître les données que nous détenons sur vous</li>
                        <li><strong>Droit de rectification :</strong> corriger vos informations inexactes</li>
                        <li><strong>Droit de suppression :</strong> demander la suppression de vos données</li>
                        <li><strong>Droit de limitation :</strong> limiter le traitement de vos données</li>
                        <li><strong>Droit de portabilité :</strong> recevoir vos données dans un format lisible</li>
                        <li><strong>Droit d'opposition :</strong> vous opposer au traitement de vos données</li>
                    </ul>
                    <p>
                        Pour exercer ces droits, contactez-nous à l'adresse : privacy@obryl-tech.com
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">7. Cookies</h2>
                    <p class="mb-3">
                        Notre site utilise des cookies pour améliorer votre expérience de navigation et analyser 
                        l'utilisation de nos services.
                    </p>
                    <p class="mb-3">Types de cookies utilisés :</p>
                    <ul class="list-disc list-inside ml-4 space-y-2">
                        <li><strong>Cookies essentiels :</strong> nécessaires au fonctionnement du site</li>
                        <li><strong>Cookies de performance :</strong> pour analyser l'utilisation du site</li>
                        <li><strong>Cookies fonctionnels :</strong> pour personnaliser votre expérience</li>
                        <li><strong>Cookies de ciblage :</strong> pour des publicités pertinentes</li>
                    </ul>
                    <p>
                        Vous pouvez gérer vos préférences cookies via les paramètres de votre navigateur.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">8. Modifications de la politique</h2>
                    <p>
                        Obryl Tech se réserve le droit de modifier cette politique de confidentialité à tout moment. 
                        Les modifications seront publiées sur cette page avec une date de mise à jour. 
                        Nous vous invitons à consulter régulièrement cette page pour rester informé des éventuels changements.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">9. Contact</h2>
                    <p class="mb-2">
                        Pour toute question concernant cette politique de confidentialité ou l'exercice de vos droits, 
                        contactez notre délégué à la protection des données :
                    </p>
                    <p>
                        <strong>Email :</strong> privacy@obryl-tech.com<br>
                        <strong>Téléphone :</strong> [+237 XXX XXX XXX]<br>
                        <strong>Adresse :</strong> [Adresse complète]<br>
                        <strong>Site web :</strong> https://obryl-tech.com
                    </p>
                </section>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-500 text-center">
                        Dernière mise à jour : {{ date('d/m/Y') }}<br>
                        Version : 1.0
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
