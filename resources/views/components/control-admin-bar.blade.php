@props(['currentStyle', 'currentRoute', 'currentSubType'])

@role('editor')
    <x-app-button :href="route('create-item', [
        'style' => $currentStyle,
        'type' => $currentRoute,
        'subType' => $currentSubType,
    ])" label="Add Item" variant="outline" color="primary" />
@endrole
