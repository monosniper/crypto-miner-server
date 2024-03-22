<div>
    @section('css')
        //....CDN
    @endsection

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./js/libs/jquery.jvectormap.min.js"></script>
    <script src="./js/libs/jquery-jvectormap-world-mill.js"></script>
    <link rel="stylesheet" href="./css/libs/jquery-jvectormap-2.0.5.css">

    <div id="world-map-gdp" style="width: 600px; height: 400px"></div>
    <script>
        const gdpData = {
            IN: 10000
        }
        $('#world-map-gdp').vectorMap({
            map: 'world_mill',
            series: {
                regions: [{
                    values: gdpData,
                    scale: ['#f2bef9', '#e879f9'],
                    normalizeFunction: 'polynomial'
                }]
            },
            regionStyle: {
                initial: {
                    fill: '#ffffff45',
                },
            },
            onRegionTipShow: function(e, el, code){
                el.html(el.html()+' ('+gdpData[code]+')');
            }
        });
    </script>
</div>
