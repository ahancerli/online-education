<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 26.08.2020
 * Time: 22:00
 */

namespace App\Controllers\Front;

require_once(APPPATH .'ThirdParty/iyzipay-php/IyzipayBootstrap.php');

use App\Models\AddressModel;
use CodeIgniter\Controller;

class CheckoutController extends Controller
{
    private $options;

    public function __construct()
    {
        helper('session');
        helper('cookie');
        helper('string');

        \IyzipayBootstrap::init();

        $options = new \Iyzipay\Options();
        $options->setApiKey('sandbox-fFfGiVPGBi0J40u855Xt7U7zXrvbjE9y');
        $options->setSecretKey('sandbox-xF1FzXnA94TZJgfgVhdqxJsEVLPxQF8C');
        $options->setBaseUrl('https://sandbox-api.iyzipay.com');

        $this->options = $options;
    }

    public function index()
    {
        $cart = get_cookie('cart') ? json_decode(get_cookie('cart'), true) : [];
        $courses = [];

        if (count($cart) > 0)
            $courses = model('CourseModel')
                ->where('status', 1)
                ->whereIn('id', $cart)
                ->select('id, title, image_name, slug, price, discount_ratio')
                ->findAll();

        if (count($courses) == 0)
            return redirect()->to('/cart');

        $address = model('AddressModel')->where('user_id', user_id())->first();

        $pageTitle = 'Ödeme';

        return view('front/checkout', compact('address', 'courses', 'pageTitle'));
    }

    public function attemptPay()
    {
        $rules = [
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'required',
            'identity_number' => 'required',
            'country' => 'required',
            'city' => 'required',
            'county' => 'required',
            'address' => 'required',
        ];

        $messages = [
            'name' => [
                'required' => 'Adınız gereklidir'
            ],
            'surname' => [
                'required' => 'Soyadınız gereklidir'
            ],
            'phone' => [
                'required' => 'Telefon numarası gereklidir'
            ],
            'identity_number' => [
                'required' => 'Vergi/kimlik numarası gereklidir'
            ],
            'country' => [
                'required' => 'Ülke gereklidir'
            ],
            'city' => [
                'required' => 'Şehir gereklidir'
            ],
            'county' => [
                'required' => 'İlçe gereklidir'
            ],
            'address' => [
                'required' => 'Adres gereklidir'
            ]
        ];

        if (!$this->validate($rules, $messages))
            return redirect()->to('checkout')->withInput()->with('errors', $this->validator->getErrors());

        $cart = get_cookie('cart') ? json_decode(get_cookie('cart'), true) : [];
        $courses = [];

        if (count($cart) > 0)
            $courses = model('CourseModel')
                ->where('status', 1)
                ->whereIn('id', $cart)
                ->select('id, title, image_name, slug, price, discount_ratio')
                ->findAll();

        if (count($courses) == 0)
            return redirect()->to('/cart');

        $addressModel = new AddressModel();
        $address = $addressModel->where('user_id', user_id())->first();

        $postData = $this->request->getPost();
        $postData['user_id'] = user_id();

        if (!$address)
            $addressModel->insert($postData);
        else
            $addressModel->update($address['id'], $postData);

        $courseIds = array();
        $basketItems = array();
        $totaPrice = 0;

        foreach ($courses as $course) {
            $courseIds[] = $course['id'];

            $basketItem = new \Iyzipay\Model\BasketItem();
            $basketItem->setId('BI' . $course['id']);
            $basketItem->setName($course['title']);
            $basketItem->setCategory1('Kurs');
            $basketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);

            if ($course['discount_ratio'] > 0)
                $price = $course['price'] - ($course['price'] * $course['discount_ratio'] / 100);
            else
                $price = $course['price'];

            $totaPrice += $price;

            $basketItem->setPrice($price);

            $basketItems[] = $basketItem;
        }

        $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setPrice($totaPrice);
        $request->setPaidPrice($totaPrice);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setCallbackUrl("http://localhost/checkout_callback");
        $request->setEnabledInstallments(array(1));

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId('BY' . user_id());
        $buyer->setName($postData['name']);
        $buyer->setSurname($postData['surname']);
        $buyer->setGsmNumber($postData['phone']);
        $buyer->setEmail(user()->email);
        $buyer->setIdentityNumber($postData['identity_number']);
        $buyer->setRegistrationAddress($postData['address']);
        $buyer->setIp($this->request->getIPAddress());
        $buyer->setCity($postData['city']);
        $buyer->setCountry($postData['country']);
        $buyer->setZipCode($postData['postal_code']);

        $request->setBuyer($buyer);
        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName($postData['name'] . ' ' . $postData['surname']);
        $shippingAddress->setCity($postData['city']);
        $shippingAddress->setCountry($postData['country']);
        $shippingAddress->setAddress($postData['address']);
        $shippingAddress->setZipCode($postData['postal_code']);
        $request->setShippingAddress($shippingAddress);

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($postData['name'] . ' ' . $postData['surname']);
        $billingAddress->setCity($postData['city']);
        $billingAddress->setCountry($postData['country']);
        $billingAddress->setAddress($postData['address']);
        $billingAddress->setZipCode($postData['postal_code']);
        $request->setBillingAddress($billingAddress);

        $request->setBasketItems($basketItems);

        $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, $this->options);

        if ($checkoutFormInitialize->getStatus() == 'success') {
            $token = $checkoutFormInitialize->getToken();
            session()->set('order_' . $token, [
                'user_id' => user_id(),
                'course_id' => $courseIds,
                'price' => $totaPrice,
                'order_note' => $this->request->getPost('order_note') ?? ''
            ]);

            return redirect()->back()->with('checkout_form_content', $checkoutFormInitialize->getCheckoutFormContent());
        } else {
            return redirect()->back()->with('error', $checkoutFormInitialize->getErrorMessage());
        }
    }

    public function paymentCallback()
    {
        if (!$this->validate(['token' => 'required']))
            return redirect()->to('/');

        if (!session()->has('order_' . $this->request->getPost('token')))
            return redirect()->to('/');

        $token = $this->request->getPost('token');
        $order = session('order_' . $token);

        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setToken($token);

        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $this->options);

        if ($checkoutForm->getStatus() == 'success' && $checkoutForm->getPaymentStatus() == 'SUCCESS') {
            $orderData = [
                'order_code' => $this->generateOrderCode(),
                'course_id' => json_encode($order['course_id']),
                'user_id' => $order['user_id'],
                'amount' => number_format($order['price'], 2),
                'order_note' => $order['order_note']
            ];

            model('OrderModel')->insert($orderData);

            if (is_array($order['course_id']))
                foreach ($order['course_id'] as $id)
                    model('EnrollmentModel')->insert(['course_id' => $id, 'user_id' => $order['user_id']]);

            session()->remove('order_' . $token);
            set_cookie('cart', json_encode([]));

            $orderData = array_merge($orderData, ['pageTitle' => 'Teşekkürler']);

            return view('front/thanks', $orderData);
        } else {
            return redirect()->to('cart')->with('error', $checkoutForm->getErrorMessage());
        }
    }

    private  function generateOrderCode()
    {
        $count = model('OrderModel')->countAll();
        return 'ORD' . str_pad($count + 1, 4, 0, STR_PAD_LEFT);
    }
}