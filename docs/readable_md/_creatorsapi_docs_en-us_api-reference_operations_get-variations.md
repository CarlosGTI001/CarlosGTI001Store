# GetVariations

Source: `_creatorsapi_docs_en-us_api-reference_operations_get-variations.html`

# GetVariations

## Description

Given an ASIN, the `GetVariations` operation returns a set of items that are the same product, but differ according to a consistent theme, for example size and color. These items which differ according to a consistent theme are called variations. A variation is a child ASIN. The parent ASIN is an abstraction of the children items. For example, a shirt is a parent ASIN and parent ASINs cannot be sold. A child ASIN would be a blue shirt, size 16, sold by MyApparelStore. This child ASIN is one of potentially many variations. The ways in which variations differ are called dimensions. In the preceding example, size and color are the dimensions.

`GetVariations` supports the following high-Level resources:

-   [BrowseNodeInfo](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info.md)
-   [Images](./_creatorsapi_docs_en-us_api-reference_resources_images.md)
-   [ItemInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)
-   [OffersV2](./_creatorsapi_docs_en-us_api-reference_resources_offersV2.md)
-   [VariationSummary](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary.md)

## Availability

All locales, however, the parameter support varies by locale.

## Request Parameters

Check [Common Request Headers and Parameters](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.md) for more information on common input parameters. For detailed information on how to create and send a request, refer [Using cURL](./_creatorsapi_docs_en-us_get-started_using-curl.md). All `GetVariations` input parameters are listed below:

Name

Description

Required

asin

Amazon Standard Identification Number. • Type: Non-Empty String • Default Value: None • Usage: \`{"asin" : "B0199980K4"}\`

Yes

condition

The condition parameter filters offersV2 by condition type. For example, Condition:New will return items having atleast one offer of New condition type. For more information and valid values, refer Condition Parameter. • Type: String • Default Value: \`Any\` • Usage: \`{"condition":"New"}\`

No

currencyOfPreference

Currency of preference in which the prices information should be returned in response. By default the prices are returned in the default currency of the marketplace. Expected currency code format is the ISO 4217 currency code (i.e. USD, EUR etc.). For information on default currency and valid currencies for a marketplace, refer Locale Reference. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"currencyOfPreference":"USD"}\`

No

languagesOfPreference

Languages of preference in which the information should be returned in response. By default the information is returned in the default language of the marketplace. Expected locale format is the ISO 639 language code followed by underscore followed by the ISO 3166 country code (i.e. en\_US, fr\_CA etc.). For information on default language and valid languages for a marketplace, refer Locale Reference. Currently only single language of preference is supported. • Type: List of Strings (Non-Empty) • Default Value: None • Usage: \`{"languagesOfPreference":\["en\_US"\]}\`

No

marketplace

Target Amazon Locale. For more information, refer Common Request Headers and Parameters. • Type: String • Default Value: None • Usage: \`{"marketplace":"www.amazon.com"}\`

No

partnerTag

Unique Id for a partner. For more information, refer Common Request Headers and Parameters. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"partnerTag":"xyz-20"}\`

Yes

resources

Specifies the types of values to return. You can specify multiple resources in one request. For list of valid Resources for GetItems operation, refer Resources Parameter. • Type: List of Strings • Default Value: \`\["itemInfo.title"\]\` • Usage: \`"resources" : \[ "images.primary.small", "itemInfo.productInfo"\]\`

No

variationCount

Number of variations to be returned per page in GetVariations. By default, GetVariations returns 10 variations per page. • Type: Positive Integer Less than 10 • Default Value:\`10\` • Usage: \`{"variationCount":10}\`

No

variationPage

Page number of variations returned by GetVariations. By default, GetVariations returns 10 variations. Use VariationPage to return a subsection of the response. By default, there are 10 variations per page. • Type: Positive Integer • Default Value:\`1\` • Usage: \`{"variationPage":1}\`

No

#### Condition Parameter

Note that, a `GetVariations` request with a particular Condition parameter may return 0 offers if there are no offers with the specified condition.

Condition Value

Description

Any

Offer Listings for items across any condition. Includes New and Used.

New

Offer Listings for New items

#### Resources Parameter

Resource Value

Description

browseNodeInfo.browseNodes

Get the browse nodes associated with the item. Using this resource only will return Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node. For more information, refer [BrowseNodeInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info.md).

browseNodeInfo.browseNodes.ancestor

Get the Ancestry ladder associated with each of the browse nodes the item falls under. Using this resource will return ancestry ladder along with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node. For more information, refer [BrowseNodeInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info.md).

browseNodeInfo.browseNodes.salesRank

Get the SalesRank information with each of the browse nodes the item falls under. Using this resource will return sales rank along with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node. For more information, refer [BrowseNodeInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info.md).

browseNodeInfo.websiteSalesRank

Get WebsiteSalesRank information associated with the item. For more information, refer [BrowseNodeInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info.md).

images.primary.small

Returns small-sized primary image for each item. For more information, refer [Images Resources](./_creatorsapi_docs_en-us_api-reference_resources_images.md)

images.primary.medium

Returns medium-sized primary image for each item. For more information, refer [Images Resources](./_creatorsapi_docs_en-us_api-reference_resources_images.md)

images.primary.large

Returns large-sized primary image for each item. For more information, refer [Images Resources](./_creatorsapi_docs_en-us_api-reference_resources_images.md)

images.variants.small

Returns small-sized variant images for each item. For more information, refer [Images Resources](./_creatorsapi_docs_en-us_api-reference_resources_images.md)

images.variants.medium

Returns medium-sized variant images for each item. For more information, refer [Images Resources](./_creatorsapi_docs_en-us_api-reference_resources_images.md)

images.variants.large

Returns large-sized variant images for each item. For more information, refer [Images Resources](./_creatorsapi_docs_en-us_api-reference_resources_images.md)

itemInfo.byLineInfo

Returns set of attributes that specifies basic information of the item. For more information, refer [ItemInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

itemInfo.classifications

Returns set of attributes that are used to classify an item into a particular category. For more information, refer [ItemInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

itemInfo.contentInfo

Returns set of attributes that are specific to the content like Books, Movies, etc. For more information, refer [ItemInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

itemInfo.contentRating

Returns set of attributes that specifies what age group is suitable to view said media. For more information, refer [ItemInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

itemInfo.externalIds

Returns set of identifiers that is used globally to identify a particular product. For more information, refer [ItemInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

itemInfo.features

Returns set of attributes that specifies an item's key features. For more information, refer [ItemInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

itemInfo.manufactureInfo

Returns set of attributes that specifies manufacturing related information of an item. For more information, refer [ItemInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

itemInfo.productInfo

Returns set of attributes that describe non-technical aspects of an item. For more information, refer [ItemInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

itemInfo.technicalInfo

Returns set of attributes that describes the technical aspects of the item. For more information, refer [ItemInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

itemInfo.title

Returns the title of the product. For more information, refer [ItemInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

itemInfo.tradeInInfo

Returns set of attributes that specifies trade-in information of an item. For more information, refer [ItemInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

offersV2.listings.availability

Returns maximum number of quantity that can be purchased for a product. For more information, refer to [OffersV2 Resources](./_creatorsapi_docs_en-us_api-reference_resources_offersV2.md)

offersV2.listings.condition

Returns condition of the product. For more information, refer to [OffersV2 Resources](./_creatorsapi_docs_en-us_api-reference_resources_offersV2.md)

offersV2.listings.dealDetails

Returns deal information. For more information, refer to [OffersV2 Resources](./_creatorsapi_docs_en-us_api-reference_resources_offersV2.md)

offersV2.listings.isBuyBoxWinner

Returns whether the given offer for the product is buy box winner on the detail page of the product. For more information, refer to [OffersV2 Resources](./_creatorsapi_docs_en-us_api-reference_resources_offersV2.md)

offersV2.listings.loyaltyPoints

Returns loyalty points related information for an offer (Currently only supported in Japan marketplace). For more information, refer to [OffersV2 Resources](./_creatorsapi_docs_en-us_api-reference_resources_offersV2.md)

offersV2.listings.merchantInfo

Returns seller information for the offer of the product. For more information, refer to [OffersV2 Resources](./_creatorsapi_docs_en-us_api-reference_resources_offersV2.md)

offersV2.listings.price

Returns offer buying price of a product. For more information, refer to [OffersV2 Resources](./_creatorsapi_docs_en-us_api-reference_resources_offersV2.md)

offersV2.listings.type

Returns offer type. For more information, refer to [OffersV2 Resources](./_creatorsapi_docs_en-us_api-reference_resources_offersV2.md)

parentASIN

Returns the parent ASIN for a given item. For more information, refer [ParentASIN Resource](./_creatorsapi_docs_en-us_api-reference_resources_parent-asin.md)

variationSummary.price.highestPrice

Returns the highest price among the child ASINs. For more information, refer [VariationSummary Resource](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary.md)

variationSummary.price.lowestPrice

Returns the lowest price among the child ASINs. For more information, refer [VariationSummary Resource](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary.md)

variationSummary.variationDimension

Returns the details about the dimensions on which the attribute varies. For more information, refer [VariationSummary Resource](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary.md)

## Response Elements

Name

Description

errors

Optional array of error objects for variations that failed validation or lookup. Only present when partial failures occur.

variationsResult

Container for variations result. It contains items container and variationSummary container.

items

Container for item information including ASIN, Title and other attributes depending on resources requested.

variationSummary

Container for variationSummary resource.

## Example Use Cases

### Example 1

Get variations for a parent ASIN.

#### Request Payload

Copy

```
{
 "asin": "B00422MCUS",
 "resources": [
  "itemInfo.title",
  "variationSummary.price.highestPrice",
  "variationSummary.price.lowestPrice",
  "variationSummary.variationDimension"
 ],
 "variationPage": 1,
 "partnerTag": "xyz-20",
 "marketplace": "www.amazon.co.uk",
 "Operation": "GetVariations"
}
```

#### Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B019MNBMS4",
        "detailPageURL": "https://www.amazon.co.uk/dp/B019MNBMS4?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Navy,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Navy"
          }
        ]
      },
      {
        "asin": "B073211XCB",
        "detailPageURL": "https://www.amazon.co.uk/dp/B073211XCB?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger mens Rfid Blocking 100% Leather Passcase Wallet Wallet - Brown -",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Logan - Tan"
          }
        ]
      },
      {
        "asin": "B00422MCW6",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCW6?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Black,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Black"
          }
        ]
      },
      {
        "asin": "B01M2C97VG",
        "detailPageURL": "https://www.amazon.co.uk/dp/B01M2C97VG?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Cognac,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Cognac"
          }
        ]
      },
      {
        "asin": "B00422MCVW",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVW?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Brown,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Brown"
          }
        ]
      },
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Tan,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Tan"
          }
        ]
      },
      {
        "asin": "B01M5J1551",
        "detailPageURL": "https://www.amazon.co.uk/dp/B01M5J1551?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Red,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Red"
          }
        ]
      },
      {
        "asin": "B07321HQRM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B07321HQRM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger mens Ranger Passcase Wallet Wallet - Black -",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Rfid-black"
          }
        ]
      },
      {
        "asin": "B01MG81M6E",
        "detailPageURL": "https://www.amazon.co.uk/dp/B01MG81M6E?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "Value": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Green,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Green"
          }
        ]
      },
      {
        "asin": "B0731XHR2W",
        "detailPageURL": "https://www.amazon.co.uk/dp/B0731XHR2W?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger mens Ranger Passcase Wallet Wallet - Blue -",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Rfid-navy"
          }
        ]
      }
    ],
    "variationSummary": {
      "pageCount": 2,
      "Price": {
        "highestPrice": {
          "amount": 30.87,
          "currency": "GBP",
          "displayAmount": "£30.87"
        },
        "lowestPrice": {
          "amount": 17.03,
          "currency": "GBP",
          "displayAmount": "£17.03"
        }
      },
      "variationCount": 13,
      "variationDimensions": [
        {
          "displayName": "Size",
          "name": "size_name",
          "values": [
            "One Size"
          ]
        },
        {
          "displayName": "Colour",
          "name": "color_name",
          "values": [
            "Brown",
            "Navy",
            "Black",
            "Burgundy",
            "Cognac",
            "Gray",
            "Green",
            "Logan - Tan",
            "Navy/Black",
            "Red",
            "Rfid-black",
            "Rfid-navy",
            "Tan"
          ]
        }
      ]
    }
  }
}
```

### Example 2

Get variations for a child ASIN.

#### Request Payload

Copy

```
{
 "asin": "B01M2C97VG",
 "resources": [
  "itemInfo.title",
  "variationSummary.price.highestPrice",
  "variationSummary.price.lowestPrice",
  "variationSummary.variationDimension"
 ],
 "variationPage": 1,
 "partnerTag": "xyz-20",
 "marketplace": "www.amazon.co.uk",
 "Operation": "GetVariations"
}
```

#### Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B019MNBMS4",
        "detailPageURL": "https://www.amazon.co.uk/dp/B019MNBMS4?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Navy,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Navy"
          }
        ]
      },
      {
        "asin": "B073211XCB",
        "detailPageURL": "https://www.amazon.co.uk/dp/B073211XCB?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger mens Rfid Blocking 100% Leather Passcase Wallet Wallet - Brown -",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Logan - Tan"
          }
        ]
      },
      {
        "asin": "B00422MCW6",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCW6?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Black,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Black"
          }
        ]
      },
      {
        "asin": "B01M2C97VG",
        "detailPageURL": "https://www.amazon.co.uk/dp/B01M2C97VG?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Cognac,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Cognac"
          }
        ]
      },
      {
        "asin": "B00422MCVW",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVW?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Brown,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Brown"
          }
        ]
      },
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Tan,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Tan"
          }
        ]
      },
      {
        "asin": "B01M5J1551",
        "detailPageURL": "https://www.amazon.co.uk/dp/B01M5J1551?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Red,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Red"
          }
        ]
      },
      {
        "asin": "B07321HQRM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B07321HQRM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger mens Ranger Passcase Wallet Wallet - Black -",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Rfid-black"
          }
        ]
      },
      {
        "asin": "B01MG81M6E",
        "detailPageURL": "https://www.amazon.co.uk/dp/B01MG81M6E?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Green,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Green"
          }
        ]
      },
      {
        "asin": "B0731XHR2W",
        "detailPageURL": "https://www.amazon.co.uk/dp/B0731XHR2W?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger mens Ranger Passcase Wallet Wallet - Blue -",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Rfid-navy"
          }
        ]
      }
    ],
    "variationSummary": {
      "pageCount": 2,
      "price": {
        "highestPrice": {
          "amount": 30.87,
          "currency": "GBP",
          "displayAmount": "£30.87"
        },
        "lowestPrice": {
          "amount": 17.03,
          "currency": "GBP",
          "displayAmount": "£17.03"
        }
      },
      "variationCount": 13,
      "variationDimensions": [
        {
          "displayName": "Size",
          "name": "size_name",
          "values": [
            "One Size"
          ]
        },
        {
          "displayName": "Colour",
          "name": "color_name",
          "values": [
            "Brown",
            "Navy",
            "Black",
            "Burgundy",
            "Cognac",
            "Gray",
            "Green",
            "Logan - Tan",
            "Navy/Black",
            "Red",
            "Rfid-black",
            "Rfid-navy",
            "Tan"
          ]
        }
      ]
    }
  }
}
```

### Example 3

Get next set of variations for an ASIN using VariationPage parameter.

#### Request Payload

Copy

```
{
 "asin": "B00422MCUS",
 "resources": [
  "itemInfo.title",
  "variationSummary.price.highestPrice",
  "variationSummary.price.lowestPrice",
  "variationSummary.variationDimension"
 ],
 "variationPage": 2,
 "partnerTag": "xyz-20",
 "marketplace": "www.amazon.co.uk",
 "Operation": "GetVariations"
}
```

#### Response

Copy

```

 "variationsResult": {
  "items": [
   {
    "asin": "B075TFCB3R",
    "detailPageURL": "https://www.amazon.co.uk/dp/B075TFCB3R?tag=xyz-20&linkCode=ogv&th=1&psc=1",
    "itemInfo": {
     "title": {
      "displayValue": "Tommy Hilfiger Men's RFID Blocking 100% Leather Ranger Passcase Wallet Bi-Fold, Navy/Black, One Size",
      "label": "title",
      "locale": "en_GB"
     }
    },
    "variationAttributes": [
     {
      "name": "size_name",
      "value": "One Size"
     },
     {
      "name": "color_name",
      "value": "Navy/Black"
     }
    ]
   },
   {
    "asin": "B0743JLQKT",
    "detailPageURL": "https://www.amazon.co.uk/dp/B0743JLQKT?tag=xyz-20&linkCode=ogv&th=1&psc=1",
    "itemInfo": {
     "title": {
      "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet, Gray",
      "label": "title",
      "locale": "en_GB"
     }
    },
    "variationAttributes": [
     {
      "name": "size_name",
      "value": "One Size"
     },
     {
      "name": "color_name",
      "value": "Gray"
     }
    ]
   },
   {
    "asin": "B0743JL719",
    "detailPageURL": "https://www.amazon.co.uk/dp/B0743JL719?tag=xyz-20&linkCode=ogv&th=1&psc=1",
    "itemInfo": {
     "title": {
      "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet, Burgundy",
      "label": "title",
      "locale": "en_GB"
     }
    },
    "variationAttributes": [
     {
      "name": "size_name",
      "value": "One Size"
     },
     {
      "name": "color_name",
      "value": "Burgundy"
     }
    ]
   }
  ],
  "variationSummary": {
   "pageCount": 2,
   "Price": {
    "highestPrice": {
     "amount": 30.87,
     "currency": "GBP",
     "displayAmount": "£30.87"
    },
    "lowestPrice": {
     "amount": 17.03,
     "currency": "GBP",
     "displayAmount": "£17.03"
    }
   },
   "variationCount": 13,
   "variationDimensions": [
    {
     "displayName": "Size",
     "name": "size_name",
     "values": [
      "One Size"
     ]
    },
    {
     "displayName": "Colour",
     "name": "color_name",
     "Values": [
      "Brown",
      "Navy",
      "Black",
      "Burgundy",
      "Cognac",
      "Gray",
      "Green",
      "Logan - Tan",
      "Navy/Black",
      "Red",
      "Rfid-black",
      "Rfid-navy",
      "Tan"
     ]
    }
   ]
  }
 }
}
```

### Example 4

Get 3 variations for an ASIN using VariationCount parameter.

#### Request Payload

Copy

```
{
 "asin": "B00422MCUS",
 "resources": [
  "itemInfo.title",
  "variationSummary.price.highestPrice",
  "variationSummary.price.lowestPrice",
  "variationSummary.variationDimension"
 ],
 "variationCount": 3,
 "partnerTag": "xyz-20",
 "marketplace": "www.amazon.co.uk",
 "operation": "GetVariations"
}
```

#### Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Tan,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Tan"
          }
        ]
      },
      {
        "asin": "B00422MCW6",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCW6?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Black,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Black"
          }
        ]
      },
      {
        "asin": "B00422MCVW",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVW?tag=xyz-20&linkCode=ogv&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Tommy Hilfiger Men's Ranger Leather Passcase Wallet with Removable Card Holder,Brown,One Size",
            "label": "title",
            "locale": "en_GB"
          }
        },
        "variationAttributes": [
          {
            "name": "size_name",
            "value": "One Size"
          },
          {
            "name": "color_name",
            "value": "Brown"
          }
        ]
      }
    ],
    "variationSummary": {
      "pageCount": 5,
      "price": {
        "highestPrice": {
          "amount": 30.87,
          "currency": "GBP",
          "displayAmount": "£30.87"
        },
        "lowestPrice": {
          "amount": 17.03,
          "currency": "GBP",
          "displayAmount": "£17.03"
        }
      },
      "variationCount": 13,
      "variationDimensions": [
        {
          "displayName": "Size",
          "name": "size_name",
          "values": [
            "One Size"
          ]
        },
        {
          "displayName": "Colour",
          "name": "color_name",
          "values": [
            "Brown",
            "Navy",
            "Black",
            "Burgundy",
            "Cognac",
            "Gray",
            "Green",
            "Logan - Tan",
            "Navy/Black",
            "Red",
            "Rfid-black",
            "Rfid-navy",
            "Tan"
          ]
        }
      ]
    }
  }
}
```
