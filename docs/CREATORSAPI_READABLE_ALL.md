# Creators API Docs (Readable Markdown)

Total files converted: 100

## GetBrowseNodes

Source: `_creatorsapi_docs_en-us_api-reference_operations_get-browse-nodes.html`

# GetBrowseNodes

## Description

Given a BrowseNodeId, `GetBrowseNodes` operation returns the specified browse node’s information like name, children and ancestors depending on the resources specified in the request. The names and browse node IDs of the children and ancestor browse nodes are also returned. GetBrowseNodes enables you to traverse the browse node hierarchy to find a browse node.

GetBrowseNodes Operation returns Id, DisplayName, ContextFreeName and SalesRank response elements by default. For other response elements associated, with GetBrowseNodes supports the following high-level resources:

-   [BrowseNodes](./_creatorsapi_docs_en-us_api-reference_resources_browse-nodes.md)

## Availability

All locales.

## Request Parameters

Check [Common Request Headers and Parameters](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.md) for more information on common input parameters. For detailed information on how to create and send a request, refer [Using cURL](./_creatorsapi_docs_en-us_get-started_using-curl.md). All GetBrowseNodes input parameters are listed below:

Name

Description

Required

browseNodeIds

List of BrowseNodeIds. A BrowseNodeId is a unique ID assigned by Amazon that identifies a product category/sub-category. The BrowseNodeId is a positive Long having max value upto Long.MAX\_VALUE i.e. 9223372036854775807 (inclusive). • Type: List of Strings (Positive Long only) (up to 10) • Default Value: None • Usage: \`{"browseNodeIds": \["3040", "3045"\]\`

Yes

languagesOfPreference

Languages of preference in which the information should be returned in response. By default the information is returned in the default language of the marketplace. Expected locale format is the ISO 639 language code followed by underscore followed by the ISO 3166 country code (i.e. en\_US, fr\_CA etc.). For information on default language and valid languages for a marketplace, refer Locale Reference. Currently only single language of preference is supported. • Type: List of Strings (Non-Empty) • Default Value: None • Usage: \`{"languagesOfPreference":\["en\_US"\]}\`

No

marketplace

Target Amazon Locale. For more information, refer Common Request Headers and Parameters. • Type: String • Default Value: None • Usage: \`{"marketplace":"www.amazon.com"}\`

No

partnerTag

Unique ID for a partner. For more information, refer Common Request Headers and Parameters. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"partnerTag":"xyz-20"}\`

Yes

resources

Specifies the types of values to return. You can specify multiple resources in one request. For list of valid Resources for SearchItems operation, refer Resources Parameter. • Type: List of String • Default Value: \`itemInfo.title\` • Usage: \`{"resources":\["browseNodes.ancestor", "browseNodes.children"\]\`

No

#### Resources Parameter

Resource Value

Description

browseNodes.ancestor

Returns ancestry ladder of the requested BrowseNodeId upto root node i.e. the last Browse Node in the ancestry ladder will be the root node. For more information, refer [BrowseNodes Resources](./_creatorsapi_docs_en-us_api-reference_resources_browse-nodes.md)

browseNodes.children

Returns list of children of the requested BrowseNodeId. For more information, refer [BrowseNodes Resources](./_creatorsapi_docs_en-us_api-reference_resources_browse-nodes.md)

## Response Elements

The following are common response elements returned:

Name

Description

errors

Optional array of error objects for browse nodes that failed validation or lookup. Only present when partial failures occur.

browseNodesResult

The container for GetBrowseNodes response. It consists of resultant BrowseNodes for the GetBrowseNodes request.

browseNodes

Container for BrowseNode information which includes BrowseNodeId, Name, Ancestor, Children, SalesRank associated, etc.

ancestor

Container for BrowseNode Ancestor information which includes BrowseNodeId, DisplayName, ContextFreeName and Ancestor information if one exists. The container is a ladder containing ancestor information up-to root browse node. That is, the last node in the ladder will be Root Node. Note that a root BrowseNode will not have any ancestor.

children

List of BrowseNode Children for a particular BrowseNode. Each BrowseNode Child contains BrowseNodeId, DisplayName and ContextFreeName information associated with the BrowseNode Child. Note that a leaf browse node won't have any children.

contextFreeName

Indicates a displayable name for a BrowseNode that is fully context free. For e.g. _DisplayName_ of `BrowseNodeId: 3060` in US marketplace is _**Orphans & Foster Homes**_. One can not infer which root category this browse node belongs to unless we have the ancestry ladder for this browse node i.e. it requires a "context" for being intuitive. However, the _ContextFreeName_ of this browse node is _**Children's Orphans & Foster Homes Books**_. Note that, for a BrowseNode whose DisplayName is already context free will have the same ContextFreeName as DisplayName.

displayName

The display name of the BrowseNode as visible on the Amazon retail website.

id

Indicates the unique identifier of the BrowseNode

isRoot

Indicates if the current BrowseNode is a root category.

> When requested BrowseNodeIds are invalid, they'll show up under the Errors container in the GetBrowseNodesResponse. As a result, the order of BrowseNodeIds in the response can change. Hence, it is recommended to fetch the requested BrowseNodeId's information by checking the Id value for the BrowseNode.

## Example Use Cases

### Example 1

Get all browse node information for list of valid browse nodes

#### Request Payload

Copy

```
{
   "partnerTag": "xyz-20",
   "browseNodeIds": ["283155", "3040"],
   "resources": ["browseNodes.ancestor", "browseNodes.children"]
}
```

#### Response

Copy

```
{
  "browseNodesResult": {
    "browseNodes": [
      {
        "ancestor": {
          "ancestor": {
            "ancestor": {
              "ancestor": {
                "ancestor": {
                  "contextFreeName": "Books",
                  "displayName": "Books",
                  "id": "283155"
                },
                "contextFreeName": "Subjects",
                "displayName": "Subjects",
                "id": "1000"
              },
              "contextFreeName": "Children's Books",
              "displayName": "Children's Books",
              "id": "4"
            },
            "contextFreeName": "Children's Geography & Cultures Books",
            "displayName": "Geography & Cultures",
            "id": "3344091011"
          },
          "contextFreeName": "Children's Explore the World Books",
          "displayName": "Explore the World",
          "id": "3023"
        },
        "contextFreeName": "Children's Mexico Books",
        "displayName": "Mexico",
        "id": "3040",
        "isRoot": false
      },
      {
        "children": [
          {
            "contextFreeName": "Subjects",
            "displayName": "Subjects",
            "id": "1000"
          },
          {
            "contextFreeName": "Books Featured Categories",
            "displayName": "Books Featured Categories",
            "id": "51546011"
          },
          {
            "contextFreeName": "Specialty Boutique",
            "displayName": "Specialty Boutique",
            "id": "2349030011"
          }
        ],
        "contextFreeName": "Books",
        "displayName": "Books",
        "id": "283155",
        "isRoot": true
      }
    ]
  }
}
```

### Example 2

Example use case when list of `BrowseNodeIds` contains an invalid browse node id.

#### Request Payload

Copy

```
{
   "partnerTag": "xyz-20",
   "browseNodeIds": ["283155", "0"],
   "resources": ["browseNodes.ancestor", "browseNodes.children"]
}
```

#### Response

Copy

```
{
  "browseNodesResult": {
    "browseNodes": [
      {
        "children": [
          {
            "contextFreeName": "Subjects",
            "displayName": "Subjects",
            "id": "1000"
          },
          {
            "contextFreeName": "Books Featured Categories",
            "displayName": "Books Featured Categories",
            "id": "51546011"
          },
          {
            "contextFreeName": "Specialty Boutique",
            "displayName": "Specialty Boutique",
            "id": "2349030011"
          }
        ],
        "contextFreeName": "Books",
        "displayName": "Books",
        "id": "283155",
        "isRoot": true
      }
    ]
  },
  "errors": [
    {
      "code": "InvalidParameterValue",
      "message": "The BrowseNodeId 0 provided in the request is invalid."
    }
  ]
}
```

## GetItems

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

## GetVariations

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

## SearchItems

Source: `_creatorsapi_docs_en-us_api-reference_operations_search-items.html`

# SearchItems

## Description

The `SearchItems` operation searches for items on Amazon based on a search query. The Amazon Creators API returns up to ten items per search request.

A `SearchItems` request requires a search category, which, if not specified, defaults to `"All"` and value for at least one of `Keywords`, `Actor`, `Artist`, `Author`, `Brand` or `Title` for searching items on Amazon.

SearchItems supports the following high-level resources:

-   [BrowseNodeInfo](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info.md)
-   [Images](./_creatorsapi_docs_en-us_api-reference_resources_images.md)
-   [ItemInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)
-   [OffersV2](./_creatorsapi_docs_en-us_api-reference_resources_offersV2.md)
-   [searchRefinements](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements.md)

## Availability

All locales, however, the parameter support varies by locale.

## API Features and Best Practices

You can refine SearchItems request to return the results you want. Try different parameter combinations to customize search results. Moreover, the API helps you refine search requests by giving out dynamic search refinements for every search request you make. These dynamic refinements are available as part of [searchRefinements](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements.md) resource.

-   You can search by `Keywords`, `Actor`, `Artist`, `Author`, `Brand` or `Title` in any category. However, note that it is mandatory to provide at least one of the above mentioned parameters.
-   `SearchItems` API supports many [request parameters](./_creatorsapi_docs_en-us_api-reference_operations_search-items#request-parameters.md), most of them help in refining search results. For example, use `Brand` to refine your search results to return products for a specific brand or use `MinPrice` to return results having at least one offer price greater than the minimum price specified. However, not all parameters are relevant to all search indices. For example, if you specify the `Actor`, you would not use the Automotive search index.
-   Use the `SortBy` parameter to return results in a specific order. For example `Price:HighToLow` sorts the result from most expensive to least expensive.
-   By default, the API searches for products in `"All"` SearchIndex if not specified. However, use a specific SearchIndex or BrowseNodeId to limit search results by a category or BrowseNode. For a complete list of SearchIndices for a locale, refer [Local Reference for Creators API](./_creatorsapi_docs_en-us_locale-reference.md).

## Request Parameters {#ItemLookup-rp}

Check [Common Request Headers and Parameters](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.md) for more information on common input parameters. For detailed information on how to create and send a request, refer [Using cURL](./_creatorsapi_docs_en-us_get-started_using-curl.md). All SearchItems input parameters are listed below:

Name

Description

Required

actor

Actor name associated with the item. You can enter all or part of the name. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"actor": "Tom Cruise"}\`

No

artist

Artist name associated with the item. You can enter all or part of the name. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"artist":"Coldplay"}\`

No

author

Author name associated with the item. You can enter all or part of the name. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"author":"Enid Blyton"}\`

No

availability

Filters available items on Amazon. By default, all requests returns available items only. For more information and valid values, refer Availability Parameter. • Type: String • Default Value: \`Available\` • Usage: \`{"availability":"IncludeOutOfStock"}\`

No

brand

Brand name associated with the item. You can enter all or part of the name. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"brand":"Apple"}\`

No

browseNodeId

A unique ID assigned by Amazon that identifies a product category/sub-category. The BrowseNodeId is a positive Long having max value upto Long.MAX\_VALUE i.e. 9223372036854775807 (inclusive). • Type: String (Positive integers only) • Default Value: None • Usage: \`{"browseNodeId": "290060"}\`

No

condition

The condition parameter filters offers by condition type. For example, Condition:New will return items having atleast one offer of New condition type. By default, condition equals Any. For more information and valid values, refer Condition Parameter. • Type: String • Default Value: \`Any\` • Usage: \`{"condition":"New"}\`

No

currencyOfPreference

Currency of preference in which the prices information should be returned in response. By default the prices are returned in the default currency of the marketplace. Expected currency code format is the ISO 4217 currency code (i.e. USD, EUR etc.). For information on default currency and valid currencies for a marketplace, refer Locale Reference. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"currencyOfPreference":"USD"}\`

No

deliveryFlags

The delivery flag filters items which satisfy a certain delivery program promoted by the specific Amazon Marketplace. For example, Prime DeliveryFlag will return items having at least one offer which is Prime Eligible. For more information and valid values, refer DeliveryFlags Parameter. • Type: List of Strings • Default Value: None • Usage: \`{"deliveryFlags":\["Prime"\]}\`

No

itemCount

The number of items desired in SearchItems response. • Type: Integer (Between 1 to 10) • Default Value: \`10\` • Usage: \`{"itemCount":5}\`

No

itemPage

The ItemPage parameter can be used to fetch the specific set/page of items to be returned from the available Search Results. The number of items returned in a page is determined by the ItemCount parameter. For e.g. if the third set of 5 items (i.e. items numbered 11 to 15) are desired for a search request, you may specify ItemPage as 3 and ItemCount as 5. • Type: Integer (Between 1 to 10) • Default Value: \`1\` • Usage: \`{"itemPage":3}\`

No

keywords

A word or phrase that describes an item i.e. the search query. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"keywords":"Harry Potter"}\`

No

languagesOfPreference

Languages in order of preference in which the item information should be returned in response. By default the item information is returned in the default language of the marketplace. Expected locale format is the ISO 639 language code followed by underscore followed by the ISO 3166 country code (i.e. en\_US, fr\_CA etc.). For information on default language and valid languages for a marketplace, refer Locale Reference. Currently only single language of preference is supported. • Type: List of Strings (Non-Empty) • Default Value: None • Usage: \`{"languagesOfPreference":\["en\_GB"\]}\`

No

marketplace

Target Amazon Locale. For more information, refer Common Request Headers and Parameters. • Type: String • Default Value: None • Usage: \`{"marketplace":"www.amazon.com"}\`

No

maxPrice

Filters search results to items with at least one offer price below the specified value. Prices appear in lowest currency denomination. For example, in US marketplace, 3241 is $31.41. • Type: Positive Integer • Default Value: None • Usage: \`{"maxPrice":3241}\`

No

minPrice

Filters search results to items with at least one offer price above the specified value. Prices appear in lowest currency denomination. For example, in US marketplace, 3241 is $32.41. • Type: Positive Integer • Default Value: None • Usage: \`{"minPrice":3241}\`

No

minReviewsRating

Filters search results to items with customer review ratings above specified value. • Type: Positive Integer less than 5 • Default Value: None • Usage: \`{"minReviewsRating":2}\`

No

minSavingPercent

Filters search results to items with at least one offer having saving percentage above the specified value. • Type: Positive Integer less than 100 • Default Value: None • Usage: \`{"minSavingPercent":50}\`

No

partnerTag

Unique ID for a partner. For more information, refer Common Request Headers and Parameters. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"partnerTag":"xyz-20"}\`

Yes

properties

Reserved Parameter. • Type: Map (String, String) • Default Value: None • Usage: \`{"properties": {"Key": "Value"} }\`

No

resources

Specifies the types of values to return. You can specify multiple resources in one request. For list of valid Resources for SearchItems operation, refer Resources Parameter. • Type: List of String • Default Value: \`itemInfo.title\` • Usage: \`{"resources":\["images.primary.medium", "itemInfo.title"\]}\`

No

searchIndex

Indicates the product category to search. SearchIndex values differ by marketplace. For list of search index values, refer Locale Reference. • Type: String (Non-Empty) • Default Value: \`All\` • Usage: \`{"searchIndex":"Electronics"}\`

No

sortBy

The way in which items in the response are sorted. For more information on valid values, refer SortBy Parameter. • Type: String • Default Value: None • Usage: \`{"sortBy":"Relevance"}\`

No

title

Title associated with the item. Title searches are subset of Keywords searches. Use a Keywords search if a Title search does not return desired items. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"title":"And Then There Were None"}\`

No

#### Availability Parameter

Availability Value

Description

Available

Only available items

IncludeOutOfStock

Include Out of Stock items

#### Condition Parameter

Note that, a search request with a particular `Condition` parameter may return 0 results if there are no offers with the specified condition in the search results.

Condition Value

Description

Any

Offer Listings for items across any condition. Includes New and Used.

New

Offer Listings for New items

#### DeliveryFlags Parameter

Note that a search request with a particular `DeliveryFlag` may result into 0 items if any of the specified Delivery Program is not supported in the target Amazon marketplace.

DeliveryFlag Value

Description

AmazonGlobal

A delivery program featuring international shipping to certain Exportable Countries

FreeShipping

A delivery program featuring free shipping of an item

FulfilledByAmazon

Fulfilled by Amazon indicates that products are stored, packed and dispatched by Amazon

Prime

An offer for an item which is eligible for Prime Program

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

Returns set of attributes that specifies an item's key features and benefits. For more information, refer [ItemInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

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

ParentASIN

Returns the parent ASIN for a given item. For more information, refer [ParentASIN Resource](./_creatorsapi_docs_en-us_api-reference_resources_parent-asin.md)

searchRefinements

Returns dynamic search refinements for each search request. For more information, refer [searchRefinements Resource](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements.md)

#### SortBy Parameter

Note that, if no `SortBy` parameter is provided in the search request, the results are sorted in default sort option for the `Marketplace` and `SearchIndex` combination. A particular `SortBy` parameter provided in the search request will fall back to the default sort option for the category if it is not supported in that category.

SortBy Value

Description

AvgCustomerReviews

Sorts results according to average customer reviews

Featured

Sorts results with featured items having higher rank

NewestArrivals

Sorts results with according to newest arrivals

Price:HighToLow

Sorts results according to most expensive to least expensive

Price:LowToHigh

Sorts results according to least expensive to most expensive

Relevance

Sorts results with relevant items having higher rank

## Response Elements

The following are common response elements returned:

Name

Description

errors

Optional array of error objects for items or query parameters that encountered issues. Only present when partial failures occur.

searchResult

Container for search result. It contains items container, totalResultCount, searchURL and searchRefinements container.

items

Container for item information including ASIN, Title and other attributes depending on resources requested.

totalResultCount

The total number of items that match the search query.

searchURL

URL to link back to search results page on Amazon for the search request.

searchRefinements

Container for searchRefinements resource if requested.

## Example Requests

-   General keyword search request:

Copy

```
{
   "partnerTag": "xyz-20",
   "keywords": "harry potter"
}
```

-   General keyword search using `ItemCount` and `Resources` parameter:

Copy

```
{
   "partnerTag": "xyz-20",
   "keywords": "harry potter",
   "itemCount": 1,
   "resources": ["images.primary.medium", "itemInfo.title", "offersV2.listings.price"]
}
```

-   Search by Actor:

Copy

```
{
   "partnerTag": "xyz-20",
   "actor": "Tom Cruise",
   "resources": ["images.primary.medium", "itemInfo.title", "offersV2.listings.price"]
}
```

-   Search inside a category with some filters applied:

Copy

```
{
   "partnerTag": "xyz-20",
   "searchIndex": "Electronics",
   "keywords": "DSLR Camera",
   "brand": "Sony",
   "minReviewsRating": "4",
   "resources": ["images.primary.medium", "itemInfo.title", "offersV2.listings.price"]
}
```

## Sample Response

-   The following snippet is a sample response for any `SearchItems` request:

Copy

```
{ 
 "searchResult": {
  "items": [
   {
    "asin": "0545162076",
    "detailPageURL": "https://www.amazon.com/dp/0545162076?tag=dgfd&linkCode=osi",
    "images": {
       /* Container for Images Resources if requested*/
    },
    "itemInfo": {
       /* Container for ItemInfo Resources if requested */
    },
    "offers": {
       /* Container for Offers Resources if requested */
    },
    {
       /* More items */
    }
   }
  ],
  "searchRefinements": {
      /* Container for searchRefinements Resources if requested */
  }
  "searchURL": "https://www.amazon.com/s/?field-keywords=Harry+Potter&search-alias=aps&tag=dgfd&linkCode=osi",
  "totalResultCount": 146
 }
}
```

-   The following snippet is a sample response for the second SearchItems request in the [Example Requests](./_creatorsapi_docs_en-us_api-reference_operations_search-items#example-requests.md) section above:

Copy

```
{
 "searchResult": {
  "items": [
   {
    "asin": "0545162076",
    "detailPageURL": "https://www.amazon.com/dp/0545162076?tag=dgfd&linkCode=osi",
    "images": {
     "primary": {
      "medium": {
       "height": 134,
       "url": "https://m.media-amazon.com/images/I/51BBTJaU6QL._SL160_.jpg",
       "width": 160
      }
     }
    },
    "itemInfo": {
     "title": {
      "displayValue": "Harry Potter Paperback Box Set (Books 1-7)",
      "label": "title",
      "locale": "en_US"
     }
    },
     "offersV2": {
       "listings": [{
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
       }]
     }
   }
  ],
  "searchURL": "https://www.amazon.com/s/?field-keywords=Harry+Potter&search-alias=aps&tag=dgfd&linkCode=osi",
  "totalResultCount": 146
 }
}
```

## SearchItems

Source: `_creatorsapi_docs_en-us_api-reference_operations_search-items#example-requests.html`

# SearchItems

## Description

The `SearchItems` operation searches for items on Amazon based on a search query. The Amazon Creators API returns up to ten items per search request.

A `SearchItems` request requires a search category, which, if not specified, defaults to `"All"` and value for at least one of `Keywords`, `Actor`, `Artist`, `Author`, `Brand` or `Title` for searching items on Amazon.

SearchItems supports the following high-level resources:

-   [BrowseNodeInfo](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info.md)
-   [Images](./_creatorsapi_docs_en-us_api-reference_resources_images.md)
-   [ItemInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)
-   [OffersV2](./_creatorsapi_docs_en-us_api-reference_resources_offersV2.md)
-   [searchRefinements](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements.md)

## Availability

All locales, however, the parameter support varies by locale.

## API Features and Best Practices

You can refine SearchItems request to return the results you want. Try different parameter combinations to customize search results. Moreover, the API helps you refine search requests by giving out dynamic search refinements for every search request you make. These dynamic refinements are available as part of [searchRefinements](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements.md) resource.

-   You can search by `Keywords`, `Actor`, `Artist`, `Author`, `Brand` or `Title` in any category. However, note that it is mandatory to provide at least one of the above mentioned parameters.
-   `SearchItems` API supports many [request parameters](./_creatorsapi_docs_en-us_api-reference_operations_search-items#request-parameters.md), most of them help in refining search results. For example, use `Brand` to refine your search results to return products for a specific brand or use `MinPrice` to return results having at least one offer price greater than the minimum price specified. However, not all parameters are relevant to all search indices. For example, if you specify the `Actor`, you would not use the Automotive search index.
-   Use the `SortBy` parameter to return results in a specific order. For example `Price:HighToLow` sorts the result from most expensive to least expensive.
-   By default, the API searches for products in `"All"` SearchIndex if not specified. However, use a specific SearchIndex or BrowseNodeId to limit search results by a category or BrowseNode. For a complete list of SearchIndices for a locale, refer [Local Reference for Creators API](./_creatorsapi_docs_en-us_locale-reference.md).

## Request Parameters {#ItemLookup-rp}

Check [Common Request Headers and Parameters](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.md) for more information on common input parameters. For detailed information on how to create and send a request, refer [Using cURL](./_creatorsapi_docs_en-us_get-started_using-curl.md). All SearchItems input parameters are listed below:

Name

Description

Required

actor

Actor name associated with the item. You can enter all or part of the name. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"actor": "Tom Cruise"}\`

No

artist

Artist name associated with the item. You can enter all or part of the name. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"artist":"Coldplay"}\`

No

author

Author name associated with the item. You can enter all or part of the name. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"author":"Enid Blyton"}\`

No

availability

Filters available items on Amazon. By default, all requests returns available items only. For more information and valid values, refer Availability Parameter. • Type: String • Default Value: \`Available\` • Usage: \`{"availability":"IncludeOutOfStock"}\`

No

brand

Brand name associated with the item. You can enter all or part of the name. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"brand":"Apple"}\`

No

browseNodeId

A unique ID assigned by Amazon that identifies a product category/sub-category. The BrowseNodeId is a positive Long having max value upto Long.MAX\_VALUE i.e. 9223372036854775807 (inclusive). • Type: String (Positive integers only) • Default Value: None • Usage: \`{"browseNodeId": "290060"}\`

No

condition

The condition parameter filters offers by condition type. For example, Condition:New will return items having atleast one offer of New condition type. By default, condition equals Any. For more information and valid values, refer Condition Parameter. • Type: String • Default Value: \`Any\` • Usage: \`{"condition":"New"}\`

No

currencyOfPreference

Currency of preference in which the prices information should be returned in response. By default the prices are returned in the default currency of the marketplace. Expected currency code format is the ISO 4217 currency code (i.e. USD, EUR etc.). For information on default currency and valid currencies for a marketplace, refer Locale Reference. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"currencyOfPreference":"USD"}\`

No

deliveryFlags

The delivery flag filters items which satisfy a certain delivery program promoted by the specific Amazon Marketplace. For example, Prime DeliveryFlag will return items having at least one offer which is Prime Eligible. For more information and valid values, refer DeliveryFlags Parameter. • Type: List of Strings • Default Value: None • Usage: \`{"deliveryFlags":\["Prime"\]}\`

No

itemCount

The number of items desired in SearchItems response. • Type: Integer (Between 1 to 10) • Default Value: \`10\` • Usage: \`{"itemCount":5}\`

No

itemPage

The ItemPage parameter can be used to fetch the specific set/page of items to be returned from the available Search Results. The number of items returned in a page is determined by the ItemCount parameter. For e.g. if the third set of 5 items (i.e. items numbered 11 to 15) are desired for a search request, you may specify ItemPage as 3 and ItemCount as 5. • Type: Integer (Between 1 to 10) • Default Value: \`1\` • Usage: \`{"itemPage":3}\`

No

keywords

A word or phrase that describes an item i.e. the search query. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"keywords":"Harry Potter"}\`

No

languagesOfPreference

Languages in order of preference in which the item information should be returned in response. By default the item information is returned in the default language of the marketplace. Expected locale format is the ISO 639 language code followed by underscore followed by the ISO 3166 country code (i.e. en\_US, fr\_CA etc.). For information on default language and valid languages for a marketplace, refer Locale Reference. Currently only single language of preference is supported. • Type: List of Strings (Non-Empty) • Default Value: None • Usage: \`{"languagesOfPreference":\["en\_GB"\]}\`

No

marketplace

Target Amazon Locale. For more information, refer Common Request Headers and Parameters. • Type: String • Default Value: None • Usage: \`{"marketplace":"www.amazon.com"}\`

No

maxPrice

Filters search results to items with at least one offer price below the specified value. Prices appear in lowest currency denomination. For example, in US marketplace, 3241 is $31.41. • Type: Positive Integer • Default Value: None • Usage: \`{"maxPrice":3241}\`

No

minPrice

Filters search results to items with at least one offer price above the specified value. Prices appear in lowest currency denomination. For example, in US marketplace, 3241 is $32.41. • Type: Positive Integer • Default Value: None • Usage: \`{"minPrice":3241}\`

No

minReviewsRating

Filters search results to items with customer review ratings above specified value. • Type: Positive Integer less than 5 • Default Value: None • Usage: \`{"minReviewsRating":2}\`

No

minSavingPercent

Filters search results to items with at least one offer having saving percentage above the specified value. • Type: Positive Integer less than 100 • Default Value: None • Usage: \`{"minSavingPercent":50}\`

No

partnerTag

Unique ID for a partner. For more information, refer Common Request Headers and Parameters. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"partnerTag":"xyz-20"}\`

Yes

properties

Reserved Parameter. • Type: Map (String, String) • Default Value: None • Usage: \`{"properties": {"Key": "Value"} }\`

No

resources

Specifies the types of values to return. You can specify multiple resources in one request. For list of valid Resources for SearchItems operation, refer Resources Parameter. • Type: List of String • Default Value: \`itemInfo.title\` • Usage: \`{"resources":\["images.primary.medium", "itemInfo.title"\]}\`

No

searchIndex

Indicates the product category to search. SearchIndex values differ by marketplace. For list of search index values, refer Locale Reference. • Type: String (Non-Empty) • Default Value: \`All\` • Usage: \`{"searchIndex":"Electronics"}\`

No

sortBy

The way in which items in the response are sorted. For more information on valid values, refer SortBy Parameter. • Type: String • Default Value: None • Usage: \`{"sortBy":"Relevance"}\`

No

title

Title associated with the item. Title searches are subset of Keywords searches. Use a Keywords search if a Title search does not return desired items. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"title":"And Then There Were None"}\`

No

#### Availability Parameter

Availability Value

Description

Available

Only available items

IncludeOutOfStock

Include Out of Stock items

#### Condition Parameter

Note that, a search request with a particular `Condition` parameter may return 0 results if there are no offers with the specified condition in the search results.

Condition Value

Description

Any

Offer Listings for items across any condition. Includes New and Used.

New

Offer Listings for New items

#### DeliveryFlags Parameter

Note that a search request with a particular `DeliveryFlag` may result into 0 items if any of the specified Delivery Program is not supported in the target Amazon marketplace.

DeliveryFlag Value

Description

AmazonGlobal

A delivery program featuring international shipping to certain Exportable Countries

FreeShipping

A delivery program featuring free shipping of an item

FulfilledByAmazon

Fulfilled by Amazon indicates that products are stored, packed and dispatched by Amazon

Prime

An offer for an item which is eligible for Prime Program

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

Returns set of attributes that specifies an item's key features and benefits. For more information, refer [ItemInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

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

ParentASIN

Returns the parent ASIN for a given item. For more information, refer [ParentASIN Resource](./_creatorsapi_docs_en-us_api-reference_resources_parent-asin.md)

searchRefinements

Returns dynamic search refinements for each search request. For more information, refer [searchRefinements Resource](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements.md)

#### SortBy Parameter

Note that, if no `SortBy` parameter is provided in the search request, the results are sorted in default sort option for the `Marketplace` and `SearchIndex` combination. A particular `SortBy` parameter provided in the search request will fall back to the default sort option for the category if it is not supported in that category.

SortBy Value

Description

AvgCustomerReviews

Sorts results according to average customer reviews

Featured

Sorts results with featured items having higher rank

NewestArrivals

Sorts results with according to newest arrivals

Price:HighToLow

Sorts results according to most expensive to least expensive

Price:LowToHigh

Sorts results according to least expensive to most expensive

Relevance

Sorts results with relevant items having higher rank

## Response Elements

The following are common response elements returned:

Name

Description

errors

Optional array of error objects for items or query parameters that encountered issues. Only present when partial failures occur.

searchResult

Container for search result. It contains items container, totalResultCount, searchURL and searchRefinements container.

items

Container for item information including ASIN, Title and other attributes depending on resources requested.

totalResultCount

The total number of items that match the search query.

searchURL

URL to link back to search results page on Amazon for the search request.

searchRefinements

Container for searchRefinements resource if requested.

## Example Requests

-   General keyword search request:

Copy

```
{
   "partnerTag": "xyz-20",
   "keywords": "harry potter"
}
```

-   General keyword search using `ItemCount` and `Resources` parameter:

Copy

```
{
   "partnerTag": "xyz-20",
   "keywords": "harry potter",
   "itemCount": 1,
   "resources": ["images.primary.medium", "itemInfo.title", "offersV2.listings.price"]
}
```

-   Search by Actor:

Copy

```
{
   "partnerTag": "xyz-20",
   "actor": "Tom Cruise",
   "resources": ["images.primary.medium", "itemInfo.title", "offersV2.listings.price"]
}
```

-   Search inside a category with some filters applied:

Copy

```
{
   "partnerTag": "xyz-20",
   "searchIndex": "Electronics",
   "keywords": "DSLR Camera",
   "brand": "Sony",
   "minReviewsRating": "4",
   "resources": ["images.primary.medium", "itemInfo.title", "offersV2.listings.price"]
}
```

## Sample Response

-   The following snippet is a sample response for any `SearchItems` request:

Copy

```
{ 
 "searchResult": {
  "items": [
   {
    "asin": "0545162076",
    "detailPageURL": "https://www.amazon.com/dp/0545162076?tag=dgfd&linkCode=osi",
    "images": {
       /* Container for Images Resources if requested*/
    },
    "itemInfo": {
       /* Container for ItemInfo Resources if requested */
    },
    "offers": {
       /* Container for Offers Resources if requested */
    },
    {
       /* More items */
    }
   }
  ],
  "searchRefinements": {
      /* Container for searchRefinements Resources if requested */
  }
  "searchURL": "https://www.amazon.com/s/?field-keywords=Harry+Potter&search-alias=aps&tag=dgfd&linkCode=osi",
  "totalResultCount": 146
 }
}
```

-   The following snippet is a sample response for the second SearchItems request in the [Example Requests](./_creatorsapi_docs_en-us_api-reference_operations_search-items#example-requests.md) section above:

Copy

```
{
 "searchResult": {
  "items": [
   {
    "asin": "0545162076",
    "detailPageURL": "https://www.amazon.com/dp/0545162076?tag=dgfd&linkCode=osi",
    "images": {
     "primary": {
      "medium": {
       "height": 134,
       "url": "https://m.media-amazon.com/images/I/51BBTJaU6QL._SL160_.jpg",
       "width": 160
      }
     }
    },
    "itemInfo": {
     "title": {
      "displayValue": "Harry Potter Paperback Box Set (Books 1-7)",
      "label": "title",
      "locale": "en_US"
     }
    },
     "offersV2": {
       "listings": [{
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
       }]
     }
   }
  ],
  "searchURL": "https://www.amazon.com/s/?field-keywords=Harry+Potter&search-alias=aps&tag=dgfd&linkCode=osi",
  "totalResultCount": 146
 }
}
```

## SearchItems

Source: `_creatorsapi_docs_en-us_api-reference_operations_search-items#request-parameters.html`

# SearchItems

## Description

The `SearchItems` operation searches for items on Amazon based on a search query. The Amazon Creators API returns up to ten items per search request.

A `SearchItems` request requires a search category, which, if not specified, defaults to `"All"` and value for at least one of `Keywords`, `Actor`, `Artist`, `Author`, `Brand` or `Title` for searching items on Amazon.

SearchItems supports the following high-level resources:

-   [BrowseNodeInfo](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info.md)
-   [Images](./_creatorsapi_docs_en-us_api-reference_resources_images.md)
-   [ItemInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)
-   [OffersV2](./_creatorsapi_docs_en-us_api-reference_resources_offersV2.md)
-   [searchRefinements](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements.md)

## Availability

All locales, however, the parameter support varies by locale.

## API Features and Best Practices

You can refine SearchItems request to return the results you want. Try different parameter combinations to customize search results. Moreover, the API helps you refine search requests by giving out dynamic search refinements for every search request you make. These dynamic refinements are available as part of [searchRefinements](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements.md) resource.

-   You can search by `Keywords`, `Actor`, `Artist`, `Author`, `Brand` or `Title` in any category. However, note that it is mandatory to provide at least one of the above mentioned parameters.
-   `SearchItems` API supports many [request parameters](./_creatorsapi_docs_en-us_api-reference_operations_search-items#request-parameters.md), most of them help in refining search results. For example, use `Brand` to refine your search results to return products for a specific brand or use `MinPrice` to return results having at least one offer price greater than the minimum price specified. However, not all parameters are relevant to all search indices. For example, if you specify the `Actor`, you would not use the Automotive search index.
-   Use the `SortBy` parameter to return results in a specific order. For example `Price:HighToLow` sorts the result from most expensive to least expensive.
-   By default, the API searches for products in `"All"` SearchIndex if not specified. However, use a specific SearchIndex or BrowseNodeId to limit search results by a category or BrowseNode. For a complete list of SearchIndices for a locale, refer [Local Reference for Creators API](./_creatorsapi_docs_en-us_locale-reference.md).

## Request Parameters {#ItemLookup-rp}

Check [Common Request Headers and Parameters](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.md) for more information on common input parameters. For detailed information on how to create and send a request, refer [Using cURL](./_creatorsapi_docs_en-us_get-started_using-curl.md). All SearchItems input parameters are listed below:

Name

Description

Required

actor

Actor name associated with the item. You can enter all or part of the name. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"actor": "Tom Cruise"}\`

No

artist

Artist name associated with the item. You can enter all or part of the name. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"artist":"Coldplay"}\`

No

author

Author name associated with the item. You can enter all or part of the name. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"author":"Enid Blyton"}\`

No

availability

Filters available items on Amazon. By default, all requests returns available items only. For more information and valid values, refer Availability Parameter. • Type: String • Default Value: \`Available\` • Usage: \`{"availability":"IncludeOutOfStock"}\`

No

brand

Brand name associated with the item. You can enter all or part of the name. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"brand":"Apple"}\`

No

browseNodeId

A unique ID assigned by Amazon that identifies a product category/sub-category. The BrowseNodeId is a positive Long having max value upto Long.MAX\_VALUE i.e. 9223372036854775807 (inclusive). • Type: String (Positive integers only) • Default Value: None • Usage: \`{"browseNodeId": "290060"}\`

No

condition

The condition parameter filters offers by condition type. For example, Condition:New will return items having atleast one offer of New condition type. By default, condition equals Any. For more information and valid values, refer Condition Parameter. • Type: String • Default Value: \`Any\` • Usage: \`{"condition":"New"}\`

No

currencyOfPreference

Currency of preference in which the prices information should be returned in response. By default the prices are returned in the default currency of the marketplace. Expected currency code format is the ISO 4217 currency code (i.e. USD, EUR etc.). For information on default currency and valid currencies for a marketplace, refer Locale Reference. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"currencyOfPreference":"USD"}\`

No

deliveryFlags

The delivery flag filters items which satisfy a certain delivery program promoted by the specific Amazon Marketplace. For example, Prime DeliveryFlag will return items having at least one offer which is Prime Eligible. For more information and valid values, refer DeliveryFlags Parameter. • Type: List of Strings • Default Value: None • Usage: \`{"deliveryFlags":\["Prime"\]}\`

No

itemCount

The number of items desired in SearchItems response. • Type: Integer (Between 1 to 10) • Default Value: \`10\` • Usage: \`{"itemCount":5}\`

No

itemPage

The ItemPage parameter can be used to fetch the specific set/page of items to be returned from the available Search Results. The number of items returned in a page is determined by the ItemCount parameter. For e.g. if the third set of 5 items (i.e. items numbered 11 to 15) are desired for a search request, you may specify ItemPage as 3 and ItemCount as 5. • Type: Integer (Between 1 to 10) • Default Value: \`1\` • Usage: \`{"itemPage":3}\`

No

keywords

A word or phrase that describes an item i.e. the search query. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"keywords":"Harry Potter"}\`

No

languagesOfPreference

Languages in order of preference in which the item information should be returned in response. By default the item information is returned in the default language of the marketplace. Expected locale format is the ISO 639 language code followed by underscore followed by the ISO 3166 country code (i.e. en\_US, fr\_CA etc.). For information on default language and valid languages for a marketplace, refer Locale Reference. Currently only single language of preference is supported. • Type: List of Strings (Non-Empty) • Default Value: None • Usage: \`{"languagesOfPreference":\["en\_GB"\]}\`

No

marketplace

Target Amazon Locale. For more information, refer Common Request Headers and Parameters. • Type: String • Default Value: None • Usage: \`{"marketplace":"www.amazon.com"}\`

No

maxPrice

Filters search results to items with at least one offer price below the specified value. Prices appear in lowest currency denomination. For example, in US marketplace, 3241 is $31.41. • Type: Positive Integer • Default Value: None • Usage: \`{"maxPrice":3241}\`

No

minPrice

Filters search results to items with at least one offer price above the specified value. Prices appear in lowest currency denomination. For example, in US marketplace, 3241 is $32.41. • Type: Positive Integer • Default Value: None • Usage: \`{"minPrice":3241}\`

No

minReviewsRating

Filters search results to items with customer review ratings above specified value. • Type: Positive Integer less than 5 • Default Value: None • Usage: \`{"minReviewsRating":2}\`

No

minSavingPercent

Filters search results to items with at least one offer having saving percentage above the specified value. • Type: Positive Integer less than 100 • Default Value: None • Usage: \`{"minSavingPercent":50}\`

No

partnerTag

Unique ID for a partner. For more information, refer Common Request Headers and Parameters. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"partnerTag":"xyz-20"}\`

Yes

properties

Reserved Parameter. • Type: Map (String, String) • Default Value: None • Usage: \`{"properties": {"Key": "Value"} }\`

No

resources

Specifies the types of values to return. You can specify multiple resources in one request. For list of valid Resources for SearchItems operation, refer Resources Parameter. • Type: List of String • Default Value: \`itemInfo.title\` • Usage: \`{"resources":\["images.primary.medium", "itemInfo.title"\]}\`

No

searchIndex

Indicates the product category to search. SearchIndex values differ by marketplace. For list of search index values, refer Locale Reference. • Type: String (Non-Empty) • Default Value: \`All\` • Usage: \`{"searchIndex":"Electronics"}\`

No

sortBy

The way in which items in the response are sorted. For more information on valid values, refer SortBy Parameter. • Type: String • Default Value: None • Usage: \`{"sortBy":"Relevance"}\`

No

title

Title associated with the item. Title searches are subset of Keywords searches. Use a Keywords search if a Title search does not return desired items. • Type: String (Non-Empty) • Default Value: None • Usage: \`{"title":"And Then There Were None"}\`

No

#### Availability Parameter

Availability Value

Description

Available

Only available items

IncludeOutOfStock

Include Out of Stock items

#### Condition Parameter

Note that, a search request with a particular `Condition` parameter may return 0 results if there are no offers with the specified condition in the search results.

Condition Value

Description

Any

Offer Listings for items across any condition. Includes New and Used.

New

Offer Listings for New items

#### DeliveryFlags Parameter

Note that a search request with a particular `DeliveryFlag` may result into 0 items if any of the specified Delivery Program is not supported in the target Amazon marketplace.

DeliveryFlag Value

Description

AmazonGlobal

A delivery program featuring international shipping to certain Exportable Countries

FreeShipping

A delivery program featuring free shipping of an item

FulfilledByAmazon

Fulfilled by Amazon indicates that products are stored, packed and dispatched by Amazon

Prime

An offer for an item which is eligible for Prime Program

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

Returns set of attributes that specifies an item's key features and benefits. For more information, refer [ItemInfo Resources](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

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

ParentASIN

Returns the parent ASIN for a given item. For more information, refer [ParentASIN Resource](./_creatorsapi_docs_en-us_api-reference_resources_parent-asin.md)

searchRefinements

Returns dynamic search refinements for each search request. For more information, refer [searchRefinements Resource](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements.md)

#### SortBy Parameter

Note that, if no `SortBy` parameter is provided in the search request, the results are sorted in default sort option for the `Marketplace` and `SearchIndex` combination. A particular `SortBy` parameter provided in the search request will fall back to the default sort option for the category if it is not supported in that category.

SortBy Value

Description

AvgCustomerReviews

Sorts results according to average customer reviews

Featured

Sorts results with featured items having higher rank

NewestArrivals

Sorts results with according to newest arrivals

Price:HighToLow

Sorts results according to most expensive to least expensive

Price:LowToHigh

Sorts results according to least expensive to most expensive

Relevance

Sorts results with relevant items having higher rank

## Response Elements

The following are common response elements returned:

Name

Description

errors

Optional array of error objects for items or query parameters that encountered issues. Only present when partial failures occur.

searchResult

Container for search result. It contains items container, totalResultCount, searchURL and searchRefinements container.

items

Container for item information including ASIN, Title and other attributes depending on resources requested.

totalResultCount

The total number of items that match the search query.

searchURL

URL to link back to search results page on Amazon for the search request.

searchRefinements

Container for searchRefinements resource if requested.

## Example Requests

-   General keyword search request:

Copy

```
{
   "partnerTag": "xyz-20",
   "keywords": "harry potter"
}
```

-   General keyword search using `ItemCount` and `Resources` parameter:

Copy

```
{
   "partnerTag": "xyz-20",
   "keywords": "harry potter",
   "itemCount": 1,
   "resources": ["images.primary.medium", "itemInfo.title", "offersV2.listings.price"]
}
```

-   Search by Actor:

Copy

```
{
   "partnerTag": "xyz-20",
   "actor": "Tom Cruise",
   "resources": ["images.primary.medium", "itemInfo.title", "offersV2.listings.price"]
}
```

-   Search inside a category with some filters applied:

Copy

```
{
   "partnerTag": "xyz-20",
   "searchIndex": "Electronics",
   "keywords": "DSLR Camera",
   "brand": "Sony",
   "minReviewsRating": "4",
   "resources": ["images.primary.medium", "itemInfo.title", "offersV2.listings.price"]
}
```

## Sample Response

-   The following snippet is a sample response for any `SearchItems` request:

Copy

```
{ 
 "searchResult": {
  "items": [
   {
    "asin": "0545162076",
    "detailPageURL": "https://www.amazon.com/dp/0545162076?tag=dgfd&linkCode=osi",
    "images": {
       /* Container for Images Resources if requested*/
    },
    "itemInfo": {
       /* Container for ItemInfo Resources if requested */
    },
    "offers": {
       /* Container for Offers Resources if requested */
    },
    {
       /* More items */
    }
   }
  ],
  "searchRefinements": {
      /* Container for searchRefinements Resources if requested */
  }
  "searchURL": "https://www.amazon.com/s/?field-keywords=Harry+Potter&search-alias=aps&tag=dgfd&linkCode=osi",
  "totalResultCount": 146
 }
}
```

-   The following snippet is a sample response for the second SearchItems request in the [Example Requests](./_creatorsapi_docs_en-us_api-reference_operations_search-items#example-requests.md) section above:

Copy

```
{
 "searchResult": {
  "items": [
   {
    "asin": "0545162076",
    "detailPageURL": "https://www.amazon.com/dp/0545162076?tag=dgfd&linkCode=osi",
    "images": {
     "primary": {
      "medium": {
       "height": 134,
       "url": "https://m.media-amazon.com/images/I/51BBTJaU6QL._SL160_.jpg",
       "width": 160
      }
     }
    },
    "itemInfo": {
     "title": {
      "displayValue": "Harry Potter Paperback Box Set (Books 1-7)",
      "label": "title",
      "locale": "en_US"
     }
    },
     "offersV2": {
       "listings": [{
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
       }]
     }
   }
  ],
  "searchURL": "https://www.amazon.com/s/?field-keywords=Harry+Potter&search-alias=aps&tag=dgfd&linkCode=osi",
  "totalResultCount": 146
 }
}
```

## Operations

Source: `_creatorsapi_docs_en-us_api-reference_operations.html`

# Operations

Creators API features following operations:

Operation Name

Description

[GetBrowseNodes](./_creatorsapi_docs_en-us_api-reference_operations_get-browse-nodes.md)

Lookup information for a Browse Node

[GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)

Lookup item information for an item

[GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)

Lookup information for variations

[SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

Searches for items on Amazon

For information on how to create and send a request, see [Using cURL](./_creatorsapi_docs_en-us_get-started_using-curl.md).

## BrowseNodeInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_browse-node-info.html`

# BrowseNodeInfo

The BrowseNodeInfo Resource in any item operation returns BrowseNodes the item falls under and the ancestry of that browse node. The browse nodes returned contain several browse node properties like Id, DisplayName, ContextFreeName, Ancestor and IsRoot. The browse node information returned as part of `BrowseNodeInfo` resource can further be utilized to:

-   Make a browse node targeted search request using [SearchItems Operation](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) by supplying the desired BrowseNodeId.

## Availability

All locales.

## Response Elements

Name

Description

BrowseNodes

Container for BrowseNodes associated with the Item. The container includes BrowseNodeId, DisplayName, ContextFreeName, Ancestor, IsRoot and SalesRank information. For more information, refer [BrowseNodes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#browsenodes-response-element.md)

WebsiteSalesRank

Container for Website Sales Rank associated with a product. Includes DisplayName, ContextFreeName and SalesRank information. For more information, refer [WebsiteSalesRank Response Element](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#websitesalesrank-response-element.md)

This is how the response elements in BrowseNodeInfo resource maps to the information available on Amazon Detail Page:

![](/assets/images/browsenodeinfo.png)

-   The top most line depicting **Amazon Best Sellers Rank** maps to the [WebsiteSalesRank Response Element](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#websitesalesrank-response-element.md).
-   WebsiteSalesRank is the sales rank of the item in the top level or the root browse node.
-   Note that, not all items have top level sales rank information available and hence, BrowseNodeInfo might not contain WebsiteSalesRank information for all items.
-   All the other browse nodes in the snapshot maps to the [BrowseNodes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#browsenodes-response-element.md).
-   Each of these browse nodes have rank associated with them. This rank is returned under the `SalesRank` element inside `BrowseNodes`. The rank here denotes the selling rank of the item in that particular browse node.
-   Note that, the number of browse nodes returned for an item are usually greater than the number of browse nodes for which sales rank information is present. This is because, Amazon displays only _Highly Relevant Sales Ranks_ (i.e. top most sales ranks).

#### BrowseNodes Response Element

The structure of BrowseNodes container inside the high level BrowseNodeInfo Resource is as follows:

Copy

```
{
  "browseNodes": [
    {
      "ancestor": "Ancestry ladder of the BrowseNode up-to the root node",
      "contextFreeName": "Context Free Name of the BrowseNode",
      "displayName": "Display Name of the BrowseNode",
      "id": "The BrowseNode ID",
      "isRoot": "Depicts whether the BrowseNode is a root node",
      "salesRank": "The sales rank of the item associated with the BrowseNode"
    }
  ]
}
```

Refer following table for more information on each of the individual response elements of the `BrowseNodes` response element:

Response Element

Description

Ancestor

Container for BrowseNode Ancestor information which includes BrowseNodeId, DisplayName, ContextFreeName and Ancestor information if one exists. The container is a ladder containing ancestor information up-to root browse node. That is, the last node in the ladder will be Root Node. Note that a root BrowseNode will not have any ancestor.

ContextFreeName

Indicates a displayable name for a BrowseNode that is fully context free. For e.g. _DisplayName_ of `BrowseNodeId: 3060` in US marketplace is _**Orphans & Foster Homes**_. One can not infer which root category this browse node belongs to unless we have the ancestry ladder for this browse node i.e. it requires a "context" for being intuitive. However, the _ContextFreeName_ of this browse node is _**Children's Orphans & Foster Homes Books**_. Note that, for a BrowseNode whose DisplayName is already context free will have the same ContextFreeName as DisplayName.

DisplayName

The display name of the BrowseNode as visible on the Amazon retail website.

Id

Indicates the unique identifier of the BrowseNode

IsRoot

Indicates if the current BrowseNode is a root category.

SalesRank

Sales Rank of the item associated with the browse node.

> Each of these browse nodes have sales rank associated with them. The rank here denotes the selling rank of the item in that particular browse node. Note that, the number of browse nodes returned for an item are usually greater than the number of browse nodes for which sales rank information is present. This is because, Amazon displays only _Highly Relevant Sales Ranks_ (i.e. top most sales ranks).

#### WebsiteSalesRank Response Element

The structure of `WebsiteSalesRank` container inside the high level `BrowseNodeInfo` Resource is as follows:

Copy

```
{
  "websiteSalesRank": {
    "contextFreeName": "Context Free Name of the BrowseNode",
    "displayName": "Display Name of the BrowseNode",
    "salesRank": "The website sales rank of the item"
  }
}
```

> Note that, not all items have top level sales rank information available and hence, BrowseNodeInfo might not contain WebsiteSalesRank information for all items.

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Resources

Add the resource name in the request payload to get the corresponding data in the API response.

Name

Description

browseNodeInfo.browseNodes

Get the browse nodes associated with the item. Using this resource only will return Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node.

browseNodeInfo.browseNodes.ancestor

Get the Ancestry ladder associated with each of the browse nodes the item falls under. Using this resource only will return ancestry ladder along with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node.

browseNodeInfo.browseNodes.salesRank

Get the SalesRank information with each of the browse nodes the item falls under. Using this resource only will return sales rank along with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node.

browseNodeInfo.websiteSalesRank

Get WebsiteSalesRank information associated with the item. Using this resource only will return the [WebsiteSalesRank Container](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#websitesalesrank-response-element.md) for the item.

### BrowseNodeInfo BrowseNodes

Requesting this resource returns browse nodes associated with the item. For each of the browse nodes returned, Id, DisplayName, ContextFreeName and IsRoot information is returned.

#### Sample Response

The following response snippet assumes [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) Request for the ItemId:059035342X

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "browseNodes": [
            {
              "id": "3060",
              "displayName": "Orphans & Foster Homes",
              "contextFreeName": "Children's Orphans & Foster Homes Books",
              "isRoot": false
            },
            {
              "id": "3153",
              "displayName": "Friendship",
              "contextFreeName": "Children's Friendship Books",
              "isRoot": false
            },
            {
              "id": "15356791",
              "displayName": "School",
              "contextFreeName": "Children's School Issues",
              "isRoot": false
            }
          ]
        }
      }
    ]
  }
}
```

### BrowseNodeInfo.browseNodes.ancestor

Requesting this resource returns ancestry ladder along with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node.

#### Sample Response

The following response snippet assumes [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) Request for the ItemId:059035342X

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "browseNodes": [
            {
              "id": "3060",
              "displayName": "Orphans & Foster Homes",
              "contextFreeName": "Children's Orphans & Foster Homes Books",
              "isRoot": false,
              "ancestor": {
                "id": "3045",
                "displayName": "Family Life",
                "contextFreeName": "Children's Family Life Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            },
            {
              "id": "3153",
              "displayName": "Friendship",
              "contextFreeName": "Children's Friendship Books",
              "isRoot": false,
              "ancestor": {
                "id": "7009087011",
                "displayName": "Friendship, Social Skills & School Life",
                "contextFreeName": "Children's Friendship & Social Skills Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            },
            {
              "id": "15356791",
              "displayName": "School",
              "contextFreeName": "Children's School Issues",
              "isRoot": false,
              "ancestor": {
                "id": "7009087011",
                "displayName": "Friendship, Social Skills & School Life",
                "contextFreeName": "Children's Friendship & Social Skills Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            }
          ]
        }
      }
    ]
  }
}
```

### BrowseNodeInfo.browseNodes.salesRank

Requesting this resource returns sales rank information along with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node.

#### Sample Response

The following response snippet assumes [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) Request for the ItemId:059035342X

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "browseNodes": [
            {
              "id": "3060",
              "displayName": "Orphans & Foster Homes",
              "contextFreeName": "Children's Orphans & Foster Homes Books",
              "isRoot": false,
              "salesRank": 2
            },
            {
              "id": "3153",
              "displayName": "Friendship",
              "contextFreeName": "Children's Friendship Books",
              "isRoot": false,
              "salesRank": 4
            },
            {
              "id": "15356791",
              "displayName": "School",
              "contextFreeName": "Children's School Issues",
              "isRoot": false,
              "salesRank": 15
            }
          ]
        }
      }
    ]
  }
}
```

### BrowseNodeInfo.websiteSalesRank

Requesting this resource returns website sales rank information associated with the item.

#### Sample Response

The following response snippet assumes [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) Request for the ItemId:059035342X

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "websiteSalesRank": {
            "displayName": "Books",
            "contextFreeName": "Books",
            "salesRank": 197
          }
        }
      }
    ]
  }
}
```

## Sample Use Cases

### Example 1

Get WebsiteSalesRank for an Item:

#### Request Payload

Copy

```
{
        "itemIds": ["059035342X"],
        "itemIdType": "ASIN",
        "marketplace": "www.amazon.com",
        "partnerTag": "associate-tag-20",
        "resources": ["browseNodeInfo.websiteSalesRank"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "websiteSalesRank": {
            "displayName": "Books",
            "contextFreeName": "Books",
            "salesRank": 197
          }
        },
        "detailPageURL": "https://www.amazon.com/dp/059035342X?tag=associate-tag-20&linkCode=ogi&th=1&psc=1"
      }
    ]
  }
}
```

### Example 2

Get all BrowseNodes associated with the item without the ancestry and sales rank information.

#### Request Payload

Copy

```
{
        "itemIds": ["059035342X"],
        "itemIdType": "ASIN",
        "marketplace": "www.amazon.com",
        "partnerTag": "associate-tag-20",
        "resources": ["browseNodeInfo.browseNodes"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "browseNodes": [
            {
              "id": "3060",
              "displayName": "Orphans & Foster Homes",
              "contextFreeName": "Children's Orphans & Foster Homes Books",
              "isRoot": false
            },
            {
              "id": "3153",
              "displayName": "Friendship",
              "contextFreeName": "Children's Friendship Books",
              "isRoot": false
            },
            {
              "id": "15356791",
              "displayName": "School",
              "contextFreeName": "Children's School Issues",
              "isRoot": false
            }
          ]
        },
        "detailPageURL": "https://www.amazon.com/dp/059035342X?tag=associate-tag-20&linkCode=ogi&th=1&psc=1"
      }
    ]
  }
}
```

### Example 3

Get all BrowseNodeInfo information for an item

#### Request Payload

Copy

```
{
        "itemIds": ["059035342X"],
        "itemIdType": "ASIN",
        "marketplace": "www.amazon.com",
        "partnerTag": "associate-tag-20",
        "resources": ["browseNodeInfo.browseNodes", "browseNodeInfo.browseNodes.ancestor", "browseNodeInfo.browseNodes.salesRank", "browseNodeInfo.websiteSalesRank"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "websiteSalesRank": {
            "displayName": "Books",
            "contextFreeName": "Books",
            "salesRank": 197
          },
          "browseNodes": [
            {
              "id": "3060",
              "displayName": "Orphans & Foster Homes",
              "contextFreeName": "Children's Orphans & Foster Homes Books",
              "isRoot": false,
              "salesRank": 2,
              "ancestor": {
                "id": "3045",
                "displayName": "Family Life",
                "contextFreeName": "Children's Family Life Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            },
            {
              "id": "3153",
              "displayName": "Friendship",
              "contextFreeName": "Children's Friendship Books",
              "isRoot": false,
              "salesRank": 5,
              "ancestor": {
                "id": "7009087011",
                "displayName": "Friendship, Social Skills & School Life",
                "contextFreeName": "Children's Friendship & Social Skills Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            },
            {
              "id": "15356791",
              "displayName": "School",
              "contextFreeName": "Children's School Issues",
              "isRoot": false,
              "salesRank": 4,
              "ancestor": {
                "id": "7009087011",
                "displayName": "Friendship, Social Skills & School Life",
                "contextFreeName": "Children's Friendship & Social Skills Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            }
          ]
        },
        "detailPageURL": "https://www.amazon.com/dp/059035342X?tag=associate-tag-20&linkCode=ogi&th=1&psc=1"
      }
    ]
  }
}
```

## BrowseNodeInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#browsenodes-response-element.html`

# BrowseNodeInfo

The BrowseNodeInfo Resource in any item operation returns BrowseNodes the item falls under and the ancestry of that browse node. The browse nodes returned contain several browse node properties like Id, DisplayName, ContextFreeName, Ancestor and IsRoot. The browse node information returned as part of `BrowseNodeInfo` resource can further be utilized to:

-   Make a browse node targeted search request using [SearchItems Operation](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) by supplying the desired BrowseNodeId.

## Availability

All locales.

## Response Elements

Name

Description

BrowseNodes

Container for BrowseNodes associated with the Item. The container includes BrowseNodeId, DisplayName, ContextFreeName, Ancestor, IsRoot and SalesRank information. For more information, refer [BrowseNodes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#browsenodes-response-element.md)

WebsiteSalesRank

Container for Website Sales Rank associated with a product. Includes DisplayName, ContextFreeName and SalesRank information. For more information, refer [WebsiteSalesRank Response Element](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#websitesalesrank-response-element.md)

This is how the response elements in BrowseNodeInfo resource maps to the information available on Amazon Detail Page:

![](/assets/images/browsenodeinfo.png)

-   The top most line depicting **Amazon Best Sellers Rank** maps to the [WebsiteSalesRank Response Element](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#websitesalesrank-response-element.md).
-   WebsiteSalesRank is the sales rank of the item in the top level or the root browse node.
-   Note that, not all items have top level sales rank information available and hence, BrowseNodeInfo might not contain WebsiteSalesRank information for all items.
-   All the other browse nodes in the snapshot maps to the [BrowseNodes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#browsenodes-response-element.md).
-   Each of these browse nodes have rank associated with them. This rank is returned under the `SalesRank` element inside `BrowseNodes`. The rank here denotes the selling rank of the item in that particular browse node.
-   Note that, the number of browse nodes returned for an item are usually greater than the number of browse nodes for which sales rank information is present. This is because, Amazon displays only _Highly Relevant Sales Ranks_ (i.e. top most sales ranks).

#### BrowseNodes Response Element

The structure of BrowseNodes container inside the high level BrowseNodeInfo Resource is as follows:

Copy

```
{
  "browseNodes": [
    {
      "ancestor": "Ancestry ladder of the BrowseNode up-to the root node",
      "contextFreeName": "Context Free Name of the BrowseNode",
      "displayName": "Display Name of the BrowseNode",
      "id": "The BrowseNode ID",
      "isRoot": "Depicts whether the BrowseNode is a root node",
      "salesRank": "The sales rank of the item associated with the BrowseNode"
    }
  ]
}
```

Refer following table for more information on each of the individual response elements of the `BrowseNodes` response element:

Response Element

Description

Ancestor

Container for BrowseNode Ancestor information which includes BrowseNodeId, DisplayName, ContextFreeName and Ancestor information if one exists. The container is a ladder containing ancestor information up-to root browse node. That is, the last node in the ladder will be Root Node. Note that a root BrowseNode will not have any ancestor.

ContextFreeName

Indicates a displayable name for a BrowseNode that is fully context free. For e.g. _DisplayName_ of `BrowseNodeId: 3060` in US marketplace is _**Orphans & Foster Homes**_. One can not infer which root category this browse node belongs to unless we have the ancestry ladder for this browse node i.e. it requires a "context" for being intuitive. However, the _ContextFreeName_ of this browse node is _**Children's Orphans & Foster Homes Books**_. Note that, for a BrowseNode whose DisplayName is already context free will have the same ContextFreeName as DisplayName.

DisplayName

The display name of the BrowseNode as visible on the Amazon retail website.

Id

Indicates the unique identifier of the BrowseNode

IsRoot

Indicates if the current BrowseNode is a root category.

SalesRank

Sales Rank of the item associated with the browse node.

> Each of these browse nodes have sales rank associated with them. The rank here denotes the selling rank of the item in that particular browse node. Note that, the number of browse nodes returned for an item are usually greater than the number of browse nodes for which sales rank information is present. This is because, Amazon displays only _Highly Relevant Sales Ranks_ (i.e. top most sales ranks).

#### WebsiteSalesRank Response Element

The structure of `WebsiteSalesRank` container inside the high level `BrowseNodeInfo` Resource is as follows:

Copy

```
{
  "websiteSalesRank": {
    "contextFreeName": "Context Free Name of the BrowseNode",
    "displayName": "Display Name of the BrowseNode",
    "salesRank": "The website sales rank of the item"
  }
}
```

> Note that, not all items have top level sales rank information available and hence, BrowseNodeInfo might not contain WebsiteSalesRank information for all items.

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Resources

Add the resource name in the request payload to get the corresponding data in the API response.

Name

Description

browseNodeInfo.browseNodes

Get the browse nodes associated with the item. Using this resource only will return Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node.

browseNodeInfo.browseNodes.ancestor

Get the Ancestry ladder associated with each of the browse nodes the item falls under. Using this resource only will return ancestry ladder along with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node.

browseNodeInfo.browseNodes.salesRank

Get the SalesRank information with each of the browse nodes the item falls under. Using this resource only will return sales rank along with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node.

browseNodeInfo.websiteSalesRank

Get WebsiteSalesRank information associated with the item. Using this resource only will return the [WebsiteSalesRank Container](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#websitesalesrank-response-element.md) for the item.

### BrowseNodeInfo BrowseNodes

Requesting this resource returns browse nodes associated with the item. For each of the browse nodes returned, Id, DisplayName, ContextFreeName and IsRoot information is returned.

#### Sample Response

The following response snippet assumes [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) Request for the ItemId:059035342X

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "browseNodes": [
            {
              "id": "3060",
              "displayName": "Orphans & Foster Homes",
              "contextFreeName": "Children's Orphans & Foster Homes Books",
              "isRoot": false
            },
            {
              "id": "3153",
              "displayName": "Friendship",
              "contextFreeName": "Children's Friendship Books",
              "isRoot": false
            },
            {
              "id": "15356791",
              "displayName": "School",
              "contextFreeName": "Children's School Issues",
              "isRoot": false
            }
          ]
        }
      }
    ]
  }
}
```

### BrowseNodeInfo.browseNodes.ancestor

Requesting this resource returns ancestry ladder along with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node.

#### Sample Response

The following response snippet assumes [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) Request for the ItemId:059035342X

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "browseNodes": [
            {
              "id": "3060",
              "displayName": "Orphans & Foster Homes",
              "contextFreeName": "Children's Orphans & Foster Homes Books",
              "isRoot": false,
              "ancestor": {
                "id": "3045",
                "displayName": "Family Life",
                "contextFreeName": "Children's Family Life Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            },
            {
              "id": "3153",
              "displayName": "Friendship",
              "contextFreeName": "Children's Friendship Books",
              "isRoot": false,
              "ancestor": {
                "id": "7009087011",
                "displayName": "Friendship, Social Skills & School Life",
                "contextFreeName": "Children's Friendship & Social Skills Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            },
            {
              "id": "15356791",
              "displayName": "School",
              "contextFreeName": "Children's School Issues",
              "isRoot": false,
              "ancestor": {
                "id": "7009087011",
                "displayName": "Friendship, Social Skills & School Life",
                "contextFreeName": "Children's Friendship & Social Skills Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            }
          ]
        }
      }
    ]
  }
}
```

### BrowseNodeInfo.browseNodes.salesRank

Requesting this resource returns sales rank information along with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node.

#### Sample Response

The following response snippet assumes [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) Request for the ItemId:059035342X

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "browseNodes": [
            {
              "id": "3060",
              "displayName": "Orphans & Foster Homes",
              "contextFreeName": "Children's Orphans & Foster Homes Books",
              "isRoot": false,
              "salesRank": 2
            },
            {
              "id": "3153",
              "displayName": "Friendship",
              "contextFreeName": "Children's Friendship Books",
              "isRoot": false,
              "salesRank": 4
            },
            {
              "id": "15356791",
              "displayName": "School",
              "contextFreeName": "Children's School Issues",
              "isRoot": false,
              "salesRank": 15
            }
          ]
        }
      }
    ]
  }
}
```

### BrowseNodeInfo.websiteSalesRank

Requesting this resource returns website sales rank information associated with the item.

#### Sample Response

The following response snippet assumes [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) Request for the ItemId:059035342X

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "websiteSalesRank": {
            "displayName": "Books",
            "contextFreeName": "Books",
            "salesRank": 197
          }
        }
      }
    ]
  }
}
```

## Sample Use Cases

### Example 1

Get WebsiteSalesRank for an Item:

#### Request Payload

Copy

```
{
        "itemIds": ["059035342X"],
        "itemIdType": "ASIN",
        "marketplace": "www.amazon.com",
        "partnerTag": "associate-tag-20",
        "resources": ["browseNodeInfo.websiteSalesRank"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "websiteSalesRank": {
            "displayName": "Books",
            "contextFreeName": "Books",
            "salesRank": 197
          }
        },
        "detailPageURL": "https://www.amazon.com/dp/059035342X?tag=associate-tag-20&linkCode=ogi&th=1&psc=1"
      }
    ]
  }
}
```

### Example 2

Get all BrowseNodes associated with the item without the ancestry and sales rank information.

#### Request Payload

Copy

```
{
        "itemIds": ["059035342X"],
        "itemIdType": "ASIN",
        "marketplace": "www.amazon.com",
        "partnerTag": "associate-tag-20",
        "resources": ["browseNodeInfo.browseNodes"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "browseNodes": [
            {
              "id": "3060",
              "displayName": "Orphans & Foster Homes",
              "contextFreeName": "Children's Orphans & Foster Homes Books",
              "isRoot": false
            },
            {
              "id": "3153",
              "displayName": "Friendship",
              "contextFreeName": "Children's Friendship Books",
              "isRoot": false
            },
            {
              "id": "15356791",
              "displayName": "School",
              "contextFreeName": "Children's School Issues",
              "isRoot": false
            }
          ]
        },
        "detailPageURL": "https://www.amazon.com/dp/059035342X?tag=associate-tag-20&linkCode=ogi&th=1&psc=1"
      }
    ]
  }
}
```

### Example 3

Get all BrowseNodeInfo information for an item

#### Request Payload

Copy

```
{
        "itemIds": ["059035342X"],
        "itemIdType": "ASIN",
        "marketplace": "www.amazon.com",
        "partnerTag": "associate-tag-20",
        "resources": ["browseNodeInfo.browseNodes", "browseNodeInfo.browseNodes.ancestor", "browseNodeInfo.browseNodes.salesRank", "browseNodeInfo.websiteSalesRank"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "websiteSalesRank": {
            "displayName": "Books",
            "contextFreeName": "Books",
            "salesRank": 197
          },
          "browseNodes": [
            {
              "id": "3060",
              "displayName": "Orphans & Foster Homes",
              "contextFreeName": "Children's Orphans & Foster Homes Books",
              "isRoot": false,
              "salesRank": 2,
              "ancestor": {
                "id": "3045",
                "displayName": "Family Life",
                "contextFreeName": "Children's Family Life Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            },
            {
              "id": "3153",
              "displayName": "Friendship",
              "contextFreeName": "Children's Friendship Books",
              "isRoot": false,
              "salesRank": 5,
              "ancestor": {
                "id": "7009087011",
                "displayName": "Friendship, Social Skills & School Life",
                "contextFreeName": "Children's Friendship & Social Skills Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            },
            {
              "id": "15356791",
              "displayName": "School",
              "contextFreeName": "Children's School Issues",
              "isRoot": false,
              "salesRank": 4,
              "ancestor": {
                "id": "7009087011",
                "displayName": "Friendship, Social Skills & School Life",
                "contextFreeName": "Children's Friendship & Social Skills Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            }
          ]
        },
        "detailPageURL": "https://www.amazon.com/dp/059035342X?tag=associate-tag-20&linkCode=ogi&th=1&psc=1"
      }
    ]
  }
}
```

## BrowseNodeInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#websitesalesrank-response-element.html`

# BrowseNodeInfo

The BrowseNodeInfo Resource in any item operation returns BrowseNodes the item falls under and the ancestry of that browse node. The browse nodes returned contain several browse node properties like Id, DisplayName, ContextFreeName, Ancestor and IsRoot. The browse node information returned as part of `BrowseNodeInfo` resource can further be utilized to:

-   Make a browse node targeted search request using [SearchItems Operation](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) by supplying the desired BrowseNodeId.

## Availability

All locales.

## Response Elements

Name

Description

BrowseNodes

Container for BrowseNodes associated with the Item. The container includes BrowseNodeId, DisplayName, ContextFreeName, Ancestor, IsRoot and SalesRank information. For more information, refer [BrowseNodes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#browsenodes-response-element.md)

WebsiteSalesRank

Container for Website Sales Rank associated with a product. Includes DisplayName, ContextFreeName and SalesRank information. For more information, refer [WebsiteSalesRank Response Element](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#websitesalesrank-response-element.md)

This is how the response elements in BrowseNodeInfo resource maps to the information available on Amazon Detail Page:

![](/assets/images/browsenodeinfo.png)

-   The top most line depicting **Amazon Best Sellers Rank** maps to the [WebsiteSalesRank Response Element](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#websitesalesrank-response-element.md).
-   WebsiteSalesRank is the sales rank of the item in the top level or the root browse node.
-   Note that, not all items have top level sales rank information available and hence, BrowseNodeInfo might not contain WebsiteSalesRank information for all items.
-   All the other browse nodes in the snapshot maps to the [BrowseNodes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#browsenodes-response-element.md).
-   Each of these browse nodes have rank associated with them. This rank is returned under the `SalesRank` element inside `BrowseNodes`. The rank here denotes the selling rank of the item in that particular browse node.
-   Note that, the number of browse nodes returned for an item are usually greater than the number of browse nodes for which sales rank information is present. This is because, Amazon displays only _Highly Relevant Sales Ranks_ (i.e. top most sales ranks).

#### BrowseNodes Response Element

The structure of BrowseNodes container inside the high level BrowseNodeInfo Resource is as follows:

Copy

```
{
  "browseNodes": [
    {
      "ancestor": "Ancestry ladder of the BrowseNode up-to the root node",
      "contextFreeName": "Context Free Name of the BrowseNode",
      "displayName": "Display Name of the BrowseNode",
      "id": "The BrowseNode ID",
      "isRoot": "Depicts whether the BrowseNode is a root node",
      "salesRank": "The sales rank of the item associated with the BrowseNode"
    }
  ]
}
```

Refer following table for more information on each of the individual response elements of the `BrowseNodes` response element:

Response Element

Description

Ancestor

Container for BrowseNode Ancestor information which includes BrowseNodeId, DisplayName, ContextFreeName and Ancestor information if one exists. The container is a ladder containing ancestor information up-to root browse node. That is, the last node in the ladder will be Root Node. Note that a root BrowseNode will not have any ancestor.

ContextFreeName

Indicates a displayable name for a BrowseNode that is fully context free. For e.g. _DisplayName_ of `BrowseNodeId: 3060` in US marketplace is _**Orphans & Foster Homes**_. One can not infer which root category this browse node belongs to unless we have the ancestry ladder for this browse node i.e. it requires a "context" for being intuitive. However, the _ContextFreeName_ of this browse node is _**Children's Orphans & Foster Homes Books**_. Note that, for a BrowseNode whose DisplayName is already context free will have the same ContextFreeName as DisplayName.

DisplayName

The display name of the BrowseNode as visible on the Amazon retail website.

Id

Indicates the unique identifier of the BrowseNode

IsRoot

Indicates if the current BrowseNode is a root category.

SalesRank

Sales Rank of the item associated with the browse node.

> Each of these browse nodes have sales rank associated with them. The rank here denotes the selling rank of the item in that particular browse node. Note that, the number of browse nodes returned for an item are usually greater than the number of browse nodes for which sales rank information is present. This is because, Amazon displays only _Highly Relevant Sales Ranks_ (i.e. top most sales ranks).

#### WebsiteSalesRank Response Element

The structure of `WebsiteSalesRank` container inside the high level `BrowseNodeInfo` Resource is as follows:

Copy

```
{
  "websiteSalesRank": {
    "contextFreeName": "Context Free Name of the BrowseNode",
    "displayName": "Display Name of the BrowseNode",
    "salesRank": "The website sales rank of the item"
  }
}
```

> Note that, not all items have top level sales rank information available and hence, BrowseNodeInfo might not contain WebsiteSalesRank information for all items.

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Resources

Add the resource name in the request payload to get the corresponding data in the API response.

Name

Description

browseNodeInfo.browseNodes

Get the browse nodes associated with the item. Using this resource only will return Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node.

browseNodeInfo.browseNodes.ancestor

Get the Ancestry ladder associated with each of the browse nodes the item falls under. Using this resource only will return ancestry ladder along with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node.

browseNodeInfo.browseNodes.salesRank

Get the SalesRank information with each of the browse nodes the item falls under. Using this resource only will return sales rank along with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node.

browseNodeInfo.websiteSalesRank

Get WebsiteSalesRank information associated with the item. Using this resource only will return the [WebsiteSalesRank Container](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info#websitesalesrank-response-element.md) for the item.

### BrowseNodeInfo BrowseNodes

Requesting this resource returns browse nodes associated with the item. For each of the browse nodes returned, Id, DisplayName, ContextFreeName and IsRoot information is returned.

#### Sample Response

The following response snippet assumes [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) Request for the ItemId:059035342X

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "browseNodes": [
            {
              "id": "3060",
              "displayName": "Orphans & Foster Homes",
              "contextFreeName": "Children's Orphans & Foster Homes Books",
              "isRoot": false
            },
            {
              "id": "3153",
              "displayName": "Friendship",
              "contextFreeName": "Children's Friendship Books",
              "isRoot": false
            },
            {
              "id": "15356791",
              "displayName": "School",
              "contextFreeName": "Children's School Issues",
              "isRoot": false
            }
          ]
        }
      }
    ]
  }
}
```

### BrowseNodeInfo.browseNodes.ancestor

Requesting this resource returns ancestry ladder along with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node.

#### Sample Response

The following response snippet assumes [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) Request for the ItemId:059035342X

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "browseNodes": [
            {
              "id": "3060",
              "displayName": "Orphans & Foster Homes",
              "contextFreeName": "Children's Orphans & Foster Homes Books",
              "isRoot": false,
              "ancestor": {
                "id": "3045",
                "displayName": "Family Life",
                "contextFreeName": "Children's Family Life Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            },
            {
              "id": "3153",
              "displayName": "Friendship",
              "contextFreeName": "Children's Friendship Books",
              "isRoot": false,
              "ancestor": {
                "id": "7009087011",
                "displayName": "Friendship, Social Skills & School Life",
                "contextFreeName": "Children's Friendship & Social Skills Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            },
            {
              "id": "15356791",
              "displayName": "School",
              "contextFreeName": "Children's School Issues",
              "isRoot": false,
              "ancestor": {
                "id": "7009087011",
                "displayName": "Friendship, Social Skills & School Life",
                "contextFreeName": "Children's Friendship & Social Skills Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            }
          ]
        }
      }
    ]
  }
}
```

### BrowseNodeInfo.browseNodes.salesRank

Requesting this resource returns sales rank information along with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node.

#### Sample Response

The following response snippet assumes [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) Request for the ItemId:059035342X

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "browseNodes": [
            {
              "id": "3060",
              "displayName": "Orphans & Foster Homes",
              "contextFreeName": "Children's Orphans & Foster Homes Books",
              "isRoot": false,
              "salesRank": 2
            },
            {
              "id": "3153",
              "displayName": "Friendship",
              "contextFreeName": "Children's Friendship Books",
              "isRoot": false,
              "salesRank": 4
            },
            {
              "id": "15356791",
              "displayName": "School",
              "contextFreeName": "Children's School Issues",
              "isRoot": false,
              "salesRank": 15
            }
          ]
        }
      }
    ]
  }
}
```

### BrowseNodeInfo.websiteSalesRank

Requesting this resource returns website sales rank information associated with the item.

#### Sample Response

The following response snippet assumes [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) Request for the ItemId:059035342X

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "websiteSalesRank": {
            "displayName": "Books",
            "contextFreeName": "Books",
            "salesRank": 197
          }
        }
      }
    ]
  }
}
```

## Sample Use Cases

### Example 1

Get WebsiteSalesRank for an Item:

#### Request Payload

Copy

```
{
        "itemIds": ["059035342X"],
        "itemIdType": "ASIN",
        "marketplace": "www.amazon.com",
        "partnerTag": "associate-tag-20",
        "resources": ["browseNodeInfo.websiteSalesRank"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "websiteSalesRank": {
            "displayName": "Books",
            "contextFreeName": "Books",
            "salesRank": 197
          }
        },
        "detailPageURL": "https://www.amazon.com/dp/059035342X?tag=associate-tag-20&linkCode=ogi&th=1&psc=1"
      }
    ]
  }
}
```

### Example 2

Get all BrowseNodes associated with the item without the ancestry and sales rank information.

#### Request Payload

Copy

```
{
        "itemIds": ["059035342X"],
        "itemIdType": "ASIN",
        "marketplace": "www.amazon.com",
        "partnerTag": "associate-tag-20",
        "resources": ["browseNodeInfo.browseNodes"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "browseNodes": [
            {
              "id": "3060",
              "displayName": "Orphans & Foster Homes",
              "contextFreeName": "Children's Orphans & Foster Homes Books",
              "isRoot": false
            },
            {
              "id": "3153",
              "displayName": "Friendship",
              "contextFreeName": "Children's Friendship Books",
              "isRoot": false
            },
            {
              "id": "15356791",
              "displayName": "School",
              "contextFreeName": "Children's School Issues",
              "isRoot": false
            }
          ]
        },
        "detailPageURL": "https://www.amazon.com/dp/059035342X?tag=associate-tag-20&linkCode=ogi&th=1&psc=1"
      }
    ]
  }
}
```

### Example 3

Get all BrowseNodeInfo information for an item

#### Request Payload

Copy

```
{
        "itemIds": ["059035342X"],
        "itemIdType": "ASIN",
        "marketplace": "www.amazon.com",
        "partnerTag": "associate-tag-20",
        "resources": ["browseNodeInfo.browseNodes", "browseNodeInfo.browseNodes.ancestor", "browseNodeInfo.browseNodes.salesRank", "browseNodeInfo.websiteSalesRank"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "059035342X",
        "browseNodeInfo": {
          "websiteSalesRank": {
            "displayName": "Books",
            "contextFreeName": "Books",
            "salesRank": 197
          },
          "browseNodes": [
            {
              "id": "3060",
              "displayName": "Orphans & Foster Homes",
              "contextFreeName": "Children's Orphans & Foster Homes Books",
              "isRoot": false,
              "salesRank": 2,
              "ancestor": {
                "id": "3045",
                "displayName": "Family Life",
                "contextFreeName": "Children's Family Life Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            },
            {
              "id": "3153",
              "displayName": "Friendship",
              "contextFreeName": "Children's Friendship Books",
              "isRoot": false,
              "salesRank": 5,
              "ancestor": {
                "id": "7009087011",
                "displayName": "Friendship, Social Skills & School Life",
                "contextFreeName": "Children's Friendship & Social Skills Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            },
            {
              "id": "15356791",
              "displayName": "School",
              "contextFreeName": "Children's School Issues",
              "isRoot": false,
              "salesRank": 4,
              "ancestor": {
                "id": "7009087011",
                "displayName": "Friendship, Social Skills & School Life",
                "contextFreeName": "Children's Friendship & Social Skills Books",
                "ancestor": {
                  "id": "1084192",
                  "displayName": "Growing Up & Facts of Life",
                  "contextFreeName": "Children's Growing Up & Facts of Life Books",
                  "ancestor": {
                    "id": "4",
                    "displayName": "Children's Books",
                    "contextFreeName": "Children's Books",
                    "ancestor": {
                      "id": "1000",
                      "displayName": "Subjects",
                      "contextFreeName": "Subjects",
                      "ancestor": {
                        "id": "283155",
                        "displayName": "Books",
                        "contextFreeName": "Books"
                      }
                    }
                  }
                }
              }
            }
          ]
        },
        "detailPageURL": "https://www.amazon.com/dp/059035342X?tag=associate-tag-20&linkCode=ogi&th=1&psc=1"
      }
    ]
  }
}
```

## BrowseNodes

Source: `_creatorsapi_docs_en-us_api-reference_resources_browse-nodes.html`

# BrowseNodes

The BrowseNodes Resource is tightly associated with the GetBrowseNodes Operation. It returns Children and Ancestry ladder associated with the requested BrowseNodeIds. The ancestor and children returned contain Id, DisplayName and ContextFreeName information.

The browse node information returned as part of `BrowseNodes` resource can be used to:

-   Get BrowseNode information like DisplayName, ContextFreeName, it's ancestry ladder and children.

## Availability

All locales.

## Response Elements

Name

Description

Ancestor

Container for BrowseNode Ancestor information which includes BrowseNodeId, DisplayName, ContextFreeName and Ancestor information if one exists. The container is a ladder containing ancestor information up-to root browse node. That is, the last node in the ladder will be Root Node. Note that a root BrowseNode will not have any ancestor.

Children

List of BrowseNode Children for a particular BrowseNode. Each BrowseNode Child contains BrowseNodeId, DisplayName and ContextFreeName information associated with the BrowseNode Child. Note that a leaf browse node won't have any children.

ContextFreeName

Indicates a displayable name for a BrowseNode that is fully context free. For e.g. _DisplayName_ of `BrowseNodeId: 3060` in US marketplace is _**Orphans & Foster Homes**_. One can not infer which root category this browse node belongs to unless we have the ancestry ladder for this browse node i.e. it requires a "context" for being intuitive. However, the _ContextFreeName_ of this browse node is _**Children's Orphans & Foster Homes Books**_. Note that, for a BrowseNode whose DisplayName is already context free will have the same ContextFreeName as DisplayName.

DisplayName

The display name of the BrowseNode as visible on the Amazon retail website.

Id

Indicates the unique identifier of the BrowseNode

IsRoot

Indicates if the current BrowseNode is a root category.

The structure of BrowseNodes container is as follows:

Copy

```
{
  "browseNodes": [
    {
      "ancestor": "Ancestry ladder of the BrowseNode up-to the root node",
      "children": "List of BrowseNode Child of the requested browse node",
      "contextFreeName": "Context Free Name of the BrowseNode",
      "displayName": "Display Name of the BrowseNode",
      "id": "The BrowseNode ID",
      "isRoot": "Depicts whether the BrowseNode is a root node"
    }
  ]
}
```

## Relevant Operations

Operations that can use these resources include:

-   [GetBrowseNodes](./_creatorsapi_docs_en-us_api-reference_operations_get-browse-nodes.md)

## Resources

The Id, DisplayName, ContextFreeName and IsRoot information is returned by default for every `GetBrowseNodes` request. Ancestor and Children are returned only when the respective resources are explicitly requested. Add the resource name in the request payload to get the corresponding data in the API response.

Name

Description

BrowseNodes.Ancestor

Get the Ancestry ladder associated with each of the browse nodes. Using this resource only will return ancestry ladder along with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node. The Id, DisplayName and ContextFreeName of each browse node ancestor is also returned.

BrowseNodes.Children

Get the list of browse node child associated with the requested browse node. Using this resource only will return list of browse node child with Id, DisplayName, ContextFreeName and IsRoot information associated with each browse node. The Id, DisplayName and ContextFreeName of each browse node child is also returned.

## Sample Use Cases

### Example 1

Get Children for a BrowseNode:

#### Request Payload

Copy

```
{
   "partnerTag": "associate-tag-20",
   "browseNodeIds": ["283155"],
   "resources": ["BrowseNodes.Children"]
}
```

#### Response

Copy

```
{
  "browseNodesResult": {
    "browseNodes": [
      {
        "children": [
          {
            "contextFreeName": "Subjects",
            "displayName": "Subjects",
            "id": "1000"
          },
          {
            "contextFreeName": "Books Featured Categories",
            "displayName": "Books Featured Categories",
            "id": "51546011"
          },
          {
            "contextFreeName": "Specialty Boutique",
            "displayName": "Specialty Boutique",
            "id": "2349030011"
          }
        ],
        "contextFreeName": "Books",
        "displayName": "Books",
        "id": "283155",
        "isRoot": true
      }
    ]
  }
}
```

### Example 2

Get ancestry ladder associated with a browse node.

#### Request Payload

Copy

```
{
   "partnerTag": "associate-tag-20",
   "browseNodeIds": ["4"],
   "resources": ["BrowseNodes.Ancestor"]
}
```

#### Response

Copy

```
{
  "browseNodesResult": {
    "browseNodes": [
      {
        "id": "4",
        "displayName": "Children's Books",
        "contextFreeName": "Children's Books",
        "isRoot": false,
        "ancestor": {
          "id": "1000",
          "displayName": "Subjects",
          "contextFreeName": "Subjects",
          "ancestor": {
            "contextFreeName": "Books",
            "displayName": "Books",
            "id": "283155"
          }
        }
      }
    ]
  }
}
```

## Images

Source: `_creatorsapi_docs_en-us_api-reference_resources_images.html`

# Images

The Images resources returns the URLs for all available images of an item in three sizes: `Small`, `Medium`, and `Large`. For example, if a Kindle has four images, the images resources returns the URLs of 12 images: four images, each in three sizes.

In addition to returning the image URLs, these resources also return the height and width dimensions of each image. Use these values to display the images correctly.

## Availability

All locales.

## Response Elements

Name

Description

Primary

Container for Primary Images. The container includes Large, Medium, and Small Image Sizes as per the resources requested. Each of the image size contains three values: URL, Height, and Width of the image. For more information, refer [ImageType Response Element](./_creatorsapi_docs_en-us_api-reference_resources_images#imagetype-response-element.md)

Variants

Container for Variants Images. The container includes Large, Medium, and Small Image Sizes as per the resources requested. Each of the image size contains three values: URL, Height, and Width of the image. For more information, refer [ImageType Response Element](./_creatorsapi_docs_en-us_api-reference_resources_images#imagetype-response-element.md)

#### ImageType Response Element

The structure of ImageType (Primary / Variants) container inside the high level Images Resource is as follows:

Copy

```
{
  "imageType": {
    "imageSize": {
      "url": "Image URL",
      "height": "Number representing width of the image",
      "width": "Number representing height of the image"
    }
  }
}
```

-   Each of the `ImageType` (Primary / Variant) can contain three sub-resources: Small, Medium, and Large.
-   Each of the `ImageSize` (Small / Medium / Large) contains three values: URL, Height, and Width of the image.

> The `Primary` image denotes the image which is displayed in search results and on the detail page. **Variants** include everything else. The sizes of the images are specified by the `_SLXXX_` suffix in the URL, where `XXX` is the number of pixels on the longest side of the image. For example, a medium size image has 160 pixels on its longest side, so it has the suffix `_SL160_`. This is the preferred way to reference images.

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Resources

Add the resource name in the request payload to get the corresponding data in the API response.

Name

Description

images.primary.small

Get the primary image of an item in small size.

images.primary.medium

Get the primary image of an item in medium size.

images.primary.large

Get the primary image of an item in large size.

images.variants.small

Get the variant images of an item in small size.

images.variants.medium

Get the variant images of an item in medium size.

images.variants.large

Get the variant images of an item in large size.

## Sample Use Cases

### Example 1

Get the primary image of an item, in large size.

#### Request Payload

Copy

```
{
    "associateTag": "xyz-20",
    "itemIds": ["B00TSUGXKE"],
    "resources": ["images.primary.large"]
}
```

#### Response

Copy

```
{
 "asin": "B00TSUGXKE",
 "images": {
  "primary": {
   "large": {
    "url": "https://m.media-amazon.com/images/I/41FYkVPzrIL.jpg",
    "height": 500,
    "width": 500
   }
  }
 }
}
```

### Example 2

Get the primary image of an item in large size, and variant images in small size.

#### Request Payload

Copy

```
{
    "associateTag": "xyz-20",
    "itemIds": ["B00TSUGXKE"],
    "resources": ["images.primary.large", "images.variants.small"]
}
```

#### Response

Copy

```
{
 "asin": "B00TSUGXKE",
 "images": {
  "primary": {
   "large": {
    "url": "https://m.media-amazon.com/images/I/41FYkVPzrIL.jpg",
    "height": 500,
    "width": 500
   }
  },
  "variants": [{
   "small": {
    "url": "https://m.media-amazon.com/images/I/51CjYz4iQHL._SL75_.jpg",
    "height": 75,
    "width": 75
   }
  }, ...]
 }
}
```

### Example 3

Get all images of an item, in all sizes.

#### Request Payload

Copy

```
{
    "associateTag": "xyz-20",
    "itemIds": ["B00TSUGXKE"],
    "resources": ["images.primary.small", "images.primary.medium", "images.primary.large", "images.variants.small", "images.variants.medium", "images.variants.large"]
}
```

#### Response

Copy

```
{
 "asin": "B00TSUGXKE",
 "images": {
  "primary": {
   "small": {
    "url": "https://m.media-amazon.com/images/I/41FYkVPzrIL._SL75_.jpg",
    "height": 75,
    "width": 75
   },
   "medium": {
    "url": "https://m.media-amazon.com/images/I/41FYkVPzrIL._SL160_.jpg",
    "height": 160,
    "width": 160
   },
   "large": {
    "url": "https://m.media-amazon.com/images/I/41FYkVPzrIL.jpg",
    "height": 500,
    "width": 500
   }
  },
  "variants": [{
   "small": {
    "url": "https://m.media-amazon.com/images/I/51CjYz4iQHL._SL75_.jpg",
    "height": 75,
    "width": 75
   },
   "medium": {
    "url": "https://m.media-amazon.com/images/I/51CjYz4iQHL._SL160_.jpg",
    "height": 160,
    "width": 160
   },
   "large": {
    "url": "https://m.media-amazon.com/images/I/51CjYz4iQHL.jpg",
    "height": 500,
    "width": 500
   }
  }, ...]
 }
}
```

## Images

Source: `_creatorsapi_docs_en-us_api-reference_resources_images#imagetype-response-element.html`

# Images

The Images resources returns the URLs for all available images of an item in three sizes: `Small`, `Medium`, and `Large`. For example, if a Kindle has four images, the images resources returns the URLs of 12 images: four images, each in three sizes.

In addition to returning the image URLs, these resources also return the height and width dimensions of each image. Use these values to display the images correctly.

## Availability

All locales.

## Response Elements

Name

Description

Primary

Container for Primary Images. The container includes Large, Medium, and Small Image Sizes as per the resources requested. Each of the image size contains three values: URL, Height, and Width of the image. For more information, refer [ImageType Response Element](./_creatorsapi_docs_en-us_api-reference_resources_images#imagetype-response-element.md)

Variants

Container for Variants Images. The container includes Large, Medium, and Small Image Sizes as per the resources requested. Each of the image size contains three values: URL, Height, and Width of the image. For more information, refer [ImageType Response Element](./_creatorsapi_docs_en-us_api-reference_resources_images#imagetype-response-element.md)

#### ImageType Response Element

The structure of ImageType (Primary / Variants) container inside the high level Images Resource is as follows:

Copy

```
{
  "imageType": {
    "imageSize": {
      "url": "Image URL",
      "height": "Number representing width of the image",
      "width": "Number representing height of the image"
    }
  }
}
```

-   Each of the `ImageType` (Primary / Variant) can contain three sub-resources: Small, Medium, and Large.
-   Each of the `ImageSize` (Small / Medium / Large) contains three values: URL, Height, and Width of the image.

> The `Primary` image denotes the image which is displayed in search results and on the detail page. **Variants** include everything else. The sizes of the images are specified by the `_SLXXX_` suffix in the URL, where `XXX` is the number of pixels on the longest side of the image. For example, a medium size image has 160 pixels on its longest side, so it has the suffix `_SL160_`. This is the preferred way to reference images.

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Resources

Add the resource name in the request payload to get the corresponding data in the API response.

Name

Description

images.primary.small

Get the primary image of an item in small size.

images.primary.medium

Get the primary image of an item in medium size.

images.primary.large

Get the primary image of an item in large size.

images.variants.small

Get the variant images of an item in small size.

images.variants.medium

Get the variant images of an item in medium size.

images.variants.large

Get the variant images of an item in large size.

## Sample Use Cases

### Example 1

Get the primary image of an item, in large size.

#### Request Payload

Copy

```
{
    "associateTag": "xyz-20",
    "itemIds": ["B00TSUGXKE"],
    "resources": ["images.primary.large"]
}
```

#### Response

Copy

```
{
 "asin": "B00TSUGXKE",
 "images": {
  "primary": {
   "large": {
    "url": "https://m.media-amazon.com/images/I/41FYkVPzrIL.jpg",
    "height": 500,
    "width": 500
   }
  }
 }
}
```

### Example 2

Get the primary image of an item in large size, and variant images in small size.

#### Request Payload

Copy

```
{
    "associateTag": "xyz-20",
    "itemIds": ["B00TSUGXKE"],
    "resources": ["images.primary.large", "images.variants.small"]
}
```

#### Response

Copy

```
{
 "asin": "B00TSUGXKE",
 "images": {
  "primary": {
   "large": {
    "url": "https://m.media-amazon.com/images/I/41FYkVPzrIL.jpg",
    "height": 500,
    "width": 500
   }
  },
  "variants": [{
   "small": {
    "url": "https://m.media-amazon.com/images/I/51CjYz4iQHL._SL75_.jpg",
    "height": 75,
    "width": 75
   }
  }, ...]
 }
}
```

### Example 3

Get all images of an item, in all sizes.

#### Request Payload

Copy

```
{
    "associateTag": "xyz-20",
    "itemIds": ["B00TSUGXKE"],
    "resources": ["images.primary.small", "images.primary.medium", "images.primary.large", "images.variants.small", "images.variants.medium", "images.variants.large"]
}
```

#### Response

Copy

```
{
 "asin": "B00TSUGXKE",
 "images": {
  "primary": {
   "small": {
    "url": "https://m.media-amazon.com/images/I/41FYkVPzrIL._SL75_.jpg",
    "height": 75,
    "width": 75
   },
   "medium": {
    "url": "https://m.media-amazon.com/images/I/41FYkVPzrIL._SL160_.jpg",
    "height": 160,
    "width": 160
   },
   "large": {
    "url": "https://m.media-amazon.com/images/I/41FYkVPzrIL.jpg",
    "height": 500,
    "width": 500
   }
  },
  "variants": [{
   "small": {
    "url": "https://m.media-amazon.com/images/I/51CjYz4iQHL._SL75_.jpg",
    "height": 75,
    "width": 75
   },
   "medium": {
    "url": "https://m.media-amazon.com/images/I/51CjYz4iQHL._SL160_.jpg",
    "height": 160,
    "width": 160
   },
   "large": {
    "url": "https://m.media-amazon.com/images/I/51CjYz4iQHL.jpg",
    "height": 500,
    "width": 500
   }
  }, ...]
 }
}
```

## ItemInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_item-info.html`

# ItemInfo

## Description

The `ItemInfo` high level resource is a collection of large number of attributes logically grouped into a resource. i.e. ItemInfo is a collection of resources where each resource contains several attributes.

## Availability

All locales. However, the attributes returned varies with locale and the category of the item.

#### ItemInfo Container

The structure of attribute container inside the high level ItemInfo Resource is as follows:

Copy

```
{
  "itemInfoResource": {
    "attributeName": {
      "displayValue": "The display value of the particular attribute",
      "label": "The attribute name in the specified locale",
      "locale": "The locale in which the attribute is returned"
    }
  }
}
```

## Response Elements

Resource Name

Description

[ByLineInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#bylineinfo.md)

Set of attributes that specifies basic information of the product.

[Classifications](./_creatorsapi_docs_en-us_api-reference_resources_item-info#classifications.md)

Set of attributes that are used to classify an item into a particular category.

[ContentInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentinfo.md)

Set of attributes that are specific to the content like books, movies.

[Content Rating](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentrating.md)

Set of attributes that tell what age group is suitable to view said media.

[ExternalIds](./_creatorsapi_docs_en-us_api-reference_resources_item-info#externalids.md)

Set of identifiers that is used globally to identify a particular product.

[Features](./_creatorsapi_docs_en-us_api-reference_resources_item-info#features.md)

This attribute provides information about a product's key features.

[ManufactureInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#manufactureinfo.md)

Set of attributes that specifies manufacturing related information of an item

[ProductInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#productinfo.md)

Set of attributes that describes non-technical aspects of the item.

[TechnicalInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#technicalinfo.md)

Set of attributes that describes the technical aspects of the item.

[Title](./_creatorsapi_docs_en-us_api-reference_resources_item-info#title.md)

The title of the product.

[TradeInInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#tradeininfo.md)

Set of attributes that specifies trade-in information of an item.

### ByLineInfo

Attribute Name

Description

Brand

This attribute represents the brand of the item.

Contributors

This attribute represents the Contributors associated with the item. Use the `RoleType` parameter to filter by different types of role like `author`, `actor`, `director` etc.

Manufacturer

This attribute represents the Manufacturer of the item.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "byLineInfo": {
            "brand": {
                "displayValue": "West Bend",
                "label": "Brand",
                "locale": "en_US"
            },
            "manufacturer": {
                "displayValue": "Focus Electrics, LLC",
                "label": "Manufacturer",
                "locale": "en_US"
            },
            "contributors": [
                {
                    "locale": "de_DE",
                    "name": "Daniel Radcliffe",
                    "role": "Darsteller",
                    "roleType": "actor"
                },
                {
                    "locale": "en_US",
                    "name": "Rupert Grint",
                    "role": "Director",
                    "roleType": "director"
                }
            ]
        }
    }
}
```

### Classifications

Attribute Name

Description

Binding

Typically (but not always) similar to the product category.

ProductGroup

This attribute represents the product category an item belongs to. The name of a category, such as sporting goods, to which an item in the cart belongs.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "classifications": {
            "binding": {
                "displayValue": "Amazon Video",
                "label": "Binding",
                "locale": "en_GB"
            },
            "productGroup": {
                "displayValue": "Video On Demand",
                "label": "ProductGroup",
                "locale": "en_GB"
            }
        }
    }
}
```

### ContentInfo

Attribute Name

Description

Edition

This attribute represents edition or the version of the product.

Languages

This attribute represents languages associated with the product

PagesCount

This attribute represents the number of pages.

PublicationDate

This attribute represents the date of publication of the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentInfo": {
            "edition": {
                "displayValue": "Slp",
                "label": "Edition",
                "locale": "en_US"
            },
            "languages": {
                "displayValues": [
                    {
                        "displayValue": "English",
                        "type": "Published"
                    },
                    {
                        "displayValue": "English",
                        "type": "Dictionary"
                    }
                ],
                "label": "Language",
                "locale": "en_GB"
            },
            "pagesCount": {
                "displayValue": 4167,
                "label": "NumberOfPages",
                "locale": "en_US"
            },
            "publicationDate": {
                "displayValue": "2009-07-01T00:00:01Z",
                "label": "PublicationDate",
                "locale": "en_US"
            }
        }
    }
}
```

### ContentRating

Attribute Name

Description

AudienceRating

Audience rating for a movie. The rating suggests the age for which the movie is appropriate.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentRating": {
            "audienceRating": {
                "displayValue": "PG (Parental Guidance Suggested)",
                "label": "AudienceRating",
                "locale": "en_GB"
            }
        }
    }
}
```

### ExternalIds

Attribute Name

Description

EANs

European Article Number, which is a number that uniquely identifies an item.

ISBNs

The international standard book number associated with the product, consisting of a 10-digit alphanumeric string

UPCs

12-digit number found below the product's bar code

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "externalIds": {
            "eans": {
                "displayValues": [
                    "9780545162074",
                    "0717356278525"
                ],
                "label": "EAN",
                "locale": "en_US"
            },
            "isbns": {
                "displayValues": [
                    "0545162076"
                ],
                "label": "ISBN",
                "locale": "en_US"
            },
            "upcs": {
                "displayValues": [
                    "717356278525"
                ],
                "label": "UPC",
                "locale": "en_US"
            }
        }
    }
}
```

### Features

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "features": {
            "label": "Features",
            "locale": "en_US",
            "displayValues": [
                "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
                "Stir rod is motorized and improves popping, get more popped corn, larger kernels per batch",
                "Convenient nesting lid is ideal for small storage"
            ]
        }
    }
}
```

### ManufactureInfo

Attribute Name

Description

ItemPartNumber

This attribute represents the item's part number, which is sometimes the same as the model number

Model

This attribute represents the item's model name

Warranty

This attribute represents information related to the warranty provided for the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "manufactureInfo": {
            "itemPartNumber": {
                "displayValue": "MG4H2B/A",
                "label": "PartNumber",
                "locale": "en_US"
            },
            "model": {
                "displayValue": "6",
                "label": "Model",
                "locale": "en_US"
            },
            "warranty": {
                "displayValue": "No Manufacturer Warranty for this phone.",
                "label": "Warranty",
                "locale": "en_US"
            }
        }
    }
}
```

### ProductInfo

Attribute Name

Description

Color

This attribute indicates the color of the product

IsAdultProduct

Indicates if the product is considered to be for adults only.

ItemDimensions

Height, Length, Weight, and Width of the item.

ReleaseDate

Date on which the item was latest released

Size

This attribute provides information related to the size of the item

UnitCount

This attribute represents the total number of identical items that are in the selling unit.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "productInfo": {
            "color": {
                "displayValue": "brown trunk",
                "label": "Color",
                "locale": "en_US"
            },
            "isAdultProduct": {
                "displayValue": false,
                "label": "IsAdultProduct",
                "locale": "en_US"
            },
            "itemDimensions": {
                "height": {
                    "displayValue": 13.9,
                    "label": "Height",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "length": {
                    "displayValue": 18,
                    "label": "Length",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "weight": {
                    "displayValue": 20,
                    "label": "Weight",
                    "locale": "en_GB",
                    "unit": "Pounds"
                },
                "width": {
                    "displayValue": 7.7,
                    "label": "Width",
                    "locale": "en_GB",
                    "unit": "inches"
                }
            },
            "releaseDate": {
                "displayValue": "2013-03-01T00:00:00.000Z",
                "label": "ReleaseDate",
                "locale": "en_US"
            },
            "size": {
                "displayValue": "Small",
                "label": "Size",
                "locale": "en_US"
            },
            "unitCount": {
                "displayValue": 1,
                "label": "NumberOfItems",
                "locale": "en_US"
            }
        }
    }
}
```

### TechnicalInfo

Attribute Name

Description

Formats

Formats is used in various ways depending on the category to assist in describing an item. Format can be 4K, Blu-Ray, etc for Video, Kindle,PaperBack for books and so on

EnergyEfficiencyClass

Energy efficiency of the product. It can have various values based on the product’s type.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "formats": {
                "displayValues": [
                    "Box set"
                ],
                "label": "Format",
                "locale": "en_GB"
            }
        }
    }
}
```

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "energyEfficiencyClass": {
                "displayValue": "a_plus",
                "label": "EnergyEfficiencyClass",
                "locale": "en_GB"
            }
        }
    }
}
```

### Title

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
        }
    }
}
```

### TradeInInfo

Attribute Name

Description

IsEligibleForTradeIn

Specifies whether or not the item is eligible for trade-in.

Price

Specifies trade-in price of the item. This includes amount, currency and display amount of the trade-in price.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
                 "amount": 24.05,
                 "currency": "USD",
                 "displayAmount": "$24.05"
            }
        }
    }
}
```

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Sample Use Cases

### Example 1

Get the title of an item in default locale.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          }
        }
      }
    ]
  }
}
```

### Example 2

Get the title of the product in preferred language of preference.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["8424916514"],
    "languagesOfPreference": ["es_US"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "8424916514",
        "detailPageURL": "https://www.amazon.com/dp/8424916514?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Descripcion de Grecia / Description of Greece: Libros I-ii (Spanish Edition)",
            "label": "Title",
            "locale": "es_US"
          }
        }
      }
    ]
  }
}
```

### Example 3

Get all the attributes related to an item.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": [
        "itemInfo.byLineInfo",
        "itemInfo.contentInfo",
        "itemInfo.contentRating",
        "itemInfo.classifications",
        "itemInfo.externalIds",
        "itemInfo.features",
        "itemInfo.manufactureInfo",
        "itemInfo.productInfo",
        "itemInfo.technicalInfo",
        "itemInfo.title",
        "itemInfo.tradeInInfo"
    ]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "byLineInfo": {
            "brand": {
              "displayValue": "West Bend",
              "label": "Brand",
              "locale": "en_US"
            },
            "manufacturer": {
              "displayValue": "West Bend",
              "label": "Manufacturer",
              "locale": "en_US"
            }
          },
          "classifications": {
            "binding": {
              "displayValue": "Cocina",
              "label": "Binding",
              "locale": "es_US"
            },
            "productGroup": {
              "displayValue": "Cocina",
              "label": "ProductGroup",
              "locale": "es_US"
            }
          },
          "contentInfo": {
            "edition": {
              "displayValue": "Slp",
              "label": "Edition",
              "locale": "en_US"
            }
          },
          "contentRating": {
            "audienceRating": {
              "displayValue": "PG (Parental Guidance Suggested)",
              "label": "AudienceRating",
              "locale": "en_GB"
            }
          },
          "externalIds": {
            "eans": {
              "displayValues": [
                "0784331985907",
                "6689306520104"
              ],
              "label": "EAN",
              "locale": "en_US"
            },
            "upcs": {
              "displayValues": [
                "885330102972",
                "072244825053"
              ],
              "label": "UPC",
              "locale": "en_US"
            }
          },
          "features": {
            "displayValues": [
              "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
              "Plate is nonstick Coated for easy clean up"
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": {
            "itemPartNumber": {
              "displayValue": "82505",
              "label": "PartNumber",
              "locale": "en_US"
            },
            "model": {
              "displayValue": "82505",
              "label": "Model",
              "locale": "en_US"
            }
          },
          "productInfo": {
            "color": {
              "displayValue": "Red",
              "label": "Color",
              "locale": "en_US"
            },
            "itemDimensions": {
              "height": {
                "displayValue": 10,
                "label": "Height",
                "locale": "en_US",
                "unit": "inches"
              },
              "length": {
                "displayValue": 10,
                "label": "Length",
                "locale": "en_US",
                "unit": "inches"
              },
              "weight": {
                "displayValue": 3.35,
                "label": "Weight",
                "locale": "en_US",
                "unit": "pounds"
              },
              "width": {
                "displayValue": 13,
                "label": "Width",
                "locale": "en_US",
                "unit": "inches"
              }
            },
            "size": {
              "displayValue": "Stir Crazy",
              "label": "Size",
              "locale": "en_US"
            },
            "unitCount": {
              "displayValue": 1,
              "label": "NumberOfItems",
              "locale": "en_US"
            }
          },
          "technicalInfo": {
            "formats": {
              "displayValues": [
                "Box set"
              ],
              "label": "Format",
              "locale": "en_GB"
            }
          },
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
              "amount": 24.05,
              "currency": "USD",
              "displayAmount": "$24.05"
            }
          }
        }
      }
    ]
  }
}
```

## ItemInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_item-info#bylineinfo.html`

# ItemInfo

## Description

The `ItemInfo` high level resource is a collection of large number of attributes logically grouped into a resource. i.e. ItemInfo is a collection of resources where each resource contains several attributes.

## Availability

All locales. However, the attributes returned varies with locale and the category of the item.

#### ItemInfo Container

The structure of attribute container inside the high level ItemInfo Resource is as follows:

Copy

```
{
  "itemInfoResource": {
    "attributeName": {
      "displayValue": "The display value of the particular attribute",
      "label": "The attribute name in the specified locale",
      "locale": "The locale in which the attribute is returned"
    }
  }
}
```

## Response Elements

Resource Name

Description

[ByLineInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#bylineinfo.md)

Set of attributes that specifies basic information of the product.

[Classifications](./_creatorsapi_docs_en-us_api-reference_resources_item-info#classifications.md)

Set of attributes that are used to classify an item into a particular category.

[ContentInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentinfo.md)

Set of attributes that are specific to the content like books, movies.

[Content Rating](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentrating.md)

Set of attributes that tell what age group is suitable to view said media.

[ExternalIds](./_creatorsapi_docs_en-us_api-reference_resources_item-info#externalids.md)

Set of identifiers that is used globally to identify a particular product.

[Features](./_creatorsapi_docs_en-us_api-reference_resources_item-info#features.md)

This attribute provides information about a product's key features.

[ManufactureInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#manufactureinfo.md)

Set of attributes that specifies manufacturing related information of an item

[ProductInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#productinfo.md)

Set of attributes that describes non-technical aspects of the item.

[TechnicalInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#technicalinfo.md)

Set of attributes that describes the technical aspects of the item.

[Title](./_creatorsapi_docs_en-us_api-reference_resources_item-info#title.md)

The title of the product.

[TradeInInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#tradeininfo.md)

Set of attributes that specifies trade-in information of an item.

### ByLineInfo

Attribute Name

Description

Brand

This attribute represents the brand of the item.

Contributors

This attribute represents the Contributors associated with the item. Use the `RoleType` parameter to filter by different types of role like `author`, `actor`, `director` etc.

Manufacturer

This attribute represents the Manufacturer of the item.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "byLineInfo": {
            "brand": {
                "displayValue": "West Bend",
                "label": "Brand",
                "locale": "en_US"
            },
            "manufacturer": {
                "displayValue": "Focus Electrics, LLC",
                "label": "Manufacturer",
                "locale": "en_US"
            },
            "contributors": [
                {
                    "locale": "de_DE",
                    "name": "Daniel Radcliffe",
                    "role": "Darsteller",
                    "roleType": "actor"
                },
                {
                    "locale": "en_US",
                    "name": "Rupert Grint",
                    "role": "Director",
                    "roleType": "director"
                }
            ]
        }
    }
}
```

### Classifications

Attribute Name

Description

Binding

Typically (but not always) similar to the product category.

ProductGroup

This attribute represents the product category an item belongs to. The name of a category, such as sporting goods, to which an item in the cart belongs.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "classifications": {
            "binding": {
                "displayValue": "Amazon Video",
                "label": "Binding",
                "locale": "en_GB"
            },
            "productGroup": {
                "displayValue": "Video On Demand",
                "label": "ProductGroup",
                "locale": "en_GB"
            }
        }
    }
}
```

### ContentInfo

Attribute Name

Description

Edition

This attribute represents edition or the version of the product.

Languages

This attribute represents languages associated with the product

PagesCount

This attribute represents the number of pages.

PublicationDate

This attribute represents the date of publication of the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentInfo": {
            "edition": {
                "displayValue": "Slp",
                "label": "Edition",
                "locale": "en_US"
            },
            "languages": {
                "displayValues": [
                    {
                        "displayValue": "English",
                        "type": "Published"
                    },
                    {
                        "displayValue": "English",
                        "type": "Dictionary"
                    }
                ],
                "label": "Language",
                "locale": "en_GB"
            },
            "pagesCount": {
                "displayValue": 4167,
                "label": "NumberOfPages",
                "locale": "en_US"
            },
            "publicationDate": {
                "displayValue": "2009-07-01T00:00:01Z",
                "label": "PublicationDate",
                "locale": "en_US"
            }
        }
    }
}
```

### ContentRating

Attribute Name

Description

AudienceRating

Audience rating for a movie. The rating suggests the age for which the movie is appropriate.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentRating": {
            "audienceRating": {
                "displayValue": "PG (Parental Guidance Suggested)",
                "label": "AudienceRating",
                "locale": "en_GB"
            }
        }
    }
}
```

### ExternalIds

Attribute Name

Description

EANs

European Article Number, which is a number that uniquely identifies an item.

ISBNs

The international standard book number associated with the product, consisting of a 10-digit alphanumeric string

UPCs

12-digit number found below the product's bar code

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "externalIds": {
            "eans": {
                "displayValues": [
                    "9780545162074",
                    "0717356278525"
                ],
                "label": "EAN",
                "locale": "en_US"
            },
            "isbns": {
                "displayValues": [
                    "0545162076"
                ],
                "label": "ISBN",
                "locale": "en_US"
            },
            "upcs": {
                "displayValues": [
                    "717356278525"
                ],
                "label": "UPC",
                "locale": "en_US"
            }
        }
    }
}
```

### Features

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "features": {
            "label": "Features",
            "locale": "en_US",
            "displayValues": [
                "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
                "Stir rod is motorized and improves popping, get more popped corn, larger kernels per batch",
                "Convenient nesting lid is ideal for small storage"
            ]
        }
    }
}
```

### ManufactureInfo

Attribute Name

Description

ItemPartNumber

This attribute represents the item's part number, which is sometimes the same as the model number

Model

This attribute represents the item's model name

Warranty

This attribute represents information related to the warranty provided for the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "manufactureInfo": {
            "itemPartNumber": {
                "displayValue": "MG4H2B/A",
                "label": "PartNumber",
                "locale": "en_US"
            },
            "model": {
                "displayValue": "6",
                "label": "Model",
                "locale": "en_US"
            },
            "warranty": {
                "displayValue": "No Manufacturer Warranty for this phone.",
                "label": "Warranty",
                "locale": "en_US"
            }
        }
    }
}
```

### ProductInfo

Attribute Name

Description

Color

This attribute indicates the color of the product

IsAdultProduct

Indicates if the product is considered to be for adults only.

ItemDimensions

Height, Length, Weight, and Width of the item.

ReleaseDate

Date on which the item was latest released

Size

This attribute provides information related to the size of the item

UnitCount

This attribute represents the total number of identical items that are in the selling unit.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "productInfo": {
            "color": {
                "displayValue": "brown trunk",
                "label": "Color",
                "locale": "en_US"
            },
            "isAdultProduct": {
                "displayValue": false,
                "label": "IsAdultProduct",
                "locale": "en_US"
            },
            "itemDimensions": {
                "height": {
                    "displayValue": 13.9,
                    "label": "Height",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "length": {
                    "displayValue": 18,
                    "label": "Length",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "weight": {
                    "displayValue": 20,
                    "label": "Weight",
                    "locale": "en_GB",
                    "unit": "Pounds"
                },
                "width": {
                    "displayValue": 7.7,
                    "label": "Width",
                    "locale": "en_GB",
                    "unit": "inches"
                }
            },
            "releaseDate": {
                "displayValue": "2013-03-01T00:00:00.000Z",
                "label": "ReleaseDate",
                "locale": "en_US"
            },
            "size": {
                "displayValue": "Small",
                "label": "Size",
                "locale": "en_US"
            },
            "unitCount": {
                "displayValue": 1,
                "label": "NumberOfItems",
                "locale": "en_US"
            }
        }
    }
}
```

### TechnicalInfo

Attribute Name

Description

Formats

Formats is used in various ways depending on the category to assist in describing an item. Format can be 4K, Blu-Ray, etc for Video, Kindle,PaperBack for books and so on

EnergyEfficiencyClass

Energy efficiency of the product. It can have various values based on the product’s type.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "formats": {
                "displayValues": [
                    "Box set"
                ],
                "label": "Format",
                "locale": "en_GB"
            }
        }
    }
}
```

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "energyEfficiencyClass": {
                "displayValue": "a_plus",
                "label": "EnergyEfficiencyClass",
                "locale": "en_GB"
            }
        }
    }
}
```

### Title

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
        }
    }
}
```

### TradeInInfo

Attribute Name

Description

IsEligibleForTradeIn

Specifies whether or not the item is eligible for trade-in.

Price

Specifies trade-in price of the item. This includes amount, currency and display amount of the trade-in price.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
                 "amount": 24.05,
                 "currency": "USD",
                 "displayAmount": "$24.05"
            }
        }
    }
}
```

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Sample Use Cases

### Example 1

Get the title of an item in default locale.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          }
        }
      }
    ]
  }
}
```

### Example 2

Get the title of the product in preferred language of preference.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["8424916514"],
    "languagesOfPreference": ["es_US"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "8424916514",
        "detailPageURL": "https://www.amazon.com/dp/8424916514?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Descripcion de Grecia / Description of Greece: Libros I-ii (Spanish Edition)",
            "label": "Title",
            "locale": "es_US"
          }
        }
      }
    ]
  }
}
```

### Example 3

Get all the attributes related to an item.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": [
        "itemInfo.byLineInfo",
        "itemInfo.contentInfo",
        "itemInfo.contentRating",
        "itemInfo.classifications",
        "itemInfo.externalIds",
        "itemInfo.features",
        "itemInfo.manufactureInfo",
        "itemInfo.productInfo",
        "itemInfo.technicalInfo",
        "itemInfo.title",
        "itemInfo.tradeInInfo"
    ]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "byLineInfo": {
            "brand": {
              "displayValue": "West Bend",
              "label": "Brand",
              "locale": "en_US"
            },
            "manufacturer": {
              "displayValue": "West Bend",
              "label": "Manufacturer",
              "locale": "en_US"
            }
          },
          "classifications": {
            "binding": {
              "displayValue": "Cocina",
              "label": "Binding",
              "locale": "es_US"
            },
            "productGroup": {
              "displayValue": "Cocina",
              "label": "ProductGroup",
              "locale": "es_US"
            }
          },
          "contentInfo": {
            "edition": {
              "displayValue": "Slp",
              "label": "Edition",
              "locale": "en_US"
            }
          },
          "contentRating": {
            "audienceRating": {
              "displayValue": "PG (Parental Guidance Suggested)",
              "label": "AudienceRating",
              "locale": "en_GB"
            }
          },
          "externalIds": {
            "eans": {
              "displayValues": [
                "0784331985907",
                "6689306520104"
              ],
              "label": "EAN",
              "locale": "en_US"
            },
            "upcs": {
              "displayValues": [
                "885330102972",
                "072244825053"
              ],
              "label": "UPC",
              "locale": "en_US"
            }
          },
          "features": {
            "displayValues": [
              "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
              "Plate is nonstick Coated for easy clean up"
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": {
            "itemPartNumber": {
              "displayValue": "82505",
              "label": "PartNumber",
              "locale": "en_US"
            },
            "model": {
              "displayValue": "82505",
              "label": "Model",
              "locale": "en_US"
            }
          },
          "productInfo": {
            "color": {
              "displayValue": "Red",
              "label": "Color",
              "locale": "en_US"
            },
            "itemDimensions": {
              "height": {
                "displayValue": 10,
                "label": "Height",
                "locale": "en_US",
                "unit": "inches"
              },
              "length": {
                "displayValue": 10,
                "label": "Length",
                "locale": "en_US",
                "unit": "inches"
              },
              "weight": {
                "displayValue": 3.35,
                "label": "Weight",
                "locale": "en_US",
                "unit": "pounds"
              },
              "width": {
                "displayValue": 13,
                "label": "Width",
                "locale": "en_US",
                "unit": "inches"
              }
            },
            "size": {
              "displayValue": "Stir Crazy",
              "label": "Size",
              "locale": "en_US"
            },
            "unitCount": {
              "displayValue": 1,
              "label": "NumberOfItems",
              "locale": "en_US"
            }
          },
          "technicalInfo": {
            "formats": {
              "displayValues": [
                "Box set"
              ],
              "label": "Format",
              "locale": "en_GB"
            }
          },
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
              "amount": 24.05,
              "currency": "USD",
              "displayAmount": "$24.05"
            }
          }
        }
      }
    ]
  }
}
```

## ItemInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_item-info#classifications.html`

# ItemInfo

## Description

The `ItemInfo` high level resource is a collection of large number of attributes logically grouped into a resource. i.e. ItemInfo is a collection of resources where each resource contains several attributes.

## Availability

All locales. However, the attributes returned varies with locale and the category of the item.

#### ItemInfo Container

The structure of attribute container inside the high level ItemInfo Resource is as follows:

Copy

```
{
  "itemInfoResource": {
    "attributeName": {
      "displayValue": "The display value of the particular attribute",
      "label": "The attribute name in the specified locale",
      "locale": "The locale in which the attribute is returned"
    }
  }
}
```

## Response Elements

Resource Name

Description

[ByLineInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#bylineinfo.md)

Set of attributes that specifies basic information of the product.

[Classifications](./_creatorsapi_docs_en-us_api-reference_resources_item-info#classifications.md)

Set of attributes that are used to classify an item into a particular category.

[ContentInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentinfo.md)

Set of attributes that are specific to the content like books, movies.

[Content Rating](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentrating.md)

Set of attributes that tell what age group is suitable to view said media.

[ExternalIds](./_creatorsapi_docs_en-us_api-reference_resources_item-info#externalids.md)

Set of identifiers that is used globally to identify a particular product.

[Features](./_creatorsapi_docs_en-us_api-reference_resources_item-info#features.md)

This attribute provides information about a product's key features.

[ManufactureInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#manufactureinfo.md)

Set of attributes that specifies manufacturing related information of an item

[ProductInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#productinfo.md)

Set of attributes that describes non-technical aspects of the item.

[TechnicalInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#technicalinfo.md)

Set of attributes that describes the technical aspects of the item.

[Title](./_creatorsapi_docs_en-us_api-reference_resources_item-info#title.md)

The title of the product.

[TradeInInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#tradeininfo.md)

Set of attributes that specifies trade-in information of an item.

### ByLineInfo

Attribute Name

Description

Brand

This attribute represents the brand of the item.

Contributors

This attribute represents the Contributors associated with the item. Use the `RoleType` parameter to filter by different types of role like `author`, `actor`, `director` etc.

Manufacturer

This attribute represents the Manufacturer of the item.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "byLineInfo": {
            "brand": {
                "displayValue": "West Bend",
                "label": "Brand",
                "locale": "en_US"
            },
            "manufacturer": {
                "displayValue": "Focus Electrics, LLC",
                "label": "Manufacturer",
                "locale": "en_US"
            },
            "contributors": [
                {
                    "locale": "de_DE",
                    "name": "Daniel Radcliffe",
                    "role": "Darsteller",
                    "roleType": "actor"
                },
                {
                    "locale": "en_US",
                    "name": "Rupert Grint",
                    "role": "Director",
                    "roleType": "director"
                }
            ]
        }
    }
}
```

### Classifications

Attribute Name

Description

Binding

Typically (but not always) similar to the product category.

ProductGroup

This attribute represents the product category an item belongs to. The name of a category, such as sporting goods, to which an item in the cart belongs.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "classifications": {
            "binding": {
                "displayValue": "Amazon Video",
                "label": "Binding",
                "locale": "en_GB"
            },
            "productGroup": {
                "displayValue": "Video On Demand",
                "label": "ProductGroup",
                "locale": "en_GB"
            }
        }
    }
}
```

### ContentInfo

Attribute Name

Description

Edition

This attribute represents edition or the version of the product.

Languages

This attribute represents languages associated with the product

PagesCount

This attribute represents the number of pages.

PublicationDate

This attribute represents the date of publication of the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentInfo": {
            "edition": {
                "displayValue": "Slp",
                "label": "Edition",
                "locale": "en_US"
            },
            "languages": {
                "displayValues": [
                    {
                        "displayValue": "English",
                        "type": "Published"
                    },
                    {
                        "displayValue": "English",
                        "type": "Dictionary"
                    }
                ],
                "label": "Language",
                "locale": "en_GB"
            },
            "pagesCount": {
                "displayValue": 4167,
                "label": "NumberOfPages",
                "locale": "en_US"
            },
            "publicationDate": {
                "displayValue": "2009-07-01T00:00:01Z",
                "label": "PublicationDate",
                "locale": "en_US"
            }
        }
    }
}
```

### ContentRating

Attribute Name

Description

AudienceRating

Audience rating for a movie. The rating suggests the age for which the movie is appropriate.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentRating": {
            "audienceRating": {
                "displayValue": "PG (Parental Guidance Suggested)",
                "label": "AudienceRating",
                "locale": "en_GB"
            }
        }
    }
}
```

### ExternalIds

Attribute Name

Description

EANs

European Article Number, which is a number that uniquely identifies an item.

ISBNs

The international standard book number associated with the product, consisting of a 10-digit alphanumeric string

UPCs

12-digit number found below the product's bar code

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "externalIds": {
            "eans": {
                "displayValues": [
                    "9780545162074",
                    "0717356278525"
                ],
                "label": "EAN",
                "locale": "en_US"
            },
            "isbns": {
                "displayValues": [
                    "0545162076"
                ],
                "label": "ISBN",
                "locale": "en_US"
            },
            "upcs": {
                "displayValues": [
                    "717356278525"
                ],
                "label": "UPC",
                "locale": "en_US"
            }
        }
    }
}
```

### Features

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "features": {
            "label": "Features",
            "locale": "en_US",
            "displayValues": [
                "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
                "Stir rod is motorized and improves popping, get more popped corn, larger kernels per batch",
                "Convenient nesting lid is ideal for small storage"
            ]
        }
    }
}
```

### ManufactureInfo

Attribute Name

Description

ItemPartNumber

This attribute represents the item's part number, which is sometimes the same as the model number

Model

This attribute represents the item's model name

Warranty

This attribute represents information related to the warranty provided for the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "manufactureInfo": {
            "itemPartNumber": {
                "displayValue": "MG4H2B/A",
                "label": "PartNumber",
                "locale": "en_US"
            },
            "model": {
                "displayValue": "6",
                "label": "Model",
                "locale": "en_US"
            },
            "warranty": {
                "displayValue": "No Manufacturer Warranty for this phone.",
                "label": "Warranty",
                "locale": "en_US"
            }
        }
    }
}
```

### ProductInfo

Attribute Name

Description

Color

This attribute indicates the color of the product

IsAdultProduct

Indicates if the product is considered to be for adults only.

ItemDimensions

Height, Length, Weight, and Width of the item.

ReleaseDate

Date on which the item was latest released

Size

This attribute provides information related to the size of the item

UnitCount

This attribute represents the total number of identical items that are in the selling unit.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "productInfo": {
            "color": {
                "displayValue": "brown trunk",
                "label": "Color",
                "locale": "en_US"
            },
            "isAdultProduct": {
                "displayValue": false,
                "label": "IsAdultProduct",
                "locale": "en_US"
            },
            "itemDimensions": {
                "height": {
                    "displayValue": 13.9,
                    "label": "Height",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "length": {
                    "displayValue": 18,
                    "label": "Length",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "weight": {
                    "displayValue": 20,
                    "label": "Weight",
                    "locale": "en_GB",
                    "unit": "Pounds"
                },
                "width": {
                    "displayValue": 7.7,
                    "label": "Width",
                    "locale": "en_GB",
                    "unit": "inches"
                }
            },
            "releaseDate": {
                "displayValue": "2013-03-01T00:00:00.000Z",
                "label": "ReleaseDate",
                "locale": "en_US"
            },
            "size": {
                "displayValue": "Small",
                "label": "Size",
                "locale": "en_US"
            },
            "unitCount": {
                "displayValue": 1,
                "label": "NumberOfItems",
                "locale": "en_US"
            }
        }
    }
}
```

### TechnicalInfo

Attribute Name

Description

Formats

Formats is used in various ways depending on the category to assist in describing an item. Format can be 4K, Blu-Ray, etc for Video, Kindle,PaperBack for books and so on

EnergyEfficiencyClass

Energy efficiency of the product. It can have various values based on the product’s type.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "formats": {
                "displayValues": [
                    "Box set"
                ],
                "label": "Format",
                "locale": "en_GB"
            }
        }
    }
}
```

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "energyEfficiencyClass": {
                "displayValue": "a_plus",
                "label": "EnergyEfficiencyClass",
                "locale": "en_GB"
            }
        }
    }
}
```

### Title

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
        }
    }
}
```

### TradeInInfo

Attribute Name

Description

IsEligibleForTradeIn

Specifies whether or not the item is eligible for trade-in.

Price

Specifies trade-in price of the item. This includes amount, currency and display amount of the trade-in price.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
                 "amount": 24.05,
                 "currency": "USD",
                 "displayAmount": "$24.05"
            }
        }
    }
}
```

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Sample Use Cases

### Example 1

Get the title of an item in default locale.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          }
        }
      }
    ]
  }
}
```

### Example 2

Get the title of the product in preferred language of preference.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["8424916514"],
    "languagesOfPreference": ["es_US"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "8424916514",
        "detailPageURL": "https://www.amazon.com/dp/8424916514?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Descripcion de Grecia / Description of Greece: Libros I-ii (Spanish Edition)",
            "label": "Title",
            "locale": "es_US"
          }
        }
      }
    ]
  }
}
```

### Example 3

Get all the attributes related to an item.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": [
        "itemInfo.byLineInfo",
        "itemInfo.contentInfo",
        "itemInfo.contentRating",
        "itemInfo.classifications",
        "itemInfo.externalIds",
        "itemInfo.features",
        "itemInfo.manufactureInfo",
        "itemInfo.productInfo",
        "itemInfo.technicalInfo",
        "itemInfo.title",
        "itemInfo.tradeInInfo"
    ]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "byLineInfo": {
            "brand": {
              "displayValue": "West Bend",
              "label": "Brand",
              "locale": "en_US"
            },
            "manufacturer": {
              "displayValue": "West Bend",
              "label": "Manufacturer",
              "locale": "en_US"
            }
          },
          "classifications": {
            "binding": {
              "displayValue": "Cocina",
              "label": "Binding",
              "locale": "es_US"
            },
            "productGroup": {
              "displayValue": "Cocina",
              "label": "ProductGroup",
              "locale": "es_US"
            }
          },
          "contentInfo": {
            "edition": {
              "displayValue": "Slp",
              "label": "Edition",
              "locale": "en_US"
            }
          },
          "contentRating": {
            "audienceRating": {
              "displayValue": "PG (Parental Guidance Suggested)",
              "label": "AudienceRating",
              "locale": "en_GB"
            }
          },
          "externalIds": {
            "eans": {
              "displayValues": [
                "0784331985907",
                "6689306520104"
              ],
              "label": "EAN",
              "locale": "en_US"
            },
            "upcs": {
              "displayValues": [
                "885330102972",
                "072244825053"
              ],
              "label": "UPC",
              "locale": "en_US"
            }
          },
          "features": {
            "displayValues": [
              "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
              "Plate is nonstick Coated for easy clean up"
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": {
            "itemPartNumber": {
              "displayValue": "82505",
              "label": "PartNumber",
              "locale": "en_US"
            },
            "model": {
              "displayValue": "82505",
              "label": "Model",
              "locale": "en_US"
            }
          },
          "productInfo": {
            "color": {
              "displayValue": "Red",
              "label": "Color",
              "locale": "en_US"
            },
            "itemDimensions": {
              "height": {
                "displayValue": 10,
                "label": "Height",
                "locale": "en_US",
                "unit": "inches"
              },
              "length": {
                "displayValue": 10,
                "label": "Length",
                "locale": "en_US",
                "unit": "inches"
              },
              "weight": {
                "displayValue": 3.35,
                "label": "Weight",
                "locale": "en_US",
                "unit": "pounds"
              },
              "width": {
                "displayValue": 13,
                "label": "Width",
                "locale": "en_US",
                "unit": "inches"
              }
            },
            "size": {
              "displayValue": "Stir Crazy",
              "label": "Size",
              "locale": "en_US"
            },
            "unitCount": {
              "displayValue": 1,
              "label": "NumberOfItems",
              "locale": "en_US"
            }
          },
          "technicalInfo": {
            "formats": {
              "displayValues": [
                "Box set"
              ],
              "label": "Format",
              "locale": "en_GB"
            }
          },
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
              "amount": 24.05,
              "currency": "USD",
              "displayAmount": "$24.05"
            }
          }
        }
      }
    ]
  }
}
```

## ItemInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_item-info#contentinfo.html`

# ItemInfo

## Description

The `ItemInfo` high level resource is a collection of large number of attributes logically grouped into a resource. i.e. ItemInfo is a collection of resources where each resource contains several attributes.

## Availability

All locales. However, the attributes returned varies with locale and the category of the item.

#### ItemInfo Container

The structure of attribute container inside the high level ItemInfo Resource is as follows:

Copy

```
{
  "itemInfoResource": {
    "attributeName": {
      "displayValue": "The display value of the particular attribute",
      "label": "The attribute name in the specified locale",
      "locale": "The locale in which the attribute is returned"
    }
  }
}
```

## Response Elements

Resource Name

Description

[ByLineInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#bylineinfo.md)

Set of attributes that specifies basic information of the product.

[Classifications](./_creatorsapi_docs_en-us_api-reference_resources_item-info#classifications.md)

Set of attributes that are used to classify an item into a particular category.

[ContentInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentinfo.md)

Set of attributes that are specific to the content like books, movies.

[Content Rating](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentrating.md)

Set of attributes that tell what age group is suitable to view said media.

[ExternalIds](./_creatorsapi_docs_en-us_api-reference_resources_item-info#externalids.md)

Set of identifiers that is used globally to identify a particular product.

[Features](./_creatorsapi_docs_en-us_api-reference_resources_item-info#features.md)

This attribute provides information about a product's key features.

[ManufactureInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#manufactureinfo.md)

Set of attributes that specifies manufacturing related information of an item

[ProductInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#productinfo.md)

Set of attributes that describes non-technical aspects of the item.

[TechnicalInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#technicalinfo.md)

Set of attributes that describes the technical aspects of the item.

[Title](./_creatorsapi_docs_en-us_api-reference_resources_item-info#title.md)

The title of the product.

[TradeInInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#tradeininfo.md)

Set of attributes that specifies trade-in information of an item.

### ByLineInfo

Attribute Name

Description

Brand

This attribute represents the brand of the item.

Contributors

This attribute represents the Contributors associated with the item. Use the `RoleType` parameter to filter by different types of role like `author`, `actor`, `director` etc.

Manufacturer

This attribute represents the Manufacturer of the item.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "byLineInfo": {
            "brand": {
                "displayValue": "West Bend",
                "label": "Brand",
                "locale": "en_US"
            },
            "manufacturer": {
                "displayValue": "Focus Electrics, LLC",
                "label": "Manufacturer",
                "locale": "en_US"
            },
            "contributors": [
                {
                    "locale": "de_DE",
                    "name": "Daniel Radcliffe",
                    "role": "Darsteller",
                    "roleType": "actor"
                },
                {
                    "locale": "en_US",
                    "name": "Rupert Grint",
                    "role": "Director",
                    "roleType": "director"
                }
            ]
        }
    }
}
```

### Classifications

Attribute Name

Description

Binding

Typically (but not always) similar to the product category.

ProductGroup

This attribute represents the product category an item belongs to. The name of a category, such as sporting goods, to which an item in the cart belongs.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "classifications": {
            "binding": {
                "displayValue": "Amazon Video",
                "label": "Binding",
                "locale": "en_GB"
            },
            "productGroup": {
                "displayValue": "Video On Demand",
                "label": "ProductGroup",
                "locale": "en_GB"
            }
        }
    }
}
```

### ContentInfo

Attribute Name

Description

Edition

This attribute represents edition or the version of the product.

Languages

This attribute represents languages associated with the product

PagesCount

This attribute represents the number of pages.

PublicationDate

This attribute represents the date of publication of the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentInfo": {
            "edition": {
                "displayValue": "Slp",
                "label": "Edition",
                "locale": "en_US"
            },
            "languages": {
                "displayValues": [
                    {
                        "displayValue": "English",
                        "type": "Published"
                    },
                    {
                        "displayValue": "English",
                        "type": "Dictionary"
                    }
                ],
                "label": "Language",
                "locale": "en_GB"
            },
            "pagesCount": {
                "displayValue": 4167,
                "label": "NumberOfPages",
                "locale": "en_US"
            },
            "publicationDate": {
                "displayValue": "2009-07-01T00:00:01Z",
                "label": "PublicationDate",
                "locale": "en_US"
            }
        }
    }
}
```

### ContentRating

Attribute Name

Description

AudienceRating

Audience rating for a movie. The rating suggests the age for which the movie is appropriate.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentRating": {
            "audienceRating": {
                "displayValue": "PG (Parental Guidance Suggested)",
                "label": "AudienceRating",
                "locale": "en_GB"
            }
        }
    }
}
```

### ExternalIds

Attribute Name

Description

EANs

European Article Number, which is a number that uniquely identifies an item.

ISBNs

The international standard book number associated with the product, consisting of a 10-digit alphanumeric string

UPCs

12-digit number found below the product's bar code

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "externalIds": {
            "eans": {
                "displayValues": [
                    "9780545162074",
                    "0717356278525"
                ],
                "label": "EAN",
                "locale": "en_US"
            },
            "isbns": {
                "displayValues": [
                    "0545162076"
                ],
                "label": "ISBN",
                "locale": "en_US"
            },
            "upcs": {
                "displayValues": [
                    "717356278525"
                ],
                "label": "UPC",
                "locale": "en_US"
            }
        }
    }
}
```

### Features

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "features": {
            "label": "Features",
            "locale": "en_US",
            "displayValues": [
                "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
                "Stir rod is motorized and improves popping, get more popped corn, larger kernels per batch",
                "Convenient nesting lid is ideal for small storage"
            ]
        }
    }
}
```

### ManufactureInfo

Attribute Name

Description

ItemPartNumber

This attribute represents the item's part number, which is sometimes the same as the model number

Model

This attribute represents the item's model name

Warranty

This attribute represents information related to the warranty provided for the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "manufactureInfo": {
            "itemPartNumber": {
                "displayValue": "MG4H2B/A",
                "label": "PartNumber",
                "locale": "en_US"
            },
            "model": {
                "displayValue": "6",
                "label": "Model",
                "locale": "en_US"
            },
            "warranty": {
                "displayValue": "No Manufacturer Warranty for this phone.",
                "label": "Warranty",
                "locale": "en_US"
            }
        }
    }
}
```

### ProductInfo

Attribute Name

Description

Color

This attribute indicates the color of the product

IsAdultProduct

Indicates if the product is considered to be for adults only.

ItemDimensions

Height, Length, Weight, and Width of the item.

ReleaseDate

Date on which the item was latest released

Size

This attribute provides information related to the size of the item

UnitCount

This attribute represents the total number of identical items that are in the selling unit.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "productInfo": {
            "color": {
                "displayValue": "brown trunk",
                "label": "Color",
                "locale": "en_US"
            },
            "isAdultProduct": {
                "displayValue": false,
                "label": "IsAdultProduct",
                "locale": "en_US"
            },
            "itemDimensions": {
                "height": {
                    "displayValue": 13.9,
                    "label": "Height",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "length": {
                    "displayValue": 18,
                    "label": "Length",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "weight": {
                    "displayValue": 20,
                    "label": "Weight",
                    "locale": "en_GB",
                    "unit": "Pounds"
                },
                "width": {
                    "displayValue": 7.7,
                    "label": "Width",
                    "locale": "en_GB",
                    "unit": "inches"
                }
            },
            "releaseDate": {
                "displayValue": "2013-03-01T00:00:00.000Z",
                "label": "ReleaseDate",
                "locale": "en_US"
            },
            "size": {
                "displayValue": "Small",
                "label": "Size",
                "locale": "en_US"
            },
            "unitCount": {
                "displayValue": 1,
                "label": "NumberOfItems",
                "locale": "en_US"
            }
        }
    }
}
```

### TechnicalInfo

Attribute Name

Description

Formats

Formats is used in various ways depending on the category to assist in describing an item. Format can be 4K, Blu-Ray, etc for Video, Kindle,PaperBack for books and so on

EnergyEfficiencyClass

Energy efficiency of the product. It can have various values based on the product’s type.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "formats": {
                "displayValues": [
                    "Box set"
                ],
                "label": "Format",
                "locale": "en_GB"
            }
        }
    }
}
```

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "energyEfficiencyClass": {
                "displayValue": "a_plus",
                "label": "EnergyEfficiencyClass",
                "locale": "en_GB"
            }
        }
    }
}
```

### Title

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
        }
    }
}
```

### TradeInInfo

Attribute Name

Description

IsEligibleForTradeIn

Specifies whether or not the item is eligible for trade-in.

Price

Specifies trade-in price of the item. This includes amount, currency and display amount of the trade-in price.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
                 "amount": 24.05,
                 "currency": "USD",
                 "displayAmount": "$24.05"
            }
        }
    }
}
```

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Sample Use Cases

### Example 1

Get the title of an item in default locale.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          }
        }
      }
    ]
  }
}
```

### Example 2

Get the title of the product in preferred language of preference.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["8424916514"],
    "languagesOfPreference": ["es_US"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "8424916514",
        "detailPageURL": "https://www.amazon.com/dp/8424916514?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Descripcion de Grecia / Description of Greece: Libros I-ii (Spanish Edition)",
            "label": "Title",
            "locale": "es_US"
          }
        }
      }
    ]
  }
}
```

### Example 3

Get all the attributes related to an item.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": [
        "itemInfo.byLineInfo",
        "itemInfo.contentInfo",
        "itemInfo.contentRating",
        "itemInfo.classifications",
        "itemInfo.externalIds",
        "itemInfo.features",
        "itemInfo.manufactureInfo",
        "itemInfo.productInfo",
        "itemInfo.technicalInfo",
        "itemInfo.title",
        "itemInfo.tradeInInfo"
    ]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "byLineInfo": {
            "brand": {
              "displayValue": "West Bend",
              "label": "Brand",
              "locale": "en_US"
            },
            "manufacturer": {
              "displayValue": "West Bend",
              "label": "Manufacturer",
              "locale": "en_US"
            }
          },
          "classifications": {
            "binding": {
              "displayValue": "Cocina",
              "label": "Binding",
              "locale": "es_US"
            },
            "productGroup": {
              "displayValue": "Cocina",
              "label": "ProductGroup",
              "locale": "es_US"
            }
          },
          "contentInfo": {
            "edition": {
              "displayValue": "Slp",
              "label": "Edition",
              "locale": "en_US"
            }
          },
          "contentRating": {
            "audienceRating": {
              "displayValue": "PG (Parental Guidance Suggested)",
              "label": "AudienceRating",
              "locale": "en_GB"
            }
          },
          "externalIds": {
            "eans": {
              "displayValues": [
                "0784331985907",
                "6689306520104"
              ],
              "label": "EAN",
              "locale": "en_US"
            },
            "upcs": {
              "displayValues": [
                "885330102972",
                "072244825053"
              ],
              "label": "UPC",
              "locale": "en_US"
            }
          },
          "features": {
            "displayValues": [
              "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
              "Plate is nonstick Coated for easy clean up"
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": {
            "itemPartNumber": {
              "displayValue": "82505",
              "label": "PartNumber",
              "locale": "en_US"
            },
            "model": {
              "displayValue": "82505",
              "label": "Model",
              "locale": "en_US"
            }
          },
          "productInfo": {
            "color": {
              "displayValue": "Red",
              "label": "Color",
              "locale": "en_US"
            },
            "itemDimensions": {
              "height": {
                "displayValue": 10,
                "label": "Height",
                "locale": "en_US",
                "unit": "inches"
              },
              "length": {
                "displayValue": 10,
                "label": "Length",
                "locale": "en_US",
                "unit": "inches"
              },
              "weight": {
                "displayValue": 3.35,
                "label": "Weight",
                "locale": "en_US",
                "unit": "pounds"
              },
              "width": {
                "displayValue": 13,
                "label": "Width",
                "locale": "en_US",
                "unit": "inches"
              }
            },
            "size": {
              "displayValue": "Stir Crazy",
              "label": "Size",
              "locale": "en_US"
            },
            "unitCount": {
              "displayValue": 1,
              "label": "NumberOfItems",
              "locale": "en_US"
            }
          },
          "technicalInfo": {
            "formats": {
              "displayValues": [
                "Box set"
              ],
              "label": "Format",
              "locale": "en_GB"
            }
          },
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
              "amount": 24.05,
              "currency": "USD",
              "displayAmount": "$24.05"
            }
          }
        }
      }
    ]
  }
}
```

## ItemInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_item-info#contentrating.html`

# ItemInfo

## Description

The `ItemInfo` high level resource is a collection of large number of attributes logically grouped into a resource. i.e. ItemInfo is a collection of resources where each resource contains several attributes.

## Availability

All locales. However, the attributes returned varies with locale and the category of the item.

#### ItemInfo Container

The structure of attribute container inside the high level ItemInfo Resource is as follows:

Copy

```
{
  "itemInfoResource": {
    "attributeName": {
      "displayValue": "The display value of the particular attribute",
      "label": "The attribute name in the specified locale",
      "locale": "The locale in which the attribute is returned"
    }
  }
}
```

## Response Elements

Resource Name

Description

[ByLineInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#bylineinfo.md)

Set of attributes that specifies basic information of the product.

[Classifications](./_creatorsapi_docs_en-us_api-reference_resources_item-info#classifications.md)

Set of attributes that are used to classify an item into a particular category.

[ContentInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentinfo.md)

Set of attributes that are specific to the content like books, movies.

[Content Rating](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentrating.md)

Set of attributes that tell what age group is suitable to view said media.

[ExternalIds](./_creatorsapi_docs_en-us_api-reference_resources_item-info#externalids.md)

Set of identifiers that is used globally to identify a particular product.

[Features](./_creatorsapi_docs_en-us_api-reference_resources_item-info#features.md)

This attribute provides information about a product's key features.

[ManufactureInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#manufactureinfo.md)

Set of attributes that specifies manufacturing related information of an item

[ProductInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#productinfo.md)

Set of attributes that describes non-technical aspects of the item.

[TechnicalInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#technicalinfo.md)

Set of attributes that describes the technical aspects of the item.

[Title](./_creatorsapi_docs_en-us_api-reference_resources_item-info#title.md)

The title of the product.

[TradeInInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#tradeininfo.md)

Set of attributes that specifies trade-in information of an item.

### ByLineInfo

Attribute Name

Description

Brand

This attribute represents the brand of the item.

Contributors

This attribute represents the Contributors associated with the item. Use the `RoleType` parameter to filter by different types of role like `author`, `actor`, `director` etc.

Manufacturer

This attribute represents the Manufacturer of the item.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "byLineInfo": {
            "brand": {
                "displayValue": "West Bend",
                "label": "Brand",
                "locale": "en_US"
            },
            "manufacturer": {
                "displayValue": "Focus Electrics, LLC",
                "label": "Manufacturer",
                "locale": "en_US"
            },
            "contributors": [
                {
                    "locale": "de_DE",
                    "name": "Daniel Radcliffe",
                    "role": "Darsteller",
                    "roleType": "actor"
                },
                {
                    "locale": "en_US",
                    "name": "Rupert Grint",
                    "role": "Director",
                    "roleType": "director"
                }
            ]
        }
    }
}
```

### Classifications

Attribute Name

Description

Binding

Typically (but not always) similar to the product category.

ProductGroup

This attribute represents the product category an item belongs to. The name of a category, such as sporting goods, to which an item in the cart belongs.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "classifications": {
            "binding": {
                "displayValue": "Amazon Video",
                "label": "Binding",
                "locale": "en_GB"
            },
            "productGroup": {
                "displayValue": "Video On Demand",
                "label": "ProductGroup",
                "locale": "en_GB"
            }
        }
    }
}
```

### ContentInfo

Attribute Name

Description

Edition

This attribute represents edition or the version of the product.

Languages

This attribute represents languages associated with the product

PagesCount

This attribute represents the number of pages.

PublicationDate

This attribute represents the date of publication of the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentInfo": {
            "edition": {
                "displayValue": "Slp",
                "label": "Edition",
                "locale": "en_US"
            },
            "languages": {
                "displayValues": [
                    {
                        "displayValue": "English",
                        "type": "Published"
                    },
                    {
                        "displayValue": "English",
                        "type": "Dictionary"
                    }
                ],
                "label": "Language",
                "locale": "en_GB"
            },
            "pagesCount": {
                "displayValue": 4167,
                "label": "NumberOfPages",
                "locale": "en_US"
            },
            "publicationDate": {
                "displayValue": "2009-07-01T00:00:01Z",
                "label": "PublicationDate",
                "locale": "en_US"
            }
        }
    }
}
```

### ContentRating

Attribute Name

Description

AudienceRating

Audience rating for a movie. The rating suggests the age for which the movie is appropriate.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentRating": {
            "audienceRating": {
                "displayValue": "PG (Parental Guidance Suggested)",
                "label": "AudienceRating",
                "locale": "en_GB"
            }
        }
    }
}
```

### ExternalIds

Attribute Name

Description

EANs

European Article Number, which is a number that uniquely identifies an item.

ISBNs

The international standard book number associated with the product, consisting of a 10-digit alphanumeric string

UPCs

12-digit number found below the product's bar code

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "externalIds": {
            "eans": {
                "displayValues": [
                    "9780545162074",
                    "0717356278525"
                ],
                "label": "EAN",
                "locale": "en_US"
            },
            "isbns": {
                "displayValues": [
                    "0545162076"
                ],
                "label": "ISBN",
                "locale": "en_US"
            },
            "upcs": {
                "displayValues": [
                    "717356278525"
                ],
                "label": "UPC",
                "locale": "en_US"
            }
        }
    }
}
```

### Features

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "features": {
            "label": "Features",
            "locale": "en_US",
            "displayValues": [
                "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
                "Stir rod is motorized and improves popping, get more popped corn, larger kernels per batch",
                "Convenient nesting lid is ideal for small storage"
            ]
        }
    }
}
```

### ManufactureInfo

Attribute Name

Description

ItemPartNumber

This attribute represents the item's part number, which is sometimes the same as the model number

Model

This attribute represents the item's model name

Warranty

This attribute represents information related to the warranty provided for the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "manufactureInfo": {
            "itemPartNumber": {
                "displayValue": "MG4H2B/A",
                "label": "PartNumber",
                "locale": "en_US"
            },
            "model": {
                "displayValue": "6",
                "label": "Model",
                "locale": "en_US"
            },
            "warranty": {
                "displayValue": "No Manufacturer Warranty for this phone.",
                "label": "Warranty",
                "locale": "en_US"
            }
        }
    }
}
```

### ProductInfo

Attribute Name

Description

Color

This attribute indicates the color of the product

IsAdultProduct

Indicates if the product is considered to be for adults only.

ItemDimensions

Height, Length, Weight, and Width of the item.

ReleaseDate

Date on which the item was latest released

Size

This attribute provides information related to the size of the item

UnitCount

This attribute represents the total number of identical items that are in the selling unit.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "productInfo": {
            "color": {
                "displayValue": "brown trunk",
                "label": "Color",
                "locale": "en_US"
            },
            "isAdultProduct": {
                "displayValue": false,
                "label": "IsAdultProduct",
                "locale": "en_US"
            },
            "itemDimensions": {
                "height": {
                    "displayValue": 13.9,
                    "label": "Height",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "length": {
                    "displayValue": 18,
                    "label": "Length",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "weight": {
                    "displayValue": 20,
                    "label": "Weight",
                    "locale": "en_GB",
                    "unit": "Pounds"
                },
                "width": {
                    "displayValue": 7.7,
                    "label": "Width",
                    "locale": "en_GB",
                    "unit": "inches"
                }
            },
            "releaseDate": {
                "displayValue": "2013-03-01T00:00:00.000Z",
                "label": "ReleaseDate",
                "locale": "en_US"
            },
            "size": {
                "displayValue": "Small",
                "label": "Size",
                "locale": "en_US"
            },
            "unitCount": {
                "displayValue": 1,
                "label": "NumberOfItems",
                "locale": "en_US"
            }
        }
    }
}
```

### TechnicalInfo

Attribute Name

Description

Formats

Formats is used in various ways depending on the category to assist in describing an item. Format can be 4K, Blu-Ray, etc for Video, Kindle,PaperBack for books and so on

EnergyEfficiencyClass

Energy efficiency of the product. It can have various values based on the product’s type.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "formats": {
                "displayValues": [
                    "Box set"
                ],
                "label": "Format",
                "locale": "en_GB"
            }
        }
    }
}
```

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "energyEfficiencyClass": {
                "displayValue": "a_plus",
                "label": "EnergyEfficiencyClass",
                "locale": "en_GB"
            }
        }
    }
}
```

### Title

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
        }
    }
}
```

### TradeInInfo

Attribute Name

Description

IsEligibleForTradeIn

Specifies whether or not the item is eligible for trade-in.

Price

Specifies trade-in price of the item. This includes amount, currency and display amount of the trade-in price.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
                 "amount": 24.05,
                 "currency": "USD",
                 "displayAmount": "$24.05"
            }
        }
    }
}
```

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Sample Use Cases

### Example 1

Get the title of an item in default locale.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          }
        }
      }
    ]
  }
}
```

### Example 2

Get the title of the product in preferred language of preference.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["8424916514"],
    "languagesOfPreference": ["es_US"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "8424916514",
        "detailPageURL": "https://www.amazon.com/dp/8424916514?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Descripcion de Grecia / Description of Greece: Libros I-ii (Spanish Edition)",
            "label": "Title",
            "locale": "es_US"
          }
        }
      }
    ]
  }
}
```

### Example 3

Get all the attributes related to an item.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": [
        "itemInfo.byLineInfo",
        "itemInfo.contentInfo",
        "itemInfo.contentRating",
        "itemInfo.classifications",
        "itemInfo.externalIds",
        "itemInfo.features",
        "itemInfo.manufactureInfo",
        "itemInfo.productInfo",
        "itemInfo.technicalInfo",
        "itemInfo.title",
        "itemInfo.tradeInInfo"
    ]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "byLineInfo": {
            "brand": {
              "displayValue": "West Bend",
              "label": "Brand",
              "locale": "en_US"
            },
            "manufacturer": {
              "displayValue": "West Bend",
              "label": "Manufacturer",
              "locale": "en_US"
            }
          },
          "classifications": {
            "binding": {
              "displayValue": "Cocina",
              "label": "Binding",
              "locale": "es_US"
            },
            "productGroup": {
              "displayValue": "Cocina",
              "label": "ProductGroup",
              "locale": "es_US"
            }
          },
          "contentInfo": {
            "edition": {
              "displayValue": "Slp",
              "label": "Edition",
              "locale": "en_US"
            }
          },
          "contentRating": {
            "audienceRating": {
              "displayValue": "PG (Parental Guidance Suggested)",
              "label": "AudienceRating",
              "locale": "en_GB"
            }
          },
          "externalIds": {
            "eans": {
              "displayValues": [
                "0784331985907",
                "6689306520104"
              ],
              "label": "EAN",
              "locale": "en_US"
            },
            "upcs": {
              "displayValues": [
                "885330102972",
                "072244825053"
              ],
              "label": "UPC",
              "locale": "en_US"
            }
          },
          "features": {
            "displayValues": [
              "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
              "Plate is nonstick Coated for easy clean up"
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": {
            "itemPartNumber": {
              "displayValue": "82505",
              "label": "PartNumber",
              "locale": "en_US"
            },
            "model": {
              "displayValue": "82505",
              "label": "Model",
              "locale": "en_US"
            }
          },
          "productInfo": {
            "color": {
              "displayValue": "Red",
              "label": "Color",
              "locale": "en_US"
            },
            "itemDimensions": {
              "height": {
                "displayValue": 10,
                "label": "Height",
                "locale": "en_US",
                "unit": "inches"
              },
              "length": {
                "displayValue": 10,
                "label": "Length",
                "locale": "en_US",
                "unit": "inches"
              },
              "weight": {
                "displayValue": 3.35,
                "label": "Weight",
                "locale": "en_US",
                "unit": "pounds"
              },
              "width": {
                "displayValue": 13,
                "label": "Width",
                "locale": "en_US",
                "unit": "inches"
              }
            },
            "size": {
              "displayValue": "Stir Crazy",
              "label": "Size",
              "locale": "en_US"
            },
            "unitCount": {
              "displayValue": 1,
              "label": "NumberOfItems",
              "locale": "en_US"
            }
          },
          "technicalInfo": {
            "formats": {
              "displayValues": [
                "Box set"
              ],
              "label": "Format",
              "locale": "en_GB"
            }
          },
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
              "amount": 24.05,
              "currency": "USD",
              "displayAmount": "$24.05"
            }
          }
        }
      }
    ]
  }
}
```

## ItemInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_item-info#externalids.html`

# ItemInfo

## Description

The `ItemInfo` high level resource is a collection of large number of attributes logically grouped into a resource. i.e. ItemInfo is a collection of resources where each resource contains several attributes.

## Availability

All locales. However, the attributes returned varies with locale and the category of the item.

#### ItemInfo Container

The structure of attribute container inside the high level ItemInfo Resource is as follows:

Copy

```
{
  "itemInfoResource": {
    "attributeName": {
      "displayValue": "The display value of the particular attribute",
      "label": "The attribute name in the specified locale",
      "locale": "The locale in which the attribute is returned"
    }
  }
}
```

## Response Elements

Resource Name

Description

[ByLineInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#bylineinfo.md)

Set of attributes that specifies basic information of the product.

[Classifications](./_creatorsapi_docs_en-us_api-reference_resources_item-info#classifications.md)

Set of attributes that are used to classify an item into a particular category.

[ContentInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentinfo.md)

Set of attributes that are specific to the content like books, movies.

[Content Rating](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentrating.md)

Set of attributes that tell what age group is suitable to view said media.

[ExternalIds](./_creatorsapi_docs_en-us_api-reference_resources_item-info#externalids.md)

Set of identifiers that is used globally to identify a particular product.

[Features](./_creatorsapi_docs_en-us_api-reference_resources_item-info#features.md)

This attribute provides information about a product's key features.

[ManufactureInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#manufactureinfo.md)

Set of attributes that specifies manufacturing related information of an item

[ProductInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#productinfo.md)

Set of attributes that describes non-technical aspects of the item.

[TechnicalInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#technicalinfo.md)

Set of attributes that describes the technical aspects of the item.

[Title](./_creatorsapi_docs_en-us_api-reference_resources_item-info#title.md)

The title of the product.

[TradeInInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#tradeininfo.md)

Set of attributes that specifies trade-in information of an item.

### ByLineInfo

Attribute Name

Description

Brand

This attribute represents the brand of the item.

Contributors

This attribute represents the Contributors associated with the item. Use the `RoleType` parameter to filter by different types of role like `author`, `actor`, `director` etc.

Manufacturer

This attribute represents the Manufacturer of the item.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "byLineInfo": {
            "brand": {
                "displayValue": "West Bend",
                "label": "Brand",
                "locale": "en_US"
            },
            "manufacturer": {
                "displayValue": "Focus Electrics, LLC",
                "label": "Manufacturer",
                "locale": "en_US"
            },
            "contributors": [
                {
                    "locale": "de_DE",
                    "name": "Daniel Radcliffe",
                    "role": "Darsteller",
                    "roleType": "actor"
                },
                {
                    "locale": "en_US",
                    "name": "Rupert Grint",
                    "role": "Director",
                    "roleType": "director"
                }
            ]
        }
    }
}
```

### Classifications

Attribute Name

Description

Binding

Typically (but not always) similar to the product category.

ProductGroup

This attribute represents the product category an item belongs to. The name of a category, such as sporting goods, to which an item in the cart belongs.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "classifications": {
            "binding": {
                "displayValue": "Amazon Video",
                "label": "Binding",
                "locale": "en_GB"
            },
            "productGroup": {
                "displayValue": "Video On Demand",
                "label": "ProductGroup",
                "locale": "en_GB"
            }
        }
    }
}
```

### ContentInfo

Attribute Name

Description

Edition

This attribute represents edition or the version of the product.

Languages

This attribute represents languages associated with the product

PagesCount

This attribute represents the number of pages.

PublicationDate

This attribute represents the date of publication of the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentInfo": {
            "edition": {
                "displayValue": "Slp",
                "label": "Edition",
                "locale": "en_US"
            },
            "languages": {
                "displayValues": [
                    {
                        "displayValue": "English",
                        "type": "Published"
                    },
                    {
                        "displayValue": "English",
                        "type": "Dictionary"
                    }
                ],
                "label": "Language",
                "locale": "en_GB"
            },
            "pagesCount": {
                "displayValue": 4167,
                "label": "NumberOfPages",
                "locale": "en_US"
            },
            "publicationDate": {
                "displayValue": "2009-07-01T00:00:01Z",
                "label": "PublicationDate",
                "locale": "en_US"
            }
        }
    }
}
```

### ContentRating

Attribute Name

Description

AudienceRating

Audience rating for a movie. The rating suggests the age for which the movie is appropriate.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentRating": {
            "audienceRating": {
                "displayValue": "PG (Parental Guidance Suggested)",
                "label": "AudienceRating",
                "locale": "en_GB"
            }
        }
    }
}
```

### ExternalIds

Attribute Name

Description

EANs

European Article Number, which is a number that uniquely identifies an item.

ISBNs

The international standard book number associated with the product, consisting of a 10-digit alphanumeric string

UPCs

12-digit number found below the product's bar code

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "externalIds": {
            "eans": {
                "displayValues": [
                    "9780545162074",
                    "0717356278525"
                ],
                "label": "EAN",
                "locale": "en_US"
            },
            "isbns": {
                "displayValues": [
                    "0545162076"
                ],
                "label": "ISBN",
                "locale": "en_US"
            },
            "upcs": {
                "displayValues": [
                    "717356278525"
                ],
                "label": "UPC",
                "locale": "en_US"
            }
        }
    }
}
```

### Features

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "features": {
            "label": "Features",
            "locale": "en_US",
            "displayValues": [
                "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
                "Stir rod is motorized and improves popping, get more popped corn, larger kernels per batch",
                "Convenient nesting lid is ideal for small storage"
            ]
        }
    }
}
```

### ManufactureInfo

Attribute Name

Description

ItemPartNumber

This attribute represents the item's part number, which is sometimes the same as the model number

Model

This attribute represents the item's model name

Warranty

This attribute represents information related to the warranty provided for the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "manufactureInfo": {
            "itemPartNumber": {
                "displayValue": "MG4H2B/A",
                "label": "PartNumber",
                "locale": "en_US"
            },
            "model": {
                "displayValue": "6",
                "label": "Model",
                "locale": "en_US"
            },
            "warranty": {
                "displayValue": "No Manufacturer Warranty for this phone.",
                "label": "Warranty",
                "locale": "en_US"
            }
        }
    }
}
```

### ProductInfo

Attribute Name

Description

Color

This attribute indicates the color of the product

IsAdultProduct

Indicates if the product is considered to be for adults only.

ItemDimensions

Height, Length, Weight, and Width of the item.

ReleaseDate

Date on which the item was latest released

Size

This attribute provides information related to the size of the item

UnitCount

This attribute represents the total number of identical items that are in the selling unit.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "productInfo": {
            "color": {
                "displayValue": "brown trunk",
                "label": "Color",
                "locale": "en_US"
            },
            "isAdultProduct": {
                "displayValue": false,
                "label": "IsAdultProduct",
                "locale": "en_US"
            },
            "itemDimensions": {
                "height": {
                    "displayValue": 13.9,
                    "label": "Height",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "length": {
                    "displayValue": 18,
                    "label": "Length",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "weight": {
                    "displayValue": 20,
                    "label": "Weight",
                    "locale": "en_GB",
                    "unit": "Pounds"
                },
                "width": {
                    "displayValue": 7.7,
                    "label": "Width",
                    "locale": "en_GB",
                    "unit": "inches"
                }
            },
            "releaseDate": {
                "displayValue": "2013-03-01T00:00:00.000Z",
                "label": "ReleaseDate",
                "locale": "en_US"
            },
            "size": {
                "displayValue": "Small",
                "label": "Size",
                "locale": "en_US"
            },
            "unitCount": {
                "displayValue": 1,
                "label": "NumberOfItems",
                "locale": "en_US"
            }
        }
    }
}
```

### TechnicalInfo

Attribute Name

Description

Formats

Formats is used in various ways depending on the category to assist in describing an item. Format can be 4K, Blu-Ray, etc for Video, Kindle,PaperBack for books and so on

EnergyEfficiencyClass

Energy efficiency of the product. It can have various values based on the product’s type.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "formats": {
                "displayValues": [
                    "Box set"
                ],
                "label": "Format",
                "locale": "en_GB"
            }
        }
    }
}
```

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "energyEfficiencyClass": {
                "displayValue": "a_plus",
                "label": "EnergyEfficiencyClass",
                "locale": "en_GB"
            }
        }
    }
}
```

### Title

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
        }
    }
}
```

### TradeInInfo

Attribute Name

Description

IsEligibleForTradeIn

Specifies whether or not the item is eligible for trade-in.

Price

Specifies trade-in price of the item. This includes amount, currency and display amount of the trade-in price.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
                 "amount": 24.05,
                 "currency": "USD",
                 "displayAmount": "$24.05"
            }
        }
    }
}
```

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Sample Use Cases

### Example 1

Get the title of an item in default locale.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          }
        }
      }
    ]
  }
}
```

### Example 2

Get the title of the product in preferred language of preference.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["8424916514"],
    "languagesOfPreference": ["es_US"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "8424916514",
        "detailPageURL": "https://www.amazon.com/dp/8424916514?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Descripcion de Grecia / Description of Greece: Libros I-ii (Spanish Edition)",
            "label": "Title",
            "locale": "es_US"
          }
        }
      }
    ]
  }
}
```

### Example 3

Get all the attributes related to an item.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": [
        "itemInfo.byLineInfo",
        "itemInfo.contentInfo",
        "itemInfo.contentRating",
        "itemInfo.classifications",
        "itemInfo.externalIds",
        "itemInfo.features",
        "itemInfo.manufactureInfo",
        "itemInfo.productInfo",
        "itemInfo.technicalInfo",
        "itemInfo.title",
        "itemInfo.tradeInInfo"
    ]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "byLineInfo": {
            "brand": {
              "displayValue": "West Bend",
              "label": "Brand",
              "locale": "en_US"
            },
            "manufacturer": {
              "displayValue": "West Bend",
              "label": "Manufacturer",
              "locale": "en_US"
            }
          },
          "classifications": {
            "binding": {
              "displayValue": "Cocina",
              "label": "Binding",
              "locale": "es_US"
            },
            "productGroup": {
              "displayValue": "Cocina",
              "label": "ProductGroup",
              "locale": "es_US"
            }
          },
          "contentInfo": {
            "edition": {
              "displayValue": "Slp",
              "label": "Edition",
              "locale": "en_US"
            }
          },
          "contentRating": {
            "audienceRating": {
              "displayValue": "PG (Parental Guidance Suggested)",
              "label": "AudienceRating",
              "locale": "en_GB"
            }
          },
          "externalIds": {
            "eans": {
              "displayValues": [
                "0784331985907",
                "6689306520104"
              ],
              "label": "EAN",
              "locale": "en_US"
            },
            "upcs": {
              "displayValues": [
                "885330102972",
                "072244825053"
              ],
              "label": "UPC",
              "locale": "en_US"
            }
          },
          "features": {
            "displayValues": [
              "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
              "Plate is nonstick Coated for easy clean up"
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": {
            "itemPartNumber": {
              "displayValue": "82505",
              "label": "PartNumber",
              "locale": "en_US"
            },
            "model": {
              "displayValue": "82505",
              "label": "Model",
              "locale": "en_US"
            }
          },
          "productInfo": {
            "color": {
              "displayValue": "Red",
              "label": "Color",
              "locale": "en_US"
            },
            "itemDimensions": {
              "height": {
                "displayValue": 10,
                "label": "Height",
                "locale": "en_US",
                "unit": "inches"
              },
              "length": {
                "displayValue": 10,
                "label": "Length",
                "locale": "en_US",
                "unit": "inches"
              },
              "weight": {
                "displayValue": 3.35,
                "label": "Weight",
                "locale": "en_US",
                "unit": "pounds"
              },
              "width": {
                "displayValue": 13,
                "label": "Width",
                "locale": "en_US",
                "unit": "inches"
              }
            },
            "size": {
              "displayValue": "Stir Crazy",
              "label": "Size",
              "locale": "en_US"
            },
            "unitCount": {
              "displayValue": 1,
              "label": "NumberOfItems",
              "locale": "en_US"
            }
          },
          "technicalInfo": {
            "formats": {
              "displayValues": [
                "Box set"
              ],
              "label": "Format",
              "locale": "en_GB"
            }
          },
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
              "amount": 24.05,
              "currency": "USD",
              "displayAmount": "$24.05"
            }
          }
        }
      }
    ]
  }
}
```

## ItemInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_item-info#features.html`

# ItemInfo

## Description

The `ItemInfo` high level resource is a collection of large number of attributes logically grouped into a resource. i.e. ItemInfo is a collection of resources where each resource contains several attributes.

## Availability

All locales. However, the attributes returned varies with locale and the category of the item.

#### ItemInfo Container

The structure of attribute container inside the high level ItemInfo Resource is as follows:

Copy

```
{
  "itemInfoResource": {
    "attributeName": {
      "displayValue": "The display value of the particular attribute",
      "label": "The attribute name in the specified locale",
      "locale": "The locale in which the attribute is returned"
    }
  }
}
```

## Response Elements

Resource Name

Description

[ByLineInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#bylineinfo.md)

Set of attributes that specifies basic information of the product.

[Classifications](./_creatorsapi_docs_en-us_api-reference_resources_item-info#classifications.md)

Set of attributes that are used to classify an item into a particular category.

[ContentInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentinfo.md)

Set of attributes that are specific to the content like books, movies.

[Content Rating](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentrating.md)

Set of attributes that tell what age group is suitable to view said media.

[ExternalIds](./_creatorsapi_docs_en-us_api-reference_resources_item-info#externalids.md)

Set of identifiers that is used globally to identify a particular product.

[Features](./_creatorsapi_docs_en-us_api-reference_resources_item-info#features.md)

This attribute provides information about a product's key features.

[ManufactureInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#manufactureinfo.md)

Set of attributes that specifies manufacturing related information of an item

[ProductInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#productinfo.md)

Set of attributes that describes non-technical aspects of the item.

[TechnicalInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#technicalinfo.md)

Set of attributes that describes the technical aspects of the item.

[Title](./_creatorsapi_docs_en-us_api-reference_resources_item-info#title.md)

The title of the product.

[TradeInInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#tradeininfo.md)

Set of attributes that specifies trade-in information of an item.

### ByLineInfo

Attribute Name

Description

Brand

This attribute represents the brand of the item.

Contributors

This attribute represents the Contributors associated with the item. Use the `RoleType` parameter to filter by different types of role like `author`, `actor`, `director` etc.

Manufacturer

This attribute represents the Manufacturer of the item.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "byLineInfo": {
            "brand": {
                "displayValue": "West Bend",
                "label": "Brand",
                "locale": "en_US"
            },
            "manufacturer": {
                "displayValue": "Focus Electrics, LLC",
                "label": "Manufacturer",
                "locale": "en_US"
            },
            "contributors": [
                {
                    "locale": "de_DE",
                    "name": "Daniel Radcliffe",
                    "role": "Darsteller",
                    "roleType": "actor"
                },
                {
                    "locale": "en_US",
                    "name": "Rupert Grint",
                    "role": "Director",
                    "roleType": "director"
                }
            ]
        }
    }
}
```

### Classifications

Attribute Name

Description

Binding

Typically (but not always) similar to the product category.

ProductGroup

This attribute represents the product category an item belongs to. The name of a category, such as sporting goods, to which an item in the cart belongs.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "classifications": {
            "binding": {
                "displayValue": "Amazon Video",
                "label": "Binding",
                "locale": "en_GB"
            },
            "productGroup": {
                "displayValue": "Video On Demand",
                "label": "ProductGroup",
                "locale": "en_GB"
            }
        }
    }
}
```

### ContentInfo

Attribute Name

Description

Edition

This attribute represents edition or the version of the product.

Languages

This attribute represents languages associated with the product

PagesCount

This attribute represents the number of pages.

PublicationDate

This attribute represents the date of publication of the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentInfo": {
            "edition": {
                "displayValue": "Slp",
                "label": "Edition",
                "locale": "en_US"
            },
            "languages": {
                "displayValues": [
                    {
                        "displayValue": "English",
                        "type": "Published"
                    },
                    {
                        "displayValue": "English",
                        "type": "Dictionary"
                    }
                ],
                "label": "Language",
                "locale": "en_GB"
            },
            "pagesCount": {
                "displayValue": 4167,
                "label": "NumberOfPages",
                "locale": "en_US"
            },
            "publicationDate": {
                "displayValue": "2009-07-01T00:00:01Z",
                "label": "PublicationDate",
                "locale": "en_US"
            }
        }
    }
}
```

### ContentRating

Attribute Name

Description

AudienceRating

Audience rating for a movie. The rating suggests the age for which the movie is appropriate.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentRating": {
            "audienceRating": {
                "displayValue": "PG (Parental Guidance Suggested)",
                "label": "AudienceRating",
                "locale": "en_GB"
            }
        }
    }
}
```

### ExternalIds

Attribute Name

Description

EANs

European Article Number, which is a number that uniquely identifies an item.

ISBNs

The international standard book number associated with the product, consisting of a 10-digit alphanumeric string

UPCs

12-digit number found below the product's bar code

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "externalIds": {
            "eans": {
                "displayValues": [
                    "9780545162074",
                    "0717356278525"
                ],
                "label": "EAN",
                "locale": "en_US"
            },
            "isbns": {
                "displayValues": [
                    "0545162076"
                ],
                "label": "ISBN",
                "locale": "en_US"
            },
            "upcs": {
                "displayValues": [
                    "717356278525"
                ],
                "label": "UPC",
                "locale": "en_US"
            }
        }
    }
}
```

### Features

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "features": {
            "label": "Features",
            "locale": "en_US",
            "displayValues": [
                "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
                "Stir rod is motorized and improves popping, get more popped corn, larger kernels per batch",
                "Convenient nesting lid is ideal for small storage"
            ]
        }
    }
}
```

### ManufactureInfo

Attribute Name

Description

ItemPartNumber

This attribute represents the item's part number, which is sometimes the same as the model number

Model

This attribute represents the item's model name

Warranty

This attribute represents information related to the warranty provided for the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "manufactureInfo": {
            "itemPartNumber": {
                "displayValue": "MG4H2B/A",
                "label": "PartNumber",
                "locale": "en_US"
            },
            "model": {
                "displayValue": "6",
                "label": "Model",
                "locale": "en_US"
            },
            "warranty": {
                "displayValue": "No Manufacturer Warranty for this phone.",
                "label": "Warranty",
                "locale": "en_US"
            }
        }
    }
}
```

### ProductInfo

Attribute Name

Description

Color

This attribute indicates the color of the product

IsAdultProduct

Indicates if the product is considered to be for adults only.

ItemDimensions

Height, Length, Weight, and Width of the item.

ReleaseDate

Date on which the item was latest released

Size

This attribute provides information related to the size of the item

UnitCount

This attribute represents the total number of identical items that are in the selling unit.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "productInfo": {
            "color": {
                "displayValue": "brown trunk",
                "label": "Color",
                "locale": "en_US"
            },
            "isAdultProduct": {
                "displayValue": false,
                "label": "IsAdultProduct",
                "locale": "en_US"
            },
            "itemDimensions": {
                "height": {
                    "displayValue": 13.9,
                    "label": "Height",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "length": {
                    "displayValue": 18,
                    "label": "Length",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "weight": {
                    "displayValue": 20,
                    "label": "Weight",
                    "locale": "en_GB",
                    "unit": "Pounds"
                },
                "width": {
                    "displayValue": 7.7,
                    "label": "Width",
                    "locale": "en_GB",
                    "unit": "inches"
                }
            },
            "releaseDate": {
                "displayValue": "2013-03-01T00:00:00.000Z",
                "label": "ReleaseDate",
                "locale": "en_US"
            },
            "size": {
                "displayValue": "Small",
                "label": "Size",
                "locale": "en_US"
            },
            "unitCount": {
                "displayValue": 1,
                "label": "NumberOfItems",
                "locale": "en_US"
            }
        }
    }
}
```

### TechnicalInfo

Attribute Name

Description

Formats

Formats is used in various ways depending on the category to assist in describing an item. Format can be 4K, Blu-Ray, etc for Video, Kindle,PaperBack for books and so on

EnergyEfficiencyClass

Energy efficiency of the product. It can have various values based on the product’s type.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "formats": {
                "displayValues": [
                    "Box set"
                ],
                "label": "Format",
                "locale": "en_GB"
            }
        }
    }
}
```

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "energyEfficiencyClass": {
                "displayValue": "a_plus",
                "label": "EnergyEfficiencyClass",
                "locale": "en_GB"
            }
        }
    }
}
```

### Title

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
        }
    }
}
```

### TradeInInfo

Attribute Name

Description

IsEligibleForTradeIn

Specifies whether or not the item is eligible for trade-in.

Price

Specifies trade-in price of the item. This includes amount, currency and display amount of the trade-in price.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
                 "amount": 24.05,
                 "currency": "USD",
                 "displayAmount": "$24.05"
            }
        }
    }
}
```

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Sample Use Cases

### Example 1

Get the title of an item in default locale.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          }
        }
      }
    ]
  }
}
```

### Example 2

Get the title of the product in preferred language of preference.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["8424916514"],
    "languagesOfPreference": ["es_US"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "8424916514",
        "detailPageURL": "https://www.amazon.com/dp/8424916514?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Descripcion de Grecia / Description of Greece: Libros I-ii (Spanish Edition)",
            "label": "Title",
            "locale": "es_US"
          }
        }
      }
    ]
  }
}
```

### Example 3

Get all the attributes related to an item.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": [
        "itemInfo.byLineInfo",
        "itemInfo.contentInfo",
        "itemInfo.contentRating",
        "itemInfo.classifications",
        "itemInfo.externalIds",
        "itemInfo.features",
        "itemInfo.manufactureInfo",
        "itemInfo.productInfo",
        "itemInfo.technicalInfo",
        "itemInfo.title",
        "itemInfo.tradeInInfo"
    ]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "byLineInfo": {
            "brand": {
              "displayValue": "West Bend",
              "label": "Brand",
              "locale": "en_US"
            },
            "manufacturer": {
              "displayValue": "West Bend",
              "label": "Manufacturer",
              "locale": "en_US"
            }
          },
          "classifications": {
            "binding": {
              "displayValue": "Cocina",
              "label": "Binding",
              "locale": "es_US"
            },
            "productGroup": {
              "displayValue": "Cocina",
              "label": "ProductGroup",
              "locale": "es_US"
            }
          },
          "contentInfo": {
            "edition": {
              "displayValue": "Slp",
              "label": "Edition",
              "locale": "en_US"
            }
          },
          "contentRating": {
            "audienceRating": {
              "displayValue": "PG (Parental Guidance Suggested)",
              "label": "AudienceRating",
              "locale": "en_GB"
            }
          },
          "externalIds": {
            "eans": {
              "displayValues": [
                "0784331985907",
                "6689306520104"
              ],
              "label": "EAN",
              "locale": "en_US"
            },
            "upcs": {
              "displayValues": [
                "885330102972",
                "072244825053"
              ],
              "label": "UPC",
              "locale": "en_US"
            }
          },
          "features": {
            "displayValues": [
              "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
              "Plate is nonstick Coated for easy clean up"
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": {
            "itemPartNumber": {
              "displayValue": "82505",
              "label": "PartNumber",
              "locale": "en_US"
            },
            "model": {
              "displayValue": "82505",
              "label": "Model",
              "locale": "en_US"
            }
          },
          "productInfo": {
            "color": {
              "displayValue": "Red",
              "label": "Color",
              "locale": "en_US"
            },
            "itemDimensions": {
              "height": {
                "displayValue": 10,
                "label": "Height",
                "locale": "en_US",
                "unit": "inches"
              },
              "length": {
                "displayValue": 10,
                "label": "Length",
                "locale": "en_US",
                "unit": "inches"
              },
              "weight": {
                "displayValue": 3.35,
                "label": "Weight",
                "locale": "en_US",
                "unit": "pounds"
              },
              "width": {
                "displayValue": 13,
                "label": "Width",
                "locale": "en_US",
                "unit": "inches"
              }
            },
            "size": {
              "displayValue": "Stir Crazy",
              "label": "Size",
              "locale": "en_US"
            },
            "unitCount": {
              "displayValue": 1,
              "label": "NumberOfItems",
              "locale": "en_US"
            }
          },
          "technicalInfo": {
            "formats": {
              "displayValues": [
                "Box set"
              ],
              "label": "Format",
              "locale": "en_GB"
            }
          },
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
              "amount": 24.05,
              "currency": "USD",
              "displayAmount": "$24.05"
            }
          }
        }
      }
    ]
  }
}
```

## ItemInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_item-info#manufactureinfo.html`

# ItemInfo

## Description

The `ItemInfo` high level resource is a collection of large number of attributes logically grouped into a resource. i.e. ItemInfo is a collection of resources where each resource contains several attributes.

## Availability

All locales. However, the attributes returned varies with locale and the category of the item.

#### ItemInfo Container

The structure of attribute container inside the high level ItemInfo Resource is as follows:

Copy

```
{
  "itemInfoResource": {
    "attributeName": {
      "displayValue": "The display value of the particular attribute",
      "label": "The attribute name in the specified locale",
      "locale": "The locale in which the attribute is returned"
    }
  }
}
```

## Response Elements

Resource Name

Description

[ByLineInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#bylineinfo.md)

Set of attributes that specifies basic information of the product.

[Classifications](./_creatorsapi_docs_en-us_api-reference_resources_item-info#classifications.md)

Set of attributes that are used to classify an item into a particular category.

[ContentInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentinfo.md)

Set of attributes that are specific to the content like books, movies.

[Content Rating](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentrating.md)

Set of attributes that tell what age group is suitable to view said media.

[ExternalIds](./_creatorsapi_docs_en-us_api-reference_resources_item-info#externalids.md)

Set of identifiers that is used globally to identify a particular product.

[Features](./_creatorsapi_docs_en-us_api-reference_resources_item-info#features.md)

This attribute provides information about a product's key features.

[ManufactureInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#manufactureinfo.md)

Set of attributes that specifies manufacturing related information of an item

[ProductInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#productinfo.md)

Set of attributes that describes non-technical aspects of the item.

[TechnicalInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#technicalinfo.md)

Set of attributes that describes the technical aspects of the item.

[Title](./_creatorsapi_docs_en-us_api-reference_resources_item-info#title.md)

The title of the product.

[TradeInInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#tradeininfo.md)

Set of attributes that specifies trade-in information of an item.

### ByLineInfo

Attribute Name

Description

Brand

This attribute represents the brand of the item.

Contributors

This attribute represents the Contributors associated with the item. Use the `RoleType` parameter to filter by different types of role like `author`, `actor`, `director` etc.

Manufacturer

This attribute represents the Manufacturer of the item.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "byLineInfo": {
            "brand": {
                "displayValue": "West Bend",
                "label": "Brand",
                "locale": "en_US"
            },
            "manufacturer": {
                "displayValue": "Focus Electrics, LLC",
                "label": "Manufacturer",
                "locale": "en_US"
            },
            "contributors": [
                {
                    "locale": "de_DE",
                    "name": "Daniel Radcliffe",
                    "role": "Darsteller",
                    "roleType": "actor"
                },
                {
                    "locale": "en_US",
                    "name": "Rupert Grint",
                    "role": "Director",
                    "roleType": "director"
                }
            ]
        }
    }
}
```

### Classifications

Attribute Name

Description

Binding

Typically (but not always) similar to the product category.

ProductGroup

This attribute represents the product category an item belongs to. The name of a category, such as sporting goods, to which an item in the cart belongs.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "classifications": {
            "binding": {
                "displayValue": "Amazon Video",
                "label": "Binding",
                "locale": "en_GB"
            },
            "productGroup": {
                "displayValue": "Video On Demand",
                "label": "ProductGroup",
                "locale": "en_GB"
            }
        }
    }
}
```

### ContentInfo

Attribute Name

Description

Edition

This attribute represents edition or the version of the product.

Languages

This attribute represents languages associated with the product

PagesCount

This attribute represents the number of pages.

PublicationDate

This attribute represents the date of publication of the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentInfo": {
            "edition": {
                "displayValue": "Slp",
                "label": "Edition",
                "locale": "en_US"
            },
            "languages": {
                "displayValues": [
                    {
                        "displayValue": "English",
                        "type": "Published"
                    },
                    {
                        "displayValue": "English",
                        "type": "Dictionary"
                    }
                ],
                "label": "Language",
                "locale": "en_GB"
            },
            "pagesCount": {
                "displayValue": 4167,
                "label": "NumberOfPages",
                "locale": "en_US"
            },
            "publicationDate": {
                "displayValue": "2009-07-01T00:00:01Z",
                "label": "PublicationDate",
                "locale": "en_US"
            }
        }
    }
}
```

### ContentRating

Attribute Name

Description

AudienceRating

Audience rating for a movie. The rating suggests the age for which the movie is appropriate.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentRating": {
            "audienceRating": {
                "displayValue": "PG (Parental Guidance Suggested)",
                "label": "AudienceRating",
                "locale": "en_GB"
            }
        }
    }
}
```

### ExternalIds

Attribute Name

Description

EANs

European Article Number, which is a number that uniquely identifies an item.

ISBNs

The international standard book number associated with the product, consisting of a 10-digit alphanumeric string

UPCs

12-digit number found below the product's bar code

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "externalIds": {
            "eans": {
                "displayValues": [
                    "9780545162074",
                    "0717356278525"
                ],
                "label": "EAN",
                "locale": "en_US"
            },
            "isbns": {
                "displayValues": [
                    "0545162076"
                ],
                "label": "ISBN",
                "locale": "en_US"
            },
            "upcs": {
                "displayValues": [
                    "717356278525"
                ],
                "label": "UPC",
                "locale": "en_US"
            }
        }
    }
}
```

### Features

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "features": {
            "label": "Features",
            "locale": "en_US",
            "displayValues": [
                "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
                "Stir rod is motorized and improves popping, get more popped corn, larger kernels per batch",
                "Convenient nesting lid is ideal for small storage"
            ]
        }
    }
}
```

### ManufactureInfo

Attribute Name

Description

ItemPartNumber

This attribute represents the item's part number, which is sometimes the same as the model number

Model

This attribute represents the item's model name

Warranty

This attribute represents information related to the warranty provided for the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "manufactureInfo": {
            "itemPartNumber": {
                "displayValue": "MG4H2B/A",
                "label": "PartNumber",
                "locale": "en_US"
            },
            "model": {
                "displayValue": "6",
                "label": "Model",
                "locale": "en_US"
            },
            "warranty": {
                "displayValue": "No Manufacturer Warranty for this phone.",
                "label": "Warranty",
                "locale": "en_US"
            }
        }
    }
}
```

### ProductInfo

Attribute Name

Description

Color

This attribute indicates the color of the product

IsAdultProduct

Indicates if the product is considered to be for adults only.

ItemDimensions

Height, Length, Weight, and Width of the item.

ReleaseDate

Date on which the item was latest released

Size

This attribute provides information related to the size of the item

UnitCount

This attribute represents the total number of identical items that are in the selling unit.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "productInfo": {
            "color": {
                "displayValue": "brown trunk",
                "label": "Color",
                "locale": "en_US"
            },
            "isAdultProduct": {
                "displayValue": false,
                "label": "IsAdultProduct",
                "locale": "en_US"
            },
            "itemDimensions": {
                "height": {
                    "displayValue": 13.9,
                    "label": "Height",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "length": {
                    "displayValue": 18,
                    "label": "Length",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "weight": {
                    "displayValue": 20,
                    "label": "Weight",
                    "locale": "en_GB",
                    "unit": "Pounds"
                },
                "width": {
                    "displayValue": 7.7,
                    "label": "Width",
                    "locale": "en_GB",
                    "unit": "inches"
                }
            },
            "releaseDate": {
                "displayValue": "2013-03-01T00:00:00.000Z",
                "label": "ReleaseDate",
                "locale": "en_US"
            },
            "size": {
                "displayValue": "Small",
                "label": "Size",
                "locale": "en_US"
            },
            "unitCount": {
                "displayValue": 1,
                "label": "NumberOfItems",
                "locale": "en_US"
            }
        }
    }
}
```

### TechnicalInfo

Attribute Name

Description

Formats

Formats is used in various ways depending on the category to assist in describing an item. Format can be 4K, Blu-Ray, etc for Video, Kindle,PaperBack for books and so on

EnergyEfficiencyClass

Energy efficiency of the product. It can have various values based on the product’s type.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "formats": {
                "displayValues": [
                    "Box set"
                ],
                "label": "Format",
                "locale": "en_GB"
            }
        }
    }
}
```

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "energyEfficiencyClass": {
                "displayValue": "a_plus",
                "label": "EnergyEfficiencyClass",
                "locale": "en_GB"
            }
        }
    }
}
```

### Title

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
        }
    }
}
```

### TradeInInfo

Attribute Name

Description

IsEligibleForTradeIn

Specifies whether or not the item is eligible for trade-in.

Price

Specifies trade-in price of the item. This includes amount, currency and display amount of the trade-in price.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
                 "amount": 24.05,
                 "currency": "USD",
                 "displayAmount": "$24.05"
            }
        }
    }
}
```

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Sample Use Cases

### Example 1

Get the title of an item in default locale.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          }
        }
      }
    ]
  }
}
```

### Example 2

Get the title of the product in preferred language of preference.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["8424916514"],
    "languagesOfPreference": ["es_US"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "8424916514",
        "detailPageURL": "https://www.amazon.com/dp/8424916514?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Descripcion de Grecia / Description of Greece: Libros I-ii (Spanish Edition)",
            "label": "Title",
            "locale": "es_US"
          }
        }
      }
    ]
  }
}
```

### Example 3

Get all the attributes related to an item.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": [
        "itemInfo.byLineInfo",
        "itemInfo.contentInfo",
        "itemInfo.contentRating",
        "itemInfo.classifications",
        "itemInfo.externalIds",
        "itemInfo.features",
        "itemInfo.manufactureInfo",
        "itemInfo.productInfo",
        "itemInfo.technicalInfo",
        "itemInfo.title",
        "itemInfo.tradeInInfo"
    ]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "byLineInfo": {
            "brand": {
              "displayValue": "West Bend",
              "label": "Brand",
              "locale": "en_US"
            },
            "manufacturer": {
              "displayValue": "West Bend",
              "label": "Manufacturer",
              "locale": "en_US"
            }
          },
          "classifications": {
            "binding": {
              "displayValue": "Cocina",
              "label": "Binding",
              "locale": "es_US"
            },
            "productGroup": {
              "displayValue": "Cocina",
              "label": "ProductGroup",
              "locale": "es_US"
            }
          },
          "contentInfo": {
            "edition": {
              "displayValue": "Slp",
              "label": "Edition",
              "locale": "en_US"
            }
          },
          "contentRating": {
            "audienceRating": {
              "displayValue": "PG (Parental Guidance Suggested)",
              "label": "AudienceRating",
              "locale": "en_GB"
            }
          },
          "externalIds": {
            "eans": {
              "displayValues": [
                "0784331985907",
                "6689306520104"
              ],
              "label": "EAN",
              "locale": "en_US"
            },
            "upcs": {
              "displayValues": [
                "885330102972",
                "072244825053"
              ],
              "label": "UPC",
              "locale": "en_US"
            }
          },
          "features": {
            "displayValues": [
              "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
              "Plate is nonstick Coated for easy clean up"
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": {
            "itemPartNumber": {
              "displayValue": "82505",
              "label": "PartNumber",
              "locale": "en_US"
            },
            "model": {
              "displayValue": "82505",
              "label": "Model",
              "locale": "en_US"
            }
          },
          "productInfo": {
            "color": {
              "displayValue": "Red",
              "label": "Color",
              "locale": "en_US"
            },
            "itemDimensions": {
              "height": {
                "displayValue": 10,
                "label": "Height",
                "locale": "en_US",
                "unit": "inches"
              },
              "length": {
                "displayValue": 10,
                "label": "Length",
                "locale": "en_US",
                "unit": "inches"
              },
              "weight": {
                "displayValue": 3.35,
                "label": "Weight",
                "locale": "en_US",
                "unit": "pounds"
              },
              "width": {
                "displayValue": 13,
                "label": "Width",
                "locale": "en_US",
                "unit": "inches"
              }
            },
            "size": {
              "displayValue": "Stir Crazy",
              "label": "Size",
              "locale": "en_US"
            },
            "unitCount": {
              "displayValue": 1,
              "label": "NumberOfItems",
              "locale": "en_US"
            }
          },
          "technicalInfo": {
            "formats": {
              "displayValues": [
                "Box set"
              ],
              "label": "Format",
              "locale": "en_GB"
            }
          },
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
              "amount": 24.05,
              "currency": "USD",
              "displayAmount": "$24.05"
            }
          }
        }
      }
    ]
  }
}
```

## ItemInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_item-info#productinfo.html`

# ItemInfo

## Description

The `ItemInfo` high level resource is a collection of large number of attributes logically grouped into a resource. i.e. ItemInfo is a collection of resources where each resource contains several attributes.

## Availability

All locales. However, the attributes returned varies with locale and the category of the item.

#### ItemInfo Container

The structure of attribute container inside the high level ItemInfo Resource is as follows:

Copy

```
{
  "itemInfoResource": {
    "attributeName": {
      "displayValue": "The display value of the particular attribute",
      "label": "The attribute name in the specified locale",
      "locale": "The locale in which the attribute is returned"
    }
  }
}
```

## Response Elements

Resource Name

Description

[ByLineInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#bylineinfo.md)

Set of attributes that specifies basic information of the product.

[Classifications](./_creatorsapi_docs_en-us_api-reference_resources_item-info#classifications.md)

Set of attributes that are used to classify an item into a particular category.

[ContentInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentinfo.md)

Set of attributes that are specific to the content like books, movies.

[Content Rating](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentrating.md)

Set of attributes that tell what age group is suitable to view said media.

[ExternalIds](./_creatorsapi_docs_en-us_api-reference_resources_item-info#externalids.md)

Set of identifiers that is used globally to identify a particular product.

[Features](./_creatorsapi_docs_en-us_api-reference_resources_item-info#features.md)

This attribute provides information about a product's key features.

[ManufactureInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#manufactureinfo.md)

Set of attributes that specifies manufacturing related information of an item

[ProductInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#productinfo.md)

Set of attributes that describes non-technical aspects of the item.

[TechnicalInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#technicalinfo.md)

Set of attributes that describes the technical aspects of the item.

[Title](./_creatorsapi_docs_en-us_api-reference_resources_item-info#title.md)

The title of the product.

[TradeInInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#tradeininfo.md)

Set of attributes that specifies trade-in information of an item.

### ByLineInfo

Attribute Name

Description

Brand

This attribute represents the brand of the item.

Contributors

This attribute represents the Contributors associated with the item. Use the `RoleType` parameter to filter by different types of role like `author`, `actor`, `director` etc.

Manufacturer

This attribute represents the Manufacturer of the item.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "byLineInfo": {
            "brand": {
                "displayValue": "West Bend",
                "label": "Brand",
                "locale": "en_US"
            },
            "manufacturer": {
                "displayValue": "Focus Electrics, LLC",
                "label": "Manufacturer",
                "locale": "en_US"
            },
            "contributors": [
                {
                    "locale": "de_DE",
                    "name": "Daniel Radcliffe",
                    "role": "Darsteller",
                    "roleType": "actor"
                },
                {
                    "locale": "en_US",
                    "name": "Rupert Grint",
                    "role": "Director",
                    "roleType": "director"
                }
            ]
        }
    }
}
```

### Classifications

Attribute Name

Description

Binding

Typically (but not always) similar to the product category.

ProductGroup

This attribute represents the product category an item belongs to. The name of a category, such as sporting goods, to which an item in the cart belongs.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "classifications": {
            "binding": {
                "displayValue": "Amazon Video",
                "label": "Binding",
                "locale": "en_GB"
            },
            "productGroup": {
                "displayValue": "Video On Demand",
                "label": "ProductGroup",
                "locale": "en_GB"
            }
        }
    }
}
```

### ContentInfo

Attribute Name

Description

Edition

This attribute represents edition or the version of the product.

Languages

This attribute represents languages associated with the product

PagesCount

This attribute represents the number of pages.

PublicationDate

This attribute represents the date of publication of the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentInfo": {
            "edition": {
                "displayValue": "Slp",
                "label": "Edition",
                "locale": "en_US"
            },
            "languages": {
                "displayValues": [
                    {
                        "displayValue": "English",
                        "type": "Published"
                    },
                    {
                        "displayValue": "English",
                        "type": "Dictionary"
                    }
                ],
                "label": "Language",
                "locale": "en_GB"
            },
            "pagesCount": {
                "displayValue": 4167,
                "label": "NumberOfPages",
                "locale": "en_US"
            },
            "publicationDate": {
                "displayValue": "2009-07-01T00:00:01Z",
                "label": "PublicationDate",
                "locale": "en_US"
            }
        }
    }
}
```

### ContentRating

Attribute Name

Description

AudienceRating

Audience rating for a movie. The rating suggests the age for which the movie is appropriate.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentRating": {
            "audienceRating": {
                "displayValue": "PG (Parental Guidance Suggested)",
                "label": "AudienceRating",
                "locale": "en_GB"
            }
        }
    }
}
```

### ExternalIds

Attribute Name

Description

EANs

European Article Number, which is a number that uniquely identifies an item.

ISBNs

The international standard book number associated with the product, consisting of a 10-digit alphanumeric string

UPCs

12-digit number found below the product's bar code

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "externalIds": {
            "eans": {
                "displayValues": [
                    "9780545162074",
                    "0717356278525"
                ],
                "label": "EAN",
                "locale": "en_US"
            },
            "isbns": {
                "displayValues": [
                    "0545162076"
                ],
                "label": "ISBN",
                "locale": "en_US"
            },
            "upcs": {
                "displayValues": [
                    "717356278525"
                ],
                "label": "UPC",
                "locale": "en_US"
            }
        }
    }
}
```

### Features

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "features": {
            "label": "Features",
            "locale": "en_US",
            "displayValues": [
                "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
                "Stir rod is motorized and improves popping, get more popped corn, larger kernels per batch",
                "Convenient nesting lid is ideal for small storage"
            ]
        }
    }
}
```

### ManufactureInfo

Attribute Name

Description

ItemPartNumber

This attribute represents the item's part number, which is sometimes the same as the model number

Model

This attribute represents the item's model name

Warranty

This attribute represents information related to the warranty provided for the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "manufactureInfo": {
            "itemPartNumber": {
                "displayValue": "MG4H2B/A",
                "label": "PartNumber",
                "locale": "en_US"
            },
            "model": {
                "displayValue": "6",
                "label": "Model",
                "locale": "en_US"
            },
            "warranty": {
                "displayValue": "No Manufacturer Warranty for this phone.",
                "label": "Warranty",
                "locale": "en_US"
            }
        }
    }
}
```

### ProductInfo

Attribute Name

Description

Color

This attribute indicates the color of the product

IsAdultProduct

Indicates if the product is considered to be for adults only.

ItemDimensions

Height, Length, Weight, and Width of the item.

ReleaseDate

Date on which the item was latest released

Size

This attribute provides information related to the size of the item

UnitCount

This attribute represents the total number of identical items that are in the selling unit.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "productInfo": {
            "color": {
                "displayValue": "brown trunk",
                "label": "Color",
                "locale": "en_US"
            },
            "isAdultProduct": {
                "displayValue": false,
                "label": "IsAdultProduct",
                "locale": "en_US"
            },
            "itemDimensions": {
                "height": {
                    "displayValue": 13.9,
                    "label": "Height",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "length": {
                    "displayValue": 18,
                    "label": "Length",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "weight": {
                    "displayValue": 20,
                    "label": "Weight",
                    "locale": "en_GB",
                    "unit": "Pounds"
                },
                "width": {
                    "displayValue": 7.7,
                    "label": "Width",
                    "locale": "en_GB",
                    "unit": "inches"
                }
            },
            "releaseDate": {
                "displayValue": "2013-03-01T00:00:00.000Z",
                "label": "ReleaseDate",
                "locale": "en_US"
            },
            "size": {
                "displayValue": "Small",
                "label": "Size",
                "locale": "en_US"
            },
            "unitCount": {
                "displayValue": 1,
                "label": "NumberOfItems",
                "locale": "en_US"
            }
        }
    }
}
```

### TechnicalInfo

Attribute Name

Description

Formats

Formats is used in various ways depending on the category to assist in describing an item. Format can be 4K, Blu-Ray, etc for Video, Kindle,PaperBack for books and so on

EnergyEfficiencyClass

Energy efficiency of the product. It can have various values based on the product’s type.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "formats": {
                "displayValues": [
                    "Box set"
                ],
                "label": "Format",
                "locale": "en_GB"
            }
        }
    }
}
```

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "energyEfficiencyClass": {
                "displayValue": "a_plus",
                "label": "EnergyEfficiencyClass",
                "locale": "en_GB"
            }
        }
    }
}
```

### Title

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
        }
    }
}
```

### TradeInInfo

Attribute Name

Description

IsEligibleForTradeIn

Specifies whether or not the item is eligible for trade-in.

Price

Specifies trade-in price of the item. This includes amount, currency and display amount of the trade-in price.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
                 "amount": 24.05,
                 "currency": "USD",
                 "displayAmount": "$24.05"
            }
        }
    }
}
```

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Sample Use Cases

### Example 1

Get the title of an item in default locale.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          }
        }
      }
    ]
  }
}
```

### Example 2

Get the title of the product in preferred language of preference.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["8424916514"],
    "languagesOfPreference": ["es_US"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "8424916514",
        "detailPageURL": "https://www.amazon.com/dp/8424916514?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Descripcion de Grecia / Description of Greece: Libros I-ii (Spanish Edition)",
            "label": "Title",
            "locale": "es_US"
          }
        }
      }
    ]
  }
}
```

### Example 3

Get all the attributes related to an item.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": [
        "itemInfo.byLineInfo",
        "itemInfo.contentInfo",
        "itemInfo.contentRating",
        "itemInfo.classifications",
        "itemInfo.externalIds",
        "itemInfo.features",
        "itemInfo.manufactureInfo",
        "itemInfo.productInfo",
        "itemInfo.technicalInfo",
        "itemInfo.title",
        "itemInfo.tradeInInfo"
    ]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "byLineInfo": {
            "brand": {
              "displayValue": "West Bend",
              "label": "Brand",
              "locale": "en_US"
            },
            "manufacturer": {
              "displayValue": "West Bend",
              "label": "Manufacturer",
              "locale": "en_US"
            }
          },
          "classifications": {
            "binding": {
              "displayValue": "Cocina",
              "label": "Binding",
              "locale": "es_US"
            },
            "productGroup": {
              "displayValue": "Cocina",
              "label": "ProductGroup",
              "locale": "es_US"
            }
          },
          "contentInfo": {
            "edition": {
              "displayValue": "Slp",
              "label": "Edition",
              "locale": "en_US"
            }
          },
          "contentRating": {
            "audienceRating": {
              "displayValue": "PG (Parental Guidance Suggested)",
              "label": "AudienceRating",
              "locale": "en_GB"
            }
          },
          "externalIds": {
            "eans": {
              "displayValues": [
                "0784331985907",
                "6689306520104"
              ],
              "label": "EAN",
              "locale": "en_US"
            },
            "upcs": {
              "displayValues": [
                "885330102972",
                "072244825053"
              ],
              "label": "UPC",
              "locale": "en_US"
            }
          },
          "features": {
            "displayValues": [
              "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
              "Plate is nonstick Coated for easy clean up"
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": {
            "itemPartNumber": {
              "displayValue": "82505",
              "label": "PartNumber",
              "locale": "en_US"
            },
            "model": {
              "displayValue": "82505",
              "label": "Model",
              "locale": "en_US"
            }
          },
          "productInfo": {
            "color": {
              "displayValue": "Red",
              "label": "Color",
              "locale": "en_US"
            },
            "itemDimensions": {
              "height": {
                "displayValue": 10,
                "label": "Height",
                "locale": "en_US",
                "unit": "inches"
              },
              "length": {
                "displayValue": 10,
                "label": "Length",
                "locale": "en_US",
                "unit": "inches"
              },
              "weight": {
                "displayValue": 3.35,
                "label": "Weight",
                "locale": "en_US",
                "unit": "pounds"
              },
              "width": {
                "displayValue": 13,
                "label": "Width",
                "locale": "en_US",
                "unit": "inches"
              }
            },
            "size": {
              "displayValue": "Stir Crazy",
              "label": "Size",
              "locale": "en_US"
            },
            "unitCount": {
              "displayValue": 1,
              "label": "NumberOfItems",
              "locale": "en_US"
            }
          },
          "technicalInfo": {
            "formats": {
              "displayValues": [
                "Box set"
              ],
              "label": "Format",
              "locale": "en_GB"
            }
          },
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
              "amount": 24.05,
              "currency": "USD",
              "displayAmount": "$24.05"
            }
          }
        }
      }
    ]
  }
}
```

## ItemInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_item-info#technicalinfo.html`

# ItemInfo

## Description

The `ItemInfo` high level resource is a collection of large number of attributes logically grouped into a resource. i.e. ItemInfo is a collection of resources where each resource contains several attributes.

## Availability

All locales. However, the attributes returned varies with locale and the category of the item.

#### ItemInfo Container

The structure of attribute container inside the high level ItemInfo Resource is as follows:

Copy

```
{
  "itemInfoResource": {
    "attributeName": {
      "displayValue": "The display value of the particular attribute",
      "label": "The attribute name in the specified locale",
      "locale": "The locale in which the attribute is returned"
    }
  }
}
```

## Response Elements

Resource Name

Description

[ByLineInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#bylineinfo.md)

Set of attributes that specifies basic information of the product.

[Classifications](./_creatorsapi_docs_en-us_api-reference_resources_item-info#classifications.md)

Set of attributes that are used to classify an item into a particular category.

[ContentInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentinfo.md)

Set of attributes that are specific to the content like books, movies.

[Content Rating](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentrating.md)

Set of attributes that tell what age group is suitable to view said media.

[ExternalIds](./_creatorsapi_docs_en-us_api-reference_resources_item-info#externalids.md)

Set of identifiers that is used globally to identify a particular product.

[Features](./_creatorsapi_docs_en-us_api-reference_resources_item-info#features.md)

This attribute provides information about a product's key features.

[ManufactureInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#manufactureinfo.md)

Set of attributes that specifies manufacturing related information of an item

[ProductInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#productinfo.md)

Set of attributes that describes non-technical aspects of the item.

[TechnicalInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#technicalinfo.md)

Set of attributes that describes the technical aspects of the item.

[Title](./_creatorsapi_docs_en-us_api-reference_resources_item-info#title.md)

The title of the product.

[TradeInInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#tradeininfo.md)

Set of attributes that specifies trade-in information of an item.

### ByLineInfo

Attribute Name

Description

Brand

This attribute represents the brand of the item.

Contributors

This attribute represents the Contributors associated with the item. Use the `RoleType` parameter to filter by different types of role like `author`, `actor`, `director` etc.

Manufacturer

This attribute represents the Manufacturer of the item.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "byLineInfo": {
            "brand": {
                "displayValue": "West Bend",
                "label": "Brand",
                "locale": "en_US"
            },
            "manufacturer": {
                "displayValue": "Focus Electrics, LLC",
                "label": "Manufacturer",
                "locale": "en_US"
            },
            "contributors": [
                {
                    "locale": "de_DE",
                    "name": "Daniel Radcliffe",
                    "role": "Darsteller",
                    "roleType": "actor"
                },
                {
                    "locale": "en_US",
                    "name": "Rupert Grint",
                    "role": "Director",
                    "roleType": "director"
                }
            ]
        }
    }
}
```

### Classifications

Attribute Name

Description

Binding

Typically (but not always) similar to the product category.

ProductGroup

This attribute represents the product category an item belongs to. The name of a category, such as sporting goods, to which an item in the cart belongs.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "classifications": {
            "binding": {
                "displayValue": "Amazon Video",
                "label": "Binding",
                "locale": "en_GB"
            },
            "productGroup": {
                "displayValue": "Video On Demand",
                "label": "ProductGroup",
                "locale": "en_GB"
            }
        }
    }
}
```

### ContentInfo

Attribute Name

Description

Edition

This attribute represents edition or the version of the product.

Languages

This attribute represents languages associated with the product

PagesCount

This attribute represents the number of pages.

PublicationDate

This attribute represents the date of publication of the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentInfo": {
            "edition": {
                "displayValue": "Slp",
                "label": "Edition",
                "locale": "en_US"
            },
            "languages": {
                "displayValues": [
                    {
                        "displayValue": "English",
                        "type": "Published"
                    },
                    {
                        "displayValue": "English",
                        "type": "Dictionary"
                    }
                ],
                "label": "Language",
                "locale": "en_GB"
            },
            "pagesCount": {
                "displayValue": 4167,
                "label": "NumberOfPages",
                "locale": "en_US"
            },
            "publicationDate": {
                "displayValue": "2009-07-01T00:00:01Z",
                "label": "PublicationDate",
                "locale": "en_US"
            }
        }
    }
}
```

### ContentRating

Attribute Name

Description

AudienceRating

Audience rating for a movie. The rating suggests the age for which the movie is appropriate.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentRating": {
            "audienceRating": {
                "displayValue": "PG (Parental Guidance Suggested)",
                "label": "AudienceRating",
                "locale": "en_GB"
            }
        }
    }
}
```

### ExternalIds

Attribute Name

Description

EANs

European Article Number, which is a number that uniquely identifies an item.

ISBNs

The international standard book number associated with the product, consisting of a 10-digit alphanumeric string

UPCs

12-digit number found below the product's bar code

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "externalIds": {
            "eans": {
                "displayValues": [
                    "9780545162074",
                    "0717356278525"
                ],
                "label": "EAN",
                "locale": "en_US"
            },
            "isbns": {
                "displayValues": [
                    "0545162076"
                ],
                "label": "ISBN",
                "locale": "en_US"
            },
            "upcs": {
                "displayValues": [
                    "717356278525"
                ],
                "label": "UPC",
                "locale": "en_US"
            }
        }
    }
}
```

### Features

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "features": {
            "label": "Features",
            "locale": "en_US",
            "displayValues": [
                "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
                "Stir rod is motorized and improves popping, get more popped corn, larger kernels per batch",
                "Convenient nesting lid is ideal for small storage"
            ]
        }
    }
}
```

### ManufactureInfo

Attribute Name

Description

ItemPartNumber

This attribute represents the item's part number, which is sometimes the same as the model number

Model

This attribute represents the item's model name

Warranty

This attribute represents information related to the warranty provided for the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "manufactureInfo": {
            "itemPartNumber": {
                "displayValue": "MG4H2B/A",
                "label": "PartNumber",
                "locale": "en_US"
            },
            "model": {
                "displayValue": "6",
                "label": "Model",
                "locale": "en_US"
            },
            "warranty": {
                "displayValue": "No Manufacturer Warranty for this phone.",
                "label": "Warranty",
                "locale": "en_US"
            }
        }
    }
}
```

### ProductInfo

Attribute Name

Description

Color

This attribute indicates the color of the product

IsAdultProduct

Indicates if the product is considered to be for adults only.

ItemDimensions

Height, Length, Weight, and Width of the item.

ReleaseDate

Date on which the item was latest released

Size

This attribute provides information related to the size of the item

UnitCount

This attribute represents the total number of identical items that are in the selling unit.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "productInfo": {
            "color": {
                "displayValue": "brown trunk",
                "label": "Color",
                "locale": "en_US"
            },
            "isAdultProduct": {
                "displayValue": false,
                "label": "IsAdultProduct",
                "locale": "en_US"
            },
            "itemDimensions": {
                "height": {
                    "displayValue": 13.9,
                    "label": "Height",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "length": {
                    "displayValue": 18,
                    "label": "Length",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "weight": {
                    "displayValue": 20,
                    "label": "Weight",
                    "locale": "en_GB",
                    "unit": "Pounds"
                },
                "width": {
                    "displayValue": 7.7,
                    "label": "Width",
                    "locale": "en_GB",
                    "unit": "inches"
                }
            },
            "releaseDate": {
                "displayValue": "2013-03-01T00:00:00.000Z",
                "label": "ReleaseDate",
                "locale": "en_US"
            },
            "size": {
                "displayValue": "Small",
                "label": "Size",
                "locale": "en_US"
            },
            "unitCount": {
                "displayValue": 1,
                "label": "NumberOfItems",
                "locale": "en_US"
            }
        }
    }
}
```

### TechnicalInfo

Attribute Name

Description

Formats

Formats is used in various ways depending on the category to assist in describing an item. Format can be 4K, Blu-Ray, etc for Video, Kindle,PaperBack for books and so on

EnergyEfficiencyClass

Energy efficiency of the product. It can have various values based on the product’s type.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "formats": {
                "displayValues": [
                    "Box set"
                ],
                "label": "Format",
                "locale": "en_GB"
            }
        }
    }
}
```

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "energyEfficiencyClass": {
                "displayValue": "a_plus",
                "label": "EnergyEfficiencyClass",
                "locale": "en_GB"
            }
        }
    }
}
```

### Title

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
        }
    }
}
```

### TradeInInfo

Attribute Name

Description

IsEligibleForTradeIn

Specifies whether or not the item is eligible for trade-in.

Price

Specifies trade-in price of the item. This includes amount, currency and display amount of the trade-in price.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
                 "amount": 24.05,
                 "currency": "USD",
                 "displayAmount": "$24.05"
            }
        }
    }
}
```

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Sample Use Cases

### Example 1

Get the title of an item in default locale.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          }
        }
      }
    ]
  }
}
```

### Example 2

Get the title of the product in preferred language of preference.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["8424916514"],
    "languagesOfPreference": ["es_US"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "8424916514",
        "detailPageURL": "https://www.amazon.com/dp/8424916514?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Descripcion de Grecia / Description of Greece: Libros I-ii (Spanish Edition)",
            "label": "Title",
            "locale": "es_US"
          }
        }
      }
    ]
  }
}
```

### Example 3

Get all the attributes related to an item.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": [
        "itemInfo.byLineInfo",
        "itemInfo.contentInfo",
        "itemInfo.contentRating",
        "itemInfo.classifications",
        "itemInfo.externalIds",
        "itemInfo.features",
        "itemInfo.manufactureInfo",
        "itemInfo.productInfo",
        "itemInfo.technicalInfo",
        "itemInfo.title",
        "itemInfo.tradeInInfo"
    ]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "byLineInfo": {
            "brand": {
              "displayValue": "West Bend",
              "label": "Brand",
              "locale": "en_US"
            },
            "manufacturer": {
              "displayValue": "West Bend",
              "label": "Manufacturer",
              "locale": "en_US"
            }
          },
          "classifications": {
            "binding": {
              "displayValue": "Cocina",
              "label": "Binding",
              "locale": "es_US"
            },
            "productGroup": {
              "displayValue": "Cocina",
              "label": "ProductGroup",
              "locale": "es_US"
            }
          },
          "contentInfo": {
            "edition": {
              "displayValue": "Slp",
              "label": "Edition",
              "locale": "en_US"
            }
          },
          "contentRating": {
            "audienceRating": {
              "displayValue": "PG (Parental Guidance Suggested)",
              "label": "AudienceRating",
              "locale": "en_GB"
            }
          },
          "externalIds": {
            "eans": {
              "displayValues": [
                "0784331985907",
                "6689306520104"
              ],
              "label": "EAN",
              "locale": "en_US"
            },
            "upcs": {
              "displayValues": [
                "885330102972",
                "072244825053"
              ],
              "label": "UPC",
              "locale": "en_US"
            }
          },
          "features": {
            "displayValues": [
              "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
              "Plate is nonstick Coated for easy clean up"
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": {
            "itemPartNumber": {
              "displayValue": "82505",
              "label": "PartNumber",
              "locale": "en_US"
            },
            "model": {
              "displayValue": "82505",
              "label": "Model",
              "locale": "en_US"
            }
          },
          "productInfo": {
            "color": {
              "displayValue": "Red",
              "label": "Color",
              "locale": "en_US"
            },
            "itemDimensions": {
              "height": {
                "displayValue": 10,
                "label": "Height",
                "locale": "en_US",
                "unit": "inches"
              },
              "length": {
                "displayValue": 10,
                "label": "Length",
                "locale": "en_US",
                "unit": "inches"
              },
              "weight": {
                "displayValue": 3.35,
                "label": "Weight",
                "locale": "en_US",
                "unit": "pounds"
              },
              "width": {
                "displayValue": 13,
                "label": "Width",
                "locale": "en_US",
                "unit": "inches"
              }
            },
            "size": {
              "displayValue": "Stir Crazy",
              "label": "Size",
              "locale": "en_US"
            },
            "unitCount": {
              "displayValue": 1,
              "label": "NumberOfItems",
              "locale": "en_US"
            }
          },
          "technicalInfo": {
            "formats": {
              "displayValues": [
                "Box set"
              ],
              "label": "Format",
              "locale": "en_GB"
            }
          },
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
              "amount": 24.05,
              "currency": "USD",
              "displayAmount": "$24.05"
            }
          }
        }
      }
    ]
  }
}
```

## ItemInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_item-info#title.html`

# ItemInfo

## Description

The `ItemInfo` high level resource is a collection of large number of attributes logically grouped into a resource. i.e. ItemInfo is a collection of resources where each resource contains several attributes.

## Availability

All locales. However, the attributes returned varies with locale and the category of the item.

#### ItemInfo Container

The structure of attribute container inside the high level ItemInfo Resource is as follows:

Copy

```
{
  "itemInfoResource": {
    "attributeName": {
      "displayValue": "The display value of the particular attribute",
      "label": "The attribute name in the specified locale",
      "locale": "The locale in which the attribute is returned"
    }
  }
}
```

## Response Elements

Resource Name

Description

[ByLineInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#bylineinfo.md)

Set of attributes that specifies basic information of the product.

[Classifications](./_creatorsapi_docs_en-us_api-reference_resources_item-info#classifications.md)

Set of attributes that are used to classify an item into a particular category.

[ContentInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentinfo.md)

Set of attributes that are specific to the content like books, movies.

[Content Rating](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentrating.md)

Set of attributes that tell what age group is suitable to view said media.

[ExternalIds](./_creatorsapi_docs_en-us_api-reference_resources_item-info#externalids.md)

Set of identifiers that is used globally to identify a particular product.

[Features](./_creatorsapi_docs_en-us_api-reference_resources_item-info#features.md)

This attribute provides information about a product's key features.

[ManufactureInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#manufactureinfo.md)

Set of attributes that specifies manufacturing related information of an item

[ProductInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#productinfo.md)

Set of attributes that describes non-technical aspects of the item.

[TechnicalInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#technicalinfo.md)

Set of attributes that describes the technical aspects of the item.

[Title](./_creatorsapi_docs_en-us_api-reference_resources_item-info#title.md)

The title of the product.

[TradeInInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#tradeininfo.md)

Set of attributes that specifies trade-in information of an item.

### ByLineInfo

Attribute Name

Description

Brand

This attribute represents the brand of the item.

Contributors

This attribute represents the Contributors associated with the item. Use the `RoleType` parameter to filter by different types of role like `author`, `actor`, `director` etc.

Manufacturer

This attribute represents the Manufacturer of the item.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "byLineInfo": {
            "brand": {
                "displayValue": "West Bend",
                "label": "Brand",
                "locale": "en_US"
            },
            "manufacturer": {
                "displayValue": "Focus Electrics, LLC",
                "label": "Manufacturer",
                "locale": "en_US"
            },
            "contributors": [
                {
                    "locale": "de_DE",
                    "name": "Daniel Radcliffe",
                    "role": "Darsteller",
                    "roleType": "actor"
                },
                {
                    "locale": "en_US",
                    "name": "Rupert Grint",
                    "role": "Director",
                    "roleType": "director"
                }
            ]
        }
    }
}
```

### Classifications

Attribute Name

Description

Binding

Typically (but not always) similar to the product category.

ProductGroup

This attribute represents the product category an item belongs to. The name of a category, such as sporting goods, to which an item in the cart belongs.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "classifications": {
            "binding": {
                "displayValue": "Amazon Video",
                "label": "Binding",
                "locale": "en_GB"
            },
            "productGroup": {
                "displayValue": "Video On Demand",
                "label": "ProductGroup",
                "locale": "en_GB"
            }
        }
    }
}
```

### ContentInfo

Attribute Name

Description

Edition

This attribute represents edition or the version of the product.

Languages

This attribute represents languages associated with the product

PagesCount

This attribute represents the number of pages.

PublicationDate

This attribute represents the date of publication of the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentInfo": {
            "edition": {
                "displayValue": "Slp",
                "label": "Edition",
                "locale": "en_US"
            },
            "languages": {
                "displayValues": [
                    {
                        "displayValue": "English",
                        "type": "Published"
                    },
                    {
                        "displayValue": "English",
                        "type": "Dictionary"
                    }
                ],
                "label": "Language",
                "locale": "en_GB"
            },
            "pagesCount": {
                "displayValue": 4167,
                "label": "NumberOfPages",
                "locale": "en_US"
            },
            "publicationDate": {
                "displayValue": "2009-07-01T00:00:01Z",
                "label": "PublicationDate",
                "locale": "en_US"
            }
        }
    }
}
```

### ContentRating

Attribute Name

Description

AudienceRating

Audience rating for a movie. The rating suggests the age for which the movie is appropriate.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentRating": {
            "audienceRating": {
                "displayValue": "PG (Parental Guidance Suggested)",
                "label": "AudienceRating",
                "locale": "en_GB"
            }
        }
    }
}
```

### ExternalIds

Attribute Name

Description

EANs

European Article Number, which is a number that uniquely identifies an item.

ISBNs

The international standard book number associated with the product, consisting of a 10-digit alphanumeric string

UPCs

12-digit number found below the product's bar code

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "externalIds": {
            "eans": {
                "displayValues": [
                    "9780545162074",
                    "0717356278525"
                ],
                "label": "EAN",
                "locale": "en_US"
            },
            "isbns": {
                "displayValues": [
                    "0545162076"
                ],
                "label": "ISBN",
                "locale": "en_US"
            },
            "upcs": {
                "displayValues": [
                    "717356278525"
                ],
                "label": "UPC",
                "locale": "en_US"
            }
        }
    }
}
```

### Features

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "features": {
            "label": "Features",
            "locale": "en_US",
            "displayValues": [
                "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
                "Stir rod is motorized and improves popping, get more popped corn, larger kernels per batch",
                "Convenient nesting lid is ideal for small storage"
            ]
        }
    }
}
```

### ManufactureInfo

Attribute Name

Description

ItemPartNumber

This attribute represents the item's part number, which is sometimes the same as the model number

Model

This attribute represents the item's model name

Warranty

This attribute represents information related to the warranty provided for the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "manufactureInfo": {
            "itemPartNumber": {
                "displayValue": "MG4H2B/A",
                "label": "PartNumber",
                "locale": "en_US"
            },
            "model": {
                "displayValue": "6",
                "label": "Model",
                "locale": "en_US"
            },
            "warranty": {
                "displayValue": "No Manufacturer Warranty for this phone.",
                "label": "Warranty",
                "locale": "en_US"
            }
        }
    }
}
```

### ProductInfo

Attribute Name

Description

Color

This attribute indicates the color of the product

IsAdultProduct

Indicates if the product is considered to be for adults only.

ItemDimensions

Height, Length, Weight, and Width of the item.

ReleaseDate

Date on which the item was latest released

Size

This attribute provides information related to the size of the item

UnitCount

This attribute represents the total number of identical items that are in the selling unit.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "productInfo": {
            "color": {
                "displayValue": "brown trunk",
                "label": "Color",
                "locale": "en_US"
            },
            "isAdultProduct": {
                "displayValue": false,
                "label": "IsAdultProduct",
                "locale": "en_US"
            },
            "itemDimensions": {
                "height": {
                    "displayValue": 13.9,
                    "label": "Height",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "length": {
                    "displayValue": 18,
                    "label": "Length",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "weight": {
                    "displayValue": 20,
                    "label": "Weight",
                    "locale": "en_GB",
                    "unit": "Pounds"
                },
                "width": {
                    "displayValue": 7.7,
                    "label": "Width",
                    "locale": "en_GB",
                    "unit": "inches"
                }
            },
            "releaseDate": {
                "displayValue": "2013-03-01T00:00:00.000Z",
                "label": "ReleaseDate",
                "locale": "en_US"
            },
            "size": {
                "displayValue": "Small",
                "label": "Size",
                "locale": "en_US"
            },
            "unitCount": {
                "displayValue": 1,
                "label": "NumberOfItems",
                "locale": "en_US"
            }
        }
    }
}
```

### TechnicalInfo

Attribute Name

Description

Formats

Formats is used in various ways depending on the category to assist in describing an item. Format can be 4K, Blu-Ray, etc for Video, Kindle,PaperBack for books and so on

EnergyEfficiencyClass

Energy efficiency of the product. It can have various values based on the product’s type.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "formats": {
                "displayValues": [
                    "Box set"
                ],
                "label": "Format",
                "locale": "en_GB"
            }
        }
    }
}
```

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "energyEfficiencyClass": {
                "displayValue": "a_plus",
                "label": "EnergyEfficiencyClass",
                "locale": "en_GB"
            }
        }
    }
}
```

### Title

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
        }
    }
}
```

### TradeInInfo

Attribute Name

Description

IsEligibleForTradeIn

Specifies whether or not the item is eligible for trade-in.

Price

Specifies trade-in price of the item. This includes amount, currency and display amount of the trade-in price.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
                 "amount": 24.05,
                 "currency": "USD",
                 "displayAmount": "$24.05"
            }
        }
    }
}
```

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Sample Use Cases

### Example 1

Get the title of an item in default locale.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          }
        }
      }
    ]
  }
}
```

### Example 2

Get the title of the product in preferred language of preference.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["8424916514"],
    "languagesOfPreference": ["es_US"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "8424916514",
        "detailPageURL": "https://www.amazon.com/dp/8424916514?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Descripcion de Grecia / Description of Greece: Libros I-ii (Spanish Edition)",
            "label": "Title",
            "locale": "es_US"
          }
        }
      }
    ]
  }
}
```

### Example 3

Get all the attributes related to an item.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": [
        "itemInfo.byLineInfo",
        "itemInfo.contentInfo",
        "itemInfo.contentRating",
        "itemInfo.classifications",
        "itemInfo.externalIds",
        "itemInfo.features",
        "itemInfo.manufactureInfo",
        "itemInfo.productInfo",
        "itemInfo.technicalInfo",
        "itemInfo.title",
        "itemInfo.tradeInInfo"
    ]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "byLineInfo": {
            "brand": {
              "displayValue": "West Bend",
              "label": "Brand",
              "locale": "en_US"
            },
            "manufacturer": {
              "displayValue": "West Bend",
              "label": "Manufacturer",
              "locale": "en_US"
            }
          },
          "classifications": {
            "binding": {
              "displayValue": "Cocina",
              "label": "Binding",
              "locale": "es_US"
            },
            "productGroup": {
              "displayValue": "Cocina",
              "label": "ProductGroup",
              "locale": "es_US"
            }
          },
          "contentInfo": {
            "edition": {
              "displayValue": "Slp",
              "label": "Edition",
              "locale": "en_US"
            }
          },
          "contentRating": {
            "audienceRating": {
              "displayValue": "PG (Parental Guidance Suggested)",
              "label": "AudienceRating",
              "locale": "en_GB"
            }
          },
          "externalIds": {
            "eans": {
              "displayValues": [
                "0784331985907",
                "6689306520104"
              ],
              "label": "EAN",
              "locale": "en_US"
            },
            "upcs": {
              "displayValues": [
                "885330102972",
                "072244825053"
              ],
              "label": "UPC",
              "locale": "en_US"
            }
          },
          "features": {
            "displayValues": [
              "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
              "Plate is nonstick Coated for easy clean up"
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": {
            "itemPartNumber": {
              "displayValue": "82505",
              "label": "PartNumber",
              "locale": "en_US"
            },
            "model": {
              "displayValue": "82505",
              "label": "Model",
              "locale": "en_US"
            }
          },
          "productInfo": {
            "color": {
              "displayValue": "Red",
              "label": "Color",
              "locale": "en_US"
            },
            "itemDimensions": {
              "height": {
                "displayValue": 10,
                "label": "Height",
                "locale": "en_US",
                "unit": "inches"
              },
              "length": {
                "displayValue": 10,
                "label": "Length",
                "locale": "en_US",
                "unit": "inches"
              },
              "weight": {
                "displayValue": 3.35,
                "label": "Weight",
                "locale": "en_US",
                "unit": "pounds"
              },
              "width": {
                "displayValue": 13,
                "label": "Width",
                "locale": "en_US",
                "unit": "inches"
              }
            },
            "size": {
              "displayValue": "Stir Crazy",
              "label": "Size",
              "locale": "en_US"
            },
            "unitCount": {
              "displayValue": 1,
              "label": "NumberOfItems",
              "locale": "en_US"
            }
          },
          "technicalInfo": {
            "formats": {
              "displayValues": [
                "Box set"
              ],
              "label": "Format",
              "locale": "en_GB"
            }
          },
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
              "amount": 24.05,
              "currency": "USD",
              "displayAmount": "$24.05"
            }
          }
        }
      }
    ]
  }
}
```

## ItemInfo

Source: `_creatorsapi_docs_en-us_api-reference_resources_item-info#tradeininfo.html`

# ItemInfo

## Description

The `ItemInfo` high level resource is a collection of large number of attributes logically grouped into a resource. i.e. ItemInfo is a collection of resources where each resource contains several attributes.

## Availability

All locales. However, the attributes returned varies with locale and the category of the item.

#### ItemInfo Container

The structure of attribute container inside the high level ItemInfo Resource is as follows:

Copy

```
{
  "itemInfoResource": {
    "attributeName": {
      "displayValue": "The display value of the particular attribute",
      "label": "The attribute name in the specified locale",
      "locale": "The locale in which the attribute is returned"
    }
  }
}
```

## Response Elements

Resource Name

Description

[ByLineInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#bylineinfo.md)

Set of attributes that specifies basic information of the product.

[Classifications](./_creatorsapi_docs_en-us_api-reference_resources_item-info#classifications.md)

Set of attributes that are used to classify an item into a particular category.

[ContentInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentinfo.md)

Set of attributes that are specific to the content like books, movies.

[Content Rating](./_creatorsapi_docs_en-us_api-reference_resources_item-info#contentrating.md)

Set of attributes that tell what age group is suitable to view said media.

[ExternalIds](./_creatorsapi_docs_en-us_api-reference_resources_item-info#externalids.md)

Set of identifiers that is used globally to identify a particular product.

[Features](./_creatorsapi_docs_en-us_api-reference_resources_item-info#features.md)

This attribute provides information about a product's key features.

[ManufactureInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#manufactureinfo.md)

Set of attributes that specifies manufacturing related information of an item

[ProductInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#productinfo.md)

Set of attributes that describes non-technical aspects of the item.

[TechnicalInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#technicalinfo.md)

Set of attributes that describes the technical aspects of the item.

[Title](./_creatorsapi_docs_en-us_api-reference_resources_item-info#title.md)

The title of the product.

[TradeInInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info#tradeininfo.md)

Set of attributes that specifies trade-in information of an item.

### ByLineInfo

Attribute Name

Description

Brand

This attribute represents the brand of the item.

Contributors

This attribute represents the Contributors associated with the item. Use the `RoleType` parameter to filter by different types of role like `author`, `actor`, `director` etc.

Manufacturer

This attribute represents the Manufacturer of the item.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "byLineInfo": {
            "brand": {
                "displayValue": "West Bend",
                "label": "Brand",
                "locale": "en_US"
            },
            "manufacturer": {
                "displayValue": "Focus Electrics, LLC",
                "label": "Manufacturer",
                "locale": "en_US"
            },
            "contributors": [
                {
                    "locale": "de_DE",
                    "name": "Daniel Radcliffe",
                    "role": "Darsteller",
                    "roleType": "actor"
                },
                {
                    "locale": "en_US",
                    "name": "Rupert Grint",
                    "role": "Director",
                    "roleType": "director"
                }
            ]
        }
    }
}
```

### Classifications

Attribute Name

Description

Binding

Typically (but not always) similar to the product category.

ProductGroup

This attribute represents the product category an item belongs to. The name of a category, such as sporting goods, to which an item in the cart belongs.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "classifications": {
            "binding": {
                "displayValue": "Amazon Video",
                "label": "Binding",
                "locale": "en_GB"
            },
            "productGroup": {
                "displayValue": "Video On Demand",
                "label": "ProductGroup",
                "locale": "en_GB"
            }
        }
    }
}
```

### ContentInfo

Attribute Name

Description

Edition

This attribute represents edition or the version of the product.

Languages

This attribute represents languages associated with the product

PagesCount

This attribute represents the number of pages.

PublicationDate

This attribute represents the date of publication of the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentInfo": {
            "edition": {
                "displayValue": "Slp",
                "label": "Edition",
                "locale": "en_US"
            },
            "languages": {
                "displayValues": [
                    {
                        "displayValue": "English",
                        "type": "Published"
                    },
                    {
                        "displayValue": "English",
                        "type": "Dictionary"
                    }
                ],
                "label": "Language",
                "locale": "en_GB"
            },
            "pagesCount": {
                "displayValue": 4167,
                "label": "NumberOfPages",
                "locale": "en_US"
            },
            "publicationDate": {
                "displayValue": "2009-07-01T00:00:01Z",
                "label": "PublicationDate",
                "locale": "en_US"
            }
        }
    }
}
```

### ContentRating

Attribute Name

Description

AudienceRating

Audience rating for a movie. The rating suggests the age for which the movie is appropriate.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "contentRating": {
            "audienceRating": {
                "displayValue": "PG (Parental Guidance Suggested)",
                "label": "AudienceRating",
                "locale": "en_GB"
            }
        }
    }
}
```

### ExternalIds

Attribute Name

Description

EANs

European Article Number, which is a number that uniquely identifies an item.

ISBNs

The international standard book number associated with the product, consisting of a 10-digit alphanumeric string

UPCs

12-digit number found below the product's bar code

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "externalIds": {
            "eans": {
                "displayValues": [
                    "9780545162074",
                    "0717356278525"
                ],
                "label": "EAN",
                "locale": "en_US"
            },
            "isbns": {
                "displayValues": [
                    "0545162076"
                ],
                "label": "ISBN",
                "locale": "en_US"
            },
            "upcs": {
                "displayValues": [
                    "717356278525"
                ],
                "label": "UPC",
                "locale": "en_US"
            }
        }
    }
}
```

### Features

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "features": {
            "label": "Features",
            "locale": "en_US",
            "displayValues": [
                "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
                "Stir rod is motorized and improves popping, get more popped corn, larger kernels per batch",
                "Convenient nesting lid is ideal for small storage"
            ]
        }
    }
}
```

### ManufactureInfo

Attribute Name

Description

ItemPartNumber

This attribute represents the item's part number, which is sometimes the same as the model number

Model

This attribute represents the item's model name

Warranty

This attribute represents information related to the warranty provided for the product

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "manufactureInfo": {
            "itemPartNumber": {
                "displayValue": "MG4H2B/A",
                "label": "PartNumber",
                "locale": "en_US"
            },
            "model": {
                "displayValue": "6",
                "label": "Model",
                "locale": "en_US"
            },
            "warranty": {
                "displayValue": "No Manufacturer Warranty for this phone.",
                "label": "Warranty",
                "locale": "en_US"
            }
        }
    }
}
```

### ProductInfo

Attribute Name

Description

Color

This attribute indicates the color of the product

IsAdultProduct

Indicates if the product is considered to be for adults only.

ItemDimensions

Height, Length, Weight, and Width of the item.

ReleaseDate

Date on which the item was latest released

Size

This attribute provides information related to the size of the item

UnitCount

This attribute represents the total number of identical items that are in the selling unit.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "productInfo": {
            "color": {
                "displayValue": "brown trunk",
                "label": "Color",
                "locale": "en_US"
            },
            "isAdultProduct": {
                "displayValue": false,
                "label": "IsAdultProduct",
                "locale": "en_US"
            },
            "itemDimensions": {
                "height": {
                    "displayValue": 13.9,
                    "label": "Height",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "length": {
                    "displayValue": 18,
                    "label": "Length",
                    "locale": "en_GB",
                    "unit": "inches"
                },
                "weight": {
                    "displayValue": 20,
                    "label": "Weight",
                    "locale": "en_GB",
                    "unit": "Pounds"
                },
                "width": {
                    "displayValue": 7.7,
                    "label": "Width",
                    "locale": "en_GB",
                    "unit": "inches"
                }
            },
            "releaseDate": {
                "displayValue": "2013-03-01T00:00:00.000Z",
                "label": "ReleaseDate",
                "locale": "en_US"
            },
            "size": {
                "displayValue": "Small",
                "label": "Size",
                "locale": "en_US"
            },
            "unitCount": {
                "displayValue": 1,
                "label": "NumberOfItems",
                "locale": "en_US"
            }
        }
    }
}
```

### TechnicalInfo

Attribute Name

Description

Formats

Formats is used in various ways depending on the category to assist in describing an item. Format can be 4K, Blu-Ray, etc for Video, Kindle,PaperBack for books and so on

EnergyEfficiencyClass

Energy efficiency of the product. It can have various values based on the product’s type.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "formats": {
                "displayValues": [
                    "Box set"
                ],
                "label": "Format",
                "locale": "en_GB"
            }
        }
    }
}
```

Copy

```
{
    "itemInfo": {
        "technicalInfo": {
            "energyEfficiencyClass": {
                "displayValue": "a_plus",
                "label": "EnergyEfficiencyClass",
                "locale": "en_GB"
            }
        }
    }
}
```

### Title

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
        }
    }
}
```

### TradeInInfo

Attribute Name

Description

IsEligibleForTradeIn

Specifies whether or not the item is eligible for trade-in.

Price

Specifies trade-in price of the item. This includes amount, currency and display amount of the trade-in price.

#### Sample Response:

Copy

```
{
    "itemInfo": {
        "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
                 "amount": 24.05,
                 "currency": "USD",
                 "displayAmount": "$24.05"
            }
        }
    }
}
```

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariationsItems](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Sample Use Cases

### Example 1

Get the title of an item in default locale.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          }
        }
      }
    ]
  }
}
```

### Example 2

Get the title of the product in preferred language of preference.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["8424916514"],
    "languagesOfPreference": ["es_US"],
    "resources": ["itemInfo.title"]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "8424916514",
        "detailPageURL": "https://www.amazon.com/dp/8424916514?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "title": {
            "displayValue": "Descripcion de Grecia / Description of Greece: Libros I-ii (Spanish Edition)",
            "label": "Title",
            "locale": "es_US"
          }
        }
      }
    ]
  }
}
```

### Example 3

Get all the attributes related to an item.

#### Request Payload

Copy

```
{
    "partnerTag": "xyz-20",
    "itemIds": ["B00KL8SM92"],
    "resources": [
        "itemInfo.byLineInfo",
        "itemInfo.contentInfo",
        "itemInfo.contentRating",
        "itemInfo.classifications",
        "itemInfo.externalIds",
        "itemInfo.features",
        "itemInfo.manufactureInfo",
        "itemInfo.productInfo",
        "itemInfo.technicalInfo",
        "itemInfo.title",
        "itemInfo.tradeInInfo"
    ]
}
```

#### Response

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B00KL8SM92",
        "detailPageURL": "https://www.amazon.com/dp/B00KL8SM92?tag=xyz-20&linkCode=ogi&language=es_US&th=1&psc=1",
        "itemInfo": {
          "byLineInfo": {
            "brand": {
              "displayValue": "West Bend",
              "label": "Brand",
              "locale": "en_US"
            },
            "manufacturer": {
              "displayValue": "West Bend",
              "label": "Manufacturer",
              "locale": "en_US"
            }
          },
          "classifications": {
            "binding": {
              "displayValue": "Cocina",
              "label": "Binding",
              "locale": "es_US"
            },
            "productGroup": {
              "displayValue": "Cocina",
              "label": "ProductGroup",
              "locale": "es_US"
            }
          },
          "contentInfo": {
            "edition": {
              "displayValue": "Slp",
              "label": "Edition",
              "locale": "en_US"
            }
          },
          "contentRating": {
            "audienceRating": {
              "displayValue": "PG (Parental Guidance Suggested)",
              "label": "AudienceRating",
              "locale": "en_GB"
            }
          },
          "externalIds": {
            "eans": {
              "displayValues": [
                "0784331985907",
                "6689306520104"
              ],
              "label": "EAN",
              "locale": "en_US"
            },
            "upcs": {
              "displayValues": [
                "885330102972",
                "072244825053"
              ],
              "label": "UPC",
              "locale": "en_US"
            }
          },
          "features": {
            "displayValues": [
              "Vented clear cover doubles as a 6-quart capacity popcorn bowl",
              "Plate is nonstick Coated for easy clean up"
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": {
            "itemPartNumber": {
              "displayValue": "82505",
              "label": "PartNumber",
              "locale": "en_US"
            },
            "model": {
              "displayValue": "82505",
              "label": "Model",
              "locale": "en_US"
            }
          },
          "productInfo": {
            "color": {
              "displayValue": "Red",
              "label": "Color",
              "locale": "en_US"
            },
            "itemDimensions": {
              "height": {
                "displayValue": 10,
                "label": "Height",
                "locale": "en_US",
                "unit": "inches"
              },
              "length": {
                "displayValue": 10,
                "label": "Length",
                "locale": "en_US",
                "unit": "inches"
              },
              "weight": {
                "displayValue": 3.35,
                "label": "Weight",
                "locale": "en_US",
                "unit": "pounds"
              },
              "width": {
                "displayValue": 13,
                "label": "Width",
                "locale": "en_US",
                "unit": "inches"
              }
            },
            "size": {
              "displayValue": "Stir Crazy",
              "label": "Size",
              "locale": "en_US"
            },
            "unitCount": {
              "displayValue": 1,
              "label": "NumberOfItems",
              "locale": "en_US"
            }
          },
          "technicalInfo": {
            "formats": {
              "displayValues": [
                "Box set"
              ],
              "label": "Format",
              "locale": "en_GB"
            }
          },
          "title": {
            "displayValue": "West Bend 82505 Stir Crazy Popcorn Popper, 6-Quart",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": {
            "isEligibleForTradeIn": true,
            "price": {
              "amount": 24.05,
              "currency": "USD",
              "displayAmount": "$24.05"
            }
          }
        }
      }
    ]
  }
}
```

## OffersV2

Source: `_creatorsapi_docs_en-us_api-reference_resources_offersV2.html`

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

## Page Not Found

Source: `_creatorsapi_docs_en-us_api-reference_resources_offersV2.md#offersv1-to-offersv2-field-mapping.html`

# Page Not Found

The page you are looking for does not exist.

## OffersV2

Source: `_creatorsapi_docs_en-us_api-reference_resources_offersV2#availability.html`

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

## OffersV2

Source: `_creatorsapi_docs_en-us_api-reference_resources_offersV2#condition.html`

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

## OffersV2

Source: `_creatorsapi_docs_en-us_api-reference_resources_offersV2#dealdetails.html`

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

## OffersV2

Source: `_creatorsapi_docs_en-us_api-reference_resources_offersV2#listings.html`

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

## OffersV2

Source: `_creatorsapi_docs_en-us_api-reference_resources_offersV2#loyaltypoints.html`

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

## OffersV2

Source: `_creatorsapi_docs_en-us_api-reference_resources_offersV2#merchantinfo.html`

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

## OffersV2

Source: `_creatorsapi_docs_en-us_api-reference_resources_offersV2#minimum-advertising-price.html`

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

## OffersV2

Source: `_creatorsapi_docs_en-us_api-reference_resources_offersV2#money.html`

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

## OffersV2

Source: `_creatorsapi_docs_en-us_api-reference_resources_offersV2#price.html`

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

## OffersV2

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

## OffersV2

Source: `_creatorsapi_docs_en-us_api-reference_resources_offersV2#savings.html`

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

## ParentASIN

Source: `_creatorsapi_docs_en-us_api-reference_resources_parent-asin.html`

# ParentASIN

An item can come in a variety of sizes and colors. Each color and size combination is called a variation or child ASIN. The abstraction of the variations is called the parent ASIN. The child ASIN is the specific variation of the product (Levi’s 501 Jeans size large and color black). Because the parent ASIN is an abstraction, it can't be purchased and hence is not associated with an offer. For more information on variations and parent ASIN, refer [Variations Use Case](./_creatorsapi_docs_en-us_use-cases_organization-of-items-on-amazon_variations.md).

A product with variations can have several variations. The Amazon Product Landing Page for a parentASIN will have all variation attributes unselected and would lack the offer information. Customers have flexibility to select the variation attribute to land on the product landing page of the desired variation child ASIN.

The parentASIN resource returns the parent ASIN of an item.

## Availability

All locales.

## Relevant Operations

Operations that can use these resources include:

-   [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)
-   [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)
-   [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

## Sample Use Cases

### Example

Get the parent ASIN of an item.

#### Request Payload

Copy

```
{
"associateTag": "xyz-20",
"itemIds": ["B00TSUGXKE"],
"resources": ["parentASIN"]
}
```

#### Response

Copy

```
{
"asin": "B00TSUGXKE",
"parentASIN": "B010BWYDYA"
}
```

## SearchRefinements

Source: `_creatorsapi_docs_en-us_api-reference_resources_search-refinements.html`

# SearchRefinements

The `searchRefinements` resource can be requested to get dynamic SearchIndexes, BrowseNodes and Refinements for a search request. The resource is relevant for only [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) operation.

## Availability

All locales. However, the various refinements returned differ by locale.

## Features

The relevant search categories/sub-categories and dynamic refinements returned as part of `searchRefinements` resource can be used to refine the search request. The SearchRefinements resource, if requested, returns:

-   Relevant SearchIndices when the search request is inside `"All"` SearchIndex. Use the relevant SearchIndices returned to fire subsequent search request in a particular SearchIndex. Note that search requests under a targeted category (i.e. other than "All") returns more relevant products. The SearchRefinement resource helps you find the most relevant search index for your search request. For list of SearchIndices, refer [Locale Reference](./_creatorsapi_docs_en-us_locale-reference.md).
-   Relevant BrowseNodeIds when the search request is inside any category other than "All". Use the relevant BrowseNodeId to fire subsequent search request in a particular sub-category to further refine your search scope and get better results.
-   Dynamic refinements (if applicable) are returned for each search request. For example, if the search request is in Books SearchIndex and the target Amazon marketplace supports Author refinements, you'll get relevant author names as dynamic refinements.

## Response Elements

Each of the response element is encapsulated inside a Refinement container which contains details about the refinement ID, display name and the refinement value. For more information, refer Refinement Container.

Name

Description

SearchIndex

Container for SearchIndexes relevant for a search request. The container includes SearchIndex value and it's display name. The SearchIndex value can be used to fire subsequent request in a particular search category. For more information, refer [SearchIndexes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#searchindexes-response-element.md)

BrowseNode

Container for dynamic BrowseNodes information for a particular search request. The container includes list of BrowseNodeIDs and their corresponding display name. The BrowseNodeID can be used to fire subsequent request in a particular sub-category. For more information, refer [BrowseNodes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#browsenodes-response-element.md)

OtherRefinements

Container for dynamic refinements for a search request which includes ID (which is also a request parameter of SearchItems operation), and bins. For more information, refer [OtherRefinements Response Element](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#otherrefinements-response-element.md)

#### Refinement Container

This is a generic container for all the types of refinements vended out by `searchRefinements` Resource. A refinement container inside `searchRefinements` resource looks like this:

Copy

```
{
  "searchRefinements": {
    "refinementType": {
      "id": "SearchItems Parameter Name",
      "displayName": "Display Name of the Parameter",
      "bins": [
         /* Refinement values for the RefinementType */
        {
           "id": "The Actual Refinement Value",
           "displayName": "Display Name of the Refinement Value"
        }
      ]
    }
  }
}
```

> RefinementType are the various [Response Elements](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#response-elements.md) (SearchIndex/BrowseNode/etc) returned by the SearchRefinements. resource.

The following table briefly describes various attributes inside the Refinement Container:

Attribute Name

Description

Id

The `Id` tells us which [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) request parameter a particular refinement binds to. For example, for a `BrowseNode` refinement, the `Id` will be `BrowseNodeId`.

DisplayName

The display name of the refinement parameter on Amazon website which varies with locale. For example, the DisplayName for `BrowseNode` refinement will be `Department` in US locale.

Bins

Bins contain valid values for the refinement. The bins are again a container of `Id` and `DisplayName` where `Id` contains the actual refinement value which can be used for firing subsequent request to refine the search results. For example, the `Id` and `DisplayName` for a `BrowseNode` refinement can be `344520001` and `Women's Clothing` respectively. Here, the subsequent request can be fired by supplying `{ "BrowseNodeId": "344530001" }` in the request.

#### SearchIndexes Response Element

The structure of SearchIndexes element inside `searchRefinements` resource looks like:

Copy

```
{
  "searchRefinements": {
    "searchIndex": {
      "id": "SearchIndex",
      "displayName": "Department",
      "bins": [
        {
          "id": "AppsAndGames",
          "displayName": "Apps and Games"
        },
        {
          "id": "DigitalMusic",
          "displayName": "Digital Music"
        }
        /* More relevant SearchIndexes */
      ]
    }
  }
}
```

The SearchIndexes are returned for every search request inside `"All"` SearchIndex. Use the relevant SearchIndex to narrow down the search request inside a particular category. From the example above, if \*\*Digital Music \*\*seems to be the relevant category for your search request, then fire a subsequent request with `DigitalMusic` as the `SearchIndex`.

#### BrowseNodes Response Element

The structure of BrowseNodes element inside `searchRefinements` resource looks like:

Copy

```
{
  "searchRefinements": {
    "browseNode": {
      "id": "BrowseNodeId",
      "displayName": "Department",
      "bins": [
        {
          "id": "344520001",
          "displayName": "Women Clothing"
        },
        {
          "id": "2233000134",
          "displayName": "Men Clothing"
        }
        /* More relevant BrowseNodeIds */
      ]
    }
  }
}
```

The BrowseNodes are returned for every search request which are in a specific search index i.e. any search index other than "All". Use the relevant BrowseNodeId to narrow down the search request inside a particular sub-category. From the example above, if \*\*Women Clothing \*\*seems to be the relevant sub-category for your search request, then fire a subsequent request with `344520001` as the `BrowseNodeId`.

#### OtherRefinements Response Element

The structure of OtherRefinements element inside `searchRefinements` resource looks like:

Copy

```
{
 "searchRefinements": {
  "otherRefinements": [
    {
     "id": "Brand",
     "displayName": "Brand",
     "bins": [
        {
         "id": "Sony",
         "displayName": "Sony"
        },
        {
         "id": "Sony",
         "displayName": "Sony"
        }
      ]
    },
    {
      /* More Dynamic Refinements (if available) */
    }
  ]
 }
}
```

OtherRefinements are returned for every search request which are inside a particular search index and if the particular search index, marketplace combination supports a particular refinement. Use the `Bin Id` to fire subsequent request refining your search results. As of now, SearchRefinements resource returns dynamic values for following (if available in a particular SearchIndex and Marketplace):

-   Actor
-   Artist
-   Author
-   Brand

> There may be cases when you might get a certain refinement as response but the same doesn't work while firing subsequent request. For instance, you may get `Artist` refinement in `DigitalMusic` category searches but when `Artist` filter is used, you may get `NoResults`. In such cases, use the refinement values in `Keywords` to get desired results.

## Example Requests and Responses

The following examples demonstrate the SearchRefinements use cases

#### Example 1

The example demonstrates the SearchRefinements resource behavior when a search request in US marketplace is inside "All" category.

##### Request:

Copy

```
{
   "partnerTag": "xyz-20",
   "itemCount": 1,
   "keyword": "Harry Potter",
   "resources" : [ "searchRefinements" ]
}
```

##### Response:

Copy

```
{
  "searchResult": {
    "items": [
      {
        "asin": "0545162076",
        "detailPageURL": "https://www.amazon.com/dp/0545162076?tag=dgfd&linkCode=osi&th=1&psc=1"
      }
    ],
    "searchRefinements": {
      "searchIndex": {
        "id": "SearchIndex",
        "displayName": "Department",
        "bins": [
          {
            "id": "Books",
            "displayName": "Books"
          },
          {
            "id": "MoviesAndTV",
            "displayName": "Movies & TV"
          },
          {
            "id": "Fashion",
            "displayName": "Clothing, Shoes & Jewelry"
          },
          {
            "id": "HomeAndKitchen",
            "displayName": "Home & Kitchen"
          },
          {
            "id": "Beauty",
            "displayName": "Beauty & Personal Care"
          }
          / * More relevant Search Indexes */
        ]
      }
    },
    "searchURL": "https://www.amazon.com/s/?field-keywords=Harry+Potter&search-alias=aps&tag=xyz-20&linkCode=osi",
    "totalResultCount": 146
  }
}
```

Note that the most relevant search indexes are at top. That is, here, in this example, the Books search index is the most relevant one.

#### Example 2

The example demonstrates the SearchRefinements resource behavior when a search request for "Mystery Novels" keyword in US marketplace is inside "Books" category.

##### Request:

Copy

```
{
   "partnerTag": "xyz-20",
   "itemCount": 1,
   "keyword": "Mystery Novels",
   "searchIndex": "Books",
   "resources" : [ "searchRefinements" ]
}
```

##### Response:

Copy

```
{
  "searchResult": {
    "items": [
      {
        "asin": "1683993039",
        "detailPageURL": "https://www.amazon.com/dp/1683993039?tag=dgfd&linkCode=osi&th=1&psc=1"
      }
    ],
    "searchRefinements": {
      "browseNode": {
        "id": "BrowseNodeId",
        "displayName": "Department",
        "bins": [
          {
            "id": "17",
            "displayName": "Literature & Fiction"
          },
          {
            "id": "18",
            "displayName": "Mystery, Thriller & Suspense"
          },
          {
            "id": "23",
            "displayName": "Romance"
          }
          /* More relevant BrowseNodes */
        ]
      },
      "otherRefinements": [
        {
          "displayName": "Author",
          "id": "Author",
          "bins": [
            {
              "id": "Agatha Christie",
              "displayName": "Agatha Christie"
            },
            {
              "id": "Arthur Conan Doyle",
              "displayName": "Arthur Conan Doyle"
            },
            {
              "id": "Wilkie Collins",
              "displayName": "Wilkie Collins"
            }
            /* More relevant Authors */
          ]
        }
      ]
    },
    "searchURL": "https://www.amazon.com/s/?field-keywords=Mystery+Novels&search-alias=stripbooks&tag=xyz-20&linkCode=osi",
    "totalResultCount": 1200
  }
}
```

## SearchRefinements

Source: `_creatorsapi_docs_en-us_api-reference_resources_search-refinements#browsenodes-response-element.html`

# SearchRefinements

The `searchRefinements` resource can be requested to get dynamic SearchIndexes, BrowseNodes and Refinements for a search request. The resource is relevant for only [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) operation.

## Availability

All locales. However, the various refinements returned differ by locale.

## Features

The relevant search categories/sub-categories and dynamic refinements returned as part of `searchRefinements` resource can be used to refine the search request. The SearchRefinements resource, if requested, returns:

-   Relevant SearchIndices when the search request is inside `"All"` SearchIndex. Use the relevant SearchIndices returned to fire subsequent search request in a particular SearchIndex. Note that search requests under a targeted category (i.e. other than "All") returns more relevant products. The SearchRefinement resource helps you find the most relevant search index for your search request. For list of SearchIndices, refer [Locale Reference](./_creatorsapi_docs_en-us_locale-reference.md).
-   Relevant BrowseNodeIds when the search request is inside any category other than "All". Use the relevant BrowseNodeId to fire subsequent search request in a particular sub-category to further refine your search scope and get better results.
-   Dynamic refinements (if applicable) are returned for each search request. For example, if the search request is in Books SearchIndex and the target Amazon marketplace supports Author refinements, you'll get relevant author names as dynamic refinements.

## Response Elements

Each of the response element is encapsulated inside a Refinement container which contains details about the refinement ID, display name and the refinement value. For more information, refer Refinement Container.

Name

Description

SearchIndex

Container for SearchIndexes relevant for a search request. The container includes SearchIndex value and it's display name. The SearchIndex value can be used to fire subsequent request in a particular search category. For more information, refer [SearchIndexes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#searchindexes-response-element.md)

BrowseNode

Container for dynamic BrowseNodes information for a particular search request. The container includes list of BrowseNodeIDs and their corresponding display name. The BrowseNodeID can be used to fire subsequent request in a particular sub-category. For more information, refer [BrowseNodes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#browsenodes-response-element.md)

OtherRefinements

Container for dynamic refinements for a search request which includes ID (which is also a request parameter of SearchItems operation), and bins. For more information, refer [OtherRefinements Response Element](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#otherrefinements-response-element.md)

#### Refinement Container

This is a generic container for all the types of refinements vended out by `searchRefinements` Resource. A refinement container inside `searchRefinements` resource looks like this:

Copy

```
{
  "searchRefinements": {
    "refinementType": {
      "id": "SearchItems Parameter Name",
      "displayName": "Display Name of the Parameter",
      "bins": [
         /* Refinement values for the RefinementType */
        {
           "id": "The Actual Refinement Value",
           "displayName": "Display Name of the Refinement Value"
        }
      ]
    }
  }
}
```

> RefinementType are the various [Response Elements](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#response-elements.md) (SearchIndex/BrowseNode/etc) returned by the SearchRefinements. resource.

The following table briefly describes various attributes inside the Refinement Container:

Attribute Name

Description

Id

The `Id` tells us which [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) request parameter a particular refinement binds to. For example, for a `BrowseNode` refinement, the `Id` will be `BrowseNodeId`.

DisplayName

The display name of the refinement parameter on Amazon website which varies with locale. For example, the DisplayName for `BrowseNode` refinement will be `Department` in US locale.

Bins

Bins contain valid values for the refinement. The bins are again a container of `Id` and `DisplayName` where `Id` contains the actual refinement value which can be used for firing subsequent request to refine the search results. For example, the `Id` and `DisplayName` for a `BrowseNode` refinement can be `344520001` and `Women's Clothing` respectively. Here, the subsequent request can be fired by supplying `{ "BrowseNodeId": "344530001" }` in the request.

#### SearchIndexes Response Element

The structure of SearchIndexes element inside `searchRefinements` resource looks like:

Copy

```
{
  "searchRefinements": {
    "searchIndex": {
      "id": "SearchIndex",
      "displayName": "Department",
      "bins": [
        {
          "id": "AppsAndGames",
          "displayName": "Apps and Games"
        },
        {
          "id": "DigitalMusic",
          "displayName": "Digital Music"
        }
        /* More relevant SearchIndexes */
      ]
    }
  }
}
```

The SearchIndexes are returned for every search request inside `"All"` SearchIndex. Use the relevant SearchIndex to narrow down the search request inside a particular category. From the example above, if \*\*Digital Music \*\*seems to be the relevant category for your search request, then fire a subsequent request with `DigitalMusic` as the `SearchIndex`.

#### BrowseNodes Response Element

The structure of BrowseNodes element inside `searchRefinements` resource looks like:

Copy

```
{
  "searchRefinements": {
    "browseNode": {
      "id": "BrowseNodeId",
      "displayName": "Department",
      "bins": [
        {
          "id": "344520001",
          "displayName": "Women Clothing"
        },
        {
          "id": "2233000134",
          "displayName": "Men Clothing"
        }
        /* More relevant BrowseNodeIds */
      ]
    }
  }
}
```

The BrowseNodes are returned for every search request which are in a specific search index i.e. any search index other than "All". Use the relevant BrowseNodeId to narrow down the search request inside a particular sub-category. From the example above, if \*\*Women Clothing \*\*seems to be the relevant sub-category for your search request, then fire a subsequent request with `344520001` as the `BrowseNodeId`.

#### OtherRefinements Response Element

The structure of OtherRefinements element inside `searchRefinements` resource looks like:

Copy

```
{
 "searchRefinements": {
  "otherRefinements": [
    {
     "id": "Brand",
     "displayName": "Brand",
     "bins": [
        {
         "id": "Sony",
         "displayName": "Sony"
        },
        {
         "id": "Sony",
         "displayName": "Sony"
        }
      ]
    },
    {
      /* More Dynamic Refinements (if available) */
    }
  ]
 }
}
```

OtherRefinements are returned for every search request which are inside a particular search index and if the particular search index, marketplace combination supports a particular refinement. Use the `Bin Id` to fire subsequent request refining your search results. As of now, SearchRefinements resource returns dynamic values for following (if available in a particular SearchIndex and Marketplace):

-   Actor
-   Artist
-   Author
-   Brand

> There may be cases when you might get a certain refinement as response but the same doesn't work while firing subsequent request. For instance, you may get `Artist` refinement in `DigitalMusic` category searches but when `Artist` filter is used, you may get `NoResults`. In such cases, use the refinement values in `Keywords` to get desired results.

## Example Requests and Responses

The following examples demonstrate the SearchRefinements use cases

#### Example 1

The example demonstrates the SearchRefinements resource behavior when a search request in US marketplace is inside "All" category.

##### Request:

Copy

```
{
   "partnerTag": "xyz-20",
   "itemCount": 1,
   "keyword": "Harry Potter",
   "resources" : [ "searchRefinements" ]
}
```

##### Response:

Copy

```
{
  "searchResult": {
    "items": [
      {
        "asin": "0545162076",
        "detailPageURL": "https://www.amazon.com/dp/0545162076?tag=dgfd&linkCode=osi&th=1&psc=1"
      }
    ],
    "searchRefinements": {
      "searchIndex": {
        "id": "SearchIndex",
        "displayName": "Department",
        "bins": [
          {
            "id": "Books",
            "displayName": "Books"
          },
          {
            "id": "MoviesAndTV",
            "displayName": "Movies & TV"
          },
          {
            "id": "Fashion",
            "displayName": "Clothing, Shoes & Jewelry"
          },
          {
            "id": "HomeAndKitchen",
            "displayName": "Home & Kitchen"
          },
          {
            "id": "Beauty",
            "displayName": "Beauty & Personal Care"
          }
          / * More relevant Search Indexes */
        ]
      }
    },
    "searchURL": "https://www.amazon.com/s/?field-keywords=Harry+Potter&search-alias=aps&tag=xyz-20&linkCode=osi",
    "totalResultCount": 146
  }
}
```

Note that the most relevant search indexes are at top. That is, here, in this example, the Books search index is the most relevant one.

#### Example 2

The example demonstrates the SearchRefinements resource behavior when a search request for "Mystery Novels" keyword in US marketplace is inside "Books" category.

##### Request:

Copy

```
{
   "partnerTag": "xyz-20",
   "itemCount": 1,
   "keyword": "Mystery Novels",
   "searchIndex": "Books",
   "resources" : [ "searchRefinements" ]
}
```

##### Response:

Copy

```
{
  "searchResult": {
    "items": [
      {
        "asin": "1683993039",
        "detailPageURL": "https://www.amazon.com/dp/1683993039?tag=dgfd&linkCode=osi&th=1&psc=1"
      }
    ],
    "searchRefinements": {
      "browseNode": {
        "id": "BrowseNodeId",
        "displayName": "Department",
        "bins": [
          {
            "id": "17",
            "displayName": "Literature & Fiction"
          },
          {
            "id": "18",
            "displayName": "Mystery, Thriller & Suspense"
          },
          {
            "id": "23",
            "displayName": "Romance"
          }
          /* More relevant BrowseNodes */
        ]
      },
      "otherRefinements": [
        {
          "displayName": "Author",
          "id": "Author",
          "bins": [
            {
              "id": "Agatha Christie",
              "displayName": "Agatha Christie"
            },
            {
              "id": "Arthur Conan Doyle",
              "displayName": "Arthur Conan Doyle"
            },
            {
              "id": "Wilkie Collins",
              "displayName": "Wilkie Collins"
            }
            /* More relevant Authors */
          ]
        }
      ]
    },
    "searchURL": "https://www.amazon.com/s/?field-keywords=Mystery+Novels&search-alias=stripbooks&tag=xyz-20&linkCode=osi",
    "totalResultCount": 1200
  }
}
```

## SearchRefinements

Source: `_creatorsapi_docs_en-us_api-reference_resources_search-refinements#otherrefinements-response-element.html`

# SearchRefinements

The `searchRefinements` resource can be requested to get dynamic SearchIndexes, BrowseNodes and Refinements for a search request. The resource is relevant for only [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) operation.

## Availability

All locales. However, the various refinements returned differ by locale.

## Features

The relevant search categories/sub-categories and dynamic refinements returned as part of `searchRefinements` resource can be used to refine the search request. The SearchRefinements resource, if requested, returns:

-   Relevant SearchIndices when the search request is inside `"All"` SearchIndex. Use the relevant SearchIndices returned to fire subsequent search request in a particular SearchIndex. Note that search requests under a targeted category (i.e. other than "All") returns more relevant products. The SearchRefinement resource helps you find the most relevant search index for your search request. For list of SearchIndices, refer [Locale Reference](./_creatorsapi_docs_en-us_locale-reference.md).
-   Relevant BrowseNodeIds when the search request is inside any category other than "All". Use the relevant BrowseNodeId to fire subsequent search request in a particular sub-category to further refine your search scope and get better results.
-   Dynamic refinements (if applicable) are returned for each search request. For example, if the search request is in Books SearchIndex and the target Amazon marketplace supports Author refinements, you'll get relevant author names as dynamic refinements.

## Response Elements

Each of the response element is encapsulated inside a Refinement container which contains details about the refinement ID, display name and the refinement value. For more information, refer Refinement Container.

Name

Description

SearchIndex

Container for SearchIndexes relevant for a search request. The container includes SearchIndex value and it's display name. The SearchIndex value can be used to fire subsequent request in a particular search category. For more information, refer [SearchIndexes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#searchindexes-response-element.md)

BrowseNode

Container for dynamic BrowseNodes information for a particular search request. The container includes list of BrowseNodeIDs and their corresponding display name. The BrowseNodeID can be used to fire subsequent request in a particular sub-category. For more information, refer [BrowseNodes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#browsenodes-response-element.md)

OtherRefinements

Container for dynamic refinements for a search request which includes ID (which is also a request parameter of SearchItems operation), and bins. For more information, refer [OtherRefinements Response Element](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#otherrefinements-response-element.md)

#### Refinement Container

This is a generic container for all the types of refinements vended out by `searchRefinements` Resource. A refinement container inside `searchRefinements` resource looks like this:

Copy

```
{
  "searchRefinements": {
    "refinementType": {
      "id": "SearchItems Parameter Name",
      "displayName": "Display Name of the Parameter",
      "bins": [
         /* Refinement values for the RefinementType */
        {
           "id": "The Actual Refinement Value",
           "displayName": "Display Name of the Refinement Value"
        }
      ]
    }
  }
}
```

> RefinementType are the various [Response Elements](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#response-elements.md) (SearchIndex/BrowseNode/etc) returned by the SearchRefinements. resource.

The following table briefly describes various attributes inside the Refinement Container:

Attribute Name

Description

Id

The `Id` tells us which [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) request parameter a particular refinement binds to. For example, for a `BrowseNode` refinement, the `Id` will be `BrowseNodeId`.

DisplayName

The display name of the refinement parameter on Amazon website which varies with locale. For example, the DisplayName for `BrowseNode` refinement will be `Department` in US locale.

Bins

Bins contain valid values for the refinement. The bins are again a container of `Id` and `DisplayName` where `Id` contains the actual refinement value which can be used for firing subsequent request to refine the search results. For example, the `Id` and `DisplayName` for a `BrowseNode` refinement can be `344520001` and `Women's Clothing` respectively. Here, the subsequent request can be fired by supplying `{ "BrowseNodeId": "344530001" }` in the request.

#### SearchIndexes Response Element

The structure of SearchIndexes element inside `searchRefinements` resource looks like:

Copy

```
{
  "searchRefinements": {
    "searchIndex": {
      "id": "SearchIndex",
      "displayName": "Department",
      "bins": [
        {
          "id": "AppsAndGames",
          "displayName": "Apps and Games"
        },
        {
          "id": "DigitalMusic",
          "displayName": "Digital Music"
        }
        /* More relevant SearchIndexes */
      ]
    }
  }
}
```

The SearchIndexes are returned for every search request inside `"All"` SearchIndex. Use the relevant SearchIndex to narrow down the search request inside a particular category. From the example above, if \*\*Digital Music \*\*seems to be the relevant category for your search request, then fire a subsequent request with `DigitalMusic` as the `SearchIndex`.

#### BrowseNodes Response Element

The structure of BrowseNodes element inside `searchRefinements` resource looks like:

Copy

```
{
  "searchRefinements": {
    "browseNode": {
      "id": "BrowseNodeId",
      "displayName": "Department",
      "bins": [
        {
          "id": "344520001",
          "displayName": "Women Clothing"
        },
        {
          "id": "2233000134",
          "displayName": "Men Clothing"
        }
        /* More relevant BrowseNodeIds */
      ]
    }
  }
}
```

The BrowseNodes are returned for every search request which are in a specific search index i.e. any search index other than "All". Use the relevant BrowseNodeId to narrow down the search request inside a particular sub-category. From the example above, if \*\*Women Clothing \*\*seems to be the relevant sub-category for your search request, then fire a subsequent request with `344520001` as the `BrowseNodeId`.

#### OtherRefinements Response Element

The structure of OtherRefinements element inside `searchRefinements` resource looks like:

Copy

```
{
 "searchRefinements": {
  "otherRefinements": [
    {
     "id": "Brand",
     "displayName": "Brand",
     "bins": [
        {
         "id": "Sony",
         "displayName": "Sony"
        },
        {
         "id": "Sony",
         "displayName": "Sony"
        }
      ]
    },
    {
      /* More Dynamic Refinements (if available) */
    }
  ]
 }
}
```

OtherRefinements are returned for every search request which are inside a particular search index and if the particular search index, marketplace combination supports a particular refinement. Use the `Bin Id` to fire subsequent request refining your search results. As of now, SearchRefinements resource returns dynamic values for following (if available in a particular SearchIndex and Marketplace):

-   Actor
-   Artist
-   Author
-   Brand

> There may be cases when you might get a certain refinement as response but the same doesn't work while firing subsequent request. For instance, you may get `Artist` refinement in `DigitalMusic` category searches but when `Artist` filter is used, you may get `NoResults`. In such cases, use the refinement values in `Keywords` to get desired results.

## Example Requests and Responses

The following examples demonstrate the SearchRefinements use cases

#### Example 1

The example demonstrates the SearchRefinements resource behavior when a search request in US marketplace is inside "All" category.

##### Request:

Copy

```
{
   "partnerTag": "xyz-20",
   "itemCount": 1,
   "keyword": "Harry Potter",
   "resources" : [ "searchRefinements" ]
}
```

##### Response:

Copy

```
{
  "searchResult": {
    "items": [
      {
        "asin": "0545162076",
        "detailPageURL": "https://www.amazon.com/dp/0545162076?tag=dgfd&linkCode=osi&th=1&psc=1"
      }
    ],
    "searchRefinements": {
      "searchIndex": {
        "id": "SearchIndex",
        "displayName": "Department",
        "bins": [
          {
            "id": "Books",
            "displayName": "Books"
          },
          {
            "id": "MoviesAndTV",
            "displayName": "Movies & TV"
          },
          {
            "id": "Fashion",
            "displayName": "Clothing, Shoes & Jewelry"
          },
          {
            "id": "HomeAndKitchen",
            "displayName": "Home & Kitchen"
          },
          {
            "id": "Beauty",
            "displayName": "Beauty & Personal Care"
          }
          / * More relevant Search Indexes */
        ]
      }
    },
    "searchURL": "https://www.amazon.com/s/?field-keywords=Harry+Potter&search-alias=aps&tag=xyz-20&linkCode=osi",
    "totalResultCount": 146
  }
}
```

Note that the most relevant search indexes are at top. That is, here, in this example, the Books search index is the most relevant one.

#### Example 2

The example demonstrates the SearchRefinements resource behavior when a search request for "Mystery Novels" keyword in US marketplace is inside "Books" category.

##### Request:

Copy

```
{
   "partnerTag": "xyz-20",
   "itemCount": 1,
   "keyword": "Mystery Novels",
   "searchIndex": "Books",
   "resources" : [ "searchRefinements" ]
}
```

##### Response:

Copy

```
{
  "searchResult": {
    "items": [
      {
        "asin": "1683993039",
        "detailPageURL": "https://www.amazon.com/dp/1683993039?tag=dgfd&linkCode=osi&th=1&psc=1"
      }
    ],
    "searchRefinements": {
      "browseNode": {
        "id": "BrowseNodeId",
        "displayName": "Department",
        "bins": [
          {
            "id": "17",
            "displayName": "Literature & Fiction"
          },
          {
            "id": "18",
            "displayName": "Mystery, Thriller & Suspense"
          },
          {
            "id": "23",
            "displayName": "Romance"
          }
          /* More relevant BrowseNodes */
        ]
      },
      "otherRefinements": [
        {
          "displayName": "Author",
          "id": "Author",
          "bins": [
            {
              "id": "Agatha Christie",
              "displayName": "Agatha Christie"
            },
            {
              "id": "Arthur Conan Doyle",
              "displayName": "Arthur Conan Doyle"
            },
            {
              "id": "Wilkie Collins",
              "displayName": "Wilkie Collins"
            }
            /* More relevant Authors */
          ]
        }
      ]
    },
    "searchURL": "https://www.amazon.com/s/?field-keywords=Mystery+Novels&search-alias=stripbooks&tag=xyz-20&linkCode=osi",
    "totalResultCount": 1200
  }
}
```

## SearchRefinements

Source: `_creatorsapi_docs_en-us_api-reference_resources_search-refinements#response-elements.html`

# SearchRefinements

The `searchRefinements` resource can be requested to get dynamic SearchIndexes, BrowseNodes and Refinements for a search request. The resource is relevant for only [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) operation.

## Availability

All locales. However, the various refinements returned differ by locale.

## Features

The relevant search categories/sub-categories and dynamic refinements returned as part of `searchRefinements` resource can be used to refine the search request. The SearchRefinements resource, if requested, returns:

-   Relevant SearchIndices when the search request is inside `"All"` SearchIndex. Use the relevant SearchIndices returned to fire subsequent search request in a particular SearchIndex. Note that search requests under a targeted category (i.e. other than "All") returns more relevant products. The SearchRefinement resource helps you find the most relevant search index for your search request. For list of SearchIndices, refer [Locale Reference](./_creatorsapi_docs_en-us_locale-reference.md).
-   Relevant BrowseNodeIds when the search request is inside any category other than "All". Use the relevant BrowseNodeId to fire subsequent search request in a particular sub-category to further refine your search scope and get better results.
-   Dynamic refinements (if applicable) are returned for each search request. For example, if the search request is in Books SearchIndex and the target Amazon marketplace supports Author refinements, you'll get relevant author names as dynamic refinements.

## Response Elements

Each of the response element is encapsulated inside a Refinement container which contains details about the refinement ID, display name and the refinement value. For more information, refer Refinement Container.

Name

Description

SearchIndex

Container for SearchIndexes relevant for a search request. The container includes SearchIndex value and it's display name. The SearchIndex value can be used to fire subsequent request in a particular search category. For more information, refer [SearchIndexes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#searchindexes-response-element.md)

BrowseNode

Container for dynamic BrowseNodes information for a particular search request. The container includes list of BrowseNodeIDs and their corresponding display name. The BrowseNodeID can be used to fire subsequent request in a particular sub-category. For more information, refer [BrowseNodes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#browsenodes-response-element.md)

OtherRefinements

Container for dynamic refinements for a search request which includes ID (which is also a request parameter of SearchItems operation), and bins. For more information, refer [OtherRefinements Response Element](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#otherrefinements-response-element.md)

#### Refinement Container

This is a generic container for all the types of refinements vended out by `searchRefinements` Resource. A refinement container inside `searchRefinements` resource looks like this:

Copy

```
{
  "searchRefinements": {
    "refinementType": {
      "id": "SearchItems Parameter Name",
      "displayName": "Display Name of the Parameter",
      "bins": [
         /* Refinement values for the RefinementType */
        {
           "id": "The Actual Refinement Value",
           "displayName": "Display Name of the Refinement Value"
        }
      ]
    }
  }
}
```

> RefinementType are the various [Response Elements](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#response-elements.md) (SearchIndex/BrowseNode/etc) returned by the SearchRefinements. resource.

The following table briefly describes various attributes inside the Refinement Container:

Attribute Name

Description

Id

The `Id` tells us which [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) request parameter a particular refinement binds to. For example, for a `BrowseNode` refinement, the `Id` will be `BrowseNodeId`.

DisplayName

The display name of the refinement parameter on Amazon website which varies with locale. For example, the DisplayName for `BrowseNode` refinement will be `Department` in US locale.

Bins

Bins contain valid values for the refinement. The bins are again a container of `Id` and `DisplayName` where `Id` contains the actual refinement value which can be used for firing subsequent request to refine the search results. For example, the `Id` and `DisplayName` for a `BrowseNode` refinement can be `344520001` and `Women's Clothing` respectively. Here, the subsequent request can be fired by supplying `{ "BrowseNodeId": "344530001" }` in the request.

#### SearchIndexes Response Element

The structure of SearchIndexes element inside `searchRefinements` resource looks like:

Copy

```
{
  "searchRefinements": {
    "searchIndex": {
      "id": "SearchIndex",
      "displayName": "Department",
      "bins": [
        {
          "id": "AppsAndGames",
          "displayName": "Apps and Games"
        },
        {
          "id": "DigitalMusic",
          "displayName": "Digital Music"
        }
        /* More relevant SearchIndexes */
      ]
    }
  }
}
```

The SearchIndexes are returned for every search request inside `"All"` SearchIndex. Use the relevant SearchIndex to narrow down the search request inside a particular category. From the example above, if \*\*Digital Music \*\*seems to be the relevant category for your search request, then fire a subsequent request with `DigitalMusic` as the `SearchIndex`.

#### BrowseNodes Response Element

The structure of BrowseNodes element inside `searchRefinements` resource looks like:

Copy

```
{
  "searchRefinements": {
    "browseNode": {
      "id": "BrowseNodeId",
      "displayName": "Department",
      "bins": [
        {
          "id": "344520001",
          "displayName": "Women Clothing"
        },
        {
          "id": "2233000134",
          "displayName": "Men Clothing"
        }
        /* More relevant BrowseNodeIds */
      ]
    }
  }
}
```

The BrowseNodes are returned for every search request which are in a specific search index i.e. any search index other than "All". Use the relevant BrowseNodeId to narrow down the search request inside a particular sub-category. From the example above, if \*\*Women Clothing \*\*seems to be the relevant sub-category for your search request, then fire a subsequent request with `344520001` as the `BrowseNodeId`.

#### OtherRefinements Response Element

The structure of OtherRefinements element inside `searchRefinements` resource looks like:

Copy

```
{
 "searchRefinements": {
  "otherRefinements": [
    {
     "id": "Brand",
     "displayName": "Brand",
     "bins": [
        {
         "id": "Sony",
         "displayName": "Sony"
        },
        {
         "id": "Sony",
         "displayName": "Sony"
        }
      ]
    },
    {
      /* More Dynamic Refinements (if available) */
    }
  ]
 }
}
```

OtherRefinements are returned for every search request which are inside a particular search index and if the particular search index, marketplace combination supports a particular refinement. Use the `Bin Id` to fire subsequent request refining your search results. As of now, SearchRefinements resource returns dynamic values for following (if available in a particular SearchIndex and Marketplace):

-   Actor
-   Artist
-   Author
-   Brand

> There may be cases when you might get a certain refinement as response but the same doesn't work while firing subsequent request. For instance, you may get `Artist` refinement in `DigitalMusic` category searches but when `Artist` filter is used, you may get `NoResults`. In such cases, use the refinement values in `Keywords` to get desired results.

## Example Requests and Responses

The following examples demonstrate the SearchRefinements use cases

#### Example 1

The example demonstrates the SearchRefinements resource behavior when a search request in US marketplace is inside "All" category.

##### Request:

Copy

```
{
   "partnerTag": "xyz-20",
   "itemCount": 1,
   "keyword": "Harry Potter",
   "resources" : [ "searchRefinements" ]
}
```

##### Response:

Copy

```
{
  "searchResult": {
    "items": [
      {
        "asin": "0545162076",
        "detailPageURL": "https://www.amazon.com/dp/0545162076?tag=dgfd&linkCode=osi&th=1&psc=1"
      }
    ],
    "searchRefinements": {
      "searchIndex": {
        "id": "SearchIndex",
        "displayName": "Department",
        "bins": [
          {
            "id": "Books",
            "displayName": "Books"
          },
          {
            "id": "MoviesAndTV",
            "displayName": "Movies & TV"
          },
          {
            "id": "Fashion",
            "displayName": "Clothing, Shoes & Jewelry"
          },
          {
            "id": "HomeAndKitchen",
            "displayName": "Home & Kitchen"
          },
          {
            "id": "Beauty",
            "displayName": "Beauty & Personal Care"
          }
          / * More relevant Search Indexes */
        ]
      }
    },
    "searchURL": "https://www.amazon.com/s/?field-keywords=Harry+Potter&search-alias=aps&tag=xyz-20&linkCode=osi",
    "totalResultCount": 146
  }
}
```

Note that the most relevant search indexes are at top. That is, here, in this example, the Books search index is the most relevant one.

#### Example 2

The example demonstrates the SearchRefinements resource behavior when a search request for "Mystery Novels" keyword in US marketplace is inside "Books" category.

##### Request:

Copy

```
{
   "partnerTag": "xyz-20",
   "itemCount": 1,
   "keyword": "Mystery Novels",
   "searchIndex": "Books",
   "resources" : [ "searchRefinements" ]
}
```

##### Response:

Copy

```
{
  "searchResult": {
    "items": [
      {
        "asin": "1683993039",
        "detailPageURL": "https://www.amazon.com/dp/1683993039?tag=dgfd&linkCode=osi&th=1&psc=1"
      }
    ],
    "searchRefinements": {
      "browseNode": {
        "id": "BrowseNodeId",
        "displayName": "Department",
        "bins": [
          {
            "id": "17",
            "displayName": "Literature & Fiction"
          },
          {
            "id": "18",
            "displayName": "Mystery, Thriller & Suspense"
          },
          {
            "id": "23",
            "displayName": "Romance"
          }
          /* More relevant BrowseNodes */
        ]
      },
      "otherRefinements": [
        {
          "displayName": "Author",
          "id": "Author",
          "bins": [
            {
              "id": "Agatha Christie",
              "displayName": "Agatha Christie"
            },
            {
              "id": "Arthur Conan Doyle",
              "displayName": "Arthur Conan Doyle"
            },
            {
              "id": "Wilkie Collins",
              "displayName": "Wilkie Collins"
            }
            /* More relevant Authors */
          ]
        }
      ]
    },
    "searchURL": "https://www.amazon.com/s/?field-keywords=Mystery+Novels&search-alias=stripbooks&tag=xyz-20&linkCode=osi",
    "totalResultCount": 1200
  }
}
```

## SearchRefinements

Source: `_creatorsapi_docs_en-us_api-reference_resources_search-refinements#searchindexes-response-element.html`

# SearchRefinements

The `searchRefinements` resource can be requested to get dynamic SearchIndexes, BrowseNodes and Refinements for a search request. The resource is relevant for only [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) operation.

## Availability

All locales. However, the various refinements returned differ by locale.

## Features

The relevant search categories/sub-categories and dynamic refinements returned as part of `searchRefinements` resource can be used to refine the search request. The SearchRefinements resource, if requested, returns:

-   Relevant SearchIndices when the search request is inside `"All"` SearchIndex. Use the relevant SearchIndices returned to fire subsequent search request in a particular SearchIndex. Note that search requests under a targeted category (i.e. other than "All") returns more relevant products. The SearchRefinement resource helps you find the most relevant search index for your search request. For list of SearchIndices, refer [Locale Reference](./_creatorsapi_docs_en-us_locale-reference.md).
-   Relevant BrowseNodeIds when the search request is inside any category other than "All". Use the relevant BrowseNodeId to fire subsequent search request in a particular sub-category to further refine your search scope and get better results.
-   Dynamic refinements (if applicable) are returned for each search request. For example, if the search request is in Books SearchIndex and the target Amazon marketplace supports Author refinements, you'll get relevant author names as dynamic refinements.

## Response Elements

Each of the response element is encapsulated inside a Refinement container which contains details about the refinement ID, display name and the refinement value. For more information, refer Refinement Container.

Name

Description

SearchIndex

Container for SearchIndexes relevant for a search request. The container includes SearchIndex value and it's display name. The SearchIndex value can be used to fire subsequent request in a particular search category. For more information, refer [SearchIndexes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#searchindexes-response-element.md)

BrowseNode

Container for dynamic BrowseNodes information for a particular search request. The container includes list of BrowseNodeIDs and their corresponding display name. The BrowseNodeID can be used to fire subsequent request in a particular sub-category. For more information, refer [BrowseNodes Response Element](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#browsenodes-response-element.md)

OtherRefinements

Container for dynamic refinements for a search request which includes ID (which is also a request parameter of SearchItems operation), and bins. For more information, refer [OtherRefinements Response Element](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#otherrefinements-response-element.md)

#### Refinement Container

This is a generic container for all the types of refinements vended out by `searchRefinements` Resource. A refinement container inside `searchRefinements` resource looks like this:

Copy

```
{
  "searchRefinements": {
    "refinementType": {
      "id": "SearchItems Parameter Name",
      "displayName": "Display Name of the Parameter",
      "bins": [
         /* Refinement values for the RefinementType */
        {
           "id": "The Actual Refinement Value",
           "displayName": "Display Name of the Refinement Value"
        }
      ]
    }
  }
}
```

> RefinementType are the various [Response Elements](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements#response-elements.md) (SearchIndex/BrowseNode/etc) returned by the SearchRefinements. resource.

The following table briefly describes various attributes inside the Refinement Container:

Attribute Name

Description

Id

The `Id` tells us which [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) request parameter a particular refinement binds to. For example, for a `BrowseNode` refinement, the `Id` will be `BrowseNodeId`.

DisplayName

The display name of the refinement parameter on Amazon website which varies with locale. For example, the DisplayName for `BrowseNode` refinement will be `Department` in US locale.

Bins

Bins contain valid values for the refinement. The bins are again a container of `Id` and `DisplayName` where `Id` contains the actual refinement value which can be used for firing subsequent request to refine the search results. For example, the `Id` and `DisplayName` for a `BrowseNode` refinement can be `344520001` and `Women's Clothing` respectively. Here, the subsequent request can be fired by supplying `{ "BrowseNodeId": "344530001" }` in the request.

#### SearchIndexes Response Element

The structure of SearchIndexes element inside `searchRefinements` resource looks like:

Copy

```
{
  "searchRefinements": {
    "searchIndex": {
      "id": "SearchIndex",
      "displayName": "Department",
      "bins": [
        {
          "id": "AppsAndGames",
          "displayName": "Apps and Games"
        },
        {
          "id": "DigitalMusic",
          "displayName": "Digital Music"
        }
        /* More relevant SearchIndexes */
      ]
    }
  }
}
```

The SearchIndexes are returned for every search request inside `"All"` SearchIndex. Use the relevant SearchIndex to narrow down the search request inside a particular category. From the example above, if \*\*Digital Music \*\*seems to be the relevant category for your search request, then fire a subsequent request with `DigitalMusic` as the `SearchIndex`.

#### BrowseNodes Response Element

The structure of BrowseNodes element inside `searchRefinements` resource looks like:

Copy

```
{
  "searchRefinements": {
    "browseNode": {
      "id": "BrowseNodeId",
      "displayName": "Department",
      "bins": [
        {
          "id": "344520001",
          "displayName": "Women Clothing"
        },
        {
          "id": "2233000134",
          "displayName": "Men Clothing"
        }
        /* More relevant BrowseNodeIds */
      ]
    }
  }
}
```

The BrowseNodes are returned for every search request which are in a specific search index i.e. any search index other than "All". Use the relevant BrowseNodeId to narrow down the search request inside a particular sub-category. From the example above, if \*\*Women Clothing \*\*seems to be the relevant sub-category for your search request, then fire a subsequent request with `344520001` as the `BrowseNodeId`.

#### OtherRefinements Response Element

The structure of OtherRefinements element inside `searchRefinements` resource looks like:

Copy

```
{
 "searchRefinements": {
  "otherRefinements": [
    {
     "id": "Brand",
     "displayName": "Brand",
     "bins": [
        {
         "id": "Sony",
         "displayName": "Sony"
        },
        {
         "id": "Sony",
         "displayName": "Sony"
        }
      ]
    },
    {
      /* More Dynamic Refinements (if available) */
    }
  ]
 }
}
```

OtherRefinements are returned for every search request which are inside a particular search index and if the particular search index, marketplace combination supports a particular refinement. Use the `Bin Id` to fire subsequent request refining your search results. As of now, SearchRefinements resource returns dynamic values for following (if available in a particular SearchIndex and Marketplace):

-   Actor
-   Artist
-   Author
-   Brand

> There may be cases when you might get a certain refinement as response but the same doesn't work while firing subsequent request. For instance, you may get `Artist` refinement in `DigitalMusic` category searches but when `Artist` filter is used, you may get `NoResults`. In such cases, use the refinement values in `Keywords` to get desired results.

## Example Requests and Responses

The following examples demonstrate the SearchRefinements use cases

#### Example 1

The example demonstrates the SearchRefinements resource behavior when a search request in US marketplace is inside "All" category.

##### Request:

Copy

```
{
   "partnerTag": "xyz-20",
   "itemCount": 1,
   "keyword": "Harry Potter",
   "resources" : [ "searchRefinements" ]
}
```

##### Response:

Copy

```
{
  "searchResult": {
    "items": [
      {
        "asin": "0545162076",
        "detailPageURL": "https://www.amazon.com/dp/0545162076?tag=dgfd&linkCode=osi&th=1&psc=1"
      }
    ],
    "searchRefinements": {
      "searchIndex": {
        "id": "SearchIndex",
        "displayName": "Department",
        "bins": [
          {
            "id": "Books",
            "displayName": "Books"
          },
          {
            "id": "MoviesAndTV",
            "displayName": "Movies & TV"
          },
          {
            "id": "Fashion",
            "displayName": "Clothing, Shoes & Jewelry"
          },
          {
            "id": "HomeAndKitchen",
            "displayName": "Home & Kitchen"
          },
          {
            "id": "Beauty",
            "displayName": "Beauty & Personal Care"
          }
          / * More relevant Search Indexes */
        ]
      }
    },
    "searchURL": "https://www.amazon.com/s/?field-keywords=Harry+Potter&search-alias=aps&tag=xyz-20&linkCode=osi",
    "totalResultCount": 146
  }
}
```

Note that the most relevant search indexes are at top. That is, here, in this example, the Books search index is the most relevant one.

#### Example 2

The example demonstrates the SearchRefinements resource behavior when a search request for "Mystery Novels" keyword in US marketplace is inside "Books" category.

##### Request:

Copy

```
{
   "partnerTag": "xyz-20",
   "itemCount": 1,
   "keyword": "Mystery Novels",
   "searchIndex": "Books",
   "resources" : [ "searchRefinements" ]
}
```

##### Response:

Copy

```
{
  "searchResult": {
    "items": [
      {
        "asin": "1683993039",
        "detailPageURL": "https://www.amazon.com/dp/1683993039?tag=dgfd&linkCode=osi&th=1&psc=1"
      }
    ],
    "searchRefinements": {
      "browseNode": {
        "id": "BrowseNodeId",
        "displayName": "Department",
        "bins": [
          {
            "id": "17",
            "displayName": "Literature & Fiction"
          },
          {
            "id": "18",
            "displayName": "Mystery, Thriller & Suspense"
          },
          {
            "id": "23",
            "displayName": "Romance"
          }
          /* More relevant BrowseNodes */
        ]
      },
      "otherRefinements": [
        {
          "displayName": "Author",
          "id": "Author",
          "bins": [
            {
              "id": "Agatha Christie",
              "displayName": "Agatha Christie"
            },
            {
              "id": "Arthur Conan Doyle",
              "displayName": "Arthur Conan Doyle"
            },
            {
              "id": "Wilkie Collins",
              "displayName": "Wilkie Collins"
            }
            /* More relevant Authors */
          ]
        }
      ]
    },
    "searchURL": "https://www.amazon.com/s/?field-keywords=Mystery+Novels&search-alias=stripbooks&tag=xyz-20&linkCode=osi",
    "totalResultCount": 1200
  }
}
```

## VariationSummary

Source: `_creatorsapi_docs_en-us_api-reference_resources_variation-summary.html`

# VariationSummary

The `VariationSummary` resource provides the lowest price, highest price and variation dimensions for all variations in a response. A variation is a child ASIN. The parent ASIN is an abstraction of the children items. For example, a shirt is a parent ASIN and parent ASINs cannot be sold. A child ASIN would be a blue shirt, size 16, sold by MyApparelStore. This child ASIN is one of potentially many variations. The ways in which variations differ are called dimensions. In the preceding example, size and color are the dimensions. The resource is relevant for only [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md) operation.

## Availability

All locales.

## Response Elements

Name

Description

PageCount

The number of pages containing variation items with certain number of variations per page.

Price

Container for showing the lowest and highest price of the child ASINs.

VariationCount

The total number of child ASINs.

VariationDimensions

List of all the dimensions i.e consistent theme over which the items varies and their values.

### Price Response Element

The structure of Price container inside the high level VariationSummary Resource is as follows

Copy

```
{
  "variationSummary": {
    "pageCount": "The number of pages containing variations",
    "price": {
      "highestPrice": "Highest Price among the child ASINs",
      "lowestPrice": "Lowest Price among the child ASINs"
    },
    "variationCount": "The total number of child ASINs",
    "variationDimension": [
      {
        "displayName": "Display Name of the Dimension",
        "locale": "The locale in which Display Name is returned",
        "name": "Name of the Dimension",
        "values": "List of all possible values for the Dimension"
      }
    ]
  }
}
```

Refer following table for more information on each of the individual response elements of the Price response element:

ResponseElement

Description

HighestPrice

Highest Price among the child ASINs.

LowestPrice

Lowest Price among the child ASINs.

### VariationDimensions Response Element

The structure of Price container inside the high level VariationSummary Resource is as follows

Copy

```
{
  "variationSummary": {
    "variationDimension": [
      {
        "displayName": "Display Name of the Dimension",
        "locale": "The locale in which Display Name is returned",
        "name": "Name of the Dimension",
        "values": "List of all possible values for the Dimension"
      }
    ]
  }
}
```

ResponseElement

Description

DisplayName

Display Name of the Dimension as visible on the Amazon retail website.

Locale

The locale in which Display Name is returned.

Name

Name of the Dimension.

Values

List of all possible values for the Dimension.

## Relevant Operations

Operations that can use these resources include:

-   [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)

## Resources

Add the resource name in the request payload to get the corresponding data in the API response.

Name

Description

[variationSummary.price.highestPrice](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-price-highestprice.md)

Get the highest price among the child ASINs.

[variationSummary.price.lowestPrice](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-price-lowestprice.md)

Get the lowest price among the child ASINs.

[variationSummary.variationDimension](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-variation-dimension.md)

Get the details about the dimensions like name, display-name and possible values on which the item varies.

### VariationSummary Price HighestPrice

Requesting this resource returns the highest price among all the child ASINs.

#### Sample Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
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
      "pageCount": 2,
      "price": {
        "highestPrice": {
          "amount": 30.87,
          "currency": "GBP",
          "displayAmount": "£30.87"
        }
      },
      "variationCount": 13
    }
  }
}
```

### VariationSummary Price LowestPrice

Requesting this resource returns the lowest price among all the child ASINs.

#### Sample Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
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
      "pageCount": 2,
      "price": {
        "lowestPrice": {
          "amount": 17.03,
          "currency": "GBP",
          "displayAmount": "£17.03"
        }
      },
      "variationCount": 13
    }
  }
}
```

### VariationSummary Variation Dimension

Requesting this resource returns the details about the dimensions like name, display-name and possible values.

#### Sample Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
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
      "pageCount": 2,
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

## VariationSummary

Source: `_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-price-highestprice.html`

# VariationSummary

The `VariationSummary` resource provides the lowest price, highest price and variation dimensions for all variations in a response. A variation is a child ASIN. The parent ASIN is an abstraction of the children items. For example, a shirt is a parent ASIN and parent ASINs cannot be sold. A child ASIN would be a blue shirt, size 16, sold by MyApparelStore. This child ASIN is one of potentially many variations. The ways in which variations differ are called dimensions. In the preceding example, size and color are the dimensions. The resource is relevant for only [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md) operation.

## Availability

All locales.

## Response Elements

Name

Description

PageCount

The number of pages containing variation items with certain number of variations per page.

Price

Container for showing the lowest and highest price of the child ASINs.

VariationCount

The total number of child ASINs.

VariationDimensions

List of all the dimensions i.e consistent theme over which the items varies and their values.

### Price Response Element

The structure of Price container inside the high level VariationSummary Resource is as follows

Copy

```
{
  "variationSummary": {
    "pageCount": "The number of pages containing variations",
    "price": {
      "highestPrice": "Highest Price among the child ASINs",
      "lowestPrice": "Lowest Price among the child ASINs"
    },
    "variationCount": "The total number of child ASINs",
    "variationDimension": [
      {
        "displayName": "Display Name of the Dimension",
        "locale": "The locale in which Display Name is returned",
        "name": "Name of the Dimension",
        "values": "List of all possible values for the Dimension"
      }
    ]
  }
}
```

Refer following table for more information on each of the individual response elements of the Price response element:

ResponseElement

Description

HighestPrice

Highest Price among the child ASINs.

LowestPrice

Lowest Price among the child ASINs.

### VariationDimensions Response Element

The structure of Price container inside the high level VariationSummary Resource is as follows

Copy

```
{
  "variationSummary": {
    "variationDimension": [
      {
        "displayName": "Display Name of the Dimension",
        "locale": "The locale in which Display Name is returned",
        "name": "Name of the Dimension",
        "values": "List of all possible values for the Dimension"
      }
    ]
  }
}
```

ResponseElement

Description

DisplayName

Display Name of the Dimension as visible on the Amazon retail website.

Locale

The locale in which Display Name is returned.

Name

Name of the Dimension.

Values

List of all possible values for the Dimension.

## Relevant Operations

Operations that can use these resources include:

-   [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)

## Resources

Add the resource name in the request payload to get the corresponding data in the API response.

Name

Description

[variationSummary.price.highestPrice](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-price-highestprice.md)

Get the highest price among the child ASINs.

[variationSummary.price.lowestPrice](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-price-lowestprice.md)

Get the lowest price among the child ASINs.

[variationSummary.variationDimension](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-variation-dimension.md)

Get the details about the dimensions like name, display-name and possible values on which the item varies.

### VariationSummary Price HighestPrice

Requesting this resource returns the highest price among all the child ASINs.

#### Sample Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
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
      "pageCount": 2,
      "price": {
        "highestPrice": {
          "amount": 30.87,
          "currency": "GBP",
          "displayAmount": "£30.87"
        }
      },
      "variationCount": 13
    }
  }
}
```

### VariationSummary Price LowestPrice

Requesting this resource returns the lowest price among all the child ASINs.

#### Sample Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
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
      "pageCount": 2,
      "price": {
        "lowestPrice": {
          "amount": 17.03,
          "currency": "GBP",
          "displayAmount": "£17.03"
        }
      },
      "variationCount": 13
    }
  }
}
```

### VariationSummary Variation Dimension

Requesting this resource returns the details about the dimensions like name, display-name and possible values.

#### Sample Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
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
      "pageCount": 2,
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

## VariationSummary

Source: `_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-price-lowestprice.html`

# VariationSummary

The `VariationSummary` resource provides the lowest price, highest price and variation dimensions for all variations in a response. A variation is a child ASIN. The parent ASIN is an abstraction of the children items. For example, a shirt is a parent ASIN and parent ASINs cannot be sold. A child ASIN would be a blue shirt, size 16, sold by MyApparelStore. This child ASIN is one of potentially many variations. The ways in which variations differ are called dimensions. In the preceding example, size and color are the dimensions. The resource is relevant for only [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md) operation.

## Availability

All locales.

## Response Elements

Name

Description

PageCount

The number of pages containing variation items with certain number of variations per page.

Price

Container for showing the lowest and highest price of the child ASINs.

VariationCount

The total number of child ASINs.

VariationDimensions

List of all the dimensions i.e consistent theme over which the items varies and their values.

### Price Response Element

The structure of Price container inside the high level VariationSummary Resource is as follows

Copy

```
{
  "variationSummary": {
    "pageCount": "The number of pages containing variations",
    "price": {
      "highestPrice": "Highest Price among the child ASINs",
      "lowestPrice": "Lowest Price among the child ASINs"
    },
    "variationCount": "The total number of child ASINs",
    "variationDimension": [
      {
        "displayName": "Display Name of the Dimension",
        "locale": "The locale in which Display Name is returned",
        "name": "Name of the Dimension",
        "values": "List of all possible values for the Dimension"
      }
    ]
  }
}
```

Refer following table for more information on each of the individual response elements of the Price response element:

ResponseElement

Description

HighestPrice

Highest Price among the child ASINs.

LowestPrice

Lowest Price among the child ASINs.

### VariationDimensions Response Element

The structure of Price container inside the high level VariationSummary Resource is as follows

Copy

```
{
  "variationSummary": {
    "variationDimension": [
      {
        "displayName": "Display Name of the Dimension",
        "locale": "The locale in which Display Name is returned",
        "name": "Name of the Dimension",
        "values": "List of all possible values for the Dimension"
      }
    ]
  }
}
```

ResponseElement

Description

DisplayName

Display Name of the Dimension as visible on the Amazon retail website.

Locale

The locale in which Display Name is returned.

Name

Name of the Dimension.

Values

List of all possible values for the Dimension.

## Relevant Operations

Operations that can use these resources include:

-   [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)

## Resources

Add the resource name in the request payload to get the corresponding data in the API response.

Name

Description

[variationSummary.price.highestPrice](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-price-highestprice.md)

Get the highest price among the child ASINs.

[variationSummary.price.lowestPrice](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-price-lowestprice.md)

Get the lowest price among the child ASINs.

[variationSummary.variationDimension](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-variation-dimension.md)

Get the details about the dimensions like name, display-name and possible values on which the item varies.

### VariationSummary Price HighestPrice

Requesting this resource returns the highest price among all the child ASINs.

#### Sample Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
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
      "pageCount": 2,
      "price": {
        "highestPrice": {
          "amount": 30.87,
          "currency": "GBP",
          "displayAmount": "£30.87"
        }
      },
      "variationCount": 13
    }
  }
}
```

### VariationSummary Price LowestPrice

Requesting this resource returns the lowest price among all the child ASINs.

#### Sample Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
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
      "pageCount": 2,
      "price": {
        "lowestPrice": {
          "amount": 17.03,
          "currency": "GBP",
          "displayAmount": "£17.03"
        }
      },
      "variationCount": 13
    }
  }
}
```

### VariationSummary Variation Dimension

Requesting this resource returns the details about the dimensions like name, display-name and possible values.

#### Sample Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
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
      "pageCount": 2,
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

## VariationSummary

Source: `_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-variation-dimension.html`

# VariationSummary

The `VariationSummary` resource provides the lowest price, highest price and variation dimensions for all variations in a response. A variation is a child ASIN. The parent ASIN is an abstraction of the children items. For example, a shirt is a parent ASIN and parent ASINs cannot be sold. A child ASIN would be a blue shirt, size 16, sold by MyApparelStore. This child ASIN is one of potentially many variations. The ways in which variations differ are called dimensions. In the preceding example, size and color are the dimensions. The resource is relevant for only [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md) operation.

## Availability

All locales.

## Response Elements

Name

Description

PageCount

The number of pages containing variation items with certain number of variations per page.

Price

Container for showing the lowest and highest price of the child ASINs.

VariationCount

The total number of child ASINs.

VariationDimensions

List of all the dimensions i.e consistent theme over which the items varies and their values.

### Price Response Element

The structure of Price container inside the high level VariationSummary Resource is as follows

Copy

```
{
  "variationSummary": {
    "pageCount": "The number of pages containing variations",
    "price": {
      "highestPrice": "Highest Price among the child ASINs",
      "lowestPrice": "Lowest Price among the child ASINs"
    },
    "variationCount": "The total number of child ASINs",
    "variationDimension": [
      {
        "displayName": "Display Name of the Dimension",
        "locale": "The locale in which Display Name is returned",
        "name": "Name of the Dimension",
        "values": "List of all possible values for the Dimension"
      }
    ]
  }
}
```

Refer following table for more information on each of the individual response elements of the Price response element:

ResponseElement

Description

HighestPrice

Highest Price among the child ASINs.

LowestPrice

Lowest Price among the child ASINs.

### VariationDimensions Response Element

The structure of Price container inside the high level VariationSummary Resource is as follows

Copy

```
{
  "variationSummary": {
    "variationDimension": [
      {
        "displayName": "Display Name of the Dimension",
        "locale": "The locale in which Display Name is returned",
        "name": "Name of the Dimension",
        "values": "List of all possible values for the Dimension"
      }
    ]
  }
}
```

ResponseElement

Description

DisplayName

Display Name of the Dimension as visible on the Amazon retail website.

Locale

The locale in which Display Name is returned.

Name

Name of the Dimension.

Values

List of all possible values for the Dimension.

## Relevant Operations

Operations that can use these resources include:

-   [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)

## Resources

Add the resource name in the request payload to get the corresponding data in the API response.

Name

Description

[variationSummary.price.highestPrice](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-price-highestprice.md)

Get the highest price among the child ASINs.

[variationSummary.price.lowestPrice](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-price-lowestprice.md)

Get the lowest price among the child ASINs.

[variationSummary.variationDimension](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary#variationsummary-variation-dimension.md)

Get the details about the dimensions like name, display-name and possible values on which the item varies.

### VariationSummary Price HighestPrice

Requesting this resource returns the highest price among all the child ASINs.

#### Sample Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
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
      "pageCount": 2,
      "price": {
        "highestPrice": {
          "amount": 30.87,
          "currency": "GBP",
          "displayAmount": "£30.87"
        }
      },
      "variationCount": 13
    }
  }
}
```

### VariationSummary Price LowestPrice

Requesting this resource returns the lowest price among all the child ASINs.

#### Sample Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
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
      "pageCount": 2,
      "price": {
        "lowestPrice": {
          "amount": 17.03,
          "currency": "GBP",
          "displayAmount": "£17.03"
        }
      },
      "variationCount": 13
    }
  }
}
```

### VariationSummary Variation Dimension

Requesting this resource returns the details about the dimensions like name, display-name and possible values.

#### Sample Response

Copy

```
{
  "variationsResult": {
    "items": [
      {
        "asin": "B00422MCVM",
        "detailPageURL": "https://www.amazon.co.uk/dp/B00422MCVM?tag=xyz-20&linkCode=ogv&th=1&psc=1",
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
      "pageCount": 2,
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

## Resources

Source: `_creatorsapi_docs_en-us_api-reference_resources.html`

# Resources

Resources determine what information will be returned in the API response. Each operation can request only certain resources. For details on what all resources are valid for a particular Product Advertising API operation, see [Operations](./_creatorsapi_docs_en-us_operations.md).

All supported high level resources are captured in the table below. Navigate to individual high level resource section to get more details on the resource.

Product Advertising API supports following high level resources:

High Level Resource

Description

[BrowseNodeInfo](./_creatorsapi_docs_en-us_browsenodeinfo.md)

Returns browse node information associated with an item

[BrowseNodes](./_creatorsapi_docs_en-us_api-reference_resources_browse-nodes.md)

Returns browse node information associated with a Browse Node for a [GetBrowseNodes](./_creatorsapi_docs_en-us_getbrowsenodes.md) request

[Images](./_creatorsapi_docs_en-us_images.md)

Returns image URLs for an item in various sizes

[ItemInfo](./_creatorsapi_docs_en-us_item-info.md)

Returns item information for an item

[OffersV2](./_creatorsapi_docs_en-us_offersV2.md)

Returns offer information for an item. Newer API.

[ParentASIN](./_creatorsapi_docs_en-us_parent-asin.md)

Returns parent ASIN for an item

[SearchRefinements](./_creatorsapi_docs_en-us_search-refinements.md)

Returns dynamic search refinements for a search request

## API Reference

Source: `_creatorsapi_docs_en-us_api-reference.html`

# API Reference

The following sections of the guide provide API reference material for the Creators API. For more information about Creators API overview and basic concepts, refer to the previous chapters in this guide. For registering with Creators API, refer [Register for Creators API](./_creatorsapi_docs_en-us_onboarding_register-for-creators-api.md) and for information on how to best use the API for some common use cases, refer our [Using SDK](./_creatorsapi_docs_en-us_get-started.md).

The following section contains information about Creators API operations, resources, locale specific information, etc in detail with examples for you to do it yourself.

## Operations

Creators API supports the following operations:

Operation Name

Description

[GetBrowseNodes](./_creatorsapi_docs_en-us_api-reference_operations_get-browse-nodes.md)

Lookup information for a Browse Node

[GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)

Provides item attributes, offer listings, images, and other details for a given item

[SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

Searches for items on Amazon based on keywords

[GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)

Returns variations for an item i.e. a set of items that are the same product, but differ according to a consistent theme, for example size and color

## Resources

Resources determine what information will be returned in the API response. Each operation can request only certain resources. For details on what all resources are valid for a particular Creators API operation, see [Operations](./_creatorsapi_docs_en-us_api-reference_operations.md).

Creators API supports following the high level resources:

High Level Resource

Description

[BrowseNodeInfo](./_creatorsapi_docs_en-us_api-reference_resources_browse-node-info.md)

Returns browse node information associated with an item

[BrowseNodes](./_creatorsapi_docs_en-us_api-reference_resources_browse-nodes.md)

Returns browse node information associated with a Browse Node for a [GetBrowseNodes](./_creatorsapi_docs_en-us_api-reference_operations_get-browse-nodes.md) request

[Images](./_creatorsapi_docs_en-us_api-reference_resources_images.md)

Returns image URLs for an item in various sizes

[ItemInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md)

Returns item information (Title, Brand, Description, etc.) for an item

[ParentASIN](./_creatorsapi_docs_en-us_api-reference_resources_parent-asin.md)

Returns the parent ASIN for an item.

[SearchRefinements](./_creatorsapi_docs_en-us_api-reference_resources_search-refinements.md)

Returns dynamic search refinements for a search request

[VariationSummary](./_creatorsapi_docs_en-us_api-reference_resources_variation-summary.md)

Returns summary for the [GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md) operations

## Locale Reference

Creators API supports multiple Amazon marketplaces across the world. Each marketplace has specific configuration requirements including marketplace endpoint and region. See the [Locale Reference](./_creatorsapi_docs_en-us_locale-reference.md) section for details on all supported locales.

## Page Not Found

Source: `_creatorsapi_docs_en-us_browsenodeinfo.html`

# Page Not Found

The page you are looking for does not exist.

## Server Busy

Source: `_creatorsapi_docs_en-us_concepts_api-rates.html`

Click the button below to continue shopping

 

Continue shopping

© 1996-2025, Amazon.com, Inc. or its affiliates ![](https://fls-na.amazon.com/1/oc-csi/1/OP/requestId=Y0Y3PGMJMWTDX8SEP4JM&js=1)

## Common Request Headers and Parameters

Source: `_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.html`

# Common Request Headers and Parameters

This document describes the request headers and parameters that are common to all Creators API operations.

## Headers

The following table describes the HTTP headers that must be included in all Creators API requests:

Header

Definition

Required

Example Value

Content-Type

The content type of the request body. Must be set to `application/json`.

Yes

`application/json`

Authorization (using v2.x credentials)

Bearer token for authenticating API requests with v2.x credentials. The value should be in the format: `Bearer <access_token>, Version <credential_version>` where credential\_version is `2.1` for NA, `2.2` for EU, `2.3` for FE.

Yes

`Bearer eyJraWQiOiJ..., Version 2.1`

Authorization (using v3.x credentials)

Bearer token for authenticating API requests with v3.x credentials. Simply use: `Bearer <access_token>`. No version header required.

Yes

`Bearer Atc|MQICIJvS...`

x-marketplace

Target Amazon marketplace passed as an HTTP header. The value determines the locale where the API request is targeted. For example: `www.amazon.com` for US, `www.amazon.co.uk` for UK. For more information, refer [Marketplace Reference](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters#marketplace-reference.md).

Yes

`www.amazon.com`

## Parameters

The following table describes the request parameters that are common to all Creators API operations:

Parameter

Definition

Required

Example Value

marketplace

Target Amazon marketplace. The value determines the locale where the API request is targeted. For example: `www.amazon.com` for US, `www.amazon.co.uk` for UK. For more information, refer [Marketplace Reference](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters#marketplace-reference.md).

Yes

`www.amazon.com`

partnerTag

An alphanumeric token that uniquely identifies a partner. In case of an associate, this token is the means by which Amazon identifies the Associate to credit for a sale. Specify the `store ID` or `tracking ID` of a valid associate store from the requested marketplace as the value for `partnerTag`. For example, If `store-20` and `store-21` are store id or tracking id of customer in United States and United Kingdom marketplaces respectively, then customer needs to pass `store-20` as `partnerTag` in all Creators API requests for United States marketplace and `store-21` as `partnerTag` in all Creators API requests for United Kingdom marketplace. To obtain a Partner Tag, see [Sign up as an Amazon Associate](./_creatorsapi_docs_en-us_onboarding_sign-up-as-an-amazon-associate.md).

Yes

`store-20`

## Marketplace/Locale Reference

Locale

Marketplace

Region

Australia

`www.amazon.com.au`

FE

Belgium

`www.amazon.com.be`

EU

Brazil

`www.amazon.com.br`

NA

Canada

`www.amazon.ca`

NA

Egypt

`www.amazon.eg`

EU

France

`www.amazon.fr`

EU

Germany

`www.amazon.de`

EU

India

`www.amazon.in`

EU

Ireland

`www.amazon.ie`

EU

Italy

`www.amazon.it`

EU

Japan

`www.amazon.co.jp`

FE

Mexico

`www.amazon.com.mx`

NA

Netherlands

`www.amazon.nl`

EU

Poland

`www.amazon.pl`

EU

Singapore

`www.amazon.sg`

FE

Saudi Arabia

`www.amazon.sa`

EU

Spain

`www.amazon.es`

EU

Sweden

`www.amazon.se`

EU

Turkey

`www.amazon.com.tr`

EU

United Arab Emirates

`www.amazon.ae`

EU

United Kingdom

`www.amazon.co.uk`

EU

United States

`www.amazon.com`

NA

## Common Request Headers and Parameters

Source: `_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters#marketplace-reference.html`

# Common Request Headers and Parameters

This document describes the request headers and parameters that are common to all Creators API operations.

## Headers

The following table describes the HTTP headers that must be included in all Creators API requests:

Header

Definition

Required

Example Value

Content-Type

The content type of the request body. Must be set to `application/json`.

Yes

`application/json`

Authorization (using v2.x credentials)

Bearer token for authenticating API requests with v2.x credentials. The value should be in the format: `Bearer <access_token>, Version <credential_version>` where credential\_version is `2.1` for NA, `2.2` for EU, `2.3` for FE.

Yes

`Bearer eyJraWQiOiJ..., Version 2.1`

Authorization (using v3.x credentials)

Bearer token for authenticating API requests with v3.x credentials. Simply use: `Bearer <access_token>`. No version header required.

Yes

`Bearer Atc|MQICIJvS...`

x-marketplace

Target Amazon marketplace passed as an HTTP header. The value determines the locale where the API request is targeted. For example: `www.amazon.com` for US, `www.amazon.co.uk` for UK. For more information, refer [Marketplace Reference](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters#marketplace-reference.md).

Yes

`www.amazon.com`

## Parameters

The following table describes the request parameters that are common to all Creators API operations:

Parameter

Definition

Required

Example Value

marketplace

Target Amazon marketplace. The value determines the locale where the API request is targeted. For example: `www.amazon.com` for US, `www.amazon.co.uk` for UK. For more information, refer [Marketplace Reference](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters#marketplace-reference.md).

Yes

`www.amazon.com`

partnerTag

An alphanumeric token that uniquely identifies a partner. In case of an associate, this token is the means by which Amazon identifies the Associate to credit for a sale. Specify the `store ID` or `tracking ID` of a valid associate store from the requested marketplace as the value for `partnerTag`. For example, If `store-20` and `store-21` are store id or tracking id of customer in United States and United Kingdom marketplaces respectively, then customer needs to pass `store-20` as `partnerTag` in all Creators API requests for United States marketplace and `store-21` as `partnerTag` in all Creators API requests for United Kingdom marketplace. To obtain a Partner Tag, see [Sign up as an Amazon Associate](./_creatorsapi_docs_en-us_onboarding_sign-up-as-an-amazon-associate.md).

Yes

`store-20`

## Marketplace/Locale Reference

Locale

Marketplace

Region

Australia

`www.amazon.com.au`

FE

Belgium

`www.amazon.com.be`

EU

Brazil

`www.amazon.com.br`

NA

Canada

`www.amazon.ca`

NA

Egypt

`www.amazon.eg`

EU

France

`www.amazon.fr`

EU

Germany

`www.amazon.de`

EU

India

`www.amazon.in`

EU

Ireland

`www.amazon.ie`

EU

Italy

`www.amazon.it`

EU

Japan

`www.amazon.co.jp`

FE

Mexico

`www.amazon.com.mx`

NA

Netherlands

`www.amazon.nl`

EU

Poland

`www.amazon.pl`

EU

Singapore

`www.amazon.sg`

FE

Saudi Arabia

`www.amazon.sa`

EU

Spain

`www.amazon.es`

EU

Sweden

`www.amazon.se`

EU

Turkey

`www.amazon.com.tr`

EU

United Arab Emirates

`www.amazon.ae`

EU

United Kingdom

`www.amazon.co.uk`

EU

United States

`www.amazon.com`

NA

## Contact Us

Source: `_creatorsapi_docs_en-us_contact-us.html`

# Contact Us

## **Amazon Associates Customer Service**

To raise a request for Amazon Associates account related concerns, visit the Amazon Associates Contact Us form on your local Associates site.

Alternatively, you can perform the following steps:

1.  In the Amazon Associates page, choose **Help** and then choose **Contact Us**.
    
    ![](./assets/images/contact-us.png)
    
    > It is not mandatory for Amazon Associates to log into their Associates account to perform this step.
    
2.  Choose **Creators API** from the **Subject** drop-down button.
    
    ![](./assets/images/contact-us-subject.png)
    
3.  Enter your concerns in the **Comments** along with other recommended fields. Please include sample request and response along with use-case in comment, if you have questions related to request, response or error.
    
    ![](./assets/images/contact-us-full.png)
    
4.  Click on the **Send E-mail** button.
    
    > Requests for final acceptance of Amazon Associates account will be reviewed by a specialist and you will receive a response within 3-4 days.
    

## Contact Form Links by Locale

Locale

Contact Form URL

Australia

[https://affiliate-program.amazon.com.au/contact](https://affiliate-program.amazon.com.au/contact)

Belgium

[https://affiliate-program.amazon.com.be/contact](https://affiliate-program.amazon.com.be/contact)

Brazil

[https://associados.amazon.com.br/contact](https://associados.amazon.com.br/contact)

Canada

[https://associates.amazon.ca/contact](https://associates.amazon.ca/contact)

Egypt

[https://affiliate-program.amazon.eg/contact](https://affiliate-program.amazon.eg/contact)

France

[https://partenaires.amazon.fr/contact](https://partenaires.amazon.fr/contact)

Germany

[https://partnernet.amazon.de/contact](https://partnernet.amazon.de/contact)

India

[https://affiliate-program.amazon.in/contact](https://affiliate-program.amazon.in/contact)

Ireland

[https://affiliate-program.amazon.ie/contact](https://affiliate-program.amazon.ie/contact)

Italy

[https://programma-affiliazione.amazon.it/contact](https://programma-affiliazione.amazon.it/contact)

Japan

[https://affiliate.amazon.co.jp/contact](https://affiliate.amazon.co.jp/contact)

Mexico

[https://afiliados.amazon.com.mx/contact](https://afiliados.amazon.com.mx/contact)

Netherlands

[https://affiliate-program.amazon.nl/contact](https://affiliate-program.amazon.nl/contact)

Poland

[https://affiliate-program.amazon.pl/contact](https://affiliate-program.amazon.pl/contact)

Saudi Arabia

[https://affiliate-program.amazon.sa/contact](https://affiliate-program.amazon.sa/contact)

Singapore

[https://affiliate-program.amazon.sg/contact](https://affiliate-program.amazon.sg/contact)

Spain

[https://afiliados.amazon.es/contact](https://afiliados.amazon.es/contact)

Sweden

[https://affiliate-program.amazon.se/contact](https://affiliate-program.amazon.se/contact)

Turkey

[https://gelirortakligi.amazon.com.tr/contact](https://gelirortakligi.amazon.com.tr/contact)

United Arab Emirates

[https://affiliate-program.amazon.ae/contact](https://affiliate-program.amazon.ae/contact)

United Kingdom

[https://affiliate-program.amazon.co.uk/contact](https://affiliate-program.amazon.co.uk/contact)

United States

[https://affiliate-program.amazon.com/contact](https://affiliate-program.amazon.com/contact)

## Server Busy

Source: `_creatorsapi_docs_en-us_frequently-asked-questions.html`

Click the button below to continue shopping

 

Continue shopping

© 1996-2025, Amazon.com, Inc. or its affiliates ![](https://fls-na.amazon.com/1/oc-csi/1/OP/requestId=GEQCDEMZF6T1MSBEN3NQ&js=1)

## Using cURL

Source: `_creatorsapi_docs_en-us_get-started_using-curl.html`

# Using cURL

Once you have signed up for Amazon Associates program and Creators API, you can start sending requests to the API. You can send requests to Creators API using SDKs (recommended) or directly using HTTP requests. This guide shows you how to make API calls using cURL.

## Request Components

Requests to Creators API have the following main components:

1.  **Headers** - Authentication and metadata about the request
2.  **Request Payload** - JSON formatted Request Body

The following sections explain how to obtain the authentication token for headers, how to construct the request payload, and finally how to put everything together in a complete cURL command.

## Step 1: Fetch Access Token (for Headers)

To authenticate your requests, you need to obtain an OAuth 2.0 access token from the Cognito token endpoint. This token will be used in the Authorization header for all API calls.

## Regional Endpoints

The Creators API uses different authentication endpoints based on your credential version:

**Region**

**Version**

**Token Endpoint**

**Marketplaces**

NA (North America)

2.1

`creatorsapi.auth.us-east-1.amazoncognito.com/oauth2/token`

US, CA, MX, BR

EU (Europe)

2.2

`creatorsapi.auth.eu-south-2.amazoncognito.com/oauth2/token`

UK, DE, FR, IT, ES, NL, BE, EG, IN, IE, PL, SA, SE, TR, AE

FE (Far East)

2.3

`creatorsapi.auth.us-west-2.amazoncognito.com/oauth2/token`

JP, SG, AU

NA (North America)

3.1

`api.amazon.com/auth/o2/token`

US, CA, MX, BR

EU (Europe)

3.2

`api.amazon.co.uk/auth/o2/token`

UK, DE, FR, IT, ES, NL, BE, EG, IN, IE, PL, SA, SE, TR, AE

FE (Far East)

3.3

`api.amazon.co.jp/auth/o2/token`

JP, SG, AU

The API endpoint for all regions is: `https://creatorsapi.amazon`

For a complete list of marketplace-specific parameters, see [Common Request Headers and Parameters](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.md).

## Token Generation for v2.x Credentials

### Method 1: Credentials in Request Body

**Headers:**

-   `Content-Type: application/x-www-form-urlencoded`

**Request Body:**

Copy

```
grant_type=client_credentials&client_id=YOUR_CLIENT_ID&client_secret=YOUR_CLIENT_SECRET&scope=creatorsapi/default
```

**Example cURL Command:**

Copy

```
curl -v -X POST https://creatorsapi.auth.us-west-2.amazoncognito.com/oauth2/token \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "grant_type=client_credentials&client_id=YOUR_CLIENT_ID&client_secret=YOUR_CLIENT_SECRET&scope=creatorsapi/default"
```

### Method 2: Credentials in Authorization Header

**Headers:**

-   `Content-Type: application/x-www-form-urlencoded`
-   `Authorization: Basic <Base64-encoded credentials>`

**Authorization Header:** Encode your `client_id:client_secret` in Base64 format. For example, if your client\_id is `abc123` and client\_secret is `xyz789`, you would encode `abc123:xyz789`.

**Request Body:**

Copy

```
grant_type=client_credentials&scope=creatorsapi/default
```

**Example cURL Command:**

Copy

```
curl -X POST https://creatorsapi.auth.us-west-2.amazoncognito.com/oauth2/token \
 -H "Content-Type: application/x-www-form-urlencoded" \
 -H "Authorization: Basic $(echo -n 'YOUR_CLIENT_ID:YOUR_CLIENT_SECRET' | base64)" \
 -d "grant_type=client_credentials&scope=creatorsapi/default"
```

**Response:**

Copy

```
{
  "access_token": "eyJraWQiOiJ...",
  "expires_in": 3600,
  "token_type": "Bearer"
}
```

**Note:** Access tokens typically expire after 3600 seconds (1 hour). Store the token securely and refresh it before expiration. **New access token is not needed for every request and should be cached until they expire.**

## Token Generation for v3.x Credentials (LwA)

For v3.x credentials, use the Login with Amazon (LwA) token endpoint with a JSON request body. Use the appropriate regional endpoint from the table above.

**Headers:**

-   `Content-Type: application/json`

**Request Body:**

Copy

```
{
  "grant_type": "client_credentials",
  "client_id": "YOUR_CLIENT_ID",
  "client_secret": "YOUR_CLIENT_SECRET",
  "scope": "creatorsapi::default"
}
```

**Example cURL Command:**

Copy

```
curl -X POST https://api.amazon.com/auth/o2/token \
  -H "Content-Type: application/json" \
  -d '{
    "grant_type": "client_credentials",
    "client_id": "YOUR_CLIENT_ID",
    "client_secret": "YOUR_CLIENT_SECRET",
    "scope": "creatorsapi::default"
  }'
```

**Response:**

Copy

```
{
  "access_token": "Atc|MQICIJvSKVTZ...",
  "scope": "creatorsapi::default",
  "token_type": "bearer",
  "expires_in": 3600
}
```

## Step 2: Make API Calls to CreatorsAPI

Once you have the access token, include it in the `Authorization` header for all API requests.

> Examples in this section use the US locale for headers and request parameters. These common parameters are listed in [Common Request Headers and Parameters](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.md), and locale-specific values (such as marketplace) can be adjusted for your target Amazon locale.

**Base URL:** `https://creatorsapi.amazon`

**Headers:**

-   `Authorization: Bearer <access_token>, Version <credential_version>` (for v2.x credentials)
-   `Authorization: Bearer <access_token>` (for v3.x credentials)
-   `Content-Type: application/json`
-   `x-marketplace: <marketplace_domain>`

### Example: GetItems API Call

Copy

```
curl -X POST https://creatorsapi.amazon/catalog/v1/getItems \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
  -H "Content-Type: application/json" \
  -H "x-marketplace: www.amazon.com" \
  -d '{
    "itemIds": ["B09B2SBHQK", "B09B8V1LZ3"],
    "itemIdType": "ASIN",
    "marketplace": "www.amazon.com",
    "partnerTag": "xyz-20",
    "resources": [
      "images.primary.small",
      "itemInfo.title",
      "itemInfo.features",
      "parentASIN"
    ]
  }'
```

**Response:**

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B09B2SBHQK",
        "browseNodeInfo": null,
        "customerReviews": null,
        "detailPageURL": "https://www.amazon.com/dp/B09B2SBHQK?tag=xyz-20&linkCode=ogi&th=1&psc=1&language=en_US",
        "images": {
          "primary": {
            "hiRes": null,
            "large": null,
            "medium": null,
            "small": {
              "height": 49,
              "url": "https://m.media-amazon.com/images/I/41cNJGm9ZFL._SL75_.jpg",
              "width": 75
            }
          },
          "variants": null
        },
        "itemInfo": {
          "byLineInfo": null,
          "classifications": null,
          "contentInfo": null,
          "contentRating": null,
          "externalIds": null,
          "features": {
            "displayValues": [
              "Alexa can show you more - Echo Show 5 includes a 5.5” display so you can see news and weather at a glance, make video calls, view compatible cameras, stream music and shows, and more.",
              "Small size, bigger sound – Stream your favorite music, shows, podcasts, and more from providers like Amazon Music, Spotify, and Prime Video—now with deeper bass and clearer vocals. Includes a 5.5\" display so you can view shows, song titles, and more at a glance.",
              "Keep your home comfortable – Control compatible smart devices like lights and thermostats, even while you're away.",
              "See more with the built-in camera – Check in on your family, pets, and more using the built-in camera. Drop in on your home when you're out or view the front door from your Echo Show 5 with compatible video doorbells.",
              "See your photos on display – When not in use, set the background to a rotating slideshow of your favorite photos. Invite family and friends to share photos to your Echo Show. Prime members also get unlimited cloud photo storage.",
              "Stay connected with video calling – Use the 2 MP camera to call friends and family who have the Alexa app or an Echo device with a screen. Make announcements to other compatible devices in your home.",
              "Designed to protect your privacy— Amazon is not in the business of selling your personal information to others. Built with multiple layers of privacy controls including a mic/camera off button and built-in camera shutter, as well as support for viewing end-to-end encrypted Ring video.",
              "Designed for sustainability – This device’s fabric is made from 100% post-consumer recycled polyester yarn and aluminum is made from 100% recycled aluminum. The device packaging is 100% recyclable."
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": null,
          "productInfo": null,
          "technicalInfo": null,
          "title": {
            "displayValue": "Amazon Echo Show 5 (newest model), Smart display with Alexa+ Early Access, 2x the bass and clearer sound, Charcoal",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": null
        },
        "offersV2": null,
        "parentASIN": "B0BZTW3TCH",
        "score": null,
        "variationAttributes": null
      },
      {
        "asin": "B09B8V1LZ3",
        "browseNodeInfo": null,
        "customerReviews": null,
        "detailPageURL": "https://www.amazon.com/dp/B09B8V1LZ3?tag=xyz-20&linkCode=ogi&th=1&psc=1&language=en_US",
        "images": {
          "primary": {
            "hiRes": null,
            "large": null,
            "medium": null,
            "small": {
              "height": 75,
              "url": "https://m.media-amazon.com/images/I/315PBUzfZiL._SL75_.jpg",
              "width": 46
            }
          },
          "variants": null
        },
        "itemInfo": {
          "byLineInfo": null,
          "classifications": null,
          "contentInfo": null,
          "contentRating": null,
          "externalIds": null,
          "features": {
            "displayValues": [
              "Your favorite music and content – Play music, audiobooks, and podcasts from Amazon Music, Apple Music, Spotify and others or via Bluetooth throughout your home.",
              "Alexa is happy to help – Ask Alexa for weather updates and to set hands-free timers, get answers to your questions and even hear jokes. Need a few extra minutes in the morning? Just tap your Echo Dot to snooze your alarm.",
              "Keep your home comfortable – Control compatible smart home devices with your voice and routines triggered by built-in motion or indoor temperature sensors. Create routines to automatically turn on lights when you walk into a room, or start a fan if the inside temperature goes above your comfort zone.",
              "Designed to protect your privacy – Amazon is not in the business of selling your personal information to others. Built with multiple layers of privacy controls, including a mic off button.",
              "Do more with device pairing– Fill your home with music using compatible Echo devices in different rooms, create a home theatre system with Fire TV, or extend wifi coverage with a compatible eero network so you can say goodbye to drop-offs and buffering."
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": null,
          "productInfo": null,
          "technicalInfo": null,
          "title": {
            "displayValue": "Amazon Echo Dot (newest model) - Vibrant sounding speaker with Alexa+ Early Access, Great for bedrooms, dining rooms and offices, Charcoal",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": null
        },
        "offersV2": null,
        "parentASIN": "B0BF73CTQF",
        "score": null,
        "variationAttributes": null
      }
    ]
  }
}
```

## Best Practices

-   **Token Management:** Cache access tokens and reuse them until they expire to minimize authentication requests (This is handled automatically when you are using the SDK)
-   **Error Handling:** Implement retry logic with exponential backoff for transient failures
-   **Security:** Never expose your client\_id and client\_secret in client-side code or public repositories
-   **Rate Limiting:** Respect API rate limits and implement appropriate throttling in your application

## Using cURL

Source: `_creatorsapi_docs_en-us_get-started_using-curl#regional-endpoints.html`

# Using cURL

Once you have signed up for Amazon Associates program and Creators API, you can start sending requests to the API. You can send requests to Creators API using SDKs (recommended) or directly using HTTP requests. This guide shows you how to make API calls using cURL.

## Request Components

Requests to Creators API have the following main components:

1.  **Headers** - Authentication and metadata about the request
2.  **Request Payload** - JSON formatted Request Body

The following sections explain how to obtain the authentication token for headers, how to construct the request payload, and finally how to put everything together in a complete cURL command.

## Step 1: Fetch Access Token (for Headers)

To authenticate your requests, you need to obtain an OAuth 2.0 access token from the Cognito token endpoint. This token will be used in the Authorization header for all API calls.

## Regional Endpoints

The Creators API uses different authentication endpoints based on your credential version:

**Region**

**Version**

**Token Endpoint**

**Marketplaces**

NA (North America)

2.1

`creatorsapi.auth.us-east-1.amazoncognito.com/oauth2/token`

US, CA, MX, BR

EU (Europe)

2.2

`creatorsapi.auth.eu-south-2.amazoncognito.com/oauth2/token`

UK, DE, FR, IT, ES, NL, BE, EG, IN, IE, PL, SA, SE, TR, AE

FE (Far East)

2.3

`creatorsapi.auth.us-west-2.amazoncognito.com/oauth2/token`

JP, SG, AU

NA (North America)

3.1

`api.amazon.com/auth/o2/token`

US, CA, MX, BR

EU (Europe)

3.2

`api.amazon.co.uk/auth/o2/token`

UK, DE, FR, IT, ES, NL, BE, EG, IN, IE, PL, SA, SE, TR, AE

FE (Far East)

3.3

`api.amazon.co.jp/auth/o2/token`

JP, SG, AU

The API endpoint for all regions is: `https://creatorsapi.amazon`

For a complete list of marketplace-specific parameters, see [Common Request Headers and Parameters](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.md).

## Token Generation for v2.x Credentials

### Method 1: Credentials in Request Body

**Headers:**

-   `Content-Type: application/x-www-form-urlencoded`

**Request Body:**

Copy

```
grant_type=client_credentials&client_id=YOUR_CLIENT_ID&client_secret=YOUR_CLIENT_SECRET&scope=creatorsapi/default
```

**Example cURL Command:**

Copy

```
curl -v -X POST https://creatorsapi.auth.us-west-2.amazoncognito.com/oauth2/token \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "grant_type=client_credentials&client_id=YOUR_CLIENT_ID&client_secret=YOUR_CLIENT_SECRET&scope=creatorsapi/default"
```

### Method 2: Credentials in Authorization Header

**Headers:**

-   `Content-Type: application/x-www-form-urlencoded`
-   `Authorization: Basic <Base64-encoded credentials>`

**Authorization Header:** Encode your `client_id:client_secret` in Base64 format. For example, if your client\_id is `abc123` and client\_secret is `xyz789`, you would encode `abc123:xyz789`.

**Request Body:**

Copy

```
grant_type=client_credentials&scope=creatorsapi/default
```

**Example cURL Command:**

Copy

```
curl -X POST https://creatorsapi.auth.us-west-2.amazoncognito.com/oauth2/token \
 -H "Content-Type: application/x-www-form-urlencoded" \
 -H "Authorization: Basic $(echo -n 'YOUR_CLIENT_ID:YOUR_CLIENT_SECRET' | base64)" \
 -d "grant_type=client_credentials&scope=creatorsapi/default"
```

**Response:**

Copy

```
{
  "access_token": "eyJraWQiOiJ...",
  "expires_in": 3600,
  "token_type": "Bearer"
}
```

**Note:** Access tokens typically expire after 3600 seconds (1 hour). Store the token securely and refresh it before expiration. **New access token is not needed for every request and should be cached until they expire.**

## Token Generation for v3.x Credentials (LwA)

For v3.x credentials, use the Login with Amazon (LwA) token endpoint with a JSON request body. Use the appropriate regional endpoint from the table above.

**Headers:**

-   `Content-Type: application/json`

**Request Body:**

Copy

```
{
  "grant_type": "client_credentials",
  "client_id": "YOUR_CLIENT_ID",
  "client_secret": "YOUR_CLIENT_SECRET",
  "scope": "creatorsapi::default"
}
```

**Example cURL Command:**

Copy

```
curl -X POST https://api.amazon.com/auth/o2/token \
  -H "Content-Type: application/json" \
  -d '{
    "grant_type": "client_credentials",
    "client_id": "YOUR_CLIENT_ID",
    "client_secret": "YOUR_CLIENT_SECRET",
    "scope": "creatorsapi::default"
  }'
```

**Response:**

Copy

```
{
  "access_token": "Atc|MQICIJvSKVTZ...",
  "scope": "creatorsapi::default",
  "token_type": "bearer",
  "expires_in": 3600
}
```

## Step 2: Make API Calls to CreatorsAPI

Once you have the access token, include it in the `Authorization` header for all API requests.

> Examples in this section use the US locale for headers and request parameters. These common parameters are listed in [Common Request Headers and Parameters](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.md), and locale-specific values (such as marketplace) can be adjusted for your target Amazon locale.

**Base URL:** `https://creatorsapi.amazon`

**Headers:**

-   `Authorization: Bearer <access_token>, Version <credential_version>` (for v2.x credentials)
-   `Authorization: Bearer <access_token>` (for v3.x credentials)
-   `Content-Type: application/json`
-   `x-marketplace: <marketplace_domain>`

### Example: GetItems API Call

Copy

```
curl -X POST https://creatorsapi.amazon/catalog/v1/getItems \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
  -H "Content-Type: application/json" \
  -H "x-marketplace: www.amazon.com" \
  -d '{
    "itemIds": ["B09B2SBHQK", "B09B8V1LZ3"],
    "itemIdType": "ASIN",
    "marketplace": "www.amazon.com",
    "partnerTag": "xyz-20",
    "resources": [
      "images.primary.small",
      "itemInfo.title",
      "itemInfo.features",
      "parentASIN"
    ]
  }'
```

**Response:**

Copy

```
{
  "itemsResult": {
    "items": [
      {
        "asin": "B09B2SBHQK",
        "browseNodeInfo": null,
        "customerReviews": null,
        "detailPageURL": "https://www.amazon.com/dp/B09B2SBHQK?tag=xyz-20&linkCode=ogi&th=1&psc=1&language=en_US",
        "images": {
          "primary": {
            "hiRes": null,
            "large": null,
            "medium": null,
            "small": {
              "height": 49,
              "url": "https://m.media-amazon.com/images/I/41cNJGm9ZFL._SL75_.jpg",
              "width": 75
            }
          },
          "variants": null
        },
        "itemInfo": {
          "byLineInfo": null,
          "classifications": null,
          "contentInfo": null,
          "contentRating": null,
          "externalIds": null,
          "features": {
            "displayValues": [
              "Alexa can show you more - Echo Show 5 includes a 5.5” display so you can see news and weather at a glance, make video calls, view compatible cameras, stream music and shows, and more.",
              "Small size, bigger sound – Stream your favorite music, shows, podcasts, and more from providers like Amazon Music, Spotify, and Prime Video—now with deeper bass and clearer vocals. Includes a 5.5\" display so you can view shows, song titles, and more at a glance.",
              "Keep your home comfortable – Control compatible smart devices like lights and thermostats, even while you're away.",
              "See more with the built-in camera – Check in on your family, pets, and more using the built-in camera. Drop in on your home when you're out or view the front door from your Echo Show 5 with compatible video doorbells.",
              "See your photos on display – When not in use, set the background to a rotating slideshow of your favorite photos. Invite family and friends to share photos to your Echo Show. Prime members also get unlimited cloud photo storage.",
              "Stay connected with video calling – Use the 2 MP camera to call friends and family who have the Alexa app or an Echo device with a screen. Make announcements to other compatible devices in your home.",
              "Designed to protect your privacy— Amazon is not in the business of selling your personal information to others. Built with multiple layers of privacy controls including a mic/camera off button and built-in camera shutter, as well as support for viewing end-to-end encrypted Ring video.",
              "Designed for sustainability – This device’s fabric is made from 100% post-consumer recycled polyester yarn and aluminum is made from 100% recycled aluminum. The device packaging is 100% recyclable."
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": null,
          "productInfo": null,
          "technicalInfo": null,
          "title": {
            "displayValue": "Amazon Echo Show 5 (newest model), Smart display with Alexa+ Early Access, 2x the bass and clearer sound, Charcoal",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": null
        },
        "offersV2": null,
        "parentASIN": "B0BZTW3TCH",
        "score": null,
        "variationAttributes": null
      },
      {
        "asin": "B09B8V1LZ3",
        "browseNodeInfo": null,
        "customerReviews": null,
        "detailPageURL": "https://www.amazon.com/dp/B09B8V1LZ3?tag=xyz-20&linkCode=ogi&th=1&psc=1&language=en_US",
        "images": {
          "primary": {
            "hiRes": null,
            "large": null,
            "medium": null,
            "small": {
              "height": 75,
              "url": "https://m.media-amazon.com/images/I/315PBUzfZiL._SL75_.jpg",
              "width": 46
            }
          },
          "variants": null
        },
        "itemInfo": {
          "byLineInfo": null,
          "classifications": null,
          "contentInfo": null,
          "contentRating": null,
          "externalIds": null,
          "features": {
            "displayValues": [
              "Your favorite music and content – Play music, audiobooks, and podcasts from Amazon Music, Apple Music, Spotify and others or via Bluetooth throughout your home.",
              "Alexa is happy to help – Ask Alexa for weather updates and to set hands-free timers, get answers to your questions and even hear jokes. Need a few extra minutes in the morning? Just tap your Echo Dot to snooze your alarm.",
              "Keep your home comfortable – Control compatible smart home devices with your voice and routines triggered by built-in motion or indoor temperature sensors. Create routines to automatically turn on lights when you walk into a room, or start a fan if the inside temperature goes above your comfort zone.",
              "Designed to protect your privacy – Amazon is not in the business of selling your personal information to others. Built with multiple layers of privacy controls, including a mic off button.",
              "Do more with device pairing– Fill your home with music using compatible Echo devices in different rooms, create a home theatre system with Fire TV, or extend wifi coverage with a compatible eero network so you can say goodbye to drop-offs and buffering."
            ],
            "label": "Features",
            "locale": "en_US"
          },
          "manufactureInfo": null,
          "productInfo": null,
          "technicalInfo": null,
          "title": {
            "displayValue": "Amazon Echo Dot (newest model) - Vibrant sounding speaker with Alexa+ Early Access, Great for bedrooms, dining rooms and offices, Charcoal",
            "label": "Title",
            "locale": "en_US"
          },
          "tradeInInfo": null
        },
        "offersV2": null,
        "parentASIN": "B0BF73CTQF",
        "score": null,
        "variationAttributes": null
      }
    ]
  }
}
```

## Best Practices

-   **Token Management:** Cache access tokens and reuse them until they expire to minimize authentication requests (This is handled automatically when you are using the SDK)
-   **Error Handling:** Implement retry logic with exponential backoff for transient failures
-   **Security:** Never expose your client\_id and client\_secret in client-side code or public repositories
-   **Rate Limiting:** Respect API rate limits and implement appropriate throttling in your application

## Get Started

Source: `_creatorsapi_docs_en-us_get-started.html`

# Get Started

This guide contains resources on how to quickly get started with Creators API

-   [Using SDK](./_creatorsapi_docs_en-us_get-started.md)
-   [Using cURL](./_creatorsapi_docs_en-us_get-started_using-curl.md)

## Page Not Found

Source: `_creatorsapi_docs_en-us_getbrowsenodes.html`

# Page Not Found

The page you are looking for does not exist.

## Page Not Found

Source: `_creatorsapi_docs_en-us_images.html`

# Page Not Found

The page you are looking for does not exist.

## Welcome to Creators API

Source: `_creatorsapi_docs_en-us_introduction.html`

# Welcome to Creators API

Build applications that integrate with Amazon's product catalog and help your audience discover products.

## What is the Creators API?

The Creators API is a REST-based API that provides programmatic access to Amazon's product catalog data, enabling publishers, influencers, and affiliate partners to create innovative and engaging shopping experiences for their audiences. Applications using the Creators API can deliver relevant product recommendations, integrate rich product content, and provide seamless shopping experiences, helping creators grow their businesses through the Amazon Associates program.

## API Operations

Operation

Description

[SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md)

Search for products using keywords, filters, and browse nodes

[GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md)

Retrieve detailed information for specific products by ASIN or other identifiers

[GetVariations](./_creatorsapi_docs_en-us_api-reference_operations_get-variations.md)

Get all variations of a parent product

[GetBrowseNodes](./_creatorsapi_docs_en-us_api-reference_operations_get-browse-nodes.md)

Fetch category information and browse node hierarchy

## Prerequisites

To use the Creators API, you must:

1.  Be enrolled in the Amazon Associates program for your target marketplace
2.  Have at least 10 qualifying sales within the past 30 days to access the PA API through the Creators API
3.  Register for API access through [Associates Central](http://affiliate-program.amazon.com/creatorsapi)
4.  Generate API credentials

See [Register for Creators API](./_creatorsapi_docs_en-us_onboarding_register-for-creators-api.md) for detailed instructions.

## Getting Started

-   [Getting Started](./_creatorsapi_docs_en-us_get-started.md) - Setup instructions and operations overview
-   [Using SDK](./_creatorsapi_docs_en-us_get-started.md) - SDKs for Node.js, Python, PHP, and Java
-   [Using cURL](./_creatorsapi_docs_en-us_get-started_using-curl.md) - Making direct HTTP requests
-   [API Reference](./_creatorsapi_docs_en-us_api-reference.md) - Complete API documentation

## Migrating from Product Advertising API?

If you're currently using Product Advertising API 5.0, see the [Migration Guide](./_creatorsapi_docs_en-us_migrating-to-creatorsapi-from-paapi.md) for step-by-step instructions on transitioning to Creators API.

## Support

-   [Troubleshooting](./_creatorsapi_docs_en-us_troubleshooting.md) - Common issues and solutions
-   [FAQ](./_creatorsapi_docs_en-us_frequently-asked-questions.md) - Frequently asked questions
-   [Contact Us](./_creatorsapi_docs_en-us_contact-us.md) - Get help from support
-   [License Agreement](./_creatorsapi_docs_en-us_license-agreement.md) - Terms and conditions

## Server Busy

Source: `_creatorsapi_docs_en-us_item-info.html`

Click the button below to continue shopping

 

Continue shopping

© 1996-2025, Amazon.com, Inc. or its affiliates ![](https://fls-na.amazon.com/1/oc-csi/1/OP/requestId=2X9WGMWQY98FFGG7BXEW&js=1)

## Server Busy

Source: `_creatorsapi_docs_en-us_license-agreement.html`

Click the button below to continue shopping

 

Continue shopping

© 1996-2025, Amazon.com, Inc. or its affiliates ![](https://fls-na.amazon.com/1/oc-csi/1/OP/requestId=XWEVR5SP87QSAFQVD5D2&js=1)

## Locale Information for AU Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_australia.html`

# Locale Information for AU Marketplace

Locale Information for various parameters in AU Marketplace:

## Marketplace

The Marketplace value for AU marketplace is: `www.amazon.com.au`

## Language of Preference

The default Language of preference in AU marketplace is: `en_AU`

### Valid Languages

Language

Description

`en_AU`

English - AUSTRALIA

## Currency of Preference

The default Currency of preference in AU marketplace is: `AUD`

### Valid Currencies

Currency

Description

`AUD`

`Australian Dollar`

## Search Index

Search Index

Display Name

All

All Departments

Automotive

Automotive

Baby

Baby

Beauty

Beauty

Books

Books

Computers

Computers

Electronics

Electronics

EverythingElse

Everything Else

Fashion

Clothing & Shoes

GiftCards

Gift Cards

HealthPersonalCare

Health, Household & Personal Care

HomeAndKitchen

Home & Kitchen

KindleStore

Kindle Store

Lighting

Lighting

Luggage

Luggage & Travel Gear

MobileApps

Apps & Games

MoviesAndTV

Movies & TV

Music

CDs & Vinyl

OfficeProducts

Stationery & Office Products

PetSupplies

Pet Supplies

Software

Software

SportsAndOutdoors

Sports, Fitness & Outdoors

ToolsAndHomeImprovement

Home Improvement

ToysAndGames

Toys & Games

VideoGames

Video Games

## Locale Information for BE Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_belgium.html`

# Locale Information for BE Marketplace

Locale Information for various parameters in BE Marketplace:

## Marketplace

The Marketplace value for BE marketplace is: `www.amazon.com.be`

## Language of Preference

The default Language of preference in BE marketplace is: `fr_BE`

### Valid Languages

Language

Description

`fr_BE`

French - BELGIUM

`nl_BE`

Dutch - BELGIUM

`en_GB`

English - UNITED KINGDOM

## Currency of Preference

The default Currency of preference in BE marketplace is: `EUR`

### Valid Currencies

Currency

Description

`EUR`

`Euro`

## Search Index

Search Index

Display Name

All

Toutes nos catégories

Automotive

Auto et Moto

Baby

Bébé

Beauty

Beauté et Parfum

Books

Livres

Electronics

High-Tech

Fashion

Mode

Garden

Jardin

GiftCards

Boutique chèques-cadeaux

Grocery

Alimentation

HomeImprovement

Bricolage

HealthPersonalCare

Santé & Hygiène personnelle

Industrial

Secteur industriel et scientifique

Music

Musique : CD & Vinyles

MusicalInstruments

Instruments de musique

MoviesAndTV

Cinéma & TV

OfficeProducts

Office Produits de bureau

PetSupplies

Animalerie

Software

Logiciels

SportsAndOutdoors

Sports & Activités en plein-air

Toys

Jeux et Jouets

VideoGames

Jeux vidéo

## Locale Information for BR Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_brazil.html`

# Locale Information for BR Marketplace

Locale Information for various parameters in BR Marketplace:

## Marketplace

The Marketplace value for BR marketplace is: `www.amazon.com.br`

## Language of Preference

The default Language of preference in BR marketplace is: `pt_BR`

### Valid Languages

Language

Description

`pt_BR`

Portuguese - BRAZIL

## Currency of Preference

The default Currency of preference in BR marketplace is: `BRL`

### Valid Currencies

Currency

Description

`BRL`

`Brazilian Real`

## Search Index

Search Index

Display Name

All

Todos os departamentos

Books

Livros

Computers

Computadores e Informática

Electronics

Eletrônicos

HomeAndKitchen

Casa e Cozinha

KindleStore

Loja Kindle

MobileApps

Apps e Jogos

OfficeProducts

Material para Escritório e Papelaria

ToolsAndHomeImprovement

Ferramentas e Materiais de Construção

VideoGames

Games

## Locale Information for CA Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_canada.html`

# Locale Information for CA Marketplace

Locale Information for various parameters in CA Marketplace:

## Marketplace

The Marketplace value for CA marketplace is: `www.amazon.ca`

## Language of Preference

The default Language of preference in CA marketplace is: `en_CA`

### Valid Languages

Language

Description

`en_CA`

English - CANADA

`fr_CA`

French - CANADA

## Currency of Preference

The default Currency of preference in CA marketplace is: `CAD`

### Valid Currencies

Currency

Description

`CAD`

`Canadian Dollar`

## Search Index

Search Index

Display Name

All

All Department

Apparel

Clothing & Accessories

Automotive

Automotive

Baby

Baby

Beauty

Beauty

Books

Books

Classical

Classical Music

Electronics

Electronics

EverythingElse

Everything Else

ForeignBooks

English Books

GardenAndOutdoor

Patio, Lawn & Garden

GiftCards

Gift Cards

GroceryAndGourmetFood

Grocery & Gourmet Food

Handmade

Handmade

HealthPersonalCare

Health & Personal Care

HomeAndKitchen

Home & Kitchen

Industrial

Industrial & Scientific

Jewelry

Jewelry

KindleStore

Kindle Store

Luggage

Luggage & Bags

LuxuryBeauty

Luxury Beauty

MobileApps

Apps & Games

MoviesAndTV

Movies & TV

Music

Music

MusicalInstruments

Musical Instruments, Stage & Studio

OfficeProducts

Office Products

PetSupplies

Pet Supplies

Shoes

Shoes & Handbags

Software

Software

SportsAndOutdoors

Sports & Outdoors

ToolsAndHomeImprovement

Tools & Home Improvement

ToysAndGames

Toys & Games

VHS

VHS

VideoGames

Video Games

Watches

Watches

## Locale Information for EG Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_egypt.html`

# Locale Information for EG Marketplace

Locale Information for various parameters in EG Marketplace:

## Marketplace

The Marketplace value for EG marketplace is: `www.amazon.eg`

## Language of Preference

The default Language of preference in EG marketplace is: `en_AE`

### Valid Languages

Language

Description

`en_AE`

English - UNITED ARAB EMIRATES

`ar_AE`

Arabic - UNITED ARAB EMIRATES

## Currency of Preference

The default Currency of preference in EG marketplace is: `EGP`

### Valid Currencies

Currency

Description

`EGP`

`Egyptian pound`

## Search Index

Search Index

Display Name

All

All

ArtsAndCrafts

Arts, Crafts & Sewing

Automotive

Automotive Parts & Accessories

Baby

Baby

Beauty

Beauty & Personal Care

Books

Books

Electronics

Electronics

Fashion

Amazon Fashion

Garden

Home & Garden

Grocery

Grocery & Gourmet Food

HealthPersonalCare

Health, Household & Baby Care

Home

Home Related

HomeImprovement

Tools & Home Improvement

Industrial

Industrial & Scientific

MusicalInstruments

Musical Instruments

OfficeProducts

Office Products

PetSupplies

Pet Supplies

Software

Software

SportsAndOutdoors

Sports

Toys

Toys & Games

VideoGames

Video Games

## Locale Information for FR Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_france.html`

# Locale Information for FR Marketplace

Locale Information for various parameters in FR Marketplace:

## Marketplace

The Marketplace value for FR marketplace is: `www.amazon.fr`

## Language of Preference

The default Language of preference in FR marketplace is: `fr_FR`

### Valid Languages

Language

Description

`fr_FR`

French - FRANCE

## Currency of Preference

The default Currency of preference in FR marketplace is: `EUR`

### Valid Currencies

Currency

Description

`EUR`

`Euro`

## Search Index

Search Index

Display Name

All

Toutes nos catégories

Apparel

Vêtements et accessoires

Appliances

Gros électroménager

Automotive

Auto et Moto

Baby

Bébés & Puériculture

Beauty

Beauté et Parfum

Books

Livres en français

Computers

Informatique

DigitalMusic

Téléchargement de musique

Electronics

High-Tech

EverythingElse

Autres

Fashion

Mode

ForeignBooks

Livres anglais et étrangers

GardenAndOutdoor

Jardin

GiftCards

Boutique chèques-cadeaux

GroceryAndGourmetFood

Epicerie

Handmade

Handmade

HealthPersonalCare

Hygiène et Santé

HomeAndKitchen

Cuisine & Maison

Industrial

Secteur industriel & scientifique

Jewelry

Bijoux

KindleStore

Boutique Kindle

Lighting

Luminaires et Eclairage

Luggage

Bagages

LuxuryBeauty

Beauté Prestige

MobileApps

Applis & Jeux

MoviesAndTV

DVD & Blu-ray

Music

Musique : CD & Vinyles

MusicalInstruments

Instruments de musique & Sono

OfficeProducts

Fournitures de bureau

PetSupplies

Animalerie

Shoes

Chaussures et Sacs

Software

Logiciels

SportsAndOutdoors

Sports et Loisirs

ToolsAndHomeImprovement

Bricolage

ToysAndGames

Jeux et Jouets

VHS

VHS

VideoGames

Jeux vidéo

Watches

Montres

## Locale Information for DE Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_germany.html`

# Locale Information for DE Marketplace

Locale Information for various parameters in DE Marketplace:

## Marketplace

The Marketplace value for DE marketplace is: `www.amazon.de`

## Language of Preference

The default Language of preference in DE marketplace is: `de_DE`

### Valid Languages

Language

Description

`cs_CZ`

Czech - CZECHIA

`de_DE`

German - GERMANY

`en_GB`

English - UNITED KINGDOM

`nl_NL`

Dutch - NETHERLANDS

`pl_PL`

Polish - POLAND

`tr_TR`

Turkish - TURKEY

## Currency of Preference

The default Currency of preference in DE marketplace is: `EUR`

### Valid Currencies

Currency

Description

`EUR`

`Euro`

## Search Index

Search Index

Display Name

All

Alle Kategorien

AmazonVideo

Prime Video

Apparel

Bekleidung

Appliances

Elektro-Großgeräte

Automotive

Auto & Motorrad

Baby

Baby

Beauty

Beauty

Books

Bücher

Classical

Klassik

Computers

Computer & Zubehör

DigitalMusic

Musik-Downloads

Electronics

Elektronik & Foto

EverythingElse

Sonstiges

Fashion

Fashion

ForeignBooks

Bücher (Fremdsprachig)

GardenAndOutdoor

Garten

GiftCards

Geschenkgutscheine

GroceryAndGourmetFood

Lebensmittel & Getränke

Handmade

Handmade

HealthPersonalCare

Drogerie & Körperpflege

HomeAndKitchen

Küche, Haushalt & Wohnen

Industrial

Gewerbe, Industrie & Wissenschaft

Jewelry

Schmuck

KindleStore

Kindle-Shop

Lighting

Beleuchtung

Luggage

Koffer, Rucksäcke & Taschen

LuxuryBeauty

Luxury Beauty

Magazines

Zeitschriften

MobileApps

Apps & Spiele

MoviesAndTV

DVD & Blu-ray

Music

Musik-CDs & Vinyl

MusicalInstruments

Musikinstrumente & DJ-Equipment

OfficeProducts

Bürobedarf & Schreibwaren

PetSupplies

Haustier

Photo

Kamera & Foto

Shoes

Schuhe & Handtaschen

Software

Software

SportsAndOutdoors

Sport & Freizeit

ToolsAndHomeImprovement

Baumarkt

ToysAndGames

Spielzeug

VHS

VHS

VideoGames

Games

Watches

Uhren

## Locale Information for IN Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_india.html`

# Locale Information for IN Marketplace

Locale Information for various parameters in IN Marketplace:

## Marketplace

The Marketplace value for IN marketplace is: `www.amazon.in`

## Language of Preference

The default Language of preference in IN marketplace is: `en_IN`

### Valid Languages

Language

Description

`en_IN`

English - INDIA

`hi_IN`

Hindi - INDIA

`kn_IN`

Kannada - INDIA

`ml_IN`

Malayalam - INDIA

`ta_IN`

Tamil - INDIA

`te_IN`

Telugu - INDIA

## Currency of Preference

The default Currency of preference in IN marketplace is: `INR`

### Valid Currencies

Currency

Description

`INR`

`Indian Rupee`

## Search Index

Search Index

Display Name

All

All Categories

Apparel

Clothing & Accessories

Appliances

Appliances

Automotive

Car & Motorbike

Baby

Baby

Beauty

Beauty

Books

Books

Collectibles

Collectibles

Computers

Computers & Accessories

Electronics

Electronics

EverythingElse

Everything Else

Fashion

Amazon Fashion

Furniture

Furniture

GardenAndOutdoor

Garden & Outdoors

GiftCards

Gift Cards

GroceryAndGourmetFood

Grocery & Gourmet Foods

HealthPersonalCare

Health & Personal Care

HomeAndKitchen

Home & Kitchen

Industrial

Industrial & Scientific

Jewelry

Jewellery

KindleStore

Kindle Store

Luggage

Luggage & Bags

LuxuryBeauty

Luxury Beauty

MobileApps

Apps & Games

MoviesAndTV

Movies & TV Shows

Music

Music

MusicalInstruments

Musical Instruments

OfficeProducts

Office Products

PetSupplies

Pet Supplies

Shoes

Shoes & Handbags

Software

Software

SportsAndOutdoors

Sports, Fitness & Outdoors

ToolsAndHomeImprovement

Tools & Home Improvement

ToysAndGames

Toys & Games

VideoGames

Video Games

Watches

Watches

## Locale Information for BE Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_ireland.html`

# Locale Information for BE Marketplace

Locale Information for various parameters in IE Marketplace:

## Marketplace

The Marketplace value for IE marketplace is: `www.amazon.ie`

## Language of Preference

The default Language of preference in BE marketplace is: `en_IE`

### Valid Languages

Language

Description

`en_IE`

English - Ireland

## Currency of Preference

The default Currency of preference in IE marketplace is: `EUR`

### Valid Currencies

Currency

Description

`EUR`

`Euro`

## Search Index

Search Index

Display Name

All

All Departments

ArtsAndCrafts

Arts & Crafts

Automotive

Automotive

Baby

Baby Products

Beauty

Beauty

Books

Books

Electronics

Electronics

Fashion

Fashion

GardenAndOutdoor

Garden

GiftCards

Gift Cards

GroceryAndGourmetFood

Grocery

Home

Home & Kitchen

HomeImprovement

DIY & Tools

HealthPersonalCare

Health & Household

Industrial

Industrial & Scientific

Music

CDs & Vinyl

MusicalInstruments

Musical Instruments

EverythingElse

Everything Else

MoviesAndTV

Movies & TV

OfficeProducts

Office Products

PetSupplies

Pet Supplies

Software

Software

SportsAndOutdoors

Sports & Outdoors

ToysAndGames

Toys & Games

VideoGames

Videogames

## Locale Information for IT Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_italy.html`

# Locale Information for IT Marketplace

Locale Information for various parameters in IT Marketplace:

## Marketplace

The Marketplace value for IT marketplace is: `www.amazon.it`

## Language of Preference

The default Language of preference in IT marketplace is: `it_IT`

### Valid Languages

Language

Description

`it_IT`

Italian - ITALY

## Currency of Preference

The default Currency of preference in IT marketplace is: `EUR`

### Valid Currencies

Currency

Description

`EUR`

`Euro`

## Search Index

Search Index

Display Name

All

Tutte le categorie

Apparel

Abbigliamento

Appliances

Grandi elettrodomestici

Automotive

Auto e Moto

Baby

Prima infanzia

Beauty

Bellezza

Books

Libri

Computers

Informatica

DigitalMusic

Musica Digitale

Electronics

Elettronica

EverythingElse

Altro

Fashion

Moda

ForeignBooks

Libri in altre lingue

GardenAndOutdoor

Giardino e giardinaggio

GiftCards

Buoni Regalo

GroceryAndGourmetFood

Alimentari e cura della casa

Handmade

Handmade

HealthPersonalCare

Salute e cura della persona

HomeAndKitchen

Casa e cucina

Industrial

Industria e Scienza

Jewelry

Gioielli

KindleStore

Kindle Store

Lighting

Illuminazione

Luggage

Valigeria

MobileApps

App e Giochi

MoviesAndTV

Film e TV

Music

CD e Vinili

MusicalInstruments

Strumenti musicali e DJ

OfficeProducts

Cancelleria e prodotti per ufficio

PetSupplies

Prodotti per animali domestici

Shoes

Scarpe e borse

Software

Software

SportsAndOutdoors

Sport e tempo libero

ToolsAndHomeImprovement

Fai da te

ToysAndGames

Giochi e giocattoli

VideoGames

Videogiochi

Watches

Orologi

## Locale Information for JP Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_japan.html`

# Locale Information for JP Marketplace

Locale Information for various parameters in JP Marketplace:

## Marketplace

The Marketplace value for JP marketplace is: `www.amazon.co.jp`

## Language of Preference

The default Language of preference in JP marketplace is: `ja_JP`

### Valid Languages

Language

Description

`en_US`

English - UNITED STATES

`ja_JP`

Japanese - JAPAN

`zh_CN`

Chinese - CHINA

## Currency of Preference

The default Currency of preference in JP marketplace is: `JPY`

### Valid Currencies

Currency

Description

`JPY`

`Japanese Yen`

## Search Index

Search Index

Display Name

All

All Departments

AmazonVideo

Prime Video

Apparel

Clothing & Accessories

Appliances

Large Appliances

Automotive

Car & Bike Products

Baby

Baby & Maternity

Beauty

Beauty

Books

Japanese Books

Classical

Classical

Computers

Computers & Accessories

CreditCards

Credit Cards

DigitalMusic

Digital Music

Electronics

Electronics & Cameras

EverythingElse

Everything Else

Fashion

Fashion

FashionBaby

Kids & Baby

FashionMen

Men

FashionWomen

Women

ForeignBooks

English Books

GiftCards

Gift Cards

GroceryAndGourmetFood

Food & Beverage

HealthPersonalCare

Health & Personal Care

Hobbies

Hobby

HomeAndKitchen

Kitchen & Housewares

Industrial

Industrial & Scientific

Jewelry

Jewelry

KindleStore

Kindle Store

MobileApps

Apps & Games

MoviesAndTV

Movies & TV

Music

Music

MusicalInstruments

Musical Instruments

OfficeProducts

Stationery and Office Products

PetSupplies

Pet Supplies

Shoes

Shoes & Bags

Software

Software

SportsAndOutdoors

Sports

ToolsAndHomeImprovement

DIY, Tools & Garden

Toys

Toys

VideoGames

Computer & Video Games

Watches

Watches

## Locale Information for MX Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_mexico.html`

# Locale Information for MX Marketplace

Locale Information for various parameters in MX Marketplace:

## Marketplace

The Marketplace value for MX marketplace is: `www.amazon.com.mx`

## Language of Preference

The default Language of preference in MX marketplace is: `es_MX`

### Valid Languages

Language

Description

`es_MX`

Spanish - MEXICO

## Currency of Preference

The default Currency of preference in MX marketplace is: `MXN`

### Valid Currencies

Currency

Description

`MXN`

`Mexican Peso`

## Search Index

Search Index

Display Name

All

Todos los departamentos

Automotive

Auto

Baby

Bebé

Books

Libros

Electronics

Electrónicos

Fashion

Ropa, Zapatos y Accesorios

FashionBaby

Ropa, Zapatos y Accesorios Bebé

FashionBoys

Ropa, Zapatos y Accesorios Niños

FashionGirls

Ropa, Zapatos y Accesorios Niñas

FashionMen

Ropa, Zapatos y Accesorios Hombres

FashionWomen

Ropa, Zapatos y Accesorios Mujeres

GroceryAndGourmetFood

Alimentos y Bebidas

Handmade

Productos Handmade

HealthPersonalCare

Salud, Belleza y Cuidado Personal

HomeAndKitchen

Hogar y Cocina

IndustrialAndScientific

Industria y ciencia

KindleStore

Tienda Kindle

MoviesAndTV

Películas y Series de TV

Music

Música

MusicalInstruments

Instrumentos musicales

OfficeProducts

Oficina y Papelería

PetSupplies

Mascotas

Software

Software

SportsAndOutdoors

Deportes y Aire Libre

ToolsAndHomeImprovement

Herramientas y Mejoras del Hogar

ToysAndGames

Juegos y juguetes

VideoGames

Videojuegos

Watches

Relojes

## Locale Information for NL Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_netherlands.html`

# Locale Information for NL Marketplace

Locale Information for various parameters in NL Marketplace:

## Marketplace

The Marketplace value for NL marketplace is: `www.amazon.nl`

## Language of Preference

The default Language of preference in NL marketplace is: `nl_NL`

### Valid Languages

Language

Description

`nl_NL`

Dutch - NETHERLANDS

## Currency of Preference

The default Currency of preference in NL marketplace is: `EUR`

### Valid Currencies

Currency

Description

`EUR`

`Euro`

## Search Index

Search Index

Display Name

All

Alle afdelingen

Automotive

Auto en motor

Baby

Babyproducten

Beauty

Beauty en persoonlijke verzorging

Books

Boeken

Electronics

Elektronica

EverythingElse

Overig

Fashion

Kleding, schoenen en sieraden

GardenAndOutdoor

Tuin, terras en gazon

GiftCards

Cadeaubonnen

GroceryAndGourmetFood

Levensmiddelen

HealthPersonalCare

Gezondheid en persoonlijke verzorging

HomeAndKitchen

Wonen en keuken

Industrial

Zakelijk, industrie en wetenschap

KindleStore

Kindle Store

MoviesAndTV

Films en tv

Music

Cd's en lp's

MusicalInstruments

Muziekinstrumenten

OfficeProducts

Kantoorproducten

PetSupplies

Huisdierbenodigdheden

Software

Software

SportsAndOutdoors

Sport en outdoor

ToolsAndHomeImprovement

Klussen en gereedschap

ToysAndGames

Speelgoed en spellen

VideoGames

Videogames

## Locale Information for PL Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_poland.html`

# Locale Information for PL Marketplace

Locale Information for various parameters in PL Marketplace:

## Marketplace

The Marketplace value for PL marketplace is: `www.amazon.pl`

## Language of Preference

The default Language of preference in PL marketplace is: `pl_PL`

### Valid Languages

Language

Description

`pl_PL`

Polish - POLAND

## Currency of Preference

The default Currency of preference in PL marketplace is: `PLN`

### Valid Currencies

Currency

Description

`PLN`

`Polish złoty`

## Search Index

Search Index

Display Name

All

Wszystkie kategorie

ArtsAndCrafts

Arts & crafts

Automotive

Motoryzacja

Baby

Dziecko

Beauty

Uroda

Books

Książki

Electronics

Elektronika

Fashion

Odzież, obuwie i akcesoria

GardenAndOutdoor

Ogród

GiftCards

Karty podarunkowe

HealthPersonalCare

Zdrowie i gospodarstwo domowe

HomeAndKitchen

Dom i kuchnia

Industrial

Biznes, przemysł i nauka

MoviesAndTV

Filmy i programy TV

Music

Muzyka

MusicalInstruments

Instrumenty muzyczne

OfficeProducts

Biuro

PetSupplies

Zwierzęta

Software

Oprogramowanie

SportsAndOutdoors

Sport i turystyka

ToolsAndHomeImprovement

Renowacja domu

ToysAndGames

Zabawki i gry

VideoGames

Gry wideo

## Locale Information for SA Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_saudi-arabia.html`

# Locale Information for SA Marketplace

Locale Information for various parameters in SA Marketplace:

## Marketplace

The Marketplace value for SA marketplace is: `www.amazon.sa`

## Language of Preference

The default Language of preference in SA marketplace is: `en_AE`

### Valid Languages

Language

Description

`en_AE`

English - UNITED ARAB EMIRATES

`ar_AE`

Arabic - UNITED ARAB EMIRATES

## Currency of Preference

The default Currency of preference in SA marketplace is: `SAR`

### Valid Currencies

Currency

Description

`SAR`

`Saudi Riyal`

## Search Index

Search Index

Display Name

All

All Categories

ArtsAndCrafts

Arts, Crafts & Sewing

Automotive

Automotive Parts & Accessories

Baby

Baby

Beauty

Beauty & Personal Care

Books

Books

Computers

Computer & Accessories

Electronics

Electronics

Fashion

Clothing, Shoes & Jewelry

GardenAndOutdoor

Home & Garden

GiftCards

Gift Cards

GroceryAndGourmetFood

Grocery & Gourmet Food

HealthPersonalCare

Health, Household & Baby Care

HomeAndKitchen

Kitchen & Dining

Industrial

Industrial & Scientific

KindleStore

Kindle Store

Miscellaneous

Everything Else

MoviesAndTV

Movies & TV

Music

CDs & Vinyl

MusicalInstruments

Musical Instruments

OfficeProducts

Office Products

PetSupplies

Pet Supplies

Software

Software

SportsAndOutdoors

Sports

ToolsAndHomeImprovement

Tools & Home Improvement

ToysAndGames

Toys & Games

VideoGames

Video Games

## Locale Information for SG Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_singapore.html`

# Locale Information for SG Marketplace

Locale Information for various parameters in SG Marketplace:

## Marketplace

The Marketplace value for SG marketplace is: `www.amazon.sg`

## Language of Preference

The default Language of preference in SG marketplace is: `en_SG`

### Valid Languages

Language

Description

`en_SG`

English - SINGAPORE

## Currency of Preference

The default Currency of preference in SG marketplace is: `SGD`

### Valid Currencies

Currency

Description

`SGD`

`Singapore Dollar`

## Search Index

Search Index

Display Name

All

All Departments

Automotive

Automotive

Baby

Baby

Beauty

Beauty & Personal Care

Computers

Computers

Electronics

Electronics

GroceryAndGourmetFood

Grocery

HealthPersonalCare

Health, Household & Personal Care

HomeAndKitchen

Home, Kitchen & Dining

OfficeProducts

Office Products

PetSupplies

Pet Supplies

SportsAndOutdoors

Sports & Outdoors

ToolsAndHomeImprovement

Tools & Home Improvement

ToysAndGames

Toys & Games

VideoGames

Video Games

## Locale Information for ES Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_spain.html`

# Locale Information for ES Marketplace

Locale Information for various parameters in ES Marketplace:

## Marketplace

The Marketplace value for ES marketplace is: `www.amazon.es`

## Language of Preference

The default Language of preference in ES marketplace is: `es_ES`

### Valid Languages

Language

Description

`es_ES`

Spanish - SPAIN

## Currency of Preference

The default Currency of preference in ES marketplace is: `EUR`

### Valid Currencies

Currency

Description

`EUR`

`Euro`

## Search Index

Search Index

Display Name

All

Todos los departamentos

AmazonVideo

Prime Video

Apparel

Ropa y accesorios

Appliances

Grandes electrodomésticos

Automotive

Coche y moto

Baby

Bebé

Beauty

Belleza

Books

Libros

Computers

Informática

DigitalMusic

Música Digital

Electronics

Electrónica

EverythingElse

Otros Productos

Fashion

Moda

ForeignBooks

Libros en idiomas extranjeros

GardenAndOutdoor

Jardín

GiftCards

Cheques regalo

GroceryAndGourmetFood

Alimentación y bebidas

Handmade

Handmade

HealthPersonalCare

Salud y cuidado personal

HomeAndKitchen

Hogar y cocina

Industrial

Industria y ciencia

Jewelry

Joyería

KindleStore

Tienda Kindle

Lighting

Iluminación

Luggage

Equipaje

MobileApps

Appstore para Android

MoviesAndTV

Películas y TV

Music

Música: CDs y vinilos

MusicalInstruments

Instrumentos musicales

OfficeProducts

Oficina y papelería

PetSupplies

Productos para mascotas

Shoes

Zapatos y complementos

Software

Software

SportsAndOutdoors

Deportes y aire libre

ToolsAndHomeImprovement

Bricolaje y herramientas

ToysAndGames

Juguetes y juegos

Vehicles

Coche - renting

VideoGames

Videojuegos

Watches

Relojes

## Locale Information for SE Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_sweden.html`

# Locale Information for SE Marketplace

Locale Information for various parameters in SE Marketplace:

## Marketplace

The Marketplace value for SE marketplace is: `www.amazon.se`

## Language of Preference

The default Language of preference in SE marketplace is: `sv_SE`

### Valid Languages

Language

Description

`sv_SE`

Swedish - SWEDEN

## Currency of Preference

The default Currency of preference in SE marketplace is: `SEK`

### Valid Currencies

Currency

Description

`SEK`

`Swedish Krona`

## Search Index

Search Index

Display Name

All

Alla avdelningar

Automotive

Delar och tillbehör till bilar

Baby

Baby

Beauty

Skönhet och kroppsvård

Books

Böcker

Electronics

Elektronik

Fashion

Kläder, skor och smycken

GroceryAndGourmetFood

Livsmedel och gourmetmat

HealthPersonalCare

Hälsa, hushåll och barnvård

HomeAndKitchen

Hem

MoviesAndTV

Filmer och TV

Music

CD och vinyl

OfficeProducts

Kontorsprodukter

PetSupplies

Husdjursprodukter

SportsAndOutdoors

Sport och outdoor

ToolsAndHomeImprovement

Verktyg och husrenovering

ToysAndGames

Leksaker och spel

VideoGames

Videospel

## Locale Information for TR Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_turkey.html`

# Locale Information for TR Marketplace

Locale Information for various parameters in TR Marketplace:

## Marketplace

The Marketplace value for TR marketplace is: `www.amazon.com.tr`

## Language of Preference

The default Language of preference in TR marketplace is: `tr_TR`

### Valid Languages

Language

Description

`tr_TR`

Turkish - TURKEY

## Currency of Preference

The default Currency of preference in TR marketplace is: `TRY`

### Valid Currencies

Currency

Description

`TRY`

`Turkish Lira`

## Search Index

Search Index

Display Name

All

Tüm Kategoriler

Baby

Bebek

Books

Kitaplar

Computers

Bilgisayarlar

Electronics

Elektronik

EverythingElse

Diğer Her Şey

Fashion

Moda

HomeAndKitchen

Ev ve Mutfak

OfficeProducts

Ofis Ürünleri

SportsAndOutdoors

Spor

ToolsAndHomeImprovement

Yapı Market

ToysAndGames

Oyuncaklar ve Oyunlar

VideoGames

PC ve Video Oyunları

## Locale Information for AE Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_united-arab-emirates.html`

# Locale Information for AE Marketplace

Locale Information for various parameters in AE Marketplace:

## Marketplace

The Marketplace value for AE marketplace is: `www.amazon.ae`

## Language of Preference

The default Language of preference in AE marketplace is: `en_AE`

### Valid Languages

Language

Description

`en_AE`

English - UNITED ARAB EMIRATES

`ar_AE`

Arabic - UNITED ARAB EMIRATES

## Currency of Preference

The default Currency of preference in AE marketplace is: `AED`

### Valid Currencies

Currency

Description

`AED`

`Arab Emirates Dirham`

## Search Index

Search Index

Display Name

All

All Departments

Appliances

Appliances

ArtsAndCrafts

Arts, Crafts & Sewing

Automotive

Automotive Parts & Accessories

Baby

Baby

Beauty

Beauty & Personal Care

Books

Books

Computers

Computers

Electronics

Electronics

EverythingElse

Everything Else

Fashion

Clothing, Shoes & Jewelry

GardenAndOutdoor

Home & Garden

GroceryAndGourmetFood

Grocery & Gourmet Food

HealthPersonalCare

Health, Household & Baby Care

HomeAndKitchen

Home & Kitchen

Industrial

Industrial & Scientific

Lighting

Lighting

MusicalInstruments

Musical Instruments

OfficeProducts

Office Products

PetSupplies

Pet Supplies

Software

Software

SportsAndOutdoors

Sports

ToolsAndHomeImprovement

Tools & Home Improvement

ToysAndGames

Toys & Games

VideoGames

Video Games

## Locale Information for UK Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_united-kingdom.html`

# Locale Information for UK Marketplace

Locale Information for various parameters in UK Marketplace:

## Marketplace

The Marketplace value for UK marketplace is: `www.amazon.co.uk`

## Language of Preference

The default Language of preference in UK marketplace is: `en_GB`

### Valid Languages

Language

Description

`en_GB`

English - UNITED KINGDOM

## Currency of Preference

The default Currency of preference in UK marketplace is: `GBP`

### Valid Currencies

Currency

Description

`GBP`

`British Pound`

## Search Index

Search Index

Display Name

All

All Departments

AmazonVideo

Amazon Video

Apparel

Clothing

Appliances

Large Appliances

Automotive

Car & Motorbike

Baby

Baby

Beauty

Beauty

Books

Books

Classical

Classical Music

Computers

Computers & Accessories

DigitalMusic

Digital Music

Electronics

Electronics & Photo

EverythingElse

Everything Else

Fashion

Fashion

GardenAndOutdoor

Garden & Outdoors

GiftCards

Gift Cards

GroceryAndGourmetFood

Grocery

Handmade

Handmade

HealthPersonalCare

Health & Personal Care

HomeAndKitchen

Home & Kitchen

Industrial

Industrial & Scientific

Jewelry

Jewellery

KindleStore

Kindle Store

Lighting

Lighting

Luggage

Luggage

LuxuryBeauty

Luxury Beauty

MobileApps

Apps & Games

MoviesAndTV

DVD & Blu-ray

Music

CDs & Vinyl

MusicalInstruments

Musical Instruments & DJ

OfficeProducts

Stationery & Office Supplies

PetSupplies

Pet Supplies

Shoes

Shoes & Bags

Software

Software

SportsAndOutdoors

Sports & Outdoors

ToolsAndHomeImprovement

DIY & Tools

ToysAndGames

Toys & Games

VHS

VHS

VideoGames

PC & Video Games

Watches

Watches

## Locale Information for US Marketplace

Source: `_creatorsapi_docs_en-us_locale-reference_united-states.html`

# Locale Information for US Marketplace

Locale Information for various parameters in US Marketplace:

## Marketplace

The Marketplace value for US marketplace is: `www.amazon.com`

## Language of Preference

The default Language of preference in US marketplace is: `en_US`

### Valid Languages

Language

Description

`de_DE`

German - GERMANY

`en_US`

English - UNITED STATES

`es_US`

Spanish - UNITED STATES

`ko_KR`

Korean - KOREA

`pt_BR`

Portuguese - BRAZIL

`zh_CN`

Chinese - CHINA

`zh_TW`

Chinese - TAIWAN

## Currency of Preference

The default Currency of preference in US marketplace is: `USD`

### Valid Currencies

Currency

Description

`AED`

`United Arab Emirates Dirham`

`AMD`

`Armenian Dram`

`ARS`

`Argentine Peso`

`AUD`

`Australian Dollar`

`AWG`

`Aruban Florin`

`AZN`

`Azerbaijani Manat`

`BGN`

`Bulgarian Lev`

`BND`

`Bruneian Dollar`

`BOB`

`Bolivian Boliviano`

`BRL`

`Brazilian Real`

`BSD`

`Bahamian Dollar`

`BZD`

`Belize Dollar`

`CAD`

`Canadian Dollar`

`CLP`

`Chilean Peso`

`CNY`

`Chinese Yuan Renminbi`

`COP`

`Colombian Peso`

`CRC`

`Costa Rican Colon`

`DOP`

`Dominican Peso`

`EGP`

`Egyptian Pound`

`EUR`

`Euro`

`GBP`

`British Pound`

`GHS`

`Ghanaian Cedi`

`GTQ`

`Guatemalan Quetzal`

`HKD`

`Hong Kong Dollar`

`HNL`

`Honduran Lempira`

`HUF`

`Hungarian Forint`

`IDR`

`Indonesian Rupiah`

`ILS`

`Israeli Shekel`

`INR`

`Indian Rupee`

`JMD`

`Jamaican Dollar`

`JPY`

`Japanese Yen`

`KES`

`Kenyan Shilling`

`KHR`

`Cambodian Riel`

`KRW`

`South Korean Won`

`KYD`

`Caymanian Dollar`

`KZT`

`Kazakhstani Tenge`

`LBP`

`Lebanese Pound`

`MAD`

`Moroccan Dirham`

`MNT`

`Mongolian Tughrik`

`MOP`

`Macanese Pataca`

`MUR`

`Mauritian Rupee`

`MXN`

`Mexican Peso`

`MYR`

`Malaysian Ringgit`

`NAD`

`Namibian Dollar`

`NGN`

`Nigerian Naira`

`NOK`

`Norwegian Krone`

`NZD`

`New Zealand Dollar`

`PAB`

`Panamanian Balboa`

`PEN`

`Peruvian Sol`

`PHP`

`Philippine Peso`

`PYG`

`Paraguayan Guaraní`

`QAR`

`Qatari Riyal`

`RUB`

`Russian Ruble`

`SAR`

`Saudi Arabian Riyal`

`SGD`

`Singapore Dollar`

`THB`

`Thai Baht`

`TRY`

`Turkish Lira`

`TTD`

`Trinidadian Dollar`

`TWD`

`Taiwan New Dollar`

`TZS`

`Tanzanian Shilling`

`USD`

`United States Dollar`

`UYU`

`Uruguayan Peso`

`VND`

`Vietnamese Dong`

`XCD`

`Eastern Caribbean Dollar`

`ZAR`

`South African Rand`

## Search Index

Search Index

Display Name

All

All Departments

AmazonVideo

Prime Video

Apparel

Clothing & Accessories

Appliances

Appliances

ArtsAndCrafts

Arts, Crafts & Sewing

Automotive

Automotive Parts & Accessories

Baby

Baby

Beauty

Beauty & Personal Care

Books

Books

Classical

Classical

Collectibles

Collectibles & Fine Art

Computers

Computers

DigitalMusic

Digital Music

DigitalEducationalResources

Digital Educational Resources

Electronics

Electronics

EverythingElse

Everything Else

Fashion

Clothing, Shoes & Jewelry

FashionBaby

Clothing, Shoes & Jewelry Baby

FashionBoys

Clothing, Shoes & Jewelry Boys

FashionGirls

Clothing, Shoes & Jewelry Girls

FashionMen

Clothing, Shoes & Jewelry Men

FashionWomen

Clothing, Shoes & Jewelry Women

GardenAndOutdoor

Garden & Outdoor

GiftCards

Gift Cards

GroceryAndGourmetFood

Grocery & Gourmet Food

Handmade

Handmade

HealthPersonalCare

Health, Household & Baby Care

HomeAndKitchen

Home & Kitchen

Industrial

Industrial & Scientific

Jewelry

Jewelry

KindleStore

Kindle Store

LocalServices

Home & Business Services

Luggage

Luggage & Travel Gear

LuxuryBeauty

Luxury Beauty

Magazines

Magazine Subscriptions

MobileAndAccessories

Cell Phones & Accessories

MobileApps

Apps & Games

MoviesAndTV

Movies & TV

Music

CDs & Vinyl

MusicalInstruments

Musical Instruments

OfficeProducts

Office Products

PetSupplies

Pet Supplies

Photo

Camera & Photo

Shoes

Shoes

Software

Software

SportsAndOutdoors

Sports & Outdoors

ToolsAndHomeImprovement

Tools & Home Improvement

ToysAndGames

Toys & Games

VHS

VHS

VideoGames

Video Games

Watches

Watches

## Locale Reference for Product Advertising API

Source: `_creatorsapi_docs_en-us_locale-reference.html`

# Locale Reference for Product Advertising API

Product Advertising API operations are the same for all locales but valid certain parameters vary by locale. For example, `SearchIndex` values used in `SearchItems` API varies by locale.

The Product Advertising API is available in the following locales:

Locale

URL

Australia

[https://www.amazon.com.au](https://www.amazon.com.au/)

Belgium

[https://www.amazon.com.be](https://www.amazon.com.be/)

Brazil

[https://www.amazon.com.br](https://www.amazon.com.br/)

Canada

[https://www.amazon.ca](https://www.amazon.ca/)

Egypt

[https://www.amazon.eg](https://www.amazon.eg/)

France

[https://www.amazon.fr](https://www.amazon.fr/)

Germany

[https://www.amazon.de](https://www.amazon.de/)

India

[https://www.amazon.in](https://www.amazon.in)

Ireland

[https://www.amazon.ie](https://www.amazon.ie/)

Italy

[https://www.amazon.it](https://www.amazon.it/)

Japan

[https://www.amazon.co.jp](https://www.amazon.co.jp)

Mexico

[https://www.amazon.com.mx](https://www.amazon.com.mx/)

Netherlands

[https://www.amazon.nl](https://www.amazon.nl/)

Poland

[https://www.amazon.pl](https://www.amazon.pl/)

Singapore

[https://www.amazon.sg](https://www.amazon.sg/)

Saudi Arabia

[https://www.amazon.sa](https://www.amazon.sa/)

Spain

[https://www.amazon.es](https://www.amazon.es/)

Sweden

[https://www.amazon.se](https://www.amazon.se/)

Turkey

[https://www.amazon.com.tr](https://www.amazon.com.tr/)

United Arab Emirates

[https://www.amazon.ae](https://www.amazon.ae/)

United Kingdom

[https://www.amazon.co.uk](https://www.amazon.co.uk/)

United States

[https://www.amazon.com](https://www.amazon.com/)

Each of these locales is serviced by an Amazon web site that uses the local language, local customs, and local formatting. For example, when you look at the DE homepage for Amazon, you see the listings in German. If you purchased an item, you would find the price in Euros, and, if you were to purchase a movie, you would find that the movie rating would conform to the movie rating system used in Germany. Product Advertising API responses contain the same localized information.

Following topics cover locale specific reference for the following parameters:

-   **Marketplace**: Target Amazon Locale. The endpoint supplied to the marketplace parameter determines which locale the API request is targeted to.
-   **Language of Preference**: Most of Product Advertising API response elements are language aware. Every locale has a default language which the API falls back to if the supplied language of preference is invalid or if no language of preference is provided.
-   **Valid Languages**: Allowed Languages in a marketplace. Every marketplace supports only certain languages and information can be returned in only those languages for the marketplace.
-   **Currency of Preference**: Some of Product Advertising API response elements are currency aware such as Item price. API uses the default currency of the locale if currency of preference is not provided. Else when currency of preference is provided, it's value should be a valid currency of the locale, and API falls back to the default currency if conversion is unsuccessful.
-   **Valid Currencies**: Allowed Currencies in a marketplace. Every marketplace supports only certain currencies and information can be returned in only those currencies for the marketplace.
-   **Search Index**: The SearchItems operation requires SearchIndex which indicates the product category to search. SearchIndexes differ by marketplace and each marketplace has it's own list of valid SearchIndices.

## Topics

-   [Locale Reference for Australia](./_creatorsapi_docs_en-us_locale-reference_australia.md)
-   [Locale Reference for Belgium](./_creatorsapi_docs_en-us_locale-reference_belgium.md)
-   [Locale Reference for Brazil](./_creatorsapi_docs_en-us_locale-reference_brazil.md)
-   [Locale Reference for Canada](./_creatorsapi_docs_en-us_locale-reference_canada.md)
-   [Locale Reference for Egypt](./_creatorsapi_docs_en-us_locale-reference_egypt.md)
-   [Locale Reference for France](./_creatorsapi_docs_en-us_locale-reference_france.md)
-   [Locale Reference for Germany](./_creatorsapi_docs_en-us_locale-reference_germany.md)
-   [Locale Reference for India](./_creatorsapi_docs_en-us_locale-reference_india.md)
-   [Locale Reference for Ireland](./_creatorsapi_docs_en-us_locale-reference_ireland.md)
-   [Locale Reference for Italy](./_creatorsapi_docs_en-us_locale-reference_italy.md)
-   [Locale Reference for Japan](./_creatorsapi_docs_en-us_locale-reference_japan.md)
-   [Locale Reference for Mexico](./_creatorsapi_docs_en-us_locale-reference_mexico.md)
-   [Locale Reference for Netherlands](./_creatorsapi_docs_en-us_locale-reference_netherlands.md)
-   [Locale Reference for Poland](./_creatorsapi_docs_en-us_locale-reference_poland.md)
-   [Locale Reference for Singapore](./_creatorsapi_docs_en-us_locale-reference_singapore.md)
-   [Locale Reference for Saudi Arabia](./_creatorsapi_docs_en-us_locale-reference_saudi-arabia.md)
-   [Locale Reference for Spain](./_creatorsapi_docs_en-us_locale-reference_spain.md)
-   [Locale Reference for Sweden](./_creatorsapi_docs_en-us_locale-reference_sweden.md)
-   [Locale Reference for Turkey](./_creatorsapi_docs_en-us_locale-reference_turkey.md)
-   [Locale Reference for United Arab Emirates](./_creatorsapi_docs_en-us_locale-reference_united-arab-emirates.md)
-   [Locale Reference for United Kingdom](./_creatorsapi_docs_en-us_locale-reference_united-kingdom.md)
-   [Locale Reference for United States](./_creatorsapi_docs_en-us_locale-reference_united-states.md)

## Migrating to Creators API from Product Advertising API

Source: `_creatorsapi_docs_en-us_migrating-to-creatorsapi-from-paapi.html`

# Migrating to Creators API from Product Advertising API

If you are an existing Product Advertising API (PA-API 5.0) customer, you need to migrate to the new Creators API. The Creators API provides the same functionality as PA-API 5.0 with enhanced authentication using OAuth 2.0 and improved credential management.

## Key Differences

The main differences between Product Advertising API and Creators API are:

**Aspect**

**Product Advertising API 5.0**

**Creators API**

**Authentication**

AWS Signature Version 4 (Access Key + Secret Key)

OAuth 2.0 (Credential ID + Credential Secret)

**Endpoints**

`webservices.amazon.com/paapi5/...`

`creatorsapi.amazon/catalog/v1/...`

**Token Management**

AWS signature required for each request

Bearer token (valid for 1 hour, cacheable)

**Request/Response Parameters**

PascalCase (e.g., `ItemIds`, `PartnerTag`)

lowerCamelCase (e.g., `itemIds`, `partnerTag`)

**Offers Support**

Available (Offers.Listings, Offers.Summaries)

Not Available. use [OffersV2](./_creatorsapi_docs_en-us_api-reference_resources_offersV2.md#offersv1-to-offersv2-field-mapping.md)

The primary difference is the shift from AWS Signature Version 4 authentication to OAuth 2.0, which simplifies the authentication process and enables token caching. All request and response parameters have been converted from PascalCase to lowerCamelCase.

> Your existing Product Advertising API credentials (AWS Access Key and Secret Key) will not work with the Creators API. You must register for Creators API and generate new credentials.

## Migration Steps

### Step 1: Register for Creators API

Complete the registration process to obtain your new credentials:

1.  Navigate to [Associates Central](http://affiliate-program.amazon.com/creatorsapi) or look for "CreatorsAPI" tab under the Tools hamburger menu
2.  Click **Create Application** - Enter a name for your application
3.  Click **Create Credential** - Copy and securely store the following values:
    -   **Credential ID** (replaces AWS Access Key)
    -   **Credential Secret** (replaces AWS Secret Key)
    -   **Version** (credential version based on your region: 2.1 for NA, 2.2 for EU, 2.3 for FE)

For complete registration instructions, see [Register for Creators API](./_creatorsapi_docs_en-us_onboarding_register-for-creators-api.md).

> Store your Credential Secret securely. It will only be displayed once during creation. If lost, you'll need to generate a new credential.

### Step 2: Choose Your Migration Path

You have two options to migrate your existing Product Advertising API applications:

#### Option A: Use the New SDKs (Recommended)

The Creators API provides SDKs for Node.js, Python, PHP, and Java that automatically handle OAuth 2.0 authentication and token management.

**Benefits:**

-   Automatic token caching and renewal
-   Simplified authentication flow
-   Built-in error handling
-   Same familiar SDK structure as PA-API 5.0

To get started with SDKs:

1.  Download the SDK for your language from [Using SDK](./_creatorsapi_docs_en-us_get-started.md)
2.  Replace your AWS credentials with the new Credential ID, Credential Secret, and Version
3.  Update API operation names if needed (endpoints remain similar)

**Example Migration (Python):**

**Before (PA-API 5.0):**

Copy

```
from paapi5_python_sdk.api.default_api import DefaultApi
from paapi5_python_sdk.models.search_items_request import SearchItemsRequest

access_key = "YOUR_ACCESS_KEY"
secret_key = "YOUR_SECRET_KEY"
partner_tag = "yourtag-20"

api_instance = DefaultApi(
    access_key=access_key,
    secret_key=secret_key,
    host="webservices.amazon.com",
    region="us-east-1"
)
```

**After (Creators API):**

Copy

```
from creators_api.api.default_api import DefaultApi
from creators_api.models.search_items_request import SearchItemsRequest

credential_id = "YOUR_CREDENTIAL_ID"
credential_secret = "YOUR_CREDENTIAL_SECRET"
version = "2.3"  # Based on your region
partner_tag = "yourtag-20"

api_instance = DefaultApi(
    credential_id=credential_id,
    credential_secret=credential_secret,
    version=version,
    marketplace="www.amazon.com"
)
```

For detailed SDK setup, see [Using SDK](./_creatorsapi_docs_en-us_get-started.md).

#### Option B: Update Your Direct API Calls

If you're making direct HTTP requests (using cURL, axios, requests, etc.) instead of using SDKs, you'll need to:

1.  **Update Authentication Flow:**
    
    -   Remove AWS Signature Version 4 signing logic
    -   Implement OAuth 2.0 token retrieval
    -   Add token caching and renewal logic
2.  **Update API Endpoints:**
    
    -   Change from `https://webservices.amazon.com/paapi5/*` to `https://creatorsapi.amazon/catalog/v1/*`
3.  **Update Request Headers:**
    
    -   Replace AWS signature headers with OAuth 2.0 Bearer token
    -   Add credential version to Authorization header
    -   Add marketplace header (x-marketplace)

**Example Migration (cURL):**

**Before (PA-API 5.0):**

Copy

```
curl -X POST https://webservices.amazon.com/paapi5/searchitems \
  -H "Content-Type: application/json" \
  -H "X-Amz-Date: 20231215T120000Z" \
  -H "Authorization: AWS4-HMAC-SHA256 Credential=..." \
  -d '{
    "Keywords": "headphones",
    "PartnerTag": "yourtag-20",
    "PartnerType": "Associates",
    "Marketplace": "www.amazon.com",
    "Resources": ["Images.Primary.Small", "ItemInfo.Title"]
  }'
```

**After (Creators API):**

First, obtain an access token:

Copy

```
curl -X POST https://creatorsapi.auth.us-west-2.amazoncognito.com/oauth2/token \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -H "Authorization: Basic $(echo -n 'YOUR_CREDENTIAL_ID:YOUR_CREDENTIAL_SECRET' | base64)" \
  -d "grant_type=client_credentials&scope=creatorsapi/default"
```

Then make API calls with the token:

Copy

```
curl -X POST https://creatorsapi.amazon/catalog/v1/searchItems \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN, Version YOUR_CREDENTIAL_VERSION" \
  -H "Content-Type: application/json" \
  -H "x-marketplace: www.amazon.com" \
  -d '{
    "keywords": "headphones",
    "partnerTag": "yourtag-20",
    "marketplace": "www.amazon.com",
    "resources": ["images.primary.small", "itemInfo.title"]
  }'
```

For complete cURL examples and authentication details, see [Using cURL](./_creatorsapi_docs_en-us_get-started_using-curl.md).

### Step 3: Update Request Parameters

While most request parameters remain similar, note the following changes:

**PA-API 5.0 Parameter**

**Creators API Parameter**

**Notes**

`Keywords`

`keywords`

Changed to camelCase

`ItemIds`

`itemIds`

Changed to camelCase

`PartnerTag`

`partnerTag`

Changed to camelCase

`Resources`

`resources`

Resource names use dot notation (same as PA-API 5.0)

`Marketplace`

`marketplace`

Changed to camelCase, also required in x-marketplace header

### Step 4: Test Your Migration

1.  Start with a simple GetItems or SearchItems request
2.  Verify authentication and token management works correctly
3.  Test all API operations your application uses
4.  Implement proper error handling for new error codes
5.  Monitor API rate limits and adjust throttling if needed

> Access tokens are valid for 3600 seconds (1 hour). Implement token caching and renewal logic to avoid unnecessary authentication requests. SDKs handle this automatically. For regional endpoint details including authentication token endpoints by version, see the [Regional Endpoints section in Using cURL](./_creatorsapi_docs_en-us_get-started_using-curl#regional-endpoints.md).

## Common Migration Issues

**Issue**

**Problem**

**Solution**

**Invalid Credentials**

Using AWS Access Key/Secret Key instead of Credential ID/Secret

Generate new credentials from Associates Central CreatorsAPI dashboard

**Token Expired**

Access token expired after 1 hour

Implement token caching and renewal. Check token expiry before each request and refresh if needed

**Wrong Endpoint**

Still using `webservices.amazon.com/paapi5/*` endpoints

Update to `creatorsapi.amazon/catalog/v1/*` endpoints

**Missing Marketplace Header**

Request fails with missing marketplace information

Add `x-marketplace` header (e.g., `x-marketplace: www.amazon.com`)

**Incorrect Authorization Header**

Authorization header doesn't include credential version

Use format: `Authorization: Bearer <token>, Version <version>`

> If you encounter errors during migration, check the [Error Codes and Messages](./_creatorsapi_docs_en-us_troubleshooting_error-codes-and-messages.md) documentation for detailed troubleshooting steps.

## Additional Resources

-   [Common Request Headers and Parameters](./_creatorsapi_docs_en-us_concepts_common-request-headers-and-parameters.md) - Locale-specific configuration
-   [GetItems Operation](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) - Retrieve product details
-   [SearchItems Operation](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) - Search for products
-   [Error Codes and Messages](./_creatorsapi_docs_en-us_troubleshooting_error-codes-and-messages.md) - Troubleshooting errors
-   [API Rates](./_creatorsapi_docs_en-us_concepts_api-rates.md) - Understanding rate limits

> For most developers, using the SDKs is the fastest migration path. The SDKs handle authentication, token management, and request formatting automatically, allowing you to focus on your application logic.

## Server Busy

Source: `_creatorsapi_docs_en-us_offersV2.html`

Click the button below to continue shopping

 

Continue shopping

© 1996-2025, Amazon.com, Inc. or its affiliates ![](https://fls-na.amazon.com/1/oc-csi/1/OP/requestId=GW0K5T2FDZQ0T1ZRB1R5&js=1)

## Register for Creators API

Source: `_creatorsapi_docs_en-us_onboarding_register-for-creators-api.html`

# Register for Creators API

> Before you register for the Creators API, you must have an Amazon Associates account that has been reviewed and received final acceptance into the Amazon Associates Program.

1.  If you do not have an Amazon Associates account, you must sign up for Amazon Associates. For more information, see [Sign up as an Amazon Associate](./_creatorsapi_docs_en-us_onboarding_sign-up-as-an-amazon-associate.md).
    
2.  You can request for final acceptance by completing the Associates Contact Us form and providing details about why you require access to the Creators API. For more information, see [Contact Us](./_creatorsapi_docs_en-us_contact-us.md).
    

> Creators API sign up is available only to associates who have referred qualified sales and have been accepted into the program.

This guide helps you get started with the Creators API. You can advertise products from the Amazon marketplace in which you have signed up as a fully accepted Amazon Associate.

## **To sign up for the Creators API**

1.  After you sign-in to your Amazon Associates account, in the Amazon Associates page, choose **Tools** and then choose **Creators API**.
    
    ![](./assets/images/creatorsapi-login1.png)
    
    > Only the primary account owner of the Amazon Associates account can sign up for the Creators API.
    
2.  Choose **Create Application**.
    
    ![](./assets/images/creatorsapi-login2.png)
    
3.  Enter **Application name**. ![](./assets/images/creatorsapi-login3.png)
    
4.  You can add new credentials. In the box, copy your **Credential ID**, **Secret**, and **Version** or download them to CSV. You specify these credentials when you make requests to the Creators API. ![](./assets/images/creatorsapi-login4.png)
    

## Frequently Asked Questions

#### How do I begin onboarding to Creators API?

We suggest navigating to our documentation to familiarize yourself with our new API and downloading the appropriate SDKs to get started with integration.

#### How do I create applications and credentials?

In the Applications section above, create a new application by selecting the "Create App" button, add a name for your new application, and click "Add New Credential" to generate credentials. Make sure to copy and save the credential keys to a safe place.

#### How many applications can I create?

Currently, you can create a maximum of two applications per store.

#### How many credentials can I generate?

Each application can have up to two sets of credentials.

#### Can I delete applications and credentials?

Yes, you can delete an application after deleting all its associated credentials.

## Sign up as an Amazon Associate

Source: `_creatorsapi_docs_en-us_onboarding_sign-up-as-an-amazon-associate.html`

# Sign up as an Amazon Associate

Associates earn commissions by using their own websites to refer sales to Amazon.com. To get a commission, an Associate must have an Associate tag. The Associate tag is an automatically generated unique identifier that you will need to make requests through the Creators API.

When you register for the Creators API, note the following:

-   You must register for Amazon Associates before you sign up as a Creators API developer. The Creators API returns an error if you are not a registered or a valid Amazon Associate.
    
-   You can only use the Creators API for the marketplace that you registered for as an Amazon Associate. For example, if you are an Amazon Associate in the US marketplace, you can't access the Creators API in the UK marketplace if you are not an Amazon Associate in the UK.
    

## **To sign up as an Amazon Associate**

1.  Using the following [Locale reference table](./_creatorsapi_docs_en-us_onboarding_sign-up-as-an-amazon-associate#locale-reference.md), choose the Amazon Associates URL for the locale that you want.
2.  Follow the instructions to create an Amazon Associates account. One of the requirements for becoming an Associate is that you provide the URL of your site. If your site is not yet public but you want to test against the API, you must still provide a URL during registration.
3.  After the sign up process, an Associate tag is sent to you in email. When you sign in to Amazon Associates for your locale, the home page shows your email and Amazon Associate tag.
4.  The following example is an Amazon Associate tag for the US marketplace (`www.amazon.com`).

![](/assets/images/paapi-shared-AA-20.png)

> Your Amazon Associates tag works only in the locale in which you register. If you want to be an Amazon Associate in more than one locale, you must register separately for each locale.

## Locale Reference

Locale

URL

Australia

[https://affiliate-program.amazon.com.au](https://affiliate-program.amazon.com.au)

Belgium

[https://affiliate-program.amazon.com.be](https://affiliate-program.amazon.com.be)

Brazil

[https://associados.amazon.com.br](https://associados.amazon.com.br)

Canada

[https://associates.amazon.ca](https://associates.amazon.ca)

Egypt

[https://affiliate-program.amazon.eg/](https://affiliate-program.amazon.eg)

France

[https://partenaires.amazon.fr](https://partenaires.amazon.fr)

Germany

[https://partnernet.amazon.de](https://partnernet.amazon.de)

India

[https://affiliate-program.amazon.in](https://affiliate-program.amazon.in)

Ireland

[https://affiliate-program.amazon.ie](https://affiliate-program.amazon.ie)

Italy

[https://programma-affiliazione.amazon.it](https://programma-affiliazione.amazon.it)

Japan

[http://affiliate.amazon.co.jp](http://affiliate.amazon.co.jp)

Mexico

[https://afiliados.amazon.com.mx](https://afiliados.amazon.com.mx)

Netherlands

[https://partnernet.amazon.nl/](https://partnernet.amazon.nl)

Poland

[https://affiliate-program.amazon.pl](https://affiliate-program.amazon.pl)

Singapore

[https://affiliate-program.amazon.sg/](https://affiliate-program.amazon.sg/)

Saudi Arabia

[https://affiliate-program.amazon.sa/](https://affiliate-program.amazon.sa/)

Spain

[https://afiliados.amazon.es](https://afiliados.amazon.es)

Sweden

[https://affiliate-program.amazon.se](https://affiliate-program.amazon.se)

Turkey

[https://gelirortakligi.amazon.com.tr](https://gelirortakligi.amazon.com.tr)

United Arab Emirates

[https://affiliate-program.amazon.ae](https://affiliate-program.amazon.ae)

United Kingdom

[https://affiliate-program.amazon.co.uk](https://affiliate-program.amazon.co.uk)

United States

[https://affiliate-program.amazon.com](https://affiliate-program.amazon.com)

## Sign up as an Amazon Associate

Source: `_creatorsapi_docs_en-us_onboarding_sign-up-as-an-amazon-associate#locale-reference.html`

# Sign up as an Amazon Associate

Associates earn commissions by using their own websites to refer sales to Amazon.com. To get a commission, an Associate must have an Associate tag. The Associate tag is an automatically generated unique identifier that you will need to make requests through the Creators API.

When you register for the Creators API, note the following:

-   You must register for Amazon Associates before you sign up as a Creators API developer. The Creators API returns an error if you are not a registered or a valid Amazon Associate.
    
-   You can only use the Creators API for the marketplace that you registered for as an Amazon Associate. For example, if you are an Amazon Associate in the US marketplace, you can't access the Creators API in the UK marketplace if you are not an Amazon Associate in the UK.
    

## **To sign up as an Amazon Associate**

1.  Using the following [Locale reference table](./_creatorsapi_docs_en-us_onboarding_sign-up-as-an-amazon-associate#locale-reference.md), choose the Amazon Associates URL for the locale that you want.
2.  Follow the instructions to create an Amazon Associates account. One of the requirements for becoming an Associate is that you provide the URL of your site. If your site is not yet public but you want to test against the API, you must still provide a URL during registration.
3.  After the sign up process, an Associate tag is sent to you in email. When you sign in to Amazon Associates for your locale, the home page shows your email and Amazon Associate tag.
4.  The following example is an Amazon Associate tag for the US marketplace (`www.amazon.com`).

![](/assets/images/paapi-shared-AA-20.png)

> Your Amazon Associates tag works only in the locale in which you register. If you want to be an Amazon Associate in more than one locale, you must register separately for each locale.

## Locale Reference

Locale

URL

Australia

[https://affiliate-program.amazon.com.au](https://affiliate-program.amazon.com.au)

Belgium

[https://affiliate-program.amazon.com.be](https://affiliate-program.amazon.com.be)

Brazil

[https://associados.amazon.com.br](https://associados.amazon.com.br)

Canada

[https://associates.amazon.ca](https://associates.amazon.ca)

Egypt

[https://affiliate-program.amazon.eg/](https://affiliate-program.amazon.eg)

France

[https://partenaires.amazon.fr](https://partenaires.amazon.fr)

Germany

[https://partnernet.amazon.de](https://partnernet.amazon.de)

India

[https://affiliate-program.amazon.in](https://affiliate-program.amazon.in)

Ireland

[https://affiliate-program.amazon.ie](https://affiliate-program.amazon.ie)

Italy

[https://programma-affiliazione.amazon.it](https://programma-affiliazione.amazon.it)

Japan

[http://affiliate.amazon.co.jp](http://affiliate.amazon.co.jp)

Mexico

[https://afiliados.amazon.com.mx](https://afiliados.amazon.com.mx)

Netherlands

[https://partnernet.amazon.nl/](https://partnernet.amazon.nl)

Poland

[https://affiliate-program.amazon.pl](https://affiliate-program.amazon.pl)

Singapore

[https://affiliate-program.amazon.sg/](https://affiliate-program.amazon.sg/)

Saudi Arabia

[https://affiliate-program.amazon.sa/](https://affiliate-program.amazon.sa/)

Spain

[https://afiliados.amazon.es](https://afiliados.amazon.es)

Sweden

[https://affiliate-program.amazon.se](https://affiliate-program.amazon.se)

Turkey

[https://gelirortakligi.amazon.com.tr](https://gelirortakligi.amazon.com.tr)

United Arab Emirates

[https://affiliate-program.amazon.ae](https://affiliate-program.amazon.ae)

United Kingdom

[https://affiliate-program.amazon.co.uk](https://affiliate-program.amazon.co.uk)

United States

[https://affiliate-program.amazon.com](https://affiliate-program.amazon.com)

## Page Not Found

Source: `_creatorsapi_docs_en-us_operations.html`

# Page Not Found

The page you are looking for does not exist.

## Server Busy

Source: `_creatorsapi_docs_en-us_parent-asin.html`

Click the button below to continue shopping

 

Continue shopping

© 1996-2025, Amazon.com, Inc. or its affiliates ![](https://fls-na.amazon.com/1/oc-csi/1/OP/requestId=2QMZSGGJGW32JTFBK2X0&js=1)

## Server Busy

Source: `_creatorsapi_docs_en-us_search-refinements.html`

Click the button below to continue shopping

 

Continue shopping

© 1996-2025, Amazon.com, Inc. or its affiliates ![](https://fls-na.amazon.com/1/oc-csi/1/OP/requestId=XPQ8HBD8D7P45SXQXQ2V&js=1)

## Error Codes and Messages

Source: `_creatorsapi_docs_en-us_troubleshooting_error-codes-and-messages.html`

# Error Codes and Messages

Creators API returns structured error responses that provide information about request validation failures, authentication issues, and server-side errors. All error messages are returned in English for all marketplaces.

## Error Response Structure

All errors follow a consistent JSON structure with these elements:

-   **Type:** The exception type identifier for clients to programmatically identify the exception (e.g., `ValidationException`).
    
-   **Message:** A human-readable description of the error to help you debug the issue.
    
-   **Reason (for ValidationException, AccessDeniedException, and UnauthorizedException):** A machine-readable code that categorizes the specific type of validation, access, or authentication error.
    
-   **Additional fields (context-dependent):** Some errors include additional fields like `resourceId`, `resourceType`, `fieldList`, or `retryAfterSeconds`.
    

### Example Error Response

Copy

```
{
  "type": "ValidationException",
  "message": "Partner tag in the request is invalid or is not mapped to the store associated with your credential.",
  "reason": "InvalidPartnerTag"
}
```

## Exception Types

Exception

HTTP Status Code

Description

UnauthorizedException

401 Unauthorized

Exception indicating missing or bad authentication for the operation.

ValidationException

400 Bad Request

The input fails to satisfy the constraints specified by the service. Use ValidationExceptionReason and fieldList to identify specific issues.

AccessDeniedException

403 Forbidden

User does not have sufficient access to perform this action.

ResourceNotFoundException

404 Not Found

Request references a resource which does not exist.

ThrottleException

429 Too Many Requests

Request was denied due to request throttling. Clients should implement exponential backoff and retry.

InternalServerException

500 Internal Server Error

Unexpected error during processing of request. Clients should retry with exponential backoff.

> It is also possible to submit a valid request and still have errors. In such cases, the HTTP Status Code is `200 Success`, however, the response might contain errors. For more information, refer [Processing of Errors](./_creatorsapi_docs_en-us_troubleshooting_processing-of-errors.md).

## HTTP Status Code Ranges

#### 4xx Client Errors

These errors indicate issues with the request sent to Creators API:

-   **400 Bad Request** - ValidationException (invalid input, missing fields, parsing errors)
-   **401 Unauthorized** - UnauthorizedException (missing or invalid authentication)
-   **403 Forbidden** - AccessDeniedException (insufficient permissions or ineligible account)
-   **404 Not Found** - ResourceNotFoundException (requested resource doesn't exist)
-   **429 Too Many Requests** - ThrottleException (rate limiting)

#### 5xx Server Errors

These errors indicate issues on the Creators API server side:

-   **500 Internal Server Error** - InternalServerException (unexpected server-side error)

## Error Reason Codes

The following sections provide detailed descriptions and example messages for each reason code.

### ValidationException Reasons

Reason Code

Description

Example Message

**UnknownOperation**

The operation requested is not recognized or does not exist

"The operation requested is invalid. Please verify that the operation name is typed correctly."

**CannotParse**

The request payload cannot be parsed as valid JSON

"Unable to parse the request payload. Please verify that the request body is valid JSON."

**FieldValidationFailed**

One or more request fields failed validation

"Request validation failed." (includes `fieldList` array with field names)

**InvalidAssociate**

The credential is not linked to the partner tag for the given marketplace

"Your credential is not linked to the partner tag in the request for the given Marketplace."

**InvalidPartnerTag**

The partner tag is invalid or not mapped to the store

"Partner tag in the request is invalid or is not mapped to the store associated with your credential."

**Other**

Other validation error not covered by specific reason codes

Varies based on the specific validation error encountered

### AccessDeniedException Reasons

Reason Code

Description

Example Message

**AssociateNotEligible**

The associate account does not meet the eligibility requirements to access the Creators API. The current eligibility criteria is that the account must have made 10 qualified sales in the trailing 30 days.

"Your account does not currently meet the eligibility requirements."

**AuthorizationFailed**

Authorization check failed for the requested operation

"Authorization check failed for the requested operation."

**Other**

Access denied for a reason not covered by specific codes

Varies based on the specific access denial reason

### UnauthorizedException Reasons

Reason Code

Description

Example Message

**TokenExpired**

The authentication token has expired. Fetch a new access token using your credentials.

"Authentication token has expired."

**InvalidToken**

The authentication token is invalid or malformed. Verify your token format and regenerate if necessary.

"The authentication token is invalid or malformed."

**InvalidIssuer**

The token issuer does not match the expected issuer. Ensure the credential version in your request header matches the region where the token was generated.

"The token issuer is invalid or does not match the expected issuer."

**MissingClaim**

The authentication token is missing required claims. Regenerate your token with proper scopes and claims.

"The authentication token is missing required claims."

**MissingKeyId**

The authentication token is missing the required key identifier in the JWT header. Ensure your token generation includes the kid field.

"The authentication token is missing the required key identifier."

**UnsupportedClient**

The client identifier is not supported. Verify your client credentials are registered for Creators API.

"The client identifier is not supported."

**InvalidClient**

The client identifier does not match the expected value. Verify you are using the correct client ID for your application.

"The client identifier does not match the expected value."

**MissingCredential**

Required authentication credentials are missing from the request. Include the Authorization header with a valid Bearer token and credential version header.

"Missing authentication credentials."

**Other**

Authentication check failed for a reason not covered by specific codes

Varies based on the specific authentication failure

### ThrottleException Details

When receiving a `ThrottleException`, the error response may include a `retryAfterSeconds` field indicating how long to wait before retrying:

Copy

```
{
  "type": "ThrottleException",
  "message": "The request was denied due to request throttling. Please verify the number of requests made per second.",
  "retryAfterSeconds": 60
}
```

### ResourceNotFoundException Details

When receiving a `ResourceNotFoundException`, the error response includes `resourceType` and `resourceId` fields:

-   **resourceType**: The type of resource that was not found
-   **resourceId**: The identifier of the resource that was not found

## Sample Error Scenarios

### Invalid PartnerTag

Copy

```
HTTP/1.1 400 Bad Request
{
  "type": "ValidationException",
  "message": "Partner tag in the request is invalid or is not mapped to the store associated with your credential.",
  "reason": "InvalidPartnerTag"
}
```

### Invalid Associate

Copy

```
HTTP/1.1 400 Bad Request
{
  "type": "ValidationException",
  "message": "Your credential is not linked to the partner tag in the request for the given Marketplace.",
  "reason": "InvalidAssociate"
}
```

### Missing or Invalid Field

Copy

```
HTTP/1.1 400 Bad Request
{
  "type": "ValidationException",
  "message": "Request validation failed.",
  "reason": "FieldValidationFailed",
  "fieldList": ["partnerTag"]
}
```

### Expired Token

Copy

```
HTTP/1.1 401 Unauthorized
{
  "type": "UnauthorizedException",
  "message": "Authentication token has expired.",
  "reason": "TokenExpired"
}
```

### Invalid Token

Copy

```
HTTP/1.1 401 Unauthorized
{
  "type": "UnauthorizedException",
  "message": "The authentication token is invalid or malformed.",
  "reason": "InvalidToken"
}
```

### Ineligible Associate

Copy

```
HTTP/1.1 403 Forbidden
{
  "type": "AccessDeniedException",
  "message": "Your account does not currently meet the eligibility requirements.",
  "reason": "AssociateNotEligible"
}
```

### Rate Limiting

This error occurs when you exceed the allowed number of requests per second. When you receive a 429 status code, you should implement exponential backoff and retry the request after waiting.

Copy

```
HTTP/1.1 429 Too Many Requests
{
  "type": "ThrottleException",
  "message": "The request was denied due to request throttling. Please verify the number of requests made per second."
}
```

### Item Not Accessible

Copy

```
HTTP/1.1 404 Not Found
{
  "type": "ResourceNotFoundException",
  "message": "No items found for the requested item IDs.",
  "resourceType": "Item",
  "resourceId": "B08N5WRWNW"
}
```

### InternalServerException

Copy

```
HTTP/1.1 500 Internal Server Error
{
  "type": "InternalServerException",
  "message": "An unexpected error occurred while processing your request."
}
```

* * *

## Best Practices

-   Check HTTP status codes and parse the `reason` field for specific error handling
-   Implement exponential backoff retry for 429 and 500 errors
-   Implement token refresh logic for TokenExpired errors

For more information, see [Processing of Errors](./_creatorsapi_docs_en-us_troubleshooting_processing-of-errors.md) and [Troubleshooting Applications](./_creatorsapi_docs_en-us_troubleshooting_troubleshooting-applications.md).

## Processing of Errors

Source: `_creatorsapi_docs_en-us_troubleshooting_processing-of-errors.html`

# Processing of Errors

### Is it possible to submit a valid request and still have an error?

Yes. If you were to submit a request and no items in Amazon satisfied the request, you would receive an error. The following request is an example of this problem.

-   Following is a [SearchItems](./_creatorsapi_docs_en-us_api-reference_operations_search-items.md) request trying to search for _Mystery Novels Non Existing_ on Amazon under `Automotive` category having condition as `New`.

Copy

```
{
 "keywords": "Mystery Novels Non Existing",
 "searchIndex": "Automotive",
 "condition": "New",
 "partnerTag": "xyz-20"
}
```

-   Since, looking for non-existing mystery novels under Automotive category doesn't return any results, we got No results for the request. The response we get from Creators API in this case look like this:

Copy

```
{
 "__type": "com.amazon.creators#ResourceNotFoundException",
 "message": "No results found for your search request",
 "resourceType": "SearchResult",
 "resourceId": "Mystery Novels Non Existing"
}
```

* * *

### Is it possible to not get a resource response even after requesting it?

Yes. [Resources](./_creatorsapi_docs_en-us_api-reference_resources.md) determine what information will be returned in the API response. It is possible that a requested resource is not available for a particular product. In this case, Creators API returns partial response where the unservable resource is absent from the response whereas other valid resources are served. For example, ContentRating resource from [ItemInfo](./_creatorsapi_docs_en-us_api-reference_resources_item-info.md) is usually applicable for digital products like Movies or VideoGames. Requesting for ContentRating for an Electronics product will not return ContentRating information.

-   Following is a [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) request for a Fire TV Stick which requests for `itemInfo.contentRating` and `itemInfo.title` resources.

Copy

```
{
 "itemIds": ["B00ZV9RDKK"],
 "itemIdType": "ASIN",
 "resources": ["itemInfo.contentRating", "itemInfo.title"],
 "partnerTag": "xyz-20",
 "marketplace": "www.amazon.com",
 "operation": "GetItems"
}
```

-   As there is no `ContentRating` information for the item, the response only contains `Title` information which is the other resource requested.

Copy

```
{
 "items": [
  {
   "asin": "B00ZV9RDKK",
   "detailPageURL": "https://www.amazon.com/dp/B00ZV9RDKK?tag=dsf&linkCode=ogi&th=1&psc=1",
   "itemInfo": {
    "title": {
     "displayValue": "Fire TV Stick with Alexa Voice Remote | Streaming Media Player",
     "label": "Title",
     "locale": "en_US"
    }
   }
  }
 ]
}
```

* * *

### Does Creators API return Partial Response?

Yes. For example, if you try to get item info for multiple ASINs where some are invalid, you'll get results for the valid ASINs along with detailed error information for the invalid ASINs in the `errors` array. For example:

-   Following is a [GetItems](./_creatorsapi_docs_en-us_api-reference_operations_get-items.md) request where some of the ASINs are invalid.

Copy

```
{
 "itemIds": ["B08N5WRWNW", "B0BL8WSCH3"],
 "partnerTag": "xyz-20",
 "marketplace": "www.amazon.com",
 "operation": "GetItems"
}
```

-   The response contains the valid ASIN in `itemsResult` and detailed error information for the invalid ASIN in the `errors` array:

Copy

```
{
 "errors": [
  {
   "code": "InvalidParameterValue",
   "message": "The ItemIds B08N5WRWNW provided in the request is invalid."
  }
 ],
 "itemsResult": {
  "items": [
   {
    "asin": "B0BL8WSCH3",
    "detailPageURL": "https://www.amazon.com/dp/B0BL8WSCH3?tag=xyz-20&linkCode=ogi&th=1&psc=1",
    "itemInfo": {
     "title": {
      "displayValue": "Amazon Fire 7 Kids tablet (newest model) ages 3-7",
      "label": "Title",
      "locale": "en_US"
     }
    }
   }
  ]
 }
}
```

### Understanding the `errors` Array

The `errors` array provides detailed information about partial failures:

-   **When it appears**: Only in HTTP 200 responses when some items succeed and others fail
-   **What it contains**: Each error has:
    -   `code`: A unique identifier for the error type (e.g., `InvalidParameterValue`, `ItemNotFound`)
    -   `message`: A human-readable description of what went wrong
-   **Behavior**:
    -   If **some** items are valid: Returns HTTP 200 with valid items + `errors` array for invalid items
    -   If **ALL** items are invalid: Returns HTTP 404 `ResourceNotFoundException` (no partial response)
    -   If **ALL** items are valid: Returns HTTP 200 with `itemsResult` only (no `errors` array)

This pattern applies to all catalog operations that accept multiple identifiers:

-   `GetItems` - Multiple item IDs
-   `SearchItems` - Search queries (may have refinement errors)
-   `GetVariations` - Variation requests
-   `GetBrowseNodes` - Multiple browse node IDs

### Error Handling Best Practices

When processing responses:

1.  **Always check the `errors` array** to identify which items failed and why
2.  **Process successful items** from the result object
3.  **Log or retry failed items** based on error codes
4.  **Don't assume all requested items are present** in the response

## Server Busy

Source: `_creatorsapi_docs_en-us_troubleshooting_troubleshooting-applications.html`

Click the button below to continue shopping

 

Continue shopping

© 1996-2025, Amazon.com, Inc. or its affiliates ![](https://fls-na.amazon.com/1/oc-csi/1/OP/requestId=WFWVKNS369N7HMG926WS&js=1)

## Server Busy

Source: `_creatorsapi_docs_en-us_troubleshooting.html`

Click the button below to continue shopping

 

Continue shopping

© 1996-2025, Amazon.com, Inc. or its affiliates ![](https://fls-na.amazon.com/1/oc-csi/1/OP/requestId=4ZRSDSA3V43B85C7HPZ5&js=1)

## Page Not Found

Source: `_creatorsapi_docs_en-us_use-cases_organization-of-items-on-amazon_variations.html`

# Page Not Found

The page you are looking for does not exist.
