const gdpData = {
    IN: 10000
}

window.onload = () => {
    const load = () => {
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
    }

    function tryLoad() {
        setTimeout(() => {
            !document.querySelector('#world-map-gdp') ? tryLoad() : load()
        }, 500)
    }

    tryLoad()
}
