let contactForms = document.querySelectorAll('.wpcf7');
for (let i = 0; i < contactForms.length; i++) {
    contactForms[i].addEventListener('wpcf7submit', function(event) {
        if (event.detail.status == 'mail_sent') {

            let Inputs = event.detail.inputs,
                Values = {};
            Inputs.map(function(inp) {
                Values[inp.name] = inp.value;
            });


            if (Values['requestId'] == 'order-call') {
                Comagic.addOfflineRequest({
                    name: Values['user-name'],
                    phone: Values['user-tel'],
                    message: 'Заявка: Заказать звонок.'
                });
            }else if (Values['requestId'] == 'order-questions') {
                Comagic.addOfflineRequest({
                    name: Values['user-name'],
                    phone: Values['user-tel'],
                    message: 'Заявка: Остались вопросы.'
                });
            }else if (Values['requestId'] == 'order-service') {
                Comagic.addOfflineRequest({
                    name: Values['user-name'],
                    phone: Values['user-tel'],
                    message: `Заявка: Заказать услугу. Услуга: ${Values['serviceTitle']}.  Ссылка услуги: ${Values['serviceLink']}.`
                });
            }else if (Values['requestId'] == 'order-one-click') {
                Comagic.addOfflineRequest({
                    name: Values['user-name'],
                    phone: Values['user-tel'],
                    message: `Заявка: Купить в один клик. Товар: ${Values['productTitle']}.  Ссылка: ${Values['productLink']}. Цена: ${Values['productPrice']}.`
                });
            }else if (Values['requestId'] == 'order-calculation') {
                Comagic.addOfflineRequest({
                    name: Values['user-name'],
                    phone: Values['user-tel'],
                    message: `Заявка: Заявка на расчет. Вид вторсырья: ${Values['user-menu']}.  Вес: ${Values['ves']}кг. Доставка: ${Values['user-radio']}.`
                });
            }

        }
    }, false);
}
