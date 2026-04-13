# SearchRefinements

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
