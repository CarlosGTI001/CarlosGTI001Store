# SearchItems

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
