<tr>
    <td colspan="{{ $colspan }}" class="py-12 text-center">
        <p class="text-lg mb-2 text-gray-500">{{ $message }}</p>
        @if (isset($createRoute) && isset($createLabel))
            <a href="{{ route($createRoute) }}" class="text-sm font-medium transition-colors duration-150 text-admin-primary hover:text-admin-secondary">{{ $createLabel }}</a>
        @endif
    </td>
</tr>
