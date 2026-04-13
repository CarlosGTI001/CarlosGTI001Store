# BrowseNodeInfo

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
