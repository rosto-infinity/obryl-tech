# Résolution : Centralisation de la logique de rendu Markdown

## Problème
La logique de rendu Markdown était dispersée ou dupliquée dans plusieurs composants (Blade, Livewire, etc.). Les extensions personnalisées comme **Torchlight** et les **Liquid tags** (YouTube, CodePen, etc.) n'étaient pas toujours appliquées de manière cohérente.

## Correction effectuée
1.  **Création/Mise à jour du `MarkdownHelper`** (`app/Markdown/MarkdownHelper.php`) :
    *   Ajout d'une méthode statique `toHtml(string $markdown)` qui centralise tout le pipeline de rendu.
    *   Intégration systématique de `Spatie\LaravelMarkdown` et du post-traitement des tags Liquid.
2.  **Refactorisation du composant `MarkdownRenderer`** (`app/View/Components/MarkdownRenderer.php`) :
    *   Le composant utilise désormais exclusivement `MarkdownHelper::toHtml()`.
3.  **Support de Torchlight** :
    *   Mise à jour de `config/markdown.php` pour utiliser l'extension personnalisée `App\Markdown\Extensions\TorchlightExtension`.
    *   Configuration correcte du parseur CommonMark v2.

## Bonnes pratiques
Pour afficher du Markdown dans l'application, utilisez systématiquement le composant Blade :
```html
<x-markdown-renderer>
    {!! $content !!}
</x-markdown-renderer>
```
Ou passez par le helper :
```php
$html = \App\Markdown\MarkdownHelper::toHtml($markdown);
```
