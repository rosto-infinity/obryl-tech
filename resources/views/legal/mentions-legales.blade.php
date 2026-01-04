@extends('components.layouts.public')

@section('content')
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Mentions Légales</h1>
            
            <div class="space-y-6 text-gray-700">
                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">1. Édition du site</h2>
                    <p class="mb-2">
                        <strong>Obryl Tech - Génie Informatique</strong><br>
                        Entreprise spécialisée dans le développement d'applications, le graphisme et les services numériques
                    </p>
                    <p class="mb-2">
                        <strong>Siège social :</strong><br>
                        [Adresse complète à insérer]<br>
                        [Code postal] [Ville], [Pays]
                    </p>
                    <p class="mb-2">
                        <strong>Téléphone :</strong> [+237 XXX XXX XXX]<br>
                        <strong>Email :</strong> contact@obryl-tech.com<br>
                        <strong>Site web :</strong> https://obryl-tech.com
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">2. Directeur de la publication</h2>
                    <p>
                        <strong>Nom :</strong> [Nom du Directeur]<br>
                        <strong>Fonction :</strong> Directeur Général<br>
                        <strong>Email :</strong> direction@obryl-tech.com
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">3. Hébergement</h2>
                    <p class="mb-2">
                        <strong>Prestataire d'hébergement :</strong> [Nom de l'hébergeur]<br>
                        <strong>Adresse :</strong> [Adresse de l'hébergeur]<br>
                        <strong>Téléphone :</strong> [Numéro de l'hébergeur]<br>
                        <strong>Site web :</strong> [Site de l'hébergeur]
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">4. Propriété intellectuelle</h2>
                    <p class="mb-3">
                        L'ensemble de ce site, y compris son architecture, les textes, graphismes, logos, animations, 
                        bases de données, et tout autre élément composant ce site, est la propriété exclusive d'Obryl Tech.
                    </p>
                    <p class="mb-3">
                        Toute reproduction, représentation, modification, publication, adaptation de tout ou partie des 
                        éléments du site, quel que soit le moyen ou le procédé utilisé, est interdite sans autorisation 
                        écrite préalable d'Obryl Tech.
                    </p>
                    <p>
                        Toute exploitation non autorisée du site ou de l'un quelconque des éléments qu'il contient sera 
                        considérée comme constitutive d'une contrefaçon et poursuivie conformément aux dispositions des 
                        articles L.335-2 et suivants du Code de la propriété intellectuelle.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">5. Services proposés</h2>
                    <div class="space-y-2 mb-3">
                        <p><strong>Développement d'applications :</strong></p>
                        <ul class="list-disc list-inside ml-4 space-y-1">
                            <li>Applications web et mobiles</li>
                            <li>Solutions sur mesure</li>
                            <li>Maintenance et évolution</li>
                        </ul>
                        
                        <p class="mt-3"><strong>Graphisme et design :</strong></p>
                        <ul class="list-disc list-inside ml-4 space-y-1">
                            <li>Identité visuelle</li>
                            <li>Design d'interface (UI/UX)</li>
                            <li>Création graphique</li>
                        </ul>
                        
                        <p class="mt-3"><strong>Autres services numériques :</strong></p>
                        <ul class="list-disc list-inside ml-4 space-y-1">
                            <li>Conseil en stratégie numérique</li>
                            <li>Formation et accompagnement</li>
                            <li>Solutions techniques personnalisées</li>
                        </ul>
                    </div>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">6. Limitation de responsabilité</h2>
                    <p class="mb-3">
                        Obryl Tech s'efforce de fournir sur ce site des informations aussi précises que possible. 
                        Toutefois, elle ne pourra être tenue responsable des omissions, des inexactitudes et des 
                        carences dans la mise à jour, qu'elles soient de son fait ou du fait des tiers partenaires 
                        qui lui fournissent ces informations.
                    </p>
                    <p>
                        Toutes les informations proposées sur le site sont données à titre indicatif et ne sont pas 
                        exhaustives. Elles sont susceptibles d'évoluer et ne constituent en aucun cas un engagement 
                        contractuel de la part d'Obryl Tech.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">7. Liens hypertextes</h2>
                    <p class="mb-3">
                        Le site peut contenir des liens hypertextes vers d'autres sites présents sur le réseau Internet. 
                        Obryl Tech ne dispose d'aucun moyen pour contrôler les sites en connexion avec ses sites web 
                        et ne saurait être responsable de la disponibilité de tels sites et des contenus qu'ils proposent.
                    </p>
                    <p>
                        L'utilisateur accède à ces sites sous sa seule responsabilité et assume tous les risques liés 
                        à cette consultation.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">8. Droit applicable et juridiction compétente</h2>
                    <p>
                        Les présentes mentions légales sont régies par le droit camerounais. Tout litige relatif à 
                        l'interprétation ou à l'exécution des présentes sera de la compétence exclusive des tribunaux 
                        compétents du ressort de [Ville, Pays].
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">9. Contact</h2>
                    <p>
                        Pour toute question relative aux présentes mentions légales, vous pouvez nous contacter :<br>
                        <strong>Email :</strong> legal@obryl-tech.com<br>
                        <strong>Téléphone :</strong> [+237 XXX XXX XXX]<br>
                        <strong>Adresse :</strong> [Adresse complète]
                    </p>
                </section>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-500 text-center">
                        Dernière mise à jour : {{ date('d/m/Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
