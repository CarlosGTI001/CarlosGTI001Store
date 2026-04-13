# BrowseNodes

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
