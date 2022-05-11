<?php
/**
 * @package Creator
 * @version 1.0
 */
/*
Plugin Name: Roistat integration
Plugin URI: http://roistat.com
Description: Roistat integration
Armstrong: Roistat Plugin.
Author: Creator
Version: 1.0
Author URI: http://roistat.com
*/

function wpcf7_modify_this( $WPCF7_ContactForm )
{
    $form    = null;
    $name    = null;
    $phone   = null;
    $email   = null;
    $comment = null;

    switch ($_POST['_wpcf7_unit_tag']) {
        case 'wpcf7-f2216-o2':
            $form    = 'Заказать звонок';
            $name    = isset($_POST['user-name']) ? $_POST['user-name'] : $name;
            $phone   = isset($_POST['user-tel'])  ? $_POST['user-tel']  : $phone;
            break;
        case 'wpcf7-f2287-o1':
            $form    = 'Есть вопросы?';
            $name    = isset($_POST['user-name']) ? $_POST['user-name'] : $name;
            $phone   = isset($_POST['user-tel'])  ? $_POST['user-tel']  : $phone;
            break;
        case 'wpcf7-f2131-o4':
            $form    = 'Заказать услугу';
            $name    = isset($_POST['user-name']) ? $_POST['user-name'] : $name;
            $phone   = isset($_POST['user-tel'])  ? $_POST['user-tel']  : $phone;
            break;
        case 'wpcf7-f2423-o3':
            $form    = 'Купить в 1 клик';
            $name    = isset($_POST['user-name'])    ? $_POST['user-name']    : $name;
            $phone   = isset($_POST['user-tel'])     ? $_POST['user-tel']     : $phone;
            $comment = isset($_POST['productTitle']) ? $_POST['productTitle'] : $comment;
            break;
        case 'wpcf7-f2288-p2345-o1':
            $form    = 'Прием пленки';
            $name    = isset($_POST['user-name']) ? $_POST['user-name'] : $name;
            $phone   = isset($_POST['user-tel'])  ? $_POST['user-tel'] : $phone;
            $comment = <<<EOT
Вес: {$_POST['ves']}
Вид вторсырья: {$_POST['user-menu']}
{$_POST['user-radio']}
EOT;
        case 'wpcf7-f2288-p2351-o1':
            $form    = 'Переработка отходов стрейч пленки, прием и сдача полимерных материалов';
            $name    = isset($_POST['user-name']) ? $_POST['user-name'] : $name;
            $phone   = isset($_POST['user-tel'])  ? $_POST['user-tel'] : $phone;
            $comment = <<<EOT
Вес: {$_POST['ves']}
Вид вторсырья: {$_POST['user-menu']}
{$_POST['user-radio']}
EOT;
        case 'wpcf7-f2288-p2360-o1':
            $form    = 'Прием отходов ПНД';
            $name    = isset($_POST['user-name']) ? $_POST['user-name'] : $name;
            $phone   = isset($_POST['user-tel'])  ? $_POST['user-tel'] : $phone;
            $comment = <<<EOT
Вес: {$_POST['ves']}
Вид вторсырья: {$_POST['user-menu']}
{$_POST['user-radio']}
EOT;
        case 'wpcf7-f2288-p2364-o1':
            $form    = 'Прием отходов ПВД';
            $name    = isset($_POST['user-name']) ? $_POST['user-name'] : $name;
            $phone   = isset($_POST['user-tel'])  ? $_POST['user-tel'] : $phone;
            $comment = <<<EOT
Вес: {$_POST['ves']}
Вид вторсырья: {$_POST['user-menu']}
{$_POST['user-radio']}
EOT;
        case 'wpcf7-f2288-p1958-o1':
            $form    = 'Прием и продажа втулок от стрейч пленки';
            $name    = isset($_POST['user-name']) ? $_POST['user-name'] : $name;
            $phone   = isset($_POST['user-tel'])  ? $_POST['user-tel'] : $phone;
            $comment = <<<EOT
Вес: {$_POST['ves']}
Вид вторсырья: {$_POST['user-menu']}
{$_POST['user-radio']}
EOT;
            break;
        case '':
            $form    = '';
            $name    = isset($_POST['']) ? $_POST[''] : $name;
            $phone   = isset($_POST['']) ? $_POST[''] : $phone;
            $email   = isset($_POST['']) ? $_POST[''] : $email;
            $comment = isset($_POST['']) ? $_POST[''] : $comment;
            break;
    }

    // Roistat Begin
    $filterData = array(
        'key'     => 'NzdlODNhN2IwOGUxM2QwNGQyZWYzZmJmYjliOTA2Nzc6MTc4Mjk4',
        'visit'   => isset($_COOKIE['roistat_visit']) ? $_COOKIE['roistat_visit'] : null,
        'form'    => $form,
        'name'    => $name,
        'phone'   => $phone,
        'email'   => $email,
        'comment' => $comment,
    );

    file_get_contents('https://med-tovary.com/roistat/filter.php?' . http_build_query($filterData));
    // Roistat End
}

add_action('wpcf7_before_send_mail', 'wpcf7_modify_this');

function send_order_to_roistat($order_id)
{
    if (mb_strlen($order_id) == 0 || ctype_space($order_id)) {
        return;
    }
    $order = wc_get_order($order_id);
    $inf_order = '';
    foreach ($order->get_items() as $item_id => $item) {
        $inf_order .= ' Название: ' . $item['name'] . ', Количество: ' . $item['qty'] . ', Цена: ' . $item['line_total'] . ' руб.;';
    }
    $inf_order .= ' Сумма заказа: ' . $order->get_total() . ' руб.;';
    $inf_order .= ' Доставка: ' . $order->get_shipping_method() . ';';
    $inf_order .= ' Способ оплаты: ' . $order->payment_method_title . ';';
    if ($order->get_used_coupons()) {
        $inf_order .= 'Использованные купоны: ';
        $order_coupons = $order->get_used_coupons();
        foreach ($order_coupons as $coupon) {
            $inf_order .= $coupon . ', ';
        }
    }
    if (!empty($order->customer_message)) {
        $comment = $order->customer_message;
    } else {
        $comment = null;
    }

    $filterData = array(
        'key'     => 'NzdlODNhN2IwOGUxM2QwNGQyZWYzZmJmYjliOTA2Nzc6MTc4Mjk4',
        'visit'   => isset($_COOKIE['roistat_visit']) ? $_COOKIE['roistat_visit'] : null,
        'form'    => 'Корзина',
        'name'    => $order->billing_first_name,
        'email'   => $order->billing_email,
        'phone'   => $order->billing_phone,
        'comment' => $inf_order,
        'orderId' => $order_id,
    );

    file_get_contents('https://med-tovary.com/roistat/filter.php?' . http_build_query($filterData));
}

add_action('woocommerce_checkout_order_processed', 'send_order_to_roistat', 10, 1);