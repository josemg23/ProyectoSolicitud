const indicadores = new Vue({
    el: "#indicadores",
    name: "Indicadores",
    data: {
        usd: 0,
        euro: 0,
        uf: 0,
        utm: 0,
        ipc: 0,
        currency: {
            decimalSeparator: ',',
            thousandsSeparator: '.',
            symbolOnLeft: false,
            spaceBetweenAmountAndSymbol: true
        },
    },
    mounted() {
        this.getGames();
    },
    methods: {
        async getGames() {
            try {
                let url = 'https://mindicador.cl/api';
                const r = await fetch(url);
                const conversiones = await r.json();
                this.asigmnConversion(conversiones)
            } catch (error) {
                console.log(error);
            }
        },
        asigmnConversion(c) {
            this.usd = c.dolar.valor;
            this.euro = c.euro.valor;
            this.uf = c.uf.valor;
            this.utm = c.utm.valor;
            this.ipc = c.ipc.valor;
        }
    }
});
