# GetItems

Source: `_creatorsapi_docs_en-us_api-reference_operations_get-items.html`

# GetItems

## Description

Given an Item identifier, the `GetItems` operation returns some or all of the item attributes, depending on the resources specified in the request.

`GetItems` supports the following high-Level resources:

-   [BrowseNodeInfo](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info.md)
-   [Images](./_creatorsapi_docs_en-us_api-reference_resources_images.md)
-   [ItemInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)
-   [OffersV2](./_creatorsapi_docs_en-us_api-reference_resources_offersV2.md)

To look up more than one item at a time, separate the item identifiers by commas.

## Availability

All locales, however, the parameter support varies by locale.

## Request Parameters

Check [Common Request Headers and Parameters](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.md) for more information on common input parameters. For detailed information on how to create and send a request, refer [Using cURL](./_creatorsapi_docs_en-us_get-started_using-curl.md). All `GetItems` input parameters are listed below:

Name

Description

Required

condition

The condition parameter filters offers by condition type. For example, Condition:New will return items having atleast one offer of New condition type. For more information and valid values, refer Condition Parameter. • Type: String • Default Value: \`Any\` • Usage: \`{"condition":"New"}\`

No

currencyOfPreference

Currency of preference in which the prices information should be returned in response. By default the prices are returned in the default currency of the marketplace. Expected currency code format is the ISO 4217 currency code (i.e. USD, EUR etc.). For information on default currency and valid currencies for a marketplace, refer Locale Reference. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"currencyOfPreference":"USD"}\`

No

itemIdType

Type of item identifier used to look up an item. For more information on valid values, refer ItemIdType Parameter. • Type: String • Default Value: \`ASIN\` • Usage: \`{"itemIdType":"ASIN"}\`

No

itemIds

One or more ItemIds like ASIN that uniquely identify an item. The meaning of the number is specified by ItemIdType. That is, if ItemIdType is ASIN, the ItemId value is an ASIN. • Type: List of Non-Empty Strings (up to 10) • Default Value: None • Usage: \`"itemIds" : \["B0199980K4" , "B000HZD168"\]\`

Yes

languagesOfPreference

Languages in order of preference in which the item information should be returned in response. By default the item information is returned in the default language of the marketplace. Expected locale format is the ISO 639 language code followed by underscore followed by the ISO 3166 country code (i.e. en\_US, fr\_CA etc.). For information on default language and valid languages for a marketplace, refer Locale Reference. Currently only single language of preference is supported. • Type: List of Strings (Non-Empty) • Default Value: None • Usage: \`{"languagesOfPreference":\["en\_ES"\]}\`

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

#### Condition Parameter

Note that, a `GetItems` request with a particular Condition parameter may return 0 offers if there are no offers with the specified condition.

Condition Value

Description

Any

Offer Listings for items across any condition. Includes New and Used.

New

Offer Listings for New items

#### ItemIdType Parameter

ItemIdType Value

Description

ASIN

Amazon Standard Identification Number: 10-Character alphanumeric unique identifier assigned by Amazon. For more details, see [ASIN](https://en.wikipedia.org/wiki/Amazon_Standard_Identification_Number)

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

## Response Elements

Name

Description

errors

Optional array of error objects for items that failed validation or lookup. Only present when some items succeed and others fail.

itemResults

Container for items.

items

List of Item.

item

Container for item information including ASIN, Detail Page URL and other attributes depending on resources requested.

> When requested ItemIds are invalid or inaccessible via the Creators API, they'll show up under the Errors container in the GetItemsResponse. As a result, the order of ItemIds in the response can change. Hence, it is recommended to fetch the requested item's information by checking the ASIN value for the item.

## Examples

The following is the sample json payload for `GetItems` request.

Copy

```
{
        "itemIds": ["B0199980K4","B000HZD168","B01180YUXS","B00BKQTA4A"],
        "itemIdType": "ASIN",
        "languagesOfPreference": ["en_US"],
        "marketplace": "www.amazon.com",
        "partnerTag": "xyz-20",
        "resources": ["images.primary.small","itemInfo.title","itemInfo.features","parentASIN"]
}
```

## Sample Response

The following code snippet is a response to the first request. It shows all of the item attributes that are returned by default.

Copy

```
{
  "errors": [
    {
      "code": "ItemNotAccessible",
      "message": "The ItemId B01180YUXS is not accessible through the Creators API."
    }
  ],
  "itemResults": {
    "items": [
      {
        "asin": "B0199980K4",
        "detailPageURL": "https://www.amazon.com/dp/B0199980K4?tag=xyz-20&linkCode=ogi&language=en_US&th=1&psc=1",
        "images": {
          "primary": {
            "small": {
              "height": 75,
              "url": "https://m.media-amazon.com/images/I/61s4tTAizUL._SL75_.jpg",
              "width": 56
            }
          }
        },
        "itemInfo": {
          "title": {
            "displayValue": "Genghis: The Legend of the Ten",
            "label": "Title",
            "locale": "en_US"
          }
        },
        "parentASIN": "B07QGKM68X"
      },
      {
        "asin": "B00BKQTA4A",
        "detailPageURL": "https://www.amazon.com/dp/B00BKQTA4A?tag=xyz-20&linkCode=ogi&language=en_US&th=1&psc=1",
        "images": {
          "primary": {
            "small": {
              "height": 75,
              "url": "https://m.media-amazon.com/images/I/41OiLOcQVJL._SL75_.jpg",
              "width": 46
            }
          }
        },
        "itemInfo": {
          "features": {
            "displayValues": [
              "Round watch featuring logoed white dial with stick indices",
              "36 mm stainless steel case with mineral dial window",
              "Quartz movement with analog display",
              "Leather calfskin band with buckle closure",
              "Water resistant to 30 m (99 ft): In general, withstands splashes or brief immersion in water, but not suitable for swimming"
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "title": {
            "displayValue": "Daniel Wellington Women's 0608DW Sheffield Stainless Steel Watch",
            "label": "Title",
            "locale": "en_US"
          }
        },
        "parentASIN": "B07L5N7P32"
      },
      {
        "asin": "B000HZD168",
        "detailPageURL": "https://www.amazon.com/dp/B000HZD168?tag=xyz-20&linkCode=ogi&language=en_US&th=1&psc=1",
        "images": {
          "primary": {
            "small": {
              "height": 75,
              "url": "https://m.media-amazon.com/images/I/61ZRPpZoBvL._SL75_.jpg",
              "width": 56
            }
          }
        },
        "itemInfo": {
          "title": {
            "displayValue": "Star Trek II: The Wrath of Khan",
            "label": "Title",
            "locale": "en_US"
          }
        },
        "parentASIN": "B07G9PHJJH"
      }
    ]
  }
}
```
