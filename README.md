# Zoho Subscriptions PHP SDK
Partial PHP SDK for Zoho Subscriptions

## Usage

To instantiate a client, use the static `build` method with your organisation ID and Auth token from Zoho.

```php
use ZohoSubscription\Client as ZohoClient;

$client = new ZohoClient::build($id, $token);
```

### Customers

If you're creating a customer, most of the customer data is not technically required (except the email address), so we have setter methods to add it when it is provided:

```php
$customer = new \ZohoSubscription\Resources\Customers\Customer($email);
$customer->setName($firstName, $lastName, $salutation);
$customer->setCompanyName($companyName);
$customer->setCurrencyCode($currencyCode);
$customer->setDisplayName($displayName);
$customer->setVatRegistration($countryCode, $vatNumber);
```

You can add custom fields to customers like so:

```php
$customer->addCustomField('label', 'value', 'data type');
$customer->addCustomField('label 2', 'value', 'data type');
```

Then when you're ready to save the customer, you send it to the method in the client, which returns the customer ID:

```php
$id = $client->send($client)->getId();
```

#### Customer Addresses

adding an address to a customer requires you to create Address objects:

```php
$address = new  new \ZohoSubscription\Resources\Customers\Address();
$address->setRegion($country, $state, $zip);
$address->setLocale($street, $city, $attention);
```
then you can add it to the billing address or the shipping address on the customer before sending the request:

```php
$customer->setBillingAddress($address);

$customer->setShippingAddress($address);
```

### Hosted Page: Subscriptions

Creating a subscription is, at it's simplest, a case of creating a Subscription entity and sending it to the client:

```php
$subscription = new  new \ZohoSubscription\Resources\HostedPages\Subscription($customerId, $planId);

$url = $client->send($subscription)->getId();
```

This creates a hosted page, and returns the URL which your user needs to be redirected to in order to complete their subscription.

You can optionally add a redirect url to the subscription before you send the request to let Zoho know where to send the user after the order has been completed:

```php
$subscription->addRedirectUrl($redirectUrl);
```

## Regions

Zoho Subscriptions are available in different regions, which have different URL's to access the API.

To change to the EU region, you can use the `setApiRegionEU()` method on the `Client` class, and change it back with the `setApiRegionCOM()`

```php
$client = ZohoSubscription\Client::build();

$client->setApiRegionEU();
$client->setApiRegionCOM();

$request = new ZohoSubscription\Resources\Customers\Customer('test@example.com');

$client->send($request);
```

## Creating new API methods

I have currently only created API classes for the functionality that is needed for the current project I am working on.
If you need anything else, you can easily do so by implementing the `ZohoSubscription\Contracts\Requestable` interface and
optionally using the `ZohoSubscription\Partials\HasRequestables` trait, for example this is a very basic Payment API implementation:


```php 
namespace MyCo\Zoho\Resources\Payments;

use ZohoSubscription\Contracts\Requestable;
use ZohoSubscription\Partials\HasRequestables;

class Payment implements Requestable
{
    use HasRequestables;
    
    public function __construct(string $customerId, int $amount, string $paymentMode)
    {
        $this->attributes['customer_id'] = $customerId;
        $this->attributes['amount'] = $amount;
        $this->attributes['payment_mode'] = $paymentMode;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getUri(): string
    {
        return 'payments';
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getId(): string
    {
        if (is_null($this->response)) {
            throw new \Exception('Trying to get ID when request not sent yet');
        }
        return json_decode($this->response->getBody())->payment->payment_id;
    }
}


```

which you could build up and pass to the client's `send` method.

```php

$payment = new MyCo\Zoho\Resources\Payments($customerId, $amount, 'cash');

$paymentId = $client->send($payment)->getId();

```