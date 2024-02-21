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
            },
            @endforeach
        ]
    },
    options: {
        animations: {
          tension: {
            duration: 1000,
            easing: 'easeInOutBounce',
            from: 0,
            to: 0.5,
            loop: true
          }
        },
        @if ($options['chart_type'] == 'pie' || $options['chart_type'] == 'doughnut')
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2,
        @elseif ($options['chart_type'] == 'bar')
            indexAxis: 'x',
            borderWidth: 2,
            borderRadius: 5,
        @elseif ($options['chart_type'] == 'line')
            tension: 0.1,
            borderWidth: 2,
        @endif

        plugins: {
            @if ($options['chart_type'] == 'pie')
                labels: [
                    {
                        render: 'percentage',
                        position: 'default',
                        overlap: false,
                        outsidePadding: 2,
                        textMargin: 2,
                        arc: false,
                        fontColor: '#fff'
                    }
                ]
            @elseif ($options['chart_type'] == 'doughnut')
                labels: [
                    {
                        render: 'percentage',
                        position: 'outside',
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