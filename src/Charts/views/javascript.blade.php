<script>
    var ctx = document.getElementById("{{ $options['chart_name'] ?? 'myChart' }}");
    var {{ $options['chart_name'] ?? 'myChart' }} = new Chart(ctx, {
        type: '{{ $options['chart_type'] ?? 'line' }}',
        data: {
            labels: [
                @if (count($datasets) > 0)
                    @foreach ($datasets[0]['data'] as $group => $result)
                        "{{ $group }}",
                    @endforeach
                @endif
            ],
        datasets: [
            @foreach ($datasets as $dataset)
            {
                label: '{{ $dataset['name'] ?? $options['chart_title'] }}',
                data: [
                    @foreach ($dataset['data'] as $group => $result)
                        {!! $result !!},
                    @endforeach
                ],
                @if($dataset['hidden'] === true)
                    hidden: true,
                @endif
                @if ($options['chart_type'] == 'line')
                    @if (isset($dataset['fill']) && $dataset['fill'] != '')
                        fill: '{{ $dataset['fill'] }}',
                    @else
                        fill: false,
                    @endif
                    @if (isset($dataset['color']) && $dataset['color'] != '')
                        borderColor: '{{ $dataset['color'] }}',
                    @elseif (isset($dataset['chart_color']) && $dataset['chart_color'] != '')
                        borderColor: 'rgba({{ $dataset['chart_color'] }})',
                    @else
                        borderColor: 'rgba({{ rand(0,255) }}, {{ rand(0,255) }}, {{ rand(0,255) }}, 0.2)',
                    @endif
                @elseif ($options['chart_type'] == 'pie' || $options['chart_type'] == 'doughnut')
                    backgroundColor: [
                        @foreach ($dataset['data'] as $group => $result)
                            @if (isset($dataset['chart_color'][$group]) && $dataset['chart_color'][$group] != '')
                                'rgba({{ $dataset['chart_color'][$group] }})',
                            @else
                                'rgba({{ rand(0,255) }}, {{ rand(0,255) }}, {{ rand(0,255) }}, 0.2)',
                            @endif
                        @endforeach
                    ],
                @elseif ($options['chart_type'] == 'bar' && isset($dataset['chart_color']) && $dataset['chart_color'] != '')
                    borderColor: 'rgba({{ $dataset['chart_color'] }})',
                    backgroundColor: 'rgba({{ $dataset['chart_color'] }}, .2)',
                @elseif ($options['chart_type'] == 'bar')
                    borderRadius: 5,
                @endif
                borderWidth: 2,
            },
            @endforeach
        ]
    },
    options: {
        @if ($options['chart_type'] == 'pie' || $options['chart_type'] == 'doughnut')
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2,
        @elseif ($options['chart_type'] == 'bar')
            indexAxis: 'x',
        @endif

        plugins: {
            @if ($options['chart_type'] == 'pie' || $options['chart_type'] == 'doughnut')
                labels: [
                    {
                        render: 'percentage',
                        position: 'border',
                        overlap: false,
                        outsidePadding: 2,
                        textMargin: 2,
                        arc: false,
                    }
                ]
            @elseif ($options['chart_type'] == 'bar')
                labels: [
                    {
                        render: 'value',
                    }
                ],
            @endif
        },
        tooltips: {
            mode: 'point'
        },
    }
    });
</script>