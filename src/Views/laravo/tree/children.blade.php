@if (isset($items))
<ul style="margin-left:5px;">
    @foreach($items->sortBy('order') as $childItem)
        @if ($childItem->parent_id === $parentId)
            @php
                $childOrder = $item->order . '.' . $childItem->order;
            @endphp
            <li>
                <span class="badge">{{ $childOrder }}</span>
                <a href="#">@foreach($dataType->browseRows as $row) {{ $data->{$row->field} }} @endforeach</a>
                        
                <!-- @foreach($actions as $action)
                    @include('voyager::bread.partials.actions', ['action' => $action])
                @endforeach -->
                
                @include('vendor.laravo.tree.children', ['items' => $items, 'parentId' => $childItem->id])
            </li>
        @endif
    @endforeach
</ul>
@endif
