<div class="space-y-4">
    <h3 class="text-lg font-semibold text-gray-900">{{ __('Legal') }}</h3>
    <ul class="space-y-2">
        <li>
            <a href="{{ route('legal.mentions') }}" 
               class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                {{ __('Mentions Légales') }}
            </a>
        </li>
        <li>
            <a href="{{ route('legal.privacy') }}" 
               class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                {{ __('Politique de Confidentialité') }}
            </a>
        </li>
        <li>
            <a href="{{ route('legal.cgu') }}" 
               class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                {{ __('Conditions Générales d\'Utilisation') }}
            </a>
        </li>
    </ul>
</div>
