# GetBrowseNodes

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
