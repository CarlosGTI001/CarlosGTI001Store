# Processing of Errors

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
