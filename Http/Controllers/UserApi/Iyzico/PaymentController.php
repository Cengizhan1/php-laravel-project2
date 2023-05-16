<?php

namespace App\Http\Controllers\UserApi\Iyzico;

use App\Enum\SubscriptionPaymentMethodEnum;
use App\Enum\SubscriptionSessionTypeEnum;
use App\Enum\SubscriptionStatusEnum;
use App\Enums\EInvoiceStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserApi\SubscriptionController;
use App\Http\Requests\UserApi\Iyzico\PaymentCheckRequest;
use App\Models\Contact;
use App\Models\Subscription;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionSession;
use Config;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay(UserSubscription $subscription)
    {
        $conversationId = rand(100000000, 999999999);
        # create request class
        $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId($conversationId);
        $request->setPrice($subscription->price);
        $request->setPaidPrice($subscription->price);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setCallbackUrl("https://" . env('APP_DOMAIN') . "/paymentCheck"); // TODO url
        $request->setBasketId($subscription->id);
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);

        $user = auth()->user();
        $buyer = new \Iyzipay\Model\Buyer();
        $address = auth()->user()->addresses->first();
        $buyer->setId($user->id);
        $buyer->setName($user->first_name);
        $buyer->setSurname($user->last_name);
        $buyer->setGsmNumber($user->phone);
        $buyer->setEmail($user->email);
        $buyer->setIdentityNumber($user->tc ?? '74300864791');
        $buyer->setLastLoginDate(date(now()));
        $buyer->setRegistrationDate(date(now()));
        $buyer->setRegistrationAddress($address->address);
        $buyer->setIp("85.34.78.112");
        $buyer->setCity($address->city->name ?? 'test');
        $buyer->setCountry($address->city->country->name ?? 'test');
        $request->setBuyer($buyer);
        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName(auth()->user()->first_name);
        $shippingAddress->setCity($address->city->name ?? 'test');
        $shippingAddress->setCountry($address->city->country->name ?? 'test');
        $shippingAddress->setAddress($address->address);
        $request->setShippingAddress($shippingAddress);
        // Billing address is used because there is no other address
        $request->setBillingAddress($shippingAddress);

        $basketItem = new \Iyzipay\Model\BasketItem();
        $basketItem->setId($subscription->id);
        $basketItem->setName($subscription->name);
        $basketItem->setCategory1(SubscriptionSessionTypeEnum::from($subscription->subscription_category)->label);
        $basketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
        $basketItem->setPrice($subscription->price);
        $basketItems[0] = $basketItem;

        $request->setBasketItems($basketItems);
        $payment = \Iyzipay\Model\CheckoutFormInitialize::create($request, Config::options());

        if ($payment->getStatus() == 'success')
            return response()->success(data: $payment->getPaymentPageUrl());
        else {
            return $payment->getErrorMessage();
        }
    }

    public function paymentCheck(PaymentCheckRequest $checkRequest)
    {
        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId("123456789");
        $request->setToken($checkRequest->token);
        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, Config::options());
        $userSubscription = UserSubscription::find($checkoutForm->getBasketId());
        if ($checkoutForm->getStatus() == 'success') {
            $subscriptionController = new SubscriptionController();
            $subscriptionController->subscriptionCreateComplete($userSubscription->id);
        } else {
            $userSubscription->update([
                'status' => SubscriptionStatusEnum::paymentDeclined()->value,
            ]);
        }
//        return view('payment.result', compact('checkoutForm'));
    }
}
