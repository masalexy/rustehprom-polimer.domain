class WhtsController {
    constructor() {
        this.box_id = 'whv_wdgt';
        this.params = {
            size: 50,
            position: 'left',
            background: '',
            title: '',
            fontSize: '24px',
            bottom: 15,
            sidesOffset: 15,
            phone: '79299464241'
        };
    }
    generate_widget() {
        const widget = document.createElement('div');
        widget.id = this.box_id + '_child';
        widget.style.width = this.params.size + 'px';
        widget.style.height = this.params.size + 'px';
        const ico = '<svg style="width: 100%; height: auto;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.3 512.3"><path d="M256 0.1C114.6 0.2 0 114.8 0.1 256.2c0 49 14.1 96.9 40.5 138.1L0.7 497.6c-2.1 5.5 0.6 11.7 6.1 13.8 1.2 0.5 2.5 0.7 3.9 0.7 1.2 0 2.4-0.2 3.6-0.6l106.7-38.1c120 74.7 277.9 38 352.6-82s38-277.9-82-352.6C350.9 13.5 303.9 0.1 256 0.1z" fill="#4CAF50"/><path d="M378.1 299.9c0 0-26.1-12.8-42.5-21.3 -18.5-9.5-40.3 8.3-50.5 18.5 -15.9-6.1-30.5-15.4-42.8-27.2 -11.8-12.3-21.1-26.9-27.2-42.8 10.2-10.3 28-32 18.5-50.5 -8.4-16.4-21.3-42.5-21.3-42.5 -1.8-3.6-5.5-5.9-9.5-5.9h-21.3c-31.1 5.4-53.7 32.5-53.3 64 0 33.5 40.1 97.8 67.1 124.9s91.4 67.1 124.9 67.1c31.5 0.3 58.6-22.3 64-53.3v-21.3C384 305.4 381.7 301.7 378.1 299.9z" fill="#FAFAFA"/></svg>';
        widget.innerHTML = ico;
        return widget;
    }
    redirect_widget() {
        window.open(
            "https://api.whatsapp.com/send?phone=" + this.params.phone
        );
    }
    append_widget() {
        const container = document.getElementById(this.box_id);
        const style = {
            display: 'flex',
            cursor: 'pointer',
            fontFamily: 'sans-serif',
            padding: this.params.title ? '5px 15px' : '10px',
            borderRadius: this.params.title ? '5px' : '50%',
            zIndex: '900',
            fontSize: this.params.fontSize + 'px',
            flexWrap: 'wrap',
            color: 'white',
            maxWidth: this.params.title ? 'auto' : this.params.size + 'px',
            maxHeight: this.params.title ? 'auto' : this.params.size + 'px',
            fontWeight: 600,
            alignItems: 'center',
            position: 'fixed',
            background: this.params.background,
            bottom: this.params.bottom + 'px',
            [this.params.position]: this.params.sidesOffset + 'px'
        };
        Object.assign(container.style, style);
        if (!container) {
            console.error('РљРѕРЅС‚РµР№РЅРµСЂ СЃ id: ' + this.box_id + ' РЅРµ РЅР°Р№РґРµРЅ');
            return;
        }
        else {
            container.appendChild(this.generate_widget());
            if (this.params.title) {
                const title = document.createElement('span');
                title.innerHTML = this.params.title;
                title.style.paddingLeft = '15px';
                container.appendChild(title);
            }

            container.addEventListener("click", () => {
              this.redirect_widget();
            });
        }
    }
    scroll_controller() {
        const container = document.getElementById(this.box_id);
        let show_timer;
        document.addEventListener('scroll', () => {
            container.style.display = 'none';
            clearTimeout(show_timer);
            show_timer = setTimeout(() => {
                container.style.display = 'flex';
            }, 1000);
        });
    }
    init(custom_params) {
        const cs_params = custom_params;
        console.log(typeof cs_params);
        for (let key in cs_params) {
            if (this.params.hasOwnProperty(key))
                this.params[key] = cs_params[key];
        }

        const currentHost = window.location.host;
        const params = new URLSearchParams(window.location.search)



        this.append_widget();
        this.scroll_controller();
    }
}

const whts_wdgt = new WhtsController();
