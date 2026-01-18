<?php

namespace App\View\Components;

use App\Markdown\MarkdownHelper;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Spatie\LaravelMarkdown\MarkdownRenderer as SpatieRenderer;

class MarkdownRenderer extends Component
{
    public function __construct(
        public ?string $content = null,
    ) {}

    public function render(): View|Closure|string
    {
        return function (array $data) {
            $markdown = $this->content ?? $data['slot'];
            $html = app(SpatieRenderer::class)->toHtml((string) $markdown);
            
            return MarkdownHelper::parseLiquidTags($html);
        };
    }
}
