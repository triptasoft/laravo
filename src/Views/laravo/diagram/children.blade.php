@if (isset($items))
<ul>
    @foreach($items->sortBy('order') as $childItem)
        @if ($childItem->parent_id === $parentId)
            @php
                $childOrder = $item->order . '.' . $childItem->order;
            @endphp
            <li>
                <span class="badge">{{ $childOrder }}</span>
                <a href="#">@foreach($dataType->browseRows as $row) {{ $data->{$row->field} }} @endforeach</a>                
                @include('vendor.laravo.diagram.children', ['items' => $items, 'parentId' => $childItem->id])
            </li>
        @endif
    @endforeach
</ul>
@endif
