# Zoho Subscriptions PHP SDK
Partial PHP SDK for Zoho Subscriptions

## Usage

To instantiate a client, use the static `build` method with your organisation ID and Auth token from Zoho.

```php
use ZohoSubscription\Client as ZohoClient;

$client = new ZohoClient::build($id, $token);
```

### Customers

If you're creating a customer, most of the customer data is not technically required, so we have setter methods to add it when it is provided:

```php
$customer = new Customer();
$customer->setName($firstName, $lastName, $salutation);
$customer->setEmail($email);
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
$id = $client->createCustomer($client);
```

#### Customer Addresses

adding an address to a customer requires you to create Address objects:

```php
$address = new Address();
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
$subscription = new Subscription($customerId, $planId);

$url = $client->createSubscription($subscription);
```

This creates a hosted page, and returns the URL which your user needs to be redirected to in order to complete their subscription.

You can optionally add a redirect url to the subscription before you send the request to let Zoho know where to send the user after the order has been completed:

```php
$subscription->addRedirectUrl($redirectUrl);
```
