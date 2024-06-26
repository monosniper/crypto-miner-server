window.onload = () => {
    const load = () => {
        fetch("https://api.hogyx.io/v1/geo").then(rs => rs.json()).then(rs => {
            const gdpData = {}

            rs.data.forEach(({country_code, total}) => {
                gdpData[country_code] = total
            })

            $('#world-map-gdp').vectorMap({
                map: 'world_mill',
                series: {
                    regions: [{
                        values: gdpData,
                        scale: ['#f1daf3', '#f2bef9', '#eb9cf7', '#e879f9'],
                        normalizeFunction: 'polynomial'
                    }]
                },
                regionStyle: {
                    initial: {
                        fill: '#ffffff45',
                    },
                },
                onRegionTipShow: function(e, el, code){
                    el.html(el.html()+' ('+(gdpData[code] || 0)+')');
                }
            });
        })
    }

    function tryLoad() {
        setTimeout(() => {
            !document.querySelector('#world-map-gdp') ? tryLoad() : load()
        }, 500)
    }

    tryLoad()
}
