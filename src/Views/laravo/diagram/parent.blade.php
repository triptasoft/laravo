<div class="col-md-12">
    <div class="panel panel-bordered">
        <div class="panel-body">
            <div id="tree" class="tree">
                <ul>
                    @foreach($dataTypeContent->sortBy('order') as $key => $item)

                        @php
                            $data = $dataTypeContent->filter(function ($record, $key) use($item) {
                                return $record->id === $item['id'] ;
                            })->first();
                        @endphp

                        @if ($item->parent_id === null)
                            <li>
                            <span class="badge">{{ $item->order }}</span>
                            <a href="#">@foreach($dataType->browseRows as $row) {{ $data->{$row->field} }} @endforeach</a>    
                                @include('.vendor.laravo.diagram.children', ['items' => $dataTypeContent, 'parentId' => $item->id])
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>