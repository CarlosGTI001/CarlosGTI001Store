# OffersV2

Source: `_creatorsapi_docs_en-us_api-reference_resources_offersV2#savingbasis.html`

# OffersV2

The `OffersV2` resource contains various resources related to offer listings for an item.

## Resources

-   [Listings](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#listings.md)
    -   [Availability](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#availability.md)
        -   [MaxOrderQuantity](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#availability.md)
        -   [Message](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#availability.md)
        -   [MinOrderQuantity](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#availability.md)
        -   [Type](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#availability.md)
    -   [Condition](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#condition.md)
        -   [ConditionNote](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#condition.md)
        -   [SubCondition](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#condition.md)
        -   [Value](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#condition.md)
    -   [DealDetails](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#dealdetails.md)
        -   [AccessType](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#dealdetails.md)
        -   [Badge](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#dealdetails.md)
        -   [EarlyAccessDurationInMilliseconds](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#dealdetails.md)
        -   [EndTime](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#dealdetails.md)
        -   [PercentClaimed](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#dealdetails.md)
        -   [StartTime](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#dealdetails.md)
    -   [IsBuyBoxWinner](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#listings.md)
    -   [LoyaltyPoints](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#loyaltypoints.md)
        -   [Points](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#loyaltypoints.md)
    -   [MerchantInfo](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#merchantinfo.md)
        -   [Name](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#merchantinfo.md)
        -   [Id](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#merchantinfo.md)
    -   [Price](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#price.md)
        -   [Money](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#price.md)
        -   [PricePerUnit](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#price.md)
        -   [SavingBasis](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#savingbasis.md)
            -   [Money](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#savingbasis.md)
            -   [SavingBasisType](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#savingbasis.md)
            -   [SavingBasisTypeLabel](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#savingbasis.md)
        -   [Savings](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#savings.md)
            -   [Money](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#savings.md)
            -   [Percentage](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#savings.md)
    -   [Type](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#listings.md)
    -   [ViolatesMAP](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#listings.md)

### Listings

Specifies the various offer listings associated with the product.

Attribute Name

Type

Description

[Availability](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#availability.md)

Struct

Specifies availability information about an offer

[Condition](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#condition.md)

Struct

Specifies the condition of the offer

[DealDetails](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#dealdetails.md)

Struct

Specifies deal information of the offer

IsBuyBoxWinner

Boolean

Specifies whether the given offer is the winner of the BuyBox in the Detail Page Experience (DPX) of an item. This is the best offer recommended by Amazon for any product. This featured offer is seen on Detail Page on an ASIN.

[LoyaltyPoints](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#loyaltypoints.md)

Struct

Specifies loyalty points related information for an offer (Currently only supported in the Japan marketplace)

[MerchantInfo](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#merchantinfo.md)

Struct

Specifies merchant information of an offer

[Price](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#price.md)

Struct

Specifies buying price of an offer

Type

String

Specifies the type of offer if there is a special distinction. Most listings will not have a type, such as regular listings and non-lightning deals. Valid Values: LIGHTNING\_DEAL, SUBSCRIBE\_AND\_SAVE

ViolatesMAP

Boolean

Specifies whether an offer violates MAP policy or not. Please refer to [this](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#minimum-advertising-price.md) for more details

#### Sample Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00MNV8E0C",
        "detailPageURL": "https://www.amazon.com/dp/B00MNV8E0C?tag=example&linkCode=ogi&th=1&psc=1",
        "offersV2": {
          "listings": [
            {
              "availability": {
                "maxOrderQuantity": 1,
                "minOrderQuantity": 1,
                "type": "IN_STOCK"
              },
              "condition": {
                "conditionNote": "",
                "subCondition": "Unknown",
                "value": "New"
              },
              "dealDetails": {
                "accessType": "PRIME_EXCLUSIVE",
                "endTime": "2024-11-06T05:35Z",
                "percentClaimed": 38,
                "startTime": "2024-11-05T18:05Z"
              },
              "isBuyBoxWinner": true,
              "merchantInfo": {
                "name": "Amazon.com"
              },
              "price": {
                "money": {
                  "amount": 59.49,
                  "currency": "USD",
                  "displayAmount": "$59.49"
                },
                "pricePerUnit": {
                  "amount": 29.75,
                  "currency": "USD",
                  "displayAmount": "$29.75 / Count"
                },
                "savingBasis": {
                  "money": {
                    "amount": 69.99,
                    "currency": "USD",
                    "displayAmount": "$69.99"
                  },
                  "savingBasisType": "LIST_PRICE",
                  "savingBasisTypeLabel": "List Price"
                },
                "savings": {
                  "money": {
                    "amount": 10.5,
                    "currency": "USD",
                    "displayAmount": "$10.50"
                  },
                  "percentage": 15
                }
              },
              "type": "LIGHTNING_DEAL",
              "violatesMAP": false
            }
          ]
        }
      }
    ]
  }
}
```

### Availability

Attribute Name

Type

Description

MaxOrderQuantity

Integer

Specifies the maximum quantity of a product that can be purchased

Message

String

Specifies availability message of a product

MinOrderQuantity

Integer

Specifies minimum number of quantity needed to make purchase of a product

Type

String

Describe about the availability type of product. Valid Values: AVAILABLE\_DATE, IN\_STOCK, IN\_STOCK\_SCARCE, LEADTIME, OUT\_OF\_STOCK, PREORDER, UNAVAILABLE, UNKNOWN

More detail on Availability Types:

Status

Description

AVAILABLE\_DATE

The item is not available, but will be available on a future date.

IN\_STOCK

The item is in stock.

IN\_STOCK\_SCARCE

The item is in stock, but stock levels are limited.

LEADTIME

The item is only available after some amount of lead time (order received to order shipped time)

OUT\_OF\_STOCK

The item is currently out of stock.

PREORDER

The item is not yet available, but can be pre-ordered.

UNAVAILABLE

The item is not available

UNKNOWN

Unknown availability

#### Sample Response

Copy

```
{
  "availability": {
    "maxOrderQuantity": 30,
    "message": "In Stock",
    "minOrderQuantity": 1,
    "type": "IN_STOCK"
  }
}
```

### Condition

For Offers with value `New`, there will not be a specified `ConditionNote` and `SubCondition` will be Unknown

Attribute Name

Type

Description

ConditionNote

String

Specifies the product condition as provided by the seller. May be blank

Value

String

Specifies the offer condition. Valid Values: New, Used, Refurbished, Unknown

SubCondition

String

Specifies the SubCondition of an offer Valid Values: LikeNew, Good, VeryGood, Acceptable, Refurbished, OEM, OpenBox, Unknown

#### Sample Response

Copy

```
{
  "condition": {
    "conditionNote": "",
    "subCondition": "Unknown",
    "value": "New"
  }
}
```

### DealDetails

This field will only be populated if there is a deal associated with the listing. The existence of this field (when requested) implies the existence of a deal.

The easiest way to find deals on Amazon is by visiting [https://www.amazon.com/deals](https://www.amazon.com/deals), or the appropriate equivalent in your marketplace of choice.

Attribute Name

Type

Description

AccessType

String

Specifies which customers can claim the deal (everyone or only Prime members). Prime Early Access is available to Prime members first (for time specified by EarlyAccessDurationInMilliseconds) before becoming available to everyone. Valid Values: ALL, PRIME\_EARLY\_ACCESS, PRIME\_EXCLUSIVE.

Badge

String

Specifies a badge to accompany the deal. Example Values: Limited Time Deal, With Prime, Black Friday Deal, Ends In

EarlyAccessDurationInMilliseconds

Integer

Specifies the number of milliseconds that a deal is first available to Prime members only, if applicable

EndTime

String

Specifies the UTC deal end time. It is possible for the deal to end sooner (For example: sold out)

PercentClaimed

String

Specifies how much capacity of a deal is already consumed. Not available on all deal types.

StartTime

String

Specifies the UTC deal start time

#### More detail on Deal Badge:

The deal Badge is a string that can be displayed to accompany the deal. It may describe the kind of deal (Ex: Limited Time Deal, Black Friday Deal), a particular aspect of the deal (Ex: With Prime on prime exclusive deals), or some other form of information about the deal. For deals that are ending soon, this badge will often display "Ends In" - this can be used in conjunction with the `EndTime` parameter if you wish to implement a countdown timer.

#### More detail on start/end time

There is no guarantee that there will be a start/end time specified in the response (as applies to any PA-API field, which may or may not be present). Deals that do not have a start/end time are running indefinitely, and do not have a pre-defined running duration. In this case, the existence of the `DealDetails` object in the response means that the deal is live at the time of the call.

Please note that a Prime Early Access Deal is only available to Prime customers for the specified early access duration, before becoming available to all customers specified by the `StartTime` when present.

#### Sample Response

##### Limited Time Deal

Copy

```
{
   "dealDetails": {
    "accessType": "ALL",
    "badge": "Limited time deal",
    "endTime": "2025-03-02T07:59:59Z",
    "startTime": "2025-02-16T08:00Z"
   }
}
```

##### Deal that is ending soon

Copy

```
{
  "dealDetails": {
    "accessType": "PRIME_EARLY_ACCESS",
    "badge": "Ends in ",
    "earlyAccessDurationInMilliseconds": 1800000,
    "endTime": "2025-02-21T05:35Z",
    "percentClaimed": 35,
    "startTime": "2025-02-20T18:05Z"
  }
}
```

### LoyaltyPoints

Loyalty Points is an Amazon Japan only program. See [https://www.amazon.co.jp/-/en/gp/help/customer/display.html?nodeId=GGB6FCM85P9UKC7T](https://www.amazon.co.jp/-/en/gp/help/customer/display.html?nodeId=GGB6FCM85P9UKC7T)

Attribute Name

Type

Description

Points

Integer

Specifies loyalty points associated with an offer

#### Sample Response

Copy

```
{
  "loyaltyPoints": {
    "points": 10
  }
}
```

### MerchantInfo

Attribute Name

Type

Description

Id

String

Unique identifier for merchant/seller

Name

String

The name of merchant/seller

#### Sample Response

Copy

```
{
  "merchantInfo": {
    "id": "ATVPDKIKX0DER",
    "name": "Amazon.com"
  }
}
```

### Price

Please note that the price served represents the price shown for a `logged-in` Amazon user with an `in-marketplace` shipping address.

Attribute Name

Type

Description

Money

[Money](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#money.md)

Specifies buying amount of an offer

PricePerUnit

[Money](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#money.md)

Specifies price per unit. DisplayAmount includes unit formatting

[SavingBasis](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#savingbasis.md)

Struct

Specifies the currency associate with the buying amount

[Savings](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#savings.md)

Struct

Specifies savings on an offer. This is the difference between the Price Money and the SavingBasis Money

#### Sample Response

Copy

```
{
  "price": {
    "money": {
      "amount": 59.49,
      "currency": "USD",
      "displayAmount": "$59.49"
    },
    "pricePerUnit": {
      "amount": 29.75,
      "currency": "USD",
      "displayAmount": "$29.75 / Count"
    },
    "savingBasis": {
      "money": {
        "amount": 69.99,
        "currency": "USD",
        "displayAmount": "$69.99"
      },
      "savingBasisType": "LIST_PRICE",
      "savingBasisTypeLabel": "List Price"
    },
    "savings": {
      "money": {
        "amount": 10.5,
        "currency": "USD",
        "displayAmount": "$10.50"
      },
      "percentage": 15
    }
  }
}

```

### SavingBasis

Reference Value Which is used to calculate savings against

Attribute Name

Type

Description

Money

[Money](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#money.md)

Specifies saving basis money information

SavingBasisType

String

Specifies type of saving basis. Valid Values: LIST\_PRICE, LOWEST\_PRICE, LOWEST\_PRICE\_STRIKETHROUGH, WAS\_PRICE

SavingBasisTypeLabel

String

Label String that can be included next to the saving basis amount.

#### Sample Response

Copy

```
{
  "savingBasis": {
    "money": {
      "amount": 69.99,
      "currency": "USD",
      "displayAmount": "$69.99"
    },
    "savingBasisType": "LIST_PRICE",
    "savingBasisTypeLabel": "List Price"
  }
}

```

### Savings

Savings of an Offer

Attribute Name

Type

Description

Money

[Money](./_creatorsapi_docs_en-us_api-reference_resources_offersV2#money.md)

Specifies savings money information

Percentage

Integer

Specifies savings percentage on an offer

#### Sample Response

Copy

```
{
  "savings": {
    "money": {
      "amount": 10.5,
      "currency": "USD",
      "displayAmount": "$10.50"
    },
    "percentage": 15
  }
}
```

### Money

Common Struct used for representing money

Attribute Name

Type

Description

Amount

BigDecimal

Specifies amount

Currency

String

Specifies the currency associate with the buying amount

DisplayAmount

String

Specifies formatted amount

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)
-   [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)

## Appendix

### Minimum Advertising Price

Some manufacturers have a minimum advertised price (MAP) that can be displayed on Amazon.com. When the Amazon price is lower than the MAP, the manufacturer does not allow the price to be shown until the customer takes further action, such as placing the item in their shopping cart, or in some cases, proceeding to the final checkout stage. Customers need to go to Amazon to see the price on the retail website, but won't be required to purchase the product.

### Offersv1 to Offersv2 Field Mapping

The following table provides a comprehensive mapping of all fields from the legacy Offers resource to the new OffersV2 resource. Fields marked as "Not Available" have been intentionally discontinued in OffersV2. OffersV2 provides only featured listings as shown to retail customers on Amazon Detail Page buybox, which represent the best overall offers for the product. **If there are no featured offers, OffersV2 will show status as out of stock.**

**OffersV1 Field**

**OffersV2 Field**

**Core Structure**

`Offers.Listings`

`OffersV2.Listings`

`Offers.Summaries`

Not Available

`Offers.Summaries.Condition`

Not Available

`Offers.Summaries.HighestPrice`

Not Available

`Offers.Summaries.LowestPrice`

Not Available

`Offers.Summaries.OfferCount`

Not Available

**Availability**

`Offers.Listings.Availability.MaxOrderQuantity`

`OffersV2.Listings.Availability.MaxOrderQuantity`

`Offers.Listings.Availability.Message`

`OffersV2.Listings.Availability.Message`

`Offers.Listings.Availability.MinOrderQuantity`

`OffersV2.Listings.Availability.MinOrderQuantity`

`Offers.Listings.Availability.Type`

`OffersV2.Listings.Availability.Type`

**Condition**

`Offers.Listings.Condition.Value`

`OffersV2.Listings.Condition.Value`

`Offers.Listings.Condition.SubCondition.Value`

`OffersV2.Listings.Condition.SubCondition`

`Offers.Listings.Condition.ConditionNote.Value`

`OffersV2.Listings.Condition.ConditionNote`

**DeliveryInfo**

`Offers.Listings.DeliveryInfo.IsAmazonFulfilled`

Not Available

`Offers.Listings.DeliveryInfo.IsFreeShippingEligible`

Not Available

`Offers.Listings.DeliveryInfo.IsPrimeEligible`

Not Available

`Offers.Listings.DeliveryInfo.ShippingCharges`

Not Available

**Listing Core Fields**

`Offers.Listings.Id`

Not Available

`Offers.Listings.IsBuyBoxWinner`

`OffersV2.Listings.IsBuyBoxWinner`

`Offers.Listings.ViolatesMAP`

`OffersV2.Listings.ViolatesMAP`

**LoyaltyPoints**

`Offers.Listings.LoyaltyPoints.Points`

`OffersV2.Listings.LoyaltyPoints.Points`

**MerchantInfo**

`Offers.Listings.MerchantInfo.DefaultShippingCountry`

Not Available

`Offers.Listings.MerchantInfo.FeedbackCount`

Not Available

`Offers.Listings.MerchantInfo.FeedbackRating`

Not Available

`Offers.Listings.MerchantInfo.Id`

`OffersV2.Listings.MerchantInfo.Id`

`Offers.Listings.MerchantInfo.Name`

`OffersV2.Listings.MerchantInfo.Name`

**Price**

`Offers.Listings.Price.Amount`

`OffersV2.Listings.Price.Money.Amount`

`Offers.Listings.Price.Currency`

`OffersV2.Listings.Price.Money.Currency`

`Offers.Listings.Price.DisplayAmount`

`OffersV2.Listings.Price.Money.DisplayAmount`

`Offers.Listings.Price.PricePerUnit`

`OffersV2.Listings.Price.PricePerUnit`

**ProgramEligibility**

`Offers.Listings.ProgramEligibility.IsPrimeExclusive`

Not Available

`Offers.Listings.ProgramEligibility.IsPrimePantry`

Not Available

**Promotions**

`Offers.Listings.Promotions`

Not Available

**SavingBasis**

`Offers.Listings.SavingBasis.Amount`

`OffersV2.Listings.Price.SavingBasis.Money.Amount`

`Offers.Listings.SavingBasis.Currency`

`OffersV2.Listings.Price.SavingBasis.Money.Currency`

`Offers.Listings.SavingBasis.DisplayAmount`

`OffersV2.Listings.Price.SavingBasis.Money.DisplayAmount`

**New in OffersV2**

N/A

`OffersV2.Listings.DealDetails`

N/A

`OffersV2.Listings.DealDetails.AccessType`

N/A

`OffersV2.Listings.DealDetails.Badge`

N/A

`OffersV2.Listings.DealDetails.EarlyAccessDurationInMilliseconds`

N/A

`OffersV2.Listings.DealDetails.EndTime`

N/A

`OffersV2.Listings.DealDetails.PercentClaimed`

N/A

`OffersV2.Listings.DealDetails.StartTime`

N/A

`OffersV2.Listings.Price.SavingBasis`

N/A

`OffersV2.Listings.Price.SavingBasis.SavingBasisType`

N/A

`OffersV2.Listings.Price.SavingBasis.SavingBasisTypeLabel`

N/A

`OffersV2.Listings.Price.Savings`

N/A

`OffersV2.Listings.Price.Savings.Money`

N/A

`OffersV2.Listings.Price.Savings.Percentage`

N/A

`OffersV2.Listings.Type`
